@extends('layout.app')

@section('title')
    {{ __('جدول الكميات (BOQ)') }} - {{ $project->subject }}
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-0">{{ __('جدول الكميات (BOQ)') }}</h4>
                <div>
                    <a href="{{ route('construction.evm.dashboard', $project->id) }}" class="btn btn-info btn-sm">
                        <i class="bi bi-graph-up"></i> {{ __('EVM Dashboard') }}
                    </a>
                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addBoqModal">
                        <i class="bi bi-plus-circle"></i> {{ __('إضافة بند جديد') }}
                    </button>
                </div>
            </div>
            <div class="card-body">
                @if($project->boqItems->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover table-striped align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>{{ __('الكود') }}</th>
                                <th>{{ __('وصف البند') }}</th>
                                <th>{{ __('الكمية') }}</th>
                                <th>{{ __('الوحدة') }}</th>
                                <th>{{ __('سعر الوحدة') }}</th>
                                <th>{{ __('الإجمالي') }}</th>
                                <th>{{ __('تاريخ البدء') }}</th>
                                <th>{{ __('تاريخ الانتهاء') }}</th>
                                <th>{{ __('الحالة') }}</th>
                                <th>{{ __('الإجراءات') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($project->boqItems as $index => $item)
                            <tr>
                                <td><code>{{ $item->code }}</code></td>
                                <td><strong>{{ $item->item_description }}</strong></td>
                                <td>{{ number_format($item->quantity, 2) }}</td>
                                <td><span class="badge badge-light-info fs-7 fw-bold">{{ $item->unit }}</span></td>
                                <td>{{ number_format($item->unit_price, 2) }} {{ __('جنيه') }}</td>
                                <td class="fw-bold text-success">{{ number_format($item->total_price, 2) }} {{ __('جنيه') }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->start_date)->format('Y-m-d') }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->end_date)->format('Y-m-d') }}</td>
                                <td>
                                    @php
                                        $today = \Carbon\Carbon::now();
                                        $start = \Carbon\Carbon::parse($item->start_date);
                                        $end = \Carbon\Carbon::parse($item->end_date);
                                    @endphp
                                    @if($today->lt($start))
                                        <span class="badge badge-light-secondary fs-7 fw-bold">{{ __('لم يبدأ') }}</span>
                                    @elseif($today->gt($end))
                                        <span class="badge badge-light-dark fs-7 fw-bold">{{ __('منتهي') }}</span>
                                    @else
                                        <span class="badge badge-light-success fs-7 fw-bold">{{ __('جاري التنفيذ') }}</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('construction.boq.breakdown', $item->id) }}" class="btn btn-sm btn-light-primary" title="{{ __('تحليل البند') }}">
                                        <i class="fa fa-sitemap"></i> {{ __('تحليل') }}
                                    </a>
                                    @if($item->has_breakdown)
                                        <span class="badge badge-light-success fs-8">{{ $item->breakdownItems->count() }} عنصر</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="table-secondary fw-bold">
                            <tr>
                                <td colspan="5" class="text-end">{{ __('الإجمالي الكلي') }}:</td>
                                <td>{{ number_format($project->boqItems->sum('total_price'), 2) }} {{ __('جنيه') }}</td>
                                <td colspan="4"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                @else
                <div class="alert alert-warning text-center">
                    <i class="bi bi-exclamation-triangle fs-1"></i>
                    <p class="mt-2">{{ __('لا توجد بنود BOQ لهذا المشروع بعد') }}</p>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addBoqModal">
                        {{ __('إضافة أول بند') }}
                    </button>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Add BOQ Modal -->
