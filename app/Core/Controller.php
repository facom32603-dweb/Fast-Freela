<?php
declare(strict_types=1);

namespace App\Core;

abstract class Controller
{
    protected function render(string $view, array $data = []): void
    {
        View::render($view, $data);
    }

    protected function redirect(string $path): void
    {
        header('Location: ' . $path);
        exit;
    }

    protected function requirePost(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            exit;
        }
    }

    protected function requireCsrf(): void
    {
        $token = $_POST['_csrf'] ?? '';
        if (!Auth::checkCsrf($token)) {
            Flash::error('Sessão expirada. Recarregue a página e tente novamente.');
            $this->redirect($_SERVER['HTTP_REFERER'] ?? '/');
        }
    }
}
