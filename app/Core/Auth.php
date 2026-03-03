<?php
declare(strict_types=1);

namespace App\Core;

final class Auth
{
    public static function userId(): ?int
    {
        return isset($_SESSION['user']['id']) ? (int)$_SESSION['user']['id'] : null;
    }

    public static function user(): ?array
    {
        return $_SESSION['user'] ?? null;
    }

    public static function check(): bool
    {
        return self::userId() !== null;
    }

    public static function isAdmin(): bool
    {
        return (bool)($_SESSION['user']['is_admin'] ?? false);
    }

    public static function requireLogin(): void
    {
        if (!self::check()) {
            Flash::info('Faça login para continuar.');
            header('Location: /auth/login');
            exit;
        }
    }

    public static function requireAdmin(): void
    {
        self::requireLogin();
        if (!self::isAdmin()) {
            http_response_code(403);
            View::render('home/403', []);
            exit;
        }
    }

    public static function ensureCsrfSeed(): void
    {
        if (!isset($_SESSION['_csrf_seed'])) {
            $_SESSION['_csrf_seed'] = bin2hex(random_bytes(16));
        }
    }

    public static function csrfToken(): string
    {
        self::ensureCsrfSeed();
        // token per request (still simple)
        $seed = (string)$_SESSION['_csrf_seed'];
        return hash('sha256', $seed . session_id());
    }

    public static function checkCsrf(string $token): bool
    {
        return hash_equals(self::csrfToken(), (string)$token);
    }
}