<div class="modal fade" id="addBoqModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('construction.boq.store', $project->id) }}" method="POST">
                @csrf
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white fw-bold">
                        <i class="bi bi-plus-circle-fill me-2 text-white"></i>{{ __('إضافة بند BOQ جديد') }}
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label class="form-label">{{ __('الكود') }}</label>
                            <input type="text" name="code" class="form-control" placeholder="سيُنشأ تلقائياً">
                            <small class="text-muted">{{ __('اتركه فارغاً للإنشاء التلقائي') }}</small>
                        </div>
                        <div class="col-md-9 mb-3">
                            <label class="form-label">{{ __('وصف البند') }} <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <select name="item_description" id="itemDescriptionSelect" class="form-select" required>
                                    <option value="">{{ __('اختر وصف البند...') }}</option>
                                </select>
                                <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#managePresetsModal" title="{{ __('إدارة الأوصاف المسبقة') }}">
                                    <i class="bi bi-gear"></i>
                                </button>
                            </div>
                            <small class="text-muted">{{ __('اختر من القائمة أو أضف وصف جديد من زر الإعدادات') }}</small>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">{{ __('الكمية') }} <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" name="quantity" class="form-control" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">{{ __('الوحدة') }} <span class="text-danger">*</span></label>
                            <select name="unit" class="form-select" required>
                                <option value="">{{ __('اختر الوحدة') }}</option>
                                <option value="متر مكعب">{{ __('متر مكعب') }}</option>
                                <option value="متر مربع">{{ __('متر مربع') }}</option>
                                <option value="متر طولي">{{ __('متر طولي') }}</option>
                                <option value="طن">{{ __('طن') }}</option>
                                <option value="كيلوجرام">{{ __('كيلوجرام') }}</option>
                                <option value="قطعة">{{ __('قطعة') }}</option>
                                <option value="يوم عمل">{{ __('يوم عمل') }}</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">{{ __('سعر الوحدة') }} <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" name="unit_price" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">{{ __('تاريخ البدء') }} <span class="text-danger">*</span></label>
                            <input type="date" name="start_date" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">{{ __('تاريخ الانتهاء') }} <span class="text-danger">*</span></label>
                            <input type="date" name="end_date" class="form-control" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('إلغاء') }}</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> {{ __('حفظ البند') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Manage Description Presets Modal -->
<div class="modal fade" id="managePresetsModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary py-3">
                <h5 class="modal-title fw-bold text-white">
                    <i class="bi bi-list-check me-2 text-white"></i>{{ __('إدارة أوصاف البنود المسبقة') }}
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <!-- Add New Preset Form -->
                <div class="mb-4">
                    <label class="form-label fw-semibold text-dark mb-2">
                        <i class="bi bi-plus-square me-1"></i>{{ __('إضافة وصف جديد') }}
                    </label>
                    <form id="addPresetForm">
                        <div class="input-group">
                            <input type="text" id="newPresetDescription" class="form-control form-control-lg" placeholder="{{ __('أدخل وصف البند...') }}" required>
                            <button type="submit" class="btn btn-success px-4">
                                <i class="bi bi-plus-circle me-1"></i> {{ __('إضافة') }}
                            </button>
                        </div>
                    </form>
                </div>

                <hr class="my-3">

                <!-- Presets List -->
                <div>
                    <label class="form-label fw-semibold text-dark mb-2">
                        <i class="bi bi-bookmark-star me-1"></i>{{ __('الأوصاف المسبقة الحالية') }}
                    </label>
                    <div class="border rounded">
                        <div id="presetsListLoading" class="text-center py-5">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">{{ __('جاري التحميل...') }}</span>
                            </div>
                            <p class="text-muted mt-2 mb-0">{{ __('جاري التحميل...') }}</p>
                        </div>
                        <ul id="presetsList" class="list-group list-group-flush" style="max-height: 300px; overflow-y: auto;">
                            <!-- Presets will be loaded here dynamically -->
                        </ul>
                        <div id="presetsEmpty" class="text-center py-5" style="display: none;">
                            <i class="bi bi-inbox text-muted" style="font-size: 3rem;"></i>
                            <p class="text-muted mt-3 mb-0">{{ __('لا توجد أوصاف مسبقة بعد') }}</p>
                            <small class="text-muted">{{ __('أضف وصفاً جديداً من الحقل أعلاه') }}</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-light py-3">
                <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle me-1"></i>{{ __('إغلاق') }}
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Preset Modal -->
<div class="modal fade" id="editPresetModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-info py-3">
                <h5 class="modal-title fw-bold text-white">
                    <i class="bi bi-pencil-square me-2 text-white"></i>{{ __('تعديل وصف البند') }}
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <form id="editPresetForm">
                    <input type="hidden" id="editPresetId">
                    <div class="mb-0">
                        <label class="form-label fw-semibold text-dark mb-2">{{ __('وصف البند') }}</label>
                        <input type="text" id="editPresetDescription" class="form-control form-control-lg" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer bg-light py-3">
                <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle me-1"></i>{{ __('إلغاء') }}
                </button>
                <button type="button" class="btn btn-primary px-4" id="saveEditPresetBtn">
                    <i class="bi bi-save me-1"></i> {{ __('حفظ التعديلات') }}
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const itemDescriptionSelect = document.getElementById('itemDescriptionSelect');
    const presetsList = document.getElementById('presetsList');
    const presetsListLoading = document.getElementById('presetsListLoading');
    const presetsEmpty = document.getElementById('presetsEmpty');
    const addPresetForm = document.getElementById('addPresetForm');
    const newPresetDescription = document.getElementById('newPresetDescription');
    const editPresetModal = new bootstrap.Modal(document.getElementById('editPresetModal'));
    const managePresetsModal = document.getElementById('managePresetsModal');
    
    // Load presets on page load
    loadPresets();
    
    // Load presets when manage modal is opened
    managePresetsModal.addEventListener('show.bs.modal', function() {
        loadPresetsList();
    });
    
    // Add new preset
    addPresetForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const description = newPresetDescription.value.trim();
        
        if (!description) return;
        
        fetch('{{ route("construction.boq.presets.store") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ description: description })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                newPresetDescription.value = '';
                loadPresets();
                loadPresetsList();
                showToast('success', data.message);
            } else {
                showToast('error', data.message || 'حدث خطأ');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('error', 'حدث خطأ أثناء الإضافة');
        });
    });
    
    // Save edit preset
    document.getElementById('saveEditPresetBtn').addEventListener('click', function() {
        const presetId = document.getElementById('editPresetId').value;
        const description = document.getElementById('editPresetDescription').value.trim();
        
        if (!description) return;
        
        fetch(`{{ url('construction/boq/description-presets') }}/${presetId}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ description: description })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                editPresetModal.hide();
                loadPresets();
                loadPresetsList();
                showToast('success', data.message);
            } else {
                showToast('error', data.message || 'حدث خطأ');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('error', 'حدث خطأ أثناء التحديث');
        });
    });
    
    // Load presets for dropdown
    function loadPresets() {
        fetch('{{ route("construction.boq.presets.index") }}')
        .then(response => response.json())
        .then(presets => {
            const currentValue = itemDescriptionSelect.value;
            itemDescriptionSelect.innerHTML = '<option value="">{{ __("اختر وصف البند...") }}</option>';
            
            presets.forEach(preset => {
                const option = document.createElement('option');
                option.value = preset.description;
                option.textContent = preset.description;
                itemDescriptionSelect.appendChild(option);
            });
            
            // Restore selected value if exists
            if (currentValue) {
                itemDescriptionSelect.value = currentValue;
            }
        })
        .catch(error => {
            console.error('Error loading presets:', error);
        });
    }
    
    // Load presets list for management modal
    function loadPresetsList() {
        presetsListLoading.style.display = 'block';
        presetsList.innerHTML = '';
        presetsEmpty.style.display = 'none';
        
        fetch('{{ route("construction.boq.presets.index") }}')
        .then(response => response.json())
        .then(presets => {
            presetsListLoading.style.display = 'none';
            
            if (presets.length === 0) {
                presetsEmpty.style.display = 'block';
                return;
            }
            
            presets.forEach(preset => {
                const li = document.createElement('li');
                li.className = 'list-group-item d-flex justify-content-between align-items-center';
                li.innerHTML = `
                    <span class="flex-grow-1">${escapeHtml(preset.description)}</span>
                    <div class="btn-group btn-group-sm">
                        <button type="button" class="btn btn-outline-info edit-preset-btn" data-id="${preset.id}" data-description="${escapeHtml(preset.description)}">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <button type="button" class="btn btn-outline-danger delete-preset-btn" data-id="${preset.id}">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                `;
                presetsList.appendChild(li);
            });
            
            // Attach event listeners
            document.querySelectorAll('.edit-preset-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    document.getElementById('editPresetId').value = this.dataset.id;
                    document.getElementById('editPresetDescription').value = this.dataset.description;
                    editPresetModal.show();
                });
            });
            
            document.querySelectorAll('.delete-preset-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    if (confirm('{{ __("هل أنت متأكد من حذف هذا الوصف؟") }}')) {
                        deletePreset(this.dataset.id);
                    }
                });
            });
        })
        .catch(error => {
            console.error('Error:', error);
            presetsListLoading.style.display = 'none';
        });
    }
    
    // Delete preset
    function deletePreset(presetId) {
        fetch(`{{ url('construction/boq/description-presets') }}/${presetId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                loadPresets();
                loadPresetsList();
                showToast('success', data.message);
            } else {
                showToast('error', data.message || 'حدث خطأ');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('error', 'حدث خطأ أثناء الحذف');
        });
    }
    
    // Helper function to escape HTML
    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
    
    // Toast notification helper
    function showToast(type, message) {
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                icon: type === 'success' ? 'success' : 'error',
                title: message,
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
        } else if (typeof toastr !== 'undefined') {
            toastr[type](message);
        } else {
            alert(message);
        }
    }
});
</script>
@endsection
