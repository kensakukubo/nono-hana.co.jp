<?php get_header(); ?>
<?php
if ( have_posts() ) :
    while ( have_posts() ) :
        the_post();
        if ( ! grouphome_page_has_visible_content() ) {
            continue;
        }
        ?>
<main class="l-page">
  <div class="w-inner">
    <article <?php post_class(); ?>>
      <h1 class="l-page__title"><?php the_title(); ?></h1>
      <div class="page-content">
        <?php the_content(); ?>
      </div>
    </article>
  </div>
</main>
        <?php
    endwhile;
endif;
?>
<?php get_footer(); ?>
