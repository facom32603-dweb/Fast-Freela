<?php
declare(strict_types=1);

session_start();

require_once __DIR__ . '/Core/Env.php';
\App\Core\Env::load(__DIR__ . '/../.env');

require_once __DIR__ . '/Core/Autoload.php';
\App\Core\Autoload::register();

require_once __DIR__ . '/Core/Helpers.php';

\App\Core\Auth::ensureCsrfSeed();
