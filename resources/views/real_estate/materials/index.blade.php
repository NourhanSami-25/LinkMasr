@extends('layout.app')

@section('title')
    {{ __('مواد البناء') }}
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-0">{{ __('قائمة مواد البناء والتشطيب') }}</h4>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addMaterialModal">
                    <i class="bi bi-plus-circle"></i> {{ __('إضافة مادة جديدة') }}
                </button>
            </div>
            <div class="card-body">
                @if($materials->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover table-striped align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>{{ __('اسم المادة') }}</th>
                                <th>{{ __('وحدة القياس') }}</th>
                                <th>{{ __('السعر الحالي') }}</th>
                                <th>{{ __('آخر تحديث') }}</th>
                                <th class="text-center">{{ __('الإجراءات') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($materials as $index => $material)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <strong>{{ $material->name }}</strong>
                                    @if($material->description)
                                    <br><small class="text-muted">{{ $material->description }}</small>
                                    @endif
                                </td>
                                <td><span class="badge badge-light-info fs-7 fw-bold">{{ $material->unit }}</span></td>
                                <td class="fw-bold text-success">
                                    {{ number_format($material->latest_price, 2) }} {{ __('جنيه') }}
                                </td>
                                <td>
                                    @if($material->prices->first())
                                        <small>{{ \Carbon\Carbon::parse($material->prices->first()->date)->format('Y-m-d') }}</small>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#priceHistoryModal{{ $material->id }}" title="{{ __('عرض تاريخ الأسعار') }}">
                                            <i class="bi bi-clock-history"></i>
                                        </button>
                                        <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#updatePriceModal{{ $material->id }}" title="{{ __('تحديث السعر') }}">
                                            <i class="bi bi-currency-dollar"></i>
                                        </button>
                                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editMaterialModal{{ $material->id }}" title="{{ __('تعديل') }}">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                    </div>
                                    
                                    <!-- Price History Modal -->
                                    <div class="modal fade" id="priceHistoryModal{{ $material->id }}" tabindex="-1">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header bg-primary">
                                                    <h5 class="modal-title fw-bold text-white">
                                                        <i class="bi bi-clock-history me-2 text-white"></i>{{ __('تاريخ أسعار') }}: {{ $material->name }}
                                                    </h5>
                                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    @if($material->prices->count() > 0)
                                                    <table class="table table-sm">
                                                        <thead>
                                                            <tr>
                                                                <th>{{ __('التاريخ') }}</th>
                                                                <th>{{ __('السعر') }}</th>
                                                                <th>{{ __('التغيير') }}</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($material->prices as $priceIndex => $price)
                                                            <tr>
                                                                <td>{{ \Carbon\Carbon::parse($price->date)->format('Y-m-d') }}</td>
                                                                <td class="fw-bold">{{ number_format($price->price, 2) }} {{ __('جنيه') }}</td>
                                                                <td>
                                                                    @if($priceIndex < $material->prices->count() - 1)
                                                                        @php
                                                                            $previousPrice = $material->prices[$priceIndex + 1]->price;
                                                                            $change = $price->price - $previousPrice;
                                                                            $changePercent = $previousPrice > 0 ? ($change / $previousPrice) * 100 : 0;
                                                                        @endphp
                                                                        @if($change > 0)
                                                                            <span class="badge badge-light-success fs-7 fw-bold">
                                                                                <i class="bi bi-arrow-up"></i> +{{ number_format($changePercent, 1) }}%
                                                                            </span>
                                                                        @elseif($change < 0)
                                                                            <span class="badge badge-light-danger fs-7 fw-bold">
                                                                                <i class="bi bi-arrow-down"></i> {{ number_format($changePercent, 1) }}%
                                                                            </span>
                                                                        @else
                                                                            <span class="badge badge-light-secondary fs-7 fw-bold">-</span>
                                                                        @endif
                                                                    @else
                                                                        <span class="badge badge-light-secondary fs-7 fw-bold">{{ __('أول سعر') }}</span>
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                    @else
                                                    <div class="alert alert-info">{{ __('لا يوجد تاريخ أسعار لهذه المادة') }}</div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Update Price Modal -->
                                    <div class="modal fade" id="updatePriceModal{{ $material->id }}" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form action="{{ route('materials.prices.store', $material->id) }}" method="POST">
                                                    @csrf
                                                    <div class="modal-header bg-success">
                                                        <h5 class="modal-title fw-bold text-white">
                                                            <i class="bi bi-tag me-2 text-white"></i>{{ __('تحديث سعر') }}: {{ $material->name }}
                                                        </h5>
                                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="alert alert-info">
                                                            <strong>{{ __('السعر الحالي') }}:</strong> {{ number_format($material->latest_price, 2) }} {{ __('جنيه') }} / {{ $material->unit }}
                                                        </div>
                                                        <div class="form-group mb-3">
                                                            <label class="form-label">{{ __('السعر الجديد') }} <span class="text-danger">*</span></label>
                                                            <div class="input-group">
                                                                <input type="number" step="0.01" name="price" class="form-control" required placeholder="0.00">
                                                                <span class="input-group-text">{{ __('جنيه') }}</span>
                                                            </div>
                                                        </div>
                                                        <div class="form-group mb-3">
                                                            <label class="form-label">{{ __('تاريخ السريان') }} <span class="text-danger">*</span></label>
                                                            <input type="date" name="date" class="form-control" value="{{ date('Y-m-d') }}" required>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('إلغاء') }}</button>
                                                        <button type="submit" class="btn btn-success">
                                                            <i class="bi bi-check-circle"></i> {{ __('حفظ السعر') }}
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Edit Material Modal -->
                                    <div class="modal fade" id="editMaterialModal{{ $material->id }}" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form action="{{ route('materials.update', $material->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-header bg-warning">
                                                        <h5 class="modal-title fw-bold text-dark">
                                                            <i class="bi bi-pencil-square me-2 text-dark"></i>{{ __('تعديل المادة') }}
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="form-group mb-3">
                                                            <label class="form-label">{{ __('اسم المادة') }} <span class="text-danger">*</span></label>
                                                            <input type="text" name="name" class="form-control" value="{{ $material->name }}" required>
                                                        </div>
                                                        <div class="form-group mb-3">
                                                            <label class="form-label">{{ __('وحدة القياس') }} <span class="text-danger">*</span></label>
                                                            <input type="text" name="unit" class="form-control" value="{{ $material->unit }}" required>
                                                        </div>
                                                        <div class="form-group mb-3">
                                                            <label class="form-label">{{ __('الوصف') }}</label>
                                                            <textarea name="description" class="form-control" rows="3">{{ $material->description }}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('إلغاء') }}</button>
                                                        <button type="submit" class="btn btn-warning">
                                                            <i class="bi bi-save"></i> {{ __('حفظ التعديلات') }}
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="alert alert-warning text-center">
                    <i class="bi bi-exclamation-triangle fs-1"></i>
                    <p class="mt-2">{{ __('لا توجد مواد بناء مسجلة بعد') }}</p>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addMaterialModal">
                        {{ __('إضافة أول مادة') }}
                    </button>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Add Material Modal -->
