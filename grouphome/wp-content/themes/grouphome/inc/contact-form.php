<?php
/**
 * =============================================================================
 * お問い合わせ（Contact Form 7）設定ナビ — 上から順にやる
 * =============================================================================
 *
 * 【全体のゴール】
 *  訪問者が /contact/ でフォーム送信 → 管理者にメール → 送信者は /thanks/ へ遷移。
 *
 * 【フォーム設計の意図（CVR・運用）】
 *  先頭に「お問い合わせの種類」を置き、入居／採用／取材などで**担当振り分け**しやすくする。
 *  ユーザーは自分の用件に合わせて選ぶだけなので、迷いが減り、受け側も返信が早くなる。
 *
 * -----------------------------------------------------------------------------
 * A. プラグインを入れる（WordPress 管理画面）
 * -----------------------------------------------------------------------------
 *  左サイドバー「プラグイン」→ 上の「新規追加」
 *  → 検索窓に「Contact Form 7」→ インストール → 有効化
 *
 * -----------------------------------------------------------------------------
 * B. フォームを1つ作る（Contact Form 7 の画面）
 * -----------------------------------------------------------------------------
 *  左サイドバー「お問い合わせ」→「コンタクトフォーム」→「新規追加」
 *
 *  (1) 画面上部の「タイトル」にフォーム名（例: サイトお問い合わせ）を入力
 *
 *  (2) タブ「フォーム」を開く
 *      → エディタの中身を一度まるごと消してよい
 *      → 下記「■フォームタブ用 HTML」をコピーして貼り付け
 *
 *  (3) タブ「メール」を開く（管理者に届く通知）
 *      →「送信先 (To)」に受信したいメールアドレス（必ず実在する宛先）
 *      →「件名」「メッセージ本文」に下記「■管理者宛メール文面」をコピペ（必要なら編集）
 *      →「送信元」「追加ヘッダー」はサーバー仕様に合わせる（届かないときはホストの案内に従う）
 *
 *  (4) タブ「メール (2)」（任意・自動返信）
 *      → 使う場合だけ「メール (2) を有効にする」にチェック
 *      → 下記「■自動返信メール文面」をコピペ。送信先は [your-email] のまま
 *
 *  (5) 右側または下の「保存」
 *
 *  (6) 保存後、画面上に「ショートコード」が表示される
 *      → [contact-form-7 id="123" ...] の **数字 123 だけメモ**（これがフォーム ID）
 *
 * -----------------------------------------------------------------------------
 * C. テーマとフォーム ID を一致させる（FTP / Git / エディタ）
 * -----------------------------------------------------------------------------
 *  このファイル内の grouphome_get_contact_cf7_shortcode() の
 *  [contact-form-7 id="1" ...] の **1 を、B(6) でメモした数字に書き換える**
 *  → 保存してサーバーへデプロイ（普段の更新と同じ）
 *
 * -----------------------------------------------------------------------------
 * D. お問い合わせ用「固定ページ」を作る / 確認する（WordPress 管理画面）
 * -----------------------------------------------------------------------------
 *  左サイドバー「固定ページ」→「固定ページ一覧」または「新規追加」
 *  → スラッグが **contact**（パーマリンクが /contact/）のページがあること
 *  → タイトルは「お問い合わせ」など自由。本文は空でもよい（追記が「追加のご案内」に出る）
 *  →「公開」を押す
 *
 * -----------------------------------------------------------------------------
 * E. 送信完了（サンクス）用「固定ページ」を作る
 * -----------------------------------------------------------------------------
 *  左サイドバー「固定ページ」→「新規追加」
 *  → タイトル: 例「お問い合わせを受け付けました」
 *  → 右サイドバー「パーマリンク」または「URLスラッグ」で **thanks**（/thanks/ になること）
 *  → テンプレートに「お問い合わせ完了（サンクス）」があれば選択（なくてもスラッグ thanks でテーマが当てる）
 *  →「公開」
 *
 * -----------------------------------------------------------------------------
 * F. 動作確認
 * -----------------------------------------------------------------------------
 *  ブラウザで /contact/ を開く → テスト送信
 *  → /thanks/ に飛ぶか、管理者メールが届くか確認
 *
 * =============================================================================
 * ■フォームタブ用 HTML（B の (2) に貼る）
 * =============================================================================
 * <div class="grouphome-cf7-fields">
 * <p class="grouphome-cf7__hint">まずは内容に近いものをお選びください。種類が分かると、担当からのご返信が早くなります。</p>
 * <p class="grouphome-cf7__field"><label>お問い合わせの種類 <span class="grouphome-cf7__req" aria-hidden="true">必須</span> [select* inquiry-type include_blank "入居・見学のご相談" "採用について" "法人・取材・メディア" "その他のお問い合わせ"]</label></p>
 * <p class="grouphome-cf7__field"><label>お名前 <span class="grouphome-cf7__req" aria-hidden="true">必須</span> [text* your-name autocomplete:name placeholder "山田 太郎"]</label></p>
 * <p class="grouphome-cf7__field"><label>メールアドレス <span class="grouphome-cf7__req" aria-hidden="true">必須</span> [email* your-email autocomplete:email placeholder "mail@example.com"]</label></p>
 * <p class="grouphome-cf7__field"><label>電話番号 <span class="grouphome-cf7__opt">任意</span> [tel your-tel placeholder "例: 090-1234-5678"]</label></p>
 * <p class="grouphome-cf7__field"><label>ご希望の連絡方法 <span class="grouphome-cf7__req" aria-hidden="true">必須</span> [radio preferred-contact use_label_element default:1 "メール" "お電話"]</label></p>
 * <p class="grouphome-cf7__field"><label>件名の補足 <span class="grouphome-cf7__opt">任意</span> [text your-subject placeholder "（例）見学希望の日時など、一言あれば"]</label></p>
 * <p class="grouphome-cf7__field grouphome-cf7__field--full"><label>お問い合わせ内容 <span class="grouphome-cf7__req" aria-hidden="true">必須</span> [textarea* your-message placeholder "ご相談内容を具体的にご記入ください"]</label></p>
 * <p class="grouphome-cf7__accept">[acceptance acceptance-privacy] 個人情報の取り扱いに同意する</p>
 * <p class="grouphome-cf7__submit">[submit class:grouphome-cf7__btn "送信する"]</p>
 * </div>
 *
 * =============================================================================
 * ■管理者宛メール文面（B の (3) メールタブ「メッセージ本文」に貼る）
 * =============================================================================
 * 件名（メールタブの「件名」欄）:
 * [inquiry-type]｜お問い合わせ（ペット共生型グループホームわおん花園）
 *
 * 本文:
 * 以下のとおりお問い合わせがありました。
 *
 * 種類: [inquiry-type]
 * お名前: [your-name]
 * メール: [your-email]
 * 電話: [your-tel]
 * ご希望の連絡方法: [preferred-contact]
 * 件名の補足: [your-subject]
 *
 * ---- メッセージ ----
 * [your-message]
 *
 * ----
 * 送信日時: [_date] [_time]
 * 送信元IP: [_remote_ip]
 *
 * =============================================================================
 * ■自動返信メール文面（B の (4) メール (2) 用・任意）
 * =============================================================================
 * 送信先 (To): [your-email]
 * 件名: 【自動返信】[inquiry-type]について（ペット共生型グループホームわおん花園）
 * 本文:
 * [your-name] 様
 *
 * この度は、お問い合わせいただきありがとうございます。
 * 以下の内容で受け付けました。担当よりご連絡いたします（ご希望の連絡方法：[preferred-contact]）。
 *
 * お問い合わせの種類: [inquiry-type]
 *
 * ----
 * [your-message]
 *
 * ※このメールは自動送信です。心当たりがない場合は破棄してください。
 */

