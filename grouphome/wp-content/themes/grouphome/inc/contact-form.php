<?php
/**
 * Contact Form 7 連携（お問い合わせページ・サンクス遷移）。
 *
 * 【管理画面での作業】
 * 1) Contact Form 7 を有効化し、フォームを1つ作成する。
 * 2) 下記「フォーム例」をフォームタブに貼り付け、メールタブの宛先・件名を設定する。
 * 3) ショートコードの id を確認し、grouphome_get_contact_cf7_shortcode の id を合わせる（またはフィルタ grouphome_contact_cf7_shortcode）。
 * 4) 固定ページ「お問い合わせ完了」を新規作成し、スラッグを thanks にし、テンプレートで「お問い合わせ完了（サンクス）」を選ぶ（またはスラッグ thanks で自動適用）。
 *
 * --- CF7 フォーム例（フォームタブに貼り付け）---
 * <div class="grouphome-cf7-fields">
 * <p class="grouphome-cf7__field"><label>お名前 <span class="grouphome-cf7__req" aria-hidden="true">必須</span> [text* your-name autocomplete:name placeholder "山田 太郎"]</label></p>
 * <p class="grouphome-cf7__field"><label>メールアドレス <span class="grouphome-cf7__req" aria-hidden="true">必須</span> [email* your-email autocomplete:email placeholder "mail@example.com"]</label></p>
 * <p class="grouphome-cf7__field"><label>電話番号 <span class="grouphome-cf7__opt">任意</span> [tel your-tel placeholder "例: 090-1234-5678"]</label></p>
 * <p class="grouphome-cf7__field"><label>件名 <span class="grouphome-cf7__req" aria-hidden="true">必須</span> [text* your-subject placeholder "件名"]</label></p>
 * <p class="grouphome-cf7__field grouphome-cf7__field--full"><label>お問い合わせ内容 <span class="grouphome-cf7__req" aria-hidden="true">必須</span> [textarea* your-message placeholder "お問い合わせ内容をご記入ください"]</label></p>
 * <p class="grouphome-cf7__accept">[acceptance acceptance-privacy] 個人情報の取り扱いに同意する</p>
 * <p class="grouphome-cf7__submit">[submit class:grouphome-cf7__btn "送信する"]</p>
 * </div>
 *
 * メールタブ例:
 * 件名: [your-subject]（お問い合わせ／サイト名を手入力）
 * 本文: [your-name] 様\nメール: [your-email]\n電話: [your-tel]\n\n----\n[your-message]
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
