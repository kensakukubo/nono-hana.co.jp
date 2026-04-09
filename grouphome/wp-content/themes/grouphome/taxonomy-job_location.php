<?php
get_header();
$term = get_queried_object();
$term_name = ( isset( $term->name ) && is_string( $term->name ) ) ? $term->name : '勤務地';
?>
<main class="l-page l-page--jobs">
	<div class="page-hero">
		<div class="page-hero__inner">
			<h1 class="page-hero__title"><?php echo esc_html( $term_name ); ?>の求人</h1>
			<p class="page-hero__sub">JOB LOCATION</p>
		</div>
	</div>

	<div class="w-inner">
		<article class="page-content">
			<section class="guide-section">
				<div class="section-heading">
					<h2>求人一覧</h2>
					<p class="section-heading__sub">LIST</p>
					<div class="section-heading__line"></div>
				</div>
				<?php if ( have_posts() ) : ?>
					<div class="job-list">
						<?php while ( have_posts() ) : the_post(); ?>
							<?php
							$emp   = (string) get_post_meta( get_the_ID(), 'grouphome_job_employment_type', true );
							$loc   = (string) get_post_meta( get_the_ID(), 'grouphome_job_work_location', true );
							$sal   = (string) get_post_meta( get_the_ID(), 'grouphome_job_salary', true );
							$hours = (string) get_post_meta( get_the_ID(), 'grouphome_job_hours', true );
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
				<?php else : ?>
					<p>現在、公開中の求人はありません。</p>
				<?php endif; ?>
			</section>

			<div class="l-page-back l-page-back--dual">
				<a href="<?php echo esc_url( get_post_type_archive_link( 'job' ) ); ?>" class="btn-secondary">求人一覧へ戻る</a>
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn-secondary">トップページへ戻る</a>
			</div>
		</article>
	</div>
</main>
<?php
get_footer();

