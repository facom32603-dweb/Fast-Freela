<?php
declare(strict_types=1);

namespace App\Core;

final class Autoload
{
    public static function register(): void
    {
        spl_autoload_register(function (string $class) {
            $prefix = 'App\\';
            $baseDir = __DIR__ . '/../';

            if (!str_starts_with($class, $prefix)) {
                return;
            }

            $relative = substr($class, strlen($prefix));
            $file = $baseDir . str_replace('\\', '/', $relative) . '.php';

            if (is_file($file)) {
                require_once $file;
            }
        });
    }
}
