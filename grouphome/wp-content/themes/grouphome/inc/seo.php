<?php
/**
 * 管理画面「外観 → カスタマイズ → サイトアイコン」未設定時のみ、テーマ同梱のファビコンを出力する。
 */
function grouphome_default_favicon() {
	if ( function_exists( 'has_site_icon' ) && has_site_icon() ) {
		return;
	}
	$url = get_template_directory_uri() . '/assets/img/favicon-waon.png';
	echo '<link rel="icon" href="' . esc_url( $url ) . '" type="image/png" sizes="512x512">' . "\n";
	echo '<link rel="apple-touch-icon" href="' . esc_url( $url ) . '">' . "\n";
}
add_action( 'wp_head', 'grouphome_default_favicon', 1 );

function grouphome_output_json_ld() {
	if ( grouphome_seo_is_location_page() ) {
		$city   = get_field( 'city' );
		$street = get_field( 'street_address' );
		$line1  = trim( (string) $city . ' ' . (string) $street );

		$address = [
			'@type'           => 'PostalAddress',
			'addressCountry'  => 'JP',
			'postalCode'      => get_field( 'postal_code' ),
			'addressRegion'   => get_field( 'prefecture' ),
			'streetAddress'   => $line1 !== '' ? $line1 : get_field( 'street_address' ),
		];
		$address = array_filter( $address );

		$data = [
			'@context'  => 'https://schema.org',
			'@type'     => 'LocalBusiness',
			'name'      => get_field( 'facility_name' ) ?: get_the_title(),
			'url'       => get_permalink(),
			'telephone' => get_field( 'tel' ) ?: grouphome_phone_main_display(),
			'image'     => grouphome_seo_image_url(),
			'address'   => $address,
		];
	} elseif ( is_front_page() ) {
		$data = [
			'@context'  => 'https://schema.org',
			'@type'     => 'Organization',
			'name'      => get_bloginfo( 'name' ),
			'url'       => home_url( '/' ),
			'telephone' => grouphome_phone_main_display(),
			'logo'      => get_template_directory_uri() . '/assets/img/favicon-waon.png',
		];
	} else {
		return;
	}
	$data = array_filter( $data );
	if ( isset( $data['address'] ) && $data['address'] === [] ) {
		unset( $data['address'] );
	}
	echo '<script type="application/ld+json">' . wp_json_encode( $data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ) . '</script>' . "\n";
}

/**
 * 拠点ページ（page-location.php）か。
 */
function grouphome_seo_is_location_page() {
	return is_page() && function_exists( 'get_field' ) && 'page-location.php' === get_page_template_slug();
}

/**
 * 検索結果・SNS 用の説明文。ACF「page_description」優先、なければページ種別ごとの既定文。
 */
function grouphome_seo_description() {
	$default = '大阪市西成区のペット共生型グループホーム わおん。花園・西天下茶屋・千本の3拠点で、障がいのある方が犬や猫と一緒に暮らせる住まいを提供しています。見学・入居のご相談はお気軽にどうぞ。';
	if ( ! is_singular() ) {
		return $default;
	}
	$desc = function_exists( 'get_field' ) ? get_field( 'page_description' ) : '';
	if ( is_string( $desc ) && trim( $desc ) !== '' ) {
		return wp_strip_all_tags( $desc );
	}
	if ( grouphome_seo_is_location_page() ) {
		$name = get_field( 'facility_name' ) ?: get_the_title();
		$addr = trim( (string) get_field( 'prefecture' ) . (string) get_field( 'city' ) . (string) get_field( 'street_address' ) );
		return $name . ( $addr !== '' ? '（' . $addr . '）' : '' ) . 'は、障がいのある方が犬や猫と一緒に暮らせるペット共生型グループホームです。居室・共用スペースの写真、料金の目安、アクセスを掲載しています。';
	}
	$excerpt = wp_strip_all_tags( get_the_excerpt() );
	$excerpt = trim( preg_replace( '/\s+/u', ' ', $excerpt ) );
	return $excerpt !== '' ? mb_substr( $excerpt, 0, 120 ) : $default;
}

