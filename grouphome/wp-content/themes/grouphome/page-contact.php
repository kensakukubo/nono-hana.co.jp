<?php
/**
 * Template Name: お問い合わせ
 *
 * Contact Form 7 を利用。プラグイン有効化後、inc/contact-form.php のショートコード id を実際のフォーム ID に合わせる。
 */
?>
<?php get_header(); ?>
<?php
while ( have_posts() ) :
	the_post();
	?>
<main class="l-page l-page--contact">
	<div class="page-hero">
		<div class="page-hero__inner">
			<h1 class="page-hero__title"><?php the_title(); ?></h1>
			<p class="page-hero__sub">CONTACT</p>
		</div>
	</div>

	<div class="w-inner">
		<article <?php post_class(); ?>>
			<div class="page-content">
				<?php if ( function_exists( 'grouphome_page_has_visible_content' ) && grouphome_page_has_visible_content() ) : ?>
					<section class="guide-section contact-intro">
						<div class="entry-content contact-intro__body">
							<?php the_content(); ?>
						</div>
					</section>
				<?php endif; ?>

				<section class="guide-section contact-form-section">
					<div class="section-heading">
						<h2>お問い合わせフォーム</h2>
						<p class="section-heading__sub">FORM</p>
						<div class="section-heading__line"></div>
					</div>
					<p class="contact-form-section__lead">必要事項をご入力のうえ、送信してください。折り返しご連絡いたします。</p>

					<div class="contact-form-wrap">
						<?php
						if ( function_exists( 'shortcode_exists' ) && shortcode_exists( 'contact-form-7' ) ) {
							echo do_shortcode( grouphome_get_contact_cf7_shortcode() );
						} else {
							?>
							<p class="contact-form-wrap__notice">Contact Form 7 をインストールして有効化してください。有効化後、<code>inc/contact-form.php</code> のフォーム ID を管理画面で作成したフォームの ID に合わせてください。</p>
							<?php
						}
						?>
					</div>
				</section>

				<section class="guide-section contact-alt">
					<div class="section-heading">
						<h2>お電話・LINE</h2>
						<p class="section-heading__sub">OTHER</p>
						<div class="section-heading__line"></div>
					</div>
					<p class="contact-alt__lead">お急ぎの方は、お電話またはLINEからもお問い合わせいただけます。</p>
					<div class="contact-alt__actions">
						<a href="tel:<?php echo esc_attr( grouphome_phone_main_tel_digits() ); ?>" class="btn-primary btn-primary--lg"><?php echo esc_html( grouphome_phone_main_display() ); ?></a>
						<a href="<?php echo esc_url( home_url( '/line/' ) ); ?>" class="btn-secondary btn-secondary--lg">LINEで相談</a>
					</div>
				</section>

				<div class="l-page-back">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn-secondary">トップページへ戻る</a>
				</div>
			</div>
		</article>
	</div>
</main>
	<?php
endwhile;
?>
<?php get_footer(); ?>
