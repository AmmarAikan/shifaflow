<?php

declare(strict_types=1);

ob_start();

use ShifaFlow\Auth;
use ShifaFlow\Csrf;
use ShifaFlow\Database;
use ShifaFlow\Env;
use ShifaFlow\Validator;

$root = dirname(__DIR__);
require $root . '/app/Env.php';
require $root . '/app/Database.php';
require $root . '/app/Auth.php';
require $root . '/app/Csrf.php';
require $root . '/app/Validator.php';
Env::load($root . '/.env');

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_name('shifaflow_test');
    session_start();
}

$passed = 0;
$failed = 0;

function expect(bool $condition, string $label): void
{
    global $passed, $failed;
    if ($condition) {
        $passed++;
        echo "[PASS] $label\n";
        return;
    }
    $failed++;
    echo "[FAIL] $label\n";
}

expect(Validator::email('patient@example.test'), 'valid email accepted');
expect(!Validator::email('not-an-email'), 'invalid email rejected');
expect(Validator::phone('0501234567'), 'Saudi mobile accepted');
expect(!Validator::phone('1234'), 'short phone rejected');
expect(Validator::strongPassword('Strong@1234'), 'strong password accepted');
expect(!Validator::strongPassword('password'), 'weak password rejected');

$_SESSION = [];
$token = Csrf::token();
expect(strlen($token) === 64, 'CSRF token has expected length');
expect(Csrf::verify($token), 'CSRF token verifies');
expect(!Csrf::verify('invalid'), 'invalid CSRF token rejected');

try {
    $pdo = Database::connection();
    expect((int) $pdo->query("SELECT COUNT(*) FROM information_schema.tables WHERE table_schema = DATABASE() AND table_name IN ('users','services','appointments','contact_messages','audit_logs')")->fetchColumn() === 5, 'required database tables exist');
    expect((int) $pdo->query('SELECT COUNT(*) FROM services')->fetchColumn() >= 4, 'service catalogue is seeded');

    $pdo->beginTransaction();
    $email = 'test-' . bin2hex(random_bytes(4)) . '@shifaflow.test';
    $phone = '059' . random_int(1000000, 9999999);
    $password = 'Testing@12345';
    $insert = $pdo->prepare("INSERT INTO users (name, email, phone, password_hash, role) VALUES (?, ?, ?, ?, 'patient')");
    $insert->execute(['مستخدم اختبار', $email, $phone, password_hash($password, PASSWORD_DEFAULT)]);
    $userId = (int) $pdo->lastInsertId();

    $_SESSION = [];
    $auth = new Auth($pdo);
    expect($auth->attempt($email, $password), 'valid credentials authenticate');
    expect($auth->hasRole('patient'), 'authenticated user has patient role');
    expect((int) ($auth->user()['id'] ?? 0) === $userId, 'authenticated user identity matches');

    $serviceId = (int) $pdo->query('SELECT id FROM services ORDER BY id LIMIT 1')->fetchColumn();
    $appointment = $pdo->prepare("INSERT INTO appointments (patient_id, service_id, scheduled_at, reason) VALUES (?, ?, DATE_ADD(NOW(), INTERVAL 2 DAY), ?)");
    $appointment->execute([$userId, $serviceId, 'موعد اختبار داخل معاملة مؤقتة']);
    expect((int) $pdo->lastInsertId() > 0, 'appointment can be created safely');
    $pdo->rollBack();
} catch (Throwable $exception) {
    if (isset($pdo) && $pdo->inTransaction()) {
        $pdo->rollBack();
    }
    $failed++;
    echo '[FAIL] integration test: ' . $exception->getMessage() . PHP_EOL;
}

echo PHP_EOL . "$passed passed, $failed failed.\n";
ob_end_flush();
exit($failed === 0 ? 0 : 1);
