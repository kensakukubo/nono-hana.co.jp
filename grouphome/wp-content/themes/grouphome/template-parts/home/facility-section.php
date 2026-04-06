<?php
$facility_rel = '2026/04/名称未設定のデザイン-24.png';
$facility_section_img = '';
if ( function_exists( 'grouphome_uploads_public_url' ) && function_exists( 'grouphome_uploads_file_exists_relative' )
	&& grouphome_uploads_file_exists_relative( $facility_rel ) ) {
	$facility_section_img = grouphome_uploads_public_url( $facility_rel );
}
if ( $facility_section_img === '' && function_exists( 'grouphome_theme_photo_placeholder_url' ) ) {
	$facility_section_img = grouphome_theme_photo_placeholder_url();
}
?>
<section class="facility-section">
  <div class="w-inner">
    <div class="facility-inner">
      <div class="facility-text">
        <div class="section-heading section-heading--left">
          <h2>施設紹介</h2>
          <p class="section-heading__sub">FACILITY INFORMATION</p>
          <div class="section-heading__line"></div>
        </div>
        <p class="facility-text__lead">各拠点の設備・生活のイメージをご紹介します。プライバシーに配慮した個室と、安心のサポート体制です。</p>
        <div class="btn-wrap btn-wrap--left">
          <a href="<?php echo esc_url( home_url( '/facility/' ) ); ?>" class="btn-secondary">拠点を選ぶ</a>
        </div>
      </div>
      <div class="facility-photo">
        <?php if ( $facility_section_img ) : ?>
        <img
          src="<?php echo esc_url( $facility_section_img ); ?>"
          alt="グループホームの施設の様子"
          loading="lazy"
          decoding="async"
        />
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>
