<?php

declare(strict_types=1);

use ShifaFlow\Auth;
use ShifaFlow\Database;
use ShifaFlow\Env;

$root = dirname(__DIR__);

spl_autoload_register(static function (string $class) use ($root): void {
    $prefix = 'ShifaFlow\\';
    if (!str_starts_with($class, $prefix)) {
        return;
    }
    $path = $root . '/app/' . str_replace('\\', '/', substr($class, strlen($prefix))) . '.php';
    if (is_file($path)) {
        require $path;
    }
});

require $root . '/app/helpers.php';
Env::load($root . '/.env');

date_default_timezone_set((string) Env::get('APP_TIMEZONE', 'Asia/Riyadh'));

$isHttps = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || ($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '') === 'https';
ini_set('session.use_strict_mode', '1');
ini_set('session.use_only_cookies', '1');
session_name('shifaflow_session');
session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'secure' => $isHttps,
    'httponly' => true,
    'samesite' => 'Lax',
]);
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: DENY');
header('Referrer-Policy: strict-origin-when-cross-origin');
header('Permissions-Policy: camera=(), microphone=(), geolocation=()');
header("Content-Security-Policy: default-src 'self'; img-src 'self' data:; style-src 'self'; script-src 'self'; font-src 'self'; frame-ancestors 'none'; base-uri 'self'; form-action 'self'");
if ($isHttps) {
    header('Strict-Transport-Security: max-age=31536000; includeSubDomains');
}

ini_set('display_errors', Env::bool('APP_DEBUG') ? '1' : '0');
error_reporting(E_ALL);

$pdo = Database::connection();
$auth = new Auth($pdo);

return compact('root', 'pdo', 'auth');
