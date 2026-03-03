@extends('layout.app')

@section('title')
    {{ __('general.' . $model) }} #{{ $financeModel->number }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item">
        <span class="bullet bg-gray-500 w-5px h-2px"></span>
    </li>
    <li class="breadcrumb-item text-muted">
        <a href="{{ route($model . 's.index') }}" class="text-muted text-hover-primary">{{ __('general.' . $model . 's') }}</a>
    </li>
    <li class="breadcrumb-item">
        <span class="bullet bg-gray-500 w-5px h-2px"></span>
    </li>
    <li class="breadcrumb-item text-muted">{{ $financeModel->number }}</li>
@endsection

@section('actions')
    <div class="d-flex align-items-center gap-2 gap-lg-3">
        @hasAccess($model, 'modify')
        <a href="{{ route($model . 's.edit', $financeModel->id) }}"
            class="btn btn-sm fw-bold btn-primary">{{ __('general.edit') }}</a>
        @endhasAccess
        <a href="{{ route($model . '_show_pdf', $financeModel->id) }}" class="btn btn-sm fw-bold btn-success"
            target="_blank">{{ __('general.export_pdf') }}</a>
        <a href="javascript:history.back()" class="btn btn-sm fw-bold btn-danger">{{ __('general.back') }}</a>
    </div>
@endsection

