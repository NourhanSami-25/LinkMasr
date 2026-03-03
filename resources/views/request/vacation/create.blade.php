<!DOCTYPE html>

@if (app()->getLocale() == 'ar')
	@include('assets._language_ar')
@else
	@include('assets._language_en')
@endif

<head>

	<title>Link Masr | Create Vacation Request</title>
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
											{{ __('general.create_new_vacation_request') }}</h1>
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
											<li class="breadcrumb-item text-muted">{{ __('general.vacation_requests') }}</li>
											<!--end::Item-->
											<!--begin::Item-->
											<li class="breadcrumb-item">
												<span class="bullet bg-gray-500 w-5px h-2px"></span>
											</li>
											<!--end::Item-->
											<!--begin::Item-->
											<li class="breadcrumb-item text-muted">{{ __('general.create') }}</li>
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
								<!--begin::Form-->
								<form action="{{route('vacation-requests.store')}}" method="POST" class="form d-flex flex-column flex-lg-row"
									data-kt-redirect="apps/ecommerce/catalog/products.html" enctype="multipart/form-data">
									@csrf
									<!--begin::Main column-->
									<div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
										<!--begin::Tab content-->
										<div class="tab-content">
											<!--begin::Tab pane-->
											<div class="tab-pane active" id="main_data" role="tab-panel">
												<!--begin::Tab pane - Card Body -->
												<div class="d-flex flex-column gap-7 gap-lg-10 mb-10">
													<!--begin::General options-->
													<div class="card card-flush py-4">
														<!--begin::Card header-->
														<div class="card-header">
															<div class="card-title">
																<h2>{{ __('general.main_data') }}</h2>
															</div>
														</div>
														<!--end::Card header-->
														<!--begin::Card body-->
														<div class="card-body pt-0">
															<!--begin::InpudRow-->
															<div class="d-flex flex-wrap gap-5 mb-5">
																<!--begin::Input group-->
																<div class="fv-row w-100 flex-md-root">
																	<!--begin::Label-->
																	<label class="required form-label">{{ __('general.subject') }}</label>
																	<!--end::Label-->
																	<!--begin::Input-->
																	<input type="text" name="subject" data-label="{{ __('general.subject') }}" class="form-control mb-2" value="{{ old('subject') }}" data-required="true" data-minlength="5" data-maxlength="255"/>
																	<!--end::Input-->
																</div>
																<!--end::Input group-->
																<!--begin::Input group-->
																<div class="fv-row w-100 flex-md-root">
																	<!--begin::Label-->
																	<label class="required form-label">{{ __('general.type') }}</label>
																	<!--end::Label-->
																	<!--begin::Select2-->
																	<select class="form-select mb-2"  id="vacation_type" name="vacation_type" data-label="{{ __('general.type') }}"
																		data-control="select2" data-hide-search="true"
																		data-placeholder="{{ __('general.select_an_option') }}" data-required="true">
																		<option></option>
																		<option value="annual" selected>{{ __('general.annual') }}</option>
																		<option value="sick">{{ __('general.sick') }}</option>
																		<option value="without_pay">{{ __('general.without_pay') }}</option>
																		<option value="maternity">{{ __('general.maternity') }}</option>
																		<option value="compensation">{{ __('general.compensation') }}</option>
																	</select>
																	<!--end::Select2-->
																</div>
																<!--end::Input group-->
															</div>
															<!--end:InpudRow-->
															<!--begin::InpudRow-->
															<div class="mb-5 mt-5">
																<!--begin::Label-->
																<label class="form-label">{{ __('general.description') }}</label>
																<!--end::Label-->
																<!--begin::Editor-->
																<textarea class="form-control mb-2"
																	value="{{ old('description') }}" name="description" data-label="{{ __('general.description') }}" maxlength="1024"></textarea>
																<!--end::Editor-->
																<!--begin::Description-->
																<div class="text-muted fs-7">{{ __('general.optional_message') }}</div>
																<!--end::Description-->
															</div>
															<!--end::InpudRow-->

															<!--begin::InpudRow-->
															<div class="d-flex flex-wrap gap-5 mb-5">
																<!--begin::Input group-->
																<div class="fv-row w-100 flex-md-root">
																	<!--begin::Label-->
																	<label class="form-label">{{ __('general.follower') }}</label>
																	<!--end::Label-->
																	<!--begin::Select2-->
																	<select class="form-select mb-2" name="follower[]" data-label="{{ __('general.follower') }}"
																		data-control="select2"
																		data-placeholder="{{ __('general.select_an_option') }}"  multiple="multiple">
																		<option></option>
																		@foreach($users as $user)
																			<option value="{{$user->id}}">{{$user->name}}</option>
																		@endforeach
																	</select>
																	<!--end::Select2-->
																	<!--begin::Description-->
																	<div class="text-muted fs-7">{{ __('general.optional_message') }}</div>
																	<!--end::Description-->
																</div>
																<!--end::Input group-->
																<!--begin::Input group-->
																<div class="fv-row w-100 flex-md-root">
																	<!--begin::Label-->
																	<label class="form-label">{{ __('general.handover') }}</label>
																	<!--end::Label-->
																	<!--begin::Select2-->
																	<select class="form-select mb-2" name="handover[]" data-label="{{ __('general.handover') }}"
																		data-control="select2"
																		data-placeholder="{{ __('general.select_an_option') }}"  multiple="multiple">
																		<option></option>
																		@foreach($users as $user)
																			<option value="{{$user->id}}">{{$user->name}}</option>
																		@endforeach
																	</select>
																	<!--end::Select2-->
																	<!--begin::Description-->
																	<div class="text-muted fs-7">{{ __('general.optional_message') }}</div>
																	<!--end::Description-->
																</div>
																<!--end::Input group-->
															</div>
															<!--end:InpudRow-->

														</div>
														<!--end::Card header-->
													</div>
													<!--end::General options-->
													
												</div>
												<!--end::Tab pane - Card Body -->

												<!--begin::Tab pane - Card Body -->
												<div class="d-flex flex-column gap-7 gap-lg-10 mb-10">
													<!--begin::General options-->
													<div class="card card-flush py-4">
														<!--begin::Card header-->
														<div class="card-header">
															<div class="card-title d-flex flex-column">
															    <h2>{{ __('general.date_settings') }}</h2>
															    <h6 class="text-muted fw-regular mt-1">{{ __('general.remaining_balance') }}: {{ max(0, $balance->total_days - $balance->used_days) }} {{ __('general.day') }}</h6>
															</div>

														</div>
														<!--end::Card header-->
														<!--begin::Card body-->
														<div class="card-body pt-0">
															<!--begin::InpudRow-->
															<div class="d-flex flex-wrap gap-5 mb-5">
																<!--begin::Input group-->
																<div class="fv-row w-100 flex-md-root">
																	<!--begin::Label-->
																	<label class="required form-label">{{ __('general.start_date') }}</label>
																	<!--end::Label-->
																	<!--begin::Input-->
																	<input id="start_date" name="date" data-label="{{ __('general.start_date') }}" value="{{ date('Y-m-d') }}" class="flatpickr-date form-control mb-2"
																		 data-type="dateTime" data-required="true"/>
																	<!--end::Input-->
																</div>
																<!--end::Input group-->
																<!--begin::Input group-->
																<div class="fv-row w-100 flex-md-root">
																	<!--begin::Label-->
																	<label class="required form-label">{{ __('general.end_date') }}</label>
																	<!--end::Label-->
																	<!--begin::Input-->
																	<input id="end_date" name="due_date" data-label="{{ __('general.end_date') }}" class="flatpickr-date form-control mb-2"
																		value="{{ old('end_date') }}"  data-required="true"/>
																	<!--end::Input-->
																	<!--begin::error-->
																	<div id="date-error" style="color: rgb(224, 19, 19); display: none;font-weight: 600"></div>
																	<!--end::error-->
																</div>
																<!--end::Input group-->
																<!--begin::Input group-->
																<div class="fv-row w-100 flex-md-root">
																	<!--begin::Label-->
																	<label class="required form-label">{{ __('general.type') }} {{ __('general.days/hours') }}</label>
																	<!--end::Label-->
																	<!--begin::Select2-->
																	<select class="form-select mb-2 duration_type" name="duration_type" data-label="{{ __('general.type') }}"
																		data-control="select2" data-hide-search="true" id="duration_type"
																		data-placeholder="{{ __('general.select_an_option') }}" data-required="true" readonly>
																		<option></option>
																		<option value="days" selected>{{ __('general.days') }}</option>
																	</select>
																	<!--end::Select2-->
																</div>
																<!--end::Input group-->
																<!--begin::Input group-->
																<div class="fv-row w-100 flex-md-root">
																	<!--begin::Label-->
																	<label class="required form-label">{{ __('general.duration') }}</label>
																	<!--end::Label-->
																	<!--begin::Input-->
																	<input type="hidden" id="remaining_balance" value="{{ max(0, $balance->total_days - $balance->used_days) }}">
																	<input id="duration" type="number" name="duration" data-label="{{ __('general.duration') }}" class="form-control mb-2" max="10000" readonly/>
																	<!--end::Input-->
																	<!--begin::Description-->
																	<div id="balance-warning" style="color: red; font-weight: 600; display: none;">{{ __('general.duration_exceeds_balance') }}</div>
																	<!--end::Description-->
																</div>
																<!--end::Input group-->
															</div>
															<!--end:InpudRow-->

															
														</div>
														<!--end::Card header-->
													</div>
													<!--end::General options-->
												</div>
												<!--end::Tab pane - Card Body -->
												
											</div>
											<!--end::Tab pane-->
										</div>

										@include('error.form_errors')
										
										<!--end::Tab content-->
										<div class="d-flex justify-content-end">
											<!--begin::Button-->
											<button type="button" class="btn btn-light me-5" onclick="showCancelConfirmation('javascript:history.back()');">{{ __('general.cancel') }}</button>
											<!--end::Button-->
											<!--begin::Button-->
											<button type="submit" id="kt_ecommerce_add_product_submit"
												class="btn btn-primary">
												<span class="indicator-label">{{ __('general.save_changes') }}</span>
												<span class="indicator-progress">{{ __('general.please_wait') }}
													<span
														class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
											</button>
											<!--end::Button-->
										</div>
									</div>
									<!--end::Main column-->
								</form>
								<!--end::Form-->
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
    	const requestType = '{{ $requestType ?? "vacation" }}'; // Set this in controller as needed
	</script>

	<!--begin::Javascript-->
	@include('assets._main_scripts')
	@include('assets._form_scripts')
	<script src="{{ asset('assets/js/models/staff-requests/create-form.js') }}"></script>
	<!--end::Javascript-->
</body>
<!--end::Body-->
</html>