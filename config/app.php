<?php
declare(strict_types=1);

return [
    'name' => env('APP_NAME', 'Mobile Business Network'),
    'url' => env('APP_URL', 'http://localhost:8000'),
    'admin_email' => env('ADMIN_EMAIL', 'admin@example.com'),
    'mail_from' => env('MAIL_FROM', 'noreply@example.com'),
    'mail_enabled' => env('MAIL_ENABLED', 'false') === 'true',
];
