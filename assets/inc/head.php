<?php
$requestUri = $_SERVER['REQUEST_URI'];

$newUri = preg_replace('#/+#', '/', $requestUri);

if ($newUri !== $requestUri) {
    $newUrl = 'https://' . $_SERVER['HTTP_HOST'] . $newUri;
    header('Location: ' . $newUrl, true, 301);
    exit();
}
?>
<!DOCTYPE html>
<html lang="ja" prefix="og: http://ogp.me/ns#">

<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# article: http://ogp.me/ns/article#">
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <meta name="robots" content="index,follow">
    <title><?php echo $title; ?></title>
    <meta name="description" content="<?php echo $description; ?>" />
    <meta name="format-detection" content="telephone=no" />
    <link rel="icon" href="<?php echo $path; ?>assets/img/common/favicon.ico" />
    <link rel="icon" href="favicon.svg" type="image/svg+xml">
    <link rel="apple-touch-icon" href="<?php echo $path; ?>assets/img/common/apple-touch-icon.png" />
    <meta property="og:site_name" content="<?php echo $title; ?>" />
    <meta property="og:url" content="" />
    <meta property="og:type" content="<?php echo $type; ?>" />
    <meta property="og:title" content="<?php echo $title; ?>" />
    <meta property="og:description" content="<?php echo $description; ?>"" />
<meta property=" og:image" content="https://nono-hana.co.jp/assets/img/common/ogp.webp" />
    <meta property="og:locale" content="ja_JP" />
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:description" content="<?php echo $description; ?>"" />
<meta name=" twitter:image:src" content="<?php echo $path; ?>assets/img/common/ogp.webp" />
    <link rel="stylesheet" href="<?php echo $path; ?>assets/css/style.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Zen+Maru+Gothic:wght@300;400;500;700;900&display=swap" rel="stylesheet">