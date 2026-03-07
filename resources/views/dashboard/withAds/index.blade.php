<!DOCTYPE html>

@if (app()->getLocale() == 'ar')
	@include('assets._language_ar')
@else
	@include('assets._language_en')
@endif

<head>

	<title>Link Masr | Dashboard</title>
	@include('assets._meta_tags')
	@include('assets._misc')
	@include('assets._data_table_styles')
	<link href="{{ asset('assets/plugins/custom/vis-timeline/vis-timeline.bundle.css') }}" rel="stylesheet" type="text/css" />

	@if (app()->getLocale() == 'ar')
		@include('assets._ar_fonts')
		@include('assets._main_styles_RTL')
	@else
		@include('assets._en_fonts')
		@include('assets._main_styles_LTR')
	@endif
	
</head>

<!--begin::Body-->

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
											class="page-heading d-flex flex-column justify-content-center text-gray-900 fw-bold fs-1 m-0" style="font-size: 2.5rem !important">
											{{ __('general.dashboard') }} </h1>
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
											<li class="breadcrumb-item text-muted">{{ __('general.dashboard') }}</li>
											<!--end::Item-->
										</ul>
										<!--end::Breadcrumb-->
									</div>
									<!--end::Page title-->
									{{-- <!--begin::Actions-->
									<div class="d-flex align-items-center gap-2 gap-lg-3">
										<a href="#" class="btn btn-flex btn-outline btn-color-gray-700 btn-active-color-primary bg-body h-40px fs-7 fw-bold">Add Member</a>
										<a href="#" class="btn btn-flex btn-primary h-40px fs-7 fw-bold">New Campaign</a>
									</div>
									<!--end::Actions--> --}}
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

								@if($announcements->count() == 0)
								@else
								<!--begin::Row Announcement-->
								<div class="row g-5 gx-xl-10 mb-xl-10" id="announcement-card" style="display:none;">
								    <!--begin::Col Announcement-->
								    <div class="col-xl-12">
								        <!--begin::Engage widget 6-->
								        <div class="card flex-grow-1 bgi-no-repeat bgi-size-contain bgi-position-x-end h-xl-100"
								            style="background-color:#000000">
											<!--begin::Header-->
											<div class="card-header border-0 pt-2 ps-xl-18">
												<h1 class="card-title align-items-start flex-column">
													<span class="card-label fs-1 fw-bold text-light" style="font-size: 1.5rem !important; color: #ffffff !important;">{{__('general.announcements')}}</span>
												</h1>
											</div>
											<!--end::Header-->
								            <!--begin::Body-->
								            <div class="card-body d-flex justify-content-between flex-column ps-xl-18" style="padding-top: 0% !important">
								                <!--begin::Heading-->
								                @foreach($announcements as $announcement)
								                <div class="mb-8 pt-xl-2 announcement-item" id="announcement-{{ $announcement['id'] }}">
								                    <div class="d-flex justify-content-between align-items-center">
								                        <!--begin::Description-->
								                        <span class="fw-bold text-white fs-4 d-block lh-0">Announcement #{{ $loop->iteration }} {{ $announcement['subject'] }}</span>
								                        <!-- X Button to Hide Announcement -->
								                        <button class="btn btn-sm btn-light-primary remove-announcement" style="background: none" 
								                                data-id="{{ $announcement['id'] }}">
								                            âœ–
								                        </button>
								                    </div>
								                    <!--end::Description-->
								                    <!--begin::Title-->
								                    <h3 class="fw-semibold text-gray-500 fs-5 mb-5">{{ $announcement['message'] }}</h3>
								                    <!--end::Title-->
													@if(  $announcement['show_name'] )
								                    <!--begin::Description-->
								                    <span class="fw-bold text-white fs-6 d-block lh-0">{{ __getUserNameById($announcement['created_by']) }}</span>
								                    <!--end::Description-->
													@else
													<!--begin::Description-->
								                    <span class="fw-bold text-white fs-5 d-block lh-0">{{ __('general.hr_department') }}</span>
								                    <!--end::Description-->
													@endif
								                </div>
								                @endforeach
								                <!--end::Heading-->
								                <!--begin::Action-->
								                <div class="mb-xl-10 mt-5 mb-3">
								                    <a href="{{route('announcements.index')}}" class="btn btn-primary fw-semibold me-2">{{__('general.view_all')}}</a>
								                    <a href="#" id="hide-announcement-card" 
								                       class="btn btn-color-white bg-transparent btn-outline fw-semibold" 
								                       style="border: 1px solid rgba(255, 255, 255, 0.3)">
								                        {{__('general.hide_announcements')}}
								                    </a>
								                </div>
								                <!--end::Action-->
								            </div>
								            <!--end::Body-->
								        </div>
								        <!--end::Engage widget 6-->
								    </div>
								    <!--end::Col Announcement-->
								</div>
								<!--end::Row Announcement-->
								@endif



								<!--begin::Row-->
								<div class="row gx-5 gx-xl-10">
									<!--begin::Col-->
									<div class="col-xl-4 mb-10">
										<!--begin::Lists Widget 19-->
										<div class="card card-flush h-xl-100">
											<!--begin::Heading-->
											<div class="card-header rounded bgi-no-repeat bgi-size-cover bgi-position-y-top bgi-position-x-center align-items-start h-250px"
												style=" background-image: url('{{ asset('assets/media/background/dashboard1.jpg') }}');"
												data-bs-theme="light">
												<!--begin::Title-->
												<h3 class="card-title align-items-start flex-column text-white pt-15">
													<span class="fw-bold fs-2x mb-3">{{__('general.tasks_summary')}}</span>
													<div class="fs-4 text-white">
														<span class="opacity-75">{{__('general.you_have')}}</span>
														<span class="position-relative d-inline-block">
															<a href="{{route('tasks.index')}}"
																class="link-white opacity-75-hover fw-bold d-block mb-1"> {{ $taskCounts['inProgressTasksCount'] }} {{__('general.just_task')}}</a>
															<!--begin::Separator-->
															<span
																class="position-absolute opacity-50 bottom-0 start-0 border-2 border-body border-bottom w-100"></span>
															<!--end::Separator-->
														</span>
														<span class="opacity-75">{{__('general.to_complete')}}</span>
													</div>
												</h3>
												<!--end::Title-->
											</div>
											<!--end::Heading-->
											<!--begin::Body-->
											<div class="card-body mt-n20">
												<!--begin::Stats-->
												<div class="mt-n20 position-relative">
													<!--begin::Row-->
													<div class="row g-3 g-lg-6">
														<!--begin::Col-->
														<div class="col-6">
															<!--begin::Items-->
															<div class="bg-gray-100 bg-opacity-70 rounded-2 px-6 py-5">
																<!--begin::Symbol-->
																<div class="symbol symbol-30px me-5 mb-8">
																	<span class="symbol-label">
																		<i class="ki-outline ki-menu fs-1 text-primary"></i>
																	</span>
																</div>
																<!--end::Symbol-->
																<!--begin::Stats-->
																<div class="m-0">
																	<!--begin::Number-->
																	<span
																		class="text-gray-700 fw-bolder d-block fs-2qx lh-1 ls-n1 mb-1">{{ $taskCounts['allTasksCount'] }}</span>
																	<!--end::Number-->
																	<!--begin::Desc-->
																	<span
																		class="text-gray-500 fw-semibold fs-6">{{ __('general.all_tasks') }}</span>
																	<!--end::Desc-->
																</div>
																<!--end::Stats-->
															</div>
															<!--end::Items-->
														</div>
														<!--end::Col-->
														<!--begin::Col-->
														<div class="col-6">
															<!--begin::Items-->
															<div class="bg-gray-100 bg-opacity-70 rounded-2 px-6 py-5">
																<!--begin::Symbol-->
																<div class="symbol symbol-30px me-5 mb-8">
																	<span class="symbol-label">
																		<i class="ki-outline ki-watch fs-1 text-primary"></i>
																	</span>
																</div>
																<!--end::Symbol-->
																<!--begin::Stats-->
																<div class="m-0">
																	<!--begin::Number-->
																	<span
																		class="text-gray-700 fw-bolder d-block fs-2qx lh-1 ls-n1 mb-1">{{ $taskCounts['inProgressTasksCount'] }}</span>
																	<!--end::Number-->
																	<!--begin::Desc-->
																	<span
																		class="text-gray-500 fw-semibold fs-6">{{ __('general.in_progress') }}</span>
																	<!--end::Desc-->
																</div>
																<!--end::Stats-->
															</div>
															<!--end::Items-->
														</div>
														<!--end::Col-->
														<!--begin::Col-->
														<div class="col-6">
															<!--begin::Items-->
															<div class="bg-gray-100 bg-opacity-70 rounded-2 px-6 py-5">
																<!--begin::Symbol-->
																<div class="symbol symbol-30px me-5 mb-8">
																	<span class="symbol-label">
																		<i
																			class="ki-outline ki-calendar-tick fs-1 text-primary"></i>
																	</span>
																</div>
																<!--end::Symbol-->
																<!--begin::Stats-->
																<div class="m-0">
																	<!--begin::Number-->
																	<span
																		class="text-gray-700 fw-bolder d-block fs-2qx lh-1 ls-n1 mb-1">{{ $taskCounts['completedTasksCount'] }}</span>
																	<!--end::Number-->
																	<!--begin::Desc-->
																	<span class="text-gray-500 fw-semibold fs-6">{{ __('general.completed') }}</span>
																	<!--end::Desc-->
																</div>
																<!--end::Stats-->
															</div>
															<!--end::Items-->
														</div>
														<!--end::Col-->
														<!--begin::Col-->
														<div class="col-6">
															<!--begin::Items-->
															<div class="bg-gray-100 bg-opacity-70 rounded-2 px-6 py-5">
																<!--begin::Symbol-->
																<div class="symbol symbol-30px me-5 mb-8">
																	<span class="symbol-label">
																		<i
																			class="ki-outline ki-lock fs-1 text-primary"></i>
																	</span>
																</div>
																<!--end::Symbol-->
																<!--begin::Stats-->
																<div class="m-0">
																	<!--begin::Number-->
																	<span
																		class="text-gray-700 fw-bolder d-block fs-2qx lh-1 ls-n1 mb-1">{{ $taskCounts['onHoldTasksCount'] }}</span>
																	<!--end::Number-->
																	<!--begin::Desc-->
																	<span class="text-gray-500 fw-semibold fs-6">{{ __('general.on_hold') }}</span>
																	<!--end::Desc-->
																</div>
																<!--end::Stats-->
															</div>
															<!--end::Items-->
														</div>
														<!--end::Col-->
													</div>
													<!--end::Row-->
												</div>
												<!--end::Stats-->
											</div>
											<!--end::Body-->
										</div>
										<!--end::Lists Widget 19-->
									</div>
									<!--end::Col-->
									<!--begin::Col-->
									<div class="col-xl-8 mb-10">
										<!--begin::Row-->
										<div class="row g-5 g-xl-10">
											<div class="col-xl-12 mb-xl-10">
												<!--begin::Timeline widget 3-->
												<div class="card h-md-100">
													<!--begin::Header-->
													<div class="card-header border-0 pt-5">
														<h3 class="card-title align-items-start flex-column">
															<span class="card-label fw-bold text-gray-900">{{__('general.whats_up_today')}}</span>
															<span class="text-muted mt-1 fw-semibold fs-7">{{__('general.follow_all_daily_tasks')}}</span>
														</h3>
														<!--begin::Toolbar-->
														<div class="card-toolbar">
															<a href="{{route('calendar.index')}}" class="btn btn-sm btn-light">{{__('general.calendar')}}</a>
														</div>
														<!--end::Toolbar-->
													</div>
													<!--end::Header-->
													<!--begin::Body-->
													<div class="card-body pt-7 px-0">
		
														@php
															// Function to get localized day abbreviation
															function getLocalizedDayAbbrWithAds($date) {
																$dayOfWeek = \Carbon\Carbon::parse($date)->dayOfWeek;
																$dayKeys = [
																	0 => 'sun_short', // Sunday
																	1 => 'mon_short', // Monday
																	2 => 'tue_short', // Tuesday
																	3 => 'wed_short', // Wednesday
																	4 => 'thu_short', // Thursday
																	5 => 'fri_short', // Friday
																	6 => 'sat_short', // Saturday
																];
																return __('general.' . $dayKeys[$dayOfWeek]);
															}
														@endphp

														<!--begin::Nav-->
														<ul
															class="nav nav-stretch nav-pills nav-pills-custom nav-pills-active-custom d-flex justify-content-between mb-8 px-5">
															<!--begin::Nav item-->
															@foreach ($days as $day => $events)
																<li class="nav-item p-0 ms-0">
																	<!--begin::Date-->
																	<a class="nav-link btn d-flex flex-column flex-center rounded-pill min-w-45px py-4 px-3 btn-active-danger {{ \Carbon\Carbon::parse($day)->isToday() ? 'active' : '' }}"
																		data-bs-toggle="tab"
																		 href="#kt_timeline_widget_3_tab_content_{{ \Carbon\Carbon::parse($day)->format('Ymd') }}">
																		<span class="fs-7 fw-semibold">{{ getLocalizedDayAbbrWithAds($day) }}</span>
																		<span class="fs-6 fw-bold">{{ \Carbon\Carbon::parse($day)->format('d') }}</span>
																	</a>
																	<!--end::Date-->
																</li>
															@endforeach
															<!--end::Nav item-->
														</ul>
														<!--end::Nav-->
		
														<!--begin::Tab Content-->
														<div class="tab-content mb-2 px-9">
														@php
															$today = now()->toDateString();
														@endphp
		
														@foreach ($days as $day => $events)
															<div class="tab-pane fade @if($day == $today) show active @endif" id="kt_timeline_widget_3_tab_content_{{ \Carbon\Carbon::parse($day)->format('Ymd') }}">
																<!-- Scrollable wrapper -->
																<div class="overflow-auto" style="max-height: 300px;"> <!-- Adjust height as needed -->
																	@foreach ($events as $event)
																		<!--begin::Wrapper-->
																		<div class="d-flex align-items-center mb-6">
																			<!--begin::Bullet-->
																			<span data-kt-element="bullet" class="bullet bullet-vertical d-flex align-items-center min-h-70px mh-100 me-4 {{ $event['className'] }}"></span>
																			<!--end::Bullet-->
																		
																			<!--begin::Info-->
																			<div class="flex-grow-1 me-5">
																				<!--begin::Time-->
																				<div class="text-gray-800 fw-semibold fs-2">
																					{{ $event['start'] }} - {{ $event['end']}}
																				</div>
																				<!--end::Time-->
																			
																				<!--begin::Description-->
																				<div class="text-gray-700 fw-semibold fs-6"><span class="fw-bold text-gray-900">{{ __('general.' . $event['type']) }}</span> | <a href="#" class="text-primary opacity-75-hover fw-semibold">{{ $event['title'] }}</a></div>
																				<!--end::Description-->
																			
																				<!--begin::Link-->
																				<div class="text-gray-500 fw-semibold fs-7">
																					{{ Str::limit($event['description'], 50) }}
																				
																				</div>
																				<!--end::Link-->
																			</div>
																			<!--end::Info-->
																		
																			<!--begin::Action-->
																			<a href="{{route('calendar.index')}}" class="btn btn-sm btn-light">{{__('general.view')}}</a>
																			<!--end::Action-->
																		</div>
																		<!--end::Wrapper-->
																	@endforeach
																</div>
																<!-- End scrollable div -->
															</div>
														@endforeach
														</div>
														<!--end::Tab Content-->
													</div>
													<!--end: Card Body-->
												</div>
												<!--end::Timeline widget 3-->
											</div>
										</div>
										<!--end::Row-->
										<!--begin::Engage widget 4-->
										<div class="card border-transparent" data-bs-theme="light"
										style=" background-image: url('{{ asset('assets/media/background/dashboard1.jpg') }}');">
											<!--begin::Body-->
											<div class="card-body d-flex ps-xl-15">
												<!--begin::Wrapper-->
												<div class="m-0">
													<!--begin::Title-->
													<div class="position-relative fs-2x z-index-2 fw-bold text-white mb-7">
														<span class="me-2">
															{{ __('general.do_not_miss') }}
															<span class="position-relative d-inline-block text-danger">
																<a href="https://www.lexpro.qa/" class="text-danger opacity-75-hover">
																	{{ __('general.follow_updates') }}
																</a>
																<span class="position-absolute opacity-50 bottom-0 start-0 border-4 border-danger border-bottom w-100"></span>
															</span>
														</span>
														<br />
														{{ __('general.to_stay_informed') }}
													</div>
													<!--end::Title-->
													<!--begin::Action-->
													<div class="mb-3">
														<a href='https://www.lexpro.qa/' class="btn btn-danger fw-semibold me-2"
															data-bs-toggle="modal"
															data-bs-target="#kt_modal_upgrade_plan">{{ __('general.linkpro') }}</a>
														<a href="https://www.lexpro.qa/"
															class="btn btn-color-white bg-white bg-opacity-15 bg-hover-opacity-25 fw-semibold">{{ __('general.about') }}</a>
													</div>
													<!--begin::Action-->
												</div>
												<!--begin::Wrapper-->
												<!--begin::Illustration-->
												<img src="{{ asset('assets/media/illustrations/sigma-1/17-dark.png') }}"
													class="position-absolute me-3 bottom-0 end-0 h-200px" alt="" />
												<!--end::Illustration-->
											</div>
											<!--end::Body-->
										</div>
										<!--end::Engage widget 4-->
									</div>
									<!--end::Col-->
								</div>
								<!--end::Row-->

								<!--begin::Row Calendar & Graph-->
								<div class="row gy-5 g-xl-10">

									<!--begin::Col Reminders-->
									<div class="col-xl-6 mb-xl-10">
										<!--begin::Table widget 8-->
										{{-- <div class="card h-xl-100" style="height: 93% !important;"> --}}
										<div class="card h-xl-100">
											<!--begin::Header-->
											<div class="card-header position-relative py-0 border-bottom-2">
												<!--begin::Nav-->
												<ul class="nav nav-stretch nav-pills nav-pills-custom d-flex mt-3">
													<!--begin::Nav item-->
													<li class="nav-item p-0 ms-0 me-8">
														<!--begin::Nav link-->
														<a class="nav-link btn btn-color-muted px-0 show active"
															data-bs-toggle="tab"
															href="#kt_table_widget_7_tab_content_today">
															<!--begin::Title-->
															<span class="nav-text fw-semibold fs-4 mb-3">{{__('general.today')}}</span>
															<!--end::Title-->
															<!--begin::Bullet-->
															<span
																class="bullet-custom position-absolute z-index-2 w-100 h-2px top-100 bottom-n100 bg-primary rounded"></span>
															<!--end::Bullet-->
														</a>
														<!--end::Nav link-->
													</li>
													<!--end::Nav item-->
													<!--begin::Nav item-->
													<li class="nav-item p-0 ms-0 me-8">
														<!--begin::Nav link-->
														<a class="nav-link btn btn-color-muted px-0"
															data-bs-toggle="tab"
															href="#kt_table_widget_7_tab_content_comming">
															<!--begin::Title-->
															<span class="nav-text fw-semibold fs-4 mb-3">{{__('general.comming_reminders')}}</span>
															<!--end::Title-->
															<!--begin::Bullet-->
															<span
																class="bullet-custom position-absolute z-index-2 w-100 h-2px top-100 bottom-n100 bg-primary rounded"></span>
															<!--end::Bullet-->
														</a>
														<!--end::Nav link-->
													</li>
													<!--end::Nav item-->
													<!--begin::Nav item-->
													<li class="nav-item p-0 ms-0 me-8">
														<!--begin::Nav link-->
														<a class="nav-link btn btn-color-muted px-0"
															data-bs-toggle="tab"
															href="#kt_table_widget_7_tab_content_missed">
															<!--begin::Title-->
															<span
																class="nav-text fw-semibold fs-4 mb-3">{{__('general.missed_reminders')}}</span>
															<!--end::Title-->
															<!--begin::Bullet-->
															<span
																class="bullet-custom position-absolute z-index-2 w-100 h-2px top-100 bottom-n100 bg-primary rounded"></span>
															<!--end::Bullet-->
														</a>
														<!--end::Nav link-->
													</li>
													<!--end::Nav item-->
													
													<!--begin::Nav item-->
													<li class="nav-item p-0 ms-0 me-8">
														<!--begin::Nav link-->
														<a class="nav-link btn btn-color-muted px-0"
															data-bs-toggle="tab"
															href="#kt_table_widget_7_tab_content_all">
															<!--begin::Title-->
															<span class="nav-text fw-semibold fs-4 mb-3">{{__('general.all')}}</span>
															<!--end::Title-->
															<!--begin::Bullet-->
															<span
																class="bullet-custom position-absolute z-index-2 w-100 h-2px top-100 bottom-n100 bg-primary rounded"></span>
															<!--end::Bullet-->
														</a>
														<!--end::Nav link-->
													</li>
													<!--end::Nav item-->
												</ul>
												<!--end::Nav-->

												<div class="card-toolbar">
													<a href="{{route('reminders.index')}}" type="button" class="btn btn-primary btn-sm">{{ __('general.view_all') }}</a>
												</div>
											</div>
											<!--end::Header-->
											<!--begin::Body-->
											<div class="card-body">
												<!--begin::Tab Content (ishlamayabdi)-->
												<div class="tab-content mb-2">
													<!--begin::Tap pane-->
													<div class="tab-pane fade show active" id="kt_table_widget_7_tab_content_today">
														<!--begin::Table container-->
														<div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
															<!--begin::Table-->
															<table class="table align-middle">
																<!--begin::Table head-->
																<thead>
																	<tr>
																		<th class="min-w-150px p-0"></th>
																		<th class="min-w-200px p-0"></th>
																		<th class="min-w-100px p-0"></th>
																		<th class="min-w-80px p-0"></th>
																	</tr>
																</thead>
																<!--end::Table head-->
															
																<!--begin::Table body-->
																<tbody>
																	@foreach($reminders['todayReminders'] as $reminder)
																	<tr>
																		<td colspan="4" class="bg-primary bg-opacity-10 fw-bold px-4 py-2 fs-5">
																			{{ $reminder['subject'] }}
																		</td>
																	</tr>
																	<tr class="border-bottom">
																		<td class="fs-6 text-gray-800 px-4 py-2">
																			{{ \Carbon\Carbon::parse($reminder['date'])->format('Y-m-d H:i') }}
																		</td>
																		<td class="fs-6 text-gray-600 px-4 py-2">
																			<span class="fw-semibold">{{ $reminder['status'] }}</span>
																		</td>
																		<td class="fs-6 text-gray-600 px-4 py-2">
																			<span class="fw-semibold">{{ $reminder['priority'] ?? '-' }}</span>
																		</td>
																		<td class="fs-6 text-gray-600 px-4 py-2">
																			<span class="fw-semibold">{{ __('general.created_at') .' : '. $reminder['created_at'] ?? '-' }}</span>
																		</td>
																	</tr>
																	@endforeach
																</tbody>
																<!--end::Table body-->
															</table>
															<!--end::Table-->
														</div>
														<!--end::Table container-->
													</div>
													<!--end::Tap pane-->
													<!--begin::Tap pane-->
													<div class="tab-pane fade" id="kt_table_widget_7_tab_content_comming">
														<!--begin::Table container-->
														<div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
															<!--begin::Table-->
															<table class="table align-middle">
																<div class="table-scroll" style="max-height: 400px; overflow-y: auto;">
																<!--begin::Table head-->
																<thead>
																	<tr>
																		<th class="min-w-150px p-0"></th>
																		<th class="min-w-200px p-0"></th>
																		<th class="min-w-100px p-0"></th>
																		<th class="min-w-80px p-0"></th>
																	</tr>
																</thead>
																<!--end::Table head-->
															
																<!--begin::Table body-->
																<tbody>
																	@foreach($reminders['commingReminders'] as $reminder)
																	<tr>
																		<td colspan="4" class="bg-primary bg-opacity-10 fw-bold px-4 py-2 fs-5">
																			{{ $reminder['subject'] }}
																		</td>
																	</tr>
																	<tr class="border-bottom">
																		<td class="fs-6 text-gray-800 px-4 py-2">
																			{{ \Carbon\Carbon::parse($reminder['date'])->format('Y-m-d H:i') }}
																		</td>
																		<td class="fs-6 text-gray-600 px-4 py-2">
																			<span class="fw-semibold text-dark">{{ $reminder['status'] }}</span>
																		</td>
																		<td class="fs-6 text-gray-600 px-4 py-2">
																			<span class="fw-semibold text-dark">{{ $reminder['priority'] ?? '-' }}</span>
																		</td>
																		<td class="fs-6 text-gray-600 px-4 py-2">
																			<span class="fw-semibold">{{ __('general.created_at') .' : '. $reminder['created_at'] ?? '-' }}</span>
																		</td>
																	</tr>
																	@endforeach
																</tbody>
																<!--end::Table body-->
															</table>
															<!--end::Table-->
														</div>
														<!--end::Table container-->
													</div>
													<!--end::Tap pane-->
													<!--begin::Tap pane-->
													<div class="tab-pane fade" id="kt_table_widget_7_tab_content_missed">
														<!--begin::Table container-->
														<div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
															<!--begin::Table-->
															<table class="table align-middle">
																<!--begin::Table head-->
																<thead>
																	<tr>
																		<th class="min-w-150px p-0"></th>
																		<th class="min-w-200px p-0"></th>
																		<th class="min-w-100px p-0"></th>
																		<th class="min-w-80px p-0"></th>
																	</tr>
																</thead>
																<!--end::Table head-->
															
																<!--begin::Table body-->
																<tbody>
																	@foreach($reminders['missedReminders'] as $reminder)
																	<tr>
																		<td colspan="4" class="bg-primary bg-opacity-10 fw-bold px-4 py-2 fs-5">
																			{{ $reminder['subject'] }}
																		</td>
																	</tr>
																	<tr class="border-bottom">
																		<td class="fs-6 text-gray-800 px-4 py-2">
																			{{ \Carbon\Carbon::parse($reminder['date'])->format('Y-m-d H:i') }}
																		</td>
																		<td class="fs-6 text-gray-600 px-4 py-2">
																			<span class="fw-semibold text-dark">{{ $reminder['status'] }}</span>
																		</td>
																		<td class="fs-6 text-gray-600 px-4 py-2">
																			<span class="fw-semibold text-dark">{{ $reminder['priority'] ?? '-' }}</span>
																		</td>
																		<td class="fs-6 text-gray-600 px-4 py-2">
																			<span class="fw-semibold">{{ __('general.created_at') .' : '. $reminder['created_at'] ?? '-' }}</span>
																		</td>
																	</tr>
																	@endforeach
																</tbody>
																<!--end::Table body-->
															</table>
															<!--end::Table-->
														</div>
														<!--end::Table container-->
													</div>
													<!--end::Tap pane-->
													<!--begin::Tap pane-->
													<div class="tab-pane fade" id="kt_table_widget_7_tab_content_sessions">
														<!--begin::Table container-->
														<div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
															<!--begin::Table-->
															<table class="table align-middle">
																<!--begin::Table head-->
																<thead>
																	<tr>
																		<th class="min-w-150px p-0"></th>
																		<th class="min-w-200px p-0"></th>
																		<th class="min-w-100px p-0"></th>
																		<th class="min-w-80px p-0"></th>
																	</tr>
																</thead>
																<!--end::Table head-->
															
																
															</table>
															<!--end::Table-->
														</div>
														<!--end::Table container-->
													</div>
													<!--end::Tap pane-->
													<!--begin::Tap pane-->
													<div class="tab-pane fade" id="kt_table_widget_7_tab_content_all">
														<!--begin::Table container-->
														<div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
															<!--begin::Table-->
															<table class="table align-middle">
																<!--begin::Table head-->
																<thead>
																	<tr>
																		<th class="min-w-150px p-0"></th>
																		<th class="min-w-200px p-0"></th>
																		<th class="min-w-100px p-0"></th>
																		<th class="min-w-80px p-0"></th>
																	</tr>
																</thead>
																<!--end::Table head-->
															
																<!--begin::Table body-->
																<tbody>
																	@foreach($reminders['allReminders'] as $reminder)
																	<tr>
																		<td colspan="4" class="bg-primary bg-opacity-10 fw-bold px-4 py-2 fs-5">
																			{{ $reminder['subject'] }}
																		</td>
																	</tr>
																	<tr class="border-bottom">
																		<td class="fs-6 text-gray-800 px-4 py-2">
																			{{ \Carbon\Carbon::parse($reminder['date'])->format('Y-m-d H:i') }}
																		</td>
																		<td class="fs-6 text-gray-600 px-4 py-2">
																			<span class="fw-semibold text-dark">{{ $reminder['status'] }}</span>
																		</td>
																		<td class="fs-6 text-gray-600 px-4 py-2">
																			<span class="fw-semibold text-dark">{{ $reminder['priority'] ?? '-' }}</span>
																		</td>
																		<td class="fs-6 text-gray-600 px-4 py-2">
																			<span class="fw-semibold">{{ __('general.created_at') .' : '. $reminder['created_at'] ?? '-' }}</span>
																		</td>
																	</tr>
																	@endforeach
																</tbody>
																<!--end::Table body-->
															</table>
															<!--end::Table-->
														</div>
														<!--end::Table container-->
													</div>
													<!--end::Tap pane-->
												</div>
												<!--end::Tab Content-->
											</div>
											<!--end: Card Body-->
										</div>
										<!--end::Table widget 8-->
									</div>
									<!--end::Col Reminders-->

									{{-- <!--begin::Col Graph-->
									<div class="col-xl-6 mb-xl-10">
										<!--begin::Chart widget 4-->
										<div class="card card-flush overflow-hidden h-md-100">
											<!--begin::Header-->
											<div class="card-header py-5">
												<!--begin::Title-->
												<h3 class="card-title align-items-start flex-column">
													<span class="card-label fw-bold text-gray-900">Discounted Product
														Sales</span>
													<span class="text-gray-500 mt-1 fw-semibold fs-6">Users from all
														channels</span>
												</h3>
												<!--end::Title-->
												<!--begin::Toolbar-->
												<div class="card-toolbar">
													<!--begin::Menu-->
													<button
														class="btn btn-icon btn-color-gray-500 btn-active-color-primary justify-content-end"
														data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end"
														data-kt-menu-overflow="true">
														<i class="ki-outline ki-dots-square fs-1"></i>
													</button>
													<!--begin::Menu 2-->
													<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px"
														data-kt-menu="true">
														<!--begin::Menu item-->
														<div class="menu-item px-3">
															<div
																class="menu-content fs-6 text-gray-900 fw-bold px-3 py-4">
																Quick Actions</div>
														</div>
														<!--end::Menu item-->
														<!--begin::Menu separator-->
														<div class="separator mb-3 opacity-75"></div>
														<!--end::Menu separator-->
														<!--begin::Menu item-->
														<div class="menu-item px-3">
															<a href="#" class="menu-link px-3">New Ticket</a>
														</div>
														<!--end::Menu item-->
														<!--begin::Menu item-->
														<div class="menu-item px-3">
															<a href="#" class="menu-link px-3">New Customer</a>
														</div>
														<!--end::Menu item-->
														<!--begin::Menu item-->
														<div class="menu-item px-3" data-kt-menu-trigger="hover"
															data-kt-menu-placement="right-start">
															<!--begin::Menu item-->
															<a href="#" class="menu-link px-3">
																<span class="menu-title">New Group</span>
																<span class="menu-arrow"></span>
															</a>
															<!--end::Menu item-->
															<!--begin::Menu sub-->
															<div class="menu-sub menu-sub-dropdown w-175px py-4">
																<!--begin::Menu item-->
																<div class="menu-item px-3">
																	<a href="#" class="menu-link px-3">Admin Group</a>
																</div>
																<!--end::Menu item-->
																<!--begin::Menu item-->
																<div class="menu-item px-3">
																	<a href="#" class="menu-link px-3">Staff Group</a>
																</div>
																<!--end::Menu item-->
																<!--begin::Menu item-->
																<div class="menu-item px-3">
																	<a href="#" class="menu-link px-3">Member Group</a>
																</div>
																<!--end::Menu item-->
															</div>
															<!--end::Menu sub-->
														</div>
														<!--end::Menu item-->
														<!--begin::Menu item-->
														<div class="menu-item px-3">
															<a href="#" class="menu-link px-3">New Contact</a>
														</div>
														<!--end::Menu item-->
														<!--begin::Menu separator-->
														<div class="separator mt-3 opacity-75"></div>
														<!--end::Menu separator-->
														<!--begin::Menu item-->
														<div class="menu-item px-3">
															<div class="menu-content px-3 py-3">
																<a class="btn btn-primary btn-sm px-4" href="#">Generate
																	Reports</a>
															</div>
														</div>
														<!--end::Menu item-->
													</div>
													<!--end::Menu 2-->
													<!--end::Menu-->
												</div>
												<!--end::Toolbar-->
											</div>
											<!--end::Header-->
											<!--begin::Card body-->
											<div class="card-body d-flex justify-content-between flex-column pb-1 px-0">
												<!--begin::Info-->
												<div class="px-9 mb-5">
													<!--begin::Statistics-->
													<div class="d-flex align-items-center mb-2">
														<!--begin::Currency-->
														<span
															class="fs-4 fw-semibold text-gray-500 align-self-start me-1">$</span>
														<!--end::Currency-->
														<!--begin::Value-->
														<span
															class="fs-2hx fw-bold text-gray-800 me-2 lh-1 ls-n2">3,706</span>
														<!--end::Value-->
														<!--begin::Label-->
														<span class="badge badge-light-success fs-base">
															<i
																class="ki-outline ki-arrow-down fs-5 text-success ms-n1"></i>4.5%</span>
														<!--end::Label-->
													</div>
													<!--end::Statistics-->
													<!--begin::Description-->
													<span class="fs-6 fw-semibold text-gray-500">Total Discounted Sales
														This Month</span>
													<!--end::Description-->
												</div>
												<!--end::Info-->
												<!--begin::Chart-->
												<div id="kt_charts_widget_4" class="min-h-auto ps-4 pe-6"
													style="height: 300px"></div>
												<!--end::Chart-->
											</div>
											<!--end::Card body-->
										</div>
										<!--end::Chart widget 4-->
									</div>
									<!--end::Col Graph--> --}}



								</div>
								<!--end::Row Calendar & Graph-->

						

								<!--begin::Row Reminders & Tasks-->
								<div class="row gy-5 g-xl-10">

									<!--begin::Col-->
									<div class="col-xl-4 mb-xl-10">
										<!--begin::Engage widget 1-->
										<div class="card h-md-100" dir="ltr">
											<!--begin::Body-->
											<div class="card-body d-flex flex-column flex-center">
												<!--begin::Heading-->
												<div class="mb-2">
													<!--begin::Title-->
													<h1 class="fw-semibold text-gray-800 text-center lh-lg">{{ __('general.have_any_suggestions_or_issues') }}
														<br />
														<span class="fw-bolder">{{ __('general.please_contact_us') }}</span>
													</h1>
													<!--end::Title-->
													<!--begin::Illustration-->
													<div class="py-10 text-center">
														<img src="{{ asset('assets/media/svg/illustrations/easy/2.svg') }}"
															class="theme-light-show w-200px" alt="" />
														<img src="{{ asset('assets/media/svg/illustrations/easy/2-dark.svg') }}"
															class="theme-dark-show w-200px" alt="" />
													</div>
													<!--end::Illustration-->
												</div>
												<!--end::Heading-->
												<!--begin::Links-->
												<div class="text-center mb-1">
													<!--begin::Link-->
													<a class="btn btn-sm btn-primary me-2"
														href="https://www.lexpro.qa/support/">{{ __('general.support') }}</a>
													<!--end::Link-->
													<!--begin::Link-->
													<a class="btn btn-sm btn-light"
														href="https://www.lexpro.qa/">{{ __('general.contact') }}</a>
													<!--end::Link-->
												</div>
												<!--end::Links-->
											</div>
											<!--end::Body-->
										</div>
										<!--end::Engage widget 1-->
									</div>
									<!--end::Col-->
																		
									<!--begin::Col Tasks-->
									<div class="col-xl-8 mb-5 mb-xl-10">
										<!--begin::Table Widget 5-->
										<div class="card card-flush h-xl-100">
											<!--begin::Card header-->
											<div class="card-header pt-7">
												<!--begin::Title-->
												<h3 class="card-title align-items-start flex-column">
													<span class="card-label fw-bold text-gray-900">{{ __('general.my_tasks') }}</span>
													<span class="text-gray-500 mt-1 fw-semibold fs-6">{{ __('general.follow_all_tasks_here') }}</span>
												</h3>
												<!--end::Title-->
												<!--begin::Actions-->
												<div class="card-toolbar">
													<!--begin::Filters-->
													<div class="d-flex flex-stack flex-wrap gap-4">
														<!--begin::Status-->
														<div class="d-flex align-items-center fw-bold">
															<!--begin::Label-->
															<div class="text-muted fs-7 me-2">{{ __('general.status') }}</div>
															<!--end::Label-->
															<!--begin::Select-->
															<select
																class="form-select form-select-transparent text-gray-900 fs-7 lh-1 fw-bold py-0 ps-3 w-auto"
																data-control="select2" data-hide-search="true"
																data-dropdown-css-class="w-150px"
																data-placeholder="Select an option"
																data-kt-table-widget-5="filter_status">
																<option></option>
																<option value="Show All" selected="selected">{{ __('general.all') }}</option>
																<option value="in_progress" >{{ __('general.in_progress') }}</option>
																<option value="on_hold">{{ __('general.on_hold') }}</option>
																<option value="not_started">{{ __('general.not_started') }}</option>
																<option value="completed">{{ __('general.completed') }}</option>
															</select>
															<!--end::Select-->
														</div>
														<!--end::Status-->
														<!--begin::Actions-->
														<a href="{{route('tasks.index')}}"
															class="btn btn-primary btn-sm">{{ __('general.view_all') }}</a>
														<!--end::Actions-->
													</div>
													<!--begin::Filters-->
												</div>
												<!--end::Actions-->
											</div>
											<!--end::Card header-->
											<!--begin::Card body-->
											<div class="card-body">
												<!--begin::Table-->
												<table class="table table-hover align-middle table-row-dashed fs-6 kt-datatable gy-3"
													id="tasks_table">
													<!--begin::Table head-->
													<thead>
														<!--begin::Table row-->
														<tr
															class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
															<th class="min-w-30px">{{ __('general.id') }}</th>
															<th class="text-end pe-3 min-w-150px">{{ __('general.subject') }}</th>
															<th class="text-end pe-3 min-w-50px">{{ __('general.date') }}</th>
															<th class="text-end pe-3 min-w-50px">{{ __('general.due_date') }}</th>
															<th class="text-end pe-0 min-w-50px">{{ __('general.status') }}</th>
														</tr>
														<!--end::Table row-->
													</thead>
													<!--end::Table head-->
													<!--begin::Table body-->
													<tbody class="fw-bold text-gray-800">
														@foreach ($tasks as $task)
														<tr>
															<!--begin::Item-->
															<td class="text-start">{{$task['id']}}</td>
															<!--end::Item-->
															<!--begin::Product ID-->
															<td class="text-end"><a href="{{route('tasks.show' , $task['id'])}}">{{ Str::limit($task['subject'], 50) }}</td>
															<!--end::Product ID-->
															<!--begin::Date added-->
															<td class="text-end">{{$task['date']}}</td>
															<!--end::Date added-->
															<!--begin::Price-->
															<td class="text-end">{{$task['due_date']}}</td>
															<!--end::Price-->
															<!--begin::Price-->
															<td class="text-end">
																<span class="badge py-3 px-4 fs-7 {{ $task['status'] === 'in_progress' ? 'badge-light-primary' : '' }}
															{{ $task['status'] === 'on_hold' ? 'badge-light-warning' : '' }}
															{{ $task['status'] === 'not_started' ? 'badge-light-info' : '' }}
															{{ $task['status'] === 'completed' ? 'badge-light-success' : '' }}">{{$task['status']}}</span>
															</td>
															<!--end::Status-->
															
														</tr>
														@endforeach
													</tbody>
													<!--end::Table body-->
												</table>
												<!--end::Table-->
											</div>
											<!--end::Card body-->
										</div>
										<!--end::Table Widget 5-->
									</div>
									<!--end::Col Tasks-->

								</div>
								<!--end::Row Reminders & Tasks-->

								<!--begin::Row Finances & Contracts-->
								<div class="row gy-5 g-xl-10">

									@hasAccess('contract', 'view')
									<!--begin::Col Contracts-->
									<div class="col-xl-4 mb-xl-10">
										<!--begin::List widget 16-->
										<div class="card card-flush h-xl-100">
											<!--begin::Header-->
											<div class="card-header pt-7">
												<!--begin::Title-->
												<h3 class="card-title align-items-start flex-column">
													<span class="card-label fw-bold text-gray-800">{{ __('general.contracts') }}</span>
													<span class="text-gray-500 mt-1 fw-semibold fs-6">{{ __('general.check_all_contracts_here') }}</span>
												</h3>
												<!--end::Title-->
												<!--begin::Toolbar-->
												<div class="card-toolbar">
													<a href="{{route('contracts.index')}}" class="btn btn-sm btn-primary">{{ __('general.view_all') }}</a>
												</div>
												<!--end::Toolbar-->
											</div>
											<!--end::Header-->
											<!--begin::Body-->
											<div class="card-body pt-4 px-0">
												<!--begin::Nav-->
												<ul
													class="nav nav-pills nav-pills-custom item position-relative mx-9 mb-9">
													<!--begin::Item-->
													<li class="nav-item col-4 mx-0 p-0">
														<!--begin::Link-->
														<a class="nav-link active d-flex justify-content-center w-100 border-0 h-100"
															data-bs-toggle="pill" href="#kt_list_widget_16_tab_about_to_expired">
															<!--begin::Subtitle-->
															<span
																class="nav-text text-gray-800 fw-bold fs-6 mb-3">{{ __('general.about_to_expire') }}</span>
															<!--end::Subtitle-->
															<!--begin::Bullet-->
															<span
																class="bullet-custom position-absolute z-index-2 bottom-0 w-100 h-4px bg-primary rounded"></span>
															<!--end::Bullet-->
														</a>
														<!--end::Link-->
													</li>
													<!--end::Item-->
													<!--begin::Item-->
													<li class="nav-item col-4 mx-0 px-0">
														<!--begin::Link-->
														<a class="nav-link d-flex justify-content-center w-100 border-0 h-100"
															data-bs-toggle="pill" href="#kt_list_widget_16_tab_expired">
															<!--begin::Subtitle-->
															<span
																class="nav-text text-gray-800 fw-bold fs-6 mb-3">{{ __('general.expired') }}</span>
															<!--end::Subtitle-->
															<!--begin::Bullet-->
															<span
																class="bullet-custom position-absolute z-index-2 bottom-0 w-100 h-4px bg-primary rounded"></span>
															<!--end::Bullet-->
														</a>
														<!--end::Link-->
													</li>
													<!--end::Item-->
													<!--begin::Item-->
													<li class="nav-item col-4 mx-0 px-0">
														<!--begin::Link-->
														<a class="nav-link d-flex justify-content-center w-100 border-0 h-100"
															data-bs-toggle="pill" href="#kt_list_widget_16_tab_active">
															<!--begin::Subtitle-->
															<span
																class="nav-text text-gray-800 fw-bold fs-6 mb-3">{{ __('general.active') }}</span>
															<!--end::Subtitle-->
															<!--begin::Bullet-->
															<span
																class="bullet-custom position-absolute z-index-2 bottom-0 w-100 h-4px bg-primary rounded"></span>
															<!--end::Bullet-->
														</a>
														<!--end::Link-->
													</li>
													<!--end::Item-->
													<!--begin::Bullet-->
													<span
														class="position-absolute z-index-1 bottom-0 w-100 h-4px bg-light rounded"></span>
													<!--end::Bullet-->
												</ul>
												<!--end::Nav-->
												<!--begin::Tab Content-->
												<div class="tab-content px-9 hover-scroll-overlay-y pe-7 me-3 mb-2"
													style="height: 454px">
													<!--begin::Tap pane-->
													<div class="tab-pane fade show active" id="kt_list_widget_16_tab_about_to_expired">
														<!--begin::Item-->
														<div class="m-0">
															<!--begin::Timeline-->
															<div class="timeline">
																@foreach($aboutToExpiredContracts as $contract)
																	<div class="timeline-item pb-5">
																		<!--begin::Timeline content-->
																		<div class="timeline-content m-0">
																			<!--begin::Label-->
																			<span
																				class="fs-8 fw-bolder text-warning text-uppercase">{{$contract['client']}}</span>
																			<!--begin::Label-->
																			<!--begin::Title-->
																			<a href="#"
																				class="fs-6 text-gray-800 fw-bold d-block text-hover-primary">#{{$contract['number']}} {{$contract['subject']}}</a>
																			<!--end::Title-->
																			<!--begin::Title-->
																			<span class="fw-semibold text-gray-500">{{ __('general.from') }}: {{$contract['date']}} - {{ __('general.to') }}: {{$contract['due_date']}}</span>
																			<!--end::Title-->
																		</div>
																		<!--end::Timeline content-->
																	</div>
																@endforeach
															</div>
															<!--end::Timeline-->
														</div>
														<!--end::Item-->
													</div>
													<!--end::Tap pane-->
													<!--begin::Tap pane-->
													<div class="tab-pane fade" id="kt_list_widget_16_tab_expired">
														<!--begin::Item-->
														<div class="m-0">
															<!--begin::Timeline-->
															<div class="timeline">
																<!--begin::Timeline item-->
																<!--begin::Timeline item-->
																@foreach($expiredContracts as $contract)
																	<div class="timeline-item pb-5">
																		<!--begin::Timeline content-->
																		<div class="timeline-content m-0">
																			<!--begin::Label-->
																			<span
																				class="fs-8 fw-bolder text-danger text-uppercase">{{$contract['client']}}</span>
																			<!--begin::Label-->
																			<!--begin::Title-->
																			<a href="#"
																				class="fs-6 text-gray-800 fw-bold d-block text-hover-primary">#{{$contract['number']}} {{$contract['subject']}}</a>
																			<!--end::Title-->
																			<!--begin::Title-->
																			<span class="fw-semibold text-gray-500">{{ __('general.from') }}: {{$contract['date']}} - {{ __('general.to') }}: {{$contract['due_date']}}</span>
																			<!--end::Title-->
																		</div>
																		<!--end::Timeline content-->
																	</div>
																@endforeach
																<!--end::Timeline item-->																
															</div>
															<!--end::Timeline-->
														</div>
														<!--end::Item-->
													</div>
													<!--end::Tap pane-->
													<!--begin::Tap pane-->
													<div class="tab-pane fade" id="kt_list_widget_16_tab_active">
														<!--begin::Item-->
														<div class="m-0">
															<!--begin::Timeline-->
															<div class="timeline">
																<!--begin::Timeline item-->
																@foreach($activeContracts as $contract)
																	<div class="timeline-item pb-5">
																		<!--begin::Timeline content-->
																		<div class="timeline-content m-0">
																			<!--begin::Label-->
																			<span
																				class="fs-8 fw-bolder text-primary text-uppercase">{{$contract['client']}}</span>
																			<!--begin::Label-->
																			<!--begin::Title-->
																			<a href="#"
																				class="fs-6 text-gray-800 fw-bold d-block text-hover-primary">#{{$contract['number']}} {{$contract['subject']}}</a>
																			<!--end::Title-->
																			<!--begin::Title-->
																			<span class="fw-semibold text-gray-500">{{ __('general.from') }}: {{$contract['date']}} - {{ __('general.to') }}: {{$contract['due_date']}}</span>
																			<!--end::Title-->
																		</div>
																		<!--end::Timeline content-->
																	</div>
																@endforeach
																<!--end::Timeline item-->
															</div>
															<!--end::Timeline-->
														</div>
														<!--end::Item-->
													</div>
													<!--end::Tap pane-->
												</div>
												<!--end::Tab Content-->
											</div>
											<!--end: Card Body-->
										</div>
										<!--end::List widget 16-->
									</div>
									<!--end::Col Contracts-->
									@endhasAccess
									
									@hasAccess('finance', 'view')
									<!--begin::Col Finances-->
									<div class="col-xl-8 mb-5 mb-xl-10">
										<!--begin::Table widget 6-->
										<div class="card card-flush h-xl-100">
											<!--begin::Header-->
											<div class="card-header pt-7">
												<!--begin::Title-->
												<h3 class="card-title align-items-start flex-column">
													<span class="card-label fw-bold text-gray-800">{{ __('general.finances') }}</span>
													<span class="text-gray-500 mt-1 fw-semibold fs-6">{{ __('general.follow_all_finances_movements_here') }}</span>
												</h3>
												<!--end::Title-->
											</div>
											<!--end::Header-->
											<!--begin::Body-->
											<div class="card-body">
												<!--begin::Nav-->
												<ul class="nav nav-pills nav-pills-custom mb-3">
													<!--begin::Item-->
													<li class="nav-item mb-3 me-3 me-lg-6">
														<!--begin::Link-->
														<a class="nav-link btn btn-outline btn-flex btn-color-muted btn-active-color-primary flex-column overflow-hidden w-80px h-85px pt-5 pb-2 active" 
															data-bs-toggle="pill" href="#kt_stats_widget_6_tab_expenses">
															<!--begin::Icon-->
															<div class="nav-icon mb-2">
																<i class="ki-outline ki-purchase fs-1"></i>
															</div>
															<!--end::Icon-->
															<!--begin::Title-->
															<span
																class="nav-text text-gray-800 fw-bold fs-6 lh-1">{{ __('general.expenses') }}</span>
															<!--end::Title-->
															<!--begin::Bullet-->
															<span
																class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span>
															<!--end::Bullet-->
														</a>
														<!--end::Link-->
													</li>
													<!--end::Item-->
													<!--begin::Item-->
													<li class="nav-item mb-3 me-3 me-lg-6">
														<!--begin::Link-->
														<a class="nav-link btn btn-outline btn-flex btn-color-muted btn-active-color-primary flex-column overflow-hidden w-80px h-85px pt-5 pb-2"
															data-bs-toggle="pill" href="#kt_stats_widget_6_tab_paymentRequests">
															<!--begin::Icon-->
															<div class="nav-icon mb-2">
																<i class="ki-outline ki-tag fs-1"></i>
															</div>
															<!--end::Icon-->
															<!--begin::Title-->
															<span
																class="nav-text text-gray-800 fw-bold fs-6 lh-1">{{ __('general.paymentRequests') }}</span>
															<!--end::Title-->
															<!--begin::Bullet-->
															<span
																class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span>
															<!--end::Bullet-->
														</a>
														<!--end::Link-->
													</li>
													<!--end::Item-->
														<!--begin::Item-->
													<li class="nav-item mb-3 me-3 me-lg-6">
														<!--begin::Link-->
														<a class="nav-link btn btn-outline btn-flex btn-color-muted btn-active-color-primary flex-column overflow-hidden w-80px h-85px pt-5 pb-2"
															data-bs-toggle="pill" href="#kt_stats_widget_6_tab_invoices">
															<!--begin::Icon-->
															<div class="nav-icon mb-2">
																<i class="ki-outline ki-cheque fs-1"></i>
															</div>
															<!--end::Icon-->
															<!--begin::Title-->
															<span
																class="nav-text text-gray-800 fw-bold fs-6 lh-1">{{ __('general.invoices') }}</span>
															<!--end::Title-->
															<!--begin::Bullet-->
															<span
																class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span>
															<!--end::Bullet-->
														</a>
														<!--end::Link-->
													</li>
													<!--end::Item-->
													<!--begin::Item-->
													<li class="nav-item mb-3 me-3 me-lg-6">
														<!--begin::Link-->
														<a class="nav-link btn btn-outline btn-flex btn-color-muted btn-active-color-primary flex-column overflow-hidden w-80px h-85px pt-5 pb-2"
															data-bs-toggle="pill" href="#kt_stats_widget_6_tab_payments">
															<!--begin::Icon-->
															<div class="nav-icon mb-2">
																<i class="ki-outline ki-dollar fs-1"></i>
															</div>
															<!--end::Icon-->
															<!--begin::Title-->
															<span
																class="nav-text text-gray-800 fw-bold fs-6 lh-1">{{ __('general.payments') }}</span>
															<!--end::Title-->
															<!--begin::Bullet-->
															<span
																class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span>
															<!--end::Bullet-->
														</a>
														<!--end::Link-->
													</li>
													<!--end::Item-->
													<!--begin::Item-->
													<li class="nav-item mb-3 me-3 me-lg-6">
														<!--begin::Link-->
														<a class="nav-link btn btn-outline btn-flex btn-color-muted btn-active-color-primary flex-column overflow-hidden w-80px h-85px pt-5 pb-2"
															data-bs-toggle="pill" href="#kt_stats_widget_6_tab_creditNotes">
															<!--begin::Icon-->
															<div class="nav-icon mb-2">
																<i class="ki-outline ki-update-file fs-1"></i>
															</div>
															<!--end::Icon-->
															<!--begin::Title-->
															<span
																class="nav-text text-gray-800 fw-bold fs-6 lh-1">{{ __('general.creditNotes') }}</span>
															<!--end::Title-->
															<!--begin::Bullet-->
															<span
																class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span>
															<!--end::Bullet-->
														</a>
														<!--end::Link-->
													</li>
													<!--end::Item-->
													
												</ul>
												<!--end::Nav-->
												<!--begin::Tab Content-->
												<div class="tab-content">
													<!--begin::Tap pane-->
													<div class="tab-pane fade" id="kt_stats_widget_6_tab_invoices">
														<!--begin::Table container-->
														<div class="table-responsive">
															<!--begin::Table-->
															<table
																class="table table-row-dashed align-middle gs-0 gy-4 my-0">
																<!--begin::Table head-->
																<thead>
																	<tr
																		class="fs-7 fw-bold text-gray-500 border-bottom-0">
																		<th class="p-0 w-150px w-xxl-1500px"></th>
																		<th class="p-0 min-w-150px"></th>
																		<th class="p-0 min-w-150px"></th>
																		<th class="p-0 min-w-190px"></th>
																		<th class="p-0 w-50px"></th>
																	</tr>
																</thead>
																<!--end::Table head-->
																<!--begin::Table body-->
																<tbody>
																	@foreach($invoices as $invoice)
																	<tr>
																		<td>
																			<div class="d-flex align-items-center">
																				<div
																					class="d-flex justify-content-start flex-column">
																					<a href="#"
																						class="text-gray-900 fw-bold text-hover-primary mb-1 fs-6">{{ __('general.number') }} #{{$invoice['number']}}</a>
																					<span
																						class="text-muted fw-semibold d-block fs-7">{{ __('general.id') }} {{$invoice['id']}}</span>
																				</div>
																			</div>
																		</td>
																		<td>
																			<span
																				class="text-gray-800 fw-bold d-block mb-1 fs-6">{{$invoice['client']}}</span>
																			<span
																				class="fw-semibold text-gray-500 d-block">{{ __('general.client') }}</span>
																		</td>
																		<td>
																			<span
																				class="text-gray-800 fw-bold d-block mb-1 fs-6">{{$invoice['total']}}</span>
																			<span
																				class="fw-semibold text-gray-500 d-block">{{ __('general.total') }}</span>
																		</td>
																		<td>
																			<a href="#"
																				class="text-gray-900 fw-bold text-hover-primary d-block mb-1 fs-6">{{$invoice['date']}}</a>
																			<span
																				class="text-muted fw-semibold d-block fs-7">{{ __('general.date') }}</span>
																		</td>
																		<td>
																			<a href="#"
																				class="text-gray-900 fw-bold text-hover-primary d-block mb-1 fs-6">{{$invoice['status']}}</a>
																			<span
																				class="text-muted fw-semibold d-block fs-7">{{ __('general.status') }}</span>
																		</td>
																		<td class="text-end">
																			<a href="{{route('invoices.show' , $invoice['id'])}}"
																				class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary w-30px h-30px">
																				<i
																					class="ki-outline ki-black-right fs-2 text-gray-500"></i>
																			</a>
																		</td>
																	</tr>
																	@endforeach
																</tbody>
																<!--end::Table body-->
															</table>
														</div>
														<!--end::Table-->
														<!--begin::Actions-->
														<div class="d-flex justify-content-end mt-5">
        												    <a href="{{route('invoices.index')}}" class="btn btn-flex btn-primary btn-sm fs-7 fw-bold">{{ __('general.view_all') }}</a>
        												</div>
														<!--end::Actions-->
													</div>
													<!--end::Tap pane-->
												</div>
												<!--end::Tab Content-->
												<!--begin::Tab Content-->
												<div class="tab-content">
													<!--begin::Tap pane-->
													<div class="tab-pane fade" id="kt_stats_widget_6_tab_paymentRequests">
														<!--begin::Table container-->
														<div class="table-responsive">
															<!--begin::Table-->
															<table
																class="table table-row-dashed align-middle gs-0 gy-4 my-0">
																<!--begin::Table head-->
																<thead>
																	<tr
																		class="fs-7 fw-bold text-gray-500 border-bottom-0">
																		<th class="p-0 w-150px w-xxl-1500px"></th>
																		<th class="p-0 min-w-150px"></th>
																		<th class="p-0 min-w-150px"></th>
																		<th class="p-0 min-w-190px"></th>
																		<th class="p-0 w-50px"></th>
																	</tr>
																</thead>
																<!--end::Table head-->
																<!--begin::Table body-->
																<tbody>
																	@foreach($paymentRequests as $paymentRequest)
																	<tr>
																		<td>
																			<div class="d-flex align-items-center">
																				<div
																					class="d-flex justify-content-start flex-column">
																					<a href="#"
																						class="text-gray-900 fw-bold text-hover-primary mb-1 fs-6">{{ __('general.number') }} #{{$paymentRequest['number']}}</a>
																					<span
																						class="text-muted fw-semibold d-block fs-7">{{ __('general.id') }} {{$paymentRequest['id']}}</span>
																				</div>
																			</div>
																		</td>
																		<td>
																			<span
																				class="text-gray-800 fw-bold d-block mb-1 fs-6">{{$paymentRequest['client']}}</span>
																			<span
																				class="fw-semibold text-gray-500 d-block">{{ __('general.client') }}</span>
																		</td>
																		<td>
																			<span
																				class="text-gray-800 fw-bold d-block mb-1 fs-6">{{$paymentRequest['total']}}</span>
																			<span
																				class="fw-semibold text-gray-500 d-block">{{ __('general.total') }}</span>
																		</td>
																		<td>
																			<a href="#"
																				class="text-gray-900 fw-bold text-hover-primary d-block mb-1 fs-6">{{$paymentRequest['date']}}</a>
																			<span
																				class="text-muted fw-semibold d-block fs-7">{{ __('general.date') }}</span>
																		</td>
																		<td>
																			<a href="#"
																				class="text-gray-900 fw-bold text-hover-primary d-block mb-1 fs-6">{{$paymentRequest['status']}}</a>
																			<span
																				class="text-muted fw-semibold d-block fs-7">{{ __('general.status') }}</span>
																		</td>
																		<td class="text-end">
																			<a href="{{route('paymentRequests.show' , $paymentRequest['id'])}}"
																				class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary w-30px h-30px">
																				<i
																					class="ki-outline ki-black-right fs-2 text-gray-500"></i>
																			</a>
																		</td>
																	</tr>
																	@endforeach
																</tbody>
																<!--end::Table body-->
															</table>
														</div>
														<!--end::Table-->
														<!--begin::Actions-->
														<div class="d-flex justify-content-end mt-5">
        												    <a href="{{route('paymentRequests.index')}}" class="btn btn-flex btn-primary btn-sm fs-7 fw-bold">{{ __('general.view_all') }}</a>
        												</div>
														<!--end::Actions-->
													</div>
													<!--end::Tap pane-->	
												</div>
												<!--end::Tab Content-->
												<!--begin::Tab Content-->
												<div class="tab-content">
													<!--begin::Tap pane-->
													<div class="tab-pane fade" id="kt_stats_widget_6_tab_creditNotes">
														<!--begin::Table container-->
														<div class="table-responsive">
															<!--begin::Table-->
															<table
																class="table table-row-dashed align-middle gs-0 gy-4 my-0">
																<!--begin::Table head-->
																<thead>
																	<tr
																		class="fs-7 fw-bold text-gray-500 border-bottom-0">
																		<th class="p-0 w-150px w-xxl-1500px"></th>
																		<th class="p-0 min-w-150px"></th>
																		<th class="p-0 min-w-150px"></th>
																		<th class="p-0 min-w-190px"></th>
																		<th class="p-0 w-50px"></th>
																	</tr>
																</thead>
																<!--end::Table head-->
																<!--begin::Table body-->
																<tbody>
																	@foreach($creditNotes as $creditNote)
																	<tr>
																		<td>
																			<div class="d-flex align-items-center">
																				<div
																					class="d-flex justify-content-start flex-column">
																					<a href="#"
																						class="text-gray-900 fw-bold text-hover-primary mb-1 fs-6">{{ __('general.number') }} #{{$creditNote['number']}}</a>
																					<span
																						class="text-muted fw-semibold d-block fs-7">{{ __('general.id') }} {{$creditNote['id']}}</span>
																				</div>
																			</div>
																		</td>
																		<td>
																			<span
																				class="text-gray-800 fw-bold d-block mb-1 fs-6">{{$creditNote['client']}}</span>
																			<span
																				class="fw-semibold text-gray-500 d-block">{{ __('general.client') }}</span>
																		</td>
																		<td>
																			<span
																				class="text-gray-800 fw-bold d-block mb-1 fs-6">{{$creditNote['total']}}</span>
																			<span
																				class="fw-semibold text-gray-500 d-block">{{ __('general.total') }}</span>
																		</td>
																		<td>
																			<a href="#"
																				class="text-gray-900 fw-bold text-hover-primary d-block mb-1 fs-6">{{$creditNote['date']}}</a>
																			<span
																				class="text-muted fw-semibold d-block fs-7">{{ __('general.date') }}</span>
																		</td>
																		<td>
																			<a href="#"
																				class="text-gray-900 fw-bold text-hover-primary d-block mb-1 fs-6">{{$creditNote['status']}}</a>
																			<span
																				class="text-muted fw-semibold d-block fs-7">{{ __('general.status') }}</span>
																		</td>
																		<td class="text-end">
																			<a href="{{route('creditNotes.show' , $creditNote['id'])}}"
																				class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary w-30px h-30px">
																				<i
																					class="ki-outline ki-black-right fs-2 text-gray-500"></i>
																			</a>
																		</td>
																	</tr>
																	@endforeach
																</tbody>
																<!--end::Table body-->
															</table>
														</div>
														<!--end::Table-->
														<!--begin::Actions-->
														<div class="d-flex justify-content-end mt-5">
        												    <a href="{{route('creditNotes.index')}}" class="btn btn-flex btn-primary btn-sm fs-7 fw-bold">{{ __('general.view_all') }}</a>
        												</div>
														<!--end::Actions-->
													</div>
													<!--end::Tap pane-->
												</div>
												<!--end::Tab Content-->
												<!--begin::Tab Content-->
												<div class="tab-content">
													<!--begin::Tap pane-->
													<div class="tab-pane fade" id="kt_stats_widget_6_tab_payments">
														<!--begin::Table container-->
														<div class="table-responsive">
															<!--begin::Table-->
															<table
																class="table table-row-dashed align-middle gs-0 gy-4 my-0">
																<!--begin::Table head-->
																<thead>
																	<tr
																		class="fs-7 fw-bold text-gray-500 border-bottom-0">
																		<th class="p-0 w-150px w-xxl-1500px"></th>
																		<th class="p-0 min-w-150px"></th>
																		<th class="p-0 min-w-150px"></th>
																		<th class="p-0 min-w-190px"></th>
																		<th class="p-0 w-50px"></th>
																	</tr>
																</thead>
																<!--end::Table head-->
																<!--begin::Table body-->
																<tbody>
																	@foreach($pyments as $pyment)
																	<tr>
																		<td>
																			<div class="d-flex align-items-center">
																				<div
																					class="d-flex justify-content-start flex-column">
																					<a href="#"
																						class="text-gray-900 fw-bold text-hover-primary mb-1 fs-6">{{ __('general.number') }} #{{$pyment['number']}}</a>
																					<span
																						class="text-muted fw-semibold d-block fs-7">{{ __('general.id') }} {{$pyment['id']}}</span>
																				</div>
																			</div>
																		</td>
																		<td>
																			<span
																				class="text-gray-800 fw-bold d-block mb-1 fs-6">{{$pyment['client']}}</span>
																			<span
																				class="fw-semibold text-gray-500 d-block">{{ __('general.client') }}</span>
																		</td>
																		<td>
																			<span
																				class="text-gray-800 fw-bold d-block mb-1 fs-6">{{$pyment['total']}}</span>
																			<span
																				class="fw-semibold text-gray-500 d-block">{{ __('general.total') }}</span>
																		</td>
																		<td>
																			<a href="#"
																				class="text-gray-900 fw-bold text-hover-primary d-block mb-1 fs-6">{{$pyment['date']}}</a>
																			<span
																				class="text-muted fw-semibold d-block fs-7">{{ __('general.date') }}</span>
																		</td>
																		<td>
																			<a href="#"
																				class="text-gray-900 fw-bold text-hover-primary d-block mb-1 fs-6">{{$pyment['status']}}</a>
																			<span
																				class="text-muted fw-semibold d-block fs-7">{{ __('general.status') }}</span>
																		</td>
																		<td class="text-end">
																			<a href="{{route('pyments.show' , $pyment['id'])}}"
																				class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary w-30px h-30px">
																				<i
																					class="ki-outline ki-black-right fs-2 text-gray-500"></i>
																			</a>
																		</td>
																	</tr>
																	@endforeach
																</tbody>
																<!--end::Table body-->
															</table>
														</div>
														<!--end::Table-->
														<!--begin::Actions-->
														<div class="d-flex justify-content-end mt-5">
        												    <a href="{{route('pyments.index')}}" class="btn btn-flex btn-primary btn-sm fs-7 fw-bold">{{ __('general.view_all') }}</a>
        												</div>
														<!--end::Actions-->
													</div>
													<!--end::Tap pane-->
													<!--begin::Tap pane-->
													<div class="tab-pane fade" id="kt_stats_widget_6_tab_2">
														<!--begin::Table container-->
														<div class="table-responsive">
															<!--begin::Table-->
															<table
																class="table table-row-dashed align-middle gs-0 gy-4 my-0">
																<!--begin::Table head-->
																<thead>
																	<tr
																		class="fs-7 fw-bold text-gray-500 border-bottom-0">
																		<th class="p-0 w-200px w-xxl-450px"></th>
																		<th class="p-0 min-w-150px"></th>
																		<th class="p-0 min-w-150px"></th>
																		<th class="p-0 min-w-190px"></th>
																		<th class="p-0 w-50px"></th>
																	</tr>
																</thead>
																<!--end::Table head-->
																<!--begin::Table body-->
																<tbody>
																	<tr>
																		<td>
																			<div class="d-flex align-items-center">
																				<div
																					class="d-flex justify-content-start flex-column">
																					<a href="#"
																						class="text-gray-900 fw-bold text-hover-primary mb-1 fs-6">Guy
																						Hawkins</a>
																					<span
																						class="text-muted fw-semibold d-block fs-7">Zuid
																						Area</span>
																				</div>
																			</div>
																		</td>
																		<td>
																			<span
																				class="text-gray-800 fw-bold d-block mb-1 fs-6">2,954</span>
																			<span
																				class="fw-semibold text-gray-500 d-block">Deliveries</span>
																		</td>
																		<td>
																			<a href="#"
																				class="text-gray-900 fw-bold text-hover-primary d-block mb-1 fs-6">$59,634</a>
																			<span
																				class="text-muted fw-semibold d-block fs-7">Earnings</span>
																		</td>
																		<td>
																			<div class="rating">
																				<div class="rating-label checked">
																					<i
																						class="ki-solid ki-star fs-6"></i>
																				</div>
																				<div class="rating-label checked">
																					<i
																						class="ki-solid ki-star fs-6"></i>
																				</div>
																				<div class="rating-label checked">
																					<i
																						class="ki-solid ki-star fs-6"></i>
																				</div>
																				<div class="rating-label checked">
																					<i
																						class="ki-solid ki-star fs-6"></i>
																				</div>
																				<div class="rating-label">
																					<i
																						class="ki-solid ki-star fs-6"></i>
																				</div>
																			</div>
																			<span
																				class="text-muted fw-semibold d-block fs-7 mt-1">Rating</span>
																		</td>
																		<td class="text-end">
																			<a href="#"
																				class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary w-30px h-30px">
																				<i
																					class="ki-outline ki-black-right fs-2 text-gray-500"></i>
																			</a>
																		</td>
																	</tr>
																</tbody>
																<!--end::Table body-->
															</table>
														</div>
														<!--end::Table-->
													</div>
													<!--end::Tap pane-->
													<!--begin::Tap pane-->
													<div class="tab-pane fade" id="kt_stats_widget_6_tab_3">
														<!--begin::Table container-->
														<div class="table-responsive">
															<!--begin::Table-->
															<table
																class="table table-row-dashed align-middle gs-0 gy-4 my-0">
																<!--begin::Table head-->
																<thead>
																	<tr
																		class="fs-7 fw-bold text-gray-500 border-bottom-0">
																		<th class="p-0 w-200px w-xxl-450px"></th>
																		<th class="p-0 min-w-150px"></th>
																		<th class="p-0 min-w-150px"></th>
																		<th class="p-0 min-w-190px"></th>
																		<th class="p-0 w-50px"></th>
																	</tr>
																</thead>
																<!--end::Table head-->
																<!--begin::Table body-->
																<tbody>
																	<tr>
																		<td>
																			<div class="d-flex align-items-center">
																				<div
																					class="d-flex justify-content-start flex-column">
																					<a href="#"
																						class="text-gray-900 fw-bold text-hover-primary mb-1 fs-6">Brooklyn
																						Simmons</a>
																					<span
																						class="text-muted fw-semibold d-block fs-7">Zuid
																						Area</span>
																				</div>
																			</div>
																		</td>
																		<td>
																			<span
																				class="text-gray-800 fw-bold d-block mb-1 fs-6">1,240</span>
																			<span
																				class="fw-semibold text-gray-500 d-block">Deliveries</span>
																		</td>
																		<td>
																			<a href="#"
																				class="text-gray-900 fw-bold text-hover-primary d-block mb-1 fs-6">$5,400</a>
																			<span
																				class="text-muted fw-semibold d-block fs-7">Earnings</span>
																		</td>
																		<td>
																			<div class="rating">
																				<div class="rating-label checked">
																					<i
																						class="ki-solid ki-star fs-6"></i>
																				</div>
																				<div class="rating-label checked">
																					<i
																						class="ki-solid ki-star fs-6"></i>
																				</div>
																				<div class="rating-label checked">
																					<i
																						class="ki-solid ki-star fs-6"></i>
																				</div>
																				<div class="rating-label checked">
																					<i
																						class="ki-solid ki-star fs-6"></i>
																				</div>
																				<div class="rating-label checked">
																					<i
																						class="ki-solid ki-star fs-6"></i>
																				</div>
																			</div>
																			<span
																				class="text-muted fw-semibold d-block fs-7 mt-1">Rating</span>
																		</td>
																		<td class="text-end">
																			<a href="#"
																				class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary w-30px h-30px">
																				<i
																					class="ki-outline ki-black-right fs-2 text-gray-500"></i>
																			</a>
																		</td>
																	</tr>
																</tbody>
																<!--end::Table body-->
															</table>
														</div>
														<!--end::Table-->
													</div>
													<!--end::Tap pane-->
												</div>
												<!--end::Tab Content-->
												<!--begin::Tab Content-->
												<div class="tab-content">
													<!--begin::Tap pane-->
													<div class="tab-pane fade active show" id="kt_stats_widget_6_tab_expenses">
														<!--begin::Table container-->
														<div class="table-responsive">
															<!--begin::Table-->
															<table
																class="table table-row-dashed align-middle gs-0 gy-4 my-0">
																<!--begin::Table head-->
																<thead>
																	<tr
																		class="fs-7 fw-bold text-gray-500 border-bottom-0">
																		<th class="p-0 w-150px w-xxl-1500px"></th>
																		<th class="p-0 min-w-150px"></th>
																		<th class="p-0 min-w-150px"></th>
																		<th class="p-0 min-w-190px"></th>
																		<th class="p-0 w-50px"></th>
																	</tr>
																</thead>
																<!--end::Table head-->
																<!--begin::Table body-->
																<tbody>
																	@foreach($expenses as $expense)
																	<tr>
																		<td>
																			<div class="d-flex align-items-center">
																				<div
																					class="d-flex justify-content-start flex-column">
																					<a href="#"
																						class="text-gray-900 fw-bold text-hover-primary mb-1 fs-6">{{ __('general.number') }} #{{$expense['number']}}</a>
																					<span
																						class="text-muted fw-semibold d-block fs-7">{{ __('general.id') }} {{$expense['id']}}</span>
																				</div>
																			</div>
																		</td>
																		<td>
																			<span
																				class="text-gray-800 fw-bold d-block mb-1 fs-6">{{$expense['client']}}</span>
																			<span
																				class="fw-semibold text-gray-500 d-block">{{ __('general.client') }}</span>
																		</td>
																		<td>
																			<span
																				class="text-gray-800 fw-bold d-block mb-1 fs-6">{{$expense['total']}}</span>
																			<span
																				class="fw-semibold text-gray-500 d-block">{{ __('general.total') }}</span>
																		</td>
																		<td>
																			<a href="#"
																				class="text-gray-900 fw-bold text-hover-primary d-block mb-1 fs-6">{{$expense['date']}}</a>
																			<span
																				class="text-muted fw-semibold d-block fs-7">{{ __('general.date') }}</span>
																		</td>
																		<td>
																			<a href="#"
																				class="text-gray-900 fw-bold text-hover-primary d-block mb-1 fs-6">{{$expense['status']}}</a>
																			<span
																				class="text-muted fw-semibold d-block fs-7">{{ __('general.status') }}</span>
																		</td>
																		<td class="text-end">
																			<a href="{{route('expenses.show' , $expense['id'])}}"
																				class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary w-30px h-30px">
																				<i
																					class="ki-outline ki-black-right fs-2 text-gray-500"></i>
																			</a>
																		</td>
																	</tr>
																	@endforeach
																</tbody>
																<!--end::Table body-->
															</table>
														</div>
														<!--end::Table-->
														<!--begin::Actions-->
														<div class="d-flex justify-content-end mt-5">
        												    <a href="{{route('expenses.index')}}" class="btn btn-flex btn-primary btn-sm fs-7 fw-bold">{{ __('general.view_all') }}</a>
        												</div>
														<!--end::Actions-->
													</div>
													<!--end::Tap pane-->
												</div>
												<!--end::Tab Content-->
											</div>
											<!--end: Card Body-->
										</div>
										<!--end::Table widget 6-->
									</div>
									<!--end::Col Finances-->
									@endhasAccess

								</div>
								<!--end::Row Finances & Contracts-->
								
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

	<!--begin::utilities-->
	@include('layout._scroll_top')
	<!--end::utilities-->

	<!--begin::Javascript-->
	@include('assets._main_scripts')
	@include('assets._data_table_scripts')
	<!--end::Javascript-->

	<!--Announcement Hide Script-->
	<script>
		document.addEventListener("DOMContentLoaded", function () {
		    const card = document.getElementById('announcement-card');
		    const hideButton = document.getElementById('hide-announcement-card');
		    const latestId = "{{ $announcements->first()['id'] ?? '' }}";
		
		    const hiddenAnnouncementId = localStorage.getItem('hiddenAnnouncementId');
		
		    if (card && hiddenAnnouncementId !== latestId) {
		        card.style.display = 'block';
                            }

                            if (hideButton) {
                                hideButton.addEventListener('click', function (e) {
                                    e.preventDefault();
                                    if (card) card.style.display = 'none';
                                    localStorage.setItem('hiddenAnnouncementId', latestId);
                                });
                            }
		});
	</script>



	<!--begin::Vendors Javascript(used for this page only)-->
	<script src="{{ asset('assets/js/widgets.bundle.js') }}"></script>
	<script src="{{ asset('assets/plugins/custom/vis-timeline/vis-timeline.bundle.js') }}"></script>
	<script src="{{ asset('assets/js/models/dashboard/dashboard.js') }}"></script>
	<!--end::Vendors Javascript-->
	<!--end::Javascript-->
</body>
<!--end::Body-->

</html>
