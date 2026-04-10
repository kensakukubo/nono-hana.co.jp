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

/**
 * カスタム投稿タイプ/タクソノミーのリライトルールを安全に更新する。
 *
 * - テーマ更新や移行直後に /jobs/ 等が 404 になるのは、リライトルールが古いままのことがあるため。
 * - 毎回 flush すると重いので「必要なときだけ」1回実行する。
 */
function grouphome_mark_rewrite_flush_needed() {
	update_option( 'grouphome_needs_rewrite_flush', 1, false );
}
add_action( 'after_switch_theme', 'grouphome_mark_rewrite_flush_needed' );

function grouphome_maybe_flush_rewrite_rules() {
	$needs = (int) get_option( 'grouphome_needs_rewrite_flush', 0 );
	if ( $needs !== 1 ) {
		return;
	}

	// CPT/タクソノミー登録（init）後に実行される想定。
	flush_rewrite_rules( false );
	delete_option( 'grouphome_needs_rewrite_flush' );
}
add_action( 'init', 'grouphome_maybe_flush_rewrite_rules', 99 );

function grouphome_acf_json_save_path( $path ) {
	return get_template_directory() . '/acf-json';
}

function grouphome_acf_json_load_paths( $paths ) {
	$paths[] = get_template_directory() . '/acf-json';
	return $paths;
}

function grouphome_register_acf_json_paths() {
	if ( ! function_exists( 'acf_get_setting' ) ) {
		return;
	}
	add_filter( 'acf/settings/save_json', 'grouphome_acf_json_save_path' );
	add_filter( 'acf/settings/load_json', 'grouphome_acf_json_load_paths' );
}
add_action( 'after_setup_theme', 'grouphome_register_acf_json_paths', 5 );

/**
 * 入居のご案内を page-guide.php で表示する。
 *
 * 固定ページが「デフォルトテンプレート」のままだと page.php が使われ、
 * ブロック／クラシック本文に残った古い HTML（写真枠・料金表など）だけが
 * 出力され、テーマの page-guide.php の変更が反映されないことがある。
 */
function grouphome_force_page_guide_template( $template ) {
	if ( ! is_singular( 'page' ) ) {
		return $template;
	}

	$post = get_queried_object();
	if ( ! $post instanceof WP_Post ) {
		return $template;
	}

	if ( basename( $template ) === 'page-guide.php' ) {
		return $template;
	}

	$assigned = get_page_template_slug( $post );
	if ( $assigned && 'default' !== $assigned ) {
		if ( basename( $assigned ) !== 'page-guide.php' ) {
			return $template;
		}
	}

	$slugs = (array) apply_filters( 'grouphome_guide_page_slugs', [ 'guide' ] );
	$slug  = $post->post_name;
	$use   = $slug && in_array( $slug, $slugs, true );

	if ( ! $use && strpos( $post->post_content, 'guide-step__photo' ) !== false ) {
		$use = true;
	}

	if ( ! $use ) {
		return $template;
	}

	$path = get_template_directory() . '/page-guide.php';
	return is_readable( $path ) ? $path : $template;
}
add_filter( 'template_include', 'grouphome_force_page_guide_template', 99 );

/**
 * お問い合わせを page-contact.php で表示する（スラッグ contact・テンプレート未指定時）。
 */
function grouphome_force_page_contact_template( $template ) {
	if ( ! is_singular( 'page' ) ) {
		return $template;
	}

	$post = get_queried_object();
	if ( ! $post instanceof WP_Post ) {
		return $template;
	}

	if ( basename( $template ) === 'page-contact.php' ) {
		return $template;
	}

	$assigned = get_page_template_slug( $post );
	if ( $assigned && 'default' !== $assigned ) {
		if ( basename( $assigned ) !== 'page-contact.php' ) {
			return $template;
		}
	}

	$slugs = (array) apply_filters( 'grouphome_contact_page_slugs', [ 'contact' ] );
	if ( ! $post->post_name || ! in_array( $post->post_name, $slugs, true ) ) {
		return $template;
	}

	$path = get_template_directory() . '/page-contact.php';
	return is_readable( $path ) ? $path : $template;
}
add_filter( 'template_include', 'grouphome_force_page_contact_template', 98 );

/**
 * <title> のサイト名部分（管理画面「サイトのタイトル」と差があってもフロントを統一）。
 */
function grouphome_document_title_parts_site( $parts ) {
	if ( function_exists( 'grouphome_site_display_name' ) ) {
		$parts['site'] = grouphome_site_display_name();
	}
	return $parts;
}
add_filter( 'document_title_parts', 'grouphome_document_title_parts_site' );