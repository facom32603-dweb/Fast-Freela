<?php
declare(strict_types=1);

namespace App\Core;

final class Router
{
    /** @var array<string, array<string, callable>> */
    private array $routes = [];

    public function get(string $path, callable $handler): void
    {
        $this->map('GET', $path, $handler);
    }

    public function post(string $path, callable $handler): void
    {
        $this->map('POST', $path, $handler);
    }

    private function map(string $method, string $path, callable $handler): void
    {
        $path = rtrim($path, '/') ?: '/';
        $this->routes[$method][$path] = $handler;
    }

    public function dispatch(string $method, string $uri): void
    {
        $path = parse_url($uri, PHP_URL_PATH) ?? '/';
        $path = rtrim($path, '/') ?: '/';

        $handler = $this->routes[$method][$path] ?? null;

        // Very simple dynamic route: /jobs/show?id=1 etc (kept didactic)
        if (!$handler) {
            http_response_code(404);
            View::render('home/404', []);
            return;
        }

        $handler();
    }
}
