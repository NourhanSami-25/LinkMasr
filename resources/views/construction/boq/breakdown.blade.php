@extends('layout.app')

@section('title', __('general.boq_breakdown') ?? 'تحليل البند')

@section('breadcrumb')
    <li class="breadcrumb-item text-muted">
        <a href="{{ route('construction.index') }}" class="text-muted text-hover-primary">{{ __('general.construction') ?? 'المقاولات' }}</a>
    </li>
    <li class="breadcrumb-item text-muted">
        <a href="{{ route('construction.boq.index', $boq->project_id) }}" class="text-muted text-hover-primary">{{ __('general.boq') ?? 'جدول الكميات' }}</a>
    </li>
    <li class="breadcrumb-item text-muted">{{ __('general.breakdown') ?? 'التحليل' }}</li>
@endsection

@section('content')
<div class="container-fluid">
    <!-- BOQ Item Header -->
    <div class="card mb-5">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h3 class="mb-2">{{ $boq->item_description }}</h3>
                    <div class="d-flex gap-4 text-muted">
                        <span><strong>{{ __('general.code') ?? 'الكود' }}:</strong> {{ $boq->code }}</span>
                        <span><strong>{{ __('general.quantity') ?? 'الكمية' }}:</strong> {{ number_format($boq->quantity, 2) }} {{ $boq->unit }}</span>
                        <span><strong>{{ __('general.unit_price') ?? 'سعر الوحدة' }}:</strong> {{ number_format($boq->unit_price, 2) }}</span>
                        <span><strong>{{ __('general.total') ?? 'الإجمالي' }}:</strong> {{ number_format($boq->total_price, 2) }}</span>
                    </div>
                </div>
                <div class="col-md-4 text-end">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addItemModal">
                        <i class="fa fa-plus"></i> {{ __('general.add_item') ?? 'إضافة عنصر' }}
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="row mb-5">
        <div class="col-md-3">
            <div class="card bg-light-primary">
                <div class="card-body py-4">
                    <div class="d-flex align-items-center">
                        <div class="symbol symbol-50px me-4">
                            <span class="symbol-label bg-primary">
                                <i class="fa fa-calculator text-white fs-2"></i>
                            </span>
                        </div>
                        <div>
                            <div class="fs-4 fw-bold text-gray-800">{{ number_format($summary['grand_total'], 2) }}</div>
                            <div class="fs-7 text-muted">{{ __('general.breakdown_total') ?? 'إجمالي التحليل' }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-light-success">
                <div class="card-body py-4">
                    <div class="d-flex align-items-center">
                        <div class="symbol symbol-50px me-4">
                            <span class="symbol-label bg-success">
                                <i class="fa fa-file-invoice text-white fs-2"></i>
                            </span>
                        </div>
                        <div>
                            <div class="fs-4 fw-bold text-gray-800">{{ number_format($summary['boq_total'], 2) }}</div>
                            <div class="fs-7 text-muted">{{ __('general.boq_total') ?? 'إجمالي BOQ' }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card {{ $summary['difference'] == 0 ? 'bg-light-success' : 'bg-light-warning' }}">
                <div class="card-body py-4">
                    <div class="d-flex align-items-center">
                        <div class="symbol symbol-50px me-4">
                            <span class="symbol-label {{ $summary['difference'] == 0 ? 'bg-success' : 'bg-warning' }}">
                                <i class="fa fa-balance-scale text-white fs-2"></i>
                            </span>
                        </div>
                        <div>
                            <div class="fs-4 fw-bold text-gray-800">{{ number_format($summary['difference'], 2) }}</div>
                            <div class="fs-7 text-muted">{{ __('general.difference') ?? 'الفرق' }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-light-info">
                <div class="card-body py-4">
                    <div class="d-flex align-items-center">
                        <div class="symbol symbol-50px me-4">
                            <span class="symbol-label bg-info">
                                <i class="fa fa-list text-white fs-2"></i>
                            </span>
                        </div>
                        <div>
                            <div class="fs-4 fw-bold text-gray-800">{{ $boq->breakdownItems->count() }}</div>
                            <div class="fs-7 text-muted">{{ __('general.items_count') ?? 'عدد العناصر' }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Breakdown by Category -->
    @foreach($summary['summary'] as $categoryData)
    <div class="card mb-4">
        <div class="card-header bg-light">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fa fa-folder-open me-2"></i>
                    {{ $categoryData['category']->name_ar }}
                </h5>
                <span class="badge badge-light-primary fs-6 fw-bold">
                    {{ __('general.subtotal') ?? 'الإجمالي' }}: {{ number_format($categoryData['total'], 2) }}
                </span>
            </div>
        </div>
        <div class="card-body p-0">
            @if($categoryData['items']->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover table-striped align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 100px;">{{ __('general.code') ?? 'الكود' }}</th>
                            <th>{{ __('general.description') ?? 'الوصف' }}</th>
                            <th style="width: 80px;">{{ __('general.unit') ?? 'الوحدة' }}</th>
                            <th style="width: 100px;">{{ __('general.quantity') ?? 'الكمية' }}</th>
                            <th style="width: 120px;">{{ __('general.unit_price') ?? 'سعر الوحدة' }}</th>
                            <th style="width: 120px;">{{ __('general.total') ?? 'الإجمالي' }}</th>
                            <th style="width: 100px;">{{ __('general.actions') ?? 'الإجراءات' }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categoryData['items'] as $item)
                        <tr>
                            <td><code>{{ $item->item_code ?? '-' }}</code></td>
                            <td>{{ $item->description }}</td>
                            <td><span class="badge badge-light-info fs-7 fw-bold">{{ $item->unit }}</span></td>
                            <td>{{ number_format($item->quantity, 4) }}</td>
                            <td>{{ number_format($item->unit_price, 2) }}</td>
                            <td><strong>{{ number_format($item->total_price, 2) }}</strong></td>
                            <td>
                                <button type="button" class="btn btn-sm btn-light-primary" 
                                        onclick="editItem({{ json_encode($item) }})"
                                        data-bs-toggle="modal" data-bs-target="#editItemModal">
                                    <i class="fa fa-edit"></i>
                                </button>
                                <form action="{{ route('construction.breakdown.destroy', $item->id) }}" method="POST" class="d-inline" 
                                      onsubmit="return confirm('{{ __('general.confirm_delete') ?? 'هل أنت متأكد من الحذف؟' }}')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-light-danger">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="text-center text-muted py-5">
                <i class="fa fa-inbox fs-1 mb-3 d-block"></i>
                {{ __('general.no_items') ?? 'لا توجد عناصر في هذه الفئة' }}
            </div>
            @endif
        </div>
    </div>
    @endforeach
</div>

<!-- Add Item Modal -->
<div class="modal fade" id="addItemModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('construction.boq.breakdown.store', $boq->id) }}" method="POST">
                @csrf
                <div class="modal-header bg-primary">
                    <h5 class="modal-title fw-bold text-white">
                        <i class="fa fa-plus-circle me-2 text-white"></i>{{ __('general.add_breakdown_item') ?? 'إضافة عنصر تحليل' }}
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label required">{{ __('general.category') ?? 'الفئة' }}</label>
                            <select name="category_id" class="form-select" required>
                                <option value="">{{ __('general.select') ?? 'اختر' }}...</option>
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name_ar }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">{{ __('general.item_code') ?? 'كود العنصر' }}</label>
                            <input type="text" name="item_code" class="form-control" placeholder="مثال: 10600900003">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label required">{{ __('general.description') ?? 'الوصف' }}</label>
                        <input type="text" name="description" class="form-control" required placeholder="مثال: خرسانة مسلحة جاهزة">
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label required">{{ __('general.unit') ?? 'الوحدة' }}</label>
                            <input type="text" name="unit" class="form-control" required placeholder="م³، طن، عدد...">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label required">{{ __('general.quantity') ?? 'الكمية' }}</label>
                            <input type="number" name="quantity" class="form-control" step="0.0001" min="0" required id="addQty">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label required">{{ __('general.unit_price') ?? 'سعر الوحدة' }}</label>
                            <input type="number" name="unit_price" class="form-control" step="0.01" min="0" required id="addPrice">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ __('general.calculated_total') ?? 'الإجمالي المحسوب' }}</label>
                        <input type="text" class="form-control bg-light" readonly id="addTotal" value="0.00">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ __('general.notes') ?? 'ملاحظات' }}</label>
                        <textarea name="notes" class="form-control" rows="2"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{ __('general.cancel') ?? 'إلغاء' }}</button>
                    <button type="submit" class="btn btn-primary">{{ __('general.add') ?? 'إضافة' }}</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Item Modal -->
