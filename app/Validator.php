<?php

declare(strict_types=1);

namespace ShifaFlow;

final class Validator
{
    public static function email(string $value): bool
    {
        return filter_var($value, FILTER_VALIDATE_EMAIL) !== false;
    }

    public static function phone(string $value): bool
    {
        return preg_match('/^(?:\+?966|0)?5\d{8}$/', preg_replace('/[\s-]+/', '', $value)) === 1;
    }

    public static function strongPassword(string $value): bool
    {
        return strlen($value) >= 10
            && preg_match('/[A-Z]/', $value)
            && preg_match('/[a-z]/', $value)
            && preg_match('/\d/', $value)
            && preg_match('/[^A-Za-z0-9]/', $value);
    }
}
