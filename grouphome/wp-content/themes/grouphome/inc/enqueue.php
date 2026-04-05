<?php
function grouphome_enqueue_scripts() {
    wp_enqueue_style(
        'grouphome-style',
        get_template_directory_uri() . '/assets/css/main.css',
        [],
        '1.4.0'
    );

    wp_enqueue_script(
        'grouphome-main',
        get_template_directory_uri() . '/assets/js/main.js',
        [],
        '1.4.0',
        true
    );
}
add_action( 'wp_enqueue_scripts', 'grouphome_enqueue_scripts' );

add_filter( 'script_loader_tag', function( $tag, $handle, $src ) {
    $defer = [ 'grouphome-main' ];
    if ( in_array( $handle, $defer ) ) {
        return str_replace( '<script ', '<script defer ', $tag );
    }
    return $tag;
}, 10, 3 );