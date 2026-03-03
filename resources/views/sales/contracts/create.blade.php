@extends('layout.app')

@section('title')
    {{ __('عقد بيع جديد') }}
@endsection

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h4 class="card-title mb-0">{{ __('إنشاء عقد بيع') }}</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('sales.contracts.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="project_id" value="{{ $project->id }}">
                    
                    <!-- Unit Selection -->
                    <div class="form-group mb-3">
                        <label class="form-label">{{ __('الوحدة') }} <span class="text-danger">*</span></label>
                        <select name="unit_id" class="form-select" required id="unitSelect">
                            <option value="">{{ __('اختر الوحدة') }}</option>
                            @foreach($availableUnits as $unit)
                            <option value="{{ $unit->id }}" data-price="{{ $unit->price }}" data-area="{{ $unit->area }}">
                                {{ $unit->name }} - {{ number_format($unit->area, 0) }} م² - {{ number_format($unit->price, 0) }} جنيه
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Client Selection -->
                    <div class="form-group mb-3">
                        <label class="form-label">{{ __('العميل') }} <span class="text-danger">*</span></label>
                        <select name="client_id" class="form-select" required>
                            <option value="">{{ __('اختر العميل') }}</option>
                            @foreach($clients as $client)
                            <option value="{{ $client->id }}">{{ $client->name }}</option>
                            @endforeach
                        </select>
                        <small class="form-text text-muted">
                            <a href="{{ route('client.create') }}" target="_blank">{{ __('إضافة عميل جديد') }}</a>
                        </small>
                    </div>

                    <!-- Price Details -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">{{ __('السعر الإجمالي') }} <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="number" step="0.01" name="total_price" class="form-control" required id="totalPrice">
                                <span class="input-group-text">{{ __('جنيه') }}</span>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">{{ __('المقدم') }} <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="number" step="0.01" name="down_payment" class="form-control" required id="downPayment">
                                <span class="input-group-text">{{ __('جنيه') }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Installment Plan -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">{{ __('عدد الأقساط (شهور)') }}</label>
                            <input type="number" name="installment_months" class="form-control" value="0" min="0" id="installmentMonths">
                            <small class="form-text text-muted">{{ __('0 = دفعة واحدة') }}</small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">{{ __('المبلغ المتبقي') }}</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="remainingAmount" readonly>
                                <span class="input-group-text">{{ __('جنيه') }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Installment Amount Preview -->
                    <div class="alert alert-info" id="installmentPreview" style="display: none;">
                        <strong>{{ __('قيمة القسط الشهري') }}:</strong> <span id="monthlyInstallment">0</span> {{ __('جنيه') }}
                    </div>

                    <!-- Dates -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">{{ __('تاريخ العقد') }} <span class="text-danger">*</span></label>
                            <input type="date" name="contract_date" class="form-control" value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">{{ __('تاريخ التسليم المتوقع') }}</label>
                            <input type="date" name="delivery_date" class="form-control">
                        </div>
                    </div>

                    <!-- Notes -->
                    <div class="form-group mb-3">
                        <label class="form-label">{{ __('ملاحظات') }}</label>
                        <textarea name="notes" class="form-control" rows="3"></textarea>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="bi bi-file-earmark-text"></i> {{ __('إنشاء العقد') }}
                        </button>
                        <a href="{{ route('units.inventory', $project->id) }}" class="btn btn-secondary">
                            {{ __('إلغاء') }}
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
// Auto-fill price when unit is selected
document.getElementById('unitSelect').addEventListener('change', function() {
    const selected = this.options[this.selectedIndex];
    const price = selected.dataset.price;
    if (price) {
        document.getElementById('totalPrice').value = price;
        calculateRemaining();
    }
});

// Calculate remaining amount
document.getElementById('totalPrice').addEventListener('input', calculateRemaining);
document.getElementById('downPayment').addEventListener('input', calculateRemaining);
document.getElementById('installmentMonths').addEventListener('input', calculateRemaining);

function calculateRemaining() {
    const total = parseFloat(document.getElementById('totalPrice').value) || 0;
    const down = parseFloat(document.getElementById('downPayment').value) || 0;
    const months = parseInt(document.getElementById('installmentMonths').value) || 0;
    
    const remaining = total - down;
    document.getElementById('remainingAmount').value = remaining.toFixed(2);
    
    if (months > 0 && remaining > 0) {
        const monthly = remaining / months;
        document.getElementById('monthlyInstallment').textContent = monthly.toFixed(2);
        document.getElementById('installmentPreview').style.display = 'block';
    } else {
        document.getElementById('installmentPreview').style.display = 'none';
    }
}
</script>
@endsection
