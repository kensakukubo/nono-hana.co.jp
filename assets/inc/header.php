<header class="header-focus">
    <div class="inner">
        <div class="l-container">
            <div class="box l-flex">
                <div class="col logo">
                    <h1>
                        <a <?php echo isset($is_home) ? '' : 'href="' . $path . '"' ?>>
                            <svg>
                                <use class="logo" xlink:href="#nonohana"></use>
                            </svg>
                        </a>
                    </h1>
                </div>
                <div class="col right">
                    <div class="contact-top l-flex">
                        <a href="<?php echo $path; ?>contact/"><i class="fa-solid fa-envelope"></i><span>お問い合わせ</span></a>
                        <a href="tel:06-4393-8474"><i class="fa-solid fa-phone"></i><span>06-4393-8474</span></a>
                    </div>
                    <nav role="navigation" id="nav">
                        <input type="checkbox" id="active">
                        <label for="active" class="menu-btn"><span></span></label>
                        <label for="active" class="close"></label>
                        <div class="mask"></div>
                        <div class="global-menu">
                            <ul class="list">
                                <li><a href="<?php echo $path; ?>./" class="main">ホーム</a></li>
                                <li><a href="<?php echo $path; ?>#service" class="main">訪問看護のサービス内容</a></li>
                                <li><a href="<?php echo $path; ?>#question" class="main">よくある質問</a></li>
                                <li><a href="<?php echo $path; ?>#flow" class="main">お申し込みの流れ</a></li>
                                <li><a href="<?php echo $path; ?>#voice" class="main">ご利用者様の声</a></li>
                                <li><a href="<?php echo $path; ?>#price" class="main">ご利用料金</a></li>
                                <li><a href="<?php echo $path; ?>#company" class="main">会社概要</a></li>
                                <li><a href="<?php echo $path; ?>news/" class="main">お知らせ</a></li>
                                <li><a href="<?php echo $path; ?>misson/" class="main">理念・ミッション</a></li>
                                <li><a href="<?php echo $path; ?>#recruit" class="main">採用情報</a></li>
                                <li><a href="<?php echo $path; ?>privacy/" class="main">プライバシーポリシー</a></li>
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</header>
<p id="page-top">
    <a href="">トップに戻る</a>
</p>