/**
 * Contact Form 7 送信成功後にサンクスページへ遷移する。
 */
document.addEventListener(
	'wpcf7mailsent',
	function () {
		if ( typeof grouphomeContactCf7 === 'undefined' || ! grouphomeContactCf7.thanksUrl ) {
			return;
		}
		window.location.href = grouphomeContactCf7.thanksUrl;
	},
	false
);
