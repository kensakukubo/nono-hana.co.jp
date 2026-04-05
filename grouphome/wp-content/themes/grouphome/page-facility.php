<?php /* Template Name: 施設紹介 */ ?>
<?php get_header(); ?>
<main class="l-page l-page--facility-pick">
	<div class="page-hero">
		<div class="page-hero__inner">
			<h1 class="page-hero__title">施設紹介</h1>
			<p class="page-hero__sub">FACILITY</p>
		</div>
	</div>

	<div class="w-inner">
		<?php if ( have_posts() ) : ?>
			<?php while ( have_posts() ) : the_post(); ?>
		<article <?php post_class(); ?>>
			<div class="page-content">
				<?php if ( grouphome_page_has_visible_content() ) : ?>
				<section class="guide-section">
					<div class="entry-content facility-pick-intro">
						<?php the_content(); ?>
					</div>
				</section>
				<?php endif; ?>

				<section class="guide-section">
					<div class="facility-lead facility-pick-lead">
						<p>設備や生活のイメージは<strong>各拠点のページ</strong>でご紹介しています。見学・ご相談はお電話・LINE・お問い合わせフォームよりお気軽にどうぞ。</p>
					</div>
				</section>

				<section class="guide-section">
					<div class="section-heading">
						<h2>拠点を選ぶ</h2>
						<p class="section-heading__sub">LOCATIONS</p>
						<div class="section-heading__line"></div>
					</div>
					<?php
					$location_pages = function_exists( 'grouphome_get_location_pages' ) ? grouphome_get_location_pages() : [];
					if ( $location_pages ) :
						?>
					<ul class="facility-location-pick__list" role="list">
						<?php foreach ( $location_pages as $loc ) : ?>
							<?php
							$loc_title = function_exists( 'get_field' ) ? get_field( 'facility_name', $loc->ID ) : '';
							$loc_title = $loc_title ? $loc_title : get_the_title( $loc );
							$addr      = '';
							if ( function_exists( 'get_field' ) ) {
								$p = (string) get_field( 'prefecture', $loc->ID );
								$c = (string) get_field( 'city', $loc->ID );
								$s = (string) get_field( 'street_address', $loc->ID );
								$addr = trim( $p . $c . $s );
							}
							$card_img = function_exists( 'grouphome_get_location_card_image' ) ? grouphome_get_location_card_image( $loc->ID ) : null;
							?>
						<li class="facility-location-pick__item">
							<a class="facility-location-pick__card" href="<?php echo esc_url( get_permalink( $loc ) ); ?>">
								<div class="facility-location-pick__media">
									<?php if ( $card_img ) : ?>
									<img
										class="facility-location-pick__thumb"
										src="<?php echo esc_url( $card_img['url'] ); ?>"
										alt="<?php echo esc_attr( $card_img['alt'] ); ?>"
										loading="lazy"
										decoding="async"
									/>
									<?php else : ?>
									<div class="facility-location-pick__thumb facility-location-pick__thumb--placeholder" aria-hidden="true"></div>
									<?php endif; ?>
								</div>
								<div class="facility-location-pick__body">
									<span class="facility-location-pick__name"><?php echo esc_html( $loc_title ); ?></span>
									<?php if ( $addr !== '' ) : ?>
									<span class="facility-location-pick__addr"><?php echo esc_html( $addr ); ?></span>
									<?php endif; ?>
									<span class="facility-location-pick__cta btn-secondary">この拠点を見る</span>
								</div>
							</a>
						</li>
						<?php endforeach; ?>
					</ul>
					<?php else : ?>
					<p class="facility-location-pick__empty">拠点ページ（テンプレート「拠点」）がまだありません。管理画面で固定ページを作成し、テンプレートを割り当ててください。</p>
					<?php endif; ?>
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
