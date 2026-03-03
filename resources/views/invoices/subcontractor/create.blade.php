@extends('layout.app')

@section('title', __('general.new_invoice') ?? 'مستخلص جديد')

@section('breadcrumb')
    <li class="breadcrumb-item text-muted">
        <a href="{{ route('subcontractor-invoices.index') }}" class="text-muted text-hover-primary">{{ __('general.subcontractor_invoices') ?? 'مستخلصات المقاولين' }}</a>
    </li>
    <li class="breadcrumb-item text-muted">{{ __('general.new_invoice') ?? 'مستخلص جديد' }}</li>
@endsection

@section('content')
<div class="container-fluid">
    <form action="{{ route('subcontractor-invoices.store') }}" method="POST" id="invoiceForm">
        @csrf
        
        <!-- Contract Selection -->
        <div class="card mb-5">
            <div class="card-header">
                <h5 class="mb-0">{{ __('general.contract_selection') ?? 'اختيار العقد' }}</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label required">{{ __('general.subcontract') ?? 'العقد' }}</label>
                        <select name="subcontract_id" id="subcontract_id" class="form-select @error('subcontract_id') is-invalid @enderror" required {{ $subcontract ? 'disabled' : '' }}>
                            <option value="">{{ __('general.select_contract') ?? 'اختر العقد' }}</option>
                            @foreach($subcontracts as $contract)
                                <option value="{{ $contract->id }}" {{ ($subcontract && $subcontract->id == $contract->id) ? 'selected' : '' }}>
                                    {{ $contract->contract_no }} - {{ $contract->vendor->name }} ({{ $contract->project->subject }})
                                </option>
                            @endforeach
                        </select>
                        @if($subcontract)
                            <input type="hidden" name="subcontract_id" value="{{ $subcontract->id }}">
                        @endif
                        @error('subcontract_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                @if(!$subcontract)
                <div class="alert alert-info">
                    <i class="fa fa-info-circle me-2"></i>
                    {{ __('general.select_contract_first') ?? 'الرجاء اختيار العقد أولاً لعرض البنود' }}
                </div>
                @endif
            </div>
        </div>

        @if($subcontract)
        <!-- Contract Info -->
        <div class="card mb-5">
            <div class="card-header bg-light">
                <h5 class="mb-0">{{ __('general.contract_info') ?? 'معلومات العقد' }}</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <strong>{{ __('general.vendor') ?? 'المقاول' }}:</strong>
                        <p>{{ $subcontract->vendor->name }}</p>
                    </div>
                    <div class="col-md-3">
                        <strong>{{ __('general.project') ?? 'المشروع' }}:</strong>
                        <p>{{ $subcontract->project->subject }}</p>
                    </div>
                    <div class="col-md-3">
                        <strong>{{ __('general.contract_value') ?? 'قيمة العقد' }}:</strong>
                        <p>{{ number_format($subcontract->contract_value, 2) }}</p>
                    </div>
                    <div class="col-md-3">
                        <strong>{{ __('general.retention') ?? 'نسبة المحجوز' }}:</strong>
                        <p>{{ $subcontract->retention_percentage }}%</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Invoice Period -->
        <div class="card mb-5">
            <div class="card-header">
                <h5 class="mb-0">{{ __('general.invoice_period') ?? 'فترة المستخلص' }}</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label required">{{ __('general.period_from') ?? 'من تاريخ' }}</label>
                        <input type="date" name="period_from" class="form-control @error('period_from') is-invalid @enderror" 
                               value="{{ old('period_from') }}" required>
                        @error('period_from')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label required">{{ __('general.period_to') ?? 'إلى تاريخ' }}</label>
                        <input type="date" name="period_to" class="form-control @error('period_to') is-invalid @enderror" 
                               value="{{ old('period_to') }}" required>
                        @error('period_to')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">{{ __('general.notes') ?? 'ملاحظات' }}</label>
                    <textarea name="notes" class="form-control" rows="2">{{ old('notes') }}</textarea>
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
                                <th width="5%">#</th>
                                <th width="30%">{{ __('general.description') ?? 'الوصف' }}</th>
                                <th width="10%">{{ __('general.contract_qty') ?? 'كمية العقد' }}</th>
                                <th width="10%">{{ __('general.previous_qty') ?? 'الكمية السابقة' }}</th>
                                <th width="10%">{{ __('general.current_qty') ?? 'الكمية الحالية' }}</th>
                                <th width="10%">{{ __('general.cumulative_qty') ?? 'الكمية التراكمية' }}</th>
                                <th width="10%">{{ __('general.unit_price') ?? 'سعر الوحدة' }}</th>
                                <th width="15%">{{ __('general.current_amount') ?? 'المبلغ الحالي' }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($items as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    @if($item->boq)
                                        <strong>{{ $item->boq->code }}</strong><br>
                                    @endif
                                    {{ $item->description }}
                                    <input type="hidden" name="items[{{ $index }}][subcontract_item_id]" value="{{ $item->id }}">
                                </td>
                                <td class="text-center">{{ number_format($item->quantity, 2) }}</td>
                                <td class="text-center">
                                    {{ number_format($item->previous_qty, 2) }}
                                    <input type="hidden" name="items[{{ $index }}][previous_qty]" value="{{ $item->previous_qty }}">
                                </td>
                                <td>
                                    <input type="number" name="items[{{ $index }}][current_qty]" 
                                           class="form-control form-control-sm current-qty" 
                                           value="0" step="0.01" min="0" max="{{ $item->remaining_qty }}"
                                           data-unit-price="{{ $item->unit_price }}"
                                           data-previous="{{ $item->previous_qty }}"
                                           data-max="{{ $item->remaining_qty }}"
                                           onchange="calculateRow(this)">
                                </td>
                                <td class="text-center cumulative-qty">{{ number_format($item->previous_qty, 2) }}</td>
                                <td class="text-center">{{ number_format($item->unit_price, 2) }}</td>
                                <td class="text-end current-amount">0.00</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="table-secondary">
                            <tr>
                                <td colspan="7" class="text-end fw-bold">{{ __('general.subtotal') ?? 'الإجمالي الفرعي' }}</td>
                                <td class="text-end fw-bold" id="subtotal">0.00</td>
                            </tr>
                            <tr>
                                <td colspan="7" class="text-end">{{ __('general.retention') ?? 'المحجوز' }} ({{ $subcontract->retention_percentage }}%)</td>
                                <td class="text-end text-danger" id="retention">0.00</td>
                            </tr>
                            @if($subcontract->insurance_percentage > 0)
                            <tr>
                                <td colspan="7" class="text-end">{{ __('general.insurance') ?? 'التأمين' }} ({{ $subcontract->insurance_percentage }}%)</td>
                                <td class="text-end text-danger" id="insurance">0.00</td>
                            </tr>
                            @endif
                            <tr class="table-primary">
                                <td colspan="7" class="text-end fw-bold fs-5">{{ __('general.net_amount') ?? 'صافي المستحق' }}</td>
                                <td class="text-end fw-bold fs-5" id="netAmount">0.00</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-end">
            <a href="{{ route('subcontractor-invoices.index') }}" class="btn btn-light me-3">{{ __('general.cancel') ?? 'إلغاء' }}</a>
            <button type="submit" class="btn btn-primary">
                <i class="fa fa-save"></i> {{ __('general.save_as_draft') ?? 'حفظ كمسودة' }}
            </button>
        </div>
        @endif
    </form>
</div>
@endsection

@if($subcontract)
@section('scripts')
<script>
    const retentionRate = {{ $subcontract->retention_percentage / 100 }};
    const insuranceRate = {{ ($subcontract->insurance_percentage ?? 0) / 100 }};

    function calculateRow(input) {
        const row = input.closest('tr');
        const currentQty = parseFloat(input.value) || 0;
        const unitPrice = parseFloat(input.dataset.unitPrice) || 0;
        const previousQty = parseFloat(input.dataset.previous) || 0;
        const maxQty = parseFloat(input.dataset.max) || 0;

        // Validate max
        if (currentQty > maxQty) {
            input.value = maxQty;
            calculateRow(input);
            return;
        }

        const cumulativeQty = previousQty + currentQty;
        const currentAmount = currentQty * unitPrice;

        row.querySelector('.cumulative-qty').textContent = cumulativeQty.toFixed(2);
        row.querySelector('.current-amount').textContent = currentAmount.toFixed(2);

        calculateTotals();
    }

    function calculateTotals() {
        let subtotal = 0;
        document.querySelectorAll('.current-amount').forEach(cell => {
            subtotal += parseFloat(cell.textContent) || 0;
        });

        const retention = subtotal * retentionRate;
        const insurance = subtotal * insuranceRate;
        const netAmount = subtotal - retention - insurance;

        document.getElementById('subtotal').textContent = subtotal.toFixed(2);
        document.getElementById('retention').textContent = '-' + retention.toFixed(2);
        if (document.getElementById('insurance')) {
            document.getElementById('insurance').textContent = '-' + insurance.toFixed(2);
        }
        document.getElementById('netAmount').textContent = netAmount.toFixed(2);
    }

    // Redirect when contract is selected
    document.getElementById('subcontract_id')?.addEventListener('change', function() {
        if (this.value) {
            window.location.href = '{{ route('subcontractor-invoices.create') }}?subcontract_id=' + this.value;
        }
    });
</script>
@endsection
@endif
