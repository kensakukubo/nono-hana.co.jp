#!/usr/bin/env python3
"""
コラム下書きの自動作成（AI生成 → WordPress REST API で draft 投稿）

運用: 生成は必ず「下書き」。公開は管理画面で人が行う。

必要な環境変数:
  OPENAI_API_KEY   OpenAI API キー
  WP_BASE_URL      例: https://example.com/grouphome または https://example.com（WPのルート）
  WP_USER          WordPress ユーザー名
  WP_APP_PASSWORD  アプリケーションパスワード（スペース区切りでもそのまま）

使い方（例）:
  export OPENAI_API_KEY=... WP_BASE_URL=... WP_USER=... WP_APP_PASSWORD=...
  python3 column_draft_from_ai.py \\
    --theme "入居者様の冬のくらし" \\
    --keyword "水分" --keyword "暖房" \\
    --reference-url "https://example.com/article/" \\
    "記事に書きたいメモや構成の希望"

  topic（最後の引数）は省略可。その場合は --theme / --keyword / --reference-url のいずれか必須。
"""

from __future__ import annotations

import argparse
import base64
import json
import os
import re
import ssl
import sys
import urllib.error
import urllib.request
from typing import Any


DEFAULT_UA = (
    "Mozilla/5.0 (compatible; grouphome-column-draft/1.0; +https://nono-hana.co.jp/) "
    "Python-urllib"
)


def _http_json(
    url: str,
    method: str = "GET",
    headers: dict[str, str] | None = None,
    body: bytes | None = None,
    timeout: int = 120,
) -> tuple[int, Any]:
    req = urllib.request.Request(url, data=body, method=method)
    for k, v in (headers or {}).items():
        req.add_header(k, v)
    ctx = ssl.create_default_context()
    with urllib.request.urlopen(req, timeout=timeout, context=ctx) as resp:
        raw = resp.read()
        code = resp.getcode()
    try:
        return code, json.loads(raw.decode("utf-8"))
    except json.JSONDecodeError:
        return code, raw.decode("utf-8", errors="replace")


def html_to_text(html: str) -> str:
    html = re.sub(r"(?is)<script[^>]*>.*?</script>", " ", html)
    html = re.sub(r"(?is)<style[^>]*>.*?</style>", " ", html)
    html = re.sub(r"(?is)<noscript[^>]*>.*?</noscript>", " ", html)
    html = re.sub(r"<br\s*/?>", "\n", html, flags=re.I)
    html = re.sub(r"</p\s*>", "\n", html, flags=re.I)
    html = re.sub(r"<[^>]+>", " ", html)
    html = re.sub(r"[ \t\r\f\v]+", " ", html)
    html = re.sub(r"\n\s*\n+", "\n", html)
    return html.strip()


def fetch_reference_text(url: str, max_chars: int) -> str:
    req = urllib.request.Request(
        url,
        headers={
            "User-Agent": DEFAULT_UA,
            "Accept": "text/html,application/xhtml+xml;q=0.9,*/*;q=0.8",
            "Accept-Language": "ja,en-US;q=0.7,en;q=0.3",
        },
        method="GET",
    )
    ctx = ssl.create_default_context()
    with urllib.request.urlopen(req, timeout=45, context=ctx) as resp:
        raw = resp.read()
    html = raw.decode("utf-8", errors="replace")
    text = html_to_text(html)
    if len(text) > max_chars:
        text = text[: max_chars - 1] + "…"
    return text


