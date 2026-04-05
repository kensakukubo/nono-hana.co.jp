<?php get_header(); ?>
<main class="l-page">
  <div class="w-inner">
    <?php if ( have_posts() ) : ?>
      <?php while ( have_posts() ) : the_post(); ?>
    <p class="news-date"><?php echo esc_html( get_the_date( 'Y.m.d' ) ); ?></p>
    <h1 class="l-page__title"><?php the_title(); ?></h1>
    <div class="page-content">
      <?php the_content(); ?>
    </div>
    <div class="l-page-back">
      <a href="<?php echo esc_url( home_url( '/news/' ) ); ?>" class="btn-secondary">一覧に戻る</a>
    </div>
      <?php endwhile; ?>
    <?php endif; ?>
  </div>
</main>
<?php get_footer(); ?>
