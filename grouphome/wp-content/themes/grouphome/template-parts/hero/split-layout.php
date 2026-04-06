<section id="l-hero__wrapper">
  <div class="hero-left">
    <div class="hero-content">
      <p class="hero-eyebrow"><?php echo esc_html( grouphome_site_display_name() ); ?>・大阪市西成区</p>
      <h1 class="hero-catch">
        みんなが家族になれるように。<br>みんなが笑顔になれるように。
      </h1>
      <p class="hero-sub">私たちは誰もが笑顔の未来を築きます。</p>
      <div class="hero-btns">
        <a href="<?php echo esc_url( home_url( '/guide/' ) ); ?>" class="btn-primary">入居のご案内</a>
        <a href="<?php echo esc_url( home_url( '/message/' ) ); ?>" class="btn-secondary">私たちの想い</a>
      </div>
      <p class="hero-tel">
        <span class="hero-tel__label">お問い合わせ</span>
        <a href="tel:<?php echo esc_attr( grouphome_phone_main_tel_digits() ); ?>" class="hero-tel__number"><?php echo esc_html( grouphome_phone_main_display() ); ?></a>
      </p>
      <p class="hero-tel hero-tel--emergency">
        <span class="hero-tel__label">緊急連絡先</span>
        <a href="tel:<?php echo esc_attr( grouphome_phone_emergency_tel_digits() ); ?>" class="hero-tel__number hero-tel__number--emergency"><?php echo esc_html( grouphome_phone_emergency_display() ); ?></a>
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
    $slides = array_values(
      array_filter(
        $slides,
        static function ( $p ) {
          return $p instanceof WP_Post && has_post_thumbnail( $p->ID );
        }
      )
    );
    $placeholder = function_exists( 'grouphome_theme_photo_placeholder_url' ) ? grouphome_theme_photo_placeholder_url() : '';
    ?>
    <?php if ( $slides ) : ?>
    <div class="hero-slider" id="heroSlider">
      <?php foreach ( $slides as $slide ) : ?>
      <div class="hero-slide">
        <?php echo get_the_post_thumbnail( $slide->ID, 'full', [ 'alt' => esc_attr( $slide->post_title ) ] ); ?>
      </div>
      <?php endforeach; ?>
    </div>
    <?php elseif ( $placeholder ) : ?>
    <div class="hero-slider" id="heroSlider">
      <div class="hero-slide">
        <img src="<?php echo esc_url( $placeholder ); ?>" alt="" width="1200" height="750" loading="eager" decoding="async" />
      </div>
    </div>
    <?php endif; ?>
    <div class="hero-scroll-hint">
      <span>SCROLL</span>
      <div class="hero-scroll-hint__line"></div>
    </div>
  </div>
</section>
