<!DOCTYPE html>

@if (app()->getLocale() == 'ar')
	@include('assets._language_ar')
@else
	@include('assets._language_en')
@endif

<head>

	<title>Link Masr | Task Details</title>
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
	<!--begin::Theme mode setup on page load-->
	
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
											{{ __('general.task_details') }}</h1>
										<!--end::Title-->
										<!--begin::Breadcrumb-->
										<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0">
											<!--begin::Item-->
											
											<li class="breadcrumb-item text-muted">
												<a href="#" class="text-muted text-hover-primary">{{ __('general.home') }}</a>
											</li>
											<!--end::Item-->
											<!--begin::Item-->
											<li class="breadcrumb-item">
												<span class="bullet bg-gray-500 w-5px h-2px"></span>
											</li>
											<!--end::Item-->
											<!--begin::Item-->
											<li class="breadcrumb-item text-muted">
												<a href="{{ route('tasks.index')}}" class="text-muted text-hover-primary">{{ __('general.tasks') }}</a>
											</li>
											<!--end::Item-->
											<!--begin::Item-->
											<li class="breadcrumb-item">
												<span class="bullet bg-gray-500 w-5px h-2px"></span>
											</li>
											<!--end::Item-->
											<!--begin::Item-->
											<li class="breadcrumb-item text-muted">{{ __('general.task_details') }}</li>
											<!--end::Item-->
										</ul>
										<!--end::Breadcrumb-->
									</div>
									<!--end::Page title-->
									<!--begin::Actions-->
									<div class="d-flex align-items-center gap-2 gap-lg-3">
										<!--begin::Action menu-->
										<a href="#" class="btn btn-primary ps-7" data-kt-menu-trigger="click"
										data-kt-menu-attach="parent"
										data-kt-menu-placement="bottom-end">{{ __('general.actions') }}
										<i class="ki-outline ki-down fs-2 me-0"></i></a>
										<a href="{{ route('tasks.index')}}" class="btn btn-danger ps-7">{{ __('general.back') }}</a>
										<!--begin::Menu-->
										<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold py-4 w-250px fs-6"
										data-kt-menu="true">
										<!--begin::Menu item-->
										{{-- <div class="menu-item px-5">
											<a href="#" class="menu-link px-5">{{ __('general.invoice_task') }}</a>
										</div> --}}
										<!--end::Menu item-->
										{{-- <!--begin::Menu item-->
										<div class="menu-item px-5">
											<a href="#" data-bs-toggle="modal" data-bs-target="#kt_modal_new_target_update_status" class="menu-link flex-stack px-5">{{ __('general.update_status') }}
												<span class="ms-2" data-bs-toggle="tooltip"
													title="Specify a target name for future usage and reference">
												</span></a>
										</div>
										<!--end::Menu item--> --}}
										
										{{-- <!--begin::Menu separator-->
										<div class="separator my-3"></div>
										<!--end::Menu separator--> --}}
										<!--begin::Menu item-->
										<div class="menu-item px-5">
											<a href="#" class="menu-link px-5">{{ __('general.print') }}</a>
										</div>
										<!--end::Menu item-->
										<!--begin::Menu item-->
										<div class="menu-item px-5">
											<a href="#" class="menu-link px-5">{{ __('general.download') }}</a>
										</div>
										<!--end::Menu item-->
										<!--begin::Menu item-->
										<div class="menu-item px-5">
											<a href="{{route('tasks.edit' , $task->id)}}" class="menu-link px-5">{{ __('general.edit') }}</a>
										</div>
										<!--end::Menu item-->
										<!--begin::Menu item-->
										<div class="menu-item px-5 my-1">
											<a href="#" class="menu-link px-5">{{ __('general.delete') }}</a>
										</div>
										<!--end::Menu item-->
									</div>
									<!--end::Menu-->
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
									{{-- @include('task._show_sidebar') --}}
									<!--end::Sidebar-->
									<!--begin::Content-->
									<div class="flex-lg-row-fluid">
										<!--begin:::Tabs-->
										<ul
											class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-6 fw-semibold mb-5">
											<!--begin:::Tab item-->
											<li class="nav-item">
												<a class="nav-link text-active-primary text-gray-900 pb-4 active" data-bs-toggle="tab"
													href="#kt_customer_view_overview_tab">{{ __('general.overview') }}</a>
											</li>
											<!--end:::Tab item-->
											<li class="nav-item">
												<a class="nav-link text-active-primary text-gray-900 pb-4" data-kt-countup-tabs="true"
												   data-bs-toggle="tab"
												   href="#kt_task_view_discussion">{{ __('general.discussion') }}</a>
											</li>
											<!--end:::Tab item-->
											<li class="nav-item">
												<a class="nav-link text-active-primary text-gray-900 pb-4" data-bs-toggle="tab"
													href="#kt_task_view_files">{{ __('general.files') }}</a>
											</li>
											<!--end:::Tab item-->
											<li class="nav-item">
												<a class="nav-link text-active-primary text-gray-900 pb-4" data-kt-countup-tabs="true"
													data-bs-toggle="tab"
													href="#kt_task_view_notes">{{ __('general.notes') }}</a>
											</li>
											<!--end:::Tab item-->
											<li class="nav-item">
												<a class="nav-link text-active-primary text-gray-900 pb-4" data-bs-toggle="tab"
													href="#kt_customer_view_reminders">{{ __('general.reminders') }}</a>
											</li>
											<!--end:::Tab item-->
										</ul>
										<!--end:::Tabs-->
										<!--begin:::Tab content-->
										<div class="tab-content" id="myTabContent">
											<!--begin:::Tab pane-->
											@include('task._show_overview')
											<!--end:::Tab pane-->
											<!--begin:::Tab pane-->
											@include('task._show_files')
											<!--end:::Tab pane-->
											<!--begin:::Tab pane-->
											@include('task._show_reminders')
											<!--end:::Tab pane-->
											<!--begin:::Tab pane-->
											@include('task._show_notes')
											<!--end:::Tab pane-->
											<!--begin:::Tab pane-->
											<div class="tab-pane fade" id="kt_task_view_discussion" role="tabpanel">
												@include('common.discussion.index', ['discussion' => $task->discussion])
											</div>
											<!--end:::Tab pane-->
										</div>
										<!--end:::Tab content-->
									</div>
									<!--end::Content-->
								</div>
								<!--end::Layout-->
								<!--begin::Modals-->
								@include('task._update_status')
								{{-- @include('task._show_modals') --}}
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
	
	<!--begin::Scrolltop-->
	@include('layout._scroll_top')
	<!--end::Scrolltop-->
	
	<!--begin::Javascript-->
	@include('assets._main_scripts')
	@include('assets._form_scripts')
	@include('assets._data_table_scripts')
	@include('assets._file_scripts')
	@include('assets._discussion_scripts')
	@include('assets._taps_script')
	<!--end::Javascript-->

	
</body>
<!--end::Body-->
</html>