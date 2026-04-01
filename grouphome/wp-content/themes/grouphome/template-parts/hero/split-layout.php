<section id="l-hero__wrapper">
  <div class="hero-left">
    <div class="hero-content">
      <p class="hero-eyebrow">障がい者グループホーム・大阪市西成区</p>
      <h1 class="hero-catch">
        みんなが家族に<br>なれるように。<br>みんなが笑顔に<br>なれるように。
      </h1>
      <p class="hero-sub">私たちは誰もが笑顔の未来を築きます。</p>
      <div class="hero-btns">
        <a href="<?php echo esc_url( home_url( '/grouphome/guide/' ) ); ?>" class="btn-primary">入居のご案内</a>
        <a href="<?php echo esc_url( home_url( '/grouphome/message/' ) ); ?>" class="btn-secondary">私たちの想い</a>
      </div>
      <p class="hero-tel">
        <span class="hero-tel__label">お問い合わせ</span>
        <a href="tel:0643938474" class="hero-tel__number">06-4393-8474</a>
      </p>
    </div>
  </div>
  <div class="hero-right">
    <?php
    $slides = get_posts( [
      'post_type'      => 'hero_slide',
      'posts_per_page' => 5,
      'orderby'        => 'menu_order',
      'order'          => 'ASC',
    ] );
    if ( $slides ) :
    ?>
    <div class="hero-slider" id="heroSlider">
      <?php foreach ( $slides as $slide ) : ?>
      <div class="hero-slide">
        <?php echo get_the_post_thumbnail( $slide->ID, 'full', [ 'alt' => esc_attr( $slide->post_title ) ] ); ?>
      </div>
      <?php endforeach; ?>
    </div>
    <?php endif; ?>
    <div class="hero-scroll-hint">
      <span>SCROLL</span>
      <div class="hero-scroll-hint__line"></div>
    </div>
  </div>
</section>