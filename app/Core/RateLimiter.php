<?php
declare(strict_types=1);

namespace App\Core;

final class RateLimiter
{
    public static function tooManyAttempts(string $key, int $maxAttempts = 5, int $windowSeconds = 900): bool
    {
        $attempts = $_SESSION['_limit'][$key] ?? ['count' => 0, 'start' => time()];

        if ((time() - $attempts['start']) > $windowSeconds) {
            $attempts = ['count' => 0, 'start' => time()];
        }

        if ($attempts['count'] >= $maxAttempts) {
            $_SESSION['_limit'][$key] = $attempts;
            return true;
        }

        $attempts['count']++;
        $_SESSION['_limit'][$key] = $attempts;
        return false;
    }

    public static function clear(string $key): void
    {
        unset($_SESSION['_limit'][$key]);
    }
}
