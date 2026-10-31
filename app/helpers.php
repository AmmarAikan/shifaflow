<?php

declare(strict_types=1);

use ShifaFlow\Csrf;
use ShifaFlow\Env;

function e(mixed $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function app_base_path(): string
{
    static $base;
    if (isset($base)) {
        return $base;
    }

    $configured = rtrim((string) Env::get('APP_URL', ''), '/');
    if ($configured !== '') {
        $path = parse_url($configured, PHP_URL_PATH);
        return $base = $path ? rtrim($path, '/') : '';
    }

    $script = str_replace('\\', '/', $_SERVER['SCRIPT_NAME'] ?? '');
    return $base = rtrim(dirname(dirname($script)), '/.');
}

function url(string $path = ''): string
{
    $base = app_base_path();
    $path = '/' . ltrim($path, '/');
    return ($base === '' ? '' : $base) . ($path === '/' ? '/' : $path);
}

function redirect(string $path): never
{
    header('Location: ' . url($path), true, 303);
    exit;
}

function csrf_field(): string
{
    return Csrf::input();
}

function flash(string $key, ?string $value = null): ?string
{
    if ($value !== null) {
        $_SESSION['_flash'][$key] = $value;
        return null;
    }

    $message = $_SESSION['_flash'][$key] ?? null;
    unset($_SESSION['_flash'][$key]);
    return $message;
}

function old(string $key, string $default = ''): string
{
    return e($_SESSION['_old'][$key] ?? $default);
}

function remember_old(array $input, array $except = ['password', 'password_confirmation', '_csrf']): void
{
    $_SESSION['_old'] = array_diff_key($input, array_flip($except));
}

function clear_old(): void
{
    unset($_SESSION['_old']);
}

function role_label(string $role): string
{
    return ['admin' => 'مدير النظام', 'doctor' => 'طبيب', 'patient' => 'مريض'][$role] ?? $role;
}

function status_label(string $status): string
{
    return [
        'pending' => 'بانتظار المراجعة',
        'confirmed' => 'مؤكد',
        'completed' => 'مكتمل',
        'cancelled' => 'ملغي',
        'rejected' => 'مرفوض',
    ][$status] ?? $status;
}
