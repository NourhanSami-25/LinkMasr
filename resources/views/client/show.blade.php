<!DOCTYPE html>

@if (app()->getLocale() == 'ar')
	@include('assets._language_ar')
@else
	@include('assets._language_en')
@endif

<head>

	<title>Link Masr | Client Profile</title>
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
	<!--begin::Theme mode setup on page load-->

	@php
    	$companyProfile = cache('company_profile');
	@endphp
	
	<!--end::Theme mode setup on page load-->
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
											{{ __('general.client_profile') }} </h1>
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
												<a href="{{ route('clients.index')}}" class="text-muted text-hover-primary">{{ __('general.clients') }}</a>
											</li>
											<!--end::Item-->
											<!--begin::Item-->
											<li class="breadcrumb-item">
												<span class="bullet bg-gray-500 w-5px h-2px"></span>
											</li>
											<!--end::Item-->
											<!--begin::Item-->
											<li class="breadcrumb-item text-muted">{{ __('general.client_profile') }}</li>
											<!--end::Item-->
										</ul>
										<!--end::Breadcrumb-->
									</div>
									<!--end::Page title-->
									<!--begin::Actions-->
									<div class="d-flex align-items-center gap-2 gap-lg-3">
										@hasAccess('client','modify')
										@if($client->status == 'active')
											<a href="{{route('clients.disable' , $client->id)}}" class="btn btn-flex btn-warning h-40px fs-7 fw-bold">{{ __('general.disable_client') }}</a>
										@elseif($client->status == 'disabled')
											<a href="{{route('clients.activate' , $client->id)}}" class="btn btn-flex btn-primary h-40px fs-7 fw-bold">{{ __('general.activate_client') }}</a>
										@endif
										@endhasAccess
										<a href="{{route('clientStatment', $client->id)}}" class="btn btn-flex btn-primary h-40px fs-7 fw-bold" target="_blank">{{ __('general.client_statment') }}</a>
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
								<div class="d-flex flex-column flex-xl-row">
									<!--begin::Sidebar-->
									@include('client._show_sidebar')
									<!--end::Sidebar-->
									<!--begin::Content-->
									<div class="flex-lg-row-fluid ms-lg-12">
										<!--begin:::Tabs-->
										<ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-x border-0 fs-6 fw-semibold mb-8">

											<li class="nav-item">
            								    <!--begin::Group Title-->
            								    <a href="#kt_customer_view_overview_tab" class="nav-link btn btn-flex btn-light ps-7 active" data-bs-toggle="tab">
            								        {{ __('general.overview') }}
												</a>
												<!--end::Group Title-->
            								</li>
											
											<li class="nav-item ms-auto">
            								    <!--begin::Group Title-->
            								    <a href="#" class="btn btn-flex btn-light ps-7" data-kt-menu-trigger="click" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
            								        {{ __('general.finance') }}<i class="ki-outline ki-down fs-2 me-0"></i>
												</a>
												<!--end::Group Title-->
            								    <!--begin::Menu-->
												<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold py-4 w-250px fs-6" data-kt-menu="true" style="">
												    <!--begin::Menu item-->
												    <div class="menu-item px-5">
												        <a href="#kt_customer_view_invoices" class="menu-link px-5" data-bs-toggle="tab">
												            {{ __('general.invoices') }} ({{ $invoiceCount }})
												        </a>
												    </div>
												    <!--end::Menu item-->
													 <!--begin::Menu item-->
												    <div class="menu-item px-5">
												        <a href="#kt_customer_view_pyments" class="menu-link px-5" data-bs-toggle="tab">
												            {{ __('general.payments') }} ({{ $paymentsCount }})
												        </a>
												    </div>
												    <!--end::Menu item-->
													 <!--begin::Menu item-->
												    <div class="menu-item px-5">
												        <a href="#kt_customer_view_paymentrequests" class="menu-link px-5" data-bs-toggle="tab">
												            {{ __('general.paymentRequests') }} ({{ $paymentRequestsCount }})
												        </a>
												    </div>
												    <!--end::Menu item-->
													 <!--begin::Menu item-->
												    <div class="menu-item px-5">
												        <a href="#kt_customer_view_creditnotes" class="menu-link px-5" data-bs-toggle="tab">
												            {{ __('general.creditNotes') }} ({{ $creditNotesCount }})
												        </a>
												    </div>
												    <!--end::Menu item-->
													 <!--begin::Menu item-->
												    <div class="menu-item px-5">
												        <a href="#kt_customer_view_expenses" class="menu-link px-5" data-bs-toggle="tab">
												            {{ __('general.expenses') }} ({{ $expensesCount }})
												        </a>
												    </div>
												    <!--end::Menu item-->
												</div>
												<!--end::Menu-->
            								</li>

											<li class="nav-item ms-auto">
            								    <!--begin::Group Title-->
            								    <a href="#" class="btn btn-flex btn-light ps-7" data-kt-menu-trigger="click" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
            								        {{ __('general.contracts&proposals') }}<i class="ki-outline ki-down fs-2 me-0"></i>
												</a>
												<!--end::Group Title-->
            								    <!--begin::Menu-->
												<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold py-4 w-250px fs-6" data-kt-menu="true" style="">
												    <!--begin::Menu item-->
												    <div class="menu-item px-5">
												        <a href="#kt_customer_view_contracts" class="menu-link px-5" data-bs-toggle="tab">
												            {{ __('general.contracts') }} ({{ $contractsCount }})
												        </a>
												    </div>
												    <!--end::Menu item-->
													 <!--begin::Menu item-->
												    <div class="menu-item px-5">
												        <a href="#kt_customer_view_proposals" class="menu-link px-5" data-bs-toggle="tab">
												            {{ __('general.proposals') }} ({{ $proposalsCount }})
												        </a>
												    </div>
												    <!--end::Menu item-->
												</div>
												<!--end::Menu-->
            								</li>

											<li class="nav-item ms-auto">
            								    <!--begin::Group Title-->
            								    <a href="#" class="btn btn-flex btn-light ps-7" data-kt-menu-trigger="click" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
            								        {{ __('general.tasks&projects') }}<i class="ki-outline ki-down fs-2 me-0"></i>
												</a>
												<!--end::Group Title-->
            								    <!--begin::Menu-->
												<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold py-4 w-250px fs-6" data-kt-menu="true" style="">
												    <!--begin::Menu item-->
												    <div class="menu-item px-5">
												        <a href="#kt_customer_view_projects" class="menu-link px-5" data-bs-toggle="tab">
												            {{ __('general.projects') }} ({{ $projectsCount }})
												        </a>
												    </div>
												    <!--end::Menu item-->
													<!--begin::Menu item-->
												    <div class="menu-item px-5">
												        <a href="#kt_customer_view_tasks" class="menu-link px-5" data-bs-toggle="tab">
												            {{ __('general.tasks') }} ({{ $tasksCount }})
												        </a>
												    </div>
												    <!--end::Menu item-->
													
												</div>
												<!--end::Menu-->
            								</li>

											<li class="nav-item ms-auto">
            								    <!--begin::Group Title-->
            								    <a href="#" class="btn btn-flex btn-light ps-7" data-kt-menu-trigger="click" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
            								        {{ __('general.files') }}<i class="ki-outline ki-down fs-2 me-0"></i>
												</a>
												<!--end::Group Title-->
            								    <!--begin::Menu-->
												<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold py-4 w-250px fs-6" data-kt-menu="true" style="">
												    <!--begin::Menu item-->
												    <div class="menu-item px-5">
												        <a href="#kt_customer_view_poa" class="menu-link px-5" data-bs-toggle="tab">
												            {{ __('general.poa') }} ({{ $poaCount }})
												        </a>
												    </div>
												    <!--end::Menu item-->
													<!--begin::Menu item-->
												    <div class="menu-item px-5">
												        <a href="#kt_customer_view_id" class="menu-link px-5" data-bs-toggle="tab">
												            {{ __('general.id_papers') }} ({{ $idCount }})
												        </a>
												    </div>
												    <!--end::Menu item-->
													<!--begin::Menu item-->
												    <div class="menu-item px-5">
												        <a href="#kt_customer_view_ipan" class="menu-link px-5" data-bs-toggle="tab">
												            {{ __('general.ipan_number') }} ({{ $ipanCount }})
												        </a>
												    </div>
												    <!--end::Menu item-->
													<!--begin::Menu item-->
												    <div class="menu-item px-5">
												        <a href="#kt_customer_view_files" class="menu-link px-5" data-bs-toggle="tab">
												            {{ __('general.all_files') }} ({{ $filesCount }})
												        </a>
												    </div>
												    <!--end::Menu item-->
												</div>
												<!--end::Menu-->
            								</li>

											<li class="nav-item ms-auto">
            								    <!--begin::Group Title-->
            								    <a href="#" class="btn btn-flex btn-light ps-7" data-kt-menu-trigger="click" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
            								        {{ __('general.other') }}<i class="ki-outline ki-down fs-2 me-0"></i>
												</a>
												<!--end::Group Title-->
            								    <!--begin::Menu-->
												<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold py-4 w-250px fs-6" data-kt-menu="true" style="">
												    <!--begin::Menu item-->
												    <div class="menu-item px-5">
												        <a href="#kt_customer_view_contacts" class="menu-link px-5" data-bs-toggle="tab">
												            {{ __('general.contacts') }} ({{ $contactsCount }})
												        </a>
												    </div>
												    <!--end::Menu item-->
													<!--begin::Menu item-->
												    <div class="menu-item px-5">
												        <a href="#kt_customer_view_notes" class="menu-link px-5" data-bs-toggle="tab">
												            {{ __('general.notes') }} ({{ $notesCount }})
												        </a>
												    </div>
												    <!--end::Menu item-->
												</div>
												<!--end::Menu-->
            								</li>
										</ul>
										<!--end:::Tabs-->

										<!--begin:::Tab content-->
										<div class="tab-content" id="myTabContent">
											<!--begin:::Tab pane-->
											@include('client._show_overview')
											<!--end:::Tab pane-->
											<!--begin:::Tab pane-->
											@include('client._show_invoices')
											<!--end:::Tab pane-->
											<!--begin:::Tab pane-->
											@include('client._show_payments')
											<!--end:::Tab pane-->
											<!--begin:::Tab pane-->
											@include('client._show_paymentRequests')
											<!--end:::Tab pane-->
											<!--begin:::Tab pane-->
											@include('client._show_creditNotes')
											<!--end:::Tab pane-->
											<!--begin:::Tab pane-->
											@include('client._show_expenses')
											<!--end:::Tab pane-->
											<!--begin:::Tab pane-->
											@include('client._show_contracts')
											<!--end:::Tab pane-->
											<!--begin:::Tab pane-->
											@include('client._show_proposals')
											<!--end:::Tab pane-->
											<!--begin:::Tab pane-->
											@include('client._show_projects')
											<!--end:::Tab pane-->
											<!--begin:::Tab pane-->
											@include('client._show_tasks')
											<!--end:::Tab pane-->
											<!--begin:::Tab pane-->
											@include('client._show_poa')
											<!--end:::Tab pane-->
											<!--begin:::Tab pane-->
											@include('client._show_id')
											<!--end:::Tab pane-->
											<!--begin:::Tab pane-->
											@include('client._show_ipan')
											<!--end:::Tab pane-->
											<!--begin:::Tab pane-->
											@include('client._show_files')
											<!--end:::Tab pane-->
											<!--begin:::Tab pane-->
											@include('client._show_contacts')
											<!--end:::Tab pane-->
											<!--begin:::Tab pane-->
											@include('client._show_notes')
											<!--end:::Tab pane-->
										</div>
										<!--end:::Tab content-->
									</div>
									<!--end::Content-->
								</div>
								<!--end::Layout-->
								<!--begin::Modals-->
								@include('client._show_modals')
								<!--end::Modals-->
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

	@include('client._create_billing_address', ['client_id' => $client->id])
	@include('client._create_address', ['client_id' => $client->id])
	@include('common.file.upload_file', ['item' => $client])



	<!--begin::Scrolltop-->
	@include('layout._scroll_top')
	<!--end::Scrolltop-->
	
	<!--begin::Javascript-->
	@include('assets._main_scripts')
	@include('assets._form_scripts')
	<!--begin::Vendors Javascript(used for this page only)-->
	@include('assets._data_table_scripts')
	@include('assets._file_scripts')
	@include('assets._taps_script')
	<!--end::Vendors Javascript-->
	<!--end::Javascript-->

	

</body>
<!--end::Body-->
</html>