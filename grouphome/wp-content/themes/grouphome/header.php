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
      <a href="<?php echo esc_url( home_url('/grouphome/') ); ?>" class="site-name">障がい者グループホーム わおん花園</a>
      <?php endif; ?>
    </div>
    <nav class="global-nav">
      <?php wp_nav_menu( [ 'theme_location' => 'global_nav', 'container' => false ] ); ?>
    </nav>
    <div class="header-cta">
      <a href="tel:0643938474" class="tel">06-4393-8474</a>
      <a href="<?php echo esc_url( home_url( '/grouphome/contact/' ) ); ?>" class="btn-cta">ご相談はこちら</a>
    </div>
  </div>
</header>
