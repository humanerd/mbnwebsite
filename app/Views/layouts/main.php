<?php declare(strict_types=1); ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($meta['title'] ?? 'Mobile Business Network'); ?></title>
    <meta name="description" content="<?= e($meta['description'] ?? ''); ?>">
    <link rel="canonical" href="<?= e($meta['canonical'] ?? current_url()); ?>">
    <meta property="og:title" content="<?= e($meta['title'] ?? 'Mobile Business Network'); ?>">
    <meta property="og:description" content="<?= e($meta['description'] ?? ''); ?>">
    <meta property="og:type" content="<?= e($meta['og_type'] ?? 'website'); ?>">
    <meta property="og:url" content="<?= e($meta['canonical'] ?? current_url()); ?>">
    <meta property="og:site_name" content="Mobile Business Network">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?= e($meta['title'] ?? 'Mobile Business Network'); ?>">
    <meta name="twitter:description" content="<?= e($meta['description'] ?? ''); ?>">
    <link rel="stylesheet" href="<?= e(asset('css/styles.css')); ?>">
</head>
<body>
<?php partial('components/header'); ?>
<main id="main-content">
    <?php require $templatePath; ?>
</main>
<?php partial('components/footer'); ?>
<script src="<?= e(asset('js/app.js')); ?>" defer></script>
<?php if (!empty($schemaOrg)): ?>
<script type="application/ld+json"><?= json_encode($schemaOrg, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?></script>
<?php endif; ?>
</body>
</html>
