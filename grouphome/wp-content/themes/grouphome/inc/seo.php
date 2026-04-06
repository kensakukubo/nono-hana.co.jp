<?php
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
