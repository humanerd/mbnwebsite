<section class="section">
    <div class="container">
        <h2>FAQ</h2>
        <div class="faq-list">
            <?php foreach (($items ?? []) as $item): ?>
                <details>
                    <summary><?= e($item['q']); ?></summary>
                    <p><?= e($item['a']); ?></p>
                </details>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php
$faqSchema = ['@context' => 'https://schema.org', '@type' => 'FAQPage', 'mainEntity' => []];
foreach (($items ?? []) as $item) {
    $faqSchema['mainEntity'][] = ['@type' => 'Question', 'name' => $item['q'], 'acceptedAnswer' => ['@type' => 'Answer', 'text' => $item['a']]];
}
?>
<script type="application/ld+json"><?= json_encode($faqSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?></script>
