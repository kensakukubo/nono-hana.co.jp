<?php
get_header();
while ( have_posts() ) :
	the_post();
	$post_id = get_the_ID();

	$emp        = (string) get_post_meta( $post_id, 'grouphome_job_employment_type', true );
	$loc        = (string) get_post_meta( $post_id, 'grouphome_job_work_location', true );
	$sal        = (string) get_post_meta( $post_id, 'grouphome_job_salary', true );
	$hours      = (string) get_post_meta( $post_id, 'grouphome_job_hours', true );
	$indeed_url = (string) get_post_meta( $post_id, 'grouphome_job_indeed_url', true );
	$indeed_url = $indeed_url !== '' ? esc_url( $indeed_url ) : '';
	?>
<main class="l-page l-page--job">
	<div class="page-hero">
		<div class="page-hero__inner">
			<h1 class="page-hero__title"><?php the_title(); ?></h1>
			<p class="page-hero__sub">JOB</p>
		</div>
	</div>

	<div class="w-inner">
		<article <?php post_class(); ?>>
			<div class="page-content">
				<section class="guide-section">
					<div class="section-heading">
						<h2>求人概要</h2>
						<p class="section-heading__sub">SUMMARY</p>
						<div class="section-heading__line"></div>
					</div>
					<table class="guide-table">
						<tbody>
							<?php if ( $emp !== '' ) : ?><tr><th>雇用形態</th><td><?php echo esc_html( $emp ); ?></td></tr><?php endif; ?>
							<?php if ( $loc !== '' ) : ?><tr><th>勤務地</th><td><?php echo esc_html( $loc ); ?></td></tr><?php endif; ?>
							<?php if ( $sal !== '' ) : ?><tr><th>給与</th><td><?php echo esc_html( $sal ); ?></td></tr><?php endif; ?>
							<?php if ( $hours !== '' ) : ?><tr><th>勤務時間</th><td><?php echo esc_html( $hours ); ?></td></tr><?php endif; ?>
						</tbody>
					</table>
				</section>

				<section class="guide-section">
					<div class="section-heading">
						<h2>仕事内容・詳細</h2>
						<p class="section-heading__sub">DETAIL</p>
						<div class="section-heading__line"></div>
					</div>
					<div class="entry-content">
						<?php the_content(); ?>
					</div>
				</section>

				<section class="guide-section recruit-entry">
					<div class="section-heading">
						<h2>応募・相談</h2>
						<p class="section-heading__sub">ENTRY</p>
						<div class="section-heading__line"></div>
					</div>
					<p class="recruit-entry__lead">ご応募・ご相談は、お電話・LINE・お問い合わせフォームからお気軽にどうぞ。</p>
					<div class="recruit-entry__actions">
						<a href="tel:<?php echo esc_attr( grouphome_phone_main_tel_digits() ); ?>" class="btn-primary btn-primary--lg"><?php echo esc_html( grouphome_phone_main_display() ); ?></a>
						<a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="btn-secondary btn-secondary--lg">お問い合わせフォーム</a>
						<a href="<?php echo esc_url( home_url( '/line/' ) ); ?>" class="btn-secondary btn-secondary--lg">LINEで相談</a>
						<?php if ( $indeed_url !== '' ) : ?>
							<a href="<?php echo $indeed_url; ?>" class="btn-secondary btn-secondary--lg" target="_blank" rel="noopener noreferrer">Indeedで見る</a>
						<?php endif; ?>
					</div>
				</section>

				<div class="l-page-back l-page-back--dual">
					<a href="<?php echo esc_url( get_post_type_archive_link( 'job' ) ); ?>" class="btn-secondary">求人一覧へ</a>
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn-secondary">トップページへ戻る</a>
				</div>
			</div>
		</article>
	</div>
</main>
	<?php
endwhile;
get_footer();

