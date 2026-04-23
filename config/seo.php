<?php
declare(strict_types=1);

return [
    'organization' => [
        '@context' => 'https://schema.org',
        '@type' => 'Organization',
        'name' => 'Mobile Business Network',
        'url' => env('APP_URL', 'http://localhost:8000'),
        'description' => 'MBN issues complete, launch-ready mobile businesses through a standardized operating model.',
    ],
    'website' => [
        '@context' => 'https://schema.org',
        '@type' => 'WebSite',
        'name' => 'Mobile Business Network',
        'url' => env('APP_URL', 'http://localhost:8000'),
    ],
];
