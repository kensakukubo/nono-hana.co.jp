<section class="recruit-section">
  <div class="w-inner">
    <div class="recruit-inner">
      <div class="recruit-text">
        <div class="section-heading section-heading--left">
          <h2>採用情報</h2>
          <p class="section-heading__sub">RECRUIT</p>
          <div class="section-heading__line"></div>
        </div>
        <p class="recruit-text__lead">入居者様が充実した毎日を送れるよう、様々な方面からサポートするお仕事です。明るく、働きやすい職場を作っていきませんか？</p>
        <div class="recruit-links">
          <a href="<?php echo esc_url( home_url( '/recruit/' ) ); ?>" class="btn-secondary">採用について</a>
          <a href="<?php echo esc_url( home_url( '/recruit-faq/' ) ); ?>" class="btn-secondary">採用のよくある質問</a>
        </div>
      </div>
      <div class="recruit-photo">
        <?php
        $recruit_img = get_template_directory_uri() . '/assets/images/recruit.jpg';
        if ( function_exists( 'grouphome_theme_photo_placeholder_url' ) ) {
          $recruit_path = path_join( get_template_directory(), 'assets/images/recruit.jpg' );
          if ( ! is_string( $recruit_path ) || ! file_exists( $recruit_path ) ) {
            $recruit_img = grouphome_theme_photo_placeholder_url();
          }
        }
        ?>
        <img src="<?php echo esc_url( $recruit_img ); ?>" alt="採用情報" loading="lazy" decoding="async" width="1200" height="750" />
      </div>
    </div>
  </div>
</section>
