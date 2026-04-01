<?php
function grouphome_register_block_patterns() {
    register_block_pattern_category( 'grouphome', [ 'label' => 'わおんハウス' ] );
}
add_action( 'init', 'grouphome_register_block_patterns' );
