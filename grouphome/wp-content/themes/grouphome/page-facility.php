<?php get_header(); ?>
<?php if ( have_posts() ) : ?>
  <?php while ( have_posts() ) : the_post(); ?>
<main class="l-page l-page--facility">
  <div class="w-inner">
    <h1 class="l-page__title">施設紹介</h1>
    <p class="l-page__sub">FACILITY</p>

    <article <?php post_class(); ?>>
      <div class="page-content">

        <section class="facility-intro">
          <p>駅にも近く生活に大変便利な環境の中で、自分らしくのびのびとした毎日を送ることができます。</p>
        </section>

        <section class="facility-info">
          <h2 class="guide-section__title">施設概要</h2>
          <table class="guide-table">
            <tbody>
              <tr><th>名称</th><td>障がい者グループホーム わおん花園</td></tr>
              <tr><th>所在地</th><td>〒557-0015 大阪府大阪市西成区花園南1-9-32</td></tr>
              <tr><th>電話番号</th><td><a href="tel:0643938474">06-4393-8474</a></td></tr>
              <tr><th>定員</th><td>応相談</td></tr>
              <tr><th>タイプ</th><td>戸建てタイプ</td></tr>
              <tr><th>備考</th><td>※同居のペットとして犬がいます。</td></tr>
            </tbody>
          </table>
        </section>

        <section class="facility-features">
          <h2 class="guide-section__title">施設の特徴</h2>
          <ul class="guide-support">
            <li>全室鍵付きのプライベート個室</li>
            <li>夜間・休日も世話人が常駐</li>
            <li>各個室にテレビ、ベッド、テーブルなどの家具・家電を設置済み</li>
            <li>無料Wi-Fiあり</li>
            <li>冷暖房完備</li>
            <li>高速インターネット</li>
            <li>リビングルームに液晶テレビ設置（共用）</li>
            <li>カメラ付きインターフォンあり</li>
            <li>屋外に喫煙スペースあり</li>
          </ul>
        </section>

        <section class="facility-map">
          <h2 class="guide-section__title">アクセス</h2>
          <p>大阪府大阪市西成区花園南1-9-32</p>
          <div class="facility-map__embed">
            <iframe
              title="障がい者グループホーム わおん花園の地図"
              src="https://maps.google.com/maps?q=<?php echo rawurlencode( '〒557-0015 大阪府大阪市西成区花園南1-9-32' ); ?>&hl=ja&z=16&output=embed"
              width="600"
              height="350"
              loading="lazy"
              referrerpolicy="no-referrer-when-downgrade"
              allowfullscreen="">
            </iframe>
          </div>
        </section>

        <div class="l-page-back">
          <a href="<?php echo esc_url( home_url( '/grouphome/' ) ); ?>" class="btn-secondary">トップページへ戻る</a>
        </div>

      </div>
    </article>
  </div>
</main>
  <?php endwhile; ?>
<?php endif; ?>
<?php get_footer(); ?>
