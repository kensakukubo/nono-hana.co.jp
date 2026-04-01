<?php
function grouphome_picture_tag( $attachment_id, $size = 'large', $alt = '' ) {
    $webp = get_post_meta( $attachment_id, '_webp_url', true );
    $src  = wp_get_attachment_image_url( $attachment_id, $size );
    $alt  = esc_attr( $alt );
    if ( $webp ) {
        return "<picture><source type=\"image/webp\" srcset=\"{$webp}\"><img src=\"{$src}\" alt=\"{$alt}\" loading=\"lazy\"></picture>";
    }
    return "<img src=\"{$src}\" alt=\"{$alt}\" loading=\"lazy\">";
}
