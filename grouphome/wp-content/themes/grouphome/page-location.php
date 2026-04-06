<?php /* Template Name: 拠点 */ ?>
<?php get_header(); ?>
<?php
while ( have_posts() ) :
	the_post();
	$g = 'grouphome_acf_textish';
	$facility_name = $g( function_exists( 'get_field' ) ? get_field( 'facility_name' ) : '' );
	$hero_title    = $facility_name !== '' ? $facility_name : get_the_title();
	$postal        = trim( $g( function_exists( 'get_field' ) ? get_field( 'postal_code' ) : '' ) );
	$pref          = trim( $g( function_exists( 'get_field' ) ? get_field( 'prefecture' ) : '' ) );
	$city          = trim( $g( function_exists( 'get_field' ) ? get_field( 'city' ) : '' ) );
	$street        = trim( $g( function_exists( 'get_field' ) ? get_field( 'street_address' ) : '' ) );
	$tel           = trim( $g( function_exists( 'get_field' ) ? get_field( 'tel' ) : '' ) );
	$line_url      = trim( $g( function_exists( 'get_field' ) ? get_field( 'line_url' ) : '' ) );
	$map_url       = trim( $g( function_exists( 'get_field' ) ? get_field( 'google_map_url' ) : '' ) );
	$service_areas = trim( $g( function_exists( 'get_field' ) ? get_field( 'service_areas' ) : '' ) );
	$summary_raw   = function_exists( 'get_field' ) ? get_field( 'facility_summary' ) : '';
	$summary       = is_string( $summary_raw ) ? $summary_raw : '';

	if ( function_exists( 'grouphome_apply_location_default_address' ) ) {
		grouphome_apply_location_default_address( $pref, $city, $street );
	}

	$address_line = trim( implode( '', [ $pref, $city, $street ] ) );
	$address_full = trim( ( $postal ? '〒' . $postal . ' ' : '' ) . $address_line );
	$map_src      = function_exists( 'grouphome_map_embed_src' ) ? grouphome_map_embed_src( $map_url, $address_full ) : '';

	$slug_l                = strtolower( (string) get_post()->post_name );
	$is_mansion_location   = ( false !== strpos( $slug_l, 'senbon' ) )
		|| ( function_exists( 'grouphome_location_matches_nishitenkachaya' ) && grouphome_location_matches_nishitenkachaya() );
	$facility_building_type = $is_mansion_location ? 'マンションタイプ' : '戸建てタイプ';
	?>
