<div class="tab-pane fade" id="kt_customer_view_proposals" role="tabpanel">

    @hasAccess('proposal','view_global')
    <!--begin::Card-->
    <div class="card pt-4 mb-6 mb-xl-9">
        <!--begin::Card header-->
        <div class="card-header border-0">
            <!--begin::Card title-->
            <div class="card-title">
                <h2>{{ __('general.proposals') }}</h2>
            </div>
            <!--end::Card title-->
            <!--begin::Card toolbar-->
            <div class="d-flex align-items-center gap-2 gap-lg-3">
                @hasAccess('proposal','create')
                <a href="{{route('proposals.create')}}" class="btn btn-flex btn-outline btn-primary h-40px fs-7 fw-bold" target="_blank">{{ __('general.create_new') }}</a>
				@endhasAccess
                @hasAccess('proposal','view')
                <a href="{{route('proposals.index' )}}" class="btn btn-flex btn-outline btn-primary h-40px fs-7 fw-bold" target="_blank">{{ __('general.view_all') }}</a>
                @endhasAccess
            </div>
            <!--end::Card toolbar-->
        </div>
        <!--end::Card header-->
        <!--begin::Card body-->
        <div class="card-body pt-0 pb-5">
            <!--begin::Table-->
            <table class="table align-middle table-row-dashed kt-datatable gy-5"
                id="proposals_table">
                <thead class="border-bottom border-gray-200 fs-7 fw-bold">
                    <tr class="text-muted text-uppercase gs-0">
                        <th class="text-start">{{ __('general.id') }}</th>
                        <th class="text-start">{{ __('general.subject') }}</th>
                        <th class="text-start">{{ __('general.number') }}</th>
                        <th class="text-start">{{ __('general.status') }}</th>
                        <th class="text-start">{{ __('general.date') }}</th>
                        <th class="text-start">{{ __('general.total') }}</th>
                        <th class="text-start">{{ __('general.currency') }}</th>
                        <th class="text-end min-w-100px pe-4">{{ __('general.actions') }}</th>
                    </tr>
                </thead>
                <tbody class="fs-6 fw-semibold text-gray-800">
                    @foreach($proposals as $proposal)
                    <tr>
                        <td class="text-start">{{$proposal->id}}</td>
                        <td class="text-start">{{$proposal->subject}}</td>
                        <td class="text-start">{{$proposal->number}}</td>
                        <td class="text-start">{{ __('general.' . $proposal->status) }}</td>
                        <td class="text-start">{{date('Y-m-d', strtotime($proposal->date))}}</td>
                        <td class="text-start">{{$proposal->total}}</td>
                        <td class="text-start">{{$proposal->currency}}</td>
                        <td class="pe-0 text-end">
                            <a href="#"
                                class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary"
                                data-kt-menu-trigger="click"
                                data-kt-menu-placement="bottom-end">{{ __('general.actions') }}
                                <i class="ki-outline ki-down fs-5 ms-1"></i></a>
                            <!--begin::Menu-->
                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4"
                                data-kt-menu="true">
                                @hasAccess('proposal','details')
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="{{route('proposals.show', $proposal->id)}}"
                                        class="menu-link px-3">{{ __('general.view') }}</a>
                                </div>
                                <!--end::Menu item-->
                                @endhasAccess
                                @hasAccess('proposal','modify')
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="{{route('proposals.edit', $proposal->id)}}"
                                        class="menu-link px-3">{{ __('general.edit') }}</a>
                                </div>
                                <!--end::Menu item-->
                                @endhasAccess
                                @hasAccess('proposal','delete')
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <form id="delete-form-{{ $proposal->id }}" action="{{ route('proposals.destroy', $proposal->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <div class="menu-item">
                                            <button type="button" onclick="showConfirmation('{{ addslashes($proposal->subject) }}', '{{ $proposal->id }}');" class="dropdown-item menu-link fw-bold text-danger">{{ __('general.delete') }}</button>
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
    @endhasAccess

</div>
