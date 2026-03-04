@extends('layout.app')

@section('title')
    {{ __('لوحة الشريك') }} - {{ $partner->name }}
@endsection

@section('content')
<!-- Help Button -->
<div class="d-flex justify-content-end mb-4">
    <button class="btn btn-light-info" type="button" data-bs-toggle="offcanvas" data-bs-target="#helpOffcanvas">
        <i class="fa fa-question-circle me-2"></i> {{ __('general.help') ?? 'Help' }}
    </button>
</div>

<div class="row">
    <!-- Summary Cards -->
    <div class="col-md-3 mb-4">
        <div class="card bg-success text-white">
            <div class="card-body">
                <h6 class="card-title">{{ __('إجمالي الأرباح') }}</h6>
                <h3 class="mb-0">{{ number_format($statement['total_earnings'], 0) }}</h3>
                <small>{{ __('جنيه') }}</small>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="card bg-info text-white">
            <div class="card-body">
                <h6 class="card-title">{{ __('أتعاب الإدارة') }}</h6>
                <h3 class="mb-0">{{ number_format($statement['total_management_fees'], 0) }}</h3>
                <small>{{ __('جنيه') }}</small>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <h6 class="card-title">{{ __('المسحوبات') }}</h6>
                <h3 class="mb-0">{{ number_format($statement['total_withdrawals'], 0) }}</h3>
                <small>{{ __('جنيه') }}</small>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <h6 class="card-title">{{ __('الرصيد المتاح') }}</h6>
                <h3 class="mb-0">{{ number_format($statement['balance'], 0) }}</h3>
                <small>{{ __('جنيه') }}</small>
            </div>
        </div>
    </div>
</div>

