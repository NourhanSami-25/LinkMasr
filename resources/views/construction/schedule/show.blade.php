@extends('layout.app')

@section('title', $schedule->name)

@section('breadcrumb')
    <li class="breadcrumb-item text-muted">
        <a href="{{ route('schedules.index') }}"
            class="text-muted text-hover-primary">{{ __('general.schedules') ?? 'المخططات' }}</a>
    </li>
    <li class="breadcrumb-item text-muted">{{ $schedule->name }}</li>
@endsection

@section('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/frappe-gantt@0.6.1/dist/frappe-gantt.min.css">
    <style>
        .gantt-container {
            overflow-x: auto;
            background: #fff;
            border-radius: 8px;
            border: 1px solid #ebedf3;
        }

        .gantt .bar-label {
            font-size: 12px;
            font-weight: 500;
        }

        .bar-primary .bar {
            fill: #009EF7;
        }

        .bar-success .bar {
            fill: #50CD89;
        }

        .bar-warning .bar {
            fill: #FFC700;
        }

        .bar-danger .bar {
            fill: #F1416C;
        }

        .bar-info .bar {
            fill: #7239EA;
        }

        /* Make the gantt chart more visible */
        .gantt-target {
            padding: 20px 0;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid">
        <!-- Schedule Header -->
        <div class="card mb-5">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h3 class="mb-2">{{ $schedule->name }} <small class="text-muted">(v{{ $schedule->version }})</small>
                        </h3>
                        <div class="d-flex gap-4 text-muted flex-wrap">
                            <span><strong>{{ __('general.project') ?? 'المشروع' }}:</strong>
                                {{ $schedule->project->subject ?? 'N/A' }}</span>
                            <span><strong>{{ __('general.period') ?? 'الفترة' }}:</strong>
                                {{ $schedule->baseline_start->format('Y-m-d') }} -
                                {{ $schedule->baseline_end->format('Y-m-d') }}</span>
                            <span><strong>{{ __('general.progress') ?? 'التقدم' }}:</strong>
                                {{ $schedule->overall_progress }}%</span>
                        </div>
                    </div>
                    <div class="col-md-4 text-end">
                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                            data-bs-target="#addTaskModal">
                            <i class="fa fa-plus"></i> {{ __('general.add_task') ?? 'إضافة مهمة' }}
                        </button>
                        <div class="btn-group btn-sm ms-2">
                            <button class="btn btn-light btn-active-primary"
                                onclick="changeViewMode('Day', this)">{{ __('general.day') ?? 'يوم' }}</button>
                            <button class="btn btn-primary"
                                onclick="changeViewMode('Week', this)">{{ __('general.week') ?? 'أسبوع' }}</button>
                            <button class="btn btn-light btn-active-primary"
                                onclick="changeViewMode('Month', this)">{{ __('general.month') ?? 'شهر' }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Gantt Chart -->
        <div class="card mb-5">
            <div class="card-header border-0 pt-5">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold text-dark">{{ __('general.gantt_chart') ?? 'مخطط جانت' }}</span>
                </h3>
            </div>
            <div class="card-body">
                <div class="gantt-container">
                    <div id="gantt" style="min-height: 400px;"></div>
                </div>
            </div>
        </div>

        <!-- Tasks Table -->
        <div class="card">
            <div class="card-header border-0 pt-5">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold text-dark">{{ __('general.tasks_list') ?? 'قائمة المهام' }}</span>
                </h3>
            </div>
            <div class="card-body py-3">
                <div class="table-responsive">
                    <table class="table table-row-bordered table-row-gray-100 align-middle gs-0 gy-3">
                        <thead>
                            <tr class="fw-bold text-muted">
                                <th class="min-w-150px">{{ __('general.task') ?? 'المهمة' }}</th>
                                <th class="min-w-120px">{{ __('general.planned_dates') ?? 'التواريخ المخططة' }}</th>
                                <th class="min-w-120px">{{ __('general.actual_dates') ?? 'التواريخ الفعلية' }}</th>
                                <th class="min-w-100px">{{ __('general.progress') ?? 'التقدم' }}</th>
                                <th class="min-w-100px text-end">{{ __('general.actions') ?? 'الإجراءات' }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($schedule->tasks as $task)
                                <tr>
                                    <td>
                                        <span class="text-dark fw-bold text-hover-primary fs-6">{{ $task->name }}</span>
                                        @if($task->boq)
                                            <span class="text-muted fw-semibold d-block mt-1">BOQ: {{ $task->boq->code }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span
                                            class="badge badge-light-primary">{{ $task->planned_start->format('Y-m-d') }}</span>
                                        <span class="text-muted">/</span>
                                        <span class="badge badge-light-info">{{ $task->planned_end->format('Y-m-d') }}</span>
                                    </td>
                                    <td>
                                        @if($task->actual_start)
                                            <span
                                                class="badge badge-light-success">{{ $task->actual_start->format('Y-m-d') }}</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column w-100 me-2">
                                            <div class="d-flex flex-stack mb-2">
                                                <span class="text-muted me-2 fs-7 fw-bold">{{ $task->actual_progress }}%</span>
                                            </div>
                                            <div class="progress h-6px w-100">
                                                <div class="progress-bar bg-success" role="progressbar"
                                                    style="width: {{ $task->actual_progress }}%"></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-end">
                                        <button onclick="editTask({{ $task }})"
                                            class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1"
                                            data-bs-toggle="modal" data-bs-target="#editTaskModal">
                                            <i class="fa fa-edit"></i>
                                        </button>
                                        <form action="{{ route('schedules.tasks.destroy', $task->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="btn btn-icon btn-bg-light btn-active-color-danger btn-sm"
                                                onclick="return confirm('{{ __('general.confirm_delete') ?? 'هل أنت متأكد؟' }}')">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addTaskModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('schedules.tasks.store', $schedule->id) }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">{{ __('general.add_task') ?? 'إضافة مهمة' }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label required">{{ __('general.task_name') ?? 'اسم المهمة' }}</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label required">{{ __('general.start_date') ?? 'تاريخ البدء' }}</label>
                                <input type="date" name="planned_start" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label required">{{ __('general.end_date') ?? 'تاريخ الانتهاء' }}</label>
                                <input type="date" name="planned_end" class="form-control" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ __('general.boq_item') ?? 'بند BOQ' }}</label>
                            <select name="boq_id" class="form-select">
                                <option value="">{{ __('general.optional') ?? 'اختياري...' }}</option>
                                @foreach($schedule->project->boqItems ?? [] as $boq)
                                    <option value="{{ $boq->id }}">{{ $boq->code }} - {{ $boq->item_description }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light"
                            data-bs-dismiss="modal">{{ __('general.cancel') ?? 'إلغاء' }}</button>
                        <button type="submit" class="btn btn-primary">{{ __('general.add') ?? 'إضافة' }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editTaskModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="editTaskForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title">{{ __('general.edit_task') ?? 'تعديل المهمة' }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label required">{{ __('general.task_name') ?? 'اسم المهمة' }}</label>
                            <input type="text" name="name" id="editTaskName" class="form-control" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label
                                    class="form-label required">{{ __('general.planned_start') ?? 'البدء المخطط' }}</label>
                                <input type="date" name="planned_start" id="editPlannedStart" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label
                                    class="form-label required">{{ __('general.planned_end') ?? 'الانتهاء المخطط' }}</label>
                                <input type="date" name="planned_end" id="editPlannedEnd" class="form-control" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ __('general.progress') ?? 'نسبة التقدم' }} %</label>
                            <input type="number" name="actual_progress" id="editProgress" class="form-control" step="0.01"
                                min="0" max="100">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light"
                            data-bs-dismiss="modal">{{ __('general.cancel') ?? 'إلغاء' }}</button>
                        <button type="submit" class="btn btn-warning">{{ __('general.save') ?? 'حفظ' }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/frappe-gantt@0.6.1/dist/frappe-gantt.min.js"></script>
    <script>
        var ganttInstance = null;

        function initGantt() {
            var tasks = @json($ganttTasks);
            console.log('Gantt tasks:', tasks);

            var container = document.getElementById('gantt');
            if (!container) return;

            if (tasks.length === 0) {
                container.innerHTML = '<div class="text-center p-20"><span class="text-muted">{{ __('general.no_tasks') ?? 'لا توجد مهام لعرضها' }}</span></div>';
                return;
            }

            try {
                ganttInstance = new Gantt('#gantt', tasks, {
                    view_mode: 'Week',
                    date_format: 'YYYY-MM-DD',
                    bar_height: 30,
                    padding: 18,
                    view_modes: ['Day', 'Week', 'Month'],
                    language: 'ar',
                    on_click: function (task) {
                        console.log(task);
                    }
                });
                console.log('Gantt initialized');
            } catch (e) {
                console.error('Gantt error:', e);
                container.innerHTML = '<div class="alert alert-danger">' + e.message + '</div>';
            }
        }

        // Initialize
        if (document.readyState === "loading") {
            document.addEventListener("DOMContentLoaded", initGantt);
        } else {
            initGantt();
        }

        function changeViewMode(mode, btn) {
            if (ganttInstance) {
                ganttInstance.change_view_mode(mode);
                var buttons = btn.parentElement.querySelectorAll('.btn');
                buttons.forEach(function (b) { b.classList.remove('btn-primary'); b.classList.add('btn-light'); });
                btn.classList.remove('btn-light');
                btn.classList.add('btn-primary');
            }
        }

        function editTask(task) {
            // Fix for task object passing from Blade to JS
            var taskId = task.id;
            document.getElementById('editTaskForm').action = '/construction/tasks/' + taskId;
            document.getElementById('editTaskName').value = task.name;
            document.getElementById('editPlannedStart').value = task.planned_start.split('T')[0];
            document.getElementById('editPlannedEnd').value = task.planned_end.split('T')[0];
            document.getElementById('editProgress').value = task.actual_progress;
        }
    </script>
@endsection