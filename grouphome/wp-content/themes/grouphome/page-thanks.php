<?php
/**
 * Template Name: お問い合わせ完了（サンクス）
 *
 * 固定ページを新規作成し、スラッグを「thanks」などにしてください（下記フィルタで変更可）。
 * 送信完了後の遷移先は grouphome_get_contact_thanks_url() と一致させること。
 */
?>
<?php get_header(); ?>
<?php
while ( have_posts() ) :
	the_post();
	?>
<main class="l-page l-page--thanks">
	<div class="page-hero">
		<div class="page-hero__inner">
			<h1 class="page-hero__title"><?php the_title(); ?></h1>
			<p class="page-hero__sub">THANK YOU</p>
		</div>
	</div>

	<div class="w-inner">
		<article <?php post_class( 'thanks-card' ); ?>>
			<div class="thanks-card__inner">
				<p class="thanks-card__icon" aria-hidden="true">
					<svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" role="img" focusable="false"><circle cx="24" cy="24" r="22" stroke="#1D9E75" stroke-width="2"/><path d="M14 24l7 7 13-14" stroke="#1D9E75" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
				</p>
				<p class="thanks-card__lead">
					この度は、お問い合わせいただき、誠にありがとうございます。
				</p>
				<p class="thanks-card__text">
					ご入力いただいた内容を確認のうえ、担当より折り返しご連絡いたします。内容や混雑状況により、ご返信までにお時間をいただく場合がございます。あらかじめご了承ください。
				</p>
				<p class="thanks-card__text">
					お急ぎのご用件は、お電話でも承っております。どうぞお気軽にご連絡ください。
				</p>

				<div class="thanks-card__cta">
					<a href="tel:<?php echo esc_attr( grouphome_phone_main_tel_digits() ); ?>" class="btn-primary btn-primary--lg"><?php echo esc_html( grouphome_phone_main_display() ); ?>（代表）</a>
					<a href="<?php echo esc_url( grouphome_line_add_friend_url() ); ?>" class="btn-secondary btn-secondary--lg" target="_blank" rel="noopener noreferrer">LINEで相談</a>
				</div>

				<?php if ( function_exists( 'grouphome_page_has_visible_content' ) && grouphome_page_has_visible_content() ) : ?>
					<div class="entry-content thanks-card__extra">
						<?php the_content(); ?>
					</div>
				<?php endif; ?>

				<div class="thanks-card__back l-page-back l-page-back--dual">
					<a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="btn-secondary">お問い合わせページへ戻る</a>
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
