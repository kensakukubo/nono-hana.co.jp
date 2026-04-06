<?php get_template_part( 'template-parts/common/floating-cta' ); ?>
<?php get_template_part( 'template-parts/home/line-cta' ); ?>
<footer id="l-footer">
  <div class="footer-inner">
    <div class="footer-brand">
      <p class="footer-name"><?php echo esc_html( grouphome_site_display_name() ); ?></p>
      <p class="footer-address">〒557-0015<br>大阪府大阪市西成区花園南1-9-32</p>
      <p class="footer-tel">TEL：<a href="tel:<?php echo esc_attr( grouphome_phone_main_tel_digits() ); ?>"><?php echo esc_html( grouphome_phone_main_display() ); ?></a></p>
      <p class="footer-tel footer-tel--emergency">緊急連絡先：<a href="tel:<?php echo esc_attr( grouphome_phone_emergency_tel_digits() ); ?>"><?php echo esc_html( grouphome_phone_emergency_display() ); ?></a></p>
      <p class="footer-home-link"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">トップページ</a></p>
    </div>
    <?php if ( function_exists( 'grouphome_get_footer_sitemap_groups' ) ) : ?>
    <nav class="footer-sitemap" aria-label="<?php echo esc_attr__( 'サイト内の主要ページ', 'grouphome' ); ?>">
      <div class="footer-sitemap__grid">
        <?php foreach ( grouphome_get_footer_sitemap_groups() as $fsg_i => $group ) : ?>
          <?php if ( empty( $group['links'] ) || ! is_array( $group['links'] ) ) : ?>
            <?php continue; ?>
          <?php endif; ?>
          <?php $fsg_hid = 'footer-sitemap-h-' . (int) $fsg_i; ?>
        <div class="footer-sitemap__col">
          <h2 class="footer-sitemap__heading" id="<?php echo esc_attr( $fsg_hid ); ?>"><?php echo esc_html( (string) ( $group['heading'] ?? '' ) ); ?></h2>
          <ul class="footer-sitemap__list" aria-labelledby="<?php echo esc_attr( $fsg_hid ); ?>">
            <?php foreach ( $group['links'] as $item ) : ?>
              <?php
              $t = isset( $item['text'] ) ? (string) $item['text'] : '';
              $u = isset( $item['url'] ) ? (string) $item['url'] : '';
              if ( $t === '' || $u === '' ) {
                continue;
              }
              ?>
            <li><a href="<?php echo esc_url( $u ); ?>"><?php echo esc_html( $t ); ?></a></li>
            <?php endforeach; ?>
          </ul>
        </div>
        <?php endforeach; ?>
      </div>
    </nav>
    <?php endif; ?>
  </div>
  <?php if ( has_nav_menu( 'footer_nav' ) ) : ?>
  <div class="footer-nav-wrap">
    <nav class="footer-nav" aria-label="<?php echo esc_attr__( '追加メニュー', 'grouphome' ); ?>">
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
  </div>
  <?php endif; ?>
  <p class="copyright">&copy; <?php echo date( 'Y' ); ?> <?php echo esc_html( grouphome_site_display_name() ); ?></p>
</footer>
<?php wp_footer(); ?>
</body>
</html>
