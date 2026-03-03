<!DOCTYPE html>

@if (app()->getLocale() == 'ar')
	@include('assets._language_ar')
@else
	@include('assets._language_en')
@endif

<head>

	<title>Link Masr | Update Request</title>
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
											{{ __('general.update_user_request') }}</h1>
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
											<li class="breadcrumb-item text-muted">{{ __('general.requests') }}</li>
											<!--end::Item-->
											<!--begin::Item-->
											<li class="breadcrumb-item">
												<span class="bullet bg-gray-500 w-5px h-2px"></span>
											</li>
											<!--end::Item-->
											<!--begin::Item-->
											<li class="breadcrumb-item text-muted">{{ __('general.update') }}</li>
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
								<form action="{{route($model.'.update' , $request->id)}}" method="POST" class="form d-flex flex-column flex-lg-row"
									data-kt-redirect="apps/ecommerce/catalog/products.html" enctype="multipart/form-data">
									@csrf
                                    @method('PUT')
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
																	<input type="text" name="subject" class="form-control mb-2" value="{{ $request->subject}}" data-required="true" data-minlength="5" data-maxlength="255"/>
																	<!--end::Input-->
																</div>
																<!--end::Input group-->
																@if($model == 'money-requests')
																<!--begin::Input group-->
																<div class="fv-row w-100 flex-md-root">
																	<!--begin::Label-->
																	<label class="required form-label">{{ __('general.amount') }}</label>
																	<!--end::Label-->
																	<!--begin::Select2-->
																	<input type="number" name="amount" class="form-control mb-2" value="{{ $request->amount }}" max="10000000" data-required="true"/>
																	<!--end::Select2-->
																</div>
																<!--end::Input group-->
																@endif
                                                                @if($model == 'vacation-requests')
																<!--begin::Input group-->
																<div class="fv-row w-100 flex-md-root">
																	<!--begin::Label-->
																	<label class="required form-label">{{ __('general.type') }}</label>
																	<!--end::Label-->
																	<!--begin::Select2-->
																	<select class="form-select mb-2" name="vacation_type"
																		data-control="select2" data-hide-search="true"
																		data-placeholder="{{ __('general.select_an_option') }}" data-required="true">
																		<option></option>
                                                                        <option value="annual" {{ $request->vacation_type === 'annual' ? 'selected' : '' }}>{{ __('general.annual') }}</option>
                                                                        <option value="sick" {{ $request->vacation_type === 'sick' ? 'selected' : '' }}>{{ __('general.sick') }}</option>
                                                                        <option value="without_pay" {{ $request->vacation_type === 'without_pay' ? 'selected' : '' }}>{{ __('general.without_pay') }}</option>
                                                                        <option value="maternity" {{ $request->vacation_type === 'maternity' ? 'selected' : '' }}>{{ __('general.maternity') }}</option>
                                                                        <option value="compensation" {{ $request->vacation_type === 'compensation' ? 'selected' : '' }}>{{ __('general.compensation') }}</option>
																	</select>
																	<!--end::Select2-->
																</div>
																<!--end::Input group-->
                                                                @endif

																@if($model == 'mission-requests' || $model == 'workhome-requests'|| $model == 'overtime-requests'|| $model == 'money-requests')
																<!--begin::Input group-->
																<div class="fv-row w-100 flex-md-root">
																	<!--begin::Label-->
																	<label class="required form-label">{{ __('general.related') }}</label>
																	<!--end::Label-->
																	<!--begin::Select2-->
																	<select class="form-select mb-2 task-relation-type" name="related"
																		data-control="select2" data-hide-search="true"
																		data-placeholder="{{ __('general.select_an_option') }}" data-required="true">
																		<option></option>
																		<option value="task" {{ $request->related === 'task' ? 'selected' : '' }}>{{ __('general.task') }}</option>
																		<option value="project" {{ $request->related === 'project' ? 'selected' : '' }}>{{ __('general.project') }}</option>
																		<option value="client" {{ $request->related === 'client' ? 'selected' : '' }}>{{ __('general.client') }}</option>
																	</select>
																	<!--end::Select2-->
																</div>
																<!--end::Input group-->
																
																<!--begin::Input group-->
																<div class="fv-row w-100 flex-md-root secondary-selects select-task" 
																	style="{{ $request->related === 'task' ? '' : 'display: none;' }}">
																	<!--begin::Label-->
																	<label class="required form-label">{{ __('general.task') }}</label>
																	<!--end::Label-->
																	<!--begin::Select2-->
																	<select class="form-select mb-2" name="task"
																		data-control="select2" id="task_subject"
																		data-placeholder="{{ __('general.select_an_option') }}">
																		<option></option>
																		@foreach($tasks as $task)
																	        <option value="{{ $task->subject }}" 
																	            {{ old('task', $request->task ?? '') == $task->subject ? 'selected' : '' }}>
																	            {{ $task->subject }}
																	        </option>
																	    @endforeach
																	</select>
																	<!--end::Select2-->
																</div>
																<!--end::Input group-->
																<!--begin::Input group-->
																<div class="fv-row w-100 flex-md-root secondary-selects select-project" 
																	style="{{ $request->related === 'project' ? '' : 'display: none;' }}">
																	<!--begin::Label-->
																	<label class="required form-label">{{ __('general.project') }}</label>
																	<!--end::Label-->
																	<!--begin::Select2-->
																	<select class="form-select mb-2" name="project"
																		data-control="select2" id="project_subject"
																		data-placeholder="{{ __('general.select_an_option') }}">
																		<option></option>
																		@foreach($projects as $project)
																	        <option value="{{ $project->subject }}" 
																	            {{ old('project', $request->project ?? '') == $project->subject ? 'selected' : '' }}>
																	            {{ $project->subject }}
																	        </option>
																	    @endforeach
																	</select>
																	<!--end::Select2-->
																</div>
																<!--end::Input group-->
																<!--begin::Input group-->
																<div class="fv-row w-100 flex-md-root secondary-selects select-client"
																	style="{{ $request->related === 'client' ? '' : 'display: none;' }}">
																	<!--begin::Label-->
																	<label class="required form-label">{{ __('general.client') }}</label>
																	<!--end::Label-->
																	<!--begin::Select2-->
																	<select class="form-select mb-2" name="client"
																		data-control="select2" id="client_name"
																		data-placeholder="{{ __('general.select_an_option') }}">
																		<option></option>
																		@foreach($clients as $client)
																	        <option value="{{ $client->name }}" 
																	            {{ old('client', $request->client ?? '') == $client->subjnameect ? 'selected' : '' }}>
																	            {{ $client->name }}
																	        </option>
																	    @endforeach
																	</select>
																	<!--end::Select2-->
																</div>
																<!--end::Input group-->
																@endif
															</div>
															<!--end:InpudRow-->
															<!--begin::InpudRow-->
															<div class="mb-5 mt-5">
																<!--begin::Label-->
																<label class="form-label">{{ __('general.description') }}</label>
																<!--end::Label-->
																<!--begin::Editor-->
																<textarea class="form-control mb-2" name="description" maxlength="1024">{{ $request->description}}</textarea>
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
																	<select class="form-select mb-2" name="follower[]"
																		data-control="select2"
																		data-placeholder="{{ __('general.select_an_option') }}"  multiple="multiple">
																		<option></option>
																		@foreach($users as $user)
																	        <option value="{{ $user->id }}"
																	            @if(in_array($user->id, json_decode($request->follower ?? '[]', true)))
																	                selected
																	            @endif>
																	            {{ $user->name }}
																	        </option>
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
																	<select class="form-select mb-2" name="handover[]"
																		data-control="select2"
																		data-placeholder="{{ __('general.select_an_option') }}"  multiple="multiple">
																		<option></option>
																		@foreach($users as $user)
																	        <option value="{{ $user->id }}"
																	            @if(in_array($user->id, json_decode($request->handover ?? '[]', true)))
																	                selected
																	            @endif>
																	            {{ $user->name }}
																	        </option>
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
												@if($model != 'support-requests')
												<!--begin::Tab pane - Card Body -->
												<div class="d-flex flex-column gap-7 gap-lg-10 mb-10">
													<!--begin::General options-->
													<div class="card card-flush py-4">
														<!--begin::Card header-->
														<div class="card-header">
															<div class="card-title">
																<h2>{{ __('general.date_settings') }}</h2>
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
																	<input id="start_date" name="date" class="flatpickr-date form-control mb-2"
																		value="{{ $request->date }}" data-type="dateTime" data-required="true"/>
																	<!--end::Input-->
																</div>
																<!--end::Input group-->
																<!--begin::Input group-->
																<div class="fv-row w-100 flex-md-root">
																	<!--begin::Label-->
																	<label class="required form-label">{{ __('general.end_date') }}</label>
																	<!--end::Label-->
																	<!--begin::Input-->
																	<input id="end_date" name="due_date" class="flatpickr-date form-control mb-2"
																		value="{{ $request->due_date }}" data-type="end_date" data-required="true"/>
																	<!--end::Input-->
																	<!--begin::error-->
																	<div id="date-error" style="color: rgb(224, 19, 19); display: none;font-weight: 600"></div>
																	<!--end::error-->
																</div>
																<!--end::Input group-->
																<!--begin::Input group-->
																<!--begin::Input group-->
																<div class="fv-row w-100 flex-md-root">
																	<!--begin::Label-->
																	<label class="required form-label">{{ __('general.type') }} {{ __('general.days/hours') }}</label>
																	<!--end::Label-->
																	<!--begin::Select2-->
																	<select class="form-select mb-2 duration_type" name="duration_type"
																		data-control="select2" data-hide-search="true" id="duration_type"
																		data-placeholder="{{ __('general.select_an_option') }}" data-required="true">
																		<option></option>
																		@if($model == 'vacation-requests')
																			<option value="days" {{ $request->duration_type === 'days' ? 'selected' : '' }}>{{ __('general.days') }}</option>
																		@elseif($model == 'mission-requests' || $model == 'money-requests' || $model == 'workhome-requests')
																			<option value="days" {{ $request->duration_type === 'days' ? 'selected' : '' }}>{{ __('general.days') }}</option>
																			<option value="hours" {{ $request->duration_type === 'hours' ? 'selected' : '' }}>{{ __('general.hours') }}</option>
																		@else
																			<option value="hours" {{ $request->duration_type === 'hours' ? 'selected' : '' }}>{{ __('general.hours') }}</option>
																		@endif
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
																	<input id="duration" type="number" name="duration" value="{{$request->duration}}" class="form-control mb-2" max="10000" readonly/>
																	<!--end::Input-->
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
												@endif
											</div>
											<!--end::Tab pane-->
										</div>
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
    
	<!--begin::Javascript-->
	@include('assets._main_scripts')
	@include('assets._form_scripts')
	<script src="{{ asset('assets/js/models/staff-requests/create-form.js') }}"></script>
	<!--end::Javascript-->
</body>
<!--end::Body-->
</html>