def build_user_prompt(
    topic: str,
    theme: str,
    keywords: list[str],
    reference_blocks: list[tuple[str, str]],
) -> str:
    lines: list[str] = []
    lines.append("以下の条件に従い、コラムの下書き用原稿を作成してください。")
    lines.append("")
    lines.append("## コラムの方向性（テーマ）")
    lines.append(theme.strip() if theme.strip() else "（未指定：全体のトーンはグループホーム・介護福祉向け）")
    lines.append("")
    lines.append("## 取り上げたい内容・メモ・構成の希望")
    lines.append(topic.strip() if topic.strip() else "（未指定）")
    lines.append("")
    lines.append("## キーワード（可能な範囲で自然に記事へ含める。無理に詰め込まない）")
    if keywords:
        for i, kw in enumerate(keywords, 1):
            lines.append(f"- {kw}")
    else:
        lines.append("（未指定）")
    lines.append("")
    lines.append("## 参考ページから抽出したテキスト（参考用。長文のコピーはせず、内容を理解したうえで独自の文章にすること）")
    if reference_blocks:
        for url, excerpt in reference_blocks:
            lines.append(f"### {url}")
            lines.append(excerpt if excerpt else "（取得失敗または空）")
            lines.append("")
    else:
        lines.append("（参考URLなし）")
    return "\n".join(lines).strip()


def openai_generate_article(user_prompt: str, model: str, api_key: str) -> dict[str, str]:
    system = (
        "あなたは日本のグループホーム・介護福祉に関するコラム執筆者です。"
        "出力は次のJSONだけ。他の文は書かない。JSONのキーは title, excerpt, content_html。"
        "title は40文字以内が目安。excerpt は160文字以内の紹介文。"
        "content_html は本文のみ。見出しは h2/h3、段落は p、箇条書きは ul/li。"
        "誇大・断定的な医療効果の表現は避け、事実と一般的な説明に留める。"
        "参考テキストがある場合は著作権に配慮し、言い換えと要約にとどめ、原文の転載はしないこと。"
    )
    payload = {
        "model": model,
        "messages": [
            {"role": "system", "content": system},
            {"role": "user", "content": user_prompt},
        ],
        "temperature": 0.7,
        "response_format": {"type": "json_object"},
    }
    body = json.dumps(payload).encode("utf-8")
    headers = {
        "Content-Type": "application/json",
        "Authorization": f"Bearer {api_key}",
    }
    code, data = _http_json(
        "https://api.openai.com/v1/chat/completions",
        method="POST",
        headers=headers,
        body=body,
        timeout=120,
    )
    if code != 200 or not isinstance(data, dict):
        raise RuntimeError(f"OpenAI API エラー: HTTP {code} {data!r}")
    try:
        text = data["choices"][0]["message"]["content"]
    except (KeyError, IndexError) as e:
        raise RuntimeError(f"OpenAI 応答形式が不正: {data!r}") from e
    if not isinstance(text, str):
        raise RuntimeError("OpenAI の content が文字列ではありません")
    text = text.strip()
    m = re.search(r"\{[\s\S]*\}", text)
    if m:
        text = m.group(0)
    obj = json.loads(text)
    for k in ("title", "excerpt", "content_html"):
        if k not in obj or not isinstance(obj[k], str):
            raise RuntimeError(f"JSON に {k} がありません: {obj!r}")
    return {
        "title": obj["title"].strip(),
        "excerpt": obj["excerpt"].strip(),
        "content_html": obj["content_html"].strip(),
    }


def wp_create_column_draft(
    base_url: str,
    user: str,
    app_password: str,
    title: str,
    excerpt: str,
    content_html: str,
) -> dict[str, Any]:
    base = base_url.rstrip("/")
    endpoint = f"{base}/wp-json/wp/v2/column"
    auth = base64.b64encode(f"{user}:{app_password}".encode("utf-8")).decode("ascii")
    payload = {
        "title": title,
        "excerpt": excerpt,
        "content": content_html,
        "status": "draft",
    }
    body = json.dumps(payload, ensure_ascii=False).encode("utf-8")
    headers = {
        "Content-Type": "application/json; charset=utf-8",
        "Authorization": f"Basic {auth}",
    }
    code, data = _http_json(endpoint, method="POST", headers=headers, body=body, timeout=60)
    if code not in (200, 201):
        raise RuntimeError(f"WordPress REST エラー: HTTP {code} {data!r}")
    if not isinstance(data, dict):
        raise RuntimeError(f"WordPress 応答が不正: {data!r}")
    return data


