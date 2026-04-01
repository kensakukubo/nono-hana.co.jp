<?php
function grouphome_output_json_ld() {
    if ( ! function_exists( 'get_field' ) ) return;
    $data = [
        '@context'  => 'https://schema.org',
        '@type'     => 'LocalBusiness',
        'name'      => get_field( 'facility_name' ) ?: get_bloginfo( 'name' ),
        'telephone' => get_field( 'tel' ),
        'address'   => [
            '@type'          => 'PostalAddress',
            'addressCountry' => 'JP',
            'postalCode'     => get_field( 'postal_code' ),
            'addressRegion'  => get_field( 'prefecture' ),
            'streetAddress'  => get_field( 'street_address' ),
        ],
    ];
    echo '<script type="application/ld+json">' . json_encode( $data, JSON_UNESCAPED_UNICODE ) . '</script>';
}
add_action( 'wp_head', 'grouphome_output_json_ld' );
