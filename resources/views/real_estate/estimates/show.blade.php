@extends('layout.app')

@section('title')
    {{ $estimate->title }}
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h4 class="card-title">{{ $estimate->title }}</h4>
                @include('components.print-export-buttons', ['tableId' => 'estimateTable', 'title' => $estimate->title, 'filename' => 'estimate'])
                <a href="{{ route('estimates.create') }}" class="btn btn-secondary">{{ __("New Estimate") }}</a>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-3">
                        <label class="text-muted">{{ __('Type') }}</label>
                        <h5>{{ ucfirst($estimate->type) }}</h5>
                    </div>
                    <div class="col-md-3">
                        <label class="text-muted">{{ __('Date') }}</label>
                        <h5>{{ $estimate->created_at->format('Y-m-d') }}</h5>
                    </div>
                    <div class="col-md-3">
                        <label class="text-muted">{{ __('Related Unit') }}</label>
                        <h5>{{ $estimate->unit ? $estimate->unit->name : '-' }}</h5>
                    </div>
                </div>

                <table id="estimateTable" class="table table-bordered">
                    <thead class="bg-light">
                        <tr>
                            <th>{{ __('Material') }}</th>
                            <th>{{ __('Quantity') }}</th>
                            <th>{{ __('Unit Price (at time of estimate)') }}</th>
                            <th class="text-end">{{ __('Subtotal') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($estimate->items as $item)
                        <tr>
                            <td>{{ $item->material->name }}</td>
                            <td>{{ $item->quantity }} {{ $item->material->unit }}</td>
                            <td>{{ number_format($item->unit_price, 2) }}</td>
                            <td class="text-end">{{ number_format($item->subtotal, 2) }}</td>
                        </tr>
                        @endforeach
                        
                        <tr class="fw-bold">
                            <td colspan="3" class="text-end">{{ __('Materials Total') }}</td>
                            <td class="text-end">{{ number_format($estimate->materials_total, 2) }}</td>
                        </tr>
                        <tr>
                            <td colspan="3" class="text-end">{{ __('Licensing Fees') }}</td>
                            <td class="text-end">{{ number_format($estimate->licensing_fees, 2) }}</td>
                        </tr>
                        <tr>
                            <td colspan="3" class="text-end">{{ __('Other Fees') }}</td>
                            <td class="text-end">{{ number_format($estimate->other_fees, 2) }}</td>
                        </tr>
                        <tr class="table-primary fw-bold">
                            <td colspan="3" class="text-end">{{ __('GRAND TOTAL') }}</td>
                            <td class="text-end">{{ number_format($estimate->total_cost, 2) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
