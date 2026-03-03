<?php
declare(strict_types=1);

namespace App\Helpers;

use App\Core\Flash as CoreFlash;

final class Flash
{
    public static function success(string $m): void { CoreFlash::success($m); }
    public static function error(string $m): void { CoreFlash::error($m); }
    public static function info(string $m): void { CoreFlash::info($m); }
}
