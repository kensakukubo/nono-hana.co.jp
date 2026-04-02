<?php get_header(); ?>
<main class="l-page">
  <div class="w-inner">
    <div class="section-heading">
      <h1>お知らせ・コラム</h1>
      <p class="section-heading__sub">TOPICS</p>
      <div class="section-heading__line"></div>
    </div>
    <ul class="news-list l-page-archive__list">
      <?php if ( have_posts() ) : ?>
        <?php while ( have_posts() ) : the_post(); ?>
      <li class="news-item">
        <a href="<?php the_permalink(); ?>">
          <span class="news-date"><?php echo esc_html( get_the_date( 'Y.m.d' ) ); ?></span>
          <span class="news-title"><?php the_title(); ?></span>
        </a>
      </li>
        <?php endwhile; ?>
      <?php endif; ?>
    </ul>
    <div class="l-page-archive__pagination">
      <?php the_posts_pagination(); ?>
    </div>
  </div>
</main>
<?php get_footer(); ?>
