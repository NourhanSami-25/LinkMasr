<!DOCTYPE html>
@if (app()->getLocale() == 'ar')
	@include('assets._language_ar')
@else
	@include('assets._language_en')
@endif

<head>
	<title>Link Masr | @yield('title', 'Dashboard')</title>
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

	@yield('styles')
</head>

<body id="kt_app_body" data-kt-app-header-fixed="true" data-kt-app-header-fixed-mobile="true"
	data-kt-app-sidebar-enabled="true" data-kt-app-sidebar-fixed="true" data-kt-app-sidebar-hoverable="true"
	data-kt-app-sidebar-push-toolbar="true" data-kt-app-sidebar-push-footer="true" data-kt-app-toolbar-enabled="true"
	data-kt-app-aside-enabled="true" data-kt-app-aside-fixed="true" data-kt-app-aside-push-toolbar="true"
	data-kt-app-aside-push-footer="true" class="app-default" data-kt-app-sidebar-minimize="on">
	
	@include('assets.dark_mode')
	
	<div class="d-flex flex-column flex-root app-root" id="kt_app_root">
		<div class="app-page flex-column flex-column-fluid" id="kt_app_page">
			@include('layout._header')
			
			<div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">
				@include('layout._side_bar')
				
				<div class="app-main flex-column flex-row-fluid" id="kt_app_main">
					<div class="d-flex flex-column flex-column-fluid">
						<div id="kt_app_toolbar" class="app-toolbar pt-6 pb-2">
							<div id="kt_app_toolbar_container" class="app-container container-fluid d-flex align-items-stretch">
								<div class="app-toolbar-wrapper d-flex flex-stack flex-wrap gap-4 w-100">
									<div class="page-title d-flex flex-column justify-content-center gap-1 me-3">
										<h1 class="page-heading d-flex flex-column justify-content-center text-gray-900 fw-bold fs-1 m-0">
											@yield('title')
										</h1>
										<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0">
											<li class="breadcrumb-item text-muted">
												<a href="{{ route('home') }}" class="text-muted text-hover-primary">{{ __('general.home') ?? 'Home' }}</a>
											</li>
											@yield('breadcrumb')
										</ul>
									</div>
									<div class="d-flex align-items-center gap-2 gap-lg-3">
										@yield('actions')
									</div>
								</div>
							</div>
						</div>
						
						<div id="kt_app_content" class="app-content flex-column-fluid">
							<div id="kt_app_content_container" class="app-container container-fluid">
								@include('layout._response_message')
								@yield('content')
							</div>
						</div>
					</div>
					
					@include('layout._footer')
				</div>
				
				@include('layout._side_shortcuts')
			</div>
		</div>
	</div>
	
	@include('layout._scroll_top')
	@include('assets._main_scripts')
	@include('assets._form_scripts')
	@include('assets._data_table_scripts')
	
	@yield('scripts')
</body>
</html>
