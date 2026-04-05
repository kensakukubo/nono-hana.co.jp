<?php get_header(); ?>
<main>
  <div class="not-found">
    <h1>404 - ページが見つかりません</h1>
    <p>お探しのページは存在しません。</p>
    <p><a href="<?php echo esc_url( home_url( '/' ) ); ?>">トップページへ戻る</a></p>
  </div>
</main>
<?php get_footer(); ?>
