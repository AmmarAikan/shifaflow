<?php

declare(strict_types=1);

use ShifaFlow\Database;
use ShifaFlow\Env;

$root = dirname(__DIR__);
require $root . '/app/Env.php';
require $root . '/app/Database.php';
Env::load($root . '/.env');

$database = Env::get('DB_NAME', Env::get('MYSQLDATABASE', 'shifaflow'));
if (!is_string($database) || !preg_match('/^[A-Za-z0-9_]+$/', $database)) {
    fwrite(STDERR, "Invalid database name.\n");
    exit(1);
}

try {
    $server = Database::connection(true);
    $server->exec(sprintf('CREATE DATABASE IF NOT EXISTS `%s` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci', $database));
    $pdo = Database::connection();

    $schema = file_get_contents($root . '/database/schema.sql');
    if ($schema === false) {
        throw new RuntimeException('Schema file is missing.');
    }

    foreach (preg_split('/;\s*(?:\r?\n|$)/', $schema) ?: [] as $statement) {
        $statement = trim($statement);
        if ($statement !== '') {
            $pdo->exec($statement);
        }
    }

    seedServices($pdo);

    $seedDemo = Env::bool('SEED_DEMO') || in_array('--seed', $argv, true);
    if ($seedDemo) {
        seedDemo($pdo);
    } else {
        seedAdmin($pdo);
    }

    echo "ShifaFlow database is ready.\n";
} catch (Throwable $exception) {
    fwrite(STDERR, 'Setup failed: ' . $exception->getMessage() . PHP_EOL);
    exit(1);
}

function seedServices(PDO $pdo): void
{
    $services = [
        ['طب الأسرة', 'متابعة صحية شاملة وتشخيص أولي لجميع أفراد الأسرة.', 30],
        ['الاستشارة العامة', 'تقييم الأعراض وتوجيه المريض إلى المسار العلاجي المناسب.', 30],
        ['متابعة الأمراض المزمنة', 'متابعة دورية وخطة رعاية لمرضى السكري والضغط.', 45],
        ['الاستشارة عن بُعد', 'موعد متابعة مرن للحالات التي لا تتطلب حضورًا مباشرًا.', 25],
    ];

    $check = $pdo->prepare('SELECT id FROM services WHERE name = ? LIMIT 1');
    $insert = $pdo->prepare('INSERT INTO services (name, description, duration_minutes) VALUES (?, ?, ?)');
    foreach ($services as $service) {
        $check->execute([$service[0]]);
        if (!$check->fetchColumn()) {
            $insert->execute($service);
        }
    }
}

function seedAdmin(PDO $pdo): void
{
    $email = mb_strtolower((string) Env::get('ADMIN_EMAIL', ''));
    $password = (string) Env::get('ADMIN_PASSWORD', '');
    if ($email === '' || $password === '') {
        return;
    }

    upsertUser($pdo, [
        (string) Env::get('ADMIN_NAME', 'مدير النظام'),
        $email,
        (string) Env::get('ADMIN_PHONE', '0500000001'),
        $password,
        'admin',
        'unspecified',
        null,
    ]);
}

function seedDemo(PDO $pdo): void
{
    $adminId = upsertUser($pdo, ['مدير شفاء فلو', 'admin@shifaflow.test', '0500000001', 'Demo@12345', 'admin', 'unspecified', null]);
    $doctorId = upsertUser($pdo, ['د. سارة أحمد', 'doctor@shifaflow.test', '0500000002', 'Demo@12345', 'doctor', 'female', 'طب الأسرة']);
    $patientId = upsertUser($pdo, ['محمد علي', 'patient@shifaflow.test', '0500000003', 'Demo@12345', 'patient', 'male', null]);

    $count = (int) $pdo->query('SELECT COUNT(*) FROM appointments')->fetchColumn();
    if ($count === 0) {
        $serviceId = (int) $pdo->query('SELECT id FROM services ORDER BY id LIMIT 1')->fetchColumn();
        $insert = $pdo->prepare('INSERT INTO appointments (patient_id, doctor_id, service_id, scheduled_at, status, reason) VALUES (?, ?, ?, ?, ?, ?)');
        $insert->execute([$patientId, $doctorId, $serviceId, date('Y-m-d H:i:s', strtotime('+2 days 10:00')), 'confirmed', 'متابعة دورية وقراءة نتائج الفحوصات.']);
        $insert->execute([$patientId, $doctorId, $serviceId, date('Y-m-d H:i:s', strtotime('-5 days 12:30')), 'completed', 'استشارة عامة بسبب الإرهاق المتكرر.']);
    }

    unset($adminId);
}

function upsertUser(PDO $pdo, array $data): int
{
    [$name, $email, $phone, $password, $role, $gender, $specialty] = $data;
    $find = $pdo->prepare('SELECT id FROM users WHERE email = ? LIMIT 1');
    $find->execute([$email]);
    $id = $find->fetchColumn();
    if ($id) {
        return (int) $id;
    }

    $insert = $pdo->prepare('INSERT INTO users (name, email, phone, password_hash, role, gender, specialty) VALUES (?, ?, ?, ?, ?, ?, ?)');
    $insert->execute([$name, $email, $phone, password_hash($password, PASSWORD_DEFAULT), $role, $gender, $specialty]);
    return (int) $pdo->lastInsertId();
}
