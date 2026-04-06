<?php /* Template Name: 会社概要 */ ?>
<?php get_header(); ?>
<main class="l-page l-page--company">
  <div class="page-hero">
    <div class="page-hero__inner">
      <h1 class="page-hero__title">会社概要</h1>
      <p class="page-hero__sub">COMPANY</p>
    </div>
  </div>

  <div class="w-inner">
    <?php if ( have_posts() ) : ?>
      <?php while ( have_posts() ) : the_post(); ?>
    <article <?php post_class(); ?>>
      <div class="page-content">

        <section class="guide-section">
          <div class="section-heading">
            <h2>会社概要</h2>
            <p class="section-heading__sub">COMPANY</p>
            <div class="section-heading__line"></div>
          </div>
          <table class="guide-table">
            <tbody>
              <tr><th>会社名</th><td>株式会社野の花</td></tr>
              <tr><th>事業所名</th><td><?php echo esc_html( grouphome_site_display_name() ); ?></td></tr>
              <tr><th>代表取締役</th><td>窪 萬利子</td></tr>
              <tr><th>所在地</th><td>〒557-0015<br>大阪府大阪市西成区花園南1-9-32</td></tr>
              <tr><th>電話番号</th><td><a href="tel:<?php echo esc_attr( grouphome_phone_main_tel_digits() ); ?>"><?php echo esc_html( grouphome_phone_main_display() ); ?></a></td></tr>
              <tr><th>緊急連絡先</th><td><a href="tel:<?php echo esc_attr( grouphome_phone_emergency_tel_digits() ); ?>"><?php echo esc_html( grouphome_phone_emergency_display() ); ?></a></td></tr>
              <tr><th>事業内容</th><td>ペット共生型グループホームの運営</td></tr>
              <tr><th>関連事業</th><td>訪問看護ステーション野の花</td></tr>
            </tbody>
          </table>
        </section>

        <div class="l-page-back">
          <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn-secondary">トップページへ戻る</a>
        </div>

      </div>
    </article>
      <?php endwhile; ?>
    <?php endif; ?>
  </div>
</main>
<?php get_footer(); ?>
