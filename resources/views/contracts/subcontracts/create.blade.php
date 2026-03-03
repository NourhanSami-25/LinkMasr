@extends('layout.app')

@section('title', __('general.new_subcontract') ?? 'عقد جديد')

@section('breadcrumb')
    <li class="breadcrumb-item text-muted">
        <a href="{{ route('subcontracts.index') }}" class="text-muted text-hover-primary">{{ __('general.subcontracts') ?? 'عقود مقاولي الباطن' }}</a>
    </li>
    <li class="breadcrumb-item text-muted">{{ __('general.new_subcontract') ?? 'عقد جديد' }}</li>
@endsection

@section('content')
<div class="container-fluid">
    <form action="{{ route('subcontracts.store') }}" method="POST" id="subcontractForm">
        @csrf
        
        <!-- Basic Info Card -->
        <div class="card mb-5">
            <div class="card-header">
                <h5 class="mb-0">{{ __('general.contract_info') ?? 'معلومات العقد' }}</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label required">{{ __('general.project') ?? 'المشروع' }}</label>
                        <select name="project_id" id="project_id" class="form-select @error('project_id') is-invalid @enderror" required>
                            <option value="">{{ __('general.select_project') ?? 'اختر المشروع' }}</option>
                            @foreach($projects as $project)
                                <option value="{{ $project->id }}" {{ old('project_id', request('project_id')) == $project->id ? 'selected' : '' }}>
                                    {{ $project->subject }}
                                </option>
                            @endforeach
                        </select>
                        @error('project_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label required">{{ __('general.vendor') ?? 'المقاول' }}</label>
                        <select name="vendor_id" class="form-select @error('vendor_id') is-invalid @enderror" required>
                            <option value="">{{ __('general.select_vendor') ?? 'اختر المقاول' }}</option>
                            @foreach($vendors as $vendor)
                                <option value="{{ $vendor->id }}" {{ old('vendor_id') == $vendor->id ? 'selected' : '' }}>
                                    {{ $vendor->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('vendor_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label class="form-label required">{{ __('general.contract_title') ?? 'عنوان العقد' }}</label>
                        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" 
                               value="{{ old('title') }}" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label required">{{ __('general.start_date') ?? 'تاريخ البدء' }}</label>
                        <input type="date" name="start_date" class="form-control @error('start_date') is-invalid @enderror" 
                               value="{{ old('start_date') }}" required>
                        @error('start_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label required">{{ __('general.end_date') ?? 'تاريخ الانتهاء' }}</label>
                        <input type="date" name="end_date" class="form-control @error('end_date') is-invalid @enderror" 
                               value="{{ old('end_date') }}" required>
                        @error('end_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label required">{{ __('general.retention_percentage') ?? 'نسبة المحجوز (%)' }}</label>
                        <input type="number" name="retention_percentage" class="form-control @error('retention_percentage') is-invalid @enderror" 
                               value="{{ old('retention_percentage', 10) }}" step="0.01" min="0" max="100" required>
                        @error('retention_percentage')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">{{ __('general.advance_percentage') ?? 'نسبة الدفعة المقدمة (%)' }}</label>
                        <input type="number" name="advance_percentage" class="form-control" 
                               value="{{ old('advance_percentage', 0) }}" step="0.01" min="0" max="100">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">{{ __('general.insurance_percentage') ?? 'نسبة التأمين (%)' }}</label>
                        <input type="number" name="insurance_percentage" class="form-control" 
                               value="{{ old('insurance_percentage', 0) }}" step="0.01" min="0" max="100">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">{{ __('general.scope') ?? 'نطاق العمل' }}</label>
                    <textarea name="scope" class="form-control" rows="3">{{ old('scope') }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">{{ __('general.terms') ?? 'شروط العقد' }}</label>
                    <textarea name="terms" class="form-control" rows="3">{{ old('terms') }}</textarea>
                </div>
            </div>
        </div>

        <!-- Items Card -->
        <div class="card mb-5">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">{{ __('general.contract_items') ?? 'بنود العقد' }}</h5>
                <button type="button" class="btn btn-sm btn-success" id="addItemBtn" disabled>
                    <i class="fa fa-plus"></i> {{ __('general.add_item') ?? 'إضافة بند' }}
                </button>
            </div>
            <div class="card-body">
                <div class="alert alert-info" id="selectProjectAlert">
                    <i class="fa fa-info-circle me-2"></i>
                    {{ __('general.select_project_first') ?? 'الرجاء اختيار المشروع أولاً لتحميل بنود جدول الكميات' }}
                </div>

                <div class="table-responsive" id="itemsTableContainer" style="display: none;">
                    <table class="table table-bordered" id="itemsTable">
                        <thead class="table-light">
                            <tr>
                                <th width="40%">{{ __('general.boq_item') ?? 'بند جدول الكميات' }}</th>
                                <th width="15%">{{ __('general.quantity') ?? 'الكمية' }}</th>
                                <th width="15%">{{ __('general.unit_price') ?? 'سعر الوحدة' }}</th>
                                <th width="20%">{{ __('general.total') ?? 'الإجمالي' }}</th>
                                <th width="10%">{{ __('general.actions') ?? '' }}</th>
                            </tr>
                        </thead>
                        <tbody id="itemsBody">
                            <!-- Items will be added here dynamically -->
                        </tbody>
                        <tfoot>
                            <tr class="table-secondary fw-bold">
                                <td colspan="3" class="text-end">{{ __('general.contract_total') ?? 'إجمالي العقد' }}</td>
                                <td id="totalValue">0.00</td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-end">
            <a href="{{ route('subcontracts.index') }}" class="btn btn-light me-3">{{ __('general.cancel') ?? 'إلغاء' }}</a>
            <button type="submit" class="btn btn-primary" id="submitBtn" disabled>
                <i class="fa fa-save"></i> {{ __('general.save') ?? 'حفظ' }}
            </button>
        </div>
    </form>
</div>

<!-- BOQ Selection Modal -->
<div class="modal fade" id="boqModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h5 class="modal-title fw-bold text-white">
                    <i class="fa fa-list me-2 text-white"></i>{{ __('general.select_boq_item') ?? 'اختر بند من جدول الكميات' }}
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive" style="max-height: 400px;">
                    <table class="table table-hover table-sm">
                        <thead class="table-light sticky-top">
                            <tr>
                                <th>{{ __('general.code') ?? 'الكود' }}</th>
                                <th>{{ __('general.description') ?? 'الوصف' }}</th>
                                <th>{{ __('general.unit') ?? 'الوحدة' }}</th>
                                <th>{{ __('general.available_qty') ?? 'الكمية المتاحة' }}</th>
                                <th>{{ __('general.unit_price') ?? 'سعر الوحدة' }}</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="boqItemsList">
                            <!-- BOQ items loaded via AJAX -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    let boqItems = [];
    let itemIndex = 0;

    document.getElementById('project_id').addEventListener('change', function() {
        const projectId = this.value;
        
        if (projectId) {
            fetch('/subcontracts/boq-items/' + projectId)
                .then(response => response.json())
                .then(data => {
                    boqItems = data;
                    document.getElementById('selectProjectAlert').style.display = 'none';
                    document.getElementById('itemsTableContainer').style.display = 'block';
                    document.getElementById('addItemBtn').disabled = false;
                    renderBoqModal();
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('حدث خطأ أثناء تحميل البيانات');
                });
        } else {
            document.getElementById('selectProjectAlert').style.display = 'block';
            document.getElementById('itemsTableContainer').style.display = 'none';
            document.getElementById('addItemBtn').disabled = true;
            boqItems = [];
        }
    });

    function renderBoqModal() {
        const tbody = document.getElementById('boqItemsList');
        tbody.innerHTML = '';
        
        boqItems.forEach(item => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${item.code}</td>
                <td>${item.item_description}</td>
                <td>${item.unit}</td>
                <td>${item.quantity}</td>
                <td>${parseFloat(item.unit_price).toFixed(2)}</td>
                <td>
                    <button type="button" class="btn btn-sm btn-primary" onclick="selectBoqItem(${item.id}, '${item.code}', '${item.item_description.replace(/'/g, "\\'")}', ${item.quantity}, ${item.unit_price})">
                        <i class="fa fa-check"></i>
                    </button>
                </td>
            `;
            tbody.appendChild(row);
        });
    }

    document.getElementById('addItemBtn').addEventListener('click', function() {
        const modal = new bootstrap.Modal(document.getElementById('boqModal'));
        modal.show();
    });

    function selectBoqItem(boqId, code, description, maxQty, unitPrice) {
        const existingRow = document.querySelector(`tr[data-boq-id="${boqId}"]`);
        if (existingRow) {
            alert('هذا البند مضاف بالفعل');
            return;
        }

        const tbody = document.getElementById('itemsBody');
        const row = document.createElement('tr');
        row.setAttribute('data-boq-id', boqId);
        row.innerHTML = `
            <td>
                <strong>${code}</strong><br>
                <small class="text-muted">${description}</small>
                <input type="hidden" name="items[${itemIndex}][boq_id]" value="${boqId}">
            </td>
            <td>
                <input type="number" name="items[${itemIndex}][quantity]" class="form-control form-control-sm qty-input" 
                       value="${maxQty}" step="0.01" min="0.01" max="${maxQty}" required onchange="calculateRowTotal(this)">
            </td>
            <td>
                <input type="number" name="items[${itemIndex}][unit_price]" class="form-control form-control-sm price-input" 
                       value="${unitPrice}" step="0.01" min="0" required onchange="calculateRowTotal(this)">
            </td>
            <td class="row-total">${(maxQty * unitPrice).toFixed(2)}</td>
            <td>
                <button type="button" class="btn btn-sm btn-danger" onclick="removeItem(this)">
                    <i class="fa fa-trash"></i>
                </button>
            </td>
        `;
        tbody.appendChild(row);
        itemIndex++;
        
        calculateTotal();
        updateSubmitButton();
        
        bootstrap.Modal.getInstance(document.getElementById('boqModal')).hide();
    }

    function calculateRowTotal(input) {
        const row = input.closest('tr');
        const qty = parseFloat(row.querySelector('.qty-input').value) || 0;
        const price = parseFloat(row.querySelector('.price-input').value) || 0;
        row.querySelector('.row-total').textContent = (qty * price).toFixed(2);
        calculateTotal();
    }

    function calculateTotal() {
        let total = 0;
        document.querySelectorAll('.row-total').forEach(cell => {
            total += parseFloat(cell.textContent) || 0;
        });
        document.getElementById('totalValue').textContent = total.toFixed(2);
    }

    function removeItem(btn) {
        btn.closest('tr').remove();
        calculateTotal();
        updateSubmitButton();
    }

    function updateSubmitButton() {
        const hasItems = document.querySelectorAll('#itemsBody tr').length > 0;
        document.getElementById('submitBtn').disabled = !hasItems;
    }

    // Trigger project change if already selected
    if (document.getElementById('project_id').value) {
        document.getElementById('project_id').dispatchEvent(new Event('change'));
    }
</script>
@endsection
