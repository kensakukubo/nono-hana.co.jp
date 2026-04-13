#!/usr/bin/env python3
"""
コラム下書きの自動作成（AI生成 → WordPress REST API で draft 投稿）

運用: 生成は必ず「下書き」。公開は管理画面で人が行う。

必要な環境変数:
  OPENAI_API_KEY   OpenAI API キー
  WP_BASE_URL      例: https://example.com/grouphome または https://example.com（WPのルート）
  WP_USER          WordPress ユーザー名
  WP_APP_PASSWORD  アプリケーションパスワード（スペース区切りでもそのまま）

使い方:
  export OPENAI_API_KEY=... WP_BASE_URL=... WP_USER=... WP_APP_PASSWORD=...
  python3 column_draft_from_ai.py "記事のテーマやメモを日本語で"

オプション:
  --model gpt-4o-mini   既定は gpt-4o-mini
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


def openai_generate_article(topic: str, model: str, api_key: str) -> dict[str, str]:
    system = (
        "あなたは日本のグループホーム・介護福祉に関するコラム執筆者です。"
        "出力は次のJSONだけ。他の文は書かない。JSONのキーは title, excerpt, content_html。"
        "title は40文字以内が目安。excerpt は160文字以内の紹介文。"
        "content_html は本文のみ。見出しは h2/h3、段落は p、箇条書きは ul/li。"
        "誇大・断定的な医療効果の表現は避け、事実と一般的な説明に留める。"
    )
    user = f"次のテーマ・メモに基づきコラム下書きを書いてください。\n\n{topic}"
    payload = {
        "model": model,
        "messages": [
            {"role": "system", "content": system},
            {"role": "user", "content": user},
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
    # response_format json_object でも稀にフェンスが付く場合に備える
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
    p = argparse.ArgumentParser(description="AIでコラム下書きを作成し WP に保存します（常に draft）。")
    p.add_argument("topic", help="テーマ・メモ（日本語）")
    p.add_argument("--model", default="gpt-4o-mini", help="OpenAI モデル名")
    args = p.parse_args()

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
        article = openai_generate_article(args.topic, args.model, api_key)
    except Exception as e:
        print(f"AI 生成に失敗: {e}", file=sys.stderr)
        return 1

    try:
        created = wp_create_column_draft(
            base_url, user, app_pw,
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
