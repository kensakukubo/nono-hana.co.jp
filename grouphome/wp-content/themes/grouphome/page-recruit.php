<?php /* Template Name: 採用情報 */ ?>
<?php get_header(); ?>
<main class="l-page l-page--recruit">
  <div class="page-hero">
    <div class="page-hero__inner">
      <h1 class="page-hero__title">採用情報</h1>
      <p class="page-hero__sub">RECRUIT</p>
    </div>
  </div>

  <div class="w-inner">
    <?php if ( have_posts() ) : ?>
      <?php while ( have_posts() ) : the_post(); ?>
    <article <?php post_class(); ?>>
      <div class="page-content">

        <section class="guide-section">
          <div class="recruit-lead">
            <div class="recruit-lead__photo">
              <div class="guide-step__photo guide-step__photo--recruit" aria-hidden="true"></div>
            </div>
            <div class="recruit-lead__text">
              <h2>明るい方そして元気な方、<br>グループホームで一緒に働いてみませんか？</h2>
              <p><?php echo esc_html( grouphome_site_display_name() ); ?>では、一緒に働く方を募集しています。あなたがお持ちの資格、ご経験を生かして、スタッフ、入居者様とそのご家族のみなさまが心地よい場所をつくっていきましょう。</p>
            </div>
          </div>
        </section>

        <section class="guide-section">
          <div class="section-heading">
            <h2>募集要項</h2>
            <p class="section-heading__sub">REQUIREMENTS</p>
            <div class="section-heading__line"></div>
          </div>

          <div class="recruit-jobs">
            <?php
            $jobs = new WP_Query(
              [
                'post_type'      => 'job',
                'posts_per_page' => -1,
                'post_status'    => 'publish',
                'orderby'        => 'date',
                'order'          => 'DESC',
              ]
            );
            if ( $jobs->have_posts() ) :
              ?>
              <div class="job-list">
                <?php
                while ( $jobs->have_posts() ) :
                  $jobs->the_post();
                  $post_id = get_the_ID();
                  $emp   = (string) get_post_meta( $post_id, 'grouphome_job_employment_type', true );
                  $loc   = function_exists( 'grouphome_job_location_display' ) ? grouphome_job_location_display( $post_id ) : (string) get_post_meta( $post_id, 'grouphome_job_work_location', true );
                  $sal   = (string) get_post_meta( $post_id, 'grouphome_job_salary', true );
                  $hours = (string) get_post_meta( $post_id, 'grouphome_job_hours', true );
                  ?>
                  <a class="job-card" href="<?php the_permalink(); ?>">
                    <h3 class="job-card__title"><?php the_title(); ?></h3>
                    <ul class="job-card__meta" role="list">
                      <?php if ( $emp !== '' ) : ?><li><strong>雇用</strong> <?php echo esc_html( $emp ); ?></li><?php endif; ?>
                      <?php if ( $loc !== '' ) : ?><li><strong>勤務地</strong> <?php echo esc_html( $loc ); ?></li><?php endif; ?>
                      <?php if ( $sal !== '' ) : ?><li><strong>給与</strong> <?php echo esc_html( $sal ); ?></li><?php endif; ?>
                      <?php if ( $hours !== '' ) : ?><li><strong>時間</strong> <?php echo esc_html( $hours ); ?></li><?php endif; ?>
                    </ul>
                    <span class="job-card__cta btn-secondary">詳細を見る</span>
                  </a>
                <?php endwhile; ?>
              </div>
              <?php
              wp_reset_postdata();
            else :
              ?>
              <p>現在、公開中の求人はありません。</p>
              <?php
            endif;
            ?>
          </div>
        </section>

        <section class="guide-section recruit-entry">
          <div class="section-heading">
            <h2>採用エントリー</h2>
            <p class="section-heading__sub">ENTRY</p>
            <div class="section-heading__line"></div>
          </div>
          <p class="recruit-entry__lead">ご応募・ご相談は、お電話・LINE・お問い合わせフォームからお気軽にどうぞ。</p>
          <div class="recruit-entry__actions">
            <a href="tel:<?php echo esc_attr( grouphome_phone_main_tel_digits() ); ?>" class="btn-primary btn-primary--lg"><?php echo esc_html( grouphome_phone_main_display() ); ?></a>
            <a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="btn-secondary btn-secondary--lg">お問い合わせフォーム</a>
            <a href="<?php echo esc_url( grouphome_line_add_friend_url() ); ?>" class="btn-secondary btn-secondary--lg" target="_blank" rel="noopener noreferrer">LINEで相談</a>
          </div>
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