def main() -> int:
    p = argparse.ArgumentParser(
        description="AIでコラム下書きを作成し WP に保存します（常に draft）。"
        " テーマ・キーワード・参考URL・メモを組み合わせて指定できます。"
    )
    p.add_argument(
        "topic",
        nargs="?",
        default="",
        help="取り上げたい内容・メモ・構成の希望（日本語。省略可）",
    )
    p.add_argument(
        "--theme",
        default="",
        help="コラム全体の方向性・トーン（例: 冬のくらしと健康）",
    )
    p.add_argument(
        "--keyword",
        action="append",
        default=[],
        metavar="KW",
        help="記事に含めたいキーワード（複数回指定可）",
    )
    p.add_argument(
        "--reference-url",
        action="append",
        dest="reference_urls",
        default=[],
        metavar="URL",
        help="参考にする公開ページのURL（複数回指定可。本文テキストを取得してプロンプトに含めます）",
    )
    p.add_argument(
        "--max-ref-chars",
        type=int,
        default=12000,
        metavar="N",
        help="各参考URLから読み込むテキストの最大文字数（既定: 12000）",
    )
    p.add_argument("--model", default="gpt-4o-mini", help="OpenAI モデル名")
    p.add_argument(
        "--print-prompt-only",
        action="store_true",
        help="AIに渡すユーザープロンプトだけ表示し、API呼び出しとWP投稿はしません",
    )
    args = p.parse_args()

    topic = args.topic
    theme = args.theme or ""
    keywords = [k.strip() for k in args.keyword if k and str(k).strip()]
    ref_urls = [u.strip() for u in (args.reference_urls or []) if u and str(u).strip()]

    if not topic.strip() and not theme.strip() and not keywords and not ref_urls:
        print(
            "次のいずれかを指定してください: メモ（引数）、--theme、--keyword、--reference-url",
            file=sys.stderr,
        )
        return 1

    reference_blocks: list[tuple[str, str]] = []
    for url in ref_urls:
        try:
            txt = fetch_reference_text(url, max(4000, args.max_ref_chars))
        except urllib.error.HTTPError as e:
            reference_blocks.append((url, f"（HTTP取得エラー: {e.code}）"))
        except urllib.error.URLError as e:
            reference_blocks.append((url, f"（URLエラー: {e.reason!r}）"))
        except Exception as e:
            reference_blocks.append((url, f"（取得エラー: {e}）"))
        else:
            reference_blocks.append((url, txt))

    user_prompt = build_user_prompt(topic, theme, keywords, reference_blocks)

    if args.print_prompt_only:
        print(user_prompt)
        return 0

    api_key = os.environ.get("OPENAI_API_KEY", "").strip()
    base_url = os.environ.get("WP_BASE_URL", "").strip().rstrip("/")
    user = os.environ.get("WP_USER", "").strip()
    app_pw = os.environ.get("WP_APP_PASSWORD", "").strip()

    missing = [
        name
        for name, val in [
            ("OPENAI_API_KEY", api_key),
            ("WP_BASE_URL", base_url),
            ("WP_USER", user),
            ("WP_APP_PASSWORD", app_pw),
        ]
        if not val
    ]
    if missing:
        print("環境変数が不足しています: " + ", ".join(missing), file=sys.stderr)
        return 1

    try:
        article = openai_generate_article(user_prompt, args.model, api_key)
    except Exception as e:
        print(f"AI 生成に失敗: {e}", file=sys.stderr)
        return 1

    try:
        created = wp_create_column_draft(
            base_url,
            user,
            app_pw,
            article["title"],
            article["excerpt"],
            article["content_html"],
        )
    except Exception as e:
        print(f"WordPress 投稿に失敗: {e}", file=sys.stderr)
        return 1

    pid = created.get("id")
    link = created.get("link") or ""
    edit_guess = f"{base_url.rstrip('/')}/wp-admin/post.php?post={pid}&action=edit" if pid else ""
    print("下書きを作成しました（公開していません）。")
    print(f"  ID: {pid}")
    if link:
        print(f"  プレビュー/リンク: {link}")
    if edit_guess:
        print(f"  編集画面（要ログイン）: {edit_guess}")
    return 0


if __name__ == "__main__":
    sys.exit(main())
