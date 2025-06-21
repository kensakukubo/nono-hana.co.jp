<?php
$title = 'お問い合わせ | 野の花';
$description = '訪問看護ステーション野の花は、大阪市・堺市・堺区、堺市・西区、堺市・南区、堺市・中区・和泉市を対象とした訪問看護に特化したサービスです。ご自宅に看護師やリハビリ職が定期的に訪問し、適格なケアとアドバイスで在宅療養生活を安心して過ごしていただけるよう、万全なケア体制を整えております。';
$type = 'article';
$path = '../';
include '../assets/inc/head.php';
?>
<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-K9RRHLF');</script>
<!-- End Google Tag Manager -->
</head>

<body>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-K9RRHLF"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    <div id="wrapper">
        <?php include '../assets/inc/header.php'; ?>
        <div class="l-page">
            <main role="main" class="l-main-column">
                <section class="mainvisual">
                    <div class="inner">
                        <div class="l-container">
                            <div class="ttl">
                                <h1>お問い合わせ</h1>
                            </div>
                        </div>
                    </div>
                    <img src="<?php echo $path; ?>assets/img/main/wrapper-top.svg" alt="" class="parts">
                    <div class="wave header-line">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 138.4" class="pc">
                            <path d="M1360 26.7c-80 26.3-240 80.3-400 80C800 107 640 53 480 48S160 85 80 106.7L0 128v10.4h1440V0l-80 26.7Z" />
                        </svg>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320" class="sp">
                            <path fill="ffffff" fill-opacity="1" d="M0,160L60,144C120,128,240,96,360,101.3C480,107,600,149,720,181.3C840,213,960,235,1080,224C1200,213,1320,171,1380,149.3L1440,128L1440,320L1380,320C1320,320,1200,320,1080,320C960,320,840,320,720,320C600,320,480,320,360,320C240,320,120,320,60,320L0,320Z"></path>
                        </svg>
                    </div>
                </section>
                <section class="contact">
                    <div class="inner">
                        <div class="l-container">
                            <div class="content">
                                <p>ご相談やご質問、その他お問い合わせなどについては、下記のお問い合わせフォームよりお問い合わせください。</p>
                                <form id="mailformpro" action="../assets/mailformpro/mailformpro.cgi" method="POST">
                                    <table>
                                        <tr>
                                            <th>お名前</th>
                                            <td>
                                                <input type="text" name="お名前" data-kana="zenkaku" required="required">
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>フリガナ</th>
                                            <td>
                                                <input type="text" name="フリガナ" data-kana="zenkaku" required="required">
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>メールアドレス</th>
                                            <td>
                                                <input type="email" data-type="email" name="email" required="required">
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>電話番号</th>
                                            <td>
                                                <input type="tel" data-type="tel" name="お電話番号" required="required">
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>住所</th>
                                            <td>
                                                <input type="text" name="住所" data-kana="zenkaku" required="required">
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>ご相談内容・メッセージ</th>
                                            <td>
                                                <textarea name="ご相談内容・メッセージ" required="required"></textarea>
                                            </td>
                                        </tr>
                                    </table>
                                    <div class="check">
                                        <div class="note">
                                            <p><a href="<?php echo $path; ?>privacy/">個人情報保護方針</a>を必ずご覧いただき、 同意される場合はチェックを入れてください。</p>
                                        </div>
                                        <label><input type="checkbox" required="required" data-exc="1" name="送信確認" value="送信チェック済み"><span>個人情報保護方針に同意する</span></label>
                                        <div id="errormsg_お申し込み内容を確認してください。" class="mfp_err"></div>
                                    </div>
                                    <div class="mfp_buttons btn">
                                        <button type="submit" class="btn">送信</button>
                                    </div>
                                </form>
                                <script type="text/javascript" id="mfpjs" src="../assets/mailformpro/mailformpro.cgi" charset="UTF-8"></script>
                                <link href="../assets/mfp.statics/mailformpro.css" type="text/css" rel="stylesheet">
                            </div>
                        </div>
                    </div>
                </section>
            </main>
        </div>
    </div>
    <?php include '../assets/inc/footer.php'; ?>
</body>

</html>