<!DOCTYPE html>

@if (app()->getLocale() == 'ar')
	@include('assets._language_ar')
@else
	@include('assets._language_en')
@endif

<head>

	<title>Link Masr | Contract Details</title>
	@include('assets._meta_tags')
	@include('assets._misc')
	@include('assets._data_table_styles')


	@if (app()->getLocale() == 'ar')
		@include('assets._ar_fonts')
		@include('assets._main_styles_RTL')
	@else
		@include('assets._en_fonts')
		@include('assets._main_styles_LTR')
	@endif
	

</head>

<body id="kt_app_body" data-kt-app-header-fixed="true" data-kt-app-header-fixed-mobile="true"
	data-kt-app-sidebar-enabled="true" data-kt-app-sidebar-fixed="true" data-kt-app-sidebar-hoverable="true"
	data-kt-app-sidebar-push-toolbar="true" data-kt-app-sidebar-push-footer="true" data-kt-app-toolbar-enabled="true"
	data-kt-app-aside-enabled="true" data-kt-app-aside-fixed="true" data-kt-app-aside-push-toolbar="true"
	data-kt-app-aside-push-footer="true" class="app-default" data-kt-app-sidebar-minimize="on">
	
	
	

	@include('assets.dark_mode')
	<!--begin::App-->
	<div class="d-flex flex-column flex-root app-root" id="kt_app_root">
		<!--begin::Page-->
		<div class="app-page flex-column flex-column-fluid" id="kt_app_page">
			<!--begin::Header-->
			@include('layout._header')
			<!--end::Header-->
			<!--begin::Wrapper-->
			<div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">
				<!--begin::Sidebar-->
				@include('layout._side_bar')
				<!--end::Sidebar-->
				<!--begin::Main-->
				<div class="app-main flex-column flex-row-fluid" id="kt_app_main">
					<!--begin::Content wrapper-->
					<div class="d-flex flex-column flex-column-fluid">
						<!--begin::Toolbar-->
						<div id="kt_app_toolbar" class="app-toolbar pt-6 pb-2">
							<!--begin::Toolbar container-->
							<div id="kt_app_toolbar_container"
								class="app-container container-fluid d-flex align-items-stretch">
								<!--begin::Toolbar wrapper-->
								<div class="app-toolbar-wrapper d-flex flex-stack flex-wrap gap-4 w-100">
									<!--begin::Page title-->
									<div class="page-title d-flex flex-column justify-content-center gap-1 me-3">
										<!--begin::Title-->
										<h1
											class="page-heading d-flex flex-column justify-content-center text-gray-900 fw-bold fs-1 m-0">
											{{ __('general.contract_details') }} </h1>
										<!--end::Title-->
										<!--begin::Breadcrumb-->
										<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0">
											<!--begin::Item-->
											<li class="breadcrumb-item text-muted">
												<a href="{{ route('home')}}" class="text-muted text-hover-primary">{{ __('general.home_breadcrumb') }}</a>
											</li>
											<!--end::Item-->
											<!--begin::Item-->
											<li class="breadcrumb-item">
												<span class="bullet bg-gray-500 w-5px h-2px"></span>
											</li>
											<!--end::Item-->
											<!--begin::Item-->
											<li class="breadcrumb-item text-muted">
												<a href="{{ route('contracts.index')}}" class="text-muted text-hover-primary">{{ __('general.contracts') }}</a>
											</li>
											<!--end::Item-->
											<!--begin::Item-->
											<li class="breadcrumb-item">
												<span class="bullet bg-gray-500 w-5px h-2px"></span>
											</li>
											<!--end::Item-->
											<!--begin::Item-->
											<li class="breadcrumb-item text-muted">{{ __('general.contract_details') }}</li>
											<!--end::Item-->
										</ul>
										<!--end::Breadcrumb-->
									</div>
									<!--end::Page title-->
									<!--begin::Actions-->
									<div class="d-flex align-items-center gap-2 gap-lg-3">
										<a href="javascript:history.back()" class="btn btn-flex btn-danger h-40px fs-7 fw-bold">{{ __('general.back') }}</a>											
									</div>
									<!--end::Actions-->
								</div>
								<!--end::Toolbar wrapper-->
							</div>
							<!--end::Toolbar container-->
						</div>
						<!--end::Toolbar-->
						<!--begin::Content-->
						<div id="kt_app_content" class="app-content flex-column-fluid">
							<!--begin::Content container-->
							<div id="kt_app_content_container" class="app-container container-fluid">
								<!--begin::Layout-->
								<div class="d-flex flex-column flex-lg-row">
									<!--begin::Content-->
									<div class="flex-lg-row-fluid order-2 order-lg-1 mb-10 mb-lg-0">
										<!--begin::Card-->
										<div class="card card-flush pt-3 mb-5 mb-xl-10">
											<!--begin::Card header-->
											<div class="card-header">
												<!--begin::Card title-->
												<div class="card-title">
													<h2 class="fw-bold">{{ __('general.contract_details') }}</h2>
												</div>
												<!--begin::Card title-->
												<!--begin::Card toolbar-->
												<div class="card-toolbar">
													<a href="{{ route('print.model', ['model' => 'business\Contract', 'id' => $contract->id]) }}" class="btn btn-light-primary" target="_blank">{{ __('general.print_contract') }}</a>
												</div>
												<!--end::Card toolbar-->
											</div>
											<!--end::Card header-->
											<!--begin::Card body-->
											<div class="card-body pt-3">
												<!--begin::Section-->
												<div class="mb-10">
													<!--begin::Details-->
													<div class="d-flex flex-wrap py-5">
														<!--begin::Row-->
														<div class="flex-equal me-5">
															<!--begin::Details-->
															<table class="table fs-5 fw-semibold gs-0 gy-2 gx-2 m-0">
																<!--begin::Row-->
																<tr>
																	<td class="text-gray-600 min-w-175px w-175px">{{ __('general.number') }}</td>
																	<td class="text-gray-800 fw-bold min-w-200px fw-bold">{{$contract->number}}</td>
																</tr>
																<!--end::Row-->
                                                                <!--begin::Row-->
																<tr>
																	<td class="text-gray-600">{{ __('general.subject') }}</td>
																	<td class="text-gray-800 fw-bold">{{$contract->subject}}</td>
																</tr>
																<!--end::Row-->
                                                                <!--begin::Row-->
																<tr>
																	<td class="text-gray-600">{{ __('general.type') }}</td>
																	<td class="text-gray-800 fw-bold">{{$contract->type}}</td>
																</tr>
																<!--end::Row-->
                                                                <!--begin::Row-->
																<tr>
																	<td class="text-gray-600">{{ __('general.date') }}</td>
																	<td class="text-gray-800 fw-bold">{{$contract->date}}</td>
																</tr>
																<!--end::Row-->
                                                                <!--begin::Row-->
																<tr>
																	<td class="text-gray-600">{{ __('general.end_date') }}</td>
																	<td class="text-gray-800 fw-bold">{{$contract->due_date}}</td>
																</tr>
																<!--end::Row-->
                                                                <!--begin::Row-->
																<tr>
																	<td class="text-gray-600">{{ __('general.created_by') }}</td>
																	<td class="text-gray-800 fw-bold">{{__getUserNameById($contract->created_by)}}</td>
																</tr>
																<!--end::Row-->
                                                                <!--begin::Row-->
																<tr>
																	<td class="text-gray-600">{{ __('general.created_at') }}</td>
																	<td class="text-gray-800 fw-bold">{{$contract->created_at}}</td>
																</tr>
																<!--end::Row-->
                                                                <!--begin::Row-->
																<tr>
																	<td class="text-gray-600">{{ __('general.content') }}</td>
																	<td class="text-gray-800 fw-bold">{{$contract->content}}</td>
																</tr>
																<!--end::Row-->
															</table>
															<!--end::Details-->
														</div>
														<!--end::Row-->
														<!--begin::Row-->
														<div class="flex-equal">
															<!--begin::Details-->
															<table class="table fs-5 fw-semibold gs-0 gy-2 gx-2 m-0">
                                                                <!--begin::Row-->
																<tr>
																	<td class="text-gray-600 min-w-175px w-175px">{{ __('general.status') }}</td>
																	<td class="fw-bold min-w-200px">
																	    <span class="text-light fs-5 badge 
                                                                            @if($contract->status == 'active') bg-success
                                                                            @elseif($contract->status == 'expired') bg-danger
                                                                            @elseif($contract->status == 'about_to_expire') bg-warning
                                                                            @elseif($contract->status == 'recently_added') bg-info
                                                                            @elseif($contract->status == 'accepted') bg-primary
                                                                            @elseif($contract->status == 'trash') bg-secondary
                                                                            @endif">
                                                                            {{ __('general.' . $contract->status) }}
                                                                        </span>
																	</td>
																</tr>
																<!--end::Row-->
                                                                <!--begin::Row-->
																<tr>
																	<td class="text-gray-600">{{ __('general.total') }}</td>
																	<td class="text-gray-800 fw-bold">{{$contract->total}}</td>
																</tr>
																<!--end::Row-->
                                                                 <!--begin::Row-->
																<tr>
																	<td class="text-gray-600">{{ __('general.currency') }}</td>
																	<td class="text-gray-800 fw-bold">{{$contract->currency}}</td>
																</tr>
																<!--end::Row-->
                                                                @if($contract->project_id)
																<!--begin::Row-->
																<tr>
																	<td class="text-gray-600">{{ __('general.project') }}</td>
																	<td class="text-gray-800 fw-bold">{{__getProjectSubjectById($contract->project_id) }}</td>
																</tr>
																<!--end::Row-->
                                                                @endif
                                                                @if($contract->client_id)
                                                                <!--begin::Row-->
																<tr>
																	<td class="text-gray-600">{{ __('general.client') }}</td>
																	<td class="text-gray-800 fw-bold">{{__getClientNameById($contract->client_id) }}</td>
																</tr>
																<!--end::Row-->
                                                                @endif
                                                                @if($contract->client_name)
                                                                <!--begin::Row-->
																<tr>
																	<td class="text-gray-600">{{ __('general.client_name') }}</td>
																	<td class="text-gray-800 fw-bold">{{$contract->client_name}}</td>
																</tr>
																<!--end::Row-->
                                                                @endif
                                                                <!--begin::Row-->
																<tr>
																	<td class="text-gray-600">{{ __('general.sale_agent') }}</td>
																	<td class="text-gray-800 fw-bold">{{__getUserNameById($contract->sale_agent)}}</td>
																</tr>
																<!--end::Row-->
                                                                
                                                                <!--begin::Row-->
																<tr>
																	<td class="text-gray-600">{{ __('general.signature') }}</td>
																	<td class="text-gray-800 fw-bold">{{$contract->signature}}</td>
																</tr>
																<!--end::Row-->
                                                                <!--begin::Row-->
																<tr>
																	<td class="text-gray-600">{{ __('general.description') }}</td>
																	<td class="text-gray-800 fw-bold">{{$contract->description}}</td>
																</tr>
																<!--end::Row-->
															</table>
															<!--end::Details-->
														</div>
														<!--end::Row-->
													</div>
													<!--end::Row-->
												</div>
												<!--end::Section-->
											</div>
											<!--end::Card body-->
										</div>
										<!--end::Card-->
										<!--begin::files-->
                                        <div class="card pt-4 mb-6 mb-xl-9">
                                            <!--begin::Card header-->
                                            <div class="card-header border-0">
                                                <!--begin::Card title-->
                                                <div class="card-title">
                                                    <h2>{{ __('general.contract_files') }}</h2>
                                                </div>
                                                <!--end::Card title-->
                                            
												@hasAccess('contract','modify')
                                                <!--begin::Card toolbar-->
                                                <div class="card-toolbar">
                                                    <div class="d-flex align-items-center gap-2 gap-lg-3">
														@include('common.file.upload_file', ['item' => $contract , 'category' => 'contract'])
                                                        <a href="#" class="btn btn-flex btn-primary h-40px fs-7 fw-bold" data-bs-toggle="modal" data-bs-target="#kt_modal_new_target_upload_file" data-category="contract">{{ __('general.upload_new_file') }}</a>
                                                    </div>
                                                </div>
                                                <!--end::Card toolbar-->
												@endhasAccess
                                            </div>
                                            <!--end::Card header-->
                                            <!--begin::Card body-->
                                            <div class="card-body pt-0 pb-5">
                                                <!--begin::Table-->
                                                <table class="table align-middle table-row-dashed kt-datatable gy-3"
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
                                                            <td>
                                                                {{ $file->id }}</a>
                                                            </td>
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
																	@hasAccess('contract','modify')
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
                                        <!--end::files-->
										<!--begin::reminders-->
                                        <div class="card pt-4 mb-6 mb-xl-9">
                                            <!--begin::Card header-->
                                            <div class="card-header border-0">
                                                <!--begin::Card title-->
                                                <div class="card-title">
                                                    <h2>{{ __('general.contract_reminders') }}</h2>
                                                </div>
                                                <!--end::Card title-->
                                            
                                                <!--begin::Card toolbar-->
                                                <div class="card-toolbar">
                                                    <div class="d-flex align-items-center gap-2 gap-lg-3">
														@include('reminder.create',['item' => $contract] )
                                                        <a href="#" class="btn btn-flex btn-primary h-40px fs-7 fw-bold" data-bs-toggle="modal" data-bs-target="#kt_modal_new_target_create_reminder">{{ __('general.create_new_reminder') }}</a>
                                                    </div>
                                                </div>
                                                <!--end::Card toolbar-->
                                            </div>
                                            <!--end::Card header-->
                                            <!--begin::Card body-->
                                            <div class="card-body pt-0 pb-5">
                                                <!--begin::Table-->
                                                 <table class="table align-middle table-row-dashed kt-datatable gy-3"
        										    id="reminders_table">
        										    <thead class="border-bottom border-gray-200 fs-7 fw-bold">
        										        <tr class="text-muted text-uppercase gs-0">
        										            <th class="text-start min-w-50px">#</th>
        										            <th class="text-start min-w-100px">{{ __('general.subject') }}</th>
        										            <th class="text-start">{{ __('general.date') }}</th>
        										            <th class="text-start">{{ __('general.status') }}</th>
        										            <th class="text-start min-w-100px">{{ __('general.created_at') }}</th>
        										            <th class="text-end min-w-100px pe-4">{{ __('general.actions') }}</th>
        										        </tr>
        										    </thead>
        										    <tbody class="fs-6 fw-semibold text-gray-800">
        										        @foreach($reminders as $reminder)
													
        										        @include('reminder.show', ['reminder' => $reminder, 'modalId' => "kt_modal_new_target_reminder_show_{$reminder->id}"])
        										        @include('reminder.edit', ['reminder' => $reminder, 'modalId' => "kt_modal_new_target_reminder_edit_{$reminder->id}"])
													
        										        <tr>
        										            <td>
        										                {{ $reminder->id }}</a>
        										            </td>
        										            <td class="text-start"><a href="#" class="text-gray-800 text-hover-primary mb-1" data-bs-toggle="modal" data-bs-target="#kt_modal_new_target_reminder_show_{{ $reminder->id }}">{{$reminder->subject}}</a></td>
        										            <td class="text-start">{{ $reminder->date }}</td>
        										            <td class="text-start">
        										                <div class="badge 
																	{{ $reminder->status === 'pending' ? 'badge-light-primary' : '' }}
																	{{ $reminder->status === 'completed' ? 'badge-light-success' : '' }}
																	{{ $reminder->status === 'passed' ? 'badge-light-danger' : '' }}">
																	{{ __('general.' . $reminder->status) }}
																</div>
        										            </td>
        										            <td class="text-start">{{ $reminder->created_at }}</td>
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
																    	<a href="#" data-bs-toggle="modal" data-bs-target="#kt_modal_new_target_reminder_show_{{ $reminder->id }}"
																    		class="menu-link px-3">{{ __('general.view') }}</a>
																    </div>
																    <!--end::Menu item-->
																    <!--begin::Menu item-->
																    <div class="menu-item px-3">
																    	<a href="#" data-bs-toggle="modal" data-bs-target="#kt_modal_new_target_reminder_edit_{{ $reminder->id }}"
																    		class="menu-link px-3">{{ __('general.edit') }}</a>
																    </div>
																    <!--end::Menu item-->
																    <!--begin::Menu item-->
																    <div class="menu-item px-3">
        										                        <form id="delete-form-{{ $reminder->id }}" action="{{ route('reminders.destroy', $reminder->id) }}" method="POST">
																    		@csrf
																    		@method('DELETE')
																    		<div class="menu-item">
																    			<button type="button" onclick="showConfirmation('{{ addslashes($reminder->message) }}', '{{ $reminder->id }}');" class="dropdown-item menu-link fw-bold text-danger">{{ __('general.delete') }}</button>
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
                                        <!--end::reminders-->
									</div>
									<!--end::Content-->

									
								</div>
								<!--end::Layout-->
							</div>
							<!--end::Content container-->
						</div>
						<!--end::Content-->
					</div>
					<!--end::Content wrapper-->
					<!--begin::Footer-->
					@include('layout._footer')
					<!--end::Footer-->
				</div>
				<!--end:::Main-->
				<!--begin::aside-->
				@include('layout._side_shortcuts')
				<!--end::aside-->
			</div>
			<!--end::Wrapper-->
		</div>
		<!--end::Page-->
	</div>
	<!--end::App-->

	@include('layout._scroll_top')
	
	<!--begin::Javascript-->
	@include('assets._main_scripts')
	@include('assets._data_table_scripts')
	@include('assets._file_scripts')



	<!--begin::Custom Javascript(used for this page only)-->
	{{-- <script src="{{ asset('assets/js/custom/apps/ecommerce/reports/shipping/shipping.js') }}"></script>
	<script src="{{ asset('assets/js/widgets.bundle.js') }}"></script>
	<script src="{{ asset('assets/js/custom/widgets.js') }}"></script>
	<script src="{{ asset('assets/js/custom/apps/chat/chat.js') }}"></script>
	<script src="{{ asset('assets/js/custom/utilities/modals/upgrade-plan.js') }}"></script>
	<script src="{{ asset('assets/js/custom/utilities/modals/create-campaign.js') }}"></script>
	<script src="{{ asset('assets/js/custom/utilities/modals/users-search.js') }}"></script> --}}
	<!--end::Custom Javascript-->



	<!--end::Javascript-->
</body>
<!--end::Body-->

</html>