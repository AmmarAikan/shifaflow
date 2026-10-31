<?php
$isAdmin = ($currentUser['role'] ?? '') === 'admin';
$statConfig = $isAdmin
    ? [
        'patients' => ['المرضى النشطون', 'م'],
        'doctors' => ['الأطباء النشطون', 'ط'],
        'pending' => ['طلبات تنتظر المراجعة', 'ق'],
        'today' => ['مواعيد اليوم', 'ي'],
    ]
    : [
        'pending' => ['بانتظار المراجعة', 'ق'],
        'confirmed' => ['مواعيد مؤكدة', 'م'],
        'completed' => ['مواعيد مكتملة', '✓'],
        'cancelled' => ['مواعيد ملغية', '×'],
    ];
?>
<section class="dashboard-shell">
    <div class="container">
        <div class="dashboard-head">
            <div><span class="eyebrow"><span></span> <?= e(role_label($currentUser['role'])) ?></span><h1>أهلًا، <?= e(explode(' ', $currentUser['name'])[0]) ?></h1><p>هذه نظرة سريعة على ما يحتاج إلى اهتمامك اليوم.</p></div>
            <?php if ($currentUser['role'] === 'patient'): ?><a class="button button-primary" href="<?= url('/appointments') ?>">+ احجز موعدًا</a><?php endif; ?>
        </div>

        <div class="stats-grid">
            <?php foreach ($statConfig as $key => [$label, $icon]): ?>
                <article class="stat-card"><span class="stat-icon"><?= e($icon) ?></span><div><strong><?= e($stats[$key] ?? 0) ?></strong><small><?= e($label) ?></small></div></article>
            <?php endforeach; ?>
        </div>

        <div class="dashboard-grid">
            <section class="panel panel-main">
                <div class="panel-title"><div><h2>آخر المواعيد</h2><p>أحدث النشاطات المسجلة في النظام</p></div><a href="<?= url('/appointments') ?>">عرض الكل</a></div>
                <?php if (!$appointments): ?>
                    <div class="empty-state"><span>＋</span><h3>لا توجد مواعيد بعد</h3><p>سيظهر أول موعد هنا بمجرد إنشائه.</p></div>
                <?php else: ?>
                    <div class="table-wrap"><table><thead><tr><th>المريض</th><th>الخدمة</th><th>الموعد</th><th>الحالة</th></tr></thead><tbody>
                    <?php foreach ($appointments as $appointment): ?><tr><td><strong><?= e($appointment['patient_name']) ?></strong><?php if ($appointment['doctor_name']): ?><small>مع <?= e($appointment['doctor_name']) ?></small><?php endif; ?></td><td><?= e($appointment['service_name'] ?? 'استشارة') ?></td><td><time><?= e(date('Y/m/d', strtotime($appointment['scheduled_at']))) ?><small><?= e(date('h:i A', strtotime($appointment['scheduled_at']))) ?></small></time></td><td><span class="status status-<?= e($appointment['status']) ?>"><?= e(status_label($appointment['status'])) ?></span></td></tr><?php endforeach; ?>
                    </tbody></table></div>
                <?php endif; ?>
            </section>
            <aside class="panel quick-panel">
                <div class="panel-title"><div><h2>وصول سريع</h2><p>المهام الأكثر استخدامًا</p></div></div>
                <a href="<?= url('/appointments') ?>"><span>01</span><div><strong>المواعيد</strong><small>عرض وإدارة الطلبات</small></div><b>←</b></a>
                <?php if ($isAdmin): ?><a href="<?= url('/users') ?>"><span>02</span><div><strong>المستخدمون</strong><small>الحسابات والصلاحيات</small></div><b>←</b></a><a href="<?= url('/messages') ?>"><span>03</span><div><strong>الرسائل</strong><small>طلبات التواصل الجديدة</small></div><b>←</b></a><?php else: ?><a href="<?= url('/profile') ?>"><span>02</span><div><strong>ملفي الشخصي</strong><small>بيانات الحساب</small></div><b>←</b></a><?php endif; ?>
            </aside>
        </div>
    </div>
</section>
