<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<header id="l-header">
  <div class="l-header__wrapper">
    <div class="l-header__inner">
      <div class="logo">
        <?php the_custom_logo(); ?>
      </div>
      <nav class="global-nav">
        <?php wp_nav_menu( [ 'theme_location' => 'global_nav', 'container' => false ] ); ?>
      </nav>
      <div class="header-cta">
        <a href="tel:<?php echo esc_attr( get_field( 'tel' ) ); ?>" class="tel">
          <?php echo esc_html( get_field( 'tel' ) ); ?>
        </a>
        <a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="btn-cta">ご相談はこちら</a>
      </div>
    </div>
  </div>
</header>
