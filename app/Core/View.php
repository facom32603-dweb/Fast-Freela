<?php
declare(strict_types=1);

namespace App\Core;

final class View
{
    public static function render(string $view, array $data = []): void
    {
        extract($data);

        $viewFile = __DIR__ . '/../Views/' . $view . '.php';
        if (!is_file($viewFile)) {
            http_response_code(500);
            echo "View não encontrada: " . htmlspecialchars($view);
            return;
        }

        $layout = __DIR__ . '/../Views/layouts/main.php';
        require $layout;
    }

    public static function includeView(string $view, array $data = []): void
    {
        extract($data);
        $viewFile = __DIR__ . '/../Views/' . $view . '.php';
        require $viewFile;
    }
}
