@extends('layout.app')

@section('title')
    {{ __('إدارة الوحدات') }} - {{ $project->subject }}
@endsection

@section('content')
<div class="row mb-4">
    <!-- Summary Cards -->
    <div class="col-md-3">
        <div class="card bg-success text-white">
            <div class="card-body text-center">
                <h6>{{ __('متاح') }}</h6>
                <h2>{{ $units->where('status', 'available')->count() }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-warning text-white">
            <div class="card-body text-center">
                <h6>{{ __('محجوز') }}</h6>
                <h2>{{ $units->where('status', 'reserved')->count() }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-danger text-white">
            <div class="card-body text-center">
                <h6>{{ __('مباع') }}</h6>
                <h2>{{ $units->where('status', 'sold')->count() }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-primary text-white">
            <div class="card-body text-center">
                <h6>{{ __('الإجمالي') }}</h6>
                <h2>{{ $units->count() }}</h2>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-0">{{ __('قائمة الوحدات') }}</h4>
                <div>
                    <button type="button" class="btn btn-sm btn-success" onclick="filterUnits('available')">
                        {{ __('متاح') }}
                    </button>
                    <button type="button" class="btn btn-sm btn-warning" onclick="filterUnits('reserved')">
                        {{ __('محجوز') }}
                    </button>
                    <button type="button" class="btn btn-sm btn-danger" onclick="filterUnits('sold')">
                        {{ __('مباع') }}
                    </button>
                    <button type="button" class="btn btn-sm btn-secondary" onclick="filterUnits('all')">
                        {{ __('الكل') }}
                    </button>
                </div>
            </div>
            <div class="card-body">
                @if($units->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle" id="unitsTable">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>{{ __('اسم الوحدة') }}</th>
                                <th>{{ __('المساحة') }}</th>
                                <th>{{ __('السعر') }}</th>
                                <th>{{ __('الحالة') }}</th>
                                <th>{{ __('الإجراءات') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($units as $index => $unit)
                            <tr data-status="{{ $unit->status }}">
                                <td>{{ $index + 1 }}</td>
                                <td><strong>{{ $unit->name }}</strong></td>
                                <td>{{ number_format($unit->area, 0) }} {{ __('م²') }}</td>
                                <td class="fw-bold">{{ number_format($unit->price, 0) }} {{ __('جنيه') }}</td>
                                <td>
                                    @if($unit->status == 'available')
                                        <span class="badge badge-light-success fs-7 fw-bold">{{ __('متاح') }}</span>
                                    @elseif($unit->status == 'reserved')
                                        <span class="badge badge-light-warning fs-7 fw-bold">{{ __('محجوز') }}</span>
                                    @elseif($unit->status == 'sold')
                                        <span class="badge badge-light-danger fs-7 fw-bold">{{ __('مباع') }}</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        @if($unit->status == 'available')
                                            <button class="btn btn-sm btn-warning" onclick="updateStatus({{ $unit->id }}, 'reserved')">
                                                <i class="bi bi-bookmark"></i> {{ __('حجز') }}
                                            </button>
                                            <button class="btn btn-sm btn-danger" onclick="updateStatus({{ $unit->id }}, 'sold')">
                                                <i class="bi bi-check-circle"></i> {{ __('بيع') }}
                                            </button>
                                        @elseif($unit->status == 'reserved')
                                            <button class="btn btn-sm btn-danger" onclick="updateStatus({{ $unit->id }}, 'sold')">
                                                <i class="bi bi-check-circle"></i> {{ __('بيع') }}
                                            </button>
                                            <button class="btn btn-sm btn-secondary" onclick="updateStatus({{ $unit->id }}, 'available')">
                                                <i class="bi bi-x-circle"></i> {{ __('إلغاء الحجز') }}
                                            </button>
                                        @elseif($unit->status == 'sold')
                                            <button class="btn btn-sm btn-secondary" onclick="updateStatus({{ $unit->id }}, 'available')">
                                                <i class="bi bi-arrow-counterclockwise"></i> {{ __('إلغاء البيع') }}
                                            </button>
                                        @endif
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
                    <p class="mt-2">{{ __('لا توجد وحدات في هذا المشروع بعد') }}</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function updateStatus(unitId, newStatus) {
    if (!confirm('{{ __("هل أنت متأكد من تغيير حالة الوحدة؟") }}')) {
        return;
    }
    
    fetch(`/real_estate/units/${unitId}/status`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ status: newStatus })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('{{ __("حدث خطأ") }}');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('{{ __("حدث خطأ") }}');
    });
}

function filterUnits(status) {
    const rows = document.querySelectorAll('#unitsTable tbody tr');
    rows.forEach(row => {
        if (status === 'all' || row.dataset.status === status) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}
</script>
@endsection
