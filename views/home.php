<section class="hero">
    <div class="container hero-grid">
        <div class="hero-copy">
            <span class="eyebrow"><span></span> منصة عربية لإدارة العيادات</span>
            <h1>كل ما تحتاجه العيادة، في مسار واحد <em>أوضح.</em></h1>
            <p>نظّم المواعيد، تابع المرضى، وسهّل عمل الأطباء والإدارة من لوحة واحدة سريعة وآمنة وسهلة الاستخدام.</p>
            <div class="hero-actions">
                <?php if ($currentUser ?? null): ?>
                    <a class="button button-primary" href="<?= url('/dashboard') ?>">افتح لوحة التحكم</a>
                <?php else: ?>
                    <a class="button button-primary" href="<?= url('/register') ?>">ابدأ بحساب تجريبي</a>
                    <a class="button button-secondary" href="<?= url('/login') ?>">استكشف النظام</a>
                <?php endif; ?>
            </div>
            <div class="trust-row">
                <span>✓ بيانات تجريبية معزولة</span>
                <span>✓ صلاحيات حسب الدور</span>
                <span>✓ واجهة عربية متجاوبة</span>
            </div>
        </div>
        <div class="hero-panel" aria-label="معاينة لوحة المواعيد">
            <div class="panel-head">
                <div><span class="live-dot"></span> نظرة اليوم</div>
                <span><?= date('d / m / Y') ?></span>
            </div>
            <div class="hero-stat-grid">
                <article><small>مواعيد اليوم</small><strong>8</strong><span class="trend">+12%</span></article>
                <article><small>وقت الانتظار</small><strong>9 <b>د</b></strong><span>ضمن الهدف</span></article>
            </div>
            <div class="mini-schedule">
                <div class="mini-title"><strong>المواعيد القادمة</strong><span>عرض الكل</span></div>
                <div class="mini-row"><time>09:30</time><span class="avatar avatar-mint">م</span><div><strong>محمد علي</strong><small>طب الأسرة</small></div><span class="status status-confirmed">مؤكد</span></div>
                <div class="mini-row"><time>10:15</time><span class="avatar avatar-sand">س</span><div><strong>سلمى خالد</strong><small>استشارة عامة</small></div><span class="status status-pending">انتظار</span></div>
                <div class="mini-row"><time>11:00</time><span class="avatar avatar-blue">ع</span><div><strong>عمر فهد</strong><small>متابعة دورية</small></div><span class="status status-confirmed">مؤكد</span></div>
            </div>
            <div class="floating-note"><span>✓</span><div><strong>تدفق منظم</strong><small>كل دور يرى ما يحتاجه فقط</small></div></div>
        </div>
    </div>
</section>

<section class="numbers-section">
    <div class="container numbers-grid">
        <div><strong><?= e($doctorCount) ?>+</strong><span>حساب طبيب تجريبي</span></div>
        <div><strong>3</strong><span>أدوار بصلاحيات مستقلة</span></div>
        <div><strong>100%</strong><span>واجهة عربية متجاوبة</span></div>
        <div><strong>24/7</strong><span>وصول آمن للمنصة</span></div>
    </div>
</section>

<section class="section" id="features">
    <div class="container">
        <div class="section-heading">
            <span class="eyebrow"><span></span> تجربة أبسط للجميع</span>
            <h2>من الحجز إلى المتابعة، بلا فوضى</h2>
            <p>صممنا تدفق العمل حول المهام اليومية الحقيقية، مع تقليل الخطوات وحماية البيانات في كل إجراء.</p>
        </div>
        <div class="feature-grid">
            <article class="feature-card feature-highlight"><span class="feature-icon">01</span><h3>مواعيد واضحة</h3><p>إنشاء الطلب، مراجعته، تأكيده، ثم إكماله ضمن سجل واحد مفهوم.</p><a href="<?= url('/appointments') ?>">إدارة المواعيد ←</a></article>
            <article class="feature-card"><span class="feature-icon">02</span><h3>صلاحيات دقيقة</h3><p>لوحات منفصلة للمدير والطبيب والمريض، دون كشف بيانات غير لازمة.</p></article>
            <article class="feature-card"><span class="feature-icon">03</span><h3>ملاحظات طبية منظمة</h3><p>يضيف الطبيب التشخيص وخطة العلاج للموعد المخصص له فقط.</p></article>
            <article class="feature-card"><span class="feature-icon">04</span><h3>سجل نشاط</h3><p>تسجيل العمليات المهمة للمراجعة والمساءلة عند تحويل النظام للاستخدام الفعلي.</p></article>
        </div>
    </div>
</section>

<section class="section section-soft" id="services">
    <div class="container">
        <div class="section-heading inline-heading"><div><span class="eyebrow"><span></span> خدمات العيادة</span><h2>رعاية تبدأ من احتياج المريض</h2></div><a class="button button-secondary" href="<?= url('/register') ?>">احجز موعدًا</a></div>
        <div class="service-grid">
            <?php foreach ($services as $index => $service): ?>
                <article class="service-card"><span><?= str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) ?></span><h3><?= e($service['name']) ?></h3><p><?= e($service['description']) ?></p><small><?= e($service['duration_minutes']) ?> دقيقة تقريبًا</small></article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="section">
    <div class="container cta-panel">
        <div><span class="eyebrow eyebrow-light"><span></span> جاهز للتجربة</span><h2>ابدأ بإدارة يوم العيادة بطريقة أهدأ.</h2><p>ادخل بأحد الحسابات التجريبية أو أنشئ حساب مريض جديدًا.</p></div>
        <div class="cta-actions"><a class="button button-light" href="<?= url('/register') ?>">أنشئ حسابًا</a><a class="button button-outline-light" href="<?= url('/login') ?>">دخول تجريبي</a></div>
    </div>
</section>
