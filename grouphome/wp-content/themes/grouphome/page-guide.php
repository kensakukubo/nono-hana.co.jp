<?php /* Template Name: 入居のご案内 */ ?>
<?php get_header(); ?>
<main class="l-page l-page--guide">
  <div class="page-hero">
    <div class="page-hero__inner">
      <h1 class="page-hero__title">入居のご案内</h1>
      <p class="page-hero__sub">SERVICE</p>
    </div>
  </div>

  <div class="page-anchors">
    <div class="w-inner">
      <ul class="page-anchors__list">
        <li><a href="#step">入居の流れ</a></li>
        <li><a href="#schedule">1日の生活の流れ</a></li>
        <li><a href="#support">主なサポート</a></li>
      </ul>
    </div>
  </div>

  <div class="w-inner">
    <?php if ( have_posts() ) : ?>
      <?php while ( have_posts() ) : the_post(); ?>
    <article <?php post_class(); ?>>
      <div class="page-content">

        <section class="guide-section" id="step">
          <div class="section-heading">
            <h2>入居の流れ</h2>
            <p class="section-heading__sub">STEP</p>
            <div class="section-heading__line"></div>
          </div>
          <ol class="guide-steps">

            <li class="guide-step">
              <div class="guide-step__left">
                <div class="guide-step__icon">
                  <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path fill="currentColor" d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/></svg>
                </div>
                <p class="guide-step__num">STEP1</p>
                <h3>お問い合わせ</h3>
              </div>
              <div class="guide-step__right">
                <p>入居について不明な点やわからない事があれば、電話やメールにてお気軽にお問い合わせください。</p>
              </div>
            </li>

            <li class="guide-step-arrow" aria-hidden="true"><span class="guide-step__arrow">&#8964;</span></li>

            <li class="guide-step">
              <div class="guide-step__left">
                <div class="guide-step__icon">
                  <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path fill="currentColor" d="M12 3L2 12h3v8h6v-6h2v6h6v-8h3L12 3z"/></svg>
                </div>
                <p class="guide-step__num">STEP2</p>
                <h3>グループホーム見学</h3>
              </div>
              <div class="guide-step__right">
                <p>グループホームがどのような場所なのか一度ご見学いただきます。実際に入居者様が生活している場をご覧いただくことで、入居後の具体的なイメージが湧くでしょう。</p>
              </div>
            </li>

            <li class="guide-step-arrow" aria-hidden="true"><span class="guide-step__arrow">&#8964;</span></li>

            <li class="guide-step">
              <div class="guide-step__left">
                <div class="guide-step__icon">
                  <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path fill="currentColor" d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/></svg>
                </div>
                <p class="guide-step__num">STEP3</p>
                <h3>ヒアリング・面談</h3>
              </div>
              <div class="guide-step__right">
                <p>ご本人やご家族の方と直接面談させていただき、現在の状況等をお伺いします。安全面などから実際に入居が可能かどうかの確認を行います。</p>
              </div>
            </li>

            <li class="guide-step-arrow" aria-hidden="true"><span class="guide-step__arrow">&#8964;</span></li>

            <li class="guide-step">
              <div class="guide-step__left">
                <div class="guide-step__icon">
                  <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path fill="currentColor" d="M7 13c1.66 0 3-1.34 3-3S8.66 7 7 7s-3 1.34-3 3 1.34 3 3 3zm12-6h-8v7H3V7H1v13h2v-2h18v2h2v-8c0-2.21-1.79-4-4-4z"/></svg>
                </div>
                <p class="guide-step__num">STEP4</p>
                <h3>体験入居</h3>
              </div>
              <div class="guide-step__right">
                <p>グループホームがどういった所なのか実際に一泊し、体験していただきます。夕食や朝食も召し上がっていただきます。体験入居を通して、ここで生活していけるかを判断していただきます。</p>
              </div>
            </li>

            <li class="guide-step-arrow" aria-hidden="true"><span class="guide-step__arrow">&#8964;</span></li>

            <li class="guide-step">
              <div class="guide-step__left">
                <div class="guide-step__icon">
                  <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path fill="currentColor" d="M14 2H6c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V8l-6-6zm4 18H6V4h7v5h5v11zm-2-6H8v-2h8v2zm0-4H8V8h8v4z"/></svg>
                </div>
                <p class="guide-step__num">STEP5</p>
                <h3>市町村への申請</h3>
              </div>
              <div class="guide-step__right">
                <p>ご入居には「障がい福祉サービス受給者証」が必要となります。ご本人が直接申請していただく必要があります。</p>
              </div>
            </li>

            <li class="guide-step-arrow" aria-hidden="true"><span class="guide-step__arrow">&#8964;</span></li>

            <li class="guide-step">
              <div class="guide-step__left">
                <div class="guide-step__icon">
                  <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path fill="currentColor" d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8h5z"/></svg>
                </div>
                <p class="guide-step__num">STEP6</p>
                <h3>入居準備・入居開始</h3>
              </div>
              <div class="guide-step__right">
                <p>ご入居にあたって、確認事項、注意点などを詳しく説明させていただきます。仲間との新しい生活が始まります。</p>
              </div>
            </li>

          </ol>
        </section>

        <section class="guide-section" id="schedule">
          <div class="section-heading">
            <h2>1日の生活の流れ</h2>
            <p class="section-heading__sub">SCHEDULE</p>
            <div class="section-heading__line"></div>
          </div>
          <ul class="guide-schedule">
            <li>
              <span class="guide-schedule__time">7:00</span>
              <div class="guide-schedule__body">
                <span class="guide-schedule__label">起床</span>
                <span class="guide-schedule__text">おはようございます。今日も一日頑張りましょう！</span>
              </div>
            </li>
            <li>
              <span class="guide-schedule__time">7:30〜8:30</span>
              <div class="guide-schedule__body">
                <span class="guide-schedule__label">朝食</span>
                <span class="guide-schedule__text">朝食の支度を整えておりますので、ご準備ができた方から食堂にてお召し上がりください。</span>
              </div>
            </li>
            <li>
              <span class="guide-schedule__time">9:00</span>
              <div class="guide-schedule__body">
                <span class="guide-schedule__label">午前の日中活動</span>
                <span class="guide-schedule__text">それぞれの就労先へ移動します。就労先からのお迎え、またはご自身での移動になります。</span>
              </div>
            </li>
            <li>
              <span class="guide-schedule__time">12:00</span>
              <div class="guide-schedule__body">
                <span class="guide-schedule__label">昼食</span>
                <span class="guide-schedule__text">就労先・活動先でのお食事となります。</span>
              </div>
            </li>
            <li>
              <span class="guide-schedule__time">16:00</span>
              <div class="guide-schedule__body">
                <span class="guide-schedule__label">午後の日中活動終了</span>
                <span class="guide-schedule__text">お仕事や活動お疲れ様でした。</span>
              </div>
            </li>
            <li>
              <span class="guide-schedule__time">17:30〜18:30</span>
              <div class="guide-schedule__body">
                <span class="guide-schedule__label">夕食</span>
                <span class="guide-schedule__text">夕食はできるかぎり皆で一緒に食べます。</span>
              </div>
            </li>
            <li>
              <span class="guide-schedule__time">19:00</span>
              <div class="guide-schedule__body">
                <span class="guide-schedule__label">入浴・フリータイム</span>
                <span class="guide-schedule__text">夕食後は、それぞれ入浴や洗濯、テレビ・音楽鑑賞など自由にお過ごしいただけます。</span>
              </div>
            </li>
            <li>
              <span class="guide-schedule__time">22:00</span>
              <div class="guide-schedule__body">
                <span class="guide-schedule__label">就寝・消灯</span>
                <span class="guide-schedule__text">一日お疲れ様でした。ゆっくりお休みください。</span>
              </div>
            </li>
          </ul>
        </section>

        <section class="guide-section" id="support">
          <div class="section-heading">
            <h2>主なサポート</h2>
            <p class="section-heading__sub">SUPPORT</p>
            <div class="section-heading__line"></div>
          </div>
          <ul class="guide-support-grid" role="list">
            <li class="guide-support-tile">
              <div class="guide-support-tile__icon" aria-hidden="true">
                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path fill="currentColor" d="M12 2L4.5 20.29l.71.71L12 18l6.79 3 .71-.71L12 2z"/></svg>
              </div>
              <span class="guide-support-tile__tag">外出</span>
              <p class="guide-support-tile__text">散歩、役所、病院、買い物などの外出同行</p>
            </li>
            <li class="guide-support-tile">
              <div class="guide-support-tile__icon" aria-hidden="true">
                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path fill="currentColor" d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8h5z"/></svg>
              </div>
              <span class="guide-support-tile__tag">補助</span>
              <p class="guide-support-tile__text">食事や日常生活（掃除、洗濯、食事など含む）の補助（※介助なし）</p>
            </li>
            <li class="guide-support-tile">
              <div class="guide-support-tile__icon" aria-hidden="true">
                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path fill="currentColor" d="M8.1 13.34l2.83-2.83L3 3v2.83l5.1 5.51zM3 21h18v-2H3v2zm14-9.66l1.41-1.41 3.67 3.67L22.83 21H18v-4l-2-2v4h-2v-6h6v2l-4-4.66z"/></svg>
              </div>
              <span class="guide-support-tile__tag">調理</span>
              <p class="guide-support-tile__text">調理補助</p>
            </li>
            <li class="guide-support-tile">
              <div class="guide-support-tile__icon" aria-hidden="true">
                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path fill="currentColor" d="M11.8 10.9c-2.27-.59-3-1.2-3-2.15 0-1.09 1.01-1.85 2.7-1.85 1.78 0 2.44.85 2.5 2.1h2.21c-.07-1.72-1.12-3.3-3.21-3.81V3h-3v2.16c-1.94.42-3.5 1.68-3.5 3.61 0 2.31 1.91 3.46 4.7 4.13 2.5.6 3 1.48 3 2.41 0 .69-.49 1.79-2.7 1.79-2.06 0-2.87-.92-2.98-2.1h-2.2c.12 2.19 1.76 3.42 3.68 3.83V21h3v-2.15c1.95-.37 3.5-1.5 3.5-3.55 0-2.84-2.43-3.81-4.7-4.4z"/></svg>
              </div>
              <span class="guide-support-tile__tag">管理</span>
              <p class="guide-support-tile__text">おこづかい帳の作成を通して金銭のお手伝いもしています（希望者のみ）</p>
            </li>
            <li class="guide-support-tile">
              <div class="guide-support-tile__icon" aria-hidden="true">
                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path fill="currentColor" d="M20 2H4c-1.1 0-2 .9-2 2v18l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm0 14H6l-2 2V4h16v12z"/></svg>
              </div>
              <span class="guide-support-tile__tag">お話</span>
              <p class="guide-support-tile__text">お話相手</p>
            </li>
            <li class="guide-support-tile">
              <div class="guide-support-tile__icon" aria-hidden="true">
                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path fill="currentColor" d="M17.5 10.5c0 1.38-1.12 2.5-2.5 2.5s-2.5-1.12-2.5-2.5S13.62 8 15 8s2.5 1.12 2.5 2.5zm-9 0C8.5 11.88 7.38 13 6 13S3.5 11.88 3.5 10.5 4.62 8 6 8s2.5 1.12 2.5 2.5zM12 17c-2.61 0-4.83-1.67-5.65-4h11.3c-.82 2.33-3.04 4-5.65 4z"/></svg>
              </div>
              <span class="guide-support-tile__tag">ペット</span>
              <p class="guide-support-tile__text">ペットとのお散歩同行</p>
            </li>
          </ul>
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
