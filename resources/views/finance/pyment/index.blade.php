<!DOCTYPE html>

@if (app()->getLocale() == 'ar')
	@include('assets._language_ar')
@else
	@include('assets._language_en')
@endif

<head>

	<title>Link Masr | Payments</title>
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
	


	<!--begin::Custom Styles-->
	
	<!--end::Custom Styles-->

	

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
											{{ __('general.all_payments') }} </h1>
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
												<a href="{{ route('pyments.index')}}" class="text-muted text-hover-primary">{{ __('general.payments') }}</a>
											</li>
											<!--end::Item-->
											<!--begin::Item-->
											<li class="breadcrumb-item">
												<span class="bullet bg-gray-500 w-5px h-2px"></span>
											</li>
											<!--end::Item-->
											<!--begin::Item-->
											<li class="breadcrumb-item text-muted">
												<a href="{{ route('pyments.index')}}" class="text-muted text-hover-primary">{{ __('general.payments') }}</a>
											</li>
											<!--end::Item-->
										</ul>
										<!--end::Breadcrumb-->
									</div>
									<!--end::Page title-->
									
									<!--begin::Actions-->
									<div class="d-flex align-items-center gap-2 gap-lg-3">
										@hasAccess('finance','create')
										{{-- <a href="{{route('pyments.create')}}"
											class="btn btn-flex btn-primary h-40px fs-7 fw-bold">{{ __('general.create_new') }}</a> --}}
										@endhasAccess
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
								<!--begin::Pyments-->
								<div class="card card-flush">
									<!--begin::Card header-->
									<div class="card-header align-items-center py-5 gap-2 gap-md-5">
										<!--begin::Card title-->
										<div class="card-title">
											<!--begin::Search-->
											<div class="d-flex align-items-center position-relative my-1">
												<i class="ki-outline ki-magnifier fs-3 position-absolute ms-4"></i>
												<input type="text" data-kt-table="pyments_table" data-kt-filter="search"
													class="form-control form-control-solid w-250px ps-12"
													placeholder="{{ __('general.search_keyword') }}" />
											</div>
											<!--end::Search-->
											<!--begin::Export buttons-->
											<div id="pyments_table_export" class="d-none"></div>
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
													data-kt-table="pyments_table" data-kt-filter="status">
													<option></option>
													<option value="all">{{ __('general.all') }}</option>
													<option value="{{ __('general.paid') }}">{{ __('general.paid') }}</option>													
													<option value="{{ __('general.paid') }}">{{ __('general.draft') }}</option>													
												</select>
												<!--end::Select2-->
											</div>
											<!--end::Filter-->
											<!--begin::Export dropdown-->
											<button type="button" class="btn btn-light-primary"
												data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
												<i class="ki-outline ki-exit-up fs-2"></i>{{ __('general.export') }}</button>
											<!--begin::Menu-->
											<div id="pyments_table_export_menu"
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
											<!--end::Menu-->
											<!--end::Export dropdown-->
										</div>
										<!--end::Card toolbar-->
									</div>
									<!--end::Card header-->
									<!--begin::Card body-->
									<div class="card-body pt-0">
										<!--begin::Table-->
										<table class="table table-hover align-middle table-row-dashed fs-6 kt-datatable gy-2"
											id="pyments_table">
											<thead>
												<tr class=" text-gray-500 fw-bold fs-7 text-uppercase gs-0">
													<th class="text-start min-w-50px">#</th>
													<th class="text-start min-w-50px">{{ __('general.number') }}</th>
													<th class="text-start min-w-150px">{{ __('general.client') }}</th>
													<th class="text-start min-w-100px">{{ __('general.status') }}</th>
													<th class="text-start min-w-100px">{{ __('general.total') }}</th>
													<th class="text-start min-w-100px">{{ __('general.currency') }}</th>
													<th class="text-start min-w-100px">{{ __('general.date') }}</th>
													<th class="text-start min-w-100px">{{ __('general.related_with') }}</th>
													<th class="text-end min-w-100px">{{ __('general.actions') }}</th>
												</tr>
											</thead>
											<tbody class="fw-semibold text-gray-800">
												@foreach($pyments as $pyment)
												<tr>
													<td class="text-start">{{$pyment->id}}</td>
													<td class="text-start">
														@hasAccess('finance','details')
														<a href="{{route('pyments.show' , $pyment->id)}}" class="text-primary-900 text-hover-primary">
														@endhasAccess
															{{$pyment->number}}</a>
													</td>
													<td class="text-start">{{$pyment->client_name}}</td>
													<td class="text-start">
														<div class="badge 
															{{ $pyment->status === 'paid' ? 'badge-light-success' : '' }}
															{{ $pyment->status === 'draft' ? 'badge-light-primary' : '' }}">
															{{ __('general.' . $pyment->status) }}
														</div>
													</td>		
													<td class="text-start">{{$pyment->total}}</td>
													<td class="text-start">{{$pyment->currency}}</td>
													<td class="text-start">{{date('Y-m-d', strtotime($pyment->date))}}</td>
													<td class="text-start">{{$pyment->related}} 
														@if($pyment->related == 'invoice')
													    #{{ optional($pyment->invoice)->number }}
														@elseif($pyment->related == 'creditNote')
														   #{{ optional($pyment->creditNote)->number }}
														@elseif($pyment->related == 'paymentRequest')
														   #{{ optional($pyment->pymentRequest)->number }}
														@elseif($pyment->related == 'expense')
														   #{{ optional($pyment->expense)->number }}
														@endif
													</td>
													
													<td class="text-end">
														<a href="#"
															class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary"
															data-kt-menu-trigger="click"
															data-kt-menu-placement="bottom-end">{{ __('general.actions') }}
															<i class="ki-outline ki-down fs-5 ms-1"></i></a>
														<!--begin::Menu-->
														<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-200px py-4"
															data-kt-menu="true">
															@hasAccess('finance','details')
															<!--begin::Menu item-->
															<div class="menu-item px-3">
																<a href="{{route('pyments.show', $pyment->id)}}"
																	class="menu-link px-3">{{ __('general.view') }}</a>
															</div>
															<!--end::Menu item-->
															<!--end::Menu item-->
															@endhasAccess
															@hasAccess('finance','modify')
															<!--begin::Menu item-->
															<div class="menu-item px-3">
																<a href="{{route('pyments.edit', $pyment->id)}}"
																	class="menu-link px-3">{{ __('general.edit') }}</a>
															</div>
															<!--end::Menu item-->
															@endhasAccess
															@hasAccess('finance','delete')
															{{-- <!--begin::Menu item-->
															<div class="menu-item px-3">
																<form id="delete-form-{{ $pyment->id }}" action="{{ route('pyments.destroy', $pyment->id) }}" method="POST">
																	@csrf
																	@method('DELETE')
																	<div class="menu-item">
																		<button type="button" onclick="showConfirmation('{{ addslashes($pyment->subject) }}', '{{ $pyment->id }}');" class="dropdown-item menu-link fw-bold text-danger">{{ __('general.delete') }}</button>
																	</div>
																</form>
															</div>
															<!--end::Menu item--> --}}
															@endhasAccess
														</div>
														<!--end::Menu-->
													</td>
												</tr>
												@endforeach
											</tbody>
										</table>
										<!--end::Table-->
									</div>
									<!--end::Card body-->
								</div>
								<!--end::Pyments-->
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

	<script>
    	document.addEventListener('DOMContentLoaded', function () {
    	    const table = document.querySelector('#pyments_table');
    	    if (table) {
    	        $(table).DataTable({
					order: [[0, 'desc']], // 👈 sort by first column descending
    	            pageLength: 50,
    	            language: {
    	                sInfo: "{{ __('general.datatable_info') }}",
    	                sLengthMenu: "{{ __('general.datatable_sLengthMenu') }}",
    	                sSearch: "{{ __('general.datatable_sSearch') }}",
    	                sZeroRecords: "{{ __('general.datatable_sZeroRecords') }}",
    	                sInfoEmpty: "{{ __('general.datatable_sInfoEmpty') }}",
    	                sInfoFiltered: "{{ __('general.datatable_sInfoFiltered') }}",
    	                paginate: {
    	                    sFirst: "{{ __('general.datatable_sFirst') }}",
    	                    sPrevious: "{{ __('general.datatable_sPrevious') }}",
    	                    sNext: "{{ __('general.datatable_sNext') }}",
    	                    sLast: "{{ __('general.datatable_sLast') }}"
    	                }
    	            }
    	        });
    	    }
    	});
    </script>

	<!--begin::Javascript-->
	@include('assets._main_scripts')
	@include('assets._data_table_scripts')
	<!--end::Javascript-->
</body>
<!--end::Body-->
</html>