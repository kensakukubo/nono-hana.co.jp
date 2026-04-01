<?php
function grouphome_get_service_area_text() {
    if ( ! function_exists( 'get_field' ) ) return '';
    $areas = get_field( 'service_areas' );
    if ( ! $areas ) return '';
    $facility = get_field( 'facility_name' ) ?: get_bloginfo( 'name' );
    $list = implode( '・', array_map( 'trim', explode( ',', $areas ) ) );
    return "{$facility}では、{$list}などからも入居のご相談をいただいています。お気軽にお問い合わせください。";
}
