<!doctype html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="<?= e($pageDescription ?? '') ?>">
    <meta name="theme-color" content="#0b6b5c">
    <title><?= e($pageTitle ?? 'ShifaFlow') ?></title>
    <link rel="icon" href="<?= url('/assets/favicon.svg') ?>" type="image/svg+xml">
    <link rel="stylesheet" href="<?= url('/assets/app.css') ?>">
</head>
<body>
<a class="skip-link" href="#main-content">انتقل إلى المحتوى</a>
<header class="site-header">
    <div class="container header-inner">
        <a class="brand" href="<?= url('/') ?>" aria-label="العودة إلى الرئيسية">
            <span class="brand-mark" aria-hidden="true">+</span>
            <span><strong>ShifaFlow</strong><small>منصة شفاء</small></span>
        </a>

        <nav class="desktop-nav" aria-label="التنقل الرئيسي">
            <a href="<?= url('/') ?>">الرئيسية</a>
            <a href="<?= url('/about') ?>">عن المنصة</a>
            <?php if ($currentUser ?? null): ?>
                <a href="<?= url('/dashboard') ?>">لوحة التحكم</a>
                <a href="<?= url('/appointments') ?>">المواعيد</a>
                <?php if (($currentUser['role'] ?? '') === 'admin'): ?>
                    <a href="<?= url('/users') ?>">المستخدمون</a>
                    <a href="<?= url('/messages') ?>">الرسائل</a>
                <?php endif; ?>
            <?php else: ?>
                <a href="<?= url('/contact') ?>">تواصل معنا</a>
            <?php endif; ?>
        </nav>

        <div class="header-actions desktop-actions">
            <?php if ($currentUser ?? null): ?>
                <a class="user-chip" href="<?= url('/profile') ?>"><?= e($currentUser['name']) ?></a>
                <form method="post" action="<?= url('/logout') ?>">
                    <?= csrf_field() ?>
                    <button class="button button-ghost button-small" type="submit">خروج</button>
                </form>
            <?php else: ?>
                <a class="button button-ghost button-small" href="<?= url('/login') ?>">دخول</a>
                <a class="button button-primary button-small" href="<?= url('/register') ?>">حساب جديد</a>
            <?php endif; ?>
        </div>

        <details class="mobile-menu">
            <summary aria-label="فتح القائمة">القائمة</summary>
            <nav>
                <a href="<?= url('/') ?>">الرئيسية</a>
                <a href="<?= url('/about') ?>">عن المنصة</a>
                <?php if ($currentUser ?? null): ?>
                    <a href="<?= url('/dashboard') ?>">لوحة التحكم</a>
                    <a href="<?= url('/appointments') ?>">المواعيد</a>
                    <a href="<?= url('/profile') ?>">الملف الشخصي</a>
                    <?php if (($currentUser['role'] ?? '') === 'admin'): ?>
                        <a href="<?= url('/users') ?>">المستخدمون</a>
                        <a href="<?= url('/messages') ?>">الرسائل</a>
                    <?php endif; ?>
                    <form method="post" action="<?= url('/logout') ?>"><?= csrf_field() ?><button type="submit">تسجيل الخروج</button></form>
                <?php else: ?>
                    <a href="<?= url('/contact') ?>">تواصل معنا</a>
                    <a href="<?= url('/login') ?>">تسجيل الدخول</a>
                    <a href="<?= url('/register') ?>">حساب جديد</a>
                <?php endif; ?>
            </nav>
        </details>
    </div>
</header>

<?php if ($message = flash('success')): ?>
    <div class="container alert alert-success" role="status"><?= e($message) ?></div>
<?php endif; ?>
<?php if ($message = flash('error')): ?>
    <div class="container alert alert-error" role="alert"><?= e($message) ?></div>
<?php endif; ?>

<main id="main-content">
    <?= $content ?>
</main>

<footer class="site-footer">
    <div class="container footer-grid">
        <div>
            <a class="brand brand-footer" href="<?= url('/') ?>"><span class="brand-mark" aria-hidden="true">+</span><span><strong>ShifaFlow</strong><small>رعاية أوضح، عمل أسهل</small></span></a>
            <p>نسخة تجريبية لإدارة المواعيد وتدفقات العمل داخل العيادة، مصممة بالعربية أولًا.</p>
        </div>
        <div>
            <strong>روابط سريعة</strong>
            <a href="<?= url('/about') ?>">عن المنصة</a>
            <a href="<?= url('/contact') ?>">تواصل معنا</a>
            <a href="<?= url('/privacy') ?>">الخصوصية</a>
            <a href="<?= url('/login') ?>">الدخول للنظام</a>
        </div>
        <div>
            <strong>تنبيه</strong>
            <p>البيانات الحالية تجريبية ولا تمثل سجلات طبية حقيقية.</p>
        </div>
    </div>
    <div class="container footer-bottom">© <?= date('Y') ?> ShifaFlow. مشروع تجريبي قابل للتطوير.</div>
</footer>
</body>
</html>
