<?php
/**
 * Template Name: お問い合わせ
 *
 * Contact Form 7 を利用。設定は inc/contact-form.php を参照。
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
				<section class="guide-section contact-lead">
					<div class="section-heading">
						<h2>ご相談・お問い合わせについて</h2>
						<p class="section-heading__sub">MESSAGE</p>
						<div class="section-heading__line"></div>
					</div>
					<div class="contact-lead__body">
						<p class="contact-lead__text">
							<?php echo esc_html( grouphome_site_display_name() ); ?>へのご入居・ご見学、採用、その他ご不明点など、お気軽にお問い合わせください。下記フォームに必要事項をご入力のうえ、送信してください。
						</p>
						<p class="contact-lead__text">
							内容を確認のうえ、担当よりメールまたはお電話にてご連絡いたします。お急ぎの場合は、ページ下部の電話番号またはLINEからもお問い合わせいただけます。
						</p>
						<ul class="contact-lead__list" role="list">
							<li>フォーム送信後、自動返信メールが届く設定になっている場合は、受信フォルダをご確認ください。</li>
							<li>ドメイン指定受信を設定されている方は、当サイトのドメイン（@<?php
							$gh_host = wp_parse_url( home_url(), PHP_URL_HOST );
							echo esc_html( is_string( $gh_host ) && $gh_host !== '' ? $gh_host : 'example.com' );
							?>）からのメールを受信できるよう設定をお願いいたします。</li>
							<li>ご入力いただいた個人情報は、お問い合わせへの回答にのみ利用し、ご本人の同意なく第三者に開示することはありません。</li>
						</ul>
					</div>
				</section>

				<?php if ( function_exists( 'grouphome_page_has_visible_content' ) && grouphome_page_has_visible_content() ) : ?>
					<section class="guide-section contact-intro">
						<div class="section-heading">
							<h2>追加のご案内</h2>
							<p class="section-heading__sub">NOTE</p>
							<div class="section-heading__line"></div>
						</div>
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
					<p class="contact-form-section__lead">
						入力内容にお間違いがないかご確認のうえ、「送信する」ボタンを押してください。送信が完了すると、送信完了ページへ移動します。
					</p>

					<div class="contact-form-wrap">
						<?php
						if ( function_exists( 'shortcode_exists' ) && shortcode_exists( 'contact-form-7' ) ) {
							echo do_shortcode( grouphome_get_contact_cf7_shortcode() );
						} else {
							?>
							<p class="contact-form-wrap__notice">Contact Form 7 をインストールして有効化してください。有効化後、<code>inc/contact-form.php</code> のフォーム ID を、管理画面で作成したフォームの ID に合わせてください。</p>
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
