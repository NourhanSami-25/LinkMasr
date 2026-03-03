@extends('layout.app')

@section('title')
    {{ __('Project Financials') }} - {{ $project->subject }}
@endsection

@section('content')
<div class="row">
    <!-- Summary -->
    <div class="col-md-4">
        <div class="card bg-success text-white">
            <div class="card-body">
                <h5>{{ __('Net Distributable Income') }}</h5>
                <h2>{{ number_format($netIncome, 2) }} {{-- Currency should be dynamic --}}</h2>
                <small>{{ __('Revenue - Operational Expenses') }}</small>
            </div>
        </div>
    </div>
    
    <!-- Operational Expenses -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title text-warning">{{ __('Operational Expenses (OPEX)') }}</h4>
                <small>{{ __('Deducted from Revenue before Distribution') }}</small>
            </div>
            <div class="card-body">
                <ul class="list-group">
                    @forelse($operationalExpenses as $expense)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ $expense->description }}
                            <span>{{ number_format($expense->total, 2) }}</span>
                        </li>
                    @empty
                        <li class="list-group-item text-center text-muted">{{ __('No operational expenses found') }}</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>

    <!-- Capital Expenses -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title text-info">{{ __('Capital Expenses (CAPEX)') }}</h4>
                <small>{{ __('Added to Project Asset Value (Not deducted from Revenue)') }}</small>
            </div>
            <div class="card-body">
                <ul class="list-group">
                    @forelse($capitalExpenses as $expense)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ $expense->description }}
                            <span>{{ number_format($expense->total, 2) }}</span>
                        </li>
                    @empty
                        <li class="list-group-item text-center text-muted">{{ __('No capital expenses found') }}</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
