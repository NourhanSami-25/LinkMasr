<div class="tab-pane fade" id="kt_customer_view_poa" role="tabpanel">

    <!--begin::Card-->
    <div class="card pt-4 mb-6 mb-xl-9">
        <!--begin::Card header-->
        <div class="card-header border-0">
            <!--begin::Card title-->
            <div class="card-title">
                <h2>{{ __('general.poa_files') }}</h2>
            </div>
            <!--end::Card title-->
            <!--begin::Card toolbar-->
            <div class="d-flex align-items-center gap-2 gap-lg-3">
                @hasAccess('client','details')
                <a href="#" class="btn btn-flex btn-outline btn-primary h-40px fs-7 fw-bold" data-bs-toggle="modal" data-bs-target="#kt_modal_new_target_upload_file" data-category="poa">{{ __('general.upload_new_poa_file') }}</a>
				@endhasAccess
                {{-- <a href="{{route('files.index' )}}" class="btn btn-flex btn-outline btn-primary h-40px fs-7 fw-bold" target="_blank">{{ __('general.view_all') }}</a> --}}
			</div>
            <!--end::Card toolbar-->
        </div>
        <!--end::Card header-->
        <!--begin::Card body-->
        <div class="card-body pt-0 pb-5">
            <!--begin::Table-->
            <table class="table align-middle table-row-dashed kt-datatable gy-5"
                id="poa_table">
                <thead class="border-bottom border-gray-200 fs-7 fw-bold">
                    <tr class="text-muted text-uppercase gs-0">
                        <th class="text-start">{{ __('general.id') }}</th>
                        <th class="text-start">{{ __('general.category') }}</th>
                        <th class="text-start">{{ __('general.name') }}</th>
                        <th class="text-start">{{ __('general.description') }}</th>
                        <th class="text-start">{{ __('general.uploaded_by') }}</th>
                        <th class="text-start">{{ __('general.created_at') }}</th>
                        <th class="text-end min-w-100px pe-4">{{ __(key: 'general.actions') }}</th>
                    </tr>
                </thead>
                <tbody class="fs-6 fw-semibold text-gray-800">
                    @foreach($POAFiles as $file)
                    <tr>
                        <td class="text-start">{{ $file->id }}</td>
                        <td class="text-start">{{ $file->category }}</td>
                        <td class="text-start">{{ $file->name }}</td>
                        <td class="text-start">{{ $file->description }}</td>
                        <td class="text-start">{{ __getUserNameById($file->created_by) }}</td>
                        <td class="text-start">{{date('Y-m-d', strtotime($file->created_at))}}</td>
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
                                    <a href="{{ route('files.preview', $file->id) }}" target="_blank"
                                        class="menu-link px-3">{{ __('general.preview') }}</a>
                                </div>
                                <!--end::Menu item-->
								<!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="{{ route('files.download', $file->id) }}" target="_blank"
                                        class="menu-link px-3">{{ __('general.download') }}</a>
                                </div>
                                <!--end::Menu item-->
                                @hasAccess('client','modify')
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <form id="delete-form-{{ $file->id }}" action="{{ route('files.delete', $file->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <div class="menu-item">
                                            <button type="button" onclick="showConfirmation('{{ addslashes($file->subject) }}', '{{ $file->id }}');" class="dropdown-item menu-link fw-bold text-danger">{{ __('general.delete') }}</button>
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
