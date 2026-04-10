<?php
get_header();
while ( have_posts() ) :
	the_post();
	$post_id = get_the_ID();

	$emp        = (string) get_post_meta( $post_id, 'grouphome_job_employment_type', true );
	$loc        = (string) get_post_meta( $post_id, 'grouphome_job_work_location', true );
	$loc_label  = function_exists( 'grouphome_job_location_display' ) ? grouphome_job_location_display( $post_id ) : $loc;
	$loc_terms  = get_the_terms( $post_id, 'job_location' );
	$has_loc_tax = ! is_wp_error( $loc_terms ) && ! empty( $loc_terms );
	$sal        = (string) get_post_meta( $post_id, 'grouphome_job_salary', true );
	$hours      = (string) get_post_meta( $post_id, 'grouphome_job_hours', true );
	$indeed_url = (string) get_post_meta( $post_id, 'grouphome_job_indeed_url', true );
	$indeed_url = $indeed_url !== '' ? esc_url( $indeed_url ) : '';

	$desc         = (string) get_post_meta( $post_id, 'grouphome_job_description', true );
	$req          = (string) get_post_meta( $post_id, 'grouphome_job_requirements', true );
	$sal_detail   = (string) get_post_meta( $post_id, 'grouphome_job_salary_detail', true );
	$hours_detail = (string) get_post_meta( $post_id, 'grouphome_job_hours_detail', true );
	$holidays     = (string) get_post_meta( $post_id, 'grouphome_job_holidays', true );
	$benefits     = (string) get_post_meta( $post_id, 'grouphome_job_benefits', true );
	$notes        = (string) get_post_meta( $post_id, 'grouphome_job_notes', true );
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
							<?php if ( $loc_label !== '' || $loc !== '' ) : ?>
								<tr>
									<th>勤務地</th>
									<td>
										<?php echo esc_html( $loc_label !== '' ? $loc_label : $loc ); ?>
										<?php
										// 拠点はタクソノミー優先。メタの住所が別のときだけ補足（拠点名と手入力の食い違い対策）。
										if ( $has_loc_tax && $loc !== '' && trim( $loc ) !== trim( $loc_label ) ) :
											?>
											<br><span class="guide-table__note"><?php echo esc_html( $loc ); ?></span>
										<?php endif; ?>
									</td>
								</tr>
							<?php endif; ?>
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
						<?php
						$has_split_fields = ( $desc . $req . $sal_detail . $hours_detail . $holidays . $benefits . $notes ) !== '';
						if ( $has_split_fields ) :
							?>
							<?php if ( $desc !== '' ) : ?>
								<h3>仕事内容</h3>
								<?php echo wpautop( wp_kses_post( $desc ) ); ?>
							<?php endif; ?>
							<?php if ( $req !== '' ) : ?>
								<h3>応募資格・経験</h3>
								<?php echo wpautop( wp_kses_post( $req ) ); ?>
							<?php endif; ?>
							<?php if ( $sal_detail !== '' ) : ?>
								<h3>給与詳細</h3>
								<?php echo wpautop( wp_kses_post( $sal_detail ) ); ?>
							<?php endif; ?>
							<?php if ( $hours_detail !== '' ) : ?>
								<h3>勤務時間詳細</h3>
								<?php echo wpautop( wp_kses_post( $hours_detail ) ); ?>
							<?php endif; ?>
							<?php if ( $holidays !== '' ) : ?>
								<h3>休日・休暇</h3>
								<?php echo wpautop( wp_kses_post( $holidays ) ); ?>
							<?php endif; ?>
							<?php if ( $benefits !== '' ) : ?>
								<h3>待遇・福利厚生</h3>
								<?php echo wpautop( wp_kses_post( $benefits ) ); ?>
							<?php endif; ?>
							<?php if ( $notes !== '' ) : ?>
								<h3>備考</h3>
								<?php echo wpautop( wp_kses_post( $notes ) ); ?>
							<?php endif; ?>
						<?php else : ?>
							<?php the_content(); ?>
						<?php endif; ?>
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

