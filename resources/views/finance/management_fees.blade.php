@extends('layout.app')

@section('title')
    {{ __('حساب أتعاب الإدارة') }}
@endsection

@section('content')
<div class="row">
    <!-- Summary Card -->
    <div class="col-md-12 mb-4">
        <div class="card bg-gradient-success text-white">
            <div class="card-body text-center">
                <h3>{{ __('إجمالي أتعاب الإدارة') }}</h3>
                <h1 class="display-3">{{ number_format($account['total_fees'], 0) }}</h1>
                <p class="mb-0">{{ __('جنيه') }}</p>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- By Project -->
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="card-title mb-0">{{ __('حسب المشروع') }}</h5>
            </div>
            <div class="card-body">
                @if($account['by_project']->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>{{ __('المشروع') }}</th>
                                <th>{{ __('إجمالي الأتعاب') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($account['by_project'] as $projectId => $data)
                            <tr>
                                <td><strong>{{ $data['project']->subject }}</strong></td>
                                <td class="fw-bold text-success">{{ number_format($data['total_fees'], 2) }} {{ __('جنيه') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <p class="text-muted text-center">{{ __('لا توجد أتعاب بعد') }}</p>
                @endif
            </div>
        </div>
    </div>

    <!-- By Partner -->
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header bg-info text-white">
                <h5 class="card-title mb-0">{{ __('حسب الشريك') }}</h5>
            </div>
            <div class="card-body">
                @if($account['by_partner']->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>{{ __('الشريك') }}</th>
                                <th>{{ __('إجمالي الأتعاب') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($account['by_partner'] as $partnerId => $data)
                            <tr>
                                <td><strong>{{ $data['partner']->name }}</strong></td>
                                <td class="fw-bold text-success">{{ number_format($data['total_fees'], 2) }} {{ __('جنيه') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <p class="text-muted text-center">{{ __('لا توجد أتعاب بعد') }}</p>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Detailed Transactions -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">{{ __('تفاصيل أتعاب الإدارة') }}</h5>
            </div>
            <div class="card-body">
                @if($account['all_distributions']->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>{{ __('التاريخ') }}</th>
                                <th>{{ __('المشروع') }}</th>
                                <th>{{ __('الشريك') }}</th>
                                <th>{{ __('نسبة الإدارة') }}</th>
                                <th>{{ __('المبلغ') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($account['all_distributions'] as $item)
                            <tr>
                                <td>{{ $item->distribution->distribution_date->format('Y-m-d') }}</td>
                                <td>{{ $item->distribution->project->subject }}</td>
                                <td>{{ $item->partner->name }}</td>
                                <td>{{ $item->management_fee_percentage }}%</td>
                                <td class="fw-bold text-success">{{ number_format($item->management_fee_amount, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <p class="text-muted text-center">{{ __('لا توجد معاملات بعد') }}</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
