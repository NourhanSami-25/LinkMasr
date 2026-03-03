<!DOCTYPE html>

@if (app()->getLocale() == 'ar')
	@include('assets._language_ar')
@else
	@include('assets._language_en')
@endif

<head>

	<title>Link Masr | Lead Details</title>
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
											{{ __('general.lead_details') }} </h1>
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
												<a href="{{ route('leads.index')}}" class="text-muted text-hover-primary">{{ __('general.leads') }}</a>
											</li>
											<!--end::Item-->
											<!--begin::Item-->
											<li class="breadcrumb-item">
												<span class="bullet bg-gray-500 w-5px h-2px"></span>
											</li>
											<!--end::Item-->
											<!--begin::Item-->
											<li class="breadcrumb-item text-muted">{{ __('general.lead_details') }}</li>
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
													<h2 class="fw-bold">{{ __('general.lead_details') }}</h2>
												</div>
												<!--begin::Card title-->
												<!--begin::Card toolbar-->
												<div class="card-toolbar">
													<a href="{{ route('print.model', ['model' => 'business\Lead', 'id' => $lead->id]) }}" class="btn btn-light-primary" target="_blank">{{ __('general.print') }}</a>
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
																	<td class="text-gray-800 fw-bold min-w-200px fw-bold">{{$lead->number}}</td>
																</tr>
																<!--end::Row-->
                                                                <!--begin::Row-->
																<tr>
																	<td class="text-gray-600">{{ __('general.subject') }}</td>
																	<td class="text-gray-800 fw-bold">{{$lead->subject}}</td>
																</tr>
																<!--end::Row-->
                                                                <!--begin::Row-->
																<tr>
																	<td class="text-gray-600">{{ __('general.created_since') }}</td>
																	<td class="text-gray-800 fw-bold">{{$lead->created_since}}</td>
																</tr>
																<!--end::Row-->
                                                                <!--begin::Row-->
																<tr>
																	<td class="text-gray-600">{{ __('general.source') }}</td>
																	<td class="text-gray-800 fw-bold">{{$lead->source}}</td>
																</tr>
																<!--end::Row-->
                                                                <!--begin::Row-->
																<tr>
																	<td class="text-gray-600">{{ __('general.created_by') }}</td>
																	<td class="text-gray-800 fw-bold">{{__getUserNameById($lead->created_by)}}</td>
																</tr>
																<!--end::Row-->
                                                                <!--begin::Row-->
																<tr>
																	<td class="text-gray-600">{{ __('general.created_at') }}</td>
																	<td class="text-gray-800 fw-bold">{{$lead->created_at}}</td>
																</tr>
																<!--end::Row-->
                                                                <!--begin::Row-->
																<tr>
																	<td class="text-gray-600">{{ __('general.lead_value') }}</td>
																	<td class="text-gray-800 fw-bold">{{$lead->lead_value}}</td>
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
																		    @if($lead->status == 'in_progress') bg-primary
																		    @elseif($lead->status == 'contracted') bg-success
																		    @elseif($lead->status == 'canceld') bg-danger
																		    @endif">
																		   	{{ __('general.' . $lead->status) }}
																		</span>
																	</td>
																</tr>
																<!--end::Row-->
                                                                <!--begin::Row-->
																<tr>
																	<td class="text-gray-600">{{ __('general.email') }}</td>
																	<td class="text-gray-800 fw-bold">{{$lead->email}}</td>
																</tr>
																<!--end::Row-->
                                                                <!--begin::Row-->
																<tr>
																	<td class="text-gray-600">{{ __('general.website') }}</td>
																	<td class="text-gray-800 fw-bold">{{$lead->website}}</td>
																</tr>
																<!--end::Row-->
																<!--begin::Row-->
																<tr>
																	<td class="text-gray-600">{{ __('general.phone') }}</td>
																	<td class="text-gray-800 fw-bold">{{$lead->phone}}</td>
																</tr>
																<!--end::Row-->
                                                                @if($lead->project_id)
																<!--begin::Row-->
																<tr>
																	<td class="text-gray-600">{{ __('general.project') }}</td>
																	<td class="text-gray-800 fw-bold">{{__getProjectSubjectById($lead->project_id) }}</td>
																</tr>
																<!--end::Row-->
                                                                @endif
																@if($lead->task_id)
																<!--begin::Row-->
																<tr>
																	<td class="text-gray-600">{{ __('general.Task') }}</td>
																	<td class="text-gray-800 fw-bold">{{__getTaskSubjectById($lead->task_id) }}</td>
																</tr>
																<!--end::Row-->
                                                                @endif
                                                                @if($lead->client_id)
                                                                <!--begin::Row-->
																<tr>
																	<td class="text-gray-600">{{ __('general.client') }}</td>
																	<td class="text-gray-800 fw-bold">{{__getClientNameById($lead->client_id) }}</td>
																</tr>
																<!--end::Row-->
                                                                @endif
                                                                @if($lead->client_name)
                                                                <!--begin::Row-->
																<tr>
																	<td class="text-gray-600">{{ __('general.client_name') }}</td>
																	<td class="text-gray-800 fw-bold">{{$lead->client_name}}</td>
																</tr>
																<!--end::Row-->
                                                                @endif
                                                                <!--begin::Row-->
																<tr>
																	<td class="text-gray-600">{{ __('general.sale_agent') }}</td>
																	<td class="text-gray-800 fw-bold">{{__getUserNameById($lead->sale_agent)}}</td>
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

												<!--begin::Notes Section-->
												@if($lead->notes || $lead->description)
												<div class="separator separator-dashed my-6"></div>
												<div class="mb-5">
													<h4 class="text-gray-800 fw-bold mb-4">
														<i class="ki-outline ki-notepad fs-3 me-2 text-primary"></i>{{ __('general.notes') }}
													</h4>
													<div class="bg-light-primary rounded p-4">
														<p class="text-gray-800 fs-5 mb-0">{{ $lead->notes ?? $lead->description ?? __('general.no_notes') }}</p>
													</div>
												</div>
												@endif
												<!--end::Notes Section-->
											</div>
											<!--end::Card body-->
										</div>
										<!--end::Card-->

										<!--begin::Notes Card (if has notes relation)-->
										@if(isset($notes) && $notes->count() > 0)
										<div class="card card-flush pt-3 mb-5 mb-xl-10">
											<div class="card-header">
												<div class="card-title">
													<h2 class="fw-bold"><i class="ki-outline ki-notepad fs-2 me-2"></i>{{ __('general.notes_history') }}</h2>
												</div>
											</div>
											<div class="card-body pt-3">
												@foreach($notes as $note)
												<div class="d-flex flex-stack py-4 border-bottom border-gray-300 border-bottom-dashed">
													<div class="d-flex align-items-center">
														<div class="symbol symbol-35px symbol-circle">
															<span class="symbol-label bg-primary text-inverse-primary fw-bold">
																{{ substr(__getUserNameById($note->created_by), 0, 2) }}
															</span>
														</div>
														<div class="ms-4">
															<p class="text-gray-800 fw-bold mb-1">{{ $note->content }}</p>
															<span class="text-muted fs-7">{{ $note->created_at->format('Y-m-d H:i') }} - {{ __getUserNameById($note->created_by) }}</span>
														</div>
													</div>
												</div>
												@endforeach
											</div>
										</div>
										@endif
										<!--end::Notes Card-->
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
	<!--end::Javascript-->
</body>
<!--end::Body-->
</html>