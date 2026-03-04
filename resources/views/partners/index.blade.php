@extends('layout.app')

@section('title', __('general.partners_management') ?? 'Partners Management')
@section('page_title', __('general.partners_management') ?? 'Partners Management')

@section('breadcrumb')
        <li class="breadcrumb-item text-muted">{{ __('general.partners_management') ?? 'إدارة الشركاء' }}</li>
@endsection

@section('content')
<!-- Help Button -->
<div class="d-flex justify-content-end align-items-center gap-2 mb-4 flex-wrap">
    @include('components.print-export-buttons', ['tableId' => 'partnersArea', 'title' => __('general.partners_management') ?? 'Partners Management', 'filename' => 'partners'])
    <button class="btn btn-light-info btn-sm ms-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#helpOffcanvas">
        <i class="fa fa-question-circle me-2"></i> {{ __('general.help') ?? 'Help' }}
    </button>
</div>

<div class="row g-5">
    <!-- Partners Summary Cards -->
    <div class="col-md-4">
        <div class="card bg-light-primary">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <span class="fs-2x fw-bold text-primary me-3">{{ $partners->count() }}</span>
                    <span class="text-gray-600">{{ __('general.total_partners') ?? 'Total Partners' }}</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-light-success">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <span class="fs-2x fw-bold text-success me-3">{{ $projects->count() }}</span>
                    <span class="text-gray-600">{{ __('general.projects_with_partners') ?? 'Projects with Partners' }}</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-light-warning">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <span class="fs-2x fw-bold text-warning me-3">{{ $recentWithdrawals->sum('amount') }}</span>
                    <span class="text-gray-600">{{ __('general.total_withdrawals') ?? 'Total Withdrawals' }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Partners by Project -->
<div id="partnersArea" class="card mt-5">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="card-title">{{ __("general.partners_by_project") ?? "Partners by Project" }}</h4>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addNewPartnerModal">
            <i class="fa fa-plus"></i> {{ __("general.add_new_partner") ?? "إضافة شريك جديد" }}
        </button>
    </div>
    <div class="card-body">
        @if($projects->count() > 0)
            @foreach($projects as $project)
                <div class="border rounded p-4 mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="mb-0">
                            <i class="fa fa-building text-primary me-2"></i>
                            {{ $project->subject }}
                        </h5>
                        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addPartnerModal{{ $project->id }}">
                            <i class="fa fa-plus"></i> {{ __('general.add_partner') ?? 'Add Partner' }}
                        </button>
                    </div>
                    
                    @if($project->partners->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-row-dashed align-middle gs-0 gy-3">
                            <thead>
                                <tr class="fw-bold text-muted">
                                    <th>{{ __('general.partner_name') ?? 'Partner Name' }}</th>
                                    <th>{{ __('general.share_percentage') ?? 'Share %' }}</th>
                                    <th>{{ __('general.management_fee_percentage') ?? 'Management Fee %' }}</th>
                                    <th>{{ __('general.actions') ?? 'Actions' }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($project->partners as $partner)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="symbol symbol-40px me-3">
                                                <span class="symbol-label bg-light-primary text-primary fw-bold">
                                                    {{ substr($partner->name, 0, 1) }}
                                                </span>
                                            </div>
                                            <div>
                                                <a href="{{ route('partners.dashboard', $partner->id) }}" class="text-dark fw-bold text-hover-primary">
                                                    {{ $partner->name }}
                                                </a>
                                                <div class="text-muted fs-7">{{ $partner->email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge badge-light-primary fs-6">{{ $partner->pivot->share_percentage ?? 0 }}%</span>
                                    </td>
                                    <td>
                                        <span class="badge badge-light-info fs-6">{{ $partner->pivot->management_fee_percentage ?? 0 }}%</span>
                                    </td>
                                    <td>
                                        <a href="{{ route('partners.dashboard', $partner->id) }}" class="btn btn-sm btn-light-primary">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        <a href="{{ route('partners.distribution.calculate', $project->id) }}" class="btn btn-sm btn-light-success">
                                            <i class="fa fa-calculator"></i> {{ __('general.distribution') ?? 'Distribution' }}
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="text-center text-muted py-5">
                        <i class="fa fa-users fs-3x mb-3"></i>
                        <p>{{ __('general.no_partners_in_project') ?? 'No partners in this project yet' }}</p>
                    </div>
                    @endif
                </div>

                <!-- Add Partner Modal -->
                <div class="modal fade" id="addPartnerModal{{ $project->id }}" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form action="{{ route('partners.add', $project->id) }}" method="POST">
                                @csrf
                                <div class="modal-header">
                                    <h5 class="modal-title">{{ __('general.add_partner_to') ?? 'Add Partner to' }} {{ $project->subject }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label class="form-label required">{{ __('general.partner') ?? 'Partner' }}</label>
                                        <select name="partner_id" class="form-select" required>
                                            <option value="">{{ __('general.select') ?? 'Select' }}...</option>
                                            @foreach(\App\Models\user\User::all() as $user)
                                                <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label required">{{ __('general.share_percentage') ?? 'Share Percentage' }}</label>
                                        <div class="input-group">
                                            <input type="number" name="share_percentage" class="form-control" step="0.01" min="0" max="100" required>
                                            <span class="input-group-text">%</span>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label required">{{ __('general.management_fee_percentage') ?? 'Management Fee %' }}</label>
                                        <div class="input-group">
                                            <input type="number" name="management_fee_percentage" class="form-control" step="0.01" min="0" max="100" required>
                                            <span class="input-group-text">%</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{ __('general.cancel') ?? 'Cancel' }}</button>
                                    <button type="submit" class="btn btn-primary">{{ __('general.add') ?? 'Add' }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
        <div class="text-center py-10">
            <i class="fa fa-folder-open fs-3x text-muted mb-3"></i>
            <p>{{ __('general.no_projects') ?? 'No projects yet' }}</p>
            <a href="{{ route('projects.create') }}" class="btn btn-primary">
                <i class="fa fa-plus"></i> {{ __('general.create_project') ?? 'Create Project' }}
            </a>
        </div>
        @endif
    </div>
</div>

<!-- Record Withdrawal -->
<div id="partnersArea" class="card mt-5">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="card-title">{{ __('general.record_withdrawal') ?? 'Record Partner Withdrawal' }}</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('partners.withdrawals.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-3">
                    <label class="form-label required">{{ __('general.partner') ?? 'Partner' }}</label>
                    <select name="partner_id" class="form-select" required>
                        <option value="">{{ __('general.select') ?? 'Select' }}...</option>
                        @foreach($partners as $partner)
                            <option value="{{ $partner->id }}">{{ $partner->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">{{ __('general.project') ?? 'Project' }} ({{ __('general.optional') ?? 'Optional' }})</label>
                    <select name="project_id" class="form-select">
                        <option value="">{{ __('general.all_projects') ?? 'All Projects' }}</option>
                        @foreach($projects as $project)
                            <option value="{{ $project->id }}">{{ $project->subject }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label required">{{ __('general.amount') ?? 'Amount' }}</label>
                    <input type="number" name="amount" class="form-control" step="0.01" min="0" required>
                </div>
                <div class="col-md-2">
                    <label class="form-label required">{{ __('general.date') ?? 'Date' }}</label>
                    <input type="date" name="date" class="form-control" value="{{ date('Y-m-d') }}" required>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-success w-100">
                        <i class="fa fa-save"></i> {{ __('general.save') ?? 'Save' }}
                    </button>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-12">
                    <label class="form-label">{{ __('general.notes') ?? 'Notes' }}</label>
                    <textarea name="notes" class="form-control" rows="2"></textarea>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Recent Withdrawals -->
<div id="partnersArea" class="card mt-5">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="card-title">{{ __('general.recent_withdrawals') ?? 'Recent Withdrawals' }}</h4>
    </div>
    <div class="card-body">
        @if($recentWithdrawals->count() > 0)
        <div class="table-responsive">
            <table class="table table-row-dashed align-middle">
                <thead>
                    <tr class="fw-bold text-muted">
                        <th>{{ __('general.date') ?? 'Date' }}</th>
                        <th>{{ __('general.partner') ?? 'Partner' }}</th>
                        <th>{{ __('general.project') ?? 'Project' }}</th>
                        <th>{{ __('general.amount') ?? 'Amount' }}</th>
                        <th>{{ __('general.notes') ?? 'Notes' }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentWithdrawals as $withdrawal)
                    <tr>
                        <td>{{ $withdrawal->date->format('Y-m-d') }}</td>
                        <td>{{ $withdrawal->partner->name ?? '-' }}</td>
                        <td>{{ $withdrawal->project->subject ?? __('general.all_projects') }}</td>
                        <td><span class="badge badge-light-danger fs-6">{{ number_format($withdrawal->amount, 2) }}</span></td>
                        <td>{{ $withdrawal->notes ?? '-' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="text-center text-muted py-5">
            <i class="fa fa-receipt fs-3x mb-3"></i>
            <p>{{ __('general.no_withdrawals') ?? 'No withdrawals yet' }}</p>
        </div>
        @endif
    </div>
</div>

<!-- Add New Partner Modal -->
<div class="modal fade" id="addNewPartnerModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('partners.create') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('general.add_new_partner') ?? 'إضافة شريك جديد' }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label required">{{ __('general.name') ?? 'الاسم' }}</label>
                                <input type="text" name="name" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label required">{{ __('general.email') ?? 'البريد الإلكتروني' }}</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">{{ __('general.phone') ?? 'الهاتف' }}</label>
                                <input type="text" name="phone" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label required">{{ __('general.password') ?? 'كلمة المرور' }}</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ __('general.address') ?? 'العنوان' }}</label>
                        <textarea name="address" class="form-control" rows="2"></textarea>
                    </div>
                    
                    <hr class="my-4">
                    <h6 class="mb-3">{{ __('general.add_to_project') ?? 'إضافة إلى مشروع' }} ({{ __('general.optional') ?? 'اختياري' }})</h6>
                    
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">{{ __('general.project') ?? 'المشروع' }}</label>
                                <select name="project_id" class="form-select">
                                    <option value="">{{ __('general.select') ?? 'اختر' }}...</option>
                                    @foreach($projects as $project)
                                        <option value="{{ $project->id }}">{{ $project->subject }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">{{ __('general.share_percentage') ?? 'نسبة الشراكة' }}</label>
                                <div class="input-group">
                                    <input type="number" name="share_percentage" class="form-control" step="0.01" min="0" max="100">
                                    <span class="input-group-text">%</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">{{ __('general.management_fee_percentage') ?? 'نسبة أتعاب الإدارة' }}</label>
                                <div class="input-group">
                                    <input type="number" name="management_fee_percentage" class="form-control" step="0.01" min="0" max="100">
                                    <span class="input-group-text">%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{ __('general.cancel') ?? 'إلغاء' }}</button>
                    <button type="submit" class="btn btn-primary">{{ __('general.add') ?? 'إضافة' }}</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Help Offcanvas -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="helpOffcanvas" style="width: 450px;">
    <div class="offcanvas-header bg-primary">
        <h5 class="offcanvas-title text-white">
            <i class="fa fa-lightbulb me-2"></i> {{ __('general.help_partners') ?? 'Partners Management Guide' }}
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
                        <p>{{ __('general.help_partners_intro') ?? 'This page allows you to manage partners across all projects. As an administrator, you can:' }}</p>
                        <ul class="mb-0">
                            <li>{{ __('general.help_partners_add') ?? 'Add partners to any project' }}</li>
                            <li>{{ __('general.help_partners_set_share') ?? 'Set partnership share percentages' }}</li>
                            <li>{{ __('general.help_partners_fees') ?? 'Define management fees for each partner' }}</li>
                            <li>{{ __('general.help_partners_withdrawals') ?? 'Record partner withdrawals' }}</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- How to add partner -->
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#help2">
                        <i class="fa fa-user-plus text-success me-2"></i> {{ __('general.help_add_partner_title') ?? 'How to add a partner?' }}
                    </button>
                </h2>
                <div id="help2" class="accordion-collapse collapse" data-bs-parent="#helpAccordion">
                    <div class="accordion-body">
                        <ol>
                            <li><strong>{{ __('general.help_add_step1') ?? 'Find the project' }}</strong> - {{ __('general.help_add_step1_desc') ?? 'Locate the project you want to add a partner to' }}</li>
                            <li><strong>{{ __('general.help_add_step2') ?? 'Click Add Partner' }}</strong> - {{ __('general.help_add_step2_desc') ?? 'Click the "Add Partner" button next to the project' }}</li>
                            <li><strong>{{ __('general.help_add_step3') ?? 'Select partner' }}</strong> - {{ __('general.help_add_step3_desc') ?? 'Choose the user from the dropdown list' }}</li>
                            <li><strong>{{ __('general.help_add_step4') ?? 'Set percentages' }}</strong> - {{ __('general.help_add_step4_desc') ?? 'Enter the share % and management fee %' }}</li>
                        </ol>
                    </div>
                </div>
            </div>

            <!-- Understanding shares -->
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#help3">
                        <i class="fa fa-percent text-info me-2"></i> {{ __('general.help_shares_title') ?? 'Understanding Shares & Fees' }}
                    </button>
                </h2>
                <div id="help3" class="accordion-collapse collapse" data-bs-parent="#helpAccordion">
                    <div class="accordion-body">
                        <div class="mb-3">
                            <strong class="text-primary">{{ __('general.share_percentage') ?? 'Share %' }}</strong>
                            <p class="mb-0 text-muted">{{ __('general.help_share_desc') ?? 'The percentage of project profits the partner will receive.' }}</p>
                        </div>
                        <div class="mb-3">
                            <strong class="text-info">{{ __('general.management_fee_percentage') ?? 'Management Fee %' }}</strong>
                            <p class="mb-0 text-muted">{{ __('general.help_fee_desc') ?? 'A fee deducted from partner profits for management services.' }}</p>
                        </div>
                        <div class="alert alert-light-warning mb-0">
                            <i class="fa fa-calculator me-2"></i>
                            {{ __('general.help_calculation') ?? 'Partner Net = (Profit × Share%) - (Profit × Share% × Management Fee%)' }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recording withdrawals -->
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#help4">
                        <i class="fa fa-money-bill-wave text-warning me-2"></i> {{ __('general.help_withdrawals_title') ?? 'Recording Withdrawals' }}
                    </button>
                </h2>
                <div id="help4" class="accordion-collapse collapse" data-bs-parent="#helpAccordion">
                    <div class="accordion-body">
                        <p>{{ __('general.help_withdrawals_intro') ?? 'When a partner receives money:' }}</p>
                        <ol>
                            <li>{{ __('general.help_withdrawal_step1') ?? 'Select the partner from the dropdown' }}</li>
                            <li>{{ __('general.help_withdrawal_step2') ?? 'Optionally select a specific project' }}</li>
                            <li>{{ __('general.help_withdrawal_step3') ?? 'Enter the withdrawal amount' }}</li>
                            <li>{{ __('general.help_withdrawal_step4') ?? 'Select the date and add notes if needed' }}</li>
                        </ol>
                        <li>{{ __('general.help_withdrawal_step5') ?? 'Click Save to record the withdrawal' }}</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
