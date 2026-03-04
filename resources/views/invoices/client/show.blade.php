@extends('layout.app')

@section('title', $invoice->invoice_no)

@section('breadcrumb')
    <li class="breadcrumb-item text-muted">
        <a href="{{ route('client-invoices.index') }}" class="text-muted text-hover-primary">{{ __('general.client_invoices') ?? 'مستخلصات العملاء' }}</a>
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
                        <span><strong>{{ __('general.project') ?? 'المشروع' }}:</strong> {{ $invoice->project->subject }}</span>
                        <span><strong>{{ __('general.client') ?? 'العميل' }}:</strong> {{ $invoice->client->name ?? '-' }}</span>
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
                        @case('certified')
                            <span class="badge badge-light-info fs-6 fw-bold">معتمد</span>
                            @break
                        @case('invoiced')
                            <span class="badge badge-light-success fs-6 fw-bold">مفوتر</span>
                            @break
                        @case('paid')
                            <span class="badge badge-light-primary fs-6 fw-bold">مدفوع</span>
                            @break
                    @endswitch

                    <div class="mt-3">
                        @if($invoice->status == 'draft')
                            <form action="{{ route('client-invoices.submit', $invoice->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-warning btn-sm">
                                    <i class="fa fa-paper-plane"></i> {{ __('general.submit') ?? 'تقديم' }}
                                </button>
                            </form>
                        @endif
                        @if($invoice->status == 'submitted')
                            <form action="{{ route('client-invoices.certify', $invoice->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm">
                                    <i class="fa fa-check"></i> {{ __('general.certify') ?? 'اعتماد' }}
                                </button>
                            </form>
                        @endif
                        <a href="{{ route('client-invoices.print', $invoice->id) }}" class="btn btn-light btn-sm" target="_blank">
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
                            <th>{{ __('general.code') ?? 'الكود' }}</th>
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
                            <td>{{ $item->boq->code ?? '-' }}</td>
                            <td>{{ $item->boq->description ?? '' }}</td>
                            <td class="text-center">{{ number_format($item->previous_qty, 2) }}</td>
                            <td class="text-center">{{ number_format($item->current_qty, 2) }}</td>
                            <td class="text-center">{{ number_format($item->cumulative_qty, 2) }}</td>
                            <td class="text-center">{{ number_format($item->unit_price, 2) }}</td>
                            <td class="text-end">{{ number_format($item->amount, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="table-secondary">
                        <tr>
                            <td colspan="7" class="text-end fw-bold">{{ __('general.gross_amount') ?? 'الإجمالي' }}</td>
                            <td class="text-end fw-bold">{{ number_format($invoice->gross_amount, 2) }}</td>
                        </tr>
                        @if($invoice->deductions > 0)
                        <tr>
                            <td colspan="7" class="text-end">{{ __('general.deductions') ?? 'الخصومات' }}</td>
                            <td class="text-end text-danger">-{{ number_format($invoice->deductions, 2) }}</td>
                        </tr>
                        @endif
                        <tr class="table-primary">
                            <td colspan="7" class="text-end fw-bold fs-5">{{ __('general.net_amount') ?? 'صافي المستحق' }}</td>
                            <td class="text-end fw-bold fs-5">{{ number_format($invoice->net_amount, 2) }}</td>
                        </tr>
                        @if($invoice->certified_amount && $invoice->certified_amount != $invoice->net_amount)
                        <tr class="table-success">
                            <td colspan="7" class="text-end fw-bold">{{ __('general.certified_amount') ?? 'المبلغ المعتمد' }}</td>
                            <td class="text-end fw-bold">{{ number_format($invoice->certified_amount, 2) }}</td>
                        </tr>
                        @endif
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
