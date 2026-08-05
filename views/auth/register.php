<section class="auth-section">
    <div class="container auth-grid auth-grid-register">
        <div class="auth-intro">
            <span class="eyebrow"><span></span> حساب جديد</span>
            <h1>خطوتك الأولى نحو موعد أسهل</h1>
            <p>أنشئ حساب مريض تجريبيًا، ثم اختر الخدمة والطبيب والوقت المناسب.</p>
            <ul class="check-list"><li>متابعة حالة الطلب</li><li>إلغاء الموعد قبل اكتماله</li><li>عرض الملاحظات بعد انتهاء الزيارة</li></ul>
        </div>
        <div class="form-card form-card-wide">
            <div class="form-card-head"><span class="brand-mark">+</span><div><h2>إنشاء حساب</h2><p>جميع الحقول الأساسية مطلوبة</p></div></div>
            <form method="post" action="<?= url('/register') ?>" class="form-grid">
                <?= csrf_field() ?>
                <label class="field-span">الاسم الكامل<input type="text" name="name" value="<?= old('name') ?>" autocomplete="name" required maxlength="120"></label>
                <label>البريد الإلكتروني<input type="email" name="email" value="<?= old('email') ?>" autocomplete="email" required></label>
                <label>رقم الجوال<input type="tel" name="phone" value="<?= old('phone') ?>" autocomplete="tel" required placeholder="05xxxxxxxx"></label>
                <label>الجنس<select name="gender"><option value="unspecified">أفضل عدم التحديد</option><option value="male">ذكر</option><option value="female">أنثى</option></select></label>
                <span></span>
                <label>كلمة المرور<input type="password" name="password" autocomplete="new-password" required minlength="10"></label>
                <label>تأكيد كلمة المرور<input type="password" name="password_confirmation" autocomplete="new-password" required minlength="10"></label>
                <small class="field-span password-help">10 أحرف على الأقل، مع حرف كبير وصغير ورقم ورمز.</small>
                <button class="button button-primary button-full field-span" type="submit">إنشاء الحساب</button>
            </form>
            <p class="form-foot">لديك حساب؟ <a href="<?= url('/login') ?>">سجّل الدخول</a></p>
        </div>
    </div>
</section>