<main class="l-page l-page--location">
	<div class="page-hero">
		<div class="page-hero__inner">
			<h1 class="page-hero__title"><?php echo esc_html( $hero_title ); ?></h1>
			<p class="page-hero__sub">LOCATION</p>
		</div>
	</div>

	<div class="w-inner">
		<article <?php post_class(); ?>>
			<div class="page-content">

				<?php if ( $summary ) : ?>
				<section class="guide-section">
					<div class="facility-lead facility-lead--wysiwyg">
						<?php echo wp_kses_post( $summary ); ?>
					</div>
				</section>
				<?php else : ?>
				<section class="guide-section">
					<div class="facility-lead">
						<p>駅にも近く生活に大変便利な環境の中で、自分らしくのびのびとした毎日を送ることができます。</p>
					</div>
				</section>
				<?php endif; ?>

				<section class="guide-section">
					<div class="facility-overview">
						<div class="facility-overview__info">
							<table class="guide-table">
								<tbody>
									<tr>
										<th>名称</th>
										<td><?php echo esc_html( $facility_name ?: $hero_title ); ?></td>
									</tr>
									<?php if ( $address_full !== '' ) : ?>
									<tr>
										<th>所在地</th>
										<td><?php echo nl2br( esc_html( $address_full ) ); ?></td>
									</tr>
									<?php endif; ?>
									<tr>
										<th>電話番号</th>
										<td>
											<?php if ( $tel ) : ?>
											<a href="tel:<?php echo esc_attr( preg_replace( '/\D/', '', (string) $tel ) ); ?>"><?php echo esc_html( $tel ); ?></a>
											<?php else : ?>
											<a href="tel:<?php echo esc_attr( grouphome_phone_main_tel_digits() ); ?>"><?php echo esc_html( grouphome_phone_main_display() ); ?></a>
											<?php endif; ?>
										</td>
									</tr>
									<tr>
										<th>緊急連絡先</th>
										<td><a href="tel:<?php echo esc_attr( grouphome_phone_emergency_tel_digits() ); ?>"><?php echo esc_html( grouphome_phone_emergency_display() ); ?></a></td>
									</tr>
									<?php if ( $line_url ) : ?>
									<tr>
										<th>LINE</th>
										<td><a href="<?php echo esc_url( $line_url ); ?>" class="facility-line-link" target="_blank" rel="noopener noreferrer">お問い合わせ（LINE）</a></td>
									</tr>
									<?php endif; ?>
									<tr>
										<th>タイプ</th>
										<td><?php echo esc_html( $facility_building_type ); ?></td>
									</tr>
									<?php
									$loc_is_nishitenkachaya = function_exists( 'grouphome_location_matches_nishitenkachaya' ) && grouphome_location_matches_nishitenkachaya();
									$loc_is_senbon          = false !== strpos( $slug_l, 'senbon' );
									if ( $loc_is_senbon ) :
										?>
									<tr>
										<th>備考</th>
										<td>猫の部屋があり、そこで保護猫を飼っています。</td>
									</tr>
									<?php elseif ( ! $loc_is_nishitenkachaya ) : ?>
									<tr>
										<th>備考</th>
										<td>※同居のペットとして犬がいます。</td>
									</tr>
									<?php endif; ?>
								</tbody>
							</table>
						</div>
					</div>
				</section>

				<?php
				get_template_part(
					'template-parts/facility/facility-features',
					null,
					[
						'is_hanazono'        => function_exists( 'grouphome_location_matches_hanazono' ) && grouphome_location_matches_hanazono(),
						'is_nishitenkachaya' => function_exists( 'grouphome_location_matches_nishitenkachaya' ) && grouphome_location_matches_nishitenkachaya(),
						'is_senbon'          => false !== strpos( $slug_l, 'senbon' ),
					]
				);
				?>
				<?php get_template_part( 'template-parts/facility/facility-gallery-slider', null, [ 'post_id' => get_the_ID() ] ); ?>

				<?php if ( $service_areas ) : ?>
				<section class="guide-section">
					<div class="section-heading">
						<h2>対応エリア</h2>
						<p class="section-heading__sub">AREA</p>
						<div class="section-heading__line"></div>
					</div>
					<p class="facility-service-areas"><?php echo esc_html( grouphome_get_service_area_text() ); ?></p>
				</section>
				<?php endif; ?>

				<?php if ( grouphome_page_has_visible_content() ) : ?>
				<section class="guide-section">
					<div class="entry-content location-entry-content">
						<?php the_content(); ?>
					</div>
				</section>
				<?php endif; ?>

				<?php if ( $address_full !== '' || $map_src ) : ?>
				<section class="guide-section">
					<div class="section-heading">
						<h2>アクセス</h2>
						<p class="section-heading__sub">ACCESS</p>
						<div class="section-heading__line"></div>
					</div>
					<?php if ( $address_full !== '' ) : ?>
					<p class="facility-access-address"><?php echo esc_html( $address_full ); ?></p>
					<?php endif; ?>
					<?php if ( $map_src ) : ?>
					<div class="facility-map__embed">
						<iframe
							title="<?php echo esc_attr( $hero_title . 'の地図' ); ?>"
							src="<?php echo esc_url( $map_src ); ?>"
							width="600"
							height="350"
							loading="lazy"
							referrerpolicy="no-referrer-when-downgrade"
							allowfullscreen=""></iframe>
					</div>
					<?php endif; ?>
				</section>
				<?php endif; ?>

				<div class="l-page-back l-page-back--dual">
					<a href="<?php echo esc_url( home_url( '/facility/' ) ); ?>" class="btn-secondary">拠点一覧へ</a>
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn-secondary">トップページへ戻る</a>
				</div>

			</div>
		</article>
	</div>
</main>
<?php endwhile; ?>
<?php get_footer(); ?>
