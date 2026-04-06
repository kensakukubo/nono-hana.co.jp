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
            <p class="faq-item__a">可能です。一度見学にお越しいただき、気に入っていただければ空いている部屋で体験入居をしていただけます。体験宿泊は、宿泊代1,315円、朝食300円、夕食600円、日用品費165円の合計2,380円です。</p>
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
            <p class="faq-item__q">家賃や諸経費のお支払いはどうなっていますか？</p>
            <p class="faq-item__a">家賃及び諸経費は基本は手渡しで、振込みも可能です。</p>
          </div>
          <div class="faq-item">
            <p class="faq-item__q">通所できない時などの日中は誰か居ますか？</p>
            <p class="faq-item__a">はい、スタッフがいますので、ご安心ください。</p>
          </div>
          <div class="faq-item">
            <p class="faq-item__q">入居にあたって、保証人は必要ですか？</p>
            <p class="faq-item__a">特に保証人は必要ございません。</p>
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
            <p class="faq-item__a">主治医、訪問看護と連携し、お薬の管理をさせていただきます。</p>
          </div>
          <div class="faq-item">
            <p class="faq-item__q">タバコを吸いたいです。</p>
            <p class="faq-item__a">施設内に指定の喫煙場所をご用意しています。</p>
          </div>
          <div class="faq-item">
            <p class="faq-item__q">お酒は飲んでもいいですか？</p>
            <p class="faq-item__a">アルコール依存症の方の場合は原則禁止となります。<br>それ以外の方は、共用スペースでの飲酒は禁止（アルコール依存症の方への配慮のため）とさせていただいております。個室では飲酒可能です。</p>
          </div>
          <div class="faq-item">
            <p class="faq-item__q">短期入所も受け入れていますか？</p>
            <p class="faq-item__a">現在はございませんが、受け入れできるよう体制を整えております。</p>
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
            <p class="faq-item__a">体験入居や本入居後、他の入居者様に迷惑になった場合（盗難等）や暴言・暴力、意志の疎通が取れない状況になった場合は、入居をお断りさせていただくことがあります。</p>
          </div>
          <div class="faq-item">
            <p class="faq-item__q">入居のご案内はどのように進みますか？</p>
            <p class="faq-item__a">ご本人やご家族の方と直接面談させていただき、現在の状況等をお伺いします。安全面などから実際に入居が可能かどうかの確認を行います。<br>また、相談支援専門員さんとの連携をお願いしておりますので、契約している相談支援専門員さんがいらっしゃらない場合は、こちらでご紹介させていただきます。</p>
          </div>
          <div class="faq-item">
            <p class="faq-item__q">市町村への申請はどうすればよいですか？</p>
            <p class="faq-item__a">相談支援専門員さんとご相談のうえ、必要な場合は相談支援専門員さんに申請していただきます。</p>
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
