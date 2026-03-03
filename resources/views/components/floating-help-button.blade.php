{{-- Floating Help Button - يظهر في جميع الصفحات والنوافذ المنبثقة --}}
<div id="floatingHelpBtn" class="position-fixed" style="bottom: 20px; left: 20px; right: auto !important; z-index: 9999;">
    <button type="button" 
            class="help-icon-btn"
            data-bs-toggle="offcanvas" 
            data-bs-target="#globalHelpOffcanvas"
            title="مساعدة">
        <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
            <rect x="2" y="2" width="36" height="36" rx="8" stroke="#7c3aed" stroke-width="2.5" fill="none"/>
            <circle cx="20" cy="24" r="1.5" fill="#7c3aed"/>
            <path d="M17 15.5C17 13.567 18.567 12 20.5 12C22.433 12 24 13.567 24 15.5C24 17.433 22.433 19 20.5 19V21" stroke="#7c3aed" stroke-width="2.5" stroke-linecap="round"/>
        </svg>
    </button>
</div>

{{-- Global Help Offcanvas --}}
<div class="offcanvas offcanvas-end" tabindex="-1" id="globalHelpOffcanvas" style="width: 420px; z-index: 99999;">
    <div class="offcanvas-header" style="background: linear-gradient(135deg, #7c3aed 0%, #a855f7 100%);">
        <h5 class="offcanvas-title text-white fw-bold">
            <i class="fa fa-life-ring me-2 text-white"></i> مركز المساعدة
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body p-0">
        {{-- Current Page Info --}}
        <div class="bg-light-primary p-4 border-bottom">
            <h6 class="fw-bold text-primary mb-2">
                <i class="fa fa-map-marker-alt me-2"></i>الصفحة الحالية
            </h6>
            <p class="mb-0 text-dark fw-semibold" id="helpCurrentPageTitle">@yield('title', 'لوحة التحكم')</p>
        </div>

        {{-- Context-Sensitive Help - يتغير حسب الصفحة --}}
        <div id="contextHelpSection" class="p-4 border-bottom bg-light-success" style="display: none;">
            <h6 class="fw-bold text-success mb-3">
                <i class="fa fa-info-circle me-2"></i>مساعدة هذه الصفحة
            </h6>
            <div id="contextHelpContent"></div>
        </div>

        {{-- أدوات ووظائف هذه الصفحة - ديناميكي --}}
        <div id="pageToolsSection" class="p-4 border-bottom">
            <h6 class="fw-bold text-primary mb-3">
                <i class="fa fa-tools me-2"></i>أدوات هذه الصفحة
            </h6>
            <div id="pageToolsContent">
                <p class="text-muted mb-0">جاري تحميل الأدوات...</p>
            </div>
        </div>

    </div>
</div>

<style>
/* Floating Help Button - Outline Style */
.help-icon-btn {
    background: transparent;
    border: none;
    padding: 0;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
}

.help-icon-btn:hover {
    transform: scale(1.1);
}

.help-icon-btn:hover svg rect,
.help-icon-btn:hover svg circle,
.help-icon-btn:hover svg path {
    stroke: #a855f7;
    fill: none;
}

.help-icon-btn:hover svg circle {
    fill: #a855f7;
}

.help-icon-btn:active {
    transform: scale(0.95);
}

.help-icon-btn:focus {
    outline: none;
}

/* الزر دائماً في الزاوية اليسرى السفلية */
#floatingHelpBtn {
    left: 20px !important;
    right: auto !important;
}

/* Keyboard shortcut styling */
kbd {
    background: #1e1e2d;
    color: #fff;
    padding: 2px 8px;
    border-radius: 4px;
    font-size: 12px;
}

