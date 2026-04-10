<?php
/**
 * Contact Form 7 連携（お問い合わせページ）。
 *
 * 管理画面で作成したフォームの ID に合わせて、子テーマや functions で
 * add_filter( 'grouphome_contact_cf7_shortcode', fn() => '[contact-form-7 id="123" html_class="grouphome-cf7"]' );
 * とするか、下のデフォルトの id を書き換えてください。
 *
 * --- CF7 に貼るフォーム例（フォームタブ）---
 * <div class="grouphome-cf7-fields">
 * <p class="grouphome-cf7__field"><label>お名前 <span class="grouphome-cf7__req" aria-hidden="true">必須</span> [text* your-name autocomplete:name placeholder "山田 太郎"]</label></p>
 * <p class="grouphome-cf7__field"><label>メールアドレス <span class="grouphome-cf7__req" aria-hidden="true">必須</span> [email* your-email autocomplete:email placeholder "mail@example.com"]</label></p>
 * <p class="grouphome-cf7__field"><label>電話番号 <span class="grouphome-cf7__opt">任意</span> [tel your-tel placeholder "例: 090-1234-5678"]</label></p>
 * <p class="grouphome-cf7__field"><label>件名 <span class="grouphome-cf7__req" aria-hidden="true">必須</span> [text* your-subject placeholder "件名"]</label></p>
 * <p class="grouphome-cf7__field grouphome-cf7__field--full"><label>お問い合わせ内容 <span class="grouphome-cf7__req" aria-hidden="true">必須</span> [textarea* your-message placeholder "内容をご記入ください"]</label></p>
 * <p class="grouphome-cf7__accept">[acceptance acceptance-privacy] 個人情報の取り扱いに同意する</p>
 * <p class="grouphome-cf7__submit">[submit class:grouphome-cf7__btn "送信する"]</p>
 * </div>
 *
 * メールタブ例: 宛先はサイト運用メールに変更。件名: [your-subject]
 * 本文: [your-name] 様より\nメール: [your-email]\n電話: [your-tel]\n\n[your-message]
 */

function grouphome_get_contact_cf7_shortcode() {
	$default = '[contact-form-7 id="1" html_class="grouphome-cf7"]';
	return apply_filters( 'grouphome_contact_cf7_shortcode', $default );
}
