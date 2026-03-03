@extends('layout.app')

@section('title')
    {{ __('تسجيل التقدم') }} - {{ $project->subject }}
@endsection

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card">
            <div class="card-header bg-success text-white">
                <h4 class="card-title mb-0">{{ __('تسجيل التقدم اليومي') }}</h4>
            </div>
            <div class="card-body">
                @if($project->boqItems->count() > 0)
                <form action="{{ route('construction.progress.store', $project->id) }}" method="POST">
                    @csrf
                    <div class="form-group mb-3">
                        <label class="form-label">{{ __('البند') }} <span class="text-danger">*</span></label>
                        <select name="boq_id" class="form-select" required id="boqSelect">
                            <option value="">{{ __('اختر البند') }}</option>
                            @foreach($project->boqItems as $item)
                            <option value="{{ $item->id }}" 
                                    data-quantity="{{ $item->quantity }}" 
                                    data-unit="{{ $item->unit }}"
                                    data-completed="{{ $item->progress()->where('status', 'approved')->sum('actual_quantity') }}">
                                {{ $item->item_name }} ({{ $item->unit }})
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="alert alert-info" id="progressInfo" style="display: none;">
                        <strong>{{ __('معلومات البند') }}:</strong><br>
                        <span id="plannedQty"></span><br>
                        <span id="completedQty"></span><br>
                        <span id="remainingQty"></span>
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label">{{ __('التاريخ') }} <span class="text-danger">*</span></label>
                        <input type="date" name="date" class="form-control" value="{{ date('Y-m-d') }}" required>
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label">{{ __('الكمية المنجزة') }} <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="number" step="0.01" name="actual_quantity" class="form-control" required id="actualQty">
                            <span class="input-group-text" id="unitDisplay">-</span>
                        </div>
                        <small class="form-text text-muted">{{ __('أدخل الكمية المنجزة في هذا اليوم') }}</small>
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label">{{ __('ملاحظات') }}</label>
                        <textarea name="notes" class="form-control" rows="3" placeholder="ملاحظات اختيارية عن التقدم"></textarea>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-success btn-lg">
                            <i class="bi bi-check-circle"></i> {{ __('تسجيل التقدم') }}
                        </button>
                        <a href="{{ route('construction.boq.index', $project->id) }}" class="btn btn-secondary">
                            {{ __('رجوع إلى BOQ') }}
                        </a>
                    </div>
                </form>
                @else
                <div class="alert alert-warning">
                    <i class="bi bi-exclamation-triangle"></i>
                    {{ __('يجب إضافة بنود BOQ أولاً قبل تسجيل التقدم') }}
                    <br>
                    <a href="{{ route('construction.boq.index', $project->id) }}" class="btn btn-primary btn-sm mt-2">
                        {{ __('إضافة بنود BOQ') }}
                    </a>
                </div>
                @endif
            </div>
        </div>

        <!-- Recent Progress Entries -->
        @if($project->boqItems->count() > 0)
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="card-title mb-0">{{ __('آخر التقدمات المسجلة') }}</h5>
            </div>
            <div class="card-body">
                @php
                    $recentProgress = \App\Models\ConstructionProgress::whereIn('boq_id', $project->boqItems->pluck('id'))
                        ->orderBy('date', 'desc')
                        ->limit(10)
                        ->get();
                @endphp
                @if($recentProgress->count() > 0)
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>{{ __('التاريخ') }}</th>
                                <th>{{ __('البند') }}</th>
                                <th>{{ __('الكمية') }}</th>
                                <th>{{ __('الحالة') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentProgress as $progress)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($progress->date)->format('Y-m-d') }}</td>
                                <td>{{ $progress->boq->item_name ?? '-' }}</td>
                                <td>{{ number_format($progress->actual_quantity, 2) }} {{ $progress->boq->unit ?? '' }}</td>
                                <td>
                                    @if($progress->status == 'approved')
                                        <span class="badge badge-light-success fs-7 fw-bold">{{ __('معتمد') }}</span>
                                    @else
                                        <span class="badge badge-light-warning fs-7 fw-bold">{{ __('قيد المراجعة') }}</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <p class="text-muted text-center">{{ __('لا توجد تقدمات مسجلة بعد') }}</p>
                @endif
            </div>
        </div>
        @endif
    </div>
</div>
@endsection

@section('scripts')
<script>
document.getElementById('boqSelect').addEventListener('change', function() {
    const selected = this.options[this.selectedIndex];
    const plannedQty = parseFloat(selected.dataset.quantity) || 0;
    const completedQty = parseFloat(selected.dataset.completed) || 0;
    const unit = selected.dataset.unit || '';
    const remaining = plannedQty - completedQty;

    if (this.value) {
        document.getElementById('progressInfo').style.display = 'block';
        document.getElementById('plannedQty').textContent = `الكمية المخططة: ${plannedQty.toFixed(2)} ${unit}`;
        document.getElementById('completedQty').textContent = `الكمية المنجزة: ${completedQty.toFixed(2)} ${unit}`;
        document.getElementById('remainingQty').textContent = `الكمية المتبقية: ${remaining.toFixed(2)} ${unit}`;
        document.getElementById('unitDisplay').textContent = unit;
        
        // Set max value for actual quantity
        document.getElementById('actualQty').max = remaining;
    } else {
        document.getElementById('progressInfo').style.display = 'none';
        document.getElementById('unitDisplay').textContent = '-';
    }
});
</script>
@endsection
