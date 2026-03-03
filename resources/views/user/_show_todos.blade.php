<div class="tab-pane fade" id="kt_customer_view_todos" role="tabpanel">

    <!--begin::Card-->
    <div class="card pt-4 mb-6 mb-xl-9">
        <!--begin::Card header-->
        <div class="card-header border-0">
            <!--begin::Card title-->
            <div class="card-title">
                <h2>{{ __('general.todos') }}</h2>
            </div>
            <!--end::Card title-->
            <!--begin::Card toolbar-->
            <div class="d-flex align-items-center gap-2 gap-lg-3">
                <a href="{{route('todos.create')}}" class="btn btn-flex btn-primary h-40px fs-7 fw-bold" target="_blank">{{ __('general.create_new') }}</a>
				<a href="{{route('todos.index' )}}" class="btn btn-flex btn-primary h-40px fs-7 fw-bold" target="_blank">{{ __('general.view_all') }}</a>
			</div>
            <!--end::Card toolbar-->
        </div>
        <!--end::Card header-->
        <!--begin::Card body-->
        <div class="card-body pt-0 pb-5">
            <!--begin::Table-->
            <table class="table align-middle table-row-dashed kt-datatable gy-5"
                id="kt_table_customers_payment">
                <thead class="border-bottom border-gray-200 fs-7 fw-bold">
                    <tr class="text-muted text-uppercase gs-0">
                        <th class="text-start">{{ __('general.id') }}</th>
                        <th class="text-start">{{ __('general.subject') }}</th>
                        <th class="text-start">{{ __('general.description') }}</th>
                        <th class="text-start">{{ __('general.status') }}</th>
                        <th class="text-start">{{ __('general.created_at') }}</th>
                        <th class="text-start">{{ __('general.priority') }}</th>
                        <th class="text-end min-w-100px pe-4">{{ __('general.actions') }}</th>
                    </tr>
                </thead>
                <tbody class="fs-6 fw-semibold text-gray-800">
                    @foreach($todos as $todo)
                    <tr>
                        <td class="text-start">{{$todo->id}}</td>
                        <td class="text-start">{{$todo->subject}}</td>
                        <td class="text-start">{{$todo->description}}</td>
                        <td class="text-start">
							<div class="badge 
								{{ $todo->status === 'pending' ? 'badge-light-primary' : '' }}
								{{ $todo->status === 'completed' ? 'badge-light-success' : '' }}">
								{{ ucfirst($todo->status) }}
							</div>
						</td>
                        <td class="text-start">{{$todo->created_at}}</td>
                        <td class="text-start">
							<div class="badge 
								{{ $todo->priority === 'normal' ? 'badge-light-primary' : '' }}
								{{ $todo->priority === 'important' ? 'badge-light-warning' : '' }}
								{{ $todo->priority === 'urgent' ? 'badge-light-danger' : '' }}">
								{{ ucfirst($todo->priority) }}
							</div>
						</td>
                        <td class="pe-0 text-end">
                            <a href="#"
                                class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary"
                                data-kt-menu-trigger="click"
                                data-kt-menu-placement="bottom-end">{{ __('general.actions') }}
                                <i class="ki-outline ki-down fs-5 ms-1"></i></a>
                            <!--begin::Menu-->
                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-200px py-4"
                                data-kt-menu="true">
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="{{route('todos.show', $todo->id)}}"
                                        class="menu-link px-3">{{ __('general.view') }}</a>
                                </div>
                                <!--end::Menu item-->
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
