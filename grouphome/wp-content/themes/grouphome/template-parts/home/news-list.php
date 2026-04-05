<section id="news">
  <div class="w-inner">
    <div class="section-heading">
      <h2>お知らせ・コラム</h2>
      <p class="section-heading__sub">TOPICS</p>
      <div class="section-heading__line"></div>
    </div>
    <ul class="news-list">
      <?php
      $args = array(
        'post_type'      => array( 'news', 'post' ),
        'posts_per_page' => 5,
      );
      $posts = get_posts( $args );
      if ( $posts ) {
        foreach ( $posts as $item ) {
          echo '<li class="news-item">';
          echo '<a href="' . esc_url( get_permalink( $item->ID ) ) . '">';
          echo '<span class="news-date">' . esc_html( get_the_date( 'Y.m.d', $item->ID ) ) . '</span>';
          echo '<span class="news-title">' . esc_html( $item->post_title ) . '</span>';
          echo '</a></li>';
        }
      } else {
        echo '<li class="news-item"><span class="news-date">-</span><span class="news-title">お知らせはまだありません</span></li>';
      }
      ?>
    </ul>
    <div class="btn-wrap">
      <a href="<?php echo esc_url( home_url( '/news/' ) ); ?>" class="btn-secondary">一覧を見る</a>
    </div>
  </div>
</section>