@section('content')
    <div class="d-flex flex-column flex-lg-row">
        <!--begin::Content-->
        <div class="flex-lg-row-fluid me-lg-15 border-0">
            <!--begin::Card-->
            <div class="card card-flush pt-3 mb-5 mb-xl-10 border-0">
                <!--begin::Card header-->
                <div class="card-header border-0">
                    <!--begin::Card title-->
                    <div class="card-title">
                        <h2 class="fw-bold">{{ __('general.details') }}</h2>
                    </div>
                    <!--end::Card title-->
                    <!--begin::Card toolbar-->
                    <div class="card-toolbar">
                        <!--begin::Menu-->
                        <button type="button" class="btn btn-sm btn-icon btn-color-primary btn-active-light-primary"
                            data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                            <i class="ki-outline ki-dots-square fs-2"></i>
                        </button>
                        <!--begin::Menu-->
                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px py-4"
                            data-kt-menu="true">
                            <!--begin::Menu item-->
                            <div class="menu-item px-3">
                                <div class="menu-content text-muted pb-2 px-3 fs-7 text-uppercase">
                                    {{ __('general.status') }}</div>
                            </div>
                            <!--end::Menu item-->
                            <!--begin::Menu item-->
                            <div class="menu-item px-3">
                                <a href="#" class="menu-link px-5"
                                    onclick="confirmStatusChange('{{ route($model . '_convert_paid', $financeModel->id) }}', '{{ __('general.confirm_convert_to_paid') }}'); return false;">
                                    <i
                                        class="ki-outline ki-check-circle fs-5 me-2 text-success"></i>{{ __('general.paid') }}
                                </a>
                            </div>
                            <!--end::Menu item-->
                            <!--begin::Menu item-->
                            <div class="menu-item px-3">
                                <a href="#" class="menu-link px-5"
                                    onclick="confirmStatusChange('{{ route($model . '_convert_draft', $financeModel->id) }}', '{{ __('general.confirm_convert_to_draft') }}'); return false;">
                                    <i class="ki-outline ki-pencil fs-5 me-2 text-warning"></i>{{ __('general.draft') }}
                                </a>
                            </div>
                            <!--end::Menu item-->

                            @if(Route::has($model . '_convert_partially_paid'))
                                <div class="menu-item px-3">
                                    <a href="#" class="menu-link px-5"
                                        onclick="confirmStatusChange('{{ route($model . '_convert_partially_paid', $financeModel->id) }}'); return false;">
                                        {{ __('general.partially_paid') }}
                                    </a>
                                </div>
                            @endif

                            @if(Route::has($model . '_convert_unpaid'))
                                <div class="menu-item px-3">
                                    <a href="#" class="menu-link px-5"
                                        onclick="confirmStatusChange('{{ route($model . '_convert_unpaid', $financeModel->id) }}'); return false;">
                                        {{ __('general.unpaid') }}
                                    </a>
                                </div>
                            @endif

                            <div class="separator mt-3 opacity-75"></div>

                            <div class="menu-item px-3 mt-3">
                                <div class="menu-content text-muted pb-2 px-3 fs-7 text-uppercase">
                                    {{ __('general.actions') }}</div>
                            </div>

                            <div class="menu-item px-3">
                                <a href="{{ route('convert_' . $model . '_to_pyment', $financeModel->id) }}"
                                    class="menu-link px-5">{{ __('general.create_payment') }}</a>
                            </div>

                            @if($model == 'invoice')
                                <div class="menu-item px-3">
                                    <a href="{{ route('convert_invoice_to_creditNote', $financeModel->id) }}"
                                        class="menu-link px-5">{{ __('general.create_creditNote') }}</a>
                                </div>
                            @endif
                        </div>
                        <!--end::Menu-->
                    </div>
                    <!--end::Card toolbar-->
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body pt-3 border-0">
                    <!--begin::Section-->
                    <div class="mb-10">
                        <!--begin::Details-->
                        <div class="d-flex flex-wrap py-5">
                            <!--begin::Row-->
                            <div class="flex-equal me-5">
                                <table class="table fs-6 fw-semibold gs-0 gy-2 m-0">
                                    <tr>
                                        <td class="text-gray-500 min-w-175px w-175px">{{ __('general.client') }}:</td>
                                        <td class="text-gray-800 min-w-200px">
                                            <a href="{{ $financeModel->client_id ? route('clients.show', $financeModel->client_id) : '#' }}"
                                                class="text-gray-800 text-hover-primary">{{ $financeModel->client_name }}</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-gray-500">{{ __('general.date') }}:</td>
                                        <td class="text-gray-800">{{ $financeModel->date }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-gray-500">{{ __('general.status') }}:</td>
                                        <td>
                                            <span
                                                class="badge badge-light-{{ $financeModel->status == 'paid' ? 'success' : ($financeModel->status == 'draft' ? 'warning' : 'danger') }}">{{ __('general.' . $financeModel->status) }}</span>
                                        </td>
                                    </tr>
                                    @if($model == 'expense')
                                        <tr>
                                            <td class="text-gray-500">{{ __('general.payment_method') }}:</td>
                                            <td class="text-gray-800">{{ $financeModel->payment_method }}</td>
                                        </tr>
                                    @endif
                                </table>
                            </div>
                            <!--end::Row-->
                            <!--begin::Row-->
                            <div class="flex-equal">
                                <table class="table fs-6 fw-semibold gs-0 gy-2 m-0">
                                    <tr>
                                        <td class="text-gray-500 min-w-175px w-175px">{{ __('general.total') }}:</td>
                                        <td class="text-gray-800 min-w-200px">
                                            <span
                                                class="fw-bold fs-4 text-primary">{{ number_format($financeModel->total, 2) }}
                                                {{ $financeModel->currency }}</span>
                                        </td>
                                    </tr>
                                    @if(isset($financeModel->project_id))
                                        <tr>
                                            <td class="text-gray-500">{{ __('general.project') }}:</td>
                                            <td class="text-gray-800">
                                                <a href="{{ route('projects.show', $financeModel->project_id) }}"
                                                    class="text-gray-800 text-hover-primary">{{ $financeModel->project->subject ?? '#' }}</a>
                                            </td>
                                        </tr>
                                    @endif
                                </table>
                            </div>
                            <!--end::Row-->
                        </div>
                        <!--end::Details-->
                    </div>
                    <!--end::Section-->

                    <!--begin::Section-->
                    <div class="mb-0">
                        <h5 class="mb-4">{{ __('general.items') }}</h5>
                        <div class="table-responsive">
                            <table class="table align-middle table-row-dashed fs-6 gy-5">
                                <thead>
                                    <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                        <th class="min-w-175px">{{ __('general.item') }}</th>
                                        <th class="min-w-70px text-end">{{ __('general.qty') }}</th>
                                        <th class="min-w-100px text-end">{{ __('general.price') }}</th>
                                        <th class="min-w-100px text-end">{{ __('general.tax') }}</th>
                                        <th class="min-w-100px text-end">{{ __('general.total') }}</th>
                                    </tr>
                                </thead>
                                <tbody class="fw-semibold text-gray-600">
                                    @foreach($modelItems as $item)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="ms-0">
                                                        <a href="#"
                                                            class="text-gray-800 text-hover-primary fs-6 fw-bold">{{ $item->name }}</a>
                                                        <div class="text-muted fs-7">{{ $item->description }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-end">{{ $item->qty }}</td>
                                            <td class="text-end">{{ number_format($item->amount, 2) }}</td>
                                            <td class="text-end">{{ $item->tax }}%</td>
                                            <td class="text-end">{{ number_format($item->subtotal, 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!--end::Section-->
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Card-->
        </div>
        <!--end::Content-->

        <!--begin::Sidebar-->
        <div class="flex-column flex-lg-row-auto w-100 w-lg-300px mb-10 border-0">
            <!--begin::Card-->
            <div class="card card-flush pt-3 mb-0 border-0" data-kt-sticky="true" data-kt-sticky-name="finance-summary"
                data-kt-sticky-offset="{default: false, lg: '200px'}" data-kt-sticky-width="{lg: '300px'}"
                data-kt-sticky-left="auto" data-kt-sticky-top="150px" data-kt-sticky-animation="false"
                data-kt-sticky-zindex="95">
                <div class="card-header border-0">
                    <div class="card-title">
                        <h2>{{ __('general.summary') }}</h2>
                    </div>
                </div>
                <div class="card-body pt-0 border-0">
                    <div class="d-flex flex-stack mb-3">
                        <div class="fw-semibold text-gray-600 fs-6">{{ __('general.subtotal') }}</div>
                        <div class="fw-bold text-gray-800 fs-6">{{ number_format($financeModel->subtotal, 2) }}
                            {{ $financeModel->currency }}</div>
                    </div>
                    <div class="d-flex flex-stack mb-3">
                        <div class="fw-semibold text-gray-600 fs-6">{{ __('general.tax') }}</div>
                        <div class="fw-bold text-gray-800 fs-6">{{ number_format($financeModel->total_tax, 2) }}
                            {{ $financeModel->currency }}</div>
                    </div>
                    @if($financeModel->total_discount > 0)
                        <div class="d-flex flex-stack mb-3">
                            <div class="fw-semibold text-gray-600 fs-6">{{ __('general.discount') }}</div>
                            <div class="fw-bold text-danger fs-6">-{{ number_format($financeModel->total_discount, 2) }}
                                {{ $financeModel->currency }}</div>
                        </div>
                    @endif
                    <div class="separator separator-dashed mb-3"></div>
                    <div class="d-flex flex-stack">
                        <div class="fw-bolder text-gray-800 fs-5">{{ __('general.total') }}</div>
                        <div class="fw-bolder text-primary fs-5">{{ number_format($financeModel->total, 2) }}
                            {{ $financeModel->currency }}</div>
                    </div>
                </div>
            </div>
            <!--end::Card-->
        </div>
        <!--end::Sidebar-->
    </div>
@endsection

@section('scripts')
    <script>
        function confirmStatusChange(url, message) {
            Swal.fire({
                text: message || "{{ __('general.confirm_status_change') }}",
                icon: "warning",
                showCancelButton: true,
                buttonsStyling: false,
                confirmButtonText: "{{ __('general.yes_confirm') }}",
                cancelButtonText: "{{ __('general.cancel') }}",
                customClass: {
                    confirmButton: "btn btn-primary",
                    cancelButton: "btn btn-active-light"
                }
            }).then(function (result) {
                if (result.isConfirmed) {
                    window.location.href = url;
                }
            });
        }
    </script>
@endsection