<?php get_header(); ?>
<div class="l-page">
    <main role="main" class="l-main-column">
        <section class="mainvisual">
            <div class="inner">
                <div class="l-container">
                    <div class="ttl">
                        <h1><?php the_title(); ?></h1>
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
                <div class="l-container">
                    <div class="content">
                        <article>
                            <?php if (have_posts()) : ?>
                                <?php while (have_posts()) : the_post(); ?>
                                    <div class="ttl">
                                        <div class="data l-flex">
                                            <div class="category">
                                                <?php
                                                $categories = get_the_category();
                                                if ($categories) {
                                                    echo '<ul class="l-flex">';
                                                    foreach ($categories as $category) {
                                                        echo '<li class="' . $category->slug . '"><a href="' . esc_url(get_category_link($category->term_id)) . '">' . $category->name . '</a></li>';
                                                    }
                                                    echo '</ul>';
                                                }
                                                ?>
                                            </div>
                                            <div class="time">
                                                <p><?php the_time("Y年m月d日"); ?></p>
                                            </div>
                                        </div>
                                        <h1><?php the_title(); ?></h1>
                                    </div>
                                    <?php if (has_post_thumbnail()) : ?>
                                        <div class="single_thumbnail">
                                            <?php the_post_thumbnail(); ?>
                                        </div>
                                    <?php endif; ?>
                                    <div class="single_content">
                                        <?php the_content(); ?>
                                    </div>
                            <?php endwhile;
                            endif; ?>
                            <div class="pagenation l-flex">
                                <div class="pre"><?php previous_post_link(); ?></div>
                                <div class="next"><?php next_post_link(); ?></div>
                            </div>
                        </article>
                    </div>
                </div>
            </div>
        </section>
    </main>
</div>
<?php get_footer(); ?>