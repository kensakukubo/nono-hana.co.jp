<?php
function grouphome_page_has_visible_content( $post = null ) {
    $post = $post ?: get_post();
    if ( ! $post instanceof WP_Post ) {
        return false;
    }
    $rendered = apply_filters( 'the_content', $post->post_content );
    $text       = trim( wp_strip_all_tags( str_replace( "\xc2\xa0", ' ', $rendered ) ) );
    return '' !== $text;
}

function grouphome_picture_tag( $attachment_id, $size = 'large', $alt = '' ) {
    $webp = get_post_meta( $attachment_id, '_webp_url', true );
    $src  = wp_get_attachment_image_url( $attachment_id, $size );
    $alt  = esc_attr( $alt );
    if ( $webp ) {
        return "<picture><source type=\"image/webp\" srcset=\"{$webp}\"><img src=\"{$src}\" alt=\"{$alt}\" loading=\"lazy\"></picture>";
    }
    return "<img src=\"{$src}\" alt=\"{$alt}\" loading=\"lazy\">";
}
