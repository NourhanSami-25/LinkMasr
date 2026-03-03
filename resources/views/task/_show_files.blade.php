<!--begin::Content-->
<div class="tab-pane fade" id="kt_task_view_files" role="tabpanel">

	<!--begin::Card-->
	<div class="card pt-4 mb-6 mb-xl-9">
    <!--begin::Card header-->
    <div class="card-header border-0">
        <!--begin::Card title-->
	    <div class="card-title">
	    	<!--begin::Search-->
	    	<div class="d-flex align-items-center position-relative my-1">
	    		<i class="ki-outline ki-magnifier fs-3 position-absolute ms-4"></i>
	    		<input type="text" data-kt-table="files_table" data-kt-filter="search"
	    			class="form-control form-control-solid w-250px ps-12"
	    			placeholder="{{ __('general.search_keyword') }}" />
	    	</div>
	    	<!--end::Search-->
	    	<!--begin::Export buttons-->
	    	<div id="files_table_export" class="d-none"></div>
	    	<!--end::Export buttons-->
	    </div>
	    <!--end::Card title-->

        <!--begin::Card toolbar-->
		<div class="card-toolbar flex-row-fluid justify-content-end gap-5">
			<!--begin::Filter-->
			<div class="w-150px">
				<!--begin::Select2-->
				<select class="form-select form-select-solid" data-control="select2"
					data-hide-search="true" data-placeholder="{{ __('general.status_filter') }}"
					data-kt-table="files_table" data-kt-filter="status">
					<option></option>
					<option value="all" selected="selected">{{ __('general.all') }}</option>
				</select>
				<!--end::Select2-->
			</div>
			<!--end::Filter-->
			<!--begin::Export dropdown-->
			<button type="button" class="btn btn-light-primary"
				data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
				<i class="ki-outline ki-exit-up fs-2"></i>{{ __('general.export_report') }}</button>
			<!--begin::Menu-->
			<div id="files_table_export_menu"
				class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-200px py-4"
				data-kt-menu="true">
				<!--begin::Menu item-->
				<div class="menu-item px-3">
					<a href="#" class="menu-link px-3"
						data-kt-export="copy">{{ __('general.export_clipboard') }}</a>
				</div>
				<!--end::Menu item-->
				<!--begin::Menu item-->
				<div class="menu-item px-3">
					<a href="#" class="menu-link px-3"
						data-kt-export="excel">{{ __('general.export_excel') }}</a>
				</div>
				<!--end::Menu item-->
				<!--begin::Menu item-->
				<div class="menu-item px-3">
					<a href="#" class="menu-link px-3"
						data-kt-export="csv">{{ __('general.export_csv') }}</a>
				</div>
				<!--end::Menu item-->
				<!--begin::Menu item-->
				<div class="menu-item px-3">
					<a href="#" class="menu-link px-3"
						data-kt-export="pdf">{{ __('general.export_pdf') }}</a>
				</div>
				<!--end::Menu item-->
			</div>

			@hasAccess('task', 'details')	
			<!--end::Menu-->
            <div class="d-flex align-items-center gap-2 gap-lg-3">
                <a href="#" class="btn btn-flex btn-primary h-40px fs-7 fw-bold" data-bs-toggle="modal" data-bs-target="#kt_modal_new_target_upload_file" data-category="task">{{ __('general.upload_new_file') }}</a>
            </div>
			<!--end::Export dropdown-->
			@endhasAccess
		</div>
		<!--end::Card toolbar-->
    </div>
    <!--end::Card header-->
    <!--begin::Card body-->
    <div class="card-body pt-0 pb-5">
        <!--begin::Table-->
        <table class="table align-middle table-row-dashed kt-datatable gy-5"
            id="files_table">
            <thead class="border-bottom border-gray-200 fs-7 fw-bold">
                <tr class="text-muted text-uppercase gs-0">
                    <th class="text-start min-w-50px">#</th>
                    <th class="text-start min-w-100px">{{ __('general.subject') }}</th>
                    <th class="text-start">{{ __('general.description') }}</th>
                    <th class="text-start min-w-100px">{{ __('general.uploaded_at') }}</th>
                    <th class="text-start min-w-100px">{{ __('general.uploaded_by') }}</th>
                    <th class="text-end min-w-100px pe-4">{{ __('general.actions') }}</th>
                </tr>
            </thead>
            <tbody class="fs-6 fw-semibold text-gray-800">
                @foreach($files as $file)
				@include('common.file.update_file', ['file' => $file, 'modalId' => "kt_modal_new_target_update_file_{$file->id}"])

                <tr>
                    <td class="text-start">{{ $file->id }}</a></td>
                    <td class="text-start"><a href="{{ route('files.preview', $file->id) }}" class="text-gray-800 text-hover-primary mb-1" target="_blank">{{$file->name}}</a></td>
                    <td class="text-start">{{ $file->description }}</td>
                    <td class="text-start">{{ $file->created_at }}</td>
                    <td class="text-start">{{__getUserNameById($file->created_by)}}</td>
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
						    	<a href="{{ route('files.preview', $file->id) }}" class="menu-link px-3" target="_blank">{{ __('general.preview') }}</a>
						    </div>
						    <!--end::Menu item-->
							<!--begin::Menu item-->
						    <div class="menu-item px-3">
						    	<a href="{{ route('files.download', $file->id) }}" class="menu-link px-3" target="_blank">{{ __('general.download') }}</a>
						    </div>
						    <!--end::Menu item-->
							@hasAccess('task', 'details')
							<!--begin::Menu item-->
                            <div class="menu-item px-3">
                                <a href="#" data-bs-toggle="modal" data-bs-target="#kt_modal_new_target_update_file_{{ $file->id }}"
                                    class="menu-link px-3">{{ __('general.edit') }}</a>
                            </div>
                            <!--end::Menu item-->
						    <!--begin::Menu item-->
						    <div class="menu-item px-3">
                                <form id="delete-form-{{ $file->id }}" action="{{ route('files.delete', $file->id) }}" method="POST">
						    		@csrf
						    		@method('DELETE')
						    		<div class="menu-item">
						    			<button type="button" onclick="showConfirmation('{{ addslashes($file->name) }}', '{{ $file->id }}');" class="dropdown-item menu-link fw-bold text-danger">{{ __('general.delete') }}</button>
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

@include('common.file.upload_file', ['item' => $task , 'category' => 'task'])

</div>
