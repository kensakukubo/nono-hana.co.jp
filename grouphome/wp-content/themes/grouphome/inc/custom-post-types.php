<?php
function grouphome_register_post_types() {
    register_post_type( 'news', [
        'labels'        => [
            'name'          => 'お知らせ',
            'singular_name' => 'お知らせ',
            'add_new_item'  => 'お知らせを追加',
            'edit_item'     => 'お知らせを編集',
        ],
        'public'        => true,
        'has_archive'   => true,
        'rewrite'       => [ 'slug' => 'news' ],
        'supports'      => [ 'title', 'editor', 'thumbnail', 'excerpt' ],
        'menu_icon'     => 'dashicons-megaphone',
        'show_in_rest'  => true,
    ]);

    register_post_type( 'column', [
        'labels'        => [
            'name'          => 'コラム',
            'singular_name' => 'コラム',
            'add_new_item'  => 'コラムを追加',
            'edit_item'     => 'コラムを編集',
        ],
        'public'        => true,
        'has_archive'   => true,
        'rewrite'       => [ 'slug' => 'column' ],
        'supports'      => [ 'title', 'editor', 'thumbnail', 'excerpt' ],
        'menu_icon'     => 'dashicons-welcome-write-blog',
        'show_in_rest'  => true,
    ]);

    register_post_type( 'hero_slide', [
        'labels'        => [
            'name'          => 'ヒーロースライド',
            'singular_name' => 'ヒーロースライド',
            'add_new_item'  => 'スライドを追加',
        ],
        'public'        => false,
        'show_ui'       => true,
        'supports'      => [ 'title', 'thumbnail', 'page-attributes' ],
        'menu_icon'     => 'dashicons-images-alt2',
    ]);

    // 求人（Indeed 等に拾わせる前提の「1求人=1投稿」）
    register_post_type( 'job', [
        'labels'        => [
            'name'          => '求人',
            'singular_name' => '求人',
            'add_new_item'  => '求人を追加',
            'edit_item'     => '求人を編集',
        ],
        'public'        => true,
        'has_archive'   => true,
        'rewrite'       => [ 'slug' => 'jobs' ],
        'supports'      => [ 'title', 'editor', 'excerpt', 'thumbnail' ],
        'menu_icon'     => 'dashicons-id',
        'show_in_rest'  => true,
    ]);

    register_taxonomy( 'news_category', 'news', [
        'labels'        => [
            'name'          => 'お知らせカテゴリー',
            'singular_name' => 'カテゴリー',
        ],
        'hierarchical'  => true,
        'rewrite'       => [ 'slug' => 'news-category' ],
        'show_in_rest'  => true,
    ]);

    register_taxonomy( 'news_location', 'news', [
        'labels'        => [
            'name'          => '拠点',
            'singular_name' => '拠点',
        ],
        'hierarchical'  => true,
        'rewrite'       => [ 'slug' => 'news-location' ],
        'show_in_rest'  => true,
    ]);

    // 勤務地（拠点）: /job-location/{slug}/ で場所ごとの求人一覧を作る
    register_taxonomy( 'job_location', 'job', [
        'labels'        => [
            'name'          => '勤務地',
            'singular_name' => '勤務地',
        ],
        'hierarchical'  => true,
        'rewrite'       => [ 'slug' => 'job-location' ],
        'show_in_rest'  => true,
    ]);
}
add_action( 'init', 'grouphome_register_post_types' );