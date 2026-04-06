<?php /* Template Name: 犬と猫のご紹介 */ ?>
<?php get_header(); ?>
<?php
$dog_rows = [
	[
		'upload' => '2026/04/S__56811560.jpg',
		'name'   => 'さくら',
		'charm'  => '穏やかで愛らしい表情が印象的です。そばにいるだけでほっとできる、ホームの癒やし役です。',
	],
	[
		'upload' => '2026/04/S__95936522.jpg',
		'name'   => 'ジジとキキ',
		'charm'  => '仲の良いふたり組です。一緒に遊んだりくつろいだりする姿が、みんなの笑顔のきっかけになっています。',
	],
];
?>
<main class="l-page l-page--dogs">
	<div class="page-hero">
		<div class="page-hero__inner">
			<h1 class="page-hero__title">一緒に暮らす犬と猫</h1>
			<p class="page-hero__sub">DOGS &amp; CATS</p>
		</div>
	</div>

	<div class="w-inner">
		<?php if ( have_posts() ) : ?>
			<?php while ( have_posts() ) : the_post(); ?>
		<article <?php post_class(); ?>>
			<div class="page-content">
				<section class="guide-section dog-intro-lead">
					<h2 class="dog-intro-lead__title">みんなと同じ屋根の下で過ごす、大切な仲間たち</h2>
					<div class="facility-lead dog-intro-lead__text">
						<p><?php echo esc_html( grouphome_site_display_name() ); ?>では、犬だけでなく猫も含め、入居のみなさんと一緒に暮らす仲間として迎え入れています。ふれあいや日々の生活を通じて、ホームに温かさや安心が生まれるようにしたいと考えています。また、保護犬・保護猫をなくすことにも向けて、新しい居場所・暮らしの選択肢のひとつとして位置づけ、グループホームで過ごせるようにしています。</p>
					</div>
				</section>

				<?php if ( function_exists( 'grouphome_page_has_visible_content' ) && grouphome_page_has_visible_content() ) : ?>
				<section class="guide-section">
					<div class="entry-content facility-lead facility-lead--wysiwyg">
						<?php the_content(); ?>
					</div>
				</section>
				<?php endif; ?>

				<section class="guide-section dog-intro-section">
					<ul class="dog-intro-grid" role="list">
						<?php foreach ( $dog_rows as $row ) : ?>
							<?php
							$src = function_exists( 'grouphome_uploads_public_url' )
								? grouphome_uploads_public_url( $row['upload'] )
								: '';
							if ( $src === '' ) {
								continue;
							}
							$charm = isset( $row['charm'] ) ? (string) $row['charm'] : '';
							?>
						<li class="dog-intro-card">
							<figure class="dog-intro-card__figure">
								<img
									class="dog-intro-card__img"
									src="<?php echo esc_url( $src ); ?>"
									alt="<?php echo esc_attr( $row['name'] ); ?>"
									loading="lazy"
									decoding="async"
									width="800"
									height="800"
								/>
							</figure>
							<h3 class="dog-intro-card__title"><?php echo esc_html( $row['name'] ); ?></h3>
							<?php if ( $charm !== '' ) : ?>
							<div class="dog-intro-card__body">
								<p class="dog-intro-card__label">チャームポイント</p>
								<p class="dog-intro-card__charm"><?php echo esc_html( $charm ); ?></p>
							</div>
							<?php endif; ?>
						</li>
						<?php endforeach; ?>
					</ul>
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
