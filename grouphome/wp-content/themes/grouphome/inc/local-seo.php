<?php
function grouphome_get_service_area_text() {
	if ( ! function_exists( 'get_field' ) ) {
		return '';
	}
	$areas = get_field( 'service_areas' );
	$areas = function_exists( 'grouphome_acf_textish' ) ? grouphome_acf_textish( $areas ) : ( is_string( $areas ) ? $areas : '' );
	$areas = trim( (string) $areas );
	if ( $areas === '' ) {
		return '';
	}
	$facility_raw = get_field( 'facility_name' );
	$facility     = function_exists( 'grouphome_acf_textish' ) ? grouphome_acf_textish( $facility_raw ) : ( is_string( $facility_raw ) ? $facility_raw : '' );
	$facility     = $facility !== '' ? $facility : get_bloginfo( 'name' );
	$list         = implode( '・', array_map( 'trim', explode( ',', $areas ) ) );
	return "{$facility}では、{$list}などからも入居のご相談をいただいています。お気軽にお問い合わせください。";
}
