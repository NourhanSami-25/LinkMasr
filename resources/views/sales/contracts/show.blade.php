@extends('layout.app')

@section('title')
    {{ __('تفاصيل العقد') }} - {{ $summary['contract']->contract_number }}
@endsection

@section('content')
<div class="row">
    <!-- Contract Info -->
    <div class="col-md-12 mb-4">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h4 class="card-title mb-0">{{ __('عقد رقم') }}: {{ $summary['contract']->contract_number }}</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>{{ __('الوحدة') }}:</strong> {{ $summary['contract']->unit->name }}</p>
                        <p><strong>{{ __('العميل') }}:</strong> {{ $summary['contract']->client->name }}</p>
                        <p><strong>{{ __('تاريخ العقد') }}:</strong> {{ $summary['contract']->contract_date->format('Y-m-d') }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>{{ __('السعر الإجمالي') }}:</strong> {{ number_format($summary['total_price'], 2) }} {{ __('جنيه') }}</p>
                        <p><strong>{{ __('المقدم') }}:</strong> {{ number_format($summary['down_payment'], 2) }} {{ __('جنيه') }}</p>
                        <p><strong>{{ __('الحالة') }}:</strong> 
                            @if($summary['contract']->status == 'active')
                                <span class="badge badge-light-success fs-7 fw-bold">{{ __('نشط') }}</span>
                            @elseif($summary['contract']->status == 'completed')
                                <span class="badge badge-light-primary fs-7 fw-bold">{{ __('مكتمل') }}</span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Payment Progress -->
    <div class="col-md-12 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">{{ __('تقدم السداد') }}</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-3">
                        <div class="text-center">
                            <h6 class="text-muted">{{ __('المدفوع') }}</h6>
                            <h4 class="text-success">{{ number_format($summary['total_paid'], 0) }}</h4>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-center">
                            <h6 class="text-muted">{{ __('المتبقي') }}</h6>
                            <h4 class="text-danger">{{ number_format($summary['remaining_balance'], 0) }}</h4>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-center">
                            <h6 class="text-muted">{{ __('نسبة السداد') }}</h6>
                            <h4 class="text-primary">{{ number_format($summary['payment_progress'], 1) }}%</h4>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-center">
                            <h6 class="text-muted">{{ __('الأقساط المتأخرة') }}</h6>
                            <h4 class="text-warning">{{ $summary['overdue_schedules'] }}</h4>
                        </div>
                    </div>
                </div>
                <div class="progress" style="height: 30px;">
                    <div class="progress-bar bg-success" style="width: {{ $summary['payment_progress'] }}%">
                        {{ number_format($summary['payment_progress'], 1) }}%
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Payment Schedule -->
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">{{ __('جدول الأقساط') }}</h5>
            </div>
            <div class="card-body">
                @if($summary['contract']->schedules->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>{{ __('القسط') }}</th>
                                <th>{{ __('المبلغ') }}</th>
                                <th>{{ __('تاريخ الاستحقاق') }}</th>
                                <th>{{ __('المدفوع') }}</th>
                                <th>{{ __('المتبقي') }}</th>
                                <th>{{ __('الحالة') }}</th>
                                <th>{{ __('الإجراءات') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($summary['contract']->schedules as $schedule)
                            <tr>
                                <td><strong>#{{ $schedule->installment_number }}</strong></td>
                                <td>{{ number_format($schedule->amount, 2) }}</td>
                                <td>{{ $schedule->due_date->format('Y-m-d') }}</td>
                                <td class="text-success">{{ number_format($schedule->paid_amount, 2) }}</td>
                                <td class="text-danger">{{ number_format($schedule->remaining_amount, 2) }}</td>
                                <td>
                                    @if($schedule->status == 'paid')
                                        <span class="badge badge-light-success fs-7 fw-bold">{{ __('مدفوع') }}</span>
                                    @elseif($schedule->status == 'partial')
                                        <span class="badge badge-light-warning fs-7 fw-bold">{{ __('جزئي') }}</span>
                                    @elseif($schedule->is_overdue)
                                        <span class="badge badge-light-danger fs-7 fw-bold">{{ __('متأخر') }}</span>
                                    @else
                                        <span class="badge badge-light-secondary fs-7 fw-bold">{{ __('معلق') }}</span>
                                    @endif
                                </td>
                                <td>
                                    @if($schedule->status != 'paid')
                                    <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#paymentModal{{ $schedule->id }}">
                                        <i class="bi bi-cash"></i> {{ __('دفع') }}
                                    </button>
                                    @endif
                                </td>
                            </tr>

                            <!-- Payment Modal -->
                            <div class="modal fade" id="paymentModal{{ $schedule->id }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form action="{{ route('sales.payments.record') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="schedule_id" value="{{ $schedule->id }}">
                                            <div class="modal-header bg-success">
                                                <h5 class="modal-title fw-bold text-white">
                                                    <i class="fa fa-money-bill me-2 text-white"></i>{{ __('تسجيل دفعة') }} - {{ __('القسط') }} #{{ $schedule->installment_number }}
                                                </h5>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="alert alert-info">
                                                    <strong>{{ __('المبلغ المستحق') }}:</strong> {{ number_format($schedule->remaining_amount, 2) }} {{ __('جنيه') }}
                                                </div>
                                                <div class="form-group mb-3">
                                                    <label class="form-label">{{ __('المبلغ المدفوع') }} <span class="text-danger">*</span></label>
                                                    <input type="number" step="0.01" name="amount" class="form-control" max="{{ $schedule->remaining_amount }}" required>
                                                </div>
                                                <div class="form-group mb-3">
                                                    <label class="form-label">{{ __('تاريخ الدفع') }} <span class="text-danger">*</span></label>
                                                    <input type="date" name="date" class="form-control" value="{{ date('Y-m-d') }}" required>
                                                </div>
                                                <div class="form-group mb-3">
                                                    <label class="form-label">{{ __('ملاحظات') }}</label>
                                                    <textarea name="notes" class="form-control" rows="2"></textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('إلغاء') }}</button>
                                                <button type="submit" class="btn btn-success">
                                                    <i class="bi bi-check-circle"></i> {{ __('تسجيل الدفعة') }}
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <p class="text-muted text-center">{{ __('لا يوجد جدول أقساط') }}</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
