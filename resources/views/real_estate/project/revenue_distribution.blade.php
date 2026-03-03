@extends('layout.app')

@section('title')
    {{ __('توزيع الإيرادات') }} - {{ $project->subject }}
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h4 class="card-title mb-0">{{ __('حاسبة توزيع الإيرادات') }}</h4>
            </div>
            <div class="card-body">
                <!-- Summary Section -->
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="card bg-light">
                            <div class="card-body text-center">
                                <h6 class="text-muted">{{ __('إجمالي الإيرادات') }}</h6>
                                <h4 class="text-success">{{ number_format($distribution['total_revenue'], 0) }}</h4>
                                <small>{{ __('جنيه') }}</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-light">
                            <div class="card-body text-center">
                                <h6 class="text-muted">{{ __('مصروفات رأسمالية') }}</h6>
                                <h4 class="text-danger">{{ number_format($distribution['capital_expenses'], 0) }}</h4>
                                <small>{{ __('جنيه') }}</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-light">
                            <div class="card-body text-center">
                                <h6 class="text-muted">{{ __('مصروفات إيرادية') }}</h6>
                                <h4 class="text-warning">{{ number_format($distribution['revenue_expenses'], 0) }}</h4>
                                <small>{{ __('جنيه') }}</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-light">
                            <div class="card-body text-center">
                                <h6 class="text-muted">{{ __('نقطة التعادل') }}</h6>
                                <h4>{{ number_format($distribution['breakeven_point'], 0) }}</h4>
                                <small>{{ __('جنيه') }}</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Breakeven Status -->
                <div class="alert {{ $distribution['breakeven_reached'] ? 'alert-success' : 'alert-warning' }}">
                    @if($distribution['breakeven_reached'])
                        <i class="bi bi-check-circle fs-4"></i>
                        <strong>{{ __('تم الوصول لنقطة التعادل!') }}</strong>
                        <p class="mb-0">{{ __('يمكن توزيع الأرباح على الشركاء') }}</p>
                    @else
                        <i class="bi bi-exclamation-triangle fs-4"></i>
                        <strong>{{ __('لم يتم الوصول لنقطة التعادل بعد') }}</strong>
                        <p class="mb-0">
                            {{ __('المتبقي') }}: {{ number_format($distribution['breakeven_point'] - $distribution['total_revenue'], 0) }} {{ __('جنيه') }}
                        </p>
                    @endif
                </div>

                @if($distribution['breakeven_reached'])
                <!-- Distribution Details -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="card border-success">
                            <div class="card-body">
                                <h5 class="text-success">{{ __('أتعاب الإدارة') }}</h5>
                                <h3>{{ number_format($distribution['total_management_fees'], 0) }} {{ __('جنيه') }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card border-primary">
                            <div class="card-body">
                                <h5 class="text-primary">{{ __('المبلغ القابل للتوزيع') }}</h5>
                                <h3>{{ number_format($distribution['distributable_amount'], 0) }} {{ __('جنيه') }}</h3>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Partner Distribution Table -->
                <h5 class="mb-3">{{ __('توزيع الشركاء') }}</h5>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th>{{ __('الشريك') }}</th>
                                <th>{{ __('نسبة رأس المال') }}</th>
                                <th>{{ __('حصة رأس المال') }}</th>
                                <th>{{ __('نسبة الإدارة') }}</th>
                                <th>{{ __('أتعاب الإدارة') }}</th>
                                <th>{{ __('الإجمالي') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($distribution['partner_distributions'] as $partnerId => $data)
                            <tr>
                                <td><strong>{{ $data['partner']->name }}</strong></td>
                                <td>{{ $data['capital_share_percentage'] ?? 0 }}%</td>
                                <td class="fw-bold text-success">{{ number_format($data['share_amount'] ?? 0, 2) }}</td>
                                <td>{{ $data['management_fee_percentage'] ?? 0 }}%</td>
                                <td class="fw-bold text-info">{{ number_format($data['management_fee_amount'] ?? 0, 2) }}</td>
                                <td class="fw-bold text-primary">{{ number_format($data['total_amount'] ?? 0, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="table-secondary fw-bold">
                            <tr>
                                <td colspan="2">{{ __('الإجمالي') }}</td>
                                <td>{{ number_format($distribution['distributable_amount'], 2) }}</td>
                                <td></td>
                                <td>{{ number_format($distribution['total_management_fees'], 2) }}</td>
                                <td>{{ number_format($distribution['distributable_amount'] + $distribution['total_management_fees'], 2) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <!-- Save Distribution -->
                <form action="{{ route('partners.distribution.save', $project->id) }}" method="POST" class="mt-4">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label">{{ __('تاريخ التوزيع') }}</label>
                            <input type="date" name="as_of_date" class="form-control" value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="col-md-6 d-flex align-items-end">
                            <button type="submit" class="btn btn-success btn-lg w-100">
                                <i class="bi bi-save"></i> {{ __('حفظ التوزيع') }}
                            </button>
                        </div>
                    </div>
                </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
