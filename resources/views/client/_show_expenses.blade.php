<div class="tab-pane fade" id="kt_customer_view_expenses" role="tabpanel">

    @hasAccess('expense','view_global')
    <!--begin::Earnings-->
    <div class="card mb-6 mb-xl-9">
        <!--begin::Header-->
        <div class="card-header border-0">
            <div class="card-title">
                <h2>{{ __('general.totals') }}</h2>
            </div>
        </div>
        <!--end::Header-->
        <!--begin::Body-->
        <div class="card-body py-0">
            <div class="fs-5 fw-semibold text-gray-500 mb-4">
                {{ __('general.this_is_total_for_all_client_invoices_for_all_time') }}
            </div>
            <!--begin::Left Section-->
            <div class="d-flex flex-wrap flex-stack mb-5">
                <!--begin::Row-->
                <div class="d-flex flex-wrap">
                    <!--begin::Col-->
                    <div class="border border-dashed border-gray-300 w-200px rounded my-3 p-4 me-6">                    
                        <span class="fs-1 fw-bold text-gray-800 lh-1">
                            <span>{{ number_format($expensesTotals['paid'], 2) }} {{ $companyProfile->currency ?? 'EGP' }}</span>
                            <i class="ki-outline ki-arrow-up fs-1 text-success"></i>                    </span>
                        <span class="fs-6 fw-semibold text-muted d-block lh-1 pt-2">{{ __('general.paid') }}</span>
                    </div>
                    <!--end::Col-->
                    <!--begin::Col-->
                    <div class="border border-dashed border-gray-300 w-200px rounded my-3 p-4 me-6">   
                        <span class="fs-1 fw-bold text-gray-800 lh-1">
                            <span>{{ number_format($expensesTotals['unpaid'], 2) }} {{ $companyProfile->currency ?? 'EGP' }}</span>
                            <i class="ki-outline ki-arrow-down fs-1 text-danger"></i>                    </span>
                        <span class="fs-6 fw-semibold text-muted d-block lh-1 pt-2">{{ __('general.unpaid') }}</span>
                    </div>
                    <!--end::Col-->
                    <!--begin::Col-->
                    <div class="border border-dashed border-gray-300 w-200px rounded my-3 p-4 me-6">   
                        <span class="fs-1 fw-bold text-gray-800 lh-1">
                            <span>{{ number_format($expensesTotals['partially_paid'], 2) }} {{ $companyProfile->currency ?? 'EGP' }}</span>
                            <i class="ki-outline ki-arrow-diagonal fs-1 text-warning"></i>                    </span>
                        <span class="fs-6 fw-semibold text-muted d-block lh-1 pt-2">{{ __('general.partially_paid') }}</span>
                    </div>
                    <!--end::Col-->
                    <!--begin::Col-->
                    <div class="border border-dashed border-gray-300 w-200px rounded my-3 p-4 me-6">
                        <span class="fs-1 fw-bold text-gray-800 lh-1">
                            <span>{{ number_format($expensesTotals['draft'], 2) }} {{ $companyProfile->currency ?? 'EGP' }}</span>
                            <span class="text-primary">--</span>
                        </span>
                        <span class="fs-6 fw-semibold text-muted d-block lh-1 pt-2">{{ __('general.draft') }}</span>
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Row-->
            </div>
            <!--end::Left Section-->
        </div>
        <!--end::Body-->
    </div>
    <!--end::Earnings-->

    <!--begin::Card-->
    <div class="card pt-4 mb-6 mb-xl-9">
        <!--begin::Card header-->
        <div class="card-header border-0">
            <!--begin::Card title-->
            <div class="card-title">
                <h2>{{ __('general.expenses') }}</h2>
            </div>
            <!--end::Card title-->
            <!--begin::Card toolbar-->
            <div class="d-flex align-items-center gap-2 gap-lg-3">
                <a href="{{route('expenses.create', ['client_id' => $client->id])}}" class="btn btn-flex btn-outline btn-primary h-40px fs-7 fw-bold" target="_blank">{{ __('general.create_new') }}</a>
				<a href="{{route('expenses.index' )}}" class="btn btn-flex btn-outline btn-primary h-40px fs-7 fw-bold" target="_blank">{{ __('general.view_all') }}</a>
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
                        <th class="text-start">{{ __('general.number') }}</th>
                        <th class="text-start">{{ __('general.status') }}</th>
                        <th class="text-start">{{ __('general.date') }}</th>
                        <th class="text-start">{{ __('general.total') }}</th>
                        <th class="text-start">{{ __('general.currency') }}</th>
                        <th class="text-end min-w-100px pe-4">{{ __('general.actions') }}</th>
                    </tr>
                </thead>
                <tbody class="fs-6 fw-semibold text-gray-800">
                    @foreach($expenses as $expense)
                    <tr>
                        <td class="text-start">{{$expense->id}}</td>
                        <td class="text-start">{{$expense->number}}</td>
                        <td class="text-start">{{ __('general.' . $expense->status) }}</td>
                        <td class="text-start">{{date('Y-m-d', strtotime($expense->date))}}</td>
                        <td class="text-start">{{$expense->total}}</td>
                        <td class="text-start">{{$expense->currency}}</td>
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
                                    <a href="{{route('expenses.show', $expense->id)}}"
                                        class="menu-link px-3">{{ __('general.view') }}</a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="{{route('expenses.edit', $expense->id)}}"
                                        class="menu-link px-3">{{ __('general.edit') }}</a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <form id="delete-form-{{ $expense->id }}" action="{{ route('expenses.destroy', $expense->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <div class="menu-item">
                                            <button type="button" onclick="showConfirmation('{{ addslashes($expense->number) }}', '{{ $expense->id }}');" class="dropdown-item menu-link fw-bold text-danger">{{ __('general.delete') }}</button>
                                        </div>
                                    </form>
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
    @endhasAccess

</div>