<div class="modal fade" id="addMaterialModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('materials.store') }}" method="POST">
                @csrf
                <div class="modal-header bg-primary">
                    <h5 class="modal-title fw-bold text-white">
                        <i class="bi bi-plus-circle me-2 text-white"></i>{{ __('إضافة مادة بناء جديدة') }}
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label class="form-label">{{ __('اسم المادة') }} <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" required placeholder="مثال: أسمنت، رمل، طوب">
                        <small class="form-text text-muted">{{ __('أدخل اسم المادة بوضوح') }}</small>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label">{{ __('وحدة القياس') }} <span class="text-danger">*</span></label>
                        <select name="unit" class="form-select" required>
                            <option value="">{{ __('اختر وحدة القياس') }}</option>
                            <option value="طن">{{ __('طن') }}</option>
                            <option value="متر مكعب">{{ __('متر مكعب') }}</option>
                            <option value="متر مربع">{{ __('متر مربع') }}</option>
                            <option value="ألف طوبة">{{ __('ألف طوبة') }}</option>
                            <option value="كيس">{{ __('كيس') }}</option>
                            <option value="لتر">{{ __('لتر') }}</option>
                            <option value="قطعة">{{ __('قطعة') }}</option>
                            <option value="كيلوجرام">{{ __('كيلوجرام') }}</option>
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label">{{ __('الوصف') }}</label>
                        <textarea name="description" class="form-control" rows="3" placeholder="وصف اختياري للمادة"></textarea>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label">{{ __('السعر الأولي (اختياري)') }}</label>
                        <div class="input-group">
                            <input type="number" step="0.01" name="initial_price" class="form-control" placeholder="0.00">
                            <span class="input-group-text">{{ __('جنيه') }}</span>
                        </div>
                        <small class="form-text text-muted">{{ __('يمكنك إضافة السعر لاحقاً') }}</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('إلغاء') }}</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-plus-circle"></i> {{ __('إضافة المادة') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
// Auto-focus on modal open
document.querySelectorAll('.modal').forEach(modal => {
    modal.addEventListener('shown.bs.modal', function () {
        const firstInput = this.querySelector('input:not([type="hidden"])');
        if (firstInput) firstInput.focus();
    });
});
</script>
@endsection