/* Context help styling */
#contextHelpContent ul {
    padding-right: 1rem;
    margin-bottom: 0;
}
#contextHelpContent li {
    margin-bottom: 0.5rem;
    line-height: 1.6;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // أدوات ووظائف كل صفحة بشكل تفصيلي
    const pageTools = {
        // لوحة التحكم
        'home': `
            <div class="accordion" id="toolsAccordion">
                <div class="accordion-item border-0 mb-2">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed bg-light rounded py-2" type="button" data-bs-toggle="collapse" data-bs-target="#tool1">
                            <i class="fa fa-chart-line text-primary me-2"></i>
                            <span class="fw-semibold">بطاقات الإحصائيات</span>
                        </button>
                    </h2>
                    <div id="tool1" class="accordion-collapse collapse" data-bs-parent="#toolsAccordion">
                        <div class="accordion-body small">
                            تعرض ملخص سريع للمشاريع والمهام والحالة المالية. اضغط على أي بطاقة للانتقال للتفاصيل.
                        </div>
                    </div>
                </div>
                <div class="accordion-item border-0 mb-2">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed bg-light rounded py-2" type="button" data-bs-toggle="collapse" data-bs-target="#tool2">
                            <i class="fa fa-bell text-warning me-2"></i>
                            <span class="fw-semibold">التنبيهات والمواعيد</span>
                        </button>
                    </h2>
                    <div id="tool2" class="accordion-collapse collapse" data-bs-parent="#toolsAccordion">
                        <div class="accordion-body small">
                            تعرض المهام والمواعيد القادمة. يمكنك التبديل بين اليوم والقادمة والفائتة.
                        </div>
                    </div>
                </div>
            </div>
        `,
        'dashboard': `
            <div class="accordion" id="toolsAccordion">
                <div class="accordion-item border-0 mb-2">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed bg-light rounded py-2" type="button" data-bs-toggle="collapse" data-bs-target="#tool1">
                            <i class="fa fa-chart-line text-primary me-2"></i>
                            <span class="fw-semibold">بطاقات الإحصائيات</span>
                        </button>
                    </h2>
                    <div id="tool1" class="accordion-collapse collapse" data-bs-parent="#toolsAccordion">
                        <div class="accordion-body small">
                            تعرض ملخص سريع للمشاريع والمهام والحالة المالية. اضغط على أي بطاقة للانتقال للتفاصيل.
                        </div>
                    </div>
                </div>
            </div>
        `,
        // صفحة المشاريع
        'projects': `
            <div class="accordion" id="toolsAccordion">
                <div class="accordion-item border-0 mb-2">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed bg-light rounded py-2" type="button" data-bs-toggle="collapse" data-bs-target="#tool1">
                            <i class="fa fa-plus text-success me-2"></i>
                            <span class="fw-semibold">زر إنشاء جديد</span>
                        </button>
                    </h2>
                    <div id="tool1" class="accordion-collapse collapse" data-bs-parent="#toolsAccordion">
                        <div class="accordion-body small">
                            اضغط لإنشاء مشروع جديد. أدخل اسم المشروع، العميل، الميزانية، وتواريخ البدء والانتهاء.
                        </div>
                    </div>
                </div>
                <div class="accordion-item border-0 mb-2">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed bg-light rounded py-2" type="button" data-bs-toggle="collapse" data-bs-target="#tool2">
                            <i class="fa fa-search text-info me-2"></i>
                            <span class="fw-semibold">البحث والفلترة</span>
                        </button>
                    </h2>
                    <div id="tool2" class="accordion-collapse collapse" data-bs-parent="#toolsAccordion">
                        <div class="accordion-body small">
                            ابحث بالاسم أو فلتر حسب الحالة (نشط، مكتمل، متوقف). استخدم القائمة المنسدلة للتصفية.
                        </div>
                    </div>
                </div>
                <div class="accordion-item border-0 mb-2">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed bg-light rounded py-2" type="button" data-bs-toggle="collapse" data-bs-target="#tool3">
                            <i class="fa fa-file-export text-secondary me-2"></i>
                            <span class="fw-semibold">تصدير التقرير</span>
                        </button>
                    </h2>
                    <div id="tool3" class="accordion-collapse collapse" data-bs-parent="#toolsAccordion">
                        <div class="accordion-body small">
                            صدّر قائمة المشاريع إلى Excel أو PDF للمراجعة أو الطباعة.
                        </div>
                    </div>
                </div>
                <div class="accordion-item border-0 mb-2">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed bg-light rounded py-2" type="button" data-bs-toggle="collapse" data-bs-target="#tool4">
                            <i class="fa fa-ellipsis-v text-muted me-2"></i>
                            <span class="fw-semibold">قائمة الإجراءات</span>
                        </button>
                    </h2>
                    <div id="tool4" class="accordion-collapse collapse" data-bs-parent="#toolsAccordion">
                        <div class="accordion-body small">
                            اضغط "الإجراءات" بجانب كل مشروع لعرض، تعديل، حذف، أو الدخول لتفاصيل المشروع.
                        </div>
                    </div>
                </div>
            </div>
        `,
        // صفحة المهام
        'tasks': `
            <div class="accordion" id="toolsAccordion">
                <div class="accordion-item border-0 mb-2">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed bg-light rounded py-2" type="button" data-bs-toggle="collapse" data-bs-target="#tool1">
                            <i class="fa fa-plus text-success me-2"></i>
                            <span class="fw-semibold">إنشاء مهمة جديدة</span>
                        </button>
                    </h2>
                    <div id="tool1" class="accordion-collapse collapse" data-bs-parent="#toolsAccordion">
                        <div class="accordion-body small">
                            حدد العنوان، الوصف، المشروع المرتبط، المسؤول عن التنفيذ، والأولوية.
                        </div>
                    </div>
                </div>
                <div class="accordion-item border-0 mb-2">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed bg-light rounded py-2" type="button" data-bs-toggle="collapse" data-bs-target="#tool2">
                            <i class="fa fa-filter text-info me-2"></i>
                            <span class="fw-semibold">فلترة حسب الحالة</span>
                        </button>
                    </h2>
                    <div id="tool2" class="accordion-collapse collapse" data-bs-parent="#toolsAccordion">
                        <div class="accordion-body small">
                            فلتر المهام حسب: الكل، جديد، قيد التنفيذ، مكتمل، أو ملغي.
                        </div>
                    </div>
                </div>
                <div class="accordion-item border-0 mb-2">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed bg-light rounded py-2" type="button" data-bs-toggle="collapse" data-bs-target="#tool3">
                            <i class="fa fa-exchange-alt text-warning me-2"></i>
                            <span class="fw-semibold">تغيير الحالة</span>
                        </button>
                    </h2>
                    <div id="tool3" class="accordion-collapse collapse" data-bs-parent="#toolsAccordion">
                        <div class="accordion-body small">
                            اضغط على حالة المهمة لتغييرها مباشرة من الجدول.
                        </div>
                    </div>
                </div>
            </div>
        `,
        // صفحة العملاء
        'clients': `
            <div class="accordion" id="toolsAccordion">
                <div class="accordion-item border-0 mb-2">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed bg-light rounded py-2" type="button" data-bs-toggle="collapse" data-bs-target="#tool1">
                            <i class="fa fa-user-plus text-success me-2"></i>
                            <span class="fw-semibold">إضافة عميل جديد</span>
                        </button>
                    </h2>
                    <div id="tool1" class="accordion-collapse collapse" data-bs-parent="#toolsAccordion">
                        <div class="accordion-body small">
                            أدخل بيانات العميل: الاسم، الهاتف، البريد الإلكتروني، والعنوان.
                        </div>
                    </div>
                </div>
                <div class="accordion-item border-0 mb-2">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed bg-light rounded py-2" type="button" data-bs-toggle="collapse" data-bs-target="#tool2">
                            <i class="fa fa-eye text-info me-2"></i>
                            <span class="fw-semibold">عرض تفاصيل العميل</span>
                        </button>
                    </h2>
                    <div id="tool2" class="accordion-collapse collapse" data-bs-parent="#toolsAccordion">
                        <div class="accordion-body small">
                            اضغط على اسم العميل لعرض العقود، المدفوعات، وسجل التعاملات.
                        </div>
                    </div>
                </div>
            </div>
        `,
        // صفحة BOQ
        'boq': `
            <div class="accordion" id="toolsAccordion">
                <div class="accordion-item border-0 mb-2">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed bg-light rounded py-2" type="button" data-bs-toggle="collapse" data-bs-target="#tool1">
                            <i class="fa fa-plus text-success me-2"></i>
                            <span class="fw-semibold">إضافة بند جديد</span>
                        </button>
                    </h2>
                    <div id="tool1" class="accordion-collapse collapse" data-bs-parent="#toolsAccordion">
                        <div class="accordion-body small">
                            اختر الوصف من القائمة المنسدلة أو أضف وصف جديد. حدد الكمية، الوحدة، وسعر الوحدة.
                        </div>
                    </div>
                </div>
                <div class="accordion-item border-0 mb-2">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed bg-light rounded py-2" type="button" data-bs-toggle="collapse" data-bs-target="#tool2">
                            <i class="fa fa-cog text-secondary me-2"></i>
                            <span class="fw-semibold">إدارة الأوصاف المسبقة</span>
                        </button>
                    </h2>
                    <div id="tool2" class="accordion-collapse collapse" data-bs-parent="#toolsAccordion">
                        <div class="accordion-body small">
                            اضغط على أيقونة الإعدادات بجانب حقل الوصف لإضافة، تعديل، أو حذف أوصاف جاهزة.
                        </div>
                    </div>
                </div>
                <div class="accordion-item border-0 mb-2">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed bg-light rounded py-2" type="button" data-bs-toggle="collapse" data-bs-target="#tool3">
                            <i class="fa fa-sitemap text-info me-2"></i>
                            <span class="fw-semibold">تحليل البند</span>
                        </button>
                    </h2>
                    <div id="tool3" class="accordion-collapse collapse" data-bs-parent="#toolsAccordion">
                        <div class="accordion-body small">
                            اضغط "تحليل" لتفصيل مكونات البند (مواد، عمالة، معدات، مقاولين).
                        </div>
                    </div>
                </div>
                <div class="accordion-item border-0 mb-2">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed bg-light rounded py-2" type="button" data-bs-toggle="collapse" data-bs-target="#tool4">
                            <i class="fa fa-calculator text-warning me-2"></i>
                            <span class="fw-semibold">الحسابات التلقائية</span>
                        </button>
                    </h2>
                    <div id="tool4" class="accordion-collapse collapse" data-bs-parent="#toolsAccordion">
                        <div class="accordion-body small">
                            الإجمالي يُحسب تلقائياً: الكمية × سعر الوحدة. إجمالي المشروع يظهر أسفل الجدول.
                        </div>
                    </div>
                </div>
            </div>
        `,
        // صفحة الشركاء
        'partners': `
            <div class="accordion" id="toolsAccordion">
                <div class="accordion-item border-0 mb-2">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed bg-light rounded py-2" type="button" data-bs-toggle="collapse" data-bs-target="#tool1">
                            <i class="fa fa-user-plus text-success me-2"></i>
                            <span class="fw-semibold">إضافة شريك</span>
                        </button>
                    </h2>
                    <div id="tool1" class="accordion-collapse collapse" data-bs-parent="#toolsAccordion">
                        <div class="accordion-body small">
                            اختر المشروع أولاً، ثم اضغط "إضافة شريك" لتحديد الشريك ونسبة مشاركته.
                        </div>
                    </div>
                </div>
                <div class="accordion-item border-0 mb-2">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed bg-light rounded py-2" type="button" data-bs-toggle="collapse" data-bs-target="#tool2">
                            <i class="fa fa-percent text-info me-2"></i>
                            <span class="fw-semibold">نسبة المشاركة ورسوم الإدارة</span>
                        </button>
                    </h2>
                    <div id="tool2" class="accordion-collapse collapse" data-bs-parent="#toolsAccordion">
                        <div class="accordion-body small">
                            حدد نسبة الشريك من الأرباح ورسوم الإدارة التي تُخصم منه.
                        </div>
                    </div>
                </div>
                <div class="accordion-item border-0 mb-2">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed bg-light rounded py-2" type="button" data-bs-toggle="collapse" data-bs-target="#tool3">
                            <i class="fa fa-money-bill text-warning me-2"></i>
                            <span class="fw-semibold">تسجيل مسحوبات</span>
                        </button>
                    </h2>
                    <div id="tool3" class="accordion-collapse collapse" data-bs-parent="#toolsAccordion">
                        <div class="accordion-body small">
                            سجّل أي مبالغ يسحبها الشريك. تُخصم من رصيده المستحق.
                        </div>
                    </div>
                </div>
                <div class="accordion-item border-0 mb-2">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed bg-light rounded py-2" type="button" data-bs-toggle="collapse" data-bs-target="#tool4">
                            <i class="fa fa-chart-pie text-primary me-2"></i>
                            <span class="fw-semibold">توزيع الأرباح</span>
                        </button>
                    </h2>
                    <div id="tool4" class="accordion-collapse collapse" data-bs-parent="#toolsAccordion">
                        <div class="accordion-body small">
                            اضغط "توزيع" لحساب حصص الشركاء تلقائياً بناءً على النسب والمسحوبات.
                        </div>
                    </div>
                </div>
            </div>
        `,
        // العقود
        'contracts': `
            <div class="accordion" id="toolsAccordion">
                <div class="accordion-item border-0 mb-2">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed bg-light rounded py-2" type="button" data-bs-toggle="collapse" data-bs-target="#tool1">
                            <i class="fa fa-file-contract text-success me-2"></i>
                            <span class="fw-semibold">إنشاء عقد جديد</span>
                        </button>
                    </h2>
                    <div id="tool1" class="accordion-collapse collapse" data-bs-parent="#toolsAccordion">
                        <div class="accordion-body small">
                            اختر نوع العقد (بيع، مقاولة)، العميل/المقاول، القيمة، والشروط.
                        </div>
                    </div>
                </div>
                <div class="accordion-item border-0 mb-2">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed bg-light rounded py-2" type="button" data-bs-toggle="collapse" data-bs-target="#tool2">
                            <i class="fa fa-calendar-alt text-info me-2"></i>
                            <span class="fw-semibold">جدولة الدفعات</span>
                        </button>
                    </h2>
                    <div id="tool2" class="accordion-collapse collapse" data-bs-parent="#toolsAccordion">
                        <div class="accordion-body small">
                            حدد جدول الدفعات: الدفعة المقدمة، الأقساط، وتواريخ الاستحقاق.
                        </div>
                    </div>
                </div>
            </div>
        `,
        // المصروفات
        'expenses': `
            <div class="accordion" id="toolsAccordion">
                <div class="accordion-item border-0 mb-2">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed bg-light rounded py-2" type="button" data-bs-toggle="collapse" data-bs-target="#tool1">
                            <i class="fa fa-plus-circle text-success me-2"></i>
                            <span class="fw-semibold">تسجيل مصروف جديد</span>
                        </button>
                    </h2>
                    <div id="tool1" class="accordion-collapse collapse" data-bs-parent="#toolsAccordion">
                        <div class="accordion-body small">
                            حدد المشروع، الفئة، المبلغ، وأرفق الفاتورة أو الإيصال.
                        </div>
                    </div>
                </div>
                <div class="accordion-item border-0 mb-2">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed bg-light rounded py-2" type="button" data-bs-toggle="collapse" data-bs-target="#tool2">
                            <i class="fa fa-paperclip text-info me-2"></i>
                            <span class="fw-semibold">إرفاق المستندات</span>
                        </button>
                    </h2>
                    <div id="tool2" class="accordion-collapse collapse" data-bs-parent="#toolsAccordion">
                        <div class="accordion-body small">
                            اضغط "إرفاق" لرفع صور الفواتير والإيصالات للتوثيق.
                        </div>
                    </div>
                </div>
            </div>
        `,
        // عروض الأسعار
        'quotations': `
            <div class="accordion" id="toolsAccordion">
                <div class="accordion-item border-0 mb-2">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed bg-light rounded py-2" type="button" data-bs-toggle="collapse" data-bs-target="#tool1">
                            <i class="fa fa-file-invoice-dollar text-success me-2"></i>
                            <span class="fw-semibold">إنشاء عرض سعر</span>
                        </button>
                    </h2>
                    <div id="tool1" class="accordion-collapse collapse" data-bs-parent="#toolsAccordion">
                        <div class="accordion-body small">
                            اختر العميل، أضف البنود والأسعار، حدد شروط الدفع والصلاحية.
                        </div>
                    </div>
                </div>
                <div class="accordion-item border-0 mb-2">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed bg-light rounded py-2" type="button" data-bs-toggle="collapse" data-bs-target="#tool2">
                            <i class="fa fa-print text-info me-2"></i>
                            <span class="fw-semibold">طباعة وإرسال</span>
                        </button>
                    </h2>
                    <div id="tool2" class="accordion-collapse collapse" data-bs-parent="#toolsAccordion">
                        <div class="accordion-body small">
                            اطبع العرض بتنسيق احترافي أو أرسله للعميل عبر البريد الإلكتروني.
                        </div>
                    </div>
                </div>
                <div class="accordion-item border-0 mb-2">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed bg-light rounded py-2" type="button" data-bs-toggle="collapse" data-bs-target="#tool3">
                            <i class="fa fa-exchange-alt text-warning me-2"></i>
                            <span class="fw-semibold">تحويل لعقد</span>
                        </button>
                    </h2>
                    <div id="tool3" class="accordion-collapse collapse" data-bs-parent="#toolsAccordion">
                        <div class="accordion-body small">
                            بعد موافقة العميل، اضغط "تحويل لعقد" لإنشاء عقد تلقائياً من العرض.
                        </div>
                    </div>
                </div>
            </div>
        `,
        // العملاء المحتملين
        'leads': `
            <div class="accordion" id="toolsAccordion">
                <div class="accordion-item border-0 mb-2">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed bg-light rounded py-2" type="button" data-bs-toggle="collapse" data-bs-target="#tool1">
                            <i class="fa fa-user-plus text-success me-2"></i>
                            <span class="fw-semibold">إضافة عميل محتمل</span>
                        </button>
                    </h2>
                    <div id="tool1" class="accordion-collapse collapse" data-bs-parent="#toolsAccordion">
                        <div class="accordion-body small">
                            سجّل بيانات العميل المحتمل: الاسم، الهاتف، مصدر التواصل، واهتماماته.
                        </div>
                    </div>
                </div>
                <div class="accordion-item border-0 mb-2">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed bg-light rounded py-2" type="button" data-bs-toggle="collapse" data-bs-target="#tool2">
                            <i class="fa fa-phone text-info me-2"></i>
                            <span class="fw-semibold">جدولة المتابعة</span>
                        </button>
                    </h2>
                    <div id="tool2" class="accordion-collapse collapse" data-bs-parent="#toolsAccordion">
                        <div class="accordion-body small">
                            حدد موعد المتابعة القادم والملاحظات. ستظهر تذكيرات تلقائية.
                        </div>
                    </div>
                </div>
                <div class="accordion-item border-0 mb-2">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed bg-light rounded py-2" type="button" data-bs-toggle="collapse" data-bs-target="#tool3">
                            <i class="fa fa-user-check text-primary me-2"></i>
                            <span class="fw-semibold">تحويل لعميل</span>
                        </button>
                    </h2>
                    <div id="tool3" class="accordion-collapse collapse" data-bs-parent="#toolsAccordion">
                        <div class="accordion-body small">
                            عند إتمام الصفقة، حوّل العميل المحتمل لعميل فعلي في النظام.
                        </div>
                    </div>
                </div>
            </div>
        `,
        // التقويم
        'calendar': `
            <div class="accordion" id="toolsAccordion">
                <div class="accordion-item border-0 mb-2">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed bg-light rounded py-2" type="button" data-bs-toggle="collapse" data-bs-target="#tool1">
                            <i class="fa fa-plus text-success me-2"></i>
                            <span class="fw-semibold">إضافة موعد</span>
                        </button>
                    </h2>
                    <div id="tool1" class="accordion-collapse collapse" data-bs-parent="#toolsAccordion">
                        <div class="accordion-body small">
                            اضغط على أي تاريخ لإضافة موعد أو اجتماع. حدد الوقت والمشاركين.
                        </div>
                    </div>
                </div>
                <div class="accordion-item border-0 mb-2">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed bg-light rounded py-2" type="button" data-bs-toggle="collapse" data-bs-target="#tool2">
                            <i class="fa fa-eye text-info me-2"></i>
                            <span class="fw-semibold">تبديل العرض</span>
                        </button>
                    </h2>
                    <div id="tool2" class="accordion-collapse collapse" data-bs-parent="#toolsAccordion">
                        <div class="accordion-body small">
                            اختر العرض المناسب: يومي، أسبوعي، أو شهري.
                        </div>
                    </div>
                </div>
            </div>
        `,
        // المستخدمين
        'users': `
            <div class="accordion" id="toolsAccordion">
                <div class="accordion-item border-0 mb-2">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed bg-light rounded py-2" type="button" data-bs-toggle="collapse" data-bs-target="#tool1">
                            <i class="fa fa-user-plus text-success me-2"></i>
                            <span class="fw-semibold">إضافة مستخدم</span>
                        </button>
                    </h2>
                    <div id="tool1" class="accordion-collapse collapse" data-bs-parent="#toolsAccordion">
                        <div class="accordion-body small">
                            أنشئ حساب جديد: الاسم، البريد، كلمة المرور، والدور (مدير، موظف...).
                        </div>
                    </div>
                </div>
                <div class="accordion-item border-0 mb-2">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed bg-light rounded py-2" type="button" data-bs-toggle="collapse" data-bs-target="#tool2">
                            <i class="fa fa-key text-warning me-2"></i>
                            <span class="fw-semibold">إدارة الصلاحيات</span>
                        </button>
                    </h2>
                    <div id="tool2" class="accordion-collapse collapse" data-bs-parent="#toolsAccordion">
                        <div class="accordion-body small">
                            حدد ما يمكن للمستخدم الوصول إليه: المشاريع، المالية، التقارير...
                        </div>
                    </div>
                </div>
            </div>
        `
    };

    // الأدوات الافتراضية للصفحات غير المعرّفة
    const defaultTools = `
        <div class="accordion" id="toolsAccordion">
            <div class="accordion-item border-0 mb-2">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed bg-light rounded py-2" type="button" data-bs-toggle="collapse" data-bs-target="#tool1">
                        <i class="fa fa-plus text-success me-2"></i>
                        <span class="fw-semibold">إضافة عنصر جديد</span>
                    </button>
                </h2>
                <div id="tool1" class="accordion-collapse collapse" data-bs-parent="#toolsAccordion">
                    <div class="accordion-body small">
                        ابحث عن زر "إضافة" أو "إنشاء جديد" في أعلى الصفحة لإضافة عنصر جديد.
                    </div>
                </div>
            </div>
            <div class="accordion-item border-0 mb-2">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed bg-light rounded py-2" type="button" data-bs-toggle="collapse" data-bs-target="#tool2">
                        <i class="fa fa-search text-info me-2"></i>
                        <span class="fw-semibold">البحث والفلترة</span>
                    </button>
                </h2>
                <div id="tool2" class="accordion-collapse collapse" data-bs-parent="#toolsAccordion">
                    <div class="accordion-body small">
                        استخدم حقل البحث أو القوائم المنسدلة لتصفية العناصر.
                    </div>
                </div>
            </div>
            <div class="accordion-item border-0 mb-2">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed bg-light rounded py-2" type="button" data-bs-toggle="collapse" data-bs-target="#tool3">
                        <i class="fa fa-ellipsis-v text-muted me-2"></i>
                        <span class="fw-semibold">الإجراءات</span>
                    </button>
                </h2>
                <div id="tool3" class="accordion-collapse collapse" data-bs-parent="#toolsAccordion">
                    <div class="accordion-body small">
                        اضغط "الإجراءات" بجانب كل عنصر لعرض، تعديل، أو حذف.
                    </div>
                </div>
            </div>
        </div>
    `;

    // أدوات النوافذ المنبثقة
    const modalTools = {
        'addBoqItemModal': `
            <div class="accordion" id="toolsAccordion">
                <div class="accordion-item border-0 mb-2">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed bg-light rounded py-2" type="button" data-bs-toggle="collapse" data-bs-target="#tool1">
                            <i class="fa fa-list text-primary me-2"></i>
                            <span class="fw-semibold">القائمة المنسدلة للوصف</span>
                        </button>
                    </h2>
                    <div id="tool1" class="accordion-collapse collapse" data-bs-parent="#toolsAccordion">
                        <div class="accordion-body small">
                            اختر وصف البند من القائمة الجاهزة أو اكتب وصفاً جديداً.
                        </div>
                    </div>
                </div>
                <div class="accordion-item border-0 mb-2">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed bg-light rounded py-2" type="button" data-bs-toggle="collapse" data-bs-target="#tool2">
                            <i class="fa fa-cog text-secondary me-2"></i>
                            <span class="fw-semibold">زر إدارة الأوصاف</span>
                        </button>
                    </h2>
                    <div id="tool2" class="accordion-collapse collapse" data-bs-parent="#toolsAccordion">
                        <div class="accordion-body small">
                            اضغط على أيقونة الترس لفتح نافذة إدارة الأوصاف المسبقة.
                        </div>
                    </div>
                </div>
            </div>
        `,
        'managePresetsModal': `
            <div class="accordion" id="toolsAccordion">
                <div class="accordion-item border-0 mb-2">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed bg-light rounded py-2" type="button" data-bs-toggle="collapse" data-bs-target="#tool1">
                            <i class="fa fa-plus text-success me-2"></i>
                            <span class="fw-semibold">إضافة وصف جديد</span>
                        </button>
                    </h2>
                    <div id="tool1" class="accordion-collapse collapse" data-bs-parent="#toolsAccordion">
                        <div class="accordion-body small">
                            اكتب الوصف في الحقل واضغط "إضافة" لحفظه في القائمة.
                        </div>
                    </div>
                </div>
                <div class="accordion-item border-0 mb-2">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed bg-light rounded py-2" type="button" data-bs-toggle="collapse" data-bs-target="#tool2">
                            <i class="fa fa-edit text-warning me-2"></i>
                            <span class="fw-semibold">تعديل وحذف</span>
                        </button>
                    </h2>
                    <div id="tool2" class="accordion-collapse collapse" data-bs-parent="#toolsAccordion">
                        <div class="accordion-body small">
                            استخدم أيقونات التعديل والحذف بجانب كل وصف لتغييره أو إزالته.
                        </div>
                    </div>
                </div>
            </div>
        `,
        'addPartnerModal': `
            <div class="accordion" id="toolsAccordion">
                <div class="accordion-item border-0 mb-2">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed bg-light rounded py-2" type="button" data-bs-toggle="collapse" data-bs-target="#tool1">
                            <i class="fa fa-user text-primary me-2"></i>
                            <span class="fw-semibold">اختيار الشريك</span>
                        </button>
                    </h2>
                    <div id="tool1" class="accordion-collapse collapse" data-bs-parent="#toolsAccordion">
                        <div class="accordion-body small">
                            اختر الشريك من القائمة المنسدلة. إذا لم يكن موجوداً، أضفه أولاً من قسم المستخدمين.
                        </div>
                    </div>
                </div>
                <div class="accordion-item border-0 mb-2">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed bg-light rounded py-2" type="button" data-bs-toggle="collapse" data-bs-target="#tool2">
                            <i class="fa fa-percent text-info me-2"></i>
                            <span class="fw-semibold">تحديد النسب</span>
                        </button>
                    </h2>
                    <div id="tool2" class="accordion-collapse collapse" data-bs-parent="#toolsAccordion">
                        <div class="accordion-body small">
                            أدخل نسبة المشاركة (من الأرباح) ورسوم الإدارة (تُخصم من حصة الشريك).
                        </div>
                    </div>
                </div>
            </div>
        `
    };

    // تعريفات المساعدة لكل صفحة ونافذة منبثقة
    const pageHelp = {
        // لوحة التحكم
        'home': {
            title: 'لوحة التحكم',
            content: `
                <ul>
                    <li><strong>نظرة عامة:</strong> ملخص سريع لحالة المشاريع والمهام</li>
                    <li><strong>الإحصائيات:</strong> أرقام ومؤشرات الأداء الرئيسية</li>
                    <li><strong>التنبيهات:</strong> إشعارات بالمهام والمواعيد القادمة</li>
                    <li><strong>الوصول السريع:</strong> روابط للأقسام الأكثر استخداماً</li>
                </ul>
            `
        },
        'dashboard': {
            title: 'لوحة التحكم',
            content: `
                <ul>
                    <li><strong>نظرة عامة:</strong> ملخص سريع لحالة المشاريع والمهام</li>
                    <li><strong>الإحصائيات:</strong> أرقام ومؤشرات الأداء الرئيسية</li>
                    <li><strong>التنبيهات:</strong> إشعارات بالمهام والمواعيد القادمة</li>
                    <li><strong>الوصول السريع:</strong> روابط للأقسام الأكثر استخداماً</li>
                </ul>
            `
        },
        // صفحات المشاريع
        'projects': {
            title: 'إدارة المشاريع',
            content: `
                <ul>
                    <li><strong>إنشاء مشروع:</strong> اضغط "مشروع جديد" وأدخل البيانات</li>
                    <li><strong>حالة المشروع:</strong> تتبع حالة التنفيذ والتقدم</li>
                    <li><strong>الميزانية:</strong> راقب المصروفات والإيرادات</li>
                    <li><strong>الجدول الزمني:</strong> تابع المواعيد والمراحل</li>
                    <li><strong>فريق العمل:</strong> إدارة المشاركين في المشروع</li>
                </ul>
            `
        },
        // صفحات المهام
        'tasks': {
            title: 'إدارة المهام',
            content: `
                <ul>
                    <li><strong>إنشاء مهمة:</strong> حدد العنوان والوصف والمسؤول</li>
                    <li><strong>الأولوية:</strong> عاجل، مهم، عادي</li>
                    <li><strong>الحالة:</strong> جديد، قيد التنفيذ، مكتمل</li>
                    <li><strong>تاريخ الاستحقاق:</strong> حدد الموعد النهائي</li>
                    <li><strong>المتابعة:</strong> تتبع تقدم المهام يومياً</li>
                </ul>
            `
        },
        // صفحات العملاء
        'clients': {
            title: 'إدارة العملاء',
            content: `
                <ul>
                    <li><strong>إضافة عميل:</strong> أدخل بيانات العميل الأساسية</li>
                    <li><strong>معلومات الاتصال:</strong> الهاتف والبريد والعنوان</li>
                    <li><strong>العقود:</strong> تتبع عقود العميل</li>
                    <li><strong>المدفوعات:</strong> راقب حالة المدفوعات</li>
                    <li><strong>التاريخ:</strong> سجل التعاملات مع العميل</li>
                </ul>
            `
        },
        // صفحات المصروفات
        'expenses': {
            title: 'إدارة المصروفات',
            content: `
                <ul>
                    <li><strong>تسجيل مصروف:</strong> أضف المصروف مع الفئة والمشروع</li>
                    <li><strong>المرفقات:</strong> أرفق الفواتير والإيصالات</li>
                    <li><strong>الموافقة:</strong> تتبع حالة الموافقة على المصروف</li>
                    <li><strong>التقارير:</strong> استعرض تقارير المصروفات</li>
                    <li><strong>التصنيف:</strong> صنّف المصروفات حسب النوع</li>
                </ul>
            `
        },
        // الشئون المالية
        'financial': {
            title: 'الشئون المالية',
            content: `
                <ul>
                    <li><strong>المستخلصات:</strong> إدارة مستخلصات المشاريع</li>
                    <li><strong>طلبات الدفع:</strong> متابعة طلبات الصرف</li>
                    <li><strong>الإشعارات:</strong> إشعارات دائنة ومدينة</li>
                    <li><strong>المدفوعات:</strong> تسجيل ومتابعة المدفوعات</li>
                    <li><strong>التقارير:</strong> تقارير مالية شاملة</li>
                </ul>
            `
        },
        // المستخلصات
        'extracts': {
            title: 'المستخلصات',
            content: `
                <ul>
                    <li><strong>إنشاء مستخلص:</strong> أنشئ مستخلص جديد للمشروع</li>
                    <li><strong>البنود:</strong> أضف بنود الأعمال المنجزة</li>
                    <li><strong>النسب:</strong> حدد نسبة الإنجاز لكل بند</li>
                    <li><strong>المراجعة:</strong> راجع واعتمد المستخلص</li>
                </ul>
            `
        },
        // طلبات الدفع
        'payment': {
            title: 'طلبات الدفع',
            content: `
                <ul>
                    <li><strong>طلب جديد:</strong> أنشئ طلب دفع جديد</li>
                    <li><strong>المستندات:</strong> أرفق المستندات المطلوبة</li>
                    <li><strong>الموافقات:</strong> تتبع سير الموافقات</li>
                    <li><strong>الصرف:</strong> تأكيد الصرف وتسجيله</li>
                </ul>
            `
        },
        // المدفوعات
        'payments': {
            title: 'المدفوعات',
            content: `
                <ul>
                    <li><strong>تسجيل دفعة:</strong> سجّل الدفعات الواردة والصادرة</li>
                    <li><strong>طرق الدفع:</strong> نقدي، تحويل، شيك</li>
                    <li><strong>الإيصالات:</strong> أرفق إيصالات الدفع</li>
                    <li><strong>التقارير:</strong> تقارير المدفوعات</li>
                </ul>
            `
        },
        // صفحات العقود
        'contracts': {
            title: 'إدارة العقود',
            content: `
                <ul>
                    <li><strong>إنشاء عقد:</strong> اضغط "عقد جديد" واختر النوع</li>
                    <li><strong>عقود المقاولين:</strong> عقود مع مقاولي الباطن</li>
                    <li><strong>عقود البيع:</strong> عقود بيع الوحدات</li>
                    <li><strong>الدفعات:</strong> تسجيل ومتابعة الدفعات</li>
                    <li><strong>الملحقات:</strong> إضافة ملحقات للعقود</li>
                </ul>
            `
        },
        // العقارات
        'real_estate': {
            title: 'إدارة العقارات',
            content: `
                <ul>
                    <li><strong>الوحدات:</strong> إدارة الوحدات العقارية</li>
                    <li><strong>الحالة:</strong> متاح، محجوز، مباع</li>
                    <li><strong>الأسعار:</strong> تحديد أسعار الوحدات</li>
                    <li><strong>المواصفات:</strong> تفاصيل كل وحدة</li>
                    <li><strong>المواد:</strong> إدارة مواد البناء والأسعار</li>
                </ul>
            `
        },
        'properties': {
            title: 'إدارة العقارات',
            content: `
                <ul>
                    <li><strong>الوحدات:</strong> إدارة الوحدات العقارية</li>
                    <li><strong>الحالة:</strong> متاح، محجوز، مباع</li>
                    <li><strong>الأسعار:</strong> تحديد أسعار الوحدات</li>
                    <li><strong>المواصفات:</strong> تفاصيل كل وحدة</li>
                </ul>
            `
        },
        // المقاولات
        'contractors': {
            title: 'إدارة المقاولات',
            content: `
                <ul>
                    <li><strong>المقاولين:</strong> إدارة بيانات المقاولين</li>
                    <li><strong>العقود:</strong> عقود المقاولات الفرعية</li>
                    <li><strong>الأعمال:</strong> متابعة أعمال كل مقاول</li>
                    <li><strong>المستحقات:</strong> حساب مستحقات المقاولين</li>
                    <li><strong>التقييم:</strong> تقييم أداء المقاولين</li>
                </ul>
            `
        },
        'subcontract': {
            title: 'عقود المقاولين',
            content: `
                <ul>
                    <li><strong>إنشاء عقد:</strong> أنشئ عقد مع مقاول باطن</li>
                    <li><strong>البنود:</strong> حدد بنود وأسعار العقد</li>
                    <li><strong>المدفوعات:</strong> جدولة وتسجيل الدفعات</li>
                    <li><strong>المتابعة:</strong> تتبع تنفيذ الأعمال</li>
                </ul>
            `
        },
        // المشتريات
        'purchases': {
            title: 'إدارة المشتريات',
            content: `
                <ul>
                    <li><strong>طلب شراء:</strong> إنشاء طلبات الشراء</li>
                    <li><strong>الموردين:</strong> إدارة بيانات الموردين</li>
                    <li><strong>عروض الأسعار:</strong> مقارنة عروض الموردين</li>
                    <li><strong>أوامر الشراء:</strong> إصدار أوامر الشراء</li>
                    <li><strong>الاستلام:</strong> تسجيل استلام المواد</li>
                </ul>
            `
        },
        // صفحات الشركاء
        'partners': {
            title: 'إدارة الشركاء',
            content: `
                <ul>
                    <li><strong>إضافة شريك:</strong> اختر المشروع ثم اضغط "إضافة شريك"</li>
                    <li><strong>نسبة المشاركة:</strong> حدد نسبة الشريك من أرباح المشروع</li>
                    <li><strong>رسوم الإدارة:</strong> نسبة تُخصم من أرباح الشريك كرسوم إدارية</li>
                    <li><strong>تسجيل مسحوبات:</strong> سجّل المبالغ المسحوبة من قِبل الشريك</li>
                    <li><strong>التوزيع:</strong> اضغط "توزيع" لحساب حصص الشركاء</li>
                </ul>
            `
        },
        // عروض الأسعار
        'quotations': {
            title: 'عروض الأسعار',
            content: `
                <ul>
                    <li><strong>إنشاء عرض:</strong> أنشئ عرض سعر للعميل</li>
                    <li><strong>البنود:</strong> أضف بنود العرض والأسعار</li>
                    <li><strong>الشروط:</strong> حدد شروط الدفع والتسليم</li>
                    <li><strong>الحالة:</strong> تتبع قبول أو رفض العرض</li>
                    <li><strong>التحويل:</strong> حوّل العرض لعقد بعد القبول</li>
                </ul>
            `
        },
        // العملاء المحتملين
        'leads': {
            title: 'العملاء المحتملين',
            content: `
                <ul>
                    <li><strong>إضافة عميل محتمل:</strong> سجّل بيانات العميل المحتمل</li>
                    <li><strong>المصدر:</strong> حدد مصدر العميل المحتمل</li>
                    <li><strong>المتابعة:</strong> جدولة مواعيد المتابعة</li>
                    <li><strong>الحالة:</strong> جديد، قيد التواصل، مؤهل، محوّل</li>
                    <li><strong>التحويل:</strong> حوّل العميل المحتمل لعميل فعلي</li>
                </ul>
            `
        },
        // طلبات الموظفين
        'employee': {
            title: 'طلبات الموظفين',
            content: `
                <ul>
                    <li><strong>طلب جديد:</strong> تقديم طلب إجازة أو سلفة</li>
                    <li><strong>أنواع الطلبات:</strong> إجازة، سلفة، عهدة، أخرى</li>
                    <li><strong>الموافقات:</strong> تتبع حالة الموافقة</li>
                    <li><strong>السجل:</strong> عرض سجل الطلبات السابقة</li>
                </ul>
            `
        },
        // صفحات BOQ
        'boq': {
            title: 'جدول الكميات (BOQ)',
            content: `
                <ul>
                    <li><strong>إضافة بند:</strong> اضغط "إضافة بند جديد" لإضافة عنصر للجدول</li>
                    <li><strong>وصف البند:</strong> اختر من القائمة المنسدلة أو أضف وصف جديد</li>
                    <li><strong>الكمية والوحدة:</strong> أدخل الكمية واختر وحدة القياس</li>
                    <li><strong>سعر الوحدة:</strong> أدخل السعر وسيتم حساب الإجمالي تلقائياً</li>
                    <li><strong>تحليل البند:</strong> اضغط "تحليل" لتفصيل مكونات البند</li>
                </ul>
            `
        },
        'breakdown': {
            title: 'تحليل البنود',
            content: `
                <ul>
                    <li><strong>إضافة عنصر:</strong> اضغط "إضافة عنصر" لإضافة مكون للبند</li>
                    <li><strong>أنواع العناصر:</strong> مواد، عمالة، معدات، مقاولين</li>
                    <li><strong>الكمية:</strong> أدخل الكمية المطلوبة لكل عنصر</li>
                    <li><strong>الإجمالي:</strong> يتم حسابه تلقائياً من الكمية × السعر</li>
                </ul>
            `
        },
        // صفحات مواد البناء
        'materials': {
            title: 'إدارة مواد البناء',
            content: `
                <ul>
                    <li><strong>إضافة مادة:</strong> أضف اسم المادة والوحدة والسعر</li>
                    <li><strong>تحديث السعر:</strong> حدّث أسعار المواد دورياً</li>
                    <li><strong>تاريخ الأسعار:</strong> تتبع تغيرات الأسعار</li>
                    <li><strong>الفئات:</strong> صنّف المواد حسب النوع</li>
                </ul>
            `
        },
        // الجدول الزمني
        'schedule': {
            title: 'الجدول الزمني',
            content: `
                <ul>
                    <li><strong>إضافة مهمة:</strong> أضف مهام المشروع بالتواريخ</li>
                    <li><strong>التبعيات:</strong> حدد العلاقات بين المهام</li>
                    <li><strong>نسبة الإنجاز:</strong> حدّث نسبة التقدم</li>
                    <li><strong>عرض Gantt:</strong> شاهد الجدول الزمني بصرياً</li>
                </ul>
            `
        },
        // البناء والتشييد
        'construction': {
            title: 'إدارة البناء والتشييد',
            content: `
                <ul>
                    <li><strong>المشاريع:</strong> إدارة مشاريع البناء</li>
                    <li><strong>جدول الكميات:</strong> BOQ لكل مشروع</li>
                    <li><strong>التقدم:</strong> متابعة نسب الإنجاز</li>
                    <li><strong>التكاليف:</strong> مراقبة تكاليف البناء</li>
                </ul>
            `
        },
        // المبيعات
        'sales': {
            title: 'إدارة المبيعات',
            content: `
                <ul>
                    <li><strong>العقود:</strong> إدارة عقود البيع</li>
                    <li><strong>الدفعات:</strong> تسجيل دفعات العملاء</li>
                    <li><strong>الأقساط:</strong> جدولة ومتابعة الأقساط</li>
                    <li><strong>التقارير:</strong> تقارير المبيعات</li>
                </ul>
            `
        },
        // المستخدمين
        'users': {
            title: 'إدارة المستخدمين',
            content: `
                <ul>
                    <li><strong>إضافة مستخدم:</strong> إنشاء حساب مستخدم جديد</li>
                    <li><strong>الصلاحيات:</strong> تحديد صلاحيات المستخدم</li>
                    <li><strong>الأدوار:</strong> تعيين دور المستخدم</li>
                    <li><strong>التفعيل:</strong> تفعيل أو تعطيل الحساب</li>
                </ul>
            `
        },
        // التقويم
        'calendar': {
            title: 'التقويم والمواعيد',
            content: `
                <ul>
                    <li><strong>إضافة موعد:</strong> جدولة موعد أو اجتماع</li>
                    <li><strong>التذكيرات:</strong> إعداد تذكيرات المواعيد</li>
                    <li><strong>المهام:</strong> عرض المهام المجدولة</li>
                    <li><strong>العرض:</strong> يومي، أسبوعي، شهري</li>
                </ul>
            `
        },
        // التنبيهات
        'notifications': {
            title: 'التنبيهات',
            content: `
                <ul>
                    <li><strong>الإشعارات:</strong> عرض جميع الإشعارات</li>
                    <li><strong>القراءة:</strong> تحديد كمقروء أو غير مقروء</li>
                    <li><strong>الإعدادات:</strong> تخصيص إعدادات الإشعارات</li>
                </ul>
            `
        }
    };

    // مساعدة النوافذ المنبثقة
    const modalHelp = {
        'addBoqItemModal': {
            title: 'إضافة بند BOQ جديد',
            content: `
                <ul>
                    <li><strong>الكود:</strong> رمز تعريفي للبند (اختياري)</li>
                    <li><strong>وصف البند:</strong> اختر من القائمة أو أضف وصف جديد من زر الإعدادات</li>
                    <li><strong>الكمية:</strong> أدخل الكمية المطلوبة</li>
                    <li><strong>الوحدة:</strong> اختر وحدة القياس (متر، طن، قطعة...)</li>
                    <li><strong>سعر الوحدة:</strong> أدخل سعر الوحدة الواحدة</li>
                    <li><strong>التواريخ:</strong> حدد تاريخ البدء والانتهاء المتوقع</li>
                </ul>
            `
        },
        'managePresetsModal': {
            title: 'إدارة أوصاف البنود المسبقة',
            content: `
                <ul>
                    <li><strong>إضافة وصف:</strong> اكتب الوصف واضغط "إضافة"</li>
                    <li><strong>تعديل:</strong> اضغط أيقونة التعديل لتغيير الوصف</li>
                    <li><strong>حذف:</strong> اضغط أيقونة الحذف لإزالة الوصف</li>
                    <li><strong>الفائدة:</strong> توفير الوقت بتجنب إعادة كتابة الأوصاف</li>
                </ul>
            `
        },
        'addPartnerModal': {
            title: 'إضافة شريك للمشروع',
            content: `
                <ul>
                    <li><strong>الشريك:</strong> اختر الشريك من القائمة</li>
                    <li><strong>نسبة المشاركة:</strong> النسبة من أرباح المشروع</li>
                    <li><strong>رسوم الإدارة:</strong> نسبة تُخصم كرسوم إدارية</li>
                </ul>
            `
        },
        'addItemModal': {
            title: 'إضافة عنصر تحليل',
            content: `
                <ul>
                    <li><strong>نوع العنصر:</strong> مواد، عمالة، معدات، مقاول</li>
                    <li><strong>الوصف:</strong> وصف تفصيلي للعنصر</li>
                    <li><strong>الكمية:</strong> الكمية المطلوبة</li>
                    <li><strong>سعر الوحدة:</strong> تكلفة الوحدة الواحدة</li>
                </ul>
            `
        }
    };

    // تحديث المساعدة السياقية عند فتح نافذة المساعدة
    const helpOffcanvas = document.getElementById('globalHelpOffcanvas');
    if (helpOffcanvas) {
        helpOffcanvas.addEventListener('show.bs.offcanvas', function() {
            updateContextHelp();
        });
    }

    // تحديث المساعدة عند فتح أي modal
    document.addEventListener('shown.bs.modal', function(e) {
        const modalId = e.target.id;
        window.currentModalId = modalId;
        if (modalHelp[modalId]) {
            // تخزين معلومات النافذة المنبثقة الحالية
            window.currentModalHelp = modalHelp[modalId];
        }
    });

    document.addEventListener('hidden.bs.modal', function() {
        window.currentModalHelp = null;
        window.currentModalId = null;
    });

    function updateContextHelp() {
        const contextSection = document.getElementById('contextHelpSection');
        const contextContent = document.getElementById('contextHelpContent');
        const pageTitle = document.getElementById('helpCurrentPageTitle');
        const toolsSection = document.getElementById('pageToolsSection');
        const toolsContent = document.getElementById('pageToolsContent');
        
        // تحديث عنوان الصفحة
        const currentTitle = document.querySelector('.page-heading, h1')?.textContent || document.title.replace('Link Masr | ', '');
        if (pageTitle) {
            pageTitle.textContent = currentTitle;
        }

        const currentPath = window.location.pathname.toLowerCase();

        // التحقق من وجود نافذة منبثقة مفتوحة
        if (window.currentModalHelp) {
            // عرض مساعدة النافذة المنبثقة
            contextSection.style.display = 'block';
            contextSection.classList.remove('bg-light-success');
            contextSection.classList.add('bg-light-warning');
            contextSection.querySelector('h6').innerHTML = '<i class="fa fa-window-restore me-2"></i>مساعدة النافذة الحالية';
            contextSection.querySelector('h6').classList.remove('text-success');
            contextSection.querySelector('h6').classList.add('text-warning');
            contextContent.innerHTML = `<p class="fw-bold mb-2">${window.currentModalHelp.title}</p>${window.currentModalHelp.content}`;
            
            // عرض أدوات النافذة المنبثقة
            if (toolsSection && toolsContent) {
                const modalId = window.currentModalId || '';
                toolsSection.querySelector('h6').innerHTML = '<i class="fa fa-tools me-2"></i>أدوات هذه النافذة';
                toolsContent.innerHTML = modalTools[modalId] || defaultTools;
            }
            return;
        }

        // البحث عن مساعدة الصفحة الحالية
        let foundHelp = null;
        let foundTools = null;
        let matchedKey = '';

        for (const [key, help] of Object.entries(pageHelp)) {
            if (currentPath.includes(key)) {
                foundHelp = help;
                matchedKey = key;
                break;
            }
        }

        // تحديث قسم المساعدة
        if (foundHelp) {
            contextSection.style.display = 'block';
            contextSection.classList.remove('bg-light-warning');
            contextSection.classList.add('bg-light-success');
            contextSection.querySelector('h6').innerHTML = '<i class="fa fa-info-circle me-2"></i>وصف هذه الصفحة';
            contextSection.querySelector('h6').classList.remove('text-warning');
            contextSection.querySelector('h6').classList.add('text-success');
            contextContent.innerHTML = `<p class="fw-bold mb-2">${foundHelp.title}</p>${foundHelp.content}`;
        } else {
            contextSection.style.display = 'none';
        }

        // تحديث قسم الأدوات
        if (toolsSection && toolsContent) {
            toolsSection.querySelector('h6').innerHTML = '<i class="fa fa-tools me-2"></i>أدوات هذه الصفحة';
            
            // البحث عن أدوات الصفحة
            for (const [key, tools] of Object.entries(pageTools)) {
                if (currentPath.includes(key)) {
                    foundTools = tools;
                    break;
                }
            }
            
            toolsContent.innerHTML = foundTools || defaultTools;
        }
    }

    // تحديث المساعدة عند تغيير الصفحة (للـ SPA)
    window.addEventListener('popstate', updateContextHelp);
});
</script>
