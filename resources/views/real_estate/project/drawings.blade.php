@extends('layout.app')

@section('title')
    {{ __('Engineering Drawings') }} - {{ $project->subject }}
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title">{{ __('Project Drawings & Units') }}</h4>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#uploadDrawingModal">
                    {{ __('Upload Drawing') }}
                </button>
            </div>
            <div class="card-body">
                <div class="row">
                    @foreach($project->drawings as $drawing)
                        <div class="col-md-3 mb-4">
                            <div class="card h-100 shadow-sm">
                                <!-- Mock Image Placeholder -->
                                <div class="bg-light d-flex align-items-center justify-content-center" style="height: 150px;">
                                    <span class="text-muted">{{ $drawing->type }}</span>
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title">{{ $drawing->title }}</h5>
                                    <p class="card-text text-muted small">{{ basename($drawing->file_path) }}</p>
                                    
                                    @if($drawing->units->count() > 0)
                                        <div class="mt-2">
                                            <span class="badge badge-light-info fs-7 fw-bold">{{ $drawing->units->count() }} Linked Units</span>
                                        </div>
                                    @endif
                                </div>
                                <div class="card-footer bg-white border-top-0">
                                    <a href="{{ route('projects.drawings.show', ['project' => $project->id, 'drawing' => $drawing->id]) }}" class="btn btn-sm btn-outline-secondary w-100">{{ __('View Interactive Map') }}</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Upload Drawing Modal -->
<div class="modal fade" id="uploadDrawingModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('projects.drawings.store', $project->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Upload New Drawing') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label>{{ __('Title') }}</label>
                        <input type="text" name="title" class="form-control" required>
                    </div>
                    <div class="form-group mb-3">
                        <label>{{ __('Type') }}</label>
                        <select name="type" class="form-control">
                            <option value="master_plan">Master Plan</option>
                            <option value="floor_plan">Floor Plan</option>
                            <option value="unit_plan">Unit Plan</option>
                            <option value="3d_view">3D View</option>
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label>{{ __('File') }}</label>
                        <input type="file" name="file" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">{{ __('Upload') }}</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Close') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
