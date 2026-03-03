<?php
declare(strict_types=1);

use App\Core\Env;

function e(?string $v): string { return htmlspecialchars($v ?? '', ENT_QUOTES, 'UTF-8'); }

function base_url(string $path = ''): string
{
    $base = Env::get('APP_BASE_URL', '');
    if ($base === '') return $path;
    return rtrim($base, '/') . '/' . ltrim($path, '/');
}
