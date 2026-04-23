<?php
declare(strict_types=1);

use App\Core\Csrf;
use App\Core\View;

function env(string $key, ?string $default = null): ?string
{
    $value = $_ENV[$key] ?? $_SERVER[$key] ?? getenv($key);
    if ($value === false || $value === null || $value === '') {
        return $default;
    }

    return (string) $value;
}

function config(string $key, mixed $default = null): mixed
{
    static $config = [];
    if ($config === []) {
        $config = [
            'app' => require dirname(__DIR__, 2) . '/config/app.php',
            'seo' => require dirname(__DIR__, 2) . '/config/seo.php',
        ];
    }

    $segments = explode('.', $key);
    $value = $config;
    foreach ($segments as $segment) {
        if (!isset($value[$segment])) {
            return $default;
        }
        $value = $value[$segment];
    }

    return $value;
}

function e(mixed $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function view(string $template, array $data = []): void
{
    View::render($template, $data);
}

function partial(string $template, array $data = []): void
{
    View::partial($template, $data);
}

function asset(string $path): string
{
    return '/assets/' . ltrim($path, '/');
}

function current_url(): string
{
    $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'] ?? env('APP_DOMAIN', 'localhost');
    $uri = $_SERVER['REQUEST_URI'] ?? '/';
    return $scheme . '://' . $host . $uri;
}

function url(string $path = ''): string
{
    $base = rtrim(env('APP_URL', 'http://localhost:8000'), '/');
    return $base . '/' . ltrim($path, '/');
}

function csrf_field(): string
{
    return '<input type="hidden" name="csrf_token" value="' . e(Csrf::token()) . '">';
}

function flash(string $key, ?string $value = null): ?string
{
    if ($value !== null) {
        $_SESSION['_flash'][$key] = $value;
        return null;
    }

    $message = $_SESSION['_flash'][$key] ?? null;
    unset($_SESSION['_flash'][$key]);
    return $message;
}

function old(string $key, mixed $default = ''): mixed
{
    return $_SESSION['_old'][$key] ?? $default;
}

function with_old(array $data): void
{
    $_SESSION['_old'] = $data;
}

function clear_old(): void
{
    unset($_SESSION['_old']);
}

function logger(string $message): void
{
    $file = dirname(__DIR__, 2) . '/storage/logs/app.log';
    file_put_contents($file, '[' . date('c') . '] ' . $message . PHP_EOL, FILE_APPEND);
}

function default_meta(string $title, string $description = ''): array
{
    $siteName = config('app.name', 'MBN');
    $fullTitle = $title . ' | ' . $siteName;
    return [
        'title' => $fullTitle,
        'description' => $description,
        'canonical' => current_url(),
        'og_type' => 'website',
    ];
}
