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
  <div class="l-header__inner">
    <div class="logo">
      <?php the_custom_logo(); ?>
      <?php if ( ! has_custom_logo() ) : ?>
      <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="site-name"><?php echo esc_html( grouphome_site_display_name() ); ?></a>
      <?php endif; ?>
    </div>
    <nav class="global-nav" id="primary-navigation" aria-label="<?php echo esc_attr__( 'メインメニュー', 'grouphome' ); ?>">
      <?php wp_nav_menu( [ 'theme_location' => 'global_nav', 'container' => false ] ); ?>
    </nav>
    <div class="header-cta">
      <a href="tel:<?php echo esc_attr( grouphome_phone_main_tel_digits() ); ?>" class="tel"><?php echo esc_html( grouphome_phone_main_display() ); ?></a>
      <a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="btn-cta">ご相談はこちら</a>
    </div>
    <button type="button" class="menu-toggle" id="menuToggle" aria-expanded="false" aria-controls="primary-navigation" aria-label="<?php echo esc_attr__( 'メニューを開閉', 'grouphome' ); ?>">
      <span class="menu-toggle__bar" aria-hidden="true"></span>
      <span class="menu-toggle__bar" aria-hidden="true"></span>
      <span class="menu-toggle__bar" aria-hidden="true"></span>
    </button>
  </div>
  <div class="menu-backdrop" id="menuBackdrop" hidden aria-hidden="true"></div>
</header>
