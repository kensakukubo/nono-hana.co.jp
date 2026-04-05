<?php /* Template Name: 採用情報 */ ?>
<?php get_header(); ?>
<main class="l-page l-page--recruit">
  <div class="page-hero">
    <div class="page-hero__inner">
      <h1 class="page-hero__title">採用情報</h1>
      <p class="page-hero__sub">RECRUIT</p>
    </div>
  </div>

  <div class="w-inner">
    <?php if ( have_posts() ) : ?>
      <?php while ( have_posts() ) : the_post(); ?>
    <article <?php post_class(); ?>>
      <div class="page-content">

        <section class="guide-section">
          <div class="recruit-lead">
            <div class="recruit-lead__photo">
              <div class="guide-step__photo guide-step__photo--recruit" aria-hidden="true"></div>
            </div>
            <div class="recruit-lead__text">
              <h2>明るい方そして元気な方、<br>グループホームで一緒に働いてみませんか？</h2>
              <p>障がい者グループホーム「わおん花園」では、一緒に働く方を募集しています。あなたがお持ちの資格、ご経験を生かして、スタッフ、入居者様とそのご家族のみなさまが心地よい場所をつくっていきましょう。</p>
            </div>
          </div>
        </section>

        <section class="guide-section">
          <div class="section-heading">
            <h2>募集要項</h2>
            <p class="section-heading__sub">REQUIREMENTS</p>
            <div class="section-heading__line"></div>
          </div>

          <div class="recruit-jobs">

            <div class="recruit-job">
              <h3 class="recruit-job__title">世話人・パート</h3>
              <table class="guide-table">
                <tbody>
                  <tr><th>仕事内容</th><td>入居者様の生活支援（食事・入浴・外出同行など）</td></tr>
                  <tr><th>雇用形態</th><td>パートタイム</td></tr>
                  <tr><th>勤務地</th><td>大阪府大阪市西成区花園南1-9-32</td></tr>
                  <tr><th>勤務時間</th><td>シフト制（応相談）</td></tr>
                  <tr><th>資格・経験</th><td>不問（未経験者歓迎）</td></tr>
                  <tr><th>待遇</th><td>社会保険完備・交通費支給</td></tr>
                </tbody>
              </table>
            </div>

            <div class="recruit-job">
              <h3 class="recruit-job__title">夜間支援員・パート</h3>
              <table class="guide-table">
                <tbody>
                  <tr><th>仕事内容</th><td>夜間における入居者様の緊急時対応・見守り</td></tr>
                  <tr><th>雇用形態</th><td>パートタイム</td></tr>
                  <tr><th>勤務地</th><td>大阪府大阪市西成区花園南1-9-32</td></tr>
                  <tr><th>勤務時間</th><td>22:00〜翌9:00（宿泊勤務）</td></tr>
                  <tr><th>資格・経験</th><td>不問（未経験者歓迎）</td></tr>
                  <tr><th>待遇</th><td>社会保険完備・交通費支給</td></tr>
                </tbody>
              </table>
            </div>

          </div>
        </section>

        <section class="guide-section recruit-entry">
          <div class="section-heading">
            <h2>採用エントリー</h2>
            <p class="section-heading__sub">ENTRY</p>
            <div class="section-heading__line"></div>
          </div>
          <p class="recruit-entry__lead">ご応募はお電話またはお問い合わせフォームよりお気軽にどうぞ。</p>
          <div class="recruit-entry__actions">
            <a href="tel:<?php echo esc_attr( grouphome_phone_main_tel_digits() ); ?>" class="btn-primary btn-primary--lg"><?php echo esc_html( grouphome_phone_main_display() ); ?></a>
            <a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="btn-secondary btn-secondary--lg">お問い合わせフォーム</a>
          </div>
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
