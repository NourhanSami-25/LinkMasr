@extends('layout.app')

@section('title', $invoice->invoice_no)

@section('breadcrumb')
    <li class="breadcrumb-item text-muted">
        <a href="{{ route('subcontractor-invoices.index') }}" class="text-muted text-hover-primary">{{ __('general.subcontractor_invoices') ?? 'مستخلصات المقاولين' }}</a>
    </li>
    <li class="breadcrumb-item text-muted">{{ $invoice->invoice_no }}</li>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Invoice Header -->
    <div class="card mb-5">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h3 class="mb-2">{{ $invoice->invoice_no }}</h3>
                    <div class="d-flex gap-4 text-muted">
                        <span><strong>{{ __('general.vendor') ?? 'المقاول' }}:</strong> {{ $invoice->subcontract->vendor->name }}</span>
                        <span><strong>{{ __('general.project') ?? 'المشروع' }}:</strong> {{ $invoice->subcontract->project->subject }}</span>
                        <span><strong>{{ __('general.period') ?? 'الفترة' }}:</strong> {{ $invoice->period_from->format('Y-m-d') }} - {{ $invoice->period_to->format('Y-m-d') }}</span>
                    </div>
                </div>
                <div class="col-md-4 text-end">
                    @switch($invoice->status)
                        @case('draft')
                            <span class="badge badge-light-secondary fs-6 fw-bold">مسودة</span>
                            @break
                        @case('submitted')
                            <span class="badge badge-light-warning fs-6 fw-bold">مقدم</span>
                            @break
                        @case('approved')
                            <span class="badge badge-light-success fs-6 fw-bold">معتمد</span>
                            @break
                        @case('paid')
                            <span class="badge badge-light-primary fs-6 fw-bold">مدفوع</span>
                            @break
                    @endswitch

                    <div class="mt-3">
                        @if($invoice->status == 'draft')
                            <form action="{{ route('subcontractor-invoices.submit', $invoice->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-warning btn-sm">
                                    <i class="fa fa-paper-plane"></i> {{ __('general.submit') ?? 'تقديم' }}
                                </button>
                            </form>
                        @endif
                        @if($invoice->status == 'submitted')
                            <form action="{{ route('subcontractor-invoices.approve', $invoice->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm">
                                    <i class="fa fa-check"></i> {{ __('general.approve') ?? 'اعتماد' }}
                                </button>
                            </form>
                        @endif
                        @if($invoice->status == 'approved')
                            <form action="{{ route('subcontractor-invoices.paid', $invoice->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-primary btn-sm">
                                    <i class="fa fa-money-bill"></i> {{ __('general.mark_paid') ?? 'تسجيل الدفع' }}
                                </button>
                            </form>
                        @endif
                        <a href="{{ route('subcontractor-invoices.print', $invoice->id) }}" class="btn btn-light btn-sm" target="_blank">
                            <i class="fa fa-print"></i> {{ __('general.print') ?? 'طباعة' }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Invoice Items -->
    <div class="card mb-5">
        <div class="card-header">
            <h5 class="mb-0">{{ __('general.invoice_items') ?? 'بنود المستخلص' }}</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>{{ __('general.description') ?? 'الوصف' }}</th>
                            <th>{{ __('general.previous_qty') ?? 'الكمية السابقة' }}</th>
                            <th>{{ __('general.current_qty') ?? 'الكمية الحالية' }}</th>
                            <th>{{ __('general.cumulative_qty') ?? 'الكمية التراكمية' }}</th>
                            <th>{{ __('general.unit_price') ?? 'سعر الوحدة' }}</th>
                            <th>{{ __('general.current_amount') ?? 'المبلغ الحالي' }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($invoice->items as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $item->description }}</td>
                            <td class="text-center">{{ number_format($item->previous_qty, 2) }}</td>
                            <td class="text-center">{{ number_format($item->current_qty, 2) }}</td>
                            <td class="text-center">{{ number_format($item->cumulative_qty, 2) }}</td>
                            <td class="text-center">{{ number_format($item->unit_price, 2) }}</td>
                            <td class="text-end">{{ number_format($item->current_amount, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="table-secondary">
                        <tr>
                            <td colspan="6" class="text-end fw-bold">{{ __('general.gross_amount') ?? 'الإجمالي' }}</td>
                            <td class="text-end fw-bold">{{ number_format($invoice->gross_amount, 2) }}</td>
                        </tr>
                        <tr>
                            <td colspan="6" class="text-end">{{ __('general.retention') ?? 'المحجوز' }}</td>
                            <td class="text-end text-danger">-{{ number_format($invoice->retention_amount, 2) }}</td>
                        </tr>
                        @if($invoice->deductions > 0)
                        <tr>
                            <td colspan="6" class="text-end">{{ __('general.deductions') ?? 'الخصومات' }}</td>
                            <td class="text-end text-danger">-{{ number_format($invoice->deductions, 2) }}</td>
                        </tr>
                        @endif
                        <tr class="table-primary">
                            <td colspan="6" class="text-end fw-bold fs-5">{{ __('general.net_amount') ?? 'صافي المستحق' }}</td>
                            <td class="text-end fw-bold fs-5">{{ number_format($invoice->net_amount, 2) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    @if($invoice->notes)
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">{{ __('general.notes') ?? 'ملاحظات' }}</h5>
        </div>
        <div class="card-body">
            {{ $invoice->notes }}
        </div>
    </div>
    @endif
</div>
@endsection
