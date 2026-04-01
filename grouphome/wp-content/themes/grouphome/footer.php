<?php get_template_part( 'template-parts/common/floating-cta' ); ?>
<?php get_template_part( 'template-parts/home/line-cta' ); ?>
<footer id="l-footer">
  <div class="footer-inner">
    <div class="footer-info">
      <p class="footer-name">障がい者グループホーム わおん花園</p>
      <p class="footer-address">〒557-0015<br>大阪府大阪市西成区花園南1-9-32</p>
      <p class="footer-tel">TEL：<a href="tel:0643938474">06-4393-8474</a></p>
    </div>
    <nav class="footer-nav">
      <?php wp_nav_menu( [ 'theme_location' => 'footer_nav', 'container' => false ] ); ?>
    </nav>
  </div>
  <p class="copyright">&copy; <?php echo date( 'Y' ); ?> 障がい者グループホーム わおん花園</p>
</footer>
<?php wp_footer(); ?>
</body>
</html>
