<section class="hero">
    <div class="container">
        <p class="eyebrow"><?= e($eyebrow ?? 'Mobile Business Issuance'); ?></p>
        <h1><?= e($title ?? ''); ?></h1>
        <p class="lead"><?= e($description ?? ''); ?></p>
        <?php if (!empty($actions)): ?>
            <div class="hero-actions">
                <?php foreach ($actions as $action): ?>
                    <a class="btn <?= e($action['variant'] ?? ''); ?>" href="<?= e($action['href']); ?>"><?= e($action['label']); ?></a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
