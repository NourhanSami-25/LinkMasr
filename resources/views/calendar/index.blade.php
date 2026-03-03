<!DOCTYPE html>

@if (app()->getLocale() == 'ar')
	@include('assets._language_ar')
@else
	@include('assets._language_en')
@endif

<head>

	<title>Link Masr | Calendar</title>
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
	
	

    <!--begin::Vendor Stylesheets(used for this page only)-->
	<link href="{{ asset('assets/plugins/custom/fullcalendar/fullcalendar.bundle.css') }}" rel="stylesheet" type="text/css" />
	<!--end::Vendor Stylesheets-->

</head>
<!--end::Head-->
<!--begin::Body-->

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
						<!--begin::Content-->
						<div id="kt_app_content" class="app-content flex-column-fluid">
							<!--begin::Content container-->
							<div id="kt_app_content_container" class="app-container container-fluid">
								<!--begin::Card-->
								<div class="card">
									<!--begin::Card header-->
									<div class="card-header">
										<h2 class="card-title fw-bold">{{__('general.calendar')}}</h2>
										<div class="card-toolbar d-flex align-items-center">
											<!--begin::Filter-->
											<button type="button" class="btn btn-light-primary me-3"
												data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" id="kt_calendar_filter_btn">
												<i class="ki-outline ki-filter fs-2"></i>{{__('general.filter')}}</button>
											<!--begin::Menu 1-->
											<div class="menu menu-sub menu-sub-dropdown w-800px w-md-800px"
												data-kt-menu="true" id="kt-toolbar-filter">
												<!--begin::Content-->
												<div class="px-7 py-5">
													<!--begin::Input group-->
													<div class="mb-10">
														<!--begin::Input-->
														<select class="form-select form-select-solid fw-bold mt-5"
															data-kt-select2="true" data-placeholder="Select option" id="kt_calendar_filter"
															data-allow-clear="true"
															data-kt-customer-table-filter="month"
															data-dropdown-parent="#kt-toolbar-filter" multiple>
															<option></option>
															<option value="task" selected="selected">{{__('general.task')}}</option>
															<option value="project" selected="selected">{{__('general.project')}}</option>
															<option value="paymentRequest" selected="selected">{{__('general.paymentRequest')}}</option>
															<option value="procontractject" selected="selected">{{__('general.contract')}}</option>
															<option value="reminder">{{__('general.reminder')}}</option>
															<option value="event" selected="selected">{{__('general.event')}}</option>
														</select>
														<!--end::Input-->
													</div>
													<!--end::Input group-->
													<!--begin::Actions-->
													<div class="d-flex justify-content-end">
														<button type="submit"
															class="btn btn-primary me-2"
															data-kt-menu-dismiss="true" id="apply_filter">{{__('general.apply')}}</button>
														<button type="reset" class="btn btn-light btn-active-light-primary"
															data-kt-menu-dismiss="true" id="reset_filter">{{__('general.reset')}}</button>
													</div>
													<!--end::Actions-->
												</div>
												<!--end::Content-->
											</div>
											<!--end::Menu 1-->
											<!--end::Filter-->
											<button class="btn btn-flex btn-primary" data-kt-calendar="add">
        									    <i class="ki-outline ki-plus fs-2"></i> {{__('general.add_event')}}
        									</button>
										</div>
									</div>
									<!--end::Card header-->
									<!--begin::Card body-->
									<div class="card-body">
										<!--begin::Calendar-->
										<div id="kt_calendar_app"></div>
										<!--end::Calendar-->
									</div>
									<!--end::Card body-->
								</div>
								<!--end::Card-->
								<!--begin::Modals-->
								<!--begin::Modal - New Event-->
								<div class="modal fade" id="kt_modal_add_event" tabindex-="1" aria-hidden="true"
									data-bs-focus="false">
									<!--begin::Modal dialog-->
									<div class="modal-dialog modal-dialog-centered mw-650px">
										<!--begin::Modal content-->
										<div class="modal-content">
											<!--begin::Form-->
											<form class="form" action="{{route('events.store')}}" method="POST" id="kt_modal_add_event_form">
												@csrf
												<!--begin::Modal header-->
												<div class="modal-header">
													<!--begin::Modal title-->
													<h2 class="fw-bold" data-kt-calendar="title">{{__('general.add_new_event')}}</h2>
													<!--end::Modal title-->
													<!--begin::Close-->
													<div class="btn btn-icon btn-sm btn-active-icon-primary"
														id="kt_modal_add_event_close">
														<i class="ki-outline ki-cross fs-1"></i>
													</div>
													<!--end::Close-->
												</div>
												<!--end::Modal header-->
												<!--begin::Modal body-->
												<div class="modal-body py-10 px-lg-17">
													<!--begin::Input group-->
													<div class="fv-row mb-9">
														<!--begin::Label-->
														<label class="fs-6 fw-semibold required mb-2">{{__('general.subject')}}</label>
														<!--end::Label-->
														<!--begin::Input-->
														<input type="text" class="form-control form-control-solid"
															placeholder="" name="calendar_event_name" required/>
														<!--end::Input-->
													</div>
													<!--end::Input group-->
													<!--begin::Input group-->
													<div class="fv-row mb-9">
														<!--begin::Label-->
														<label class="fs-6 fw-regular mb-2">{{__('general.description')}}</label>
														<!--end::Label-->
														<!--begin::Input-->
														<input type="text" class="form-control form-control-solid"
															placeholder="" name="calendar_event_description" />
														<!--end::Input-->
													</div>
													<!--end::Input group-->
													<!--begin::Input group-->
													<div class="fv-row mb-9">
														<!--begin::Label-->
														<label class="fs-6 fw-semibold mb-2">{{__('general.notes')}}</label>
														<!--end::Label-->
														<!--begin::Input-->
														<input type="text" class="form-control form-control-solid"
															placeholder="" name="calendar_event_location" />
														<!--end::Input-->
													</div>
													<!--end::Input group-->
													<!--begin::Input group-->
													<div class="fv-row mb-9">
														<!--begin::Checkbox-->
														<label class="form-check form-check-custom form-check-solid">
															<input class="form-check-input" type="checkbox" value="1"
																id="kt_calendar_datepicker_allday" name="is_allday"/>
															<span class="form-check-label fw-semibold"
																for="kt_calendar_datepicker_allday">{{__('general.all_day')}}</span>
														</label>
														<!--end::Checkbox-->
													</div>
													<!--end::Input group-->
													<!--begin::Input group-->
													<div class="row row-cols-lg-2 g-10">
														<div class="col">
															<div class="fv-row mb-9">
																<!--begin::Label-->
																<label class="fs-6 fw-semibold mb-2 required">{{__('general.start_date')}}</label>
																<!--end::Label-->
																<!--begin::Input-->
																<input class="form-control form-control-solid"
																	name="calendar_event_start_date"
																	placeholder="{{__('general.pick_start_date')}}"
																	id="kt_calendar_datepicker_start_date" required/>
																<!--end::Input-->
															</div>
														</div>
														<div class="col" data-kt-calendar="datepicker">
															<div class="fv-row mb-9">
																<!--begin::Label-->
																<label class="fs-6 fw-semibold mb-2">{{__('general.start_time')}}</label>
																<!--end::Label-->
																<!--begin::Input-->
																<input class="form-control form-control-solid"
																	name="calendar_event_start_time"
																	placeholder="{{__('general.pick_start_time')}}"
																	id="kt_calendar_datepicker_start_time" />
																<!--end::Input-->
															</div>
														</div>
													</div>
													<!--end::Input group-->
													<!--begin::Input group-->
													<div class="row row-cols-lg-2 g-10">
														<div class="col">
															<div class="fv-row mb-9">
																<!--begin::Label-->
																<label class="fs-6 fw-semibold mb-2 required">{{__('general.end_date')}}</label>
																<!--end::Label-->
																<!--begin::Input-->
																<input class="form-control form-control-solid"
																	name="calendar_event_end_date"
																	placeholder="{{__('general.pick_end_date')}}"
																	id="kt_calendar_datepicker_end_date" />
																<!--end::Input-->
															</div>
														</div>
														<div class="col" data-kt-calendar="datepicker">
															<div class="fv-row mb-9">
																<!--begin::Label-->
																<label class="fs-6 fw-semibold mb-2">{{__('general.end_time')}}</label>
																<!--end::Label-->
																<!--begin::Input-->
																<input class="form-control form-control-solid"
																	name="calendar_event_end_time"
																	placeholder="{{__('general.pick_end_time')}}"
																	id="kt_calendar_datepicker_end_time" />
																<!--end::Input-->
															</div>
														</div>
													</div>
													<!--end::Input group-->
												</div>
												<!--end::Modal body-->
												<!--begin::Modal footer-->
												<div class="modal-footer flex-center">
													<!--begin::Button-->
													<button type="reset" id="kt_modal_add_event_cancel"
														class="btn btn-light me-3">{{__('general.cancel')}}</button>
													<!--end::Button-->
													<!--begin::Button-->
													<button type="submit"
														class="btn btn-primary">
														<span class="indicator-label">{{__('general.save')}}</span>
														<span class="indicator-progress">{{__('general.please_wait')}}
															<span
																class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
													</button>
													<!--end::Button-->
												</div>
												<!--end::Modal footer-->
											</form>
											<!--end::Form-->
										</div>
									</div>
								</div>
								<!--end::Modal - New Event-->
								<!--begin::Modal - Edit Event-->
								<div class="modal fade" id="kt_modal_view_event_edit" tabindex-="1" aria-hidden="true"
									data-bs-focus="false">
									<!--begin::Modal dialog-->
									<div class="modal-dialog modal-dialog-centered mw-650px">
										<!--begin::Modal content-->
										<div class="modal-content">
											<!--begin::Form-->
											<form class="form" action="{{route('events.update' , 100)}}" method="POST">
												@csrf
												@method('PUT')
												<input type="hidden" name="event_id" id="event_id">
												<!--begin::Modal header-->
												<div class="modal-header">
													<!--begin::Modal title-->
													<h2 class="fw-bold" data-kt-calendar="title">{{__('general.edit_an_event')}}</h2>
													<!--end::Modal title-->
													<!--begin::Close-->
													<div class="btn btn-icon btn-sm btn-active-icon-primary"
														id="kt_modal_add_event_close">
														<i class="ki-outline ki-cross fs-1"></i>
													</div>
													<!--end::Close-->
												</div>
												<!--end::Modal header-->
												<!--begin::Modal body-->
												<div class="modal-body py-10 px-lg-17">
													<!--begin::Input group-->
													<div class="fv-row mb-9">
														<!--begin::Label-->
														<label class="fs-6 fw-semibold required mb-2">{{__('general.subject')}}</label>
														<!--end::Label-->
														<!--begin::Input-->
														<input type="text" class="form-control form-control-solid" id="event_name"
															placeholder="" name="calendar_event_name" required/>
														<!--end::Input-->
													</div>
													<!--end::Input group-->
													<!--begin::Input group-->
													<div class="fv-row mb-9">
														<!--begin::Label-->
														<label class="fs-6 fw-semibold mb-2">{{__('general.description')}}</label>
														<!--end::Label-->
														<!--begin::Input-->
														<input type="text" class="form-control form-control-solid" id="event_description"
															placeholder="" name="calendar_event_description" />
														<!--end::Input-->
													</div>
													<!--end::Input group-->
													<!--begin::Input group-->
													<div class="fv-row mb-9">
														<!--begin::Label-->
														<label class="fs-6 fw-semibold mb-2">{{__('general.notes')}}</label>
														<!--end::Label-->
														<!--begin::Input-->
														<input type="text" class="form-control form-control-solid" id="event_location"
															placeholder="" name="calendar_event_location" />
														<!--end::Input-->
													</div>
													<!--end::Input group-->
													<!--begin::Input group-->
													<div class="fv-row mb-9">
														<!--begin::Checkbox-->
														<label class="form-check form-check-custom form-check-solid">
															<input class="form-check-input" type="checkbox" value="1" 
																id="kt_calendar_datepicker_allday" name="is_allday"/>
															<span class="form-check-label fw-semibold"
																for="kt_calendar_datepicker_allday">{{__('general.all_day')}}</span>
														</label>
														<!--end::Checkbox-->
													</div>
													<!--end::Input group-->
													<!--begin::Input group-->
													<div class="row row-cols-lg-2 g-10">
														<div class="col">
															<div class="fv-row mb-9">
																<!--begin::Label-->
																<label class="fs-6 fw-semibold mb-2 required">{{__('general.start_date')}}</label>
																<!--end::Label-->
																<!--begin::Input-->
																<input class="form-control form-control-solid"
																	name="calendar_event_start_date" id="event_start"
																	placeholder="Pick a start date"
																	id="kt_calendar_datepicker_start_date" required/>
																<!--end::Input-->
															</div>
														</div>
														<div class="col" data-kt-calendar="datepicker">
															<div class="fv-row mb-9">
																<!--begin::Label-->
																<label class="fs-6 fw-semibold mb-2">{{__('general.start_time')}}</label>
																<!--end::Label-->
																<!--begin::Input-->
																<input class="form-control form-control-solid"
																	name="calendar_event_start_time"
																	placeholder="Pick a start time"
																	id="kt_calendar_datepicker_start_time" />
																<!--end::Input-->
															</div>
														</div>
													</div>
													<!--end::Input group-->
													<!--begin::Input group-->
													<div class="row row-cols-lg-2 g-10">
														<div class="col">
															<div class="fv-row mb-9">
																<!--begin::Label-->
																<label class="fs-6 fw-semibold mb-2 required">{{__('general.end_date')}}</label>
																<!--end::Label-->
																<!--begin::Input-->
																<input class="form-control form-control-solid"
																	name="calendar_event_end_date" id="event_end"
																	placeholder="Pick a end date"
																	id="kt_calendar_datepicker_end_date" />
																<!--end::Input-->
															</div>
														</div>
														<div class="col" data-kt-calendar="datepicker">
															<div class="fv-row mb-9">
																<!--begin::Label-->
																<label class="fs-6 fw-semibold mb-2">{{__('general.end_time')}}</label>
																<!--end::Label-->
																<!--begin::Input-->
																<input class="form-control form-control-solid"
																	name="calendar_event_end_time"
																	placeholder="Pick a end time"
																	id="kt_calendar_datepicker_end_time" />
																<!--end::Input-->
															</div>
														</div>
													</div>
													<!--end::Input group-->
												</div>
												<!--end::Modal body-->
												<!--begin::Modal footer-->
												<div class="modal-footer flex-center">
													<!--begin::Button-->
													<button type="reset" id="kt_modal_add_event_cancel"
														class="btn btn-light me-3">{{__('general.cancel')}}</button>
													<!--end::Button-->
													<!--begin::Button-->
													<button type="submit"
														class="btn btn-primary">
														<span class="indicator-label">{{__('general.save')}}</span>
														<span class="indicator-progress">{{__('general.please_wait')}}
															<span
																class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
													</button>
													<!--end::Button-->
												</div>
												<!--end::Modal footer-->
											</form>
											<!--end::Form-->
										</div>
									</div>
								</div>
								<!--end::Modal - Edit Event-->
								<!--begin::Modal - View Event-->
								<div class="modal fade" id="kt_modal_view_event" tabindex="-1" data-bs-focus="false"
									aria-hidden="true">
									<!--begin::Modal dialog-->
									<div class="modal-dialog modal-dialog-centered mw-850px">
										<!--begin::Modal content-->
										<div class="modal-content">
											<!--begin::Modal header-->
											<div class="modal-header border-0 justify-content-end">
												
												{{-- @if(true)
												<!--begin::Edit-->
												<div class="btn btn-icon btn-sm btn-color-gray-500 btn-active-icon-primary me-2"
													data-bs-toggle="tooltip" data-bs-dismiss="click" title="{{__('general.edit')}}"
													id="kt_modal_view_event_edit">
													<i class="ki-outline ki-pencil fs-2"></i>
												</div>
												<!--end::Edit-->
												@endif --}}
												@if(true)
													<!--begin::Delete-->
													<div class="btn btn-icon btn-sm btn-color-gray-500 btn-active-icon-danger me-2"
														data-bs-toggle="tooltip" data-bs-dismiss="click"
														title="{{__('general.delete')}}" id="kt_modal_view_event_delete">
														<i class="ki-outline ki-trash fs-2"></i>
													</div>
												<!--end::Delete-->
												@endif
												<!--begin::Close-->
												<div class="btn btn-icon btn-sm btn-color-gray-500 btn-active-icon-primary"
													data-bs-toggle="tooltip" title="{{__('general.hide')}}" data-bs-dismiss="modal">
													<i class="ki-outline ki-cross fs-2x"></i>
												</div>
												<!--end::Close-->
											</div>
											<!--end::Modal header-->
											<!--begin::Modal body-->
											<div class="modal-body pt-0 pb-20 px-lg-17">
												<!--begin::Row-->
												<div class="d-flex">
													<!--begin::Icon-->
													<i class="ki-outline ki-calendar-8 fs-1 text-muted me-5"></i>
													<!--end::Icon-->
													<div class="mb-9">
														<!--begin::Event name-->
														<div class="d-flex align-items-center mb-10">
															<span class="fs-2 fw-bold me-3"
																data-kt-calendar="event_name"></span>
															<span class="badge badge-light-success"
																data-kt-calendar="all_day"></span>
														</div>
														<!--end::Event name-->
														<!--begin::Event description-->
														<div class="fs-4 fw-regular text-gray-700" data-kt-calendar="event_description"></div>
														<!--end::Event description-->
													</div>
												</div>
												<!--end::Row-->
												<!--begin::Row-->
												<div class="d-flex align-items-center mb-2">
													<!--begin::Bullet-->
													<span
														class="bullet bullet-dot h-10px w-10px bg-success ms-2 me-7" data-kt-calendar="event_description"></span>
													<!--end::Bullet-->
													<!--begin::Event start date/time-->
													<div class="fs-4">
														<span class="fw-bold">{{__('general.starts')}}</span>
														<span data-kt-calendar="event_start_date"></span>
													</div>
													<!--end::Event start date/time-->
												</div>
												<!--end::Row-->
												<!--begin::Row-->
												<div class="d-flex align-items-center mb-10">
													<!--begin::Bullet-->
													<span
														class="bullet bullet-dot h-10px w-10px bg-danger ms-2 me-7"></span>
													<!--end::Bullet-->
													<!--begin::Event end date/time-->
													<div class="fs-4">
														<span class="fw-bold">{{__('general.ends')}}</span>
														<span data-kt-calendar="event_end_date"></span>
													</div>
													<!--end::Event end date/time-->
												</div>
												<!--end::Row-->
												<!--begin::Row-->
												<div class="d-flex align-items-center">
													<!--begin::Icon-->
													<i class="ki-outline ki-document fs-1 text-muted me-5"></i>
													<!--end::Icon-->
													<!--begin::Event location-->
													<div class="fs-4" data-kt-calendar="event_location"></div>
													<!--end::Event location-->
												</div>
												<!--end::Row-->
											</div>
											<!--end::Modal body-->
										</div>
									</div>
								</div>
								<!--end::Modal - View Event-->
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
	
	<script>
    	window.baseUrl = "{{ url('/') }}";
	</script>


	<!--begin::Javascript-->
	@include('assets._main_scripts')
    <!--begin::Vendors Javascript(used for this page only)-->
	<script src="{{ asset('assets/plugins/custom/fullcalendar/fullcalendar.bundle.js') }}"></script>
	<script src="{{ asset('assets/js/custom/apps/calendar/calendar.js') }}"></script>
	<!--end::Vendors Javascript-->
	<!--end::Javascript-->
</body>
<!--end::Body-->
</html>