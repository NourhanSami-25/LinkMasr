@extends('layout.app')

@section('title', __('general.new_client_invoice') ?? 'مستخلص عميل جديد')

@section('breadcrumb')
    <li class="breadcrumb-item text-muted">
        <a href="{{ route('client-invoices.index') }}" class="text-muted text-hover-primary">{{ __('general.client_invoices') ?? 'مستخلصات العملاء' }}</a>
    </li>
    <li class="breadcrumb-item text-muted">{{ __('general.new_client_invoice') ?? 'مستخلص جديد' }}</li>
@endsection

@section('content')
<div class="container-fluid">
    <form action="{{ route('client-invoices.store') }}" method="POST" id="invoiceForm">
        @csrf
        
        <!-- Project Selection -->
        <div class="card mb-5">
            <div class="card-header">
                <h5 class="mb-0">{{ __('general.project_selection') ?? 'اختيار المشروع' }}</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label required">{{ __('general.project') ?? 'المشروع' }}</label>
                        <select name="project_id" id="project_id" class="form-select @error('project_id') is-invalid @enderror" required {{ $project ? 'disabled' : '' }}>
                            <option value="">{{ __('general.select_project') ?? 'اختر المشروع' }}</option>
                            @foreach($projects as $proj)
                                <option value="{{ $proj->id }}" {{ ($project && $project->id == $proj->id) ? 'selected' : '' }}>
                                    {{ $proj->subject }}
                                </option>
                            @endforeach
                        </select>
                        @if($project)
                            <input type="hidden" name="project_id" value="{{ $project->id }}">
                        @endif
                        @error('project_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                @if(!$project)
                <div class="alert alert-info">
                    <i class="fa fa-info-circle me-2"></i>
                    {{ __('general.select_project_first_boq') ?? 'الرجاء اختيار المشروع أولاً لعرض بنود جدول الكميات' }}
                </div>
                @endif
            </div>
        </div>

        @if($project)
        <!-- Project Info -->
        <div class="card mb-5">
            <div class="card-header bg-light">
                <h5 class="mb-0">{{ __('general.project_info') ?? 'معلومات المشروع' }}</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <strong>{{ __('general.project') ?? 'المشروع' }}:</strong>
                        <p>{{ $project->subject }}</p>
                    </div>
                    <div class="col-md-4">
                        <strong>{{ __('general.client') ?? 'العميل' }}:</strong>
                        <p>{{ $project->client->name ?? '-' }}</p>
                    </div>
                    <div class="col-md-4">
                        <strong>{{ __('general.contract_value') ?? 'قيمة العقد' }}:</strong>
                        <p>{{ number_format($project->boqItems->sum('total_price') ?? 0, 2) }}</p>
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
                    <div class="col-md-3 mb-3">
                        <label class="form-label required">{{ __('general.period_from') ?? 'من تاريخ' }}</label>
                        <input type="date" name="period_from" class="form-control @error('period_from') is-invalid @enderror" 
                               value="{{ old('period_from') }}" required>
                        @error('period_from')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label required">{{ __('general.period_to') ?? 'إلى تاريخ' }}</label>
                        <input type="date" name="period_to" class="form-control @error('period_to') is-invalid @enderror" 
                               value="{{ old('period_to') }}" required>
                        @error('period_to')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label required">{{ __('general.retention_percentage') ?? 'نسبة المحجوز (%)' }}</label>
                        <input type="number" name="retention_percentage" class="form-control @error('retention_percentage') is-invalid @enderror" 
                               value="{{ old('retention_percentage', 10) }}" step="0.01" min="0" max="100" required>
                        @error('retention_percentage')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label required">{{ __('general.vat_percentage') ?? 'نسبة الضريبة (%)' }}</label>
                        <input type="number" name="vat_percentage" class="form-control @error('vat_percentage') is-invalid @enderror" 
                               value="{{ old('vat_percentage', 15) }}" step="0.01" min="0" max="100" required>
                        @error('vat_percentage')
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

        <!-- Invoice Items (BOQ) -->
        <div class="card mb-5">
            <div class="card-header">
                <h5 class="mb-0">{{ __('general.boq_items') ?? 'بنود جدول الكميات' }}</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered mb-0">
                        <thead class="table-light">
                            <tr>
                                <th width="5%">#</th>
                                <th width="8%">{{ __('general.code') ?? 'الكود' }}</th>
                                <th width="25%">{{ __('general.description') ?? 'الوصف' }}</th>
                                <th width="8%">{{ __('general.contract_qty') ?? 'كمية العقد' }}</th>
                                <th width="10%">{{ __('general.previous_qty') ?? 'الكمية السابقة' }}</th>
                                <th width="10%">{{ __('general.current_qty') ?? 'الكمية الحالية' }}</th>
                                <th width="10%">{{ __('general.cumulative_qty') ?? 'الكمية التراكمية' }}</th>
                                <th width="10%">{{ __('general.unit_price') ?? 'سعر الوحدة' }}</th>
                                <th width="14%">{{ __('general.current_amount') ?? 'المبلغ الحالي' }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($boqItems as $index => $boq)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $boq->code }}</td>
                                <td>
                                    {{ $boq->item_description }}
                                    <input type="hidden" name="items[{{ $index }}][boq_id]" value="{{ $boq->id }}">
                                    <input type="hidden" name="items[{{ $index }}][unit_price]" value="{{ $boq->unit_price }}">
                                </td>
                                <td class="text-center">{{ number_format($boq->quantity, 2) }}</td>
                                <td class="text-center">
                                    {{ number_format($boq->previous_qty, 2) }}
                                    <input type="hidden" name="items[{{ $index }}][previous_qty]" value="{{ $boq->previous_qty }}">
                                </td>
                                <td>
                                    <input type="number" name="items[{{ $index }}][current_qty]" 
                                           class="form-control form-control-sm current-qty" 
                                           value="0" step="0.01" min="0" max="{{ $boq->remaining_qty }}"
                                           data-unit-price="{{ $boq->unit_price }}"
                                           data-previous="{{ $boq->previous_qty }}"
                                           data-max="{{ $boq->remaining_qty }}"
                                           onchange="calculateRow(this)">
                                </td>
                                <td class="text-center cumulative-qty">{{ number_format($boq->previous_qty, 2) }}</td>
                                <td class="text-center">{{ number_format($boq->unit_price, 2) }}</td>
                                <td class="text-end current-amount">0.00</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="table-secondary">
                            <tr>
                                <td colspan="8" class="text-end fw-bold">{{ __('general.gross_amount') ?? 'الإجمالي' }}</td>
                                <td class="text-end fw-bold" id="grossAmount">0.00</td>
                            </tr>
                            <tr class="table-primary">
                                <td colspan="8" class="text-end fw-bold fs-5">{{ __('general.total_due') ?? 'إجمالي المستحق' }}</td>
                                <td class="text-end fw-bold fs-5" id="totalDue">0.00</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-end">
            <a href="{{ route('client-invoices.index') }}" class="btn btn-light me-3">{{ __('general.cancel') ?? 'إلغاء' }}</a>
            <button type="submit" class="btn btn-primary">
                <i class="fa fa-save"></i> {{ __('general.save_as_draft') ?? 'حفظ كمسودة' }}
            </button>
        </div>
        @endif
    </form>
</div>
@endsection

@section('scripts')
<script>
    // Redirect when project is selected
    document.getElementById('project_id')?.addEventListener('change', function() {
        if (this.value) {
            window.location.href = '{{ route('client-invoices.create') }}?project_id=' + this.value;
        }
    });

    @if($project)
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
        let grossAmount = 0;
        document.querySelectorAll('.current-amount').forEach(cell => {
            grossAmount += parseFloat(cell.textContent) || 0;
        });

        document.getElementById('grossAmount').textContent = grossAmount.toFixed(2);
        document.getElementById('totalDue').textContent = grossAmount.toFixed(2);
    }
    @endif
</script>
@endsection
