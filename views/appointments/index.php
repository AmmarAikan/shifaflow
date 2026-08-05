<section class="dashboard-shell">
    <div class="container">
        <div class="dashboard-head"><div><span class="eyebrow"><span></span> جدول الرعاية</span><h1>المواعيد</h1><p><?= $currentUser['role'] === 'patient' ? 'احجز موعدًا جديدًا وتابع حالة طلباتك.' : 'راجع المواعيد وحدّث حالتها وفق صلاحياتك.' ?></p></div></div>

        <?php if ($currentUser['role'] === 'patient'): ?>
        <details class="booking-panel" open>
            <summary><span>＋</span><div><strong>حجز موعد جديد</strong><small>اختر تفاصيل الموعد المناسب</small></div></summary>
            <form method="post" action="<?= url('/appointments') ?>" class="form-grid booking-form">
                <?= csrf_field() ?>
                <label>الخدمة<select name="service_id" required><option value="">اختر الخدمة</option><?php foreach ($services as $service): ?><option value="<?= e($service['id']) ?>"><?= e($service['name']) ?> — <?= e($service['duration_minutes']) ?> د</option><?php endforeach; ?></select></label>
                <label>الطبيب<select name="doctor_id"><option value="">أول طبيب متاح</option><?php foreach ($doctors as $doctor): ?><option value="<?= e($doctor['id']) ?>"><?= e($doctor['name']) ?><?= $doctor['specialty'] ? ' — ' . e($doctor['specialty']) : '' ?></option><?php endforeach; ?></select></label>
                <label>التاريخ والوقت<input type="datetime-local" name="scheduled_at" min="<?= date('Y-m-d\TH:i', strtotime('+2 hours')) ?>" value="<?= old('scheduled_at') ?>" required></label>
                <label class="field-span">سبب الزيارة<textarea name="reason" rows="3" minlength="8" maxlength="500" required placeholder="صف باختصار سبب طلب الموعد"><?= old('reason') ?></textarea></label>
                <button class="button button-primary" type="submit">إرسال طلب الموعد</button>
            </form>
        </details>
        <?php endif; ?>

        <section class="panel appointments-panel">
            <div class="panel-title"><div><h2><?= $currentUser['role'] === 'admin' ? 'جميع المواعيد' : 'مواعيدي' ?></h2><p><?= count($appointments) ?> موعدًا في السجل</p></div></div>
            <?php if (!$appointments): ?>
                <div class="empty-state"><span>＋</span><h3>لا توجد مواعيد</h3><p>لم يتم تسجيل أي موعد في هذه المساحة بعد.</p></div>
            <?php else: ?>
                <div class="appointment-list">
                    <?php foreach ($appointments as $appointment): ?>
                    <article class="appointment-card">
                        <div class="appointment-date"><strong><?= e(date('d', strtotime($appointment['scheduled_at']))) ?></strong><span><?= e(date('m / Y', strtotime($appointment['scheduled_at']))) ?></span><small><?= e(date('h:i A', strtotime($appointment['scheduled_at']))) ?></small></div>
                        <div class="appointment-info">
                            <div class="appointment-top"><div><span class="status status-<?= e($appointment['status']) ?>"><?= e(status_label($appointment['status'])) ?></span><h3><?= e($appointment['service_name'] ?? 'استشارة') ?></h3></div><span class="appointment-id">#<?= e($appointment['id']) ?></span></div>
                            <div class="appointment-meta"><span><b>المريض:</b> <?= e($appointment['patient_name']) ?></span><span><b>الطبيب:</b> <?= e($appointment['doctor_name'] ?? 'يحدد لاحقًا') ?></span></div>
                            <p><b>سبب الزيارة:</b> <?= e($appointment['reason']) ?></p>
                            <?php if ($appointment['diagnosis'] && in_array($currentUser['role'], ['doctor', 'patient'], true)): ?><div class="clinical-note"><strong>الملاحظة الطبية</strong><p><b>التشخيص:</b> <?= nl2br(e($appointment['diagnosis'])) ?></p><p><b>الخطة:</b> <?= nl2br(e($appointment['treatment'])) ?></p></div><?php endif; ?>

                            <div class="appointment-actions">
                                <?php if ($currentUser['role'] === 'admin'): ?>
                                    <form method="post" action="<?= url('/appointments/' . $appointment['id'] . '/status') ?>" class="assign-form"><?= csrf_field() ?><input type="hidden" name="status" value="confirmed"><select name="doctor_id" aria-label="اختيار الطبيب" required><option value="">اختر الطبيب</option><?php foreach ($doctors as $doctor): ?><option value="<?= e($doctor['id']) ?>" <?= (int) $appointment['doctor_id'] === (int) $doctor['id'] ? 'selected' : '' ?>><?= e($doctor['name']) ?></option><?php endforeach; ?></select><button class="button button-small button-primary" type="submit">تأكيد</button></form>
                                    <?php foreach (['rejected' => 'رفض', 'cancelled' => 'إلغاء'] as $status => $label): ?><form method="post" action="<?= url('/appointments/' . $appointment['id'] . '/status') ?>"><?= csrf_field() ?><input type="hidden" name="status" value="<?= e($status) ?>"><button class="button button-small button-ghost" type="submit"><?= e($label) ?></button></form><?php endforeach; ?>
                                <?php elseif ($currentUser['role'] === 'patient' && in_array($appointment['status'], ['pending', 'confirmed'], true)): ?>
                                    <form method="post" action="<?= url('/appointments/' . $appointment['id'] . '/status') ?>"><?= csrf_field() ?><input type="hidden" name="status" value="cancelled"><button class="button button-ghost button-small" type="submit">إلغاء الموعد</button></form>
                                <?php elseif ($currentUser['role'] === 'doctor' && in_array($appointment['status'], ['confirmed', 'completed'], true)): ?>
                                    <details class="clinical-form"><summary>إضافة ملاحظة طبية</summary><form method="post" action="<?= url('/appointments/' . $appointment['id'] . '/clinical') ?>"><?= csrf_field() ?><label>التشخيص<textarea name="diagnosis" rows="2" required><?= e($appointment['diagnosis'] ?? '') ?></textarea></label><label>خطة العلاج<textarea name="treatment" rows="2" required><?= e($appointment['treatment'] ?? '') ?></textarea></label><button class="button button-primary button-small" type="submit">حفظ وإكمال الموعد</button></form></details>
                                <?php endif; ?>
                            </div>
                        </div>
                    </article>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </section>
    </div>
</section>
