<?php

declare(strict_types=1);

use ShifaFlow\Csrf;
use ShifaFlow\Validator;
use ShifaFlow\View;

try {
    ['pdo' => $pdo, 'auth' => $auth] = require dirname(__DIR__) . '/app/bootstrap.php';
} catch (Throwable $exception) {
    http_response_code(503);
    $debug = getenv('APP_DEBUG') === 'true';
    $stylesheet = htmlspecialchars(url('/assets/app.css'), ENT_QUOTES, 'UTF-8');
    echo '<!doctype html><html lang="ar" dir="rtl"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>ShifaFlow</title><link rel="stylesheet" href="' . $stylesheet . '"></head><body><main class="error-page"><div><span>503</span><h1>النظام قيد التجهيز</h1><p>تعذر الاتصال بقاعدة البيانات. شغّل أداة الإعداد ثم أعد المحاولة.</p>' . ($debug ? '<small>' . htmlspecialchars($exception->getMessage(), ENT_QUOTES, 'UTF-8') . '</small>' : '') . '</div></main></body></html>';
    exit;
}

$method = strtoupper($_SERVER['REQUEST_METHOD'] ?? 'GET');
$method = $method === 'HEAD' ? 'GET' : $method;
$requestPath = rawurldecode(parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/');
$base = app_base_path();
if ($base !== '' && str_starts_with($requestPath, $base)) {
    $requestPath = substr($requestPath, strlen($base)) ?: '/';
}
$path = '/' . trim($requestPath, '/');
$path = $path === '//' ? '/' : $path;

$render = static function (string $view, array $data = [], string $layout = 'app') use ($auth): never {
    View::render($view, array_merge([
        'auth' => $auth,
        'currentUser' => $auth->user(),
        'pageTitle' => 'ShifaFlow',
        'pageDescription' => 'منصة عربية آمنة لإدارة العيادات والمواعيد.',
    ], $data), $layout);
};

$requireAuth = static function () use ($auth): array {
    $user = $auth->user();
    if (!$user) {
        flash('error', 'سجّل الدخول للوصول إلى هذه الصفحة.');
        redirect('/login');
    }
    return $user;
};

$requireRole = static function (string ...$roles) use ($requireAuth): array {
    $user = $requireAuth();
    if (!in_array($user['role'], $roles, true)) {
        http_response_code(403);
        View::render('errors/403', [
            'currentUser' => $user,
            'auth' => null,
            'pageTitle' => 'غير مصرح',
            'pageDescription' => '',
        ]);
    }
    return $user;
};

$audit = static function (string $action, ?string $entityType = null, ?int $entityId = null, array $metadata = []) use ($pdo, $auth): void {
    $statement = $pdo->prepare('INSERT INTO audit_logs (user_id, action, entity_type, entity_id, metadata, ip_address) VALUES (?, ?, ?, ?, ?, ?)');
    $statement->execute([
        $auth->user()['id'] ?? null,
        $action,
        $entityType,
        $entityId,
        $metadata ? json_encode($metadata, JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR) : null,
        substr((string) ($_SERVER['REMOTE_ADDR'] ?? ''), 0, 45) ?: null,
    ]);
};

if ($path === '/health') {
    header('Content-Type: application/json; charset=utf-8');
    try {
        $pdo->query('SELECT 1');
        echo json_encode(['status' => 'ok', 'service' => 'shifaflow'], JSON_THROW_ON_ERROR);
    } catch (Throwable) {
        http_response_code(503);
        echo json_encode(['status' => 'unavailable', 'service' => 'shifaflow'], JSON_THROW_ON_ERROR);
    }
    exit;
}

if ($method === 'POST' && !Csrf::verify($_POST['_csrf'] ?? null)) {
    http_response_code(419);
    flash('error', 'انتهت صلاحية الطلب. أعد المحاولة.');
    redirect('/');
}

if ($method === 'GET' && $path === '/') {
    $services = $pdo->query('SELECT id, name, description, duration_minutes FROM services WHERE is_active = 1 ORDER BY id LIMIT 6')->fetchAll();
    $doctorCount = (int) $pdo->query("SELECT COUNT(*) FROM users WHERE role = 'doctor' AND is_active = 1")->fetchColumn();
    $render('home', [
        'pageTitle' => 'ShifaFlow | إدارة العيادة بوضوح واطمئنان',
        'services' => $services,
        'doctorCount' => max($doctorCount, 1),
    ]);
}

if ($method === 'GET' && $path === '/about') {
    $render('about', ['pageTitle' => 'عن ShifaFlow']);
}

if ($method === 'GET' && $path === '/privacy') {
    $render('privacy', ['pageTitle' => 'الخصوصية والاستخدام التجريبي']);
}

if ($method === 'GET' && $path === '/contact') {
    $render('contact', ['pageTitle' => 'تواصل معنا']);
}

if ($method === 'POST' && $path === '/contact') {
    $name = trim((string) ($_POST['name'] ?? ''));
    $email = mb_strtolower(trim((string) ($_POST['email'] ?? '')));
    $phone = preg_replace('/[\s-]+/', '', trim((string) ($_POST['phone'] ?? '')));
    $message = trim((string) ($_POST['message'] ?? ''));
    remember_old($_POST);

    if (mb_strlen($name) < 2 || !Validator::email($email) || ($phone !== '' && !Validator::phone($phone)) || mb_strlen($message) < 10) {
        flash('error', 'تحقق من الاسم والبريد ورقم الجوال ونص الرسالة.');
        redirect('/contact');
    }

    $statement = $pdo->prepare('INSERT INTO contact_messages (name, email, phone, message) VALUES (?, ?, ?, ?)');
    $statement->execute([$name, $email, $phone ?: null, $message]);
    clear_old();
    flash('success', 'وصلتنا رسالتك، شكرًا لتواصلك.');
    redirect('/contact');
}

if ($method === 'GET' && $path === '/login') {
    if ($auth->check()) {
        redirect('/dashboard');
    }
    $render('auth/login', ['pageTitle' => 'تسجيل الدخول']);
}

if ($method === 'POST' && $path === '/login') {
    $identifier = trim((string) ($_POST['identifier'] ?? ''));
    $password = (string) ($_POST['password'] ?? '');
    remember_old(['identifier' => $identifier]);

    if ($identifier === '' || $password === '' || !$auth->attempt($identifier, $password)) {
        flash('error', 'بيانات الدخول غير صحيحة، أو توجد محاولات كثيرة.');
        redirect('/login');
    }

    clear_old();
    $audit('auth.login', 'user', (int) $auth->user()['id']);
    flash('success', 'مرحبًا بعودتك، ' . $auth->user()['name'] . '.');
    redirect('/dashboard');
}

if ($method === 'POST' && $path === '/logout') {
    if ($auth->check()) {
        $audit('auth.logout', 'user', (int) $auth->user()['id']);
    }
    $auth->logout();
    redirect('/');
}

if ($method === 'GET' && $path === '/register') {
    if ($auth->check()) {
        redirect('/dashboard');
    }
    $render('auth/register', ['pageTitle' => 'إنشاء حساب مريض']);
}

if ($method === 'POST' && $path === '/register') {
    $name = trim((string) ($_POST['name'] ?? ''));
    $email = mb_strtolower(trim((string) ($_POST['email'] ?? '')));
    $phone = preg_replace('/[\s-]+/', '', trim((string) ($_POST['phone'] ?? '')));
    $password = (string) ($_POST['password'] ?? '');
    $confirmation = (string) ($_POST['password_confirmation'] ?? '');
    $gender = in_array($_POST['gender'] ?? '', ['male', 'female', 'unspecified'], true) ? $_POST['gender'] : 'unspecified';
    remember_old($_POST);

    $errors = [];
    if (mb_strlen($name) < 3 || mb_strlen($name) > 120) {
        $errors[] = 'الاسم يجب أن يكون بين 3 و120 حرفًا.';
    }
    if (!Validator::email($email)) {
        $errors[] = 'البريد الإلكتروني غير صحيح.';
    }
    if (!Validator::phone($phone)) {
        $errors[] = 'استخدم رقم جوال سعودي صحيح.';
    }
    if (!Validator::strongPassword($password)) {
        $errors[] = 'كلمة المرور يجب أن تكون 10 أحرف وتضم حرفًا كبيرًا وصغيرًا ورقمًا ورمزًا.';
    }
    if ($password !== $confirmation) {
        $errors[] = 'تأكيد كلمة المرور غير مطابق.';
    }

    $duplicate = $pdo->prepare('SELECT COUNT(*) FROM users WHERE email = ? OR phone = ?');
    $duplicate->execute([$email, $phone]);
    if ((int) $duplicate->fetchColumn() > 0) {
        $errors[] = 'البريد أو رقم الجوال مسجل مسبقًا.';
    }

    if ($errors) {
        flash('error', implode(' ', $errors));
        redirect('/register');
    }

    $insert = $pdo->prepare("INSERT INTO users (name, email, phone, password_hash, role, gender) VALUES (?, ?, ?, ?, 'patient', ?)");
    $insert->execute([$name, $email, $phone, password_hash($password, PASSWORD_DEFAULT), $gender]);
    $userId = (int) $pdo->lastInsertId();
    $auth->login($userId);
    $audit('user.registered', 'user', $userId);
    clear_old();
    flash('success', 'تم إنشاء حسابك بنجاح. يمكنك الآن حجز موعدك الأول.');
    redirect('/appointments');
}

if ($method === 'GET' && $path === '/dashboard') {
    $user = $requireAuth();
    $params = [];
    $where = '';
    if ($user['role'] === 'patient') {
        $where = 'WHERE a.patient_id = ?';
        $params[] = $user['id'];
    } elseif ($user['role'] === 'doctor') {
        $where = 'WHERE a.doctor_id = ?';
        $params[] = $user['id'];
    }

    $statement = $pdo->prepare("SELECT a.*, p.name AS patient_name, d.name AS doctor_name, s.name AS service_name FROM appointments a JOIN users p ON p.id = a.patient_id LEFT JOIN users d ON d.id = a.doctor_id LEFT JOIN services s ON s.id = a.service_id $where ORDER BY a.scheduled_at DESC LIMIT 6");
    $statement->execute($params);
    $appointments = $statement->fetchAll();

    $stats = [];
    if ($user['role'] === 'admin') {
        $stats = [
            'patients' => (int) $pdo->query("SELECT COUNT(*) FROM users WHERE role = 'patient' AND is_active = 1")->fetchColumn(),
            'doctors' => (int) $pdo->query("SELECT COUNT(*) FROM users WHERE role = 'doctor' AND is_active = 1")->fetchColumn(),
            'pending' => (int) $pdo->query("SELECT COUNT(*) FROM appointments WHERE status = 'pending'")->fetchColumn(),
            'today' => (int) $pdo->query("SELECT COUNT(*) FROM appointments WHERE DATE(scheduled_at) = CURRENT_DATE")->fetchColumn(),
        ];
    } else {
        $idColumn = $user['role'] === 'doctor' ? 'doctor_id' : 'patient_id';
        $counter = $pdo->prepare("SELECT status, COUNT(*) AS total FROM appointments WHERE $idColumn = ? GROUP BY status");
        $counter->execute([$user['id']]);
        foreach ($counter->fetchAll() as $row) {
            $stats[$row['status']] = (int) $row['total'];
        }
    }

    $render('dashboard', ['pageTitle' => 'لوحة التحكم', 'appointments' => $appointments, 'stats' => $stats]);
}

if ($method === 'GET' && $path === '/appointments') {
    $user = $requireAuth();
    $where = '';
    $params = [];
    if ($user['role'] === 'patient') {
        $where = 'WHERE a.patient_id = ?';
        $params[] = $user['id'];
    } elseif ($user['role'] === 'doctor') {
        $where = 'WHERE a.doctor_id = ?';
        $params[] = $user['id'];
    }

    $statement = $pdo->prepare("SELECT a.*, p.name AS patient_name, d.name AS doctor_name, s.name AS service_name FROM appointments a JOIN users p ON p.id = a.patient_id LEFT JOIN users d ON d.id = a.doctor_id LEFT JOIN services s ON s.id = a.service_id $where ORDER BY a.scheduled_at DESC");
    $statement->execute($params);
    $appointments = $statement->fetchAll();
    $services = $pdo->query('SELECT id, name, duration_minutes FROM services WHERE is_active = 1 ORDER BY name')->fetchAll();
    $doctors = $pdo->query("SELECT id, name, specialty FROM users WHERE role = 'doctor' AND is_active = 1 ORDER BY name")->fetchAll();
    $render('appointments/index', [
        'pageTitle' => 'إدارة المواعيد',
        'appointments' => $appointments,
        'services' => $services,
        'doctors' => $doctors,
    ]);
}

if ($method === 'POST' && $path === '/appointments') {
    $user = $requireRole('patient');
    $serviceId = filter_input(INPUT_POST, 'service_id', FILTER_VALIDATE_INT);
    $doctorId = filter_input(INPUT_POST, 'doctor_id', FILTER_VALIDATE_INT) ?: null;
    $scheduledAt = trim((string) ($_POST['scheduled_at'] ?? ''));
    $reason = trim((string) ($_POST['reason'] ?? ''));
    remember_old($_POST);

    $timestamp = strtotime($scheduledAt);
    if (!$serviceId || !$timestamp || $timestamp < strtotime('+2 hours') || mb_strlen($reason) < 8 || mb_strlen($reason) > 500) {
        flash('error', 'اختر خدمة وموعدًا مستقبليًا، واكتب سبب الزيارة بوضوح.');
        redirect('/appointments');
    }

    $serviceCheck = $pdo->prepare('SELECT COUNT(*) FROM services WHERE id = ? AND is_active = 1');
    $serviceCheck->execute([$serviceId]);
    if (!(int) $serviceCheck->fetchColumn()) {
        flash('error', 'الخدمة المختارة غير متاحة حاليًا.');
        redirect('/appointments');
    }

    if ($doctorId) {
        $check = $pdo->prepare("SELECT COUNT(*) FROM users WHERE id = ? AND role = 'doctor' AND is_active = 1");
        $check->execute([$doctorId]);
        if (!(int) $check->fetchColumn()) {
            flash('error', 'الطبيب المختار غير متاح.');
            redirect('/appointments');
        }
    }

    $insert = $pdo->prepare('INSERT INTO appointments (patient_id, doctor_id, service_id, scheduled_at, reason) VALUES (?, ?, ?, ?, ?)');
    $insert->execute([$user['id'], $doctorId, $serviceId, date('Y-m-d H:i:s', $timestamp), $reason]);
    $appointmentId = (int) $pdo->lastInsertId();
    $audit('appointment.created', 'appointment', $appointmentId);
    clear_old();
    flash('success', 'تم إرسال طلب الموعد، وسنحدّث حالته بعد المراجعة.');
    redirect('/appointments');
}

if ($method === 'POST' && preg_match('#^/appointments/(\d+)/status$#', $path, $matches)) {
    $user = $requireAuth();
    $appointmentId = (int) $matches[1];
    $status = (string) ($_POST['status'] ?? '');
    $allowed = [];
    if ($user['role'] === 'admin') {
        $allowed = ['pending', 'confirmed', 'cancelled', 'rejected'];
    } elseif ($user['role'] === 'doctor') {
        $allowed = ['confirmed', 'completed', 'cancelled'];
    } elseif ($user['role'] === 'patient') {
        $allowed = ['cancelled'];
    }
    if (!in_array($status, $allowed, true)) {
        flash('error', 'تغيير الحالة غير مسموح.');
        redirect('/appointments');
    }

    $where = 'id = ?';
    $params = [];
    if ($user['role'] === 'doctor') {
        $where .= ' AND doctor_id = ?';
    } elseif ($user['role'] === 'patient') {
        $where .= " AND patient_id = ? AND status IN ('pending', 'confirmed')";
    }

    if ($user['role'] === 'admin' && $status === 'confirmed') {
        $doctorId = filter_input(INPUT_POST, 'doctor_id', FILTER_VALIDATE_INT);
        $doctorCheck = $pdo->prepare("SELECT COUNT(*) FROM users WHERE id = ? AND role = 'doctor' AND is_active = 1");
        $doctorCheck->execute([$doctorId]);
        if (!$doctorId || !(int) $doctorCheck->fetchColumn()) {
            flash('error', 'اختر طبيبًا نشطًا قبل تأكيد الموعد.');
            redirect('/appointments');
        }
        $update = $pdo->prepare("UPDATE appointments SET status = ?, doctor_id = ? WHERE $where");
        $params = [$status, $doctorId, $appointmentId];
    } else {
        $update = $pdo->prepare("UPDATE appointments SET status = ? WHERE $where");
        $params = [$status, $appointmentId];
    }
    if ($user['role'] === 'doctor' || $user['role'] === 'patient') {
        $params[] = $user['id'];
    }
    $update->execute($params);
    if ($update->rowCount()) {
        $audit('appointment.status_changed', 'appointment', $appointmentId, ['status' => $status]);
        flash('success', 'تم تحديث حالة الموعد.');
    } else {
        flash('error', 'تعذر تحديث هذا الموعد.');
    }
    redirect('/appointments');
}

if ($method === 'POST' && preg_match('#^/appointments/(\d+)/clinical$#', $path, $matches)) {
    $user = $requireRole('doctor');
    $appointmentId = (int) $matches[1];
    $diagnosis = trim((string) ($_POST['diagnosis'] ?? ''));
    $treatment = trim((string) ($_POST['treatment'] ?? ''));
    if (mb_strlen($diagnosis) < 3 || mb_strlen($treatment) < 3) {
        flash('error', 'أدخل التشخيص وخطة العلاج.');
        redirect('/appointments');
    }

    $update = $pdo->prepare("UPDATE appointments SET diagnosis = ?, treatment = ?, status = 'completed' WHERE id = ? AND doctor_id = ? AND status IN ('confirmed', 'completed')");
    $update->execute([$diagnosis, $treatment, $appointmentId, $user['id']]);
    if ($update->rowCount()) {
        $audit('appointment.clinical_note_saved', 'appointment', $appointmentId);
        flash('success', 'تم حفظ الملاحظة الطبية وإكمال الموعد.');
    } else {
        flash('error', 'لا يمكن تعديل هذا الموعد.');
    }
    redirect('/appointments');
}

if ($method === 'GET' && $path === '/users') {
    $requireRole('admin');
    $users = $pdo->query('SELECT id, name, email, phone, role, specialty, is_active, created_at FROM users ORDER BY created_at DESC')->fetchAll();
    $render('users/index', ['pageTitle' => 'إدارة المستخدمين', 'users' => $users]);
}

if ($method === 'POST' && $path === '/users') {
    $requireRole('admin');
    $name = trim((string) ($_POST['name'] ?? ''));
    $email = mb_strtolower(trim((string) ($_POST['email'] ?? '')));
    $phone = preg_replace('/[\s-]+/', '', trim((string) ($_POST['phone'] ?? '')));
    $role = in_array($_POST['role'] ?? '', ['admin', 'doctor', 'patient'], true) ? $_POST['role'] : '';
    $specialty = trim((string) ($_POST['specialty'] ?? ''));
    $password = (string) ($_POST['password'] ?? '');

    if (mb_strlen($name) < 3 || !Validator::email($email) || !Validator::phone($phone) || !$role || !Validator::strongPassword($password)) {
        flash('error', 'تحقق من بيانات الحساب وكلمة المرور القوية.');
        redirect('/users');
    }

    $duplicate = $pdo->prepare('SELECT COUNT(*) FROM users WHERE email = ? OR phone = ?');
    $duplicate->execute([$email, $phone]);
    if ((int) $duplicate->fetchColumn() > 0) {
        flash('error', 'البريد أو رقم الجوال مستخدم مسبقًا.');
        redirect('/users');
    }

    $insert = $pdo->prepare('INSERT INTO users (name, email, phone, password_hash, role, specialty) VALUES (?, ?, ?, ?, ?, ?)');
    $insert->execute([$name, $email, $phone, password_hash($password, PASSWORD_DEFAULT), $role, $role === 'doctor' ? ($specialty ?: null) : null]);
    $userId = (int) $pdo->lastInsertId();
    $audit('user.created_by_admin', 'user', $userId, ['role' => $role]);
    flash('success', 'تم إنشاء الحساب بنجاح.');
    redirect('/users');
}

if ($method === 'POST' && preg_match('#^/users/(\d+)/toggle$#', $path, $matches)) {
    $admin = $requireRole('admin');
    $userId = (int) $matches[1];
    if ($userId === (int) $admin['id']) {
        flash('error', 'لا يمكنك تعطيل حسابك الحالي.');
        redirect('/users');
    }
    $update = $pdo->prepare('UPDATE users SET is_active = 1 - is_active WHERE id = ?');
    $update->execute([$userId]);
    $audit('user.active_toggled', 'user', $userId);
    flash('success', 'تم تحديث حالة الحساب.');
    redirect('/users');
}

if ($method === 'GET' && $path === '/messages') {
    $requireRole('admin');
    $messages = $pdo->query('SELECT * FROM contact_messages ORDER BY created_at DESC')->fetchAll();
    $render('messages/index', ['pageTitle' => 'رسائل التواصل', 'messages' => $messages]);
}

if ($method === 'POST' && preg_match('#^/messages/(\d+)/close$#', $path, $matches)) {
    $requireRole('admin');
    $messageId = (int) $matches[1];
    $update = $pdo->prepare("UPDATE contact_messages SET status = 'closed' WHERE id = ?");
    $update->execute([$messageId]);
    $audit('contact.closed', 'contact_message', $messageId);
    flash('success', 'تم إغلاق الرسالة.');
    redirect('/messages');
}

if ($method === 'GET' && $path === '/profile') {
    $user = $requireAuth();
    $render('profile', ['pageTitle' => 'الملف الشخصي', 'profile' => $user]);
}

if ($method === 'POST' && $path === '/profile') {
    $user = $requireAuth();
    $name = trim((string) ($_POST['name'] ?? ''));
    $phone = preg_replace('/[\s-]+/', '', trim((string) ($_POST['phone'] ?? '')));
    $address = trim((string) ($_POST['address'] ?? ''));
    $dateOfBirth = trim((string) ($_POST['date_of_birth'] ?? '')) ?: null;
    if (mb_strlen($name) < 3 || !Validator::phone($phone) || ($dateOfBirth && !preg_match('/^\d{4}-\d{2}-\d{2}$/', $dateOfBirth))) {
        flash('error', 'تحقق من الاسم ورقم الجوال وتاريخ الميلاد.');
        redirect('/profile');
    }
    $duplicate = $pdo->prepare('SELECT COUNT(*) FROM users WHERE phone = ? AND id <> ?');
    $duplicate->execute([$phone, $user['id']]);
    if ((int) $duplicate->fetchColumn() > 0) {
        flash('error', 'رقم الجوال مرتبط بحساب آخر.');
        redirect('/profile');
    }
    $update = $pdo->prepare('UPDATE users SET name = ?, phone = ?, address = ?, date_of_birth = ? WHERE id = ?');
    $update->execute([$name, $phone, $address ?: null, $dateOfBirth, $user['id']]);
    $audit('profile.updated', 'user', (int) $user['id']);
    flash('success', 'تم تحديث بياناتك.');
    redirect('/profile');
}

if ($method === 'POST' && $path === '/profile/password') {
    $user = $requireAuth();
    $currentPassword = (string) ($_POST['current_password'] ?? '');
    $password = (string) ($_POST['password'] ?? '');
    $confirmation = (string) ($_POST['password_confirmation'] ?? '');
    $statement = $pdo->prepare('SELECT password_hash FROM users WHERE id = ?');
    $statement->execute([$user['id']]);
    $hash = (string) $statement->fetchColumn();
    if (!password_verify($currentPassword, $hash) || !Validator::strongPassword($password) || $password !== $confirmation) {
        flash('error', 'تحقق من كلمة المرور الحالية ومن قوة الكلمة الجديدة وتأكيدها.');
        redirect('/profile');
    }
    $update = $pdo->prepare('UPDATE users SET password_hash = ? WHERE id = ?');
    $update->execute([password_hash($password, PASSWORD_DEFAULT), $user['id']]);
    session_regenerate_id(true);
    $audit('profile.password_changed', 'user', (int) $user['id']);
    flash('success', 'تم تغيير كلمة المرور بنجاح.');
    redirect('/profile');
}

http_response_code(404);
$render('errors/404', ['pageTitle' => 'الصفحة غير موجودة']);
