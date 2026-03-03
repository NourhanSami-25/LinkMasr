@extends('layout.app')

@section('title', __('general.create_schedule'))

@section('content')
<div class="post d-flex flex-column-fluid" id="kt_post">
    <div id="kt_content_container" class="container-xxl">
        <!-- Breadcrumb -->
        <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
            <li class="breadcrumb-item text-muted">
                <a href="{{ url('/') }}" class="text-muted text-hover-primary">{{ __('general.Home') }}</a>
            </li>
            <li class="breadcrumb-item"><span class="bullet bg-gray-500 w-5px h-2px"></span></li>
            <li class="breadcrumb-item text-muted">
                <a href="{{ route('schedules.index') }}" class="text-muted text-hover-primary">{{ __('general.schedules') }}</a>
            </li>
            <li class="breadcrumb-item"><span class="bullet bg-gray-500 w-5px h-2px"></span></li>
            <li class="breadcrumb-item text-dark">{{ __('general.create_schedule') }}</li>
        </ul>

        <div class="card mt-5">
            <div class="card-header">
                <h4 class="card-title">{{ __('general.create_schedule') }}</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('schedules.store') }}" method="POST">
                    @csrf
                    
                    <div class="row mb-5">
                        <div class="col-md-6">
                            <label class="form-label required">{{ __('general.project') }}</label>
                            <select name="project_id" id="project_id" class="form-select @error('project_id') is-invalid @enderror" required>
                                <option value="">{{ __('general.select_project') }}</option>
                                @foreach($projects as $proj)
                                    <option value="{{ $proj->id }}" {{ ($project && $project->id == $proj->id) ? 'selected' : '' }}>
                                        {{ $proj->subject }}
                                    </option>
                                @endforeach
                            </select>
                            @error('project_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label required">{{ __('general.schedule_name') }}</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                                   value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-5">
                        <div class="col-md-6">
                            <label class="form-label required">{{ __('general.baseline_start') }}</label>
                            <input type="date" name="baseline_start" class="form-control @error('baseline_start') is-invalid @enderror" 
                                   value="{{ old('baseline_start') }}" required>
                            @error('baseline_start')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label required">{{ __('general.baseline_end') }}</label>
                            <input type="date" name="baseline_end" class="form-control @error('baseline_end') is-invalid @enderror" 
                                   value="{{ old('baseline_end') }}" required>
                            @error('baseline_end')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-5">
                        <div class="col-md-12">
                            <label class="form-label">{{ __('general.notes') }}</label>
                            <textarea name="notes" class="form-control" rows="3">{{ old('notes') }}</textarea>
                        </div>
                    </div>

                    @if($boqItems && $boqItems->count() > 0)
                    <div class="row mb-5">
                        <div class="col-md-12">
                            <div class="form-check">
                                <input type="checkbox" name="import_from_boq" value="1" class="form-check-input" id="import_from_boq">
                                <label class="form-check-label" for="import_from_boq">
                                    {{ __('general.import_from_boq') }} ({{ $boqItems->count() }} {{ __('general.items') }})
                                </label>
                            </div>
                        </div>
                    </div>
                    @endif

                    <div class="d-flex justify-content-end">
                        <a href="{{ route('schedules.index') }}" class="btn btn-light me-3">{{ __('general.cancel') }}</a>
                        <button type="submit" class="btn btn-primary">{{ __('general.save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('project_id').addEventListener('change', function() {
        if (this.value) {
            window.location.href = '{{ route('schedules.create') }}?project_id=' + this.value;
        }
    });
</script>
@endpush
