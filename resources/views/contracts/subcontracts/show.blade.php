@extends('layout.app')

@section('title', $subcontract->title)

@section('breadcrumb')
    <li class="breadcrumb-item text-muted">
        <a href="{{ route('subcontracts.index') }}" class="text-muted text-hover-primary">{{ __('general.subcontracts') ?? 'العقود' }}</a>
    </li>
    <li class="breadcrumb-item text-muted">{{ $subcontract->contract_no }}</li>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Contract Header -->
    <div class="card mb-5">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h3 class="mb-2">{{ $subcontract->title }}</h3>
                    <div class="d-flex gap-4 text-muted flex-wrap">
                        <span><strong>{{ __('general.contract_no') ?? 'رقم العقد' }}:</strong> {{ $subcontract->contract_no }}</span>
                        <span><strong>{{ __('general.vendor') ?? 'المقاول' }}:</strong> {{ $subcontract->vendor->name }}</span>
                        <span><strong>{{ __('general.project') ?? 'المشروع' }}:</strong> {{ $subcontract->project->subject }}</span>
                    </div>
                </div>
                <div class="col-md-4 text-end">
                    @if($subcontract->status == 'draft')
                        <form action="{{ route('subcontracts.activate', $subcontract->id) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-success btn-sm">
                                <i class="fa fa-check"></i> {{ __('general.activate') ?? 'تفعيل' }}
                            </button>
                        </form>
                        <a href="{{ route('subcontracts.edit', $subcontract->id) }}" class="btn btn-warning btn-sm">
                            <i class="fa fa-edit"></i> {{ __('general.edit') ?? 'تعديل' }}
                        </a>
                    @elseif($subcontract->status == 'active')
                        <a href="{{ route('subcontractor-invoices.create', ['subcontract_id' => $subcontract->id]) }}" class="btn btn-primary btn-sm">
                            <i class="fa fa-file-invoice"></i> {{ __('general.new_invoice') ?? 'مستخلص جديد' }}
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="row mb-5">
        <div class="col-md-3">
            <div class="card bg-light-primary">
                <div class="card-body py-4">
                    <div class="d-flex align-items-center">
                        <div class="symbol symbol-50px me-4">
                            <span class="symbol-label bg-primary">
                                <i class="fa fa-file-contract text-white fs-2"></i>
                            </span>
                        </div>
                        <div>
                            <div class="fs-4 fw-bold text-gray-800">{{ number_format($subcontract->contract_value, 2) }}</div>
                            <div class="fs-7 text-muted">{{ __('general.contract_value') ?? 'قيمة العقد' }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-light-success">
                <div class="card-body py-4">
                    <div class="d-flex align-items-center">
                        <div class="symbol symbol-50px me-4">
                            <span class="symbol-label bg-success">
                                <i class="fa fa-check-double text-white fs-2"></i>
                            </span>
                        </div>
                        <div>
                            <div class="fs-4 fw-bold text-gray-800">{{ number_format($subcontract->executed_value, 2) }}</div>
                            <div class="fs-7 text-muted">{{ __('general.executed_value') ?? 'المنفذ' }} ({{ $subcontract->execution_percentage }}%)</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-light-warning">
                <div class="card-body py-4">
                    <div class="d-flex align-items-center">
                        <div class="symbol symbol-50px me-4">
                            <span class="symbol-label bg-warning">
                                <i class="fa fa-coins text-white fs-2"></i>
                            </span>
                        </div>
                        <div>
                            <div class="fs-4 fw-bold text-gray-800">{{ number_format($subcontract->total_paid, 2) }}</div>
                            <div class="fs-7 text-muted">{{ __('general.total_paid') ?? 'إجمالي المدفوع' }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-light-info">
                <div class="card-body py-4">
                    <div class="d-flex align-items-center">
                        <div class="symbol symbol-50px me-4">
                            <span class="symbol-label bg-info">
                                <i class="fa fa-lock text-white fs-2"></i>
                            </span>
                        </div>
                        <div>
                            <div class="fs-4 fw-bold text-gray-800">{{ number_format($subcontract->total_retention, 2) }}</div>
                            <div class="fs-7 text-muted">{{ __('general.retention') ?? 'المحتجز' }} ({{ $subcontract->retention_percentage }}%)</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Contract Details -->
    <div class="row">
        <div class="col-md-8">
            <!-- Contract Items -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">{{ __('general.contract_items') ?? 'بنود العقد' }}</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>{{ __('general.description') ?? 'الوصف' }}</th>
                                    <th>{{ __('general.quantity') ?? 'الكمية' }}</th>
                                    <th>{{ __('general.unit_price') ?? 'سعر الوحدة' }}</th>
                                    <th>{{ __('general.total') ?? 'الإجمالي' }}</th>
                                    <th>{{ __('general.executed') ?? 'المنفذ' }}</th>
                                    <th>{{ __('general.remaining') ?? 'المتبقي' }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($subcontract->items as $item)
                                <tr>
                                    <td>
                                        <strong>{{ $item->boq->item_description ?? $item->description }}</strong>
                                        <br><small class="text-muted">{{ $item->boq->code ?? '' }}</small>
                                    </td>
                                    <td>{{ number_format($item->quantity, 2) }} {{ $item->boq->unit ?? '' }}</td>
                                    <td>{{ number_format($item->unit_price, 2) }}</td>
                                    <td class="fw-bold">{{ number_format($item->total_price, 2) }}</td>
                                    <td>
                                        <span class="badge badge-light-success fs-7 fw-bold">{{ number_format($item->executed_qty, 2) }}</span>
                                        <br><small class="text-muted">({{ $item->execution_percentage }}%)</small>
                                    </td>
                                    <td>{{ number_format($item->remaining_qty, 2) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="table-secondary fw-bold">
                                <tr>
                                    <td colspan="3" class="text-end">{{ __('general.total') ?? 'الإجمالي' }}:</td>
                                    <td>{{ number_format($subcontract->contract_value, 2) }}</td>
                                    <td>{{ number_format($subcontract->executed_value, 2) }}</td>
                                    <td>{{ number_format($subcontract->remaining_value, 2) }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Invoices -->
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">{{ __('general.invoices') ?? 'المستخلصات' }}</h5>
                    @if($subcontract->status == 'active')
                    <a href="{{ route('subcontractor-invoices.create', ['subcontract_id' => $subcontract->id]) }}" class="btn btn-sm btn-primary">
                        <i class="fa fa-plus"></i>
                    </a>
                    @endif
                </div>
                <div class="card-body p-0">
                    @if($subcontract->invoices->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-striped align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('general.period') ?? 'الفترة' }}</th>
                                    <th>{{ __('general.gross') ?? 'الإجمالي' }}</th>
                                    <th>{{ __('general.retention') ?? 'المحتجز' }}</th>
                                    <th>{{ __('general.net') ?? 'الصافي' }}</th>
                                    <th>{{ __('general.status') ?? 'الحالة' }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($subcontract->invoices as $invoice)
                                <tr>
                                    <td>{{ $invoice->sequence_no }}</td>
                                    <td>{{ $invoice->period_from->format('Y-m-d') }} - {{ $invoice->period_to->format('Y-m-d') }}</td>
                                    <td>{{ number_format($invoice->gross_amount, 2) }}</td>
                                    <td>{{ number_format($invoice->retention_amount, 2) }}</td>
                                    <td class="fw-bold">{{ number_format($invoice->net_amount, 2) }}</td>
                                    <td>
                                        <span class="badge badge-light-{{ $invoice->status == 'paid' ? 'success' : ($invoice->status == 'approved' ? 'primary' : 'warning') }} fs-7 fw-bold">
                                            {{ $invoice->status }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="text-center text-muted py-5">
                        {{ __('general.no_invoices') ?? 'لا توجد مستخلصات' }}
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <!-- Contract Info -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">{{ __('general.contract_info') ?? 'معلومات العقد' }}</h5>
                </div>
                <div class="card-body">
                    <table class="table table-sm">
                        <tr>
                            <td class="text-muted">{{ __('general.status') ?? 'الحالة' }}</td>
                            <td>
                                <span class="badge badge-light-{{ $subcontract->status == 'active' ? 'success' : 'secondary' }} fs-7 fw-bold">
                                    {{ $subcontract->status }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-muted">{{ __('general.start_date') ?? 'تاريخ البدء' }}</td>
                            <td>{{ $subcontract->start_date->format('Y-m-d') }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">{{ __('general.end_date') ?? 'تاريخ الانتهاء' }}</td>
                            <td>{{ $subcontract->end_date->format('Y-m-d') }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">{{ __('general.retention') ?? 'نسبة المحتجز' }}</td>
                            <td>{{ $subcontract->retention_percentage }}%</td>
                        </tr>
                        <tr>
                            <td class="text-muted">{{ __('general.advance') ?? 'نسبة الدفعة المقدمة' }}</td>
                            <td>{{ $subcontract->advance_percentage }}%</td>
                        </tr>
                    </table>
                </div>
            </div>

            <!-- Vendor Info -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">{{ __('general.vendor_info') ?? 'معلومات المقاول' }}</h5>
                </div>
                <div class="card-body">
                    <h6>{{ $subcontract->vendor->name }}</h6>
                    <p class="text-muted mb-1">
                        <i class="fa fa-phone me-2"></i> {{ $subcontract->vendor->phone ?? '-' }}
                    </p>
                    <p class="text-muted mb-1">
                        <i class="fa fa-envelope me-2"></i> {{ $subcontract->vendor->email ?? '-' }}
                    </p>
                    <p class="text-muted mb-0">
                        <i class="fa fa-map-marker me-2"></i> {{ $subcontract->vendor->address ?? '-' }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
