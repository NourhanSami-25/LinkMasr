<div class="tab-pane fade"
id="kt_project_view_tasks" role="tabpanel">

<!--begin::Card-->
<div class="card pt-4 mb-6 mb-xl-9">
    <!--begin::Card header-->
    <div class="card-header border-0">
        <!--begin::Card title-->
        <div class="card-title">
            <h2>{{ __('general.project_tasks') }}</h2>
        </div>
        <!--end::Card title-->

        
        <!--begin::Card toolbar-->
        <div class="card-toolbar">
            @hasAccess('task', 'create')
            <div class="d-flex align-items-center gap-2 gap-lg-3">
                <a href="{{ route('tasks.create', isset($project) ? ['project_id' => $project->id] : []) }}"
                   class="btn btn-primary er fs-6 px-8 py-4">
                    {{ __('general.create_task') }}
                </a>
            </div>
            @endhasAccess

        </div>
        <!--end::Card toolbar-->
        
    </div>
    <!--end::Card header-->
    <!--begin::Card body-->
    <div class="card-body pt-0 pb-5">
        <!--begin::Table-->
        <table class="table align-middle table-row-dashed kt-datatable gy-3"
            id="tasks_table">
            <thead class="border-bottom border-gray-200 fs-7 fw-bold">
                <tr class="text-gray-900 text-uppercase gs-0">
                    <th class="text-start min-w-50px">#</th>
				    <th class="text-start min-w-100px">{{ __('general.subject') }}</th>
				    <th class="text-start min-w-100px">{{ __('general.related_to') }}</th>
				    <th class="text-start min-w-100px">{{ __('general.status') }}</th>
				    <th class="text-start min-w-100px">{{ __('general.start_date') }}</th>
				    <th class="text-start min-w-100px">{{ __('general.due_date') }}</th>
				    <th class="text-start min-w-100px">{{ __('general.created_at') }}</th>
				    <th class="text-start min-w-100px">{{ __('general.created_by') }}</th>
				    <th class="text-end min-w-100px">{{ __('general.actions') }}</th>
                </tr>
            </thead>
            <tbody class="fs-6 fw-semibold text-gray-800">
                @foreach($tasks as $task)
                <tr>
                    <td class="text-start">{{$task->id}}</td>
					<td class="text-start">
                        @hasAccess('task', 'details')
                        <a href="{{route('tasks.show' , $task->id)}}" class="text-primary-900 text-hover-primary">
                        @endhasAccess
                            {{$task->subject}}</a></td>
					<td class="text-start">{{$task->related}}</td>
					<td class="text-start">
						<div class="badge 
							{{ $task->status === 'in_progress' ? 'badge-light-primary' : '' }}
							{{ $task->status === 'on_hold' ? 'badge-light-warning' : '' }}
							{{ $task->status === 'not_started' ? 'badge-light-info' : '' }}
							{{ $task->status === 'completed' ? 'badge-light-success' : '' }}">
							{{ __('general.' . $task->status) }}
						</div>
					</td>
					<td class="text-start">{{date('Y-m-d', strtotime($task->start_date))}}</td>
					<td class="text-start">{{date('Y-m-d', strtotime($task->due_date))}}</td>
					<td class="text-start">{{date('Y-m-d', strtotime($task->created_at))}}</td>
					<td class="text-start">{{__getUserNameById($task->created_by)}}</td>
                    <td class="pe-0 text-end">
                        <a href="#"
                            class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary"
                            data-kt-menu-trigger="click"
                            data-kt-menu-placement="bottom-end">{{ __('general.actions') }}
                            <i class="ki-outline ki-down fs-5 ms-1"></i></a>
                        <!--begin::Menu-->
                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4"
                            data-kt-menu="true">
                            <!--begin::Menu item-->
                            <div class="menu-item px-3">
                                <a href="{{route('tasks.show' , $task->id)}}" class="menu-link px-3">{{ __('general.view') }}</a>
                            </div>
                            <!--end::Menu item-->
                            @hasAccess('task', 'modify')
                            <!--begin::Menu item-->
                            <div class="menu-item px-3">
                                <a href="{{route('tasks.edit' , $task->id)}}" class="menu-link px-3">{{ __('general.edit') }}</a>
                            </div>
                            <!--end::Menu item-->
                            @endhasAccess
                            @hasAccess('task', 'delete')
                            <!--begin::Menu item-->
                            <div class="menu-item px-3">
                                <form id="delete-form-{{ $task->id }}" action="{{ route('tasks.destroy', $task->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <div class="menu-item">
                                        <button type="button" onclick="showConfirmation('{{ addslashes($task->subject) }}', '{{ $task->id }}');" class="dropdown-item menu-link fw-bold text-danger">{{ __('general.delete') }}</button>
                                    </div>
                                </form>
                            </div>
                            <!--end::Menu item-->
                             @endhasAccess
                        </div>
                        <!--end::Menu-->
                    </td>
                </tr>
                @endforeach
            </tbody>
            <!--end::Table body-->
        </table>
        <!--end::Table-->
    </div>
    <!--end::Card body-->
</div>
<!--end::Card-->

</div>

@include('reminder.create',['item' => $project] )
