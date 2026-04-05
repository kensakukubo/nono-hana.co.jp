<?php /* Template Name: よくあるご質問 */ ?>
<?php get_header(); ?>
<main class="l-page">
  <div class="page-hero">
    <div class="page-hero__inner">
      <h1 class="page-hero__title">よくあるご質問</h1>
      <p class="page-hero__sub">FAQ</p>
    </div>
  </div>

  <div class="w-inner">
    <?php if ( have_posts() ) : ?>
      <?php while ( have_posts() ) : the_post(); ?>
    <article <?php post_class(); ?>>
      <div class="page-content">

        <div class="faq-list">
          <div class="faq-item">
            <p class="faq-item__q">グループホームとは、どんなところですか？</p>
            <p class="faq-item__a">グループホームは障がい者総合支援法にもとづく障がい者福祉サービスのひとつとして、障がいのある方々が地域社会に溶け込んで生活できるよう、共同生活をする場所のことです。</p>
          </div>
          <div class="faq-item">
            <p class="faq-item__q">入居者の方は、どのような生活を送っていますか？</p>
            <p class="faq-item__a">グループホームは、入居者たちが安心して生活できるように、24時間スタッフが常駐しています。また、地域の医療機関や福祉サービスなどと連携して、入居者たちの生活を支援しています。</p>
          </div>
          <div class="faq-item">
            <p class="faq-item__q">体験入居は可能ですか？</p>
            <p class="faq-item__a">可能です。一度見学にお越しいただき、気に入っていただければ空いている部屋で体験入居をしていただけます。なお、体験入居は一泊二日で2,895円です。</p>
          </div>
          <div class="faq-item">
            <p class="faq-item__q">入居後のルールや規則はありますか？</p>
            <p class="faq-item__a">あります。全体のルールはもちろんございますが、入居者様一人ひとりに合ったルールが必要な際は、相談して決めさせていただいております。</p>
          </div>
          <div class="faq-item">
            <p class="faq-item__q">居室には、鍵がついていますか？</p>
            <p class="faq-item__a">はい、全室に鍵がついています。</p>
          </div>
          <div class="faq-item">
            <p class="faq-item__q">家賃等は振り込みですか？引き落としですか？</p>
            <p class="faq-item__a">月末締めで請求書を翌15日までに渡します。25日までの振り込み/引き落としになっています。</p>
          </div>
          <div class="faq-item">
            <p class="faq-item__q">土日等の昼食は自分で用意しなくてはいけませんか？</p>
            <p class="faq-item__a">ご自身で用意して召し上がられても良いですし、グループホームの方でも、1食500円で提供しています。月末締めで家賃等の請求書に合算しています。</p>
          </div>
          <div class="faq-item">
            <p class="faq-item__q">通所できない時などの日中は誰か居ますか？</p>
            <p class="faq-item__a">はい、スタッフがいますので、ご安心ください。</p>
          </div>
          <div class="faq-item">
            <p class="faq-item__q">世話人さんの配置を教えてください。</p>
            <p class="faq-item__a">午前10時頃から翌朝9時まで、日勤と夜勤が交代で勤務いたします。365日体制になります。</p>
          </div>
          <div class="faq-item">
            <p class="faq-item__q">入居にあたって、保証人は必要ですか？</p>
            <p class="faq-item__a">通常は保証人または身元引受人が必要となります。難しい場合は個別の事情をお伺いし、ご相談させていただきます。</p>
          </div>
          <div class="faq-item">
            <p class="faq-item__q">入居時にかかる費用を教えてください。</p>
            <p class="faq-item__a">保証金・敷金はいただいておりません。エアコンは設置済みです。</p>
          </div>
          <div class="faq-item">
            <p class="faq-item__q">日中活動していないと住めませんか？</p>
            <p class="faq-item__a">退院したばかりの方や毎日日中活動にいけない方などもご入居いただけます。また日中活動先も一緒に探しますので、ご相談ください。</p>
          </div>
          <div class="faq-item">
            <p class="faq-item__q">薬の管理をお願いできますか？</p>
            <p class="faq-item__a">薬をホームでお預かりし、服薬確認・管理を行なっています。必要に応じ、お渡しさせていただきます。</p>
          </div>
          <div class="faq-item">
            <p class="faq-item__q">タバコを吸いたいです。</p>
            <p class="faq-item__a">ホーム内は全て禁煙とさせてもらっています。屋外に喫煙スペースがありますので、そちらで喫煙（電子タバコを含む）をしてください。</p>
          </div>
          <div class="faq-item">
            <p class="faq-item__q">お酒は飲んでもいいですか？</p>
            <p class="faq-item__a">ご入居者様の健康管理のため、個室での飲酒はご遠慮いただいています。共用スペースでの飲酒をお願いします。</p>
          </div>
          <div class="faq-item">
            <p class="faq-item__q">短期入所も受け入れていますか？</p>
            <p class="faq-item__a">ショートステイを目的とした、空床型短期利用も受け付けております。都度、施設にご連絡ください。</p>
          </div>
          <div class="faq-item">
            <p class="faq-item__q">入居中は自由に外出できますか？</p>
            <p class="faq-item__a">スタッフへの報告をいただければ、基本的には自由に外出できます。ただし門限が22時のため、22時までにお戻りください。</p>
          </div>
          <div class="faq-item">
            <p class="faq-item__q">年齢制限や障がいなどの区分制限はありますか？</p>
            <p class="faq-item__a">ご入居対象年齢は18〜65歳です。区分については、基本的には制限を設けておりません。ご相談の上、ご入居いただいております。</p>
          </div>
          <div class="faq-item">
            <p class="faq-item__q">インターネットは使えますか？</p>
            <p class="faq-item__a">Wi-Fi環境を整えていますので、個室でインターネットをご利用いただけます。</p>
          </div>
          <div class="faq-item">
            <p class="faq-item__q">緊急時の対応はどうなっていますか？</p>
            <p class="faq-item__a">提携先の病院と連携し、必要な対応をいたします。</p>
          </div>
          <div class="faq-item">
            <p class="faq-item__q">グループホーム全体での活動やイベント、レクリエーションはありますか？</p>
            <p class="faq-item__a">誕生会や忘年会、クリスマス会など季節の行事・イベントを企画・実施しています。</p>
          </div>
          <div class="faq-item">
            <p class="faq-item__q">身寄りのない方や障がい年金受給者も受け入れ可能ですか？</p>
            <p class="faq-item__a">はい、ご入居いただけます。詳しくはご相談ください。</p>
          </div>
          <div class="faq-item">
            <p class="faq-item__q">入居を断られるケースなどありますか？</p>
            <p class="faq-item__a">体験入居時に他の入居者様に大きな迷惑になった場合などにお断りさせていただくことがあります。</p>
          </div>
        </div>

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
