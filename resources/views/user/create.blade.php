<!DOCTYPE html>

@if (app()->getLocale() == 'ar')
	@include('assets._language_ar')
@else
	@include('assets._language_en')
@endif

<head>

	<title>Link Masr | Create User</title>
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
											{{ __('general.create_new_user') }}</h1>
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
												<a href="{{ route('users.index')}}" class="text-muted text-hover-primary">{{ __('general.users') }}</a>
											</li>
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
								<form action="{{route('users.store')}}" method="POST" class="form d-flex flex-column flex-lg-row"
									data-kt-redirect="apps/ecommerce/catalog/products.html" enctype="multipart/form-data">
									@csrf
									<!--begin::Aside column-->
									<div class="d-flex flex-column gap-7 gap-lg-10 w-100 w-lg-300px mb-7 me-lg-10">
										<!--begin::Thumbnail settings-->
										<div class="card card-flush py-4">
											<!--begin::Card header-->
											<div class="card-header">
												<!--begin::Card title-->
												<div class="card-title">
													<h2>{{ __('general.profile_picture') }}</h2>
												</div>
												<!--end::Card title-->
											</div>
											<!--end::Card header-->
											<!--begin::Card body-->
											<div class="card-body text-center pt-0">
												<!--begin::Image input-->
												<!--begin::Image input placeholder-->
												<style>
													.image-input-placeholder {
														background-image: url('assets/media/svg/files/blank-image.svg');
													}

													[data-bs-theme="dark"] .image-input-placeholder {
														background-image: url('assets/media/svg/files/blank-image-dark.svg');
													}
												</style>
												<!--end::Image input placeholder-->
												<div class="image-input image-input-empty image-input-outline image-input-placeholder mb-3"
													data-kt-image-input="true">
													<!--begin::Preview existing avatar-->
													<div class="image-input-wrapper w-150px h-150px"></div>
													<!--end::Preview existing avatar-->
													<!--begin::Label-->
													<label
														class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
														data-kt-image-input-action="change" data-bs-toggle="tooltip"
														title="{{ __('general.change_picture') }}">
														<i class="ki-outline ki-pencil fs-7"></i>
														<!--begin::Inputs-->
														<input type="file" name="photo" data-label="{{ __('general.photo') }}" accept=".png, .jpg, .jpeg') }}" />
														<input type="hidden" name="avatar_remove" />
														<!--end::Inputs-->
													</label>
													<!--end::Label-->
													<!--begin::Cancel-->
													<span
														class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
														data-kt-image-input-action="cancel" data-bs-toggle="tooltip"
														title="Cancel avatar">
														<i class="ki-outline ki-cross fs-2"></i>
													</span>
													<!--end::Cancel-->
													<!--begin::Remove-->
													<span
														class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
														data-kt-image-input-action="remove" data-bs-toggle="tooltip"
														title="Remove avatar">
														<i class="ki-outline ki-cross fs-2"></i>
													</span>
													<!--end::Remove-->
												</div>
												<!--end::Image input-->
												<!--begin::Description-->
												<div class="text-muted fs-7">{{ __('general.profile_picture_info') }}</div>
												<!--end::Description-->
											</div>
											<!--end::Card body-->

											<!--begin::Card body-->
											<div class="card-body pt-0">
												<label class="required form-label">{{ __('general.status') }}</label>
												<!--begin::Select2-->
												<select class="form-select mb-2" data-control="select2" name="status" data-label="{{ __('general.status') }}"
													data-hide-search="true" data-placeholder="{{ __('general.select_an_option') }}"
													id="kt_ecommerce_add_product_status_select" required>
													<option></option>
													<option value="active" selected="selected">{{ __('general.active') }}</option>
													<option value="disabled">{{ __('general.disabled') }}</option>
												</select>
												<!--end::Select2-->
												<!--begin::Description-->
												<div class="text-muted fs-7">{{ __('general.status_info') }}</div>
												<!--end::Description-->
											</div>
											<!--end::Card body-->

											<!--begin::Card body-->
											<div class="card-body pt-0">

												<label class="required form-label">{{ __('general.user_default_language') }}</label>
												<!--begin::Select2-->
												<select class="form-select mb-2" data-control="select2" name="language" data-label="{{ __('general.user_default_language') }}"
													data-hide-search="true" data-placeholder="{{ __('general.select_an_option') }}" required>
													<option></option>
													<option value="ar" selected="selected">العربية</option>
													<option value="en">English</option>
												</select>
												<!--end::Select2-->
											</div>
											<!--end::Card body-->

										</div>
										<!--end::Thumbnail settings-->
										<!--begin::Status-->
										<div class="card card-flush py-4">
											
										</div>
										<!--end::Status-->
									</div>
									<!--end::Aside column-->
									<!--begin::Main column-->
									<div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
										<!--begin:::Tabs-->
										<ul
											class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-semibold mb-n2">
											<!--begin:::Tab item-->
											<li class="nav-item">
												<a class="nav-link text-active-primary pb-4 active" data-bs-toggle="tab"
													href="#main_data">{{ __('general.form_main_data') }}</a>
											</li>
											<!--end:::Tab item-->
											<!--begin:::Tab item-->
											<li class="nav-item">
												<a class="nav-link text-active-primary pb-4" data-bs-toggle="tab"
													href="#opitional_data">{{ __('general.form_optional_data') }}</a>
											</li>
											<!--end:::Tab item-->
											<!--begin:::Tab item-->
											<li class="nav-item">
												<a class="nav-link text-active-primary pb-4" data-bs-toggle="tab"
													href="#user_permissions">{{ __('general.user_permissions') }}</a>
											</li>
											<!--end:::Tab item-->
										</ul>
										<!--end:::Tabs-->
										<!--begin::Tab content-->
										<div class="tab-content">
											<!--begin::Tab pane-->
											<div class="tab-pane fade show active" id="main_data"
												role="tab-panel">
												<div class="d-flex flex-column gap-7 gap-lg-10">
													<!--begin::General options-->
													<div class="card card-flush py-4">
														<!--begin::Card header-->
														<div class="card-header">
															<div class="card-title">
																<h2>{{ __('general.please_fill_data') }}</h2>
															</div>
														</div>
														<!--end::Card header-->
														<!--begin::Card body-->
														<div class="card-body pt-0">
															<!--begin::Input Row-->
															<div class="d-flex flex-wrap gap-5 mb-5">
																<!--begin::Input group-->
																<div class="fv-row w-100 flex-md-root">
																	<!--begin::Label-->
																	<label class="required form-label">{{ __('general.name') }}</label>
																	<!--end::Label-->
																	<!--begin::Input-->
																	<input type="text" name="name" data-label="{{ __('general.name') }}" class="form-control mb-2"
																		value="{{ old('name') }}" data-minlength="5" data-maxlength="255" data-required="true"/>
																	<!--end::Input-->
																</div>
																<!--end::Input group-->
																<!--begin::Input group-->
																<div class="fv-row w-100 flex-md-root">
																	<!--begin::Label-->
																	<label class="form-label">{{ __('general.phone') }}</label>
																	<!--end::Label-->
																	<!--begin::Input-->
																	<input type="text" class="form-control mb-2" name="phone" data-label="{{ __('general.phone') }}"
																	value="{{ old('phone') }}"/>
																	<!--end::Input-->
																	<!--begin::Description-->
																	<div class="text-muted fs-7">{{ __('general.optional_message') }}</div>
																	<!--end::Description-->
																</div>
																<!--end::Input group-->
															</div>
															<!--end:Input Row-->
															<!--begin::Input Row-->
															<div class="d-flex flex-wrap gap-5 mb-5">
																<!--begin::Input group-->
																<div class="fv-row w-100 flex-md-root">
																	<!--begin::Label-->
																	<label class="required form-label">{{ __('general.email') }}</label>
																	<!--end::Label-->
																	<!--begin::Input-->
																		<input name="email" data-label="{{ __('general.email') }}"
																		class="form-control mb-2" placeholder=""
																		value="{{ old('email') }}" data-minlength="5" data-maxlength="255" data-type="email" data-required="true"/>
																	<!--end::Input-->
																	
																</div>
																<!--end::Input group-->
																<!--begin::Input group-->
																<div class="fv-row w-100 flex-md-root">
																    <!--begin::Label-->
																    <label class="required form-label">{{ __('general.password') }}</label>
																    <!--end::Label-->
																
																    <!--begin::Input & Button-->
																    <div class="input-group mb-2">
																        <input  name="password" data-label="{{ __('general.password') }}" id="password" class="form-control" placeholder="" data-type="password" data-minlength="10" data-maxlength="16" data-required="true"/>
																		<input type="hidden" id="plain_password" name="plain_password">
																		<button type="button" class="btn btn-secondary" id="generate-password">{{ __('general.generate') }}</button>
																    </div>
																    <!--end::Input & Button-->
																
																    <!--begin::Description-->
																    <div class="text-muted fs-7">{{ __('general.password_info') }}</div>
																    <!--end::Description-->
																</div>
																<!--end::Input group-->
															</div>
															<!--end:Input Row-->
															<!--begin::Input Row-->
															<div class="d-flex flex-wrap gap-5 mb-10">
																<!--begin::Input group-->
																<div class="fv-row w-100 flex-md-root">
																	<!--begin::Label-->
																	<label class="required form-label">{{ __('general.department') }}</label>
																	<!--end::Label-->
																	<!--begin::Select2-->
																	<select class="form-select mb-2" name="department_id" data-label="{{ __('general.department') }}"
																		data-control="select2" data-hide-search="true"
																		data-placeholder="{{ __('general.select_an_option') }}" data-required="true">
																		<option></option>
																		@foreach($departments as $department)
																			<option value="{{$department->id}}">{{$department->subject}}</option>
																		@endforeach
																	</select>
																	<!--end::Select2-->
																	
																</div>
																<!--end::Input group-->
																<!--begin::Input group-->
																<div class="fv-row w-100 flex-md-root">
																	<!--begin::Label-->
																	<label class="required form-label">{{ __('general.position') }}</label>
																	<!--end::Label-->
																	<!--begin::Select2-->
																	<select class="form-select mb-2" name="position_id" data-label="{{ __('general.position') }}"
																		data-control="select2" data-hide-search="true"
																		data-placeholder="{{ __('general.select_an_option') }}" data-required="true">
																		<option></option>
																		@foreach($positions as $position)
																			<option value="{{$position->id}}">{{$position->subject}}</option>
																		@endforeach
																	</select>
																	<!--end::Select2-->
																	
																</div>
																<!--end::Input group-->
															</div>
															<!--end:Input Row-->
															<!--begin::Input Row-->
															<div class="d-flex flex-wrap gap-5 mb-10">
																<!--begin::Input group-->
																<div class="fv-row w-100 flex-md-root">
																	<!--begin::Label-->
																	<label class="required form-label">{{ __('general.annual_balance') }}</label>
																	<!--end::Label-->
																	<!--begin::Select2-->
																	<select class="form-select mb-2" name="total_days" data-label="{{ __('general.annual_balance') }}"
																		data-control="select2"
																		data-placeholder="{{ __('general.select_an_option') }}" data-required="true">
																		<option></option>
																		<option value="15">0</option>
																		<option value="15">15</option>
																		<option value="21" selected>21</option>
																		<option value="30">30</option>
																		<option value="40">40</option>
																		
																		@for ($i=0; $i <= 100 ; $i++)
																			<option value="{{ $i }}">{{ $i }}</option>
																		@endfor
																	</select>
																	<!--end::Select2-->
																</div>
																<!--end::Input group-->
															</div>
															<!--end:Input Row-->
														</div>
														<!--end::Card header-->
													</div>
													<!--end::General options-->
												</div>
											</div>
											<!--end::Tab pane-->
											<!--begin::Tab pane-->
											<div class="tab-pane fade" id="opitional_data"
												role="tab-panel">
												<div class="d-flex flex-column gap-7 gap-lg-10">
													<!--begin::Inventory-->
													<div class="card card-flush py-4">
														<!--begin::Card header-->
														<div class="card-header">
															<div class="card-title">
																<h2>{{ __('general.please_fill_data') }}</h2>
															</div>
														</div>
														<!--end::Card header-->
														<!--begin::Card body-->
														<div class="card-body pt-0">
															<!--begin::Input Row-->
															<div class="d-flex flex-wrap gap-5 mb-5">
																<!--begin::Input group-->
																<div class="fv-row w-100 flex-md-root">
																	<!--begin::Label-->
																	<label class="form-label">{{ __('general.job_title') }}</label>
																	<!--end::Label-->
																	<!--begin::Input-->
																	<input type="text" class="form-control mb-2" name="job_title" data-label="{{ __('general.job_title') }}"
																		value="{{ old('job_title') }}" maxlength="50"/>
																	<!--end::Input-->
																	<!--begin::Description-->
																	<div class="text-muted fs-7">{{ __('general.optional_message') }}</div>
																	<!--end::Description-->
																</div>
																<!--end::Input group-->
																<!--begin::Input group-->
																<div class="fv-row w-100 flex-md-root">
																	<!--begin::Label-->
																	<label class="form-label">{{ __('general.address') }}</label>
																	<!--end::Label-->
																	<!--begin::Input-->
																	<input type="text" class="form-control mb-2" name="address" data-label="{{ __('general.address') }}"
																	value="{{ old('address') }}" maxlength="255" />
																	<!--end::Input-->
																	<!--begin::Description-->
																	<div class="text-muted fs-7">{{ __('general.optional_message') }}</div>
																	<!--end::Description-->
																</div>
																<!--end::Input group-->
															</div>
															<!--end:Input Row-->
															<!--begin::Input Row-->
															<div class="d-flex flex-wrap gap-5 mb-5">
																<!--begin::Input group-->
																<div class="fv-row w-100 flex-md-root">
																	<!--begin::Label-->
																	<label class="form-label">{{ __('general.facebook') }}</label>
																	<!--end::Label-->
																	<!--begin::Input-->
																	<input type="text" class="form-control mb-2" name="facebook" data-label="{{ __('general.facebook') }}"
																		value="{{ old('facebook') }}" maxlength="255"/>
																	<!--end::Input-->
																	<!--begin::Description-->
																	<div class="text-muted fs-7">{{ __('general.optional_message') }}</div>
																	<!--end::Description-->
																</div>
																<!--end::Input group-->
																<!--begin::Input group-->
																<div class="fv-row w-100 flex-md-root">
																	<!--begin::Label-->
																	<label class="form-label">{{ __('general.linkedin') }}</label>
																	<!--end::Label-->
																	<!--begin::Input-->
																	<input type="text" class="form-control mb-2" name="linkedin" data-label="{{ __('general.linkedin') }}"
																		value="{{ old('linkedin') }}" maxlength="255"/>
																	<!--end::Input-->
																	<!--begin::Description-->
																	<div class="text-muted fs-7">{{ __('general.optional_message') }}</div>
																	<!--end::Description-->
																</div>
																<!--end::Input group-->
															</div>
															<!--end:Input Row-->
															<!--begin::Input Row-->
															<div class="d-flex flex-wrap gap-5 mb-5">
																<!--begin::Input group-->
																<div class="fv-row w-100 flex-md-root">
																	<!--begin::Label-->
																	<label class="form-label">{{ __('general.signature') }}</label>
																	<!--end::Label-->
																	<!--begin::Input-->
																	<input type="text" class="form-control mb-2" name="signature" data-label="{{ __('general.signature') }}"
																		value="{{ old('signature') }}" maxlength="255"/>
																	<!--end::Input-->
																	<!--begin::Description-->
																	<div class="text-muted fs-7">{{ __('general.optional_message') }}</div>
																	<!--end::Description-->
																</div>
																<!--end::Input group-->
																<!--begin::Input group-->
																<div class="fv-row w-100 flex-md-root">
																	<!--begin::Label-->
																	<label class="form-label">{{ __('general.hourly_rate') }}</label>
																	<!--end::Label-->
																	<!--begin::Input-->
																	<input type="number" class="form-control mb-2" name="hourly_rate" data-label="{{ __('general.hourly_rate') }}"
																		value="{{ old('hourly_rate') }}" max="100000"/>
																	<!--end::Input-->
																	<!--begin::Description-->
																	<div class="text-muted fs-7">{{ __('general.optional_message') }}</div>
																	<!--end::Description-->
																</div>
																<!--end::Input group-->
															</div>
															<!--end:Input Row-->
															<!--end:Input Row-->
															<!--begin::Input group-->
															<div class="mb-5 mt-5">
																<!--begin::Label-->
																<label class="form-label">{{ __('general.bio') }}</label>
																<!--end::Label-->
																<!--begin::Editor-->
																<textarea class="form-control mb-2"
																	value="{{ old('bio') }}" name="bio" data-label="{{ __('general.bio') }}" maxlength="2048"></textarea>
																<!--end::Editor-->
																<!--begin::Description-->
																<div class="text-muted fs-7">{{ __('general.optional_message') }}</div>
																<!--end::Description-->
															</div>
															<!--end::Input group-->
														</div>
														<!--end::Card header-->
													</div>
													<!--end::Inventory-->
												</div>
											</div>
											<!--end::Tab pane-->
											<!--begin::Tab pane-->
											<div class="tab-pane fade" id="user_permissions"
												role="tab-panel">
												<div class="d-flex flex-column gap-7 gap-lg-10">
													<!--begin::Inventory-->
													<div class="card card-flush py-4">
														<!--begin::Card header-->
														<div class="card-header">
															<div class="card-title">
																<h2>{{ __('general.please_fill_data') }}</h2>
															</div>
														</div>
														<!--end::Card header-->
														<!--begin::Card body-->
														<div class="card-body pt-0">
															<div class="mb-4">
															    @foreach (['junior', 'senior', 'manager', 'hr_manager', 'accountant', 'custom'] as $profile)
																    <label class="form-check form-check-inline">
																        <input 
																            type="checkbox" 
																            name="profile_select[]" 
																            class="profile-select form-check-input" 
																            value="{{ strtolower($profile) }}"> 
																        <span class="form-check-label text-capitalize">{{ __('general.' . $profile) }}</span>
																    </label>
																@endforeach
															</div>

    														<table class="table">
    														    <!--begin::Table row for Admin Role-->
    														    <tr>
    														        <td class="text-primary fs-4 fw-bold">
    														            {{ __('general.administrator_access') }}
    														            <span class="ms-1" data-bs-toggle="tooltip" title="Allows a full access to the system">
    														                <i class="ki-outline ki-information-5 text-gray-500 fs-6"></i>
    														            </span>
    														        </td>
    														        <td>
    														            <!--begin::Checkbox for Admin Role-->
    														            <label class="form-check form-check-sm form-check-custom form-check-solid me-9">
    														                <input class="form-check-input" type="checkbox" name="admin" id="admin_checkbox"/>
    														                <span class="form-check-label fs-5">{{ __('general.full_access_all') }}</span>
    														            </label>
    														            <!--end::Checkbox-->
    														        </td>
    														    </tr>
    														    <!--end::Table row-->
															
    														    @foreach ($roles as $role)
    														        @php    														           
    														            $selectedPermissions = isset($junior_permissions[$role->name]) ? $junior_permissions[$role->name] : [];
    														        @endphp

    														        @if ($role->name == 'Administrator')
    														            @continue
    														        @endif
															
    														        <tr>
    														            <td class="fs-4 fw-bold">{{ __('general.' . $role->name) }}</td>
    														            <td>
    														                <div class="d-flex">
    														                    @foreach ($levels as $level)
    														                        <label class="form-check form-check-sm form-check-custom form-check-solid me-5">
    														                            <input class="form-check-input" type="checkbox" 
    														                                   name="roles[{{ $role->id }}][]"  
    														                                   value="{{ $level }}"
    														                                   {{ in_array($level, $selectedPermissions) ? 'checked' : '' }}>
    														                            <span class="form-check-label fs-5">{{ __('general.' . $level) }}</span>
    														                        </label>
    														                    @endforeach
    														                </div>
    														            </td>
    														        </tr>
    														    @endforeach
    														</table>
														</div>
														<!--end::Card header-->
													</div>
													<!--end::Inventory-->
												</div>
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
											<button type="submit" id="kt_ecommerce_add_product_submit" onclick="openTab()"
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

	<script>
    	const existingEmails = @json($emails);
	</script>
	
	@include('layout._scroll_top')
	
	<!--begin::Javascript-->
	@include('assets._main_scripts')
	@include('assets._form_scripts')
	@include('assets._user_scripts')

	

	<script>
    	const permissionsProfiles = {
    	    junior: @json($junior_permissions),
    	    senior: @json($senior_permissions),
    	    manager: @json($manager_permissions),
    	    hr_manager: @json($hr_manager_permissions),
    	    accountant: @json($accountant_permissions),
    	};

    	const roleMap = @json($roles->pluck('id', 'name'));
	</script>

	{{-- <script>
	    const generatedPassword = Math.random().toString(36).slice(-10);
	    document.getElementById('password').value = generatedPassword;
	    document.getElementById('plain_password').value = generatedPassword;
	</script> --}}

	{{-- <script>
    	function openTab() {
    	    setTimeout(() => {
    	        window.open("{{ route('user.showData') }}", '_blank');
    	    }, 1000); // delay to allow the redirect to happen
    	}
	</script> --}}
	<!--end::Javascript-->

</body>
<!--end::Body-->
</html>