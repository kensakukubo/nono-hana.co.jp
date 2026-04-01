<?php
function grouphome_convert_to_webp( $upload ) {
    $mime = $upload['type'] ?? '';
    if ( ! in_array( $mime, [ 'image/jpeg', 'image/png' ] ) ) return $upload;
    if ( ! function_exists( 'imagewebp' ) ) return $upload;
    $source = $upload['file'];
    $dest   = preg_replace( '/\.(jpe?g|png)$/i', '.webp', $source );
    $image  = ( $mime === 'image/jpeg' ) ? imagecreatefromjpeg( $source ) : imagecreatefrompng( $source );
    if ( $image ) {
        imagewebp( $image, $dest, 82 );
        imagedestroy( $image );
    }
    return $upload;
}
add_filter( 'wp_handle_upload', 'grouphome_convert_to_webp' );
