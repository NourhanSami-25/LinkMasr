<!DOCTYPE html>

@if (app()->getLocale() == 'ar')
	@include('assets._language_ar')
@else
	@include('assets._language_en')
@endif

<head>

	<title>Link Masr | Edit Task</title>
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
											{{ __('general.update_task') }}</h1>
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
												<a href="{{ route('tasks.index')}}" class="text-muted text-hover-primary">{{ __('general.tasks') }}</a>
											</li>
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
								<form action="{{route('tasks.update' , $task->id)}}" method="POST" class="form d-flex flex-column flex-lg-row" enctype="multipart/form-data">
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
																	<input type="text" name="subject" data-label="{{ __('general.subject') }}" class="form-control mb-2" value="{{ $task->subject }}" data-required="true" data-minlength="5" data-maxlength="255"/>																		
																	<!--end::Input-->
																</div>
																<!--end::Input group-->
																<!--begin::Input group-->
																<div class="fv-row w-100 flex-md-root">
																	<!--begin::Label-->
																	<label class="required form-label">{{ __('general.status') }}</label>
																	<!--end::Label-->
																	<!--begin::Select2-->
																	<select class="form-select mb-2" name="status" data-label="{{ __('general.status') }}"
																		data-control="select2" data-hide-search="true"
																		data-placeholder="{{ __('general.select_an_option') }}" data-required="true">
																		<option></option>
																		<option value="in_progress" {{ $task->status === 'in_progress' ? 'selected' : '' }}>{{ __('general.in_progress') }}</option>
																		<option value="on_hold" {{ $task->status === 'on_hold' ? 'selected' : '' }}>{{ __('general.on_hold') }}</option>
																		<option value="not_started" {{ $task->status === 'not_started' ? 'selected' : '' }}>{{ __('general.not_started') }}</option>
																		<option value="completed" {{ $task->status === 'completed' ? 'selected' : '' }}>{{ __('general.completed') }}</option>
																	</select>
																	<!--end::Select2-->
																</div>
																<!--end::Input group-->
																<!--begin::Input group-->
																<div class="fv-row w-100 flex-md-root">
																	<!--begin::Label-->
																	<label class="form-label">{{ __('general.type') }}</label>
																	<!--end::Label-->
																	<!--begin::Select2-->
																	<select class="form-select mb-2" name="type" data-label="{{ __('general.type') }}"
																		data-control="select2" data-hide-search="true"
																		data-placeholder="{{ __('general.select_an_option') }}">
																		<option></option>
																		<option value="private" {{ $task->type === 'private' ? 'selected' : '' }}>{{ __('general.private') }}</option>
																		<option value="public" {{ $task->type === 'public' ? 'selected' : '' }}>{{ __('general.public') }}</option>
																	</select>
																	<!--end::Select2-->
																	<!--begin::Description-->
																	<div class="text-muted fs-7">{{ __('general.optional_message') }}</div>
																	<!--end::Description-->
																</div>
																<!--end::Input group-->
															</div>
															<!--end:InpudRow-->

															<!--begin::InpudRow-->
															<div class="d-flex flex-wrap gap-5 mb-5">
																<!--begin::Input group-->
																<div class="fv-row w-100 flex-md-root">
																	<!--begin::Label-->
																	<label class="required form-label">{{ __('general.related') }}</label>
																	<!--end::Label-->
																	<!--begin::Select2-->
																	<select class="form-select mb-2 task-relation-type" name="related" data-label="{{ __('general.related_with') }}"
																		data-control="select2" data-hide-search="true"
																		data-placeholder="{{ __('general.select_an_option') }}" data-required="true">
																		<option></option>
																		<option value="project" {{ $task->related === 'project' ? 'selected' : '' }}>{{ __('general.project') }}</option>
																		<option value="client" {{ $task->related === 'client' ? 'selected' : '' }}>{{ __('general.client') }}</option>
																	</select>
																	<!--end::Select2-->
																</div>
																<!--end::Input group-->

																<!--begin::Input group-->
																<div class="fv-row w-100 flex-md-root secondary-selects select-project" style="display: none;">
																	<!--begin::Label-->
																	<label class="required form-label">{{ __('general.project') }}</label>
																	<!--end::Label-->
																	<!--begin::Select2-->
																	<select class="form-select mb-2" name="project_id" data-label="{{ __('general.project') }}"
																	        data-control="select2"
																	        data-placeholder="{{ __('general.select_an_option') }}">
																	    <option></option>
																	    @foreach($projects as $project)
																	        <option value="{{ $project->id }}" 
																	            {{ old('project_id', $task->project_id ?? '') == $project->id ? 'selected' : '' }}>
																	            {{ $project->subject }}
																	        </option>
																	    @endforeach
																	</select>
																	<!--end::Select2-->
																</div>
																<!--end::Input group-->
																<!--begin::Input group-->
																<div class="fv-row w-100 flex-md-root secondary-selects select-client" style="display: none;">
																	<!--begin::Label-->
																	<label class="required form-label">{{ __('general.client') }}</label>
																	<!--end::Label-->
																	<!--begin::Select2--> 
																	<select class="form-select mb-2" name="client_id" data-label="{{ __('general.client') }}"
																	        data-control="select2"
																	        data-placeholder="{{ __('general.select_an_option') }}">
																	    <option></option>
																	    @foreach($clients as $client)
																	        <option value="{{ $client->id }}" 
																	            {{ old('client_id', $task->client_id ?? '') == $client->id ? 'selected' : '' }}>
																	            {{ $client->name }}
																	        </option>
																	    @endforeach
																	</select>
																	<!--end::Select2-->
																</div>
																<!--end::Input group-->
																
																<!--begin::Input group-->
																<div class="fv-row w-100 flex-md-root">
																	<!--begin::Label-->
																	<label class="form-label">{{ __('general.is_billed') }}</label>
																	<!--end::Label-->
																	<!--begin::Select2-->
																	<select class="form-select mb-2" name="is_billed" data-label="{{ __('general.is_billed') }}"
																		data-control="select2" data-hide-search="true"
																		data-placeholder="{{ __('general.is_billed') }}" data-required="true">
																		<option></option>
																		<option value="1" {{ $task->is_billed === 1 ? 'selected' : '' }}>{{ __('general.yes') }}</option>
																		<option value="0" {{ $task->is_billed === 0 ? 'selected' : '' }}>{{ __('general.no') }}</option>
																	</select>
																	<!--end::Select2-->
																</div>
																<!--end::Input group-->

																<!--begin::Input group-->
																<div class="fv-row w-100 flex-md-root">
																	<!--begin::Label-->
																	<label class="form-label">{{ __('general.priority') }}</label>
																	<!--end::Label-->
																	<!--begin::Select2-->
																	<select class="form-select mb-2" name="priority" data-label="{{ __('general.priority') }}"
																		data-control="select2" data-hide-search="true"
																		data-placeholder="{{ __('general.priority') }}">
																		<option></option>
																		<option value="low" {{ $task->priority === 'low' ? 'selected' : '' }}>{{ __('general.low') }}</option>
																		<option value="medium" {{ $task->priority === 'medium' ? 'selected' : '' }}>{{ __('general.medium') }}</option>
																		<option value="high" {{ $task->priority === 'high' ? 'selected' : '' }}>{{ __('general.high') }}</option>
																		<option value="urgent" {{ $task->priority === 'urgent' ? 'selected' : '' }}>{{ __('general.urgent') }}</option>
																	</select>
																	<!--end::Select2-->
																	<!--begin::Description-->
																	<div class="text-muted fs-7">{{ __('general.optional_message') }}</div>
																	<!--end::Description-->
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
																<textarea class="form-control mb-2" name="description" data-label="{{ __('general.description') }}" data-maxlength="1024">{{ $task->description }}</textarea>
																<!--end::Editor-->
																<!--begin::Description-->
																<div class="text-muted fs-7">{{ __('general.optional_message') }}</div>
																<!--end::Description-->
															</div>
															<!--end::InpudRow-->
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
															<div class="card-title">
																<h2>{{ __('general.date_settings') }}</h2>
															</div>
														</div>
														<!--end::Card header-->
														<!--begin::Card body-->
														<div class="card-body pt-0">
															<!--begin::InputRow-->
															<div class="d-flex flex-wrap gap-5 mb-5">
																<!--begin::Input group-->
																<div class="fv-row w-100 flex-md-root">
																	<!--begin::Label-->
																	<label class="required form-label">{{ __('general.start_date') }}</label>
																	<!--end::Label-->
																	<!--begin::Input-->
																	<input class="flatpickr-date form-control mb-2" name="date" data-label="{{ __('general.start_date') }}" value="{{$task->date}}" placeholder="{{ __('general.select_a_date') }}" data-type="dateTime" data-required="true"/>
																	<!--end::Input-->
																</div>
																<!--end::Input group-->
																<!--begin::Input group-->
																<div class="fv-row w-100 flex-md-root">
																	<!--begin::Label-->
																	<label class="required form-label">{{ __('general.due_date') }}</label>
																	<!--end::Label-->
																	<!--begin::Input-->
																	<input class="flatpickr-date form-control mb-2" name="due_date" data-label="{{ __('general.dead_line') }}" value="{{$task->due_date}}" placeholder="{{ __('general.select_a_date') }}" data-type="dateTime" data-required="true"/>
																	<!--end::Input-->
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
												<div class="d-flex flex-column gap-7 gap-lg-10">
													<!--begin::General options-->
													<div class="card card-flush py-4">
														<!--begin::Card header-->
														<div class="card-header">
															<div class="card-title">
																<h2>{{ __('general.assignees_and_followers') }}</h2>
															</div>
														</div>
														<!--end::Card header-->
														<!--begin::Card body-->
														<div class="card-body pt-0">
															<!--begin::InpudRow-->
															<div class="d-flex flex-wrap gap-5">
																<!--begin::Input group-->
																<div class="fv-row w-100 flex-md-root">
																	<!--begin::Label-->
																	<label class="form-label">{{ __('general.assignees') }}</label>
																	<!--end::Label-->
																	<!--begin::Select2-->
																	<select class="form-select mb-2" name="assignees[]" data-label="{{ __('general.assignees') }}"
																	    data-control="select2"
																	    data-placeholder="{{ __('general.select_an_option') }}" multiple="multiple">
																	    <option></option>
																	    @foreach($users as $user)
																	        <option value="{{ $user->id }}"
																	            @if(in_array($user->id, json_decode($task->assignees ?? '[]', true)))
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
																	<label class="form-label">{{ __('general.followers') }}</label>
																	<!--end::Label-->
																	<!--begin::Select2-->
																	<select class="form-select mb-2" name="followers[]" data-label="{{ __('general.followers') }}"
																	    data-control="select2"
																	    data-placeholder="{{ __('general.select_an_option') }}" multiple="multiple">
																	    <option></option>
																	    @foreach($users as $user)
																	        <option value="{{ $user->id }}"
																	            @if(in_array($user->id, json_decode($task->followers ?? '[]', true)))
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
											<button type="submit"
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
	<script src="{{ asset('assets/js/models/task/create-task.js') }}"></script>
	<!--end::Javascript-->
</body>
<!--end::Body-->
</html>