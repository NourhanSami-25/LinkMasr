<div class="tab-pane fade" id="kt_customer_view_contacts" role="tabpanel">

    <!--begin::Card-->
    <div class="card pt-4 mb-6 mb-xl-9">
        <!--begin::Card header-->
        <div class="card-header border-0">
            <!--begin::Card title-->
            <div class="card-title">
                <h2>{{ __('general.contacts') }}</h2>
            </div>
            <!--end::Card title-->
            <!--begin::Card toolbar-->
            <div class="d-flex align-items-center gap-2 gap-lg-3">
                <a href="#" class="btn btn-flex btn-outline btn-primary h-40px fs-7 fw-bold" data-bs-toggle="modal" data-bs-target="#kt_modal_new_target_create_contact">{{ __('general.create_new') }}</a>
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
                        <th class="text-start">{{ __('general.name') }}</th>
                        <th class="text-start">{{ __('general.email') }}</th>
                        <th class="text-start">{{ __('general.phone') }}</th>
                        <th class="text-start">{{ __('general.is_primary') }}</th>
                        <th class="text-start">{{ __('general.status') }}</th>
                        <th class="text-end min-w-100px pe-4">{{ __('general.actions') }}</th>
                    </tr>
                </thead>
                <tbody class="fs-6 fw-semibold text-gray-800">
                    @foreach($clientContacts as $contact)
                    @include('client._edit_contact', ['contact' => $contact, 'modalId' => "kt_modal_new_target_contact_edit_{$contact->id}"])
                    <tr>
                        <td class="text-start">{{$contact->id}}</td>
                        <td class="text-start">{{$contact->name}}</td>
                        <td class="text-start">{{$contact->email}}</td>
                        <td class="text-start">{{$contact->phone}}</td>
                        <td class="text-start">{{ $contact->is_primary ? 'yes' : 'no' }}</td>
                        <td class="text-start">{{ __('general.' . $contact->status) }}</td>
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
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#kt_modal_new_target_contact_edit_{{ $contact->id }}"
                                        class="menu-link px-3">{{ __('general.edit') }}</a>
                                </div>
                                <!--end::Menu item-->
                                @hasAccess('client','modify')
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <form id="delete-form-{{ $contact->id }}" action="{{ route('client-contacts.destroy', $contact->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <div class="menu-item">
                                            <button type="button" onclick="showConfirmation('{{ addslashes($contact->name) }}', '{{ $contact->id }}');" class="dropdown-item menu-link fw-bold text-danger">{{ __('general.delete') }}</button>
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
@include('client._create_contact', ['client_id' => $client->id])
