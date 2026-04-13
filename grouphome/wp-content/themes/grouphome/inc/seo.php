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
	if ( ! function_exists( 'get_field' ) ) {
		return;
	}
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
		'name'      => get_field( 'facility_name' ) ?: ( function_exists( 'grouphome_site_display_name' ) ? grouphome_site_display_name() : get_bloginfo( 'name' ) ),
		'telephone' => get_field( 'tel' ),
		'address'   => $address,
	];
	$data = array_filter( $data );
	if ( isset( $data['address'] ) && $data['address'] === [] ) {
		unset( $data['address'] );
	}
	echo '<script type="application/ld+json">' . wp_json_encode( $data, JSON_UNESCAPED_UNICODE ) . '</script>';
}

function grouphome_meta_description() {
	if ( ! is_singular() || ! function_exists( 'get_field' ) ) {
		return;
	}
	$desc = get_field( 'page_description' );
	if ( ! is_string( $desc ) || $desc === '' ) {
		return;
	}
	echo '<meta name="description" content="' . esc_attr( wp_strip_all_tags( $desc ) ) . '">' . "\n";
}

add_action( 'wp_head', 'grouphome_meta_description', 2 );
add_action( 'wp_head', 'grouphome_output_json_ld', 3 );
