<div class="tab-pane fade" id="kt_customer_view_requests" role="tabpanel">

    <!--begin::Card-->
    <div class="card pt-4 mb-6 mb-xl-9">
        <!--begin::Card header-->
        <div class="card-header border-0">
            <!--begin::Card title-->
            <div class="card-title">
                <h2>{{ __('general.my_requests') }}</h2>
            </div>
            <!--end::Card title-->
            <!--begin::Card toolbar-->
            {{-- <div class="d-flex align-items-center gap-2 gap-lg-3">
                <a href="{{route('requests.create')}}" class="btn btn-flex btn-primary h-40px fs-7 fw-bold" target="_blank">{{ __('general.create_new') }}</a>
				<a href="{{route('requests.index' )}}" class="btn btn-flex btn-primary h-40px fs-7 fw-bold" target="_blank">{{ __('general.view_all') }}</a>
			</div> --}}
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
                        <th class="text-start">{{ __('general.type') }}</th>
                        <th class="text-start">{{ __('general.subject') }}</th>
                        <th class="text-start">{{ __('general.status') }}</th>
                        <th class="text-start">{{ __('general.start_date') }}</th>
                        <th class="text-start">{{ __('general.due_date') }}</th>
                        <th class="text-start">{{ __('general.created_by') }}</th>
                        <th class="text-end min-w-100px pe-4">{{ __('general.actions') }}</th>
                    </tr>
                </thead>
                <tbody class="fs-6 fw-semibold text-gray-800">
                    @foreach($requests as $request)
                    @include('request.all._show_popup', ['request' => $request, 'modalId' => "kt_modal_new_target_request_show_{$request->id}"])
                    <tr>
                        <td class="text-start">{{$request->id}}</td>
                        <td class="text-start">{{$request->type}}</td>
                        <td class="text-start"><a href="#" class="mb-1" data-bs-toggle="modal" data-bs-target="#kt_modal_new_target_request_show_{{ $request->id }}">{{ \Illuminate\Support\Str::limit($request->subject, 30) }}</a></td>
                        <td class="text-start">
                            <div class="badge 
								{{ $request->status === 'approved' ? 'badge-light-success' : '' }}
								{{ $request->status === 'rejected' ? 'badge-light-danger' : '' }}
								{{ $request->status === 'pending' ? 'badge-light-primary' : '' }}
								{{ $request->status === 'canceled' ? 'badge-light-warning' : '' }}">
								{{ ucfirst($request->status) }}
							</div>
                        </td>
                        <td class="text-start">{{$request->date}}</td>
                        <td class="text-start">{{$request->due_date}}</td>
                        <td class="text-start">{{__getUserNameById($request->user_id)}}</td>
                        <td class="pe-0 text-end">
                            <a href="#"
                                class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary"
                                data-kt-menu-trigger="click"
                                data-kt-menu-placement="bottom-end">{{ __('general.actions') }}
                                <i class="ki-outline ki-down fs-5 ms-1"></i></a>
                            <!--begin::Menu-->
                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-200px py-4"
                                data-kt-menu="true">
                                @hasAccess('request','details')
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="{{ route($request->type . '-requests.show', $request->id) }}"
                                        class="menu-link px-3">{{ __('general.view') }}</a>
                                </div>
                                <!--end::Menu item-->
                                @endhasAccess
                                @hasAccess('request','modify')
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="{{ route($request->type . '-requests.edit', $request->id) }}"
                                        class="menu-link px-3">{{ __('general.edit') }}</a>
                                </div>
                                <!--end::Menu item-->		
								<!--begin::Menu item-->
								<div class="menu-item px-2">
									<form action="{{ route('requests.cancel', ['type' => $request->type, 'id' => $request->id]) }}" method="POST">
    								    @csrf
										<div class="menu-item">
    								    	<button type="submit" class="dropdown-item menu-link fw-bold">{{ __('general.cancel') }}</button>
										</div>
    								</form>
								</div>
								<!--end::Menu item-->
                                @endhasAccess
                                @hasAccess('request','delete')	
                                <!--begin::Menu item-->
							    <div class="menu-item px-3">
							        <form id="delete-form-{{ $request->id }}" action="{{ route($request->type . '-requests.destroy', $request->id) }}" method="POST">
							            @csrf
							            @method('DELETE')
							            <div class="menu-item">
							                <button type="button" onclick="showConfirmation('{{ addslashes($request->subject) }}', '{{ $request->id }}');" 
							                    class="dropdown-item menu-link fw-bold text-danger">
							                    {{ __('general.delete') }}
							                </button>
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
