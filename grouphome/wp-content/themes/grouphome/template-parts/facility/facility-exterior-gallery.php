<?php
/**
 * 外観写真（スライダー・室内ギャラリーと同 UI）
 *
 * @var int $post_id 対象固定ページID
 */
$post_id = isset( $post_id ) ? (int) $post_id : get_the_ID();
$slides  = function_exists( 'grouphome_get_exterior_gallery_slides' ) ? grouphome_get_exterior_gallery_slides( $post_id ) : [];
if ( empty( $slides ) ) {
	return;
}
$n         = count( $slides );
$slider_id = 'exteriorSlider-' . $post_id;
?>
<section class="guide-section facility-exterior-section">
	<div class="section-heading">
		<h2>外観</h2>
		<p class="section-heading__sub">EXTERIOR</p>
		<div class="section-heading__line"></div>
	</div>
	<div class="facility-room-slider" id="<?php echo esc_attr( $slider_id ); ?>" data-room-slider>
		<div class="facility-room-slider__viewport">
			<?php foreach ( $slides as $i => $slide ) : ?>
			<figure class="facility-room-slider__slide<?php echo 0 === $i ? ' is-active' : ''; ?>" data-room-slide data-index="<?php echo (int) $i; ?>">
				<?php
				$img_alt = $slide['alt'] !== '' ? $slide['alt'] : get_the_title( $post_id ) . ' 外観';
				if ( ! empty( $slide['id'] ) ) {
					echo wp_get_attachment_image(
						(int) $slide['id'],
						'large',
						false,
						[
							'class'   => 'facility-room-slider__img',
							'loading' => 0 === $i ? 'eager' : 'lazy',
							'alt'     => $img_alt,
						]
					);
				} else {
					printf(
						'<img class="facility-room-slider__img" src="%s" alt="%s" loading="%s" decoding="async" />',
						esc_url( $slide['url'] ),
						esc_attr( $img_alt ),
						0 === $i ? 'eager' : 'lazy'
					);
				}
				?>
				<?php if ( ! empty( $slide['caption'] ) ) : ?>
				<figcaption class="facility-room-slider__caption"><?php echo esc_html( $slide['caption'] ); ?></figcaption>
				<?php endif; ?>
			</figure>
			<?php endforeach; ?>
		</div>
		<?php if ( $n > 1 ) : ?>
		<div class="facility-room-slider__toolbar">
			<button type="button" class="facility-room-slider__btn facility-room-slider__btn--prev" data-room-prev aria-label="前の写真へ">‹</button>
			<div class="facility-room-slider__dots" role="tablist" aria-label="写真の選択">
				<?php foreach ( $slides as $i => $_s ) : ?>
				<button type="button" class="facility-room-slider__dot<?php echo 0 === $i ? ' is-active' : ''; ?>" data-room-dot data-go="<?php echo (int) $i; ?>" role="tab" aria-selected="<?php echo 0 === $i ? 'true' : 'false'; ?>" aria-label="<?php echo esc_attr( sprintf( '写真 %d', $i + 1 ) ); ?>"></button>
				<?php endforeach; ?>
			</div>
			<button type="button" class="facility-room-slider__btn facility-room-slider__btn--next" data-room-next aria-label="次の写真へ">›</button>
		</div>
		<p class="facility-room-slider__counter" aria-live="polite">
			<span class="facility-room-slider__current">1</span> / <?php echo (int) $n; ?>
		</p>
		<?php endif; ?>
	</div>
</section>
