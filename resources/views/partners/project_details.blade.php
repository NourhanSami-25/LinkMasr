@extends('layout.app')

@section('title')
    {{ __('تفاصيل المشروع') }} - {{ $project->subject }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item text-muted">
        <a href="{{ route('partners.dashboard', $partner->id) }}" class="text-muted text-hover-primary">{{ __('لوحة الشريك') }}</a>
    </li>
    <li class="breadcrumb-item text-muted">{{ $project->subject }}</li>
@endsection

@section('content')
<!-- Help Button -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="mb-0">
        <i class="fa fa-building text-primary me-2"></i>
        {{ $project->subject }}
    </h3>
    <div>
        <button class="btn btn-light-primary me-2" onclick="window.print()">
            <i class="fa fa-print me-1"></i> {{ __('general.print') ?? 'Print' }}
        </button>
        <button class="btn btn-light-info" type="button" data-bs-toggle="offcanvas" data-bs-target="#helpOffcanvas">
            <i class="fa fa-question-circle me-2"></i> {{ __('general.help') ?? 'Help' }}
        </button>
    </div>
</div>

@php
    $partnerData = $project->partners->where('id', $partner->id)->first();
@endphp

<!-- Partner Info Card -->
<div class="card mb-5">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <h5 class="text-primary mb-3">{{ __('بيانات الشريك') }}</h5>
                <div class="d-flex align-items-center mb-3">
                    <div class="symbol symbol-50px me-3">
                        <span class="symbol-label bg-light-primary text-primary fs-2 fw-bold">
                            {{ substr($partner->name, 0, 1) }}
                        </span>
                    </div>
                    <div>
                        <h4 class="mb-0">{{ $partner->name }}</h4>
                        <span class="text-muted">{{ $partner->email }}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <h5 class="text-primary mb-3">{{ __('نسب المشاركة') }}</h5>
                <div class="row">
                    <div class="col-6">
                        <div class="border rounded p-3 text-center bg-light-success">
                            <span class="fs-3 fw-bold text-success">{{ $partnerData->pivot->share_percentage ?? $partnerData->pivot->capital_share ?? 0 }}%</span>
                            <br>
                            <small class="text-muted">{{ __('نسبة رأس المال') }}</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="border rounded p-3 text-center bg-light-info">
                            <span class="fs-3 fw-bold text-info">{{ $partnerData->pivot->management_fee_percentage ?? $partnerData->pivot->management_fee ?? 0 }}%</span>
                            <br>
                            <small class="text-muted">{{ __('نسبة أتعاب الإدارة') }}</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Financial Summary -->
<div class="row mb-5">
    <div class="col-md-3">
        <div class="card bg-success text-white h-100">
            <div class="card-body">
                <h6 class="card-title opacity-75">{{ __('الأرباح من المشروع') }}</h6>
                <h3 class="mb-0">{{ number_format($statement['total_earnings'], 0) }}</h3>
                <small>{{ __('جنيه') }}</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-info text-white h-100">
            <div class="card-body">
                <h6 class="card-title opacity-75">{{ __('أتعاب الإدارة') }}</h6>
                <h3 class="mb-0">{{ number_format($statement['total_management_fees'], 0) }}</h3>
                <small>{{ __('جنيه') }}</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-warning text-white h-100">
            <div class="card-body">
                <h6 class="card-title opacity-75">{{ __('المسحوبات') }}</h6>
                <h3 class="mb-0">{{ number_format($statement['total_withdrawals'], 0) }}</h3>
                <small>{{ __('جنيه') }}</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-primary text-white h-100">
            <div class="card-body">
                <h6 class="card-title opacity-75">{{ __('الرصيد المتاح') }}</h6>
                <h3 class="mb-0">{{ number_format($statement['balance'], 0) }}</h3>
                <small>{{ __('جنيه') }}</small>
            </div>
        </div>
    </div>
</div>

<!-- Distribution Details -->
<div class="card mb-5">
    <div class="card-header">
        <h4 class="card-title mb-0">{{ __('تفاصيل التوزيع الحالي') }}</h4>
    </div>
    <div class="card-body">
        @if(isset($distribution) && $distribution)
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="bg-light rounded p-3">
                    <small class="text-muted d-block">{{ __('إجمالي الإيرادات') }}</small>
                    <span class="fs-4 fw-bold text-success">{{ number_format($distribution['total_revenue'], 2) }}</span>
                </div>
            </div>
            <div class="col-md-4">
                <div class="bg-light rounded p-3">
                    <small class="text-muted d-block">{{ __('مصروفات رأسمالية') }}</small>
                    <span class="fs-4 fw-bold text-danger">{{ number_format($distribution['capital_expenses'], 2) }}</span>
                </div>
            </div>
            <div class="col-md-4">
                <div class="bg-light rounded p-3">
                    <small class="text-muted d-block">{{ __('مصروفات تشغيلية') }}</small>
                    <span class="fs-4 fw-bold text-warning">{{ number_format($distribution['revenue_expenses'], 2) }}</span>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-6">
                <div class="bg-light-primary rounded p-3">
                    <small class="text-muted d-block">{{ __('نقطة التعادل') }}</small>
                    <span class="fs-4 fw-bold">{{ number_format($distribution['breakeven_point'], 2) }}</span>
                    @if($distribution['breakeven_reached'])
                        <span class="badge bg-success ms-2">{{ __('تم الوصول') }}</span>
                    @else
                        <span class="badge bg-warning ms-2">{{ __('لم يتم الوصول بعد') }}</span>
                    @endif
                </div>
            </div>
            <div class="col-md-6">
                <div class="bg-light-success rounded p-3">
                    <small class="text-muted d-block">{{ __('المبلغ القابل للتوزيع') }}</small>
                    <span class="fs-4 fw-bold text-success">{{ number_format($distribution['distributable_amount'], 2) }}</span>
                </div>
            </div>
        </div>

        @if(!empty($distribution['partner_distributions']) && isset($distribution['partner_distributions'][$partner->id]))
            @php $myDistribution = $distribution['partner_distributions'][$partner->id]; @endphp
            <div class="alert alert-light-primary border-primary border-dashed">
                <h5 class="text-primary mb-3">{{ __('نصيبك من هذا التوزيع') }}</h5>
                <div class="row">
                    <div class="col-md-4">
                        <small class="text-muted">{{ __('نصيب رأس المال') }}</small>
                        <h4 class="mb-0 text-success">{{ number_format($myDistribution['share_amount'] ?? 0, 2) }}</h4>
                    </div>
                    <div class="col-md-4">
                        <small class="text-muted">{{ __('أتعاب الإدارة') }}</small>
                        <h4 class="mb-0 text-info">{{ number_format($myDistribution['management_fee_amount'] ?? 0, 2) }}</h4>
                    </div>
                    <div class="col-md-4">
                        <small class="text-muted">{{ __('الإجمالي') }}</small>
                        <h4 class="mb-0 text-primary">{{ number_format($myDistribution['total_amount'] ?? 0, 2) }}</h4>
                    </div>
                </div>
            </div>
        @endif
        @else
        <div class="text-center py-5 text-muted">
            <i class="fa fa-calculator fs-3x mb-3"></i>
            <p>{{ __('لا يوجد توزيع محسوب حالياً') }}</p>
        </div>
        @endif
    </div>
</div>

<!-- Distributions History -->
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">{{ __('سجل التوزيعات') }}</h5>
            </div>
            <div class="card-body">
                @if($statement['distributions']->count() > 0)
                <div class="table-responsive">
                    <table class="table table-sm table-row-dashed">
                        <thead>
                            <tr class="fw-bold text-muted">
                                <th>{{ __('التاريخ') }}</th>
                                <th>{{ __('نصيب رأس المال') }}</th>
                                <th>{{ __('أتعاب الإدارة') }}</th>
                                <th>{{ __('الإجمالي') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($statement['distributions'] as $dist)
                            <tr>
                                <td>{{ $dist->distribution->distribution_date->format('Y-m-d') }}</td>
                                <td class="text-success">{{ number_format($dist->share_amount, 2) }}</td>
                                <td class="text-info">{{ number_format($dist->management_fee_amount, 2) }}</td>
                                <td class="fw-bold">{{ number_format($dist->total_amount, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="fw-bold border-top">
                            <tr>
                                <td>{{ __('الإجمالي') }}</td>
                                <td class="text-success">{{ number_format($statement['distributions']->sum('share_amount'), 2) }}</td>
                                <td class="text-info">{{ number_format($statement['distributions']->sum('management_fee_amount'), 2) }}</td>
                                <td>{{ number_format($statement['distributions']->sum('total_amount'), 2) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                @else
                <div class="text-center py-5 text-muted">
                    <i class="fa fa-chart-pie fs-3x mb-3"></i>
                    <p>{{ __('لا توجد توزيعات بعد') }}</p>
                </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">{{ __('سجل المسحوبات') }}</h5>
            </div>
            <div class="card-body">
                @if($statement['withdrawals']->count() > 0)
                <div class="table-responsive">
                    <table class="table table-sm table-row-dashed">
                        <thead>
                            <tr class="fw-bold text-muted">
                                <th>{{ __('التاريخ') }}</th>
                                <th>{{ __('المبلغ') }}</th>
                                <th>{{ __('ملاحظات') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($statement['withdrawals'] as $withdrawal)
                            <tr>
                                <td>{{ $withdrawal->date->format('Y-m-d') }}</td>
                                <td class="text-danger fw-bold">{{ number_format($withdrawal->amount, 2) }}</td>
                                <td>{{ $withdrawal->notes ?? '-' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="fw-bold border-top">
                            <tr>
                                <td>{{ __('الإجمالي') }}</td>
                                <td class="text-danger">{{ number_format($statement['withdrawals']->sum('amount'), 2) }}</td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                @else
                <div class="text-center py-5 text-muted">
                    <i class="fa fa-money-bill-wave fs-3x mb-3"></i>
                    <p>{{ __('لا توجد مسحوبات') }}</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Back Button -->
<div class="mt-5">
    <a href="{{ route('partners.dashboard', $partner->id) }}" class="btn btn-secondary">
        <i class="fa fa-arrow-right me-2"></i> {{ __('العودة للوحة الشريك') }}
    </a>
</div>

<!-- Help Offcanvas -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="helpOffcanvas" style="width: 450px;">
    <div class="offcanvas-header bg-primary">
        <h5 class="offcanvas-title text-white">
            <i class="fa fa-lightbulb me-2"></i> {{ __('دليل تفاصيل المشروع') }}
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body">
        <div class="accordion" id="helpAccordion">
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#help1">
                        <i class="fa fa-info-circle text-primary me-2"></i> {{ __('ما هي هذه الصفحة؟') }}
                    </button>
                </h2>
                <div id="help1" class="accordion-collapse collapse show" data-bs-parent="#helpAccordion">
                    <div class="accordion-body">
                        <p>{{ __('هذه الصفحة تعرض تفاصيل مشاركتك في هذا المشروع بما في ذلك:') }}</p>
                        <ul class="mb-0">
                            <li>{{ __('نسب مشاركتك في رأس المال وأتعاب الإدارة') }}</li>
                            <li>{{ __('ملخص الأرباح والمسحوبات') }}</li>
                            <li>{{ __('تفاصيل التوزيع الحالي') }}</li>
                            <li>{{ __('سجل كامل للتوزيعات والمسحوبات') }}</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#help2">
                        <i class="fa fa-chart-line text-success me-2"></i> {{ __('كيف يتم حساب التوزيع؟') }}
                    </button>
                </h2>
                <div id="help2" class="accordion-collapse collapse" data-bs-parent="#helpAccordion">
                    <div class="accordion-body">
                        <ol class="mb-0">
                            <li class="mb-2"><strong>{{ __('إجمالي الإيرادات') }}</strong> - {{ __('من مبيعات الوحدات والدفعات') }}</li>
                            <li class="mb-2"><strong>{{ __('طرح المصروفات') }}</strong> - {{ __('رأسمالية وتشغيلية') }}</li>
                            <li class="mb-2"><strong>{{ __('نقطة التعادل') }}</strong> - {{ __('يجب تغطية التكاليف الرأسمالية أولاً') }}</li>
                            <li class="mb-2"><strong>{{ __('توزيع الأرباح') }}</strong> - {{ __('حسب نسب المشاركة') }}</li>
                        </ol>
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#help3">
                        <i class="fa fa-wallet text-warning me-2"></i> {{ __('الرصيد المتاح') }}
                    </button>
                </h2>
                <div id="help3" class="accordion-collapse collapse" data-bs-parent="#helpAccordion">
                    <div class="accordion-body">
                        <div class="alert alert-light-info mb-0">
                            <strong>{{ __('الرصيد') }} = {{ __('الأرباح') }} - {{ __('المسحوبات') }}</strong>
                            <hr>
                            <p class="mb-0">{{ __('هذا هو المبلغ المتاح لك للسحب من هذا المشروع.') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="alert alert-light-primary mt-4">
            <i class="fa fa-phone me-2"></i>
            <strong>{{ __('تحتاج مساعدة؟') }}</strong> {{ __('تواصل مع الإدارة لطلب سحب أو استفسار.') }}
        </div>
    </div>
</div>

<style>
@media print {
    .offcanvas, .btn, .breadcrumb, nav, .sidebar, header, footer {
        display: none !important;
    }
    .card {
        border: 1px solid #ddd !important;
        box-shadow: none !important;
    }
}
</style>
@endsection
