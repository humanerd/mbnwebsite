<?php
declare(strict_types=1);

namespace App\Core;

final class Auth
{
    public static function check(): bool
    {
        return !empty($_SESSION['admin_id']);
    }

    public static function login(int $id): void
    {
        session_regenerate_id(true);
        $_SESSION['admin_id'] = $id;
    }

    public static function logout(): void
    {
        $_SESSION = [];
        session_destroy();
    }
}
