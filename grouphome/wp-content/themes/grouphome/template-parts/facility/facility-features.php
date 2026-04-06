<?php
/**
 * 施設の特徴（拠点により一部文言差分）
 *
 * @var array $args { @type bool $is_hanazono 花園拠点のとき true }
 */
$is_hanazono = isset( $args ) && is_array( $args ) && ! empty( $args['is_hanazono'] );
$night_text    = $is_hanazono ? '夜間は世話人が常駐' : '夜間・休日も世話人が常駐';
$smoking_text  = $is_hanazono ? '屋内に喫煙スペースあり' : '屋外に喫煙スペースあり';
?>
<section class="guide-section">
	<div class="section-heading">
		<h2>施設の特徴</h2>
		<p class="section-heading__sub">FEATURES</p>
		<div class="section-heading__line"></div>
	</div>
	<ul class="facility-features">
		<li class="facility-feature">
			<div class="facility-feature__icon" aria-hidden="true">
				<svg viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M20 4C11.2 4 4 11.2 4 20s7.2 16 16 16 16-7.2 16-16S28.8 4 20 4zm-2 22l-6-6 1.4-1.4L18 23.2l8.6-8.6L28 16l-10 10z" fill="white"/></svg>
			</div>
			<span>全室鍵付きのプライベート個室</span>
		</li>
		<li class="facility-feature">
			<div class="facility-feature__icon" aria-hidden="true">
				<svg viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M20 4C11.2 4 4 11.2 4 20s7.2 16 16 16 16-7.2 16-16S28.8 4 20 4zm-2 22l-6-6 1.4-1.4L18 23.2l8.6-8.6L28 16l-10 10z" fill="white"/></svg>
			</div>
			<span><?php echo esc_html( $night_text ); ?></span>
		</li>
		<li class="facility-feature">
			<div class="facility-feature__icon" aria-hidden="true">
				<svg viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M20 4C11.2 4 4 11.2 4 20s7.2 16 16 16 16-7.2 16-16S28.8 4 20 4zm-2 22l-6-6 1.4-1.4L18 23.2l8.6-8.6L28 16l-10 10z" fill="white"/></svg>
			</div>
			<span>無料Wi-Fi・高速インターネット完備</span>
		</li>
		<li class="facility-feature">
			<div class="facility-feature__icon" aria-hidden="true">
				<svg viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M20 4C11.2 4 4 11.2 4 20s7.2 16 16 16 16-7.2 16-16S28.8 4 20 4zm-2 22l-6-6 1.4-1.4L18 23.2l8.6-8.6L28 16l-10 10z" fill="white"/></svg>
			</div>
			<span>冷暖房完備</span>
		</li>
		<li class="facility-feature">
			<div class="facility-feature__icon" aria-hidden="true">
				<svg viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M20 4C11.2 4 4 11.2 4 20s7.2 16 16 16 16-7.2 16-16S28.8 4 20 4zm-2 22l-6-6 1.4-1.4L18 23.2l8.6-8.6L28 16l-10 10z" fill="white"/></svg>
			</div>
			<span>リビングルームに液晶テレビ設置（共用）</span>
		</li>
		<li class="facility-feature">
			<div class="facility-feature__icon" aria-hidden="true">
				<svg viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M20 4C11.2 4 4 11.2 4 20s7.2 16 16 16 16-7.2 16-16S28.8 4 20 4zm-2 22l-6-6 1.4-1.4L18 23.2l8.6-8.6L28 16l-10 10z" fill="white"/></svg>
			</div>
			<span>カメラ付きインターフォンあり</span>
		</li>
		<li class="facility-feature">
			<div class="facility-feature__icon" aria-hidden="true">
				<svg viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M20 4C11.2 4 4 11.2 4 20s7.2 16 16 16 16-7.2 16-16S28.8 4 20 4zm-2 22l-6-6 1.4-1.4L18 23.2l8.6-8.6L28 16l-10 10z" fill="white"/></svg>
			</div>
			<span><?php echo esc_html( $smoking_text ); ?></span>
		</li>
	</ul>
</section>
