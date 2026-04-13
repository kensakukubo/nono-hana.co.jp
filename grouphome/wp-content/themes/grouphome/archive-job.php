<?php
get_header();
?>
<main class="l-page l-page--jobs">
	<div class="page-hero">
		<div class="page-hero__inner">
			<h1 class="page-hero__title">求人情報</h1>
			<p class="page-hero__sub">JOBS</p>
		</div>
	</div>

	<div class="w-inner">
		<article class="page-content">
			<section class="guide-section">
				<div class="section-heading">
					<h2>勤務地から探す</h2>
					<p class="section-heading__sub">LOCATIONS</p>
					<div class="section-heading__line"></div>
				</div>
				<?php
				$terms = get_terms(
					[
						'taxonomy'   => 'job_location',
						'hide_empty' => true,
					]
				);
				if ( ! is_wp_error( $terms ) && ! empty( $terms ) ) :
					?>
					<ul class="job-locations" role="list">
						<?php foreach ( $terms as $t ) : ?>
							<li class="job-locations__item">
								<a class="btn-secondary" href="<?php echo esc_url( get_term_link( $t ) ); ?>"><?php echo esc_html( $t->name ); ?></a>
							</li>
						<?php endforeach; ?>
					</ul>
				<?php else : ?>
					<p>現在、公開中の求人は準備中です。</p>
				<?php endif; ?>
			</section>

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
							$loc   = function_exists( 'grouphome_job_location_display' ) ? grouphome_job_location_display( get_the_ID() ) : (string) get_post_meta( get_the_ID(), 'grouphome_job_work_location', true );
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

			<section class="guide-section">
				<div class="section-heading">
					<h2>お問い合わせ</h2>
					<p class="section-heading__sub">CONTACT</p>
					<div class="section-heading__line"></div>
				</div>
				<p class="recruit-entry__lead">ご応募・ご相談は、お電話・LINE・お問い合わせフォームからお気軽にどうぞ。</p>
				<div class="recruit-entry__actions">
					<a href="tel:<?php echo esc_attr( grouphome_phone_main_tel_digits() ); ?>" class="btn-primary btn-primary--lg"><?php echo esc_html( grouphome_phone_main_display() ); ?></a>
					<a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="btn-secondary btn-secondary--lg">お問い合わせフォーム</a>
					<a href="<?php echo esc_url( grouphome_line_add_friend_url() ); ?>" class="btn-secondary btn-secondary--lg" target="_blank" rel="noopener noreferrer">LINEで相談</a>
				</div>
			</section>
		</article>
	</div>
</main>
<?php
get_footer();

