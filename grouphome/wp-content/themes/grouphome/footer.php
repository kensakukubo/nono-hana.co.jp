<?php get_template_part( 'template-parts/common/floating-cta' ); ?>
<?php get_template_part( 'template-parts/home/line-cta' ); ?>
<footer id="l-footer">
  <div class="footer-inner">
    <div class="footer-info">
      <p class="footer-name">障がい者グループホーム わおん花園</p>
      <p class="footer-address">〒557-0015<br>大阪府大阪市西成区花園南1-9-32</p>
      <p class="footer-tel">TEL：<a href="tel:<?php echo esc_attr( grouphome_phone_main_tel_digits() ); ?>"><?php echo esc_html( grouphome_phone_main_display() ); ?></a></p>
      <p class="footer-tel footer-tel--emergency">緊急連絡先：<a href="tel:<?php echo esc_attr( grouphome_phone_emergency_tel_digits() ); ?>"><?php echo esc_html( grouphome_phone_emergency_display() ); ?></a></p>
    </div>
    <?php if ( has_nav_menu( 'footer_nav' ) ) : ?>
    <nav class="footer-nav" aria-label="<?php echo esc_attr__( 'フッターメニュー', 'grouphome' ); ?>">
      <?php
      wp_nav_menu(
        [
          'theme_location' => 'footer_nav',
          'container'      => false,
          'fallback_cb'    => false,
        ]
      );
      ?>
    </nav>
    <?php endif; ?>
  </div>
  <p class="copyright">&copy; <?php echo date( 'Y' ); ?> 障がい者グループホーム わおん花園</p>
</footer>
<?php wp_footer(); ?>
</body>
</html>
