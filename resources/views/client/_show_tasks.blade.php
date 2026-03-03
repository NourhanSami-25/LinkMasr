<div class="tab-pane fade" id="kt_customer_view_tasks" role="tabpanel">

    <!--begin::Card-->
    <div class="card pt-4 mb-6 mb-xl-9">
        <!--begin::Card header-->
        <div class="card-header border-0">
            <!--begin::Card title-->
            <div class="card-title">
                <h2>{{ __('general.tasks') }}</h2>
            </div>
            <!--end::Card title-->
            <!--begin::Card toolbar-->
            <div class="d-flex align-items-center gap-2 gap-lg-3">
                @hasAccess('task','create')
                <a href="{{ route('tasks.create', isset($client) ? ['client_id' => $client->id] : []) }}"
                   class="btn btn-flex btn-primary h-40px fs-7 fw-bold">
                    {{ __('general.create_new') }}
                </a>
				@endhasAccess
                @hasAccess('task','view')
                <a href="{{route('tasks.index' )}}" class="btn btn-flex btn-primary h-40px fs-7 fw-bold" target="_blank">{{ __('general.view_all') }}</a>
                @endhasAccess
            </div>
            <!--end::Card toolbar-->
        </div>
        <!--end::Card header-->
        <!--begin::Card body-->
        <div class="card-body pt-0 pb-5">
            <!--begin::Table-->
            <table class="table align-middle table-row-dashed kt-datatable gy-5"
                id="tasks_table">
                <thead class="border-bottom border-gray-200 fs-7 fw-bold">
                    <tr class="text-muted text-uppercase gs-0">
                        <th class="text-start">{{ __('general.id') }}</th>
                        <th class="text-start">{{ __('general.subject') }}</th>
                        <th class="text-start">{{ __('general.status') }}</th>
                        <th class="text-start">{{ __('general.start_date') }}</th>
                        <th class="text-start">{{ __('general.due_date') }}</th>
                        <th class="text-end min-w-100px pe-4">{{ __('general.actions') }}</th>
                    </tr>
                </thead>
                <tbody class="fs-6 fw-semibold text-gray-800">
                    @foreach($tasks as $task)
                    <tr>
                        <td class="text-start">{{$task->id}}</td>
                        <td class="text-start">
							@hasAccess('task','details')
							<a href="{{route('tasks.show' , $task->id)}}" class="text-primary-900 text-hover-primary">
							@endhasAccess('task','details')
								{{$task->subject}}</a>
						</td>
                        <td class="text-start">{{ __('general.' . $task->status) }}</td>
                        <td class="text-start">{{date('Y-m-d', strtotime($task->date))}}</td>
                        <td class="text-start">{{date('Y-m-d', strtotime($task->due_date))}}</td>
                        <td class="pe-0 text-end">
                            <a href="#"
                                class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary"
                                data-kt-menu-trigger="click"
                                data-kt-menu-placement="bottom-end">{{ __('general.actions') }}
                                <i class="ki-outline ki-down fs-5 ms-1"></i></a>
                            <!--begin::Menu-->
                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4"
                                data-kt-menu="true">
                                @hasAccess('task','details')
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="{{route('tasks.show', $task->id)}}"
                                        class="menu-link px-3">{{ __('general.view') }}</a>
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
