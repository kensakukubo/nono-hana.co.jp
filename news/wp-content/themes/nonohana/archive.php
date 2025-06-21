<?php get_header(); ?>
<p id="page-top">
    <a href="">トップに戻る</a>
</p>

<?php
$page_title = "";
if (is_category()) {
    $page_title = "カテゴリー「" . single_cat_title("", false) . "」";
} else if (is_tag()) {
    $page_title = "タグ「" . single_tag_title("", false) . "」";
} else if (is_date()) {
    $page_title = get_the_date("Y年n月");
}
$page_title .= "の記事一覧";
?>

<div class="l-page">
    <main role="main" class="l-main-column">
        <section class="mainvisual">
            <div class="inner">
                <div class="l-container">
                    <div class="ttl">
                        <h1><?php echo get_archive_title() . ""; ?>一覧</h1>
                    </div>
                </div>
            </div>
            <img src="http://nono-hana.co.jp/assets/img/main/wrapper-top.svg" alt="" class="parts">
            <div class="wave header-line">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 138.4" class="pc">
                    <path d="M1360 26.7c-80 26.3-240 80.3-400 80C800 107 640 53 480 48S160 85 80 106.7L0 128v10.4h1440V0l-80 26.7Z" />
                </svg>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320" class="sp">
                    <path fill="ffffff" fill-opacity="1" d="M0,160L60,144C120,128,240,96,360,101.3C480,107,600,149,720,181.3C840,213,960,235,1080,224C1200,213,1320,171,1380,149.3L1440,128L1440,320L1380,320C1320,320,1200,320,1080,320C960,320,840,320,720,320C600,320,480,320,360,320C240,320,120,320,60,320L0,320Z"></path>
                </svg>
            </div>
        </section>
        <section class="news post" id="news">
            <div class="inner">
                <div class="l-container long">
                    <div class="content">
                        <ul class="l-grid items">
                            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                                    <li>
                                        <article>
                                            <a href="<?php the_permalink(); ?>">
                                                <div class="col thumbnail">
                                                    <?php if (has_post_thumbnail()) : ?>
                                                        <?php the_post_thumbnail(); ?>
                                                    <?php else : ?>
                                                        <img src="http://nono-hana.co.jp/assets/img/common/eyecatch.webp" alt="">
                                                    <?php endif; ?>
                                                </div>
                                                <div class="col details">
                                                    <div class="post-option l-flex">
                                                        <div class="post-data">
                                                            <span><i class="fa-regular fa-clock"></i><?php the_time("Y/m/j") ?></span>
                                                            <?php if (get_the_modified_time('Ymd') != get_the_time('Ymd')) ?>
                                                        </div>
                                                        <div class="post-category">
                                                            <ul class="l-flex">
                                                                <?php
                                                                $categories = get_the_category();
                                                                foreach ($categories as $category) :
                                                                ?>
                                                                    <li><span><?php echo $category->name; ?></span></li>
                                                                <?php endforeach; ?>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <h3 class="post-title"><?php the_title(); ?></h3>
                                                </div>
                                            </a>
                                        </article>
                                    </li>
                                <?php endwhile; ?>
                            <?php endif; ?>
                        </ul>
                        <div id="pagenation" class="l-section">
                            <?php the_posts_pagination(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
</div>
<?php get_footer(); ?>