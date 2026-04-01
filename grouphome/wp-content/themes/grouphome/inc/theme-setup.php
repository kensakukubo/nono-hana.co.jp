<?php
function grouphome_setup() {
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'title-tag' );
    add_theme_support( 'html5', [
        'search-form', 'comment-form', 'comment-list', 'gallery', 'caption',
    ]);
    add_theme_support( 'custom-logo' );
    add_theme_support( 'editor-styles' );
    add_theme_support( 'wp-block-styles' );

    register_nav_menus([
        'global_nav'  => 'グローバルナビ',
        'footer_nav'  => 'フッターナビ',
    ]);
}
add_action( 'after_setup_theme', 'grouphome_setup' );