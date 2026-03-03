@extends('layout.app')

@section('title', __('general.subcontracts') ?? 'عقود مقاولي الباطن')

@section('breadcrumb')
    <li class="breadcrumb-item text-muted">{{ __('general.subcontracts') ?? 'عقود مقاولي الباطن' }}</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="card-title mb-0">{{ __('general.subcontracts') ?? 'عقود مقاولي الباطن' }}</h4>
            <a href="{{ route('subcontracts.create') }}" class="btn btn-primary btn-sm">
                <i class="fa fa-plus"></i> {{ __('general.new_subcontract') ?? 'عقد جديد' }}
            </a>
        </div>
        <div class="card-body">
            <!-- Filters -->
            <form method="GET" class="row mb-4">
                <div class="col-md-3">
                    <select name="project_id" class="form-select" onchange="this.form.submit()">
                        <option value="">{{ __('general.all_projects') ?? 'كل المشاريع' }}</option>
                        @foreach($projects as $project)
                        <option value="{{ $project->id }}" {{ request('project_id') == $project->id ? 'selected' : '' }}>
                            {{ $project->subject }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="status" class="form-select" onchange="this.form.submit()">
                        <option value="">{{ __('general.all_statuses') ?? 'كل الحالات' }}</option>
                        <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>{{ __('general.draft') ?? 'مسودة' }}</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>{{ __('general.active') ?? 'نشط' }}</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>{{ __('general.completed') ?? 'مكتمل' }}</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="vendor_id" class="form-select" onchange="this.form.submit()">
                        <option value="">{{ __('general.all_vendors') ?? 'كل المقاولين' }}</option>
                        @foreach($vendors as $vendor)
                        <option value="{{ $vendor->id }}" {{ request('vendor_id') == $vendor->id ? 'selected' : '' }}>
                            {{ $vendor->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </form>

            @if($subcontracts->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover table-striped align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>{{ __('general.contract_no') ?? 'رقم العقد' }}</th>
                            <th>{{ __('general.title') ?? 'العنوان' }}</th>
                            <th>{{ __('general.project') ?? 'المشروع' }}</th>
                            <th>{{ __('general.vendor') ?? 'المقاول' }}</th>
                            <th>{{ __('general.value') ?? 'القيمة' }}</th>
                            <th>{{ __('general.execution') ?? 'التنفيذ' }}</th>
                            <th>{{ __('general.status') ?? 'الحالة' }}</th>
                            <th>{{ __('general.actions') ?? 'الإجراءات' }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($subcontracts as $contract)
                        <tr>
                            <td><code>{{ $contract->contract_no }}</code></td>
                            <td>
                                <a href="{{ route('subcontracts.show', $contract->id) }}" class="text-dark fw-bold">
                                    {{ $contract->title }}
                                </a>
                            </td>
                            <td>{{ $contract->project->subject }}</td>
                            <td>{{ $contract->vendor->name }}</td>
                            <td class="fw-bold">{{ number_format($contract->contract_value, 2) }}</td>
                            <td>
                                <div class="progress" style="height: 20px;">
                                    <div class="progress-bar bg-success" style="width: {{ $contract->execution_percentage }}%">
                                        {{ $contract->execution_percentage }}%
                                    </div>
                                </div>
                            </td>
                            <td>
                                @switch($contract->status)
                                    @case('draft')
                                        <span class="badge badge-light-secondary fs-7 fw-bold">{{ __('general.draft') ?? 'مسودة' }}</span>
                                        @break
                                    @case('active')
                                        <span class="badge badge-light-success fs-7 fw-bold">{{ __('general.active') ?? 'نشط' }}</span>
                                        @break
                                    @case('completed')
                                        <span class="badge badge-light-primary fs-7 fw-bold">{{ __('general.completed') ?? 'مكتمل' }}</span>
                                        @break
                                    @case('suspended')
                                        <span class="badge badge-light-warning fs-7 fw-bold">{{ __('general.suspended') ?? 'موقوف' }}</span>
                                        @break
                                    @default
                                        <span class="badge badge-light-dark fs-7 fw-bold">{{ $contract->status }}</span>
                                @endswitch
                            </td>
                            <td>
                                <a href="{{ route('subcontracts.show', $contract->id) }}" class="btn btn-sm btn-light-info">
                                    <i class="fa fa-eye"></i>
                                </a>
                                @if($contract->status == 'draft')
                                <a href="{{ route('subcontracts.edit', $contract->id) }}" class="btn btn-sm btn-light-warning">
                                    <i class="fa fa-edit"></i>
                                </a>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            {{ $subcontracts->links() }}
            @else
            <div class="alert alert-info text-center">
                <i class="fa fa-info-circle fs-1 mb-3 d-block"></i>
                {{ __('general.no_subcontracts') ?? 'لا توجد عقود حتى الآن' }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
