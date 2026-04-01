<section id="news">
  <div class="w-inner">
    <div class="section-heading">
      <h2>お知らせ・コラム</h2>
      <p class="section-heading__sub">TOPICS</p>
      <div class="section-heading__line"></div>
    </div>
    <ul class="news-list">
      <?php
      $posts = get_posts( [ 'post_type' => [ 'news', 'post' ], 'posts_per_page' => 5 ] );
      if ( $posts ) :
        foreach ( $posts as $post ) :
      ?>
      <li class="news-item">
        <a href="<?php echo esc_url( get_permalink( $post ) ); ?>">
          <span class="news-date"><?php echo get_the_date( 'Y.m.d', $post ); ?></span>
          <span class="news-title"><?->post_title ); ?></span>
        </a>
      </li>
      <?php
        endforeach;
      else :
      ?>
      <li class="news-item"><span class="news-date">-</span><span class="news-title">お知らせはまだありません</span></li>
      <?php endif; ?>
    </ul>
    <div class="btn-wrap">
      <a href="<?php echo esc_url( home_url( '/grouphome/news/' ) ); ?>" class="btn-secondary">一覧を見る</a>
    </div>
  </div>
</section>
