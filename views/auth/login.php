<section class="auth-section">
    <div class="container auth-grid">
        <div class="auth-intro">
            <span class="eyebrow"><span></span> دخول آمن</span>
            <h1>مرحبًا بعودتك إلى ShifaFlow</h1>
            <p>استخدم بريدك الإلكتروني أو رقم الجوال للوصول إلى المساحة المخصصة لدورك.</p>
            <div class="demo-box">
                <strong>حسابات النسخة التجريبية</strong>
                <div><span>مدير</span><code>admin@shifaflow.test</code></div>
                <div><span>طبيب</span><code>doctor@shifaflow.test</code></div>
                <div><span>مريض</span><code>patient@shifaflow.test</code></div>
                <small>كلمة المرور لجميع الحسابات: <code>Demo@12345</code></small>
            </div>
        </div>
        <div class="form-card">
            <div class="form-card-head"><span class="brand-mark">+</span><div><h2>تسجيل الدخول</h2><p>أدخل بيانات حسابك للمتابعة</p></div></div>
            <form method="post" action="<?= url('/login') ?>" class="form-stack">
                <?= csrf_field() ?>
                <label>البريد أو رقم الجوال<input type="text" name="identifier" value="<?= old('identifier') ?>" autocomplete="username" required placeholder="name@example.com"></label>
                <label>كلمة المرور<input type="password" name="password" autocomplete="current-password" required placeholder="••••••••••"></label>
                <button class="button button-primary button-full" type="submit">دخول إلى المنصة</button>
            </form>
            <p class="form-foot">ليس لديك حساب؟ <a href="<?= url('/register') ?>">أنشئ حساب مريض</a></p>
        </div>
    </div>
</section>
