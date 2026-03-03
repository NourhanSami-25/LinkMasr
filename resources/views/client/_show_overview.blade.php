<div class="tab-pane fade show active" id="kt_customer_view_overview_tab" role="tabpanel">

    <!--begin::Earnings-->
    <div class="card mb-6 mb-xl-9">
        <!--begin::Header-->
        <div class="card-header border-0">
            <div class="card-title">
                <h2>{{__('general.client_data')}}</h2>
            </div>
        </div>
        <!--end::Header-->
        <!--begin::Body-->
        <!--begin::Card body-->
        <div class="card-body pt-0">
            <div class="table-responsive">
                <!--begin::Table-->
                <table class="table align-middle table-row-bordered mb-0 fs-5 gy-5 min-w-300px">
                    <tbody class="fw-semibold text-gray-600">
                        <tr>
                            <td class="text-muted">
                                {{__('general.name')}}
                            </td>
                            <td class="fw-bold text-end text-gray-800">{{$client->name ?? __('general.not_exists')}}
                            </td>
                            <td class="text-muted">
                                <div class="d-flex align-items-center">
                                    {{__('general.type')}}
                                </div>
                            </td>
                            <td class="fw-bold text-end text-gray-800">
                                {{  __('general.' . $client->type) ?? __('general.not_exists')}}
                            </td>
                        </tr>
                        <tr>
                            <td class="text-muted">
                                <div class="d-flex align-items-center">
                                    {{__('general.phone')}}
                                </div>
                            </td>
                            <td class="fw-bold text-end text-gray-800">{{$client->phone ?? __('general.not_exists')}}
                            </td>
                            <td class="text-muted">
                                <div class="d-flex align-items-center">
                                    {{__('general.phone2')}}
                                </div>
                            </td>
                            <td class="fw-bold text-end text-gray-800">{{$client->phone2 ?? __('general.not_exists')}}
                            </td>
                        </tr>
                        <tr>
                            <td class="text-muted">
                                <div class="d-flex align-items-center">
                                    {{__('general.email')}}
                                </div>
                            </td>
                            <td class="fw-bold text-end text-gray-800">{{$client->email ?? __('general.not_exists')}}
                            </td>
                            <td class="text-muted">
                                <div class="d-flex align-items-center">
                                    {{__('general.website')}}
                                </div>
                            </td>
                            <td class="fw-bold text-end text-gray-800">{{$client->website ?? __('general.not_exists')}}
                            </td>
                        </tr>
                        <tr>
                            <td class="text-muted">
                                <div class="d-flex align-items-center">
                                    {{__('general.currency')}}
                                </div>
                            </td>
                            <td class="fw-bold text-end text-gray-800">{{$client->currency ?? __('general.not_exists')}}
                            </td>
                            <td class="text-muted">
                                <div class="d-flex align-items-center">
                                    {{__('general.default_language')}}
                                </div>
                            </td>
                            <td class="fw-bold text-end text-gray-800">
                                {{__('general.' . $client->default_language) ?? __('general.not_exists')}}
                            </td>
                        </tr>
                        <tr>
                            <td class="text-muted">
                                <div class="d-flex align-items-center">
                                    {{__('general.tax_number')}}
                                </div>
                            </td>
                            <td class="fw-bold text-end text-gray-800">
                                {{$client->tax_number ?? __('general.not_exists')}}
                            </td>
                            <td class="text-muted">
                                <div class="d-flex align-items-center">
                                    {{__('general.computer_number')}}
                                </div>
                            </td>
                            <td class="fw-bold text-end text-gray-800">
                                {{$client->computer_number ?? __('general.not_exists')}}
                            </td>
                        </tr>

                    </tbody>
                    <!--end::Table body-->
                </table>
                <!--end::Table-->
            </div>
        </div>
        <!--end::Card body-->
    </div>
    <!--begin::Card Addresses-->
    <div class="card pt-4 mb-6 mb-xl-9">
        <!--begin::Card header-->
        <div class="card-header border-0">
            <!--begin::Card title-->
            <div class="card-title">
                <h2>{{__('general.addresses')}}</h2>
            </div>
            <!--end::Card title-->
            <!--begin::Card toolbar-->
            <div class="card-toolbar">
                <a href="#" data-bs-toggle="modal" data-bs-target="#kt_modal_new_target_create_address"
                    class="btn btn-sm btn-flex btn-light-primary">
                    <i class="ki-outline ki-plus-square fs-3"></i>{{__('general.create_new_address')}}</a>
            </div>
            <!--end::Card toolbar-->
        </div>
        <!--end::Card header-->
        <!--begin::Card body-->
        <div id="kt_ecommerce_customer_addresses" class="card-body pt-0 pb-5">
            <div class="accordion accordion-icon-toggle" id="kt_ecommerce_customer_addresses_accordion">
                <!--begin::Addresses-->
                @foreach ($ClientAddresses as $address)
                    @include('client._edit_address', ['address' => $address, 'modalId' => "kt_modal_new_target_address_edit_{$address->id}"])
                    <!--begin::Address-->
                    <div class="py-0">
                        <!--begin::Header-->
                        <div class="py-3 d-flex flex-stack flex-wrap">
                            <!--begin::Toggle-->
                            <div class="accordion-header d-flex align-items-center collapsible collapsed rotate"
                                data-bs-toggle="collapse" href="#kt_ecommerce_customer_addresses_1" role="button"
                                aria-expanded="false" aria-controls="kt_customer_view_payment_method_1">
                                <!--begin::Arrow-->
                                <div class="accordion-icon me-3">
                                    <i class="ki-outline ki-right fs-4"></i>
                                </div>
                                <!--end::Arrow-->
                                <!--begin::Summary-->
                                <div class="me-3">
                                    <div class="d-flex align-items-center">
                                        <div class="fs-4 fw-bold">{{$address->bank_name}}</div>
                                        <div class="badge badge-light-primary ms-5">
                                            {{$address->status}}
                                        </div>
                                    </div>
                                    <div class="text-muted">{{$address->address}}
                                    </div>
                                </div>
                                <!--end::Summary-->
                            </div>
                            <!--end::Toggle-->
                            <!--begin::Toolbar-->
                            <div class="d-flex my-3 ms-9">
                                <!--begin::Edit-->
                                <a href="#" class="btn btn-icon btn-active-light-primary w-30px h-30px me-3"
                                    data-bs-toggle="modal"
                                    data-bs-target="#kt_modal_new_target_address_edit_{{ $address->id }}">
                                    <span data-bs-toggle="tooltip" data-bs-trigger="hover" title="Edit">
                                        <i class="ki-outline ki-pencil fs-3"></i>
                                    </span>
                                </a>
                                <!--end::Edit-->
                                <!--begin::Delete-->
                                @hasAccess('client', 'modify')
                                <form id="delete-form-{{ $address->id }}"
                                    action="{{ route('addresses.destroy', $address->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-icon btn-active-light-danger w-30px h-30px me-3" type="button"
                                        onclick="showConfirmation('{{ addslashes($address->bank_name) }}', '{{ $address->id }}');"
                                        title="{{ __('general.delete') }}">
                                        <i class="ki-outline ki-trash fs-3"></i>
                                    </button>
                                </form>
                                @endhasAccess

                                <!--end::Delete-->
                            </div>
                            <!--end::Toolbar-->
                        </div>
                        <!--end::Header-->
                        <!--begin::Body-->
                        <div id="kt_ecommerce_customer_addresses_1" class="collapse fs-6 ps-9"
                            data-bs-parent="#kt_ecommerce_customer_addresses_accordion">
                            <!--begin::Details-->
                            <div class="d-flex flex-column pb-5">
                                <div class="fw-bold text-gray-600">{{__('general.country')}} : {{$address->country}} -
                                    {{$address->state}}
                                </div>
                                <div class="fw-bold text-gray-600 mb-4">{{__('general.address')}} : {{$address->city}} -
                                    {{$address->street_name}} {{$address->street_number}}
                                    <br />{{__('general.building')}} : {{$address->building_number}} -
                                    {{__('general.floor:')}} {{$address->floor_number}} - {{__('general.unit:')}}
                                    {{$address->unit_number}}
                                    <br />{{__('general.zip_code')}} : {{$address->zip_code}}
                                </div>
                            </div>
                            <!--end::Details-->
                        </div>
                        <!--end::Body-->
                    </div>
                    <!--end::Address-->
                @endforeach
                <!--end::Addresses-->
            </div>
        </div>
        <!--end::Card body-->
    </div>
    <!--end::Card Addresses-->

    <!--begin::Card Billing Addresses-->
    <div class="card pt-4 mb-6 mb-xl-9">
        <!--begin::Card header-->
        <div class="card-header border-0">
            <!--begin::Card title-->
            <div class="card-title">
                <h2>{{__('general.billing_addresses')}}</h2>
            </div>
            <!--end::Card title-->
            <!--begin::Card toolbar-->
            <div class="card-toolbar">
                <a href="#" data-bs-toggle="modal" data-bs-target="#kt_modal_new_target_create_billing_address"
                    class="btn btn-sm btn-flex btn-light-primary">
                    <i class="ki-outline ki-plus-square fs-3"></i>{{__('general.create_new_billing_address')}}</a>
            </div>
            <!--end::Card toolbar-->
        </div>
        <!--end::Card header-->
        <!--begin::Card body-->
        <div id="kt_ecommerce_customer_addresses" class="card-body pt-0 pb-5">
            <div class="accordion accordion-icon-toggle" id="kt_ecommerce_customer_addresses_accordion">
                <!--begin::Addresses-->
                @foreach ($billingAddresses as $address)
                    @include('client._edit_billing_address', ['address' => $address, 'modalId' => "kt_modal_new_target_billing_address_edit_{$address->id}"])
                    <!--begin::Address-->
                    <div class="py-0">
                        <!--begin::Header-->
                        <div class="py-3 d-flex flex-stack flex-wrap">
                            <!--begin::Toggle-->
                            <div class="accordion-header d-flex align-items-center collapsible collapsed rotate"
                                data-bs-toggle="collapse" href="#kt_ecommerce_customer_addresses_1" role="button"
                                aria-expanded="false" aria-controls="kt_customer_view_payment_method_1">
                                <!--begin::Arrow-->
                                <div class="accordion-icon me-3">
                                    <i class="ki-outline ki-right fs-4"></i>
                                </div>
                                <!--end::Arrow-->
                                <!--begin::Summary-->
                                <div class="me-3">
                                    <div class="d-flex align-items-center">
                                        <div class="fs-4 fw-bold">{{$address->bank_name}}</div>
                                        <div class="badge badge-light-primary ms-5">
                                            {{$address->status}}
                                        </div>
                                    </div>
                                    <div class="text-muted">{{$address->address}}
                                    </div>
                                </div>
                                <!--end::Summary-->
                            </div>
                            <!--end::Toggle-->
                            <!--begin::Toolbar-->
                            <div class="d-flex my-3 ms-9">
                                <!--begin::Edit-->
                                <a href="#" class="btn btn-icon btn-active-light-primary w-30px h-30px me-3"
                                    data-bs-toggle="modal"
                                    data-bs-target="#kt_modal_new_target_billing_address_edit_{{ $address->id }}">
                                    <span data-bs-toggle="tooltip" data-bs-trigger="hover" title="Edit">
                                        <i class="ki-outline ki-pencil fs-3"></i>
                                    </span>
                                </a>
                                <!--end::Edit-->
                                @hasAccess('client', 'modify')
                                <!--begin::Delete-->
                                <form id="delete-form-{{ $address->id }}"
                                    action="{{ route('billing-addresses.destroy', $address->id) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-icon btn-active-light-danger w-30px h-30px me-3" type="button"
                                        onclick="showConfirmation('{{ addslashes($address->bank_name) }}', '{{ $address->id }}');"
                                        title="{{ __('general.delete') }}">
                                        <i class="ki-outline ki-trash fs-3"></i>
                                    </button>
                                </form>
                                <!--end::Delete-->
                                @endhasAccess
                            </div>
                            <!--end::Toolbar-->
                        </div>
                        <!--end::Header-->
                        <!--begin::Body-->
                        <div id="kt_ecommerce_customer_addresses_1" class="collapse fs-6 ps-9"
                            data-bs-parent="#kt_ecommerce_customer_addresses_accordion">
                            <!--begin::Details-->
                            <div class="d-flex flex-column pb-5">
                                <div class="fw-bold text-gray-600">{{__('general.le_account')}} : {{$address->le_account}}
                                </div>
                                <div class="fw-bold text-gray-600 mb-4">{{__('general.le_ipan')}} : {{$address->le_iban}}
                                    <br />{{__('general.le_swift_code')}} : {{$address->le_swift_code}}
                                </div>
                                <div class="fw-bold text-gray-600">{{__('general.us_account')}} : {{$address->us_account}}
                                </div>
                                <div class="fw-bold text-gray-600 mb-4">{{__('general.us_ipan')}} : {{$address->us_iban}}
                                    <br />{{__('general.us_swift_code')}} : {{$address->us_swift_code}}
                                </div>
                            </div>
                            <!--end::Details-->
                        </div>
                        <!--end::Body-->
                    </div>
                    <!--end::Address-->
                @endforeach
                <!--end::Addresses-->
            </div>
        </div>
        <!--end::Card body-->
    </div>
    <!--end::Card Billing Addresses-->

</div>