@extends('layout.app')

@section('title', __('general.client_invoices') ?? 'مستخلصات العملاء')

@section('breadcrumb')
    <li class="breadcrumb-item text-muted">{{ __('general.client_invoices') ?? 'مستخلصات العملاء' }}</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="card-title mb-0">{{ __('general.client_invoices') ?? 'مستخلصات العملاء' }}</h4>
            <a href="{{ route('client-invoices.create') }}" class="btn btn-primary btn-sm">
                <i class="fa fa-plus"></i> {{ __('general.new_invoice') ?? 'مستخلص جديد' }}
            </a>
        </div>
        <div class="card-body">
            <!-- Filters -->
            <form method="GET" class="row mb-4">
                <div class="col-md-4">
                    <select name="project_id" class="form-select" onchange="this.form.submit()">
                        <option value="">{{ __('general.all_projects') ?? 'كل المشاريع' }}</option>
                        @foreach($projects as $project)
                        <option value="{{ $project->id }}" {{ request('project_id') == $project->id ? 'selected' : '' }}>
                            {{ $project->subject }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="status" class="form-select" onchange="this.form.submit()">
                        <option value="">{{ __('general.all_statuses') ?? 'كل الحالات' }}</option>
                        <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>مسودة</option>
                        <option value="submitted" {{ request('status') == 'submitted' ? 'selected' : '' }}>مقدم</option>
                        <option value="certified" {{ request('status') == 'certified' ? 'selected' : '' }}>معتمد</option>
                        <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>مدفوع</option>
                    </select>
                </div>
            </form>

            @if($invoices->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover table-striped align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>{{ __('general.invoice_no') ?? 'رقم المستخلص' }}</th>
                            <th>{{ __('general.project') ?? 'المشروع' }}</th>
                            <th>{{ __('general.period') ?? 'الفترة' }}</th>
                            <th>{{ __('general.gross') ?? 'الإجمالي' }}</th>
                            <th>{{ __('general.net') ?? 'الصافي' }}</th>
                            <th>{{ __('general.vat') ?? 'الضريبة' }}</th>
                            <th>{{ __('general.total') ?? 'المجموع' }}</th>
                            <th>{{ __('general.status') ?? 'الحالة' }}</th>
                            <th>{{ __('general.actions') ?? 'الإجراءات' }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($invoices as $invoice)
                        <tr>
                            <td><code>{{ $invoice->invoice_no }}</code></td>
                            <td>{{ $invoice->project->subject }}</td>
                            <td>{{ $invoice->period_from->format('Y-m-d') }} - {{ $invoice->period_to->format('Y-m-d') }}</td>
                            <td>{{ number_format($invoice->gross_amount, 2) }}</td>
                            <td>{{ number_format($invoice->net_amount, 2) }}</td>
                            <td>{{ number_format($invoice->vat_amount, 2) }}</td>
                            <td class="fw-bold">{{ number_format($invoice->total_with_vat, 2) }}</td>
                            <td>
                                @switch($invoice->status)
                                    @case('draft')
                                        <span class="badge badge-light-secondary fs-7 fw-bold">مسودة</span>
                                        @break
                                    @case('submitted')
                                        <span class="badge badge-light-warning fs-7 fw-bold">مقدم</span>
                                        @break
                                    @case('certified')
                                        <span class="badge badge-light-success fs-7 fw-bold">معتمد</span>
                                        @break
                                    @case('paid')
                                        <span class="badge badge-light-primary fs-7 fw-bold">مدفوع</span>
                                        @break
                                @endswitch
                            </td>
                            <td>
                                <a href="{{ route('client-invoices.show', $invoice->id) }}" class="btn btn-sm btn-light-info">
                                    <i class="fa fa-eye"></i>
                                </a>
                                <a href="{{ route('client-invoices.print', $invoice->id) }}" class="btn btn-sm btn-light-dark" target="_blank">
                                    <i class="fa fa-print"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            {{ $invoices->links() }}
            @else
            <div class="alert alert-info text-center">
                <i class="fa fa-info-circle fs-1 mb-3 d-block"></i>
                {{ __('general.no_invoices') ?? 'لا توجد مستخلصات' }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
