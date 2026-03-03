<?php
declare(strict_types=1);

namespace App\Core;

final class Flash
{
    private const KEY = '_flash';

    public static function set(string $type, string $message): void
    {
        $_SESSION[self::KEY] = ['type' => $type, 'message' => $message];
    }

    public static function success(string $m): void { self::set('success', $m); }
    public static function error(string $m): void { self::set('danger', $m); }
    public static function info(string $m): void { self::set('info', $m); }

    public static function pull(): ?array
    {
        $v = $_SESSION[self::KEY] ?? null;
        unset($_SESSION[self::KEY]);
        return $v;
    }
}
