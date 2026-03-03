<?php
declare(strict_types=1);

namespace App\Helpers;

final class Validator
{
    /** @return array<string, string> */
    public static function required(array $fields, array $source): array
    {
        $errors = [];
        foreach ($fields as $f) {
            $v = trim((string)($source[$f] ?? ''));
            if ($v === '') $errors[$f] = 'Campo obrigatório.';
        }
        return $errors;
    }

    public static function email(string $value): bool
    {
        return filter_var($value, FILTER_VALIDATE_EMAIL) !== false;
    }
}