<div class="modal fade" id="editItemModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="editItemForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header bg-warning">
                    <h5 class="modal-title fw-bold text-dark">
                        <i class="fa fa-edit me-2 text-dark"></i>{{ __('general.edit_breakdown_item') ?? 'تعديل عنصر التحليل' }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label required">{{ __('general.category') ?? 'الفئة' }}</label>
                            <select name="category_id" id="editCategoryId" class="form-select" required>
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name_ar }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">{{ __('general.item_code') ?? 'كود العنصر' }}</label>
                            <input type="text" name="item_code" id="editItemCode" class="form-control">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label required">{{ __('general.description') ?? 'الوصف' }}</label>
                        <input type="text" name="description" id="editDescription" class="form-control" required>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label required">{{ __('general.unit') ?? 'الوحدة' }}</label>
                            <input type="text" name="unit" id="editUnit" class="form-control" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label required">{{ __('general.quantity') ?? 'الكمية' }}</label>
                            <input type="number" name="quantity" id="editQty" class="form-control" step="0.0001" min="0" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label required">{{ __('general.unit_price') ?? 'سعر الوحدة' }}</label>
                            <input type="number" name="unit_price" id="editPrice" class="form-control" step="0.01" min="0" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ __('general.calculated_total') ?? 'الإجمالي المحسوب' }}</label>
                        <input type="text" class="form-control bg-light" readonly id="editTotal" value="0.00">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ __('general.notes') ?? 'ملاحظات' }}</label>
                        <textarea name="notes" id="editNotes" class="form-control" rows="2"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{ __('general.cancel') ?? 'إلغاء' }}</button>
                    <button type="submit" class="btn btn-warning">{{ __('general.save_changes') ?? 'حفظ التغييرات' }}</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    // Calculate total on add modal
    document.getElementById('addQty').addEventListener('input', calculateAddTotal);
    document.getElementById('addPrice').addEventListener('input', calculateAddTotal);
    
    function calculateAddTotal() {
        const qty = parseFloat(document.getElementById('addQty').value) || 0;
        const price = parseFloat(document.getElementById('addPrice').value) || 0;
        document.getElementById('addTotal').value = (qty * price).toFixed(2);
    }
    
    // Calculate total on edit modal
    document.getElementById('editQty').addEventListener('input', calculateEditTotal);
    document.getElementById('editPrice').addEventListener('input', calculateEditTotal);
    
    function calculateEditTotal() {
        const qty = parseFloat(document.getElementById('editQty').value) || 0;
        const price = parseFloat(document.getElementById('editPrice').value) || 0;
        document.getElementById('editTotal').value = (qty * price).toFixed(2);
    }
    
    // Populate edit modal
    function editItem(item) {
        document.getElementById('editItemForm').action = '/construction/breakdown/' + item.id;
        document.getElementById('editCategoryId').value = item.category_id;
        document.getElementById('editItemCode').value = item.item_code || '';
        document.getElementById('editDescription').value = item.description;
        document.getElementById('editUnit').value = item.unit;
        document.getElementById('editQty').value = item.quantity;
        document.getElementById('editPrice').value = item.unit_price;
        document.getElementById('editNotes').value = item.notes || '';
        calculateEditTotal();
    }
</script>
@endsection
