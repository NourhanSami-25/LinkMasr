@extends('layout.app')

@section('title', __('general.schedules') ?? 'مخططات التنفيذ')

@section('breadcrumb')
    <li class="breadcrumb-item text-muted">{{ __('general.schedules') ?? 'مخططات التنفيذ' }}</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="card-title mb-0">{{ __('general.project_schedules') ?? 'مخططات تنفيذ المشاريع' }}</h4>
            <a href="{{ route('schedules.create') }}" class="btn btn-primary btn-sm">
                <i class="fa fa-plus"></i> {{ __('general.new_schedule') ?? 'مخطط جديد' }}
            </a>
        </div>
        <div class="card-body">
            <!-- Filters -->
            <form method="GET" class="row mb-4">
                <div class="col-md-4">
                    <select name="project_id" class="form-select" onchange="this.form.submit()">
                        <option value="">{{ __('general.all_projects') ?? 'كل المشاريع' }}</option>
                        @foreach($projects as $project)
                        <option value="{{ $project->id }}" {{ request('project_id') == $project->id ? 'selected' : '' }}>
                            {{ $project->subject }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </form>

            @if($schedules->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover table-striped align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>{{ __('general.name') ?? 'الاسم' }}</th>
                            <th>{{ __('general.project') ?? 'المشروع' }}</th>
                            <th>{{ __('general.start_date') ?? 'تاريخ البدء' }}</th>
                            <th>{{ __('general.end_date') ?? 'تاريخ الانتهاء' }}</th>
                            <th>{{ __('general.tasks') ?? 'المهام' }}</th>
                            <th>{{ __('general.progress') ?? 'التقدم' }}</th>
                            <th>{{ __('general.actions') ?? 'الإجراءات' }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($schedules as $schedule)
                        <tr>
                            <td>
                                <a href="{{ route('schedules.show', $schedule->id) }}" class="text-dark fw-bold">
                                    {{ $schedule->name }}
                                </a>
                                <br><small class="text-muted">v{{ $schedule->version }}</small>
                            </td>
                            <td>{{ $schedule->project->subject }}</td>
                            <td>{{ $schedule->baseline_start->format('Y-m-d') }}</td>
                            <td>{{ $schedule->baseline_end->format('Y-m-d') }}</td>
                            <td><span class="badge badge-light-info fs-7 fw-bold">{{ $schedule->tasks->count() }}</span></td>
                            <td>
                                <div class="progress" style="height: 20px; width: 100px;">
                                    <div class="progress-bar bg-success" style="width: {{ $schedule->overall_progress }}%">
                                        {{ $schedule->overall_progress }}%
                                    </div>
                                </div>
                            </td>
                            <td>
                                <a href="{{ route('schedules.show', $schedule->id) }}" class="btn btn-sm btn-light-primary">
                                    <i class="fa fa-chart-gantt"></i> {{ __('general.gantt') ?? 'Gantt' }}
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            {{ $schedules->links() }}
            @else
            <div class="alert alert-info text-center">
                <i class="fa fa-info-circle fs-1 mb-3 d-block"></i>
                {{ __('general.no_schedules') ?? 'لا توجد مخططات' }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