/**
 * お問い合わせページかどうか（スラッグはフィルタで変更可）。
 *
 * @return bool
 */
function grouphome_is_contact_page() {
	if ( ! is_singular( 'page' ) ) {
		return false;
	}
	$post = get_queried_object();
	if ( ! $post instanceof WP_Post ) {
		return false;
	}
	$slugs = (array) apply_filters( 'grouphome_contact_page_slugs', [ 'contact' ] );
	return $post->post_name && in_array( $post->post_name, $slugs, true );
}

/**
 * 送信完了後の遷移先URL（固定ページのパーマリンクに合わせる）。
 *
 * @return string
 */
function grouphome_get_contact_thanks_url() {
	$default = home_url( '/thanks/' );
	return apply_filters( 'grouphome_contact_thanks_url', $default );
}

/**
 * @return string
 */
function grouphome_get_contact_cf7_shortcode() {
	$default = '[contact-form-7 id="1" html_class="grouphome-cf7"]';
	return apply_filters( 'grouphome_contact_cf7_shortcode', $default );
}

/**
 * CF7 送信成功時にサンクスへリダイレクトするスクリプト（お問い合わせページのみ）。
 */
function grouphome_contact_cf7_enqueue_redirect() {
	if ( ! grouphome_is_contact_page() ) {
		return;
	}
	if ( function_exists( 'shortcode_exists' ) && ! shortcode_exists( 'contact-form-7' ) ) {
		return;
	}
	wp_enqueue_script(
		'grouphome-contact-cf7',
		get_template_directory_uri() . '/assets/js/contact-cf7.js',
		[],
		'1.0.0',
		true
	);
	wp_localize_script(
		'grouphome-contact-cf7',
		'grouphomeContactCf7',
		[
			'thanksUrl' => esc_url( grouphome_get_contact_thanks_url() ),
		]
	);
}
add_action( 'wp_enqueue_scripts', 'grouphome_contact_cf7_enqueue_redirect', 25 );
