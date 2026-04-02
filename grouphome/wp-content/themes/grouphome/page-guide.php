<?php get_header(); ?>
<?php if ( have_posts() ) : ?>
  <?php while ( have_posts() ) : the_post(); ?>
<main class="l-page l-page--guide">
  <div class="w-inner">
    <h1 class="l-page__title">入居のご案内</h1>
    <p class="l-page__sub">SERVICE</p>

    <article <?php post_class(); ?>>
      <div class="page-content">

        <section class="guide-section">
          <h2 class="guide-section__title">入居の流れ <span>STEP</span></h2>
          <ol class="guide-steps">
            <li class="guide-step">
              <div class="guide-step__num">STEP 1</div>
              <div class="guide-step__body">
                <h3>お問い合わせ</h3>
                <p>入居について不明な点やわからない事があれば、電話やメールにてお気軽にお問い合わせください。</p>
              </div>
            </li>
            <li class="guide-step">
              <div class="guide-step__num">STEP 2</div>
              <div class="guide-step__body">
                <h3>グループホーム見学</h3>
                <p>グループホームがどのような場所なのか一度ご見学いただきます。実際に入居者様が生活している場をご覧いただくことで、入居後の具体的なイメージが湧くでしょう。</p>
              </div>
            </li>
            <li class="guide-step">
              <div class="guide-step__num">STEP 3</div>
              <div class="guide-step__body">
                <h3>ヒアリング・面談</h3>
                <p>ご本人やご家族の方と直接面談させていただき、現在の状況等をお伺いします。安全面などから実際に入居が可能かどうかの確認を行います。</p>
              </div>
            </li>
            <li class="guide-step">
              <div class="guide-step__num">STEP 4</div>
              <div class="guide-step__body">
                <h3>体験入居</h3>
                <p>グループホームがどういった所なのか実際に一泊し、体験していただきます。夕食や朝食も召し上がっていただきます。体験入居を通して、ここで生活していけるかを判断していただきます。</p>
              </div>
            </li>
            <li class="guide-step">
              <div class="guide-step__num">STEP 5</div>
              <div class="guide-step__body">
                <h3>市町村への申請</h3>
                <p>ご入居には「障がい福祉サービス受給者証」が必要となります。ご本人が直接申請していただく必要があります。</p>
              </div>
            </li>
            <li class="guide-step">
              <div class="guide-step__num">STEP 6</div>
              <div class="guide-step__body">
                <h3>入居準備・入居開始</h3>
                <p>ご入居にあたって、確認事項、注意点などを詳しく説明させていただきます。仲間との新しい生活が始まります。</p>
              </div>
            </li>
          </ol>
        </section>

        <section class="guide-section">
          <h2 class="guide-section__title">1日の生活の流れ <span>SCHEDULE</span></h2>
          <ul class="guide-schedule">
            <li><span class="guide-schedule__time">7:00</span><span class="guide-schedule__label">起床</span><span class="guide-schedule__text">おはようございます。今日も一日頑張りましょう！</span></li>
            <li><span class="guide-schedule__time">7:30〜8:30</span><span class="guide-schedule__label">朝食</span><span class="guide-schedule__text">朝食の支度を整えておりますので、ご準備ができた方から食堂にてお召し上がりください。</span></li>
            <li><span class="guide-schedule__time">9:00</span><span class="guide-schedule__label">午前の日中活動</span><span class="guide-schedule__text">それぞれの就労先へ移動します。就労先からのお迎え、またはご自身での移動になります。</span></li>
            <li><span class="guide-schedule__time">12:00</span><span class="guide-schedule__label">昼食</span><span class="guide-schedule__text">就労先・活動先でのお食事となります。</span></li>
            <li><span class="guide-schedule__time">16:00</span><span class="guide-schedule__label">午後の日中活動終了</span><span class="guide-schedule__text">お仕事や活動お疲れ様でした。</span></li>
            <li><span class="guide-schedule__time">17:30〜18:30</span><span class="guide-schedule__label">夕食</span><span class="guide-schedule__text">夕食の支度を整えております。それぞれご準備ができた方から食堂にてお召し上がりください。</span></li>
            <li><span class="guide-schedule__time">19:00</span><span class="guide-schedule__label">入浴・フリータイム</span><span class="guide-schedule__text">夕食後は、それぞれ入浴や洗濯、テレビ・音楽鑑賞など自由にお過ごしいただけます。</span></li>
            <li><span class="guide-schedule__time">22:00</span><span class="guide-schedule__label">就寝・消灯</span><span class="guide-schedule__text">一日お疲れ様でした。ゆっくりお休みください。</span></li>
          </ul>
        </section>

        <section class="guide-section">
          <h2 class="guide-section__title">主なサポート <span>SUPPORT</span></h2>
          <ul class="guide-support">
            <li>散歩、役所、病院、買い物などの外出同行</li>
            <li>食事や日常生活（掃除・洗濯・食事など）の補助 ※介助なし</li>
            <li>調理補助</li>
            <li>庭仕事の手伝い</li>
            <li>おこづかい帳作成を通して金銭のお手伝い（希望者のみ）</li>
            <li>お話相手</li>
            <li>ペットとのお散歩同行</li>
          </ul>
        </section>

        <section class="guide-section">
          <h2 class="guide-section__title">料金体系 <span>PRICE</span></h2>
          <table class="guide-table">
            <tbody>
              <tr><th>家賃</th><td>39,000円/月</td></tr>
              <tr><th>食費</th><td>27,000円/月</td></tr>
              <tr><th>水道光熱費</th><td>実費でのご精算</td></tr>
              <tr><th>日用品費</th><td>5,000円/月</td></tr>
              <tr><th>体験入居</th><td>2,895円/一泊</td></tr>
            </tbody>
          </table>
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