<!-- Projects List -->
<div class="row">
    <div class="col-12 mb-4">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">{{ __('المشاريع') }}</h4>
            </div>
            <div class="card-body">
                @if($projects->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>{{ __('المشروع') }}</th>
                                <th>{{ __('نسبة رأس المال') }}</th>
                                <th>{{ __('نسبة الإدارة') }}</th>
                                <th>{{ __('الحالة') }}</th>
                                <th>{{ __('الإجراءات') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($projects as $project)
                            @php
                                $partnerData = $project->partners->where('id', $partner->id)->first();
                            @endphp
                            <tr>
                                <td><strong>{{ $project->subject }}</strong></td>
                                <td>{{ $partnerData->pivot->share_percentage ?? 0 }}%</td>
                                <td>{{ $partnerData->pivot->management_fee_percentage ?? 0 }}%</td>
                                <td>
                                    <span class="badge badge-light-success fs-7 fw-bold">{{ __('نشط') }}</span>
                                </td>
                                <td>
                                    <a href="{{ route('partners.project.details', [$partner->id, $project->id]) }}" class="btn btn-sm btn-primary">
                                        {{ __('التفاصيل') }}
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <p class="text-muted text-center">{{ __('لا توجد مشاريع') }}</p>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Recent Distributions -->
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">{{ __('آخر التوزيعات') }}</h5>
            </div>
            <div class="card-body">
                @if($statement['distributions']->count() > 0)
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>{{ __('التاريخ') }}</th>
                                <th>{{ __('المشروع') }}</th>
                                <th>{{ __('المبلغ') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($statement['distributions']->take(10) as $dist)
                            <tr>
                                <td>{{ $dist->distribution->distribution_date->format('Y-m-d') }}</td>
                                <td>{{ $dist->distribution->project->subject }}</td>
                                <td class="fw-bold text-success">{{ number_format($dist->total_amount, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <p class="text-muted text-center">{{ __('لا توجد توزيعات بعد') }}</p>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">{{ __('آخر المسحوبات') }}</h5>
            </div>
            <div class="card-body">
                @if($statement['withdrawals']->count() > 0)
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>{{ __('التاريخ') }}</th>
                                <th>{{ __('المشروع') }}</th>
                                <th>{{ __('المبلغ') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($statement['withdrawals']->take(10) as $withdrawal)
                            <tr>
                                <td>{{ $withdrawal->date->format('Y-m-d') }}</td>
                                <td>{{ $withdrawal->project->subject }}</td>
                                <td class="fw-bold text-danger">{{ number_format($withdrawal->amount, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <p class="text-muted text-center">{{ __('لا توجد مسحوبات') }}</p>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Help Offcanvas -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="helpOffcanvas" style="width: 450px;">
    <div class="offcanvas-header bg-primary">
        <h5 class="offcanvas-title text-white">
            <i class="fa fa-lightbulb me-2"></i> {{ __('general.help_portfolio') ?? 'My Portfolio Guide' }}
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body">
        <div class="accordion" id="helpAccordion">
            <!-- What is this page -->
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#help1">
                        <i class="fa fa-info-circle text-primary me-2"></i> {{ __('general.help_what_is_page') ?? 'What is this page?' }}
                    </button>
                </h2>
                <div id="help1" class="accordion-collapse collapse show" data-bs-parent="#helpAccordion">
                    <div class="accordion-body">
                        <p>{{ __('general.help_portfolio_intro') ?? 'This is your personal partner dashboard showing:' }}</p>
                        <ul class="mb-0">
                            <li>{{ __('general.help_portfolio_earnings') ?? 'Your total earnings from all projects' }}</li>
                            <li>{{ __('general.help_portfolio_fees') ?? 'Management fees deducted' }}</li>
                            <li>{{ __('general.help_portfolio_withdrawals') ?? 'Your withdrawal history' }}</li>
                            <li>{{ __('general.help_portfolio_balance') ?? 'Your current available balance' }}</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Understanding cards -->
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#help2">
                        <i class="fa fa-credit-card text-success me-2"></i> {{ __('general.help_cards_title') ?? 'Understanding the Summary Cards' }}
                    </button>
                </h2>
                <div id="help2" class="accordion-collapse collapse" data-bs-parent="#helpAccordion">
                    <div class="accordion-body">
                        <div class="d-flex align-items-center mb-3">
                            <span class="badge bg-success me-2 p-2">{{ __('إجمالي الأرباح') }}</span>
                            <span class="text-muted">{{ __('general.help_total_earnings_desc') ?? 'Total profits from all your projects' }}</span>
                        </div>
                        <div class="d-flex align-items-center mb-3">
                            <span class="badge bg-info me-2 p-2">{{ __('أتعاب الإدارة') }}</span>
                            <span class="text-muted">{{ __('general.help_mgmt_fees_desc') ?? 'Fees paid to management for services' }}</span>
                        </div>
                        <div class="d-flex align-items-center mb-3">
                            <span class="badge bg-warning me-2 p-2">{{ __('المسحوبات') }}</span>
                            <span class="text-muted">{{ __('general.help_withdrawals_desc') ?? 'Money you have already withdrawn' }}</span>
                        </div>
                        <div class="d-flex align-items-center mb-3">
                            <span class="badge bg-primary me-2 p-2">{{ __('الرصيد المتاح') }}</span>
                            <span class="text-muted">{{ __('general.help_balance_desc') ?? 'Amount available for withdrawal' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Projects section -->
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#help3">
                        <i class="fa fa-building text-info me-2"></i> {{ __('general.help_projects_section') ?? 'Your Projects' }}
                    </button>
                </h2>
                <div id="help3" class="accordion-collapse collapse" data-bs-parent="#helpAccordion">
                    <div class="accordion-body">
                        <p>{{ __('general.help_projects_desc') ?? 'The projects table shows:' }}</p>
                        <ul>
                            <li><strong>{{ __('نسبة رأس المال') }}</strong> - {{ __('general.help_capital_share') ?? 'Your share of project profits' }}</li>
                            <li><strong>{{ __('نسبة الإدارة') }}</strong> - {{ __('general.help_mgmt_share') ?? 'Management fee percentage' }}</li>
                            <li><strong>{{ __('الحالة') }}</strong> - {{ __('general.help_status') ?? 'Project status (active/inactive)' }}</li>
                        </ul>
                        <p class="mb-0 text-muted">{{ __('general.help_details_btn') ?? 'Click "Details" to see project-specific breakdown.' }}</p>
                    </div>
                </div>
            </div>

            <!-- How balance is calculated -->
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#help4">
                        <i class="fa fa-calculator text-warning me-2"></i> {{ __('general.help_balance_calc') ?? 'How Balance is Calculated' }}
                    </button>
                </h2>
                <div id="help4" class="accordion-collapse collapse" data-bs-parent="#helpAccordion">
                    <div class="accordion-body">
                        <div class="alert alert-light-info mb-3">
                            <strong>{{ __('الرصيد المتاح') }} = {{ __('إجمالي الأرباح') }} - {{ __('أتعاب الإدارة') }} - {{ __('المسحوبات') }}</strong>
                        </div>
                        <p class="text-muted mb-0">{{ __('general.help_balance_explanation') ?? 'Your available balance is what remains after deducting management fees and any withdrawals you have made.' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="alert alert-light-primary mt-4">
            <i class="fa fa-phone me-2"></i>
            <strong>{{ __('general.help_need_help') ?? 'Need help?' }}</strong> {{ __('general.help_contact_admin') ?? 'Contact the administrator for withdrawal requests or questions.' }}
        </div>
    </div>
</div>
@endsection