/**
 * SNS 用の画像。アイキャッチ → 拠点の施設写真 → 花園の外観。
 */
function grouphome_seo_image_url() {
	return set_url_scheme( grouphome_seo_image_url_raw(), 'https' );
}

function grouphome_seo_image_url_raw() {
	if ( is_singular() && has_post_thumbnail() ) {
		$u = get_the_post_thumbnail_url( null, 'large' );
		if ( $u ) {
			return $u;
		}
	}
	if ( grouphome_seo_is_location_page() && function_exists( 'grouphome_location_default_facility_image_url' ) ) {
		$u = grouphome_location_default_facility_image_url();
		if ( $u ) {
			return $u;
		}
	}
	return grouphome_uploads_public_url( '2026/04/S__56811553.jpg' );
}

function grouphome_meta_description() {
	$desc  = grouphome_seo_description();
	$title = wp_get_document_title();
	$url   = is_front_page() ? home_url( '/' ) : ( is_singular() ? get_permalink() : '' );
	echo '<meta name="description" content="' . esc_attr( $desc ) . '">' . "\n";
	if ( is_front_page() && ! is_paged() ) {
		// WP は投稿一覧のトップに canonical を出さないため補う。
		echo '<link rel="canonical" href="' . esc_url( home_url( '/' ) ) . '">' . "\n";
	}
	$og = [
		'og:site_name'   => get_bloginfo( 'name' ),
		'og:type'        => is_front_page() ? 'website' : 'article',
		'og:title'       => $title,
		'og:description' => $desc,
		'og:url'         => $url,
		'og:image'       => grouphome_seo_image_url(),
		'og:locale'      => 'ja_JP',
	];
	foreach ( $og as $k => $v ) {
		if ( $v !== '' ) {
			echo '<meta property="' . esc_attr( $k ) . '" content="' . esc_attr( $v ) . '">' . "\n";
		}
	}
	echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
}

add_action( 'wp_head', 'grouphome_meta_description', 2 );
add_action( 'wp_head', 'grouphome_output_json_ld', 3 );

/**
 * Google タグマネージャー（野の花本体と同じコンテナ。GA4 は GTM 側で設定済み）。
 */
define( 'GROUPHOME_GTM_ID', 'GTM-K9RRHLF' );

function grouphome_gtm_head() {
	?>
<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','<?php echo esc_js( GROUPHOME_GTM_ID ); ?>');</script>
<!-- End Google Tag Manager -->
	<?php
}
add_action( 'wp_head', 'grouphome_gtm_head', 0 );

function grouphome_gtm_body() {
	echo '<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=' . esc_attr( GROUPHOME_GTM_ID ) . '" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>' . "\n";
}
add_action( 'wp_body_open', 'grouphome_gtm_body' );

/**
 * サイトマップ: ユーザー一覧（ログイン名が分かる）とサンプルページを除外。
 */
function grouphome_sitemaps_remove_users( $provider, $name ) {
	return 'users' === $name ? false : $provider;
}
add_filter( 'wp_sitemaps_add_provider', 'grouphome_sitemaps_remove_users', 10, 2 );

function grouphome_sitemaps_exclude_pages( $args, $post_type ) {
	if ( 'page' !== $post_type ) {
		return $args;
	}
	$sample = get_page_by_path( 'sample-page' );
	if ( $sample instanceof WP_Post ) {
		$args['post__not_in'] = array_merge( isset( $args['post__not_in'] ) ? (array) $args['post__not_in'] : [], [ $sample->ID ] );
	}
	return $args;
}
add_filter( 'wp_sitemaps_posts_query_args', 'grouphome_sitemaps_exclude_pages', 10, 2 );
