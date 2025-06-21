<?php
function get_the_pagenation(){
    global $wp_query;
    $big = 999999999;
    $args = array(
        "base" => str_replace($big, "%#%", esc_url(get_pagenum_link($big))),
        "total" => $wp_query->max_num_pages,
        "current" => max(1, get_query_var("paged")),
        "mid_size" => 1
    );

    return paginate_links($args);
}
function the_pagenation(){
    echo get_the_pagenation();
}