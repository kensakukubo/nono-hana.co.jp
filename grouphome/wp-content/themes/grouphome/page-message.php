<?php /* Template Name: 私たちの想い */ ?>
<?php get_header(); ?>
<main class="l-page l-page--company l-page--message">
  <div class="page-hero">
    <div class="page-hero__inner">
      <h1 class="page-hero__title">私たちの想い</h1>
      <p class="page-hero__sub">MESSAGE</p>
    </div>
  </div>

  <div class="w-inner">
    <?php if ( have_posts() ) : ?>
      <?php while ( have_posts() ) : the_post(); ?>
    <article <?php post_class(); ?>>
      <div class="page-content">

        <section class="guide-section">
          <div class="section-heading">
            <h2>みんなが家族になれるように。<br>みんなが笑顔になれるように。</h2>
            <p class="section-heading__sub">MESSAGE</p>
            <div class="section-heading__line"></div>
          </div>
          <div class="message-text">
            <p>ペット共生型グループホーム わおんは、障がいのある方が地域の中で安心して、自分らしく暮らせる住まいです。</p>
            <p>私たちは入居者様を「お客様」ではなく、ホームで共に暮らす家族の一員としてお迎えしています。</p>
          </div>
        </section>

        <section class="guide-section">
          <div class="section-heading">
            <h2>自分だけの時間を大切にする、鍵付きの完全個室</h2>
            <p class="section-heading__sub">PRIVATE ROOM</p>
            <div class="section-heading__line"></div>
          </div>
          <div class="message-text">
            <p>全室に鍵が付いた完全個室です。家具・家電を備え付けているので、入居したその日から、自分のペースで過ごせます。</p>
            <p>Wi-Fiも整えていますので、ひとりの時間も気兼ねなくお過ごしください。</p>
          </div>
        </section>

        <section class="guide-section">
          <div class="section-heading">
            <h2>ごはんは、できるだけみんなで</h2>
            <p class="section-heading__sub">TOGETHER</p>
            <div class="section-heading__line"></div>
          </div>
          <div class="message-text">
            <p>プライベートを大切にする一方で、食事はできるだけ共用スペースでとっていただいています。</p>
            <p>同じテーブルを囲み、入居者同士や世話人と何気ない会話を重ねることが、毎日の安心につながると考えているからです。</p>
            <p>困っていることや不安なことも、リビングでの雑談の中から自然に打ち明けていただけるよう心がけています。</p>
          </div>
        </section>

        <section class="guide-section">
          <div class="section-heading">
            <h2>犬や猫が、暮らしの仲間</h2>
            <p class="section-heading__sub">DOGS &amp; CATS</p>
            <div class="section-heading__line"></div>
          </div>
          <div class="message-text">
            <p>わおんでは、犬や猫も入居者の皆さんと一緒に暮らす仲間です。</p>
            <p>3つのホームはどれも近くにあるので、犬や猫がいないホームにも、犬が遊びに来てくれます。</p>
            <p>撫でたり、そばで過ごしたりする時間が、日々の暮らしにやすらぎを与えてくれます。</p>
            <p>保護犬・保護猫の新しい居場所づくりにも取り組んでいます。</p>
          </div>
        </section>

        <section class="guide-section">
          <div class="section-heading">
            <h2>好きなことが続けられる暮らし</h2>
            <p class="section-heading__sub">HOBBY</p>
            <div class="section-heading__line"></div>
          </div>
          <div class="message-text">
            <p>共用スペースでは料理をすることもでき、本棚の漫画を読んだりと、趣味の時間も楽しめます。</p>
            <p>本棚は入居者の皆さんのリクエストに応えて置いたものです。</p>
            <p>ピアノのあるホームには、ほかのホームからも気軽に弾きに行けます。近くにある3拠点だからこそ、ホームの垣根をこえて好きなことを続けられます。</p>
            <p>「こんなことがしたい」という声を、これからも暮らしに取り入れていきます。</p>
            <p>誕生会や忘年会、クリスマス会など、季節の行事もみんなで楽しんでいます。</p>
          </div>
        </section>

        <section class="guide-section">
          <div class="section-heading">
            <h2>安心して暮らし続けるために</h2>
            <p class="section-heading__sub">SUPPORT</p>
            <div class="section-heading__line"></div>
          </div>
          <div class="message-text">
            <p>スタッフが24時間常駐し、お薬の管理は主治医や訪問看護と連携して行います。</p>
            <p>日中の活動先探しや、ご家族のご相談にも一緒に向き合います。</p>
            <p>入居者様だけでなく、ご家族にも安心していただけるホームであり続けたいと考えています。</p>
          </div>
        </section>

        <div class="l-page-back l-page-back--dual">
          <a href="<?php echo esc_url( home_url( '/guide/' ) ); ?>" class="btn-primary">入居のご案内</a>
          <a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="btn-secondary">お問い合わせ</a>
        </div>

      </div>
    </article>
      <?php endwhile; ?>
    <?php endif; ?>
  </div>
</main>
<?php get_footer(); ?>
