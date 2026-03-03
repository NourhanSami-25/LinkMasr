
<!DOCTYPE html>

@if (app()->getLocale() == 'ar')
	@include('assets._language_ar')
@else
	@include('assets._language_en')
@endif

<head>

	<title>Link Masr | Users Roles</title>
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
											{{ __('general.user_roles') }} </h1>
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
											<li class="breadcrumb-item text-muted">{{ __('general.hr') }}</li>
											<!--end::Item-->
											<!--begin::Item-->
											<li class="breadcrumb-item">
												<span class="bullet bg-gray-500 w-5px h-2px"></span>
											</li>
											<!--end::Item-->
											<!--begin::Item-->
											<li class="breadcrumb-item text-muted">{{ __('general.user_roles') }}</li>
											<!--end::Item-->
										</ul>
										<!--end::Breadcrumb-->
									</div>
									<!--end::Page title-->
									
									<!--begin::Actions-->
									<div class="d-flex align-items-center gap-2 gap-lg-3">
										@hasAccess('setting', 'create')
										<a href="{{route('roles.create')}}"
											class="btn btn-flex btn-primary h-40px fs-7 fw-bold">{{ __('general.create_new_role') }}</a>
										@endhasAccess
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
								<!--begin::Departments-->
								<div class="card card-flush">
                                    <!--begin::Card body-->
									<div class="card-body pt-0">
										
				                        <!--begin:Form-->
				                        <form action="{{ route('users_roles_update', $user->id) }}" method="POST" id="kt_modal_new_target_form" class="form" enctype="multipart/form-data">
				                        	@csrf
                                            @method('POST')
                                            <!--begin::Heading-->
				                        	<div class="mt-5 mb-5">
				                        		<!--begin::Title-->
				                        		<h1 class="mb-3">{{ __('general.roles_permissions') }} ({{ $user->name }} {{ __('general.id') }}#{{ $user->id }})</h1>
				                        		<!--end::Title-->
				                        	</div>
				                        	<!--end::Heading-->

											<div class="mt-10 mb-10">
											    @foreach (['junior', 'senior', 'manager', 'hr_manager', 'accountant','custom'] as $profile)
											        <label class="form-check form-check-inline">
											            <input 
											                type="checkbox" 
											                name="profile_select" 
											                class="profile-select form-check-input" 
											                value="{{ strtolower($profile) }}"> 
											            <span class="form-check-label text-capitalize">{{ __('general.' . $profile) }}</span>
											        </label>
											    @endforeach
											</div>
                                        
                                            <!--begin::Body-->
                                            <div class="fv-row">
                                            
                                                <!--begin::Table wrapper-->
                                                <div class="table-responsive">
                                                    <!--begin::Table-->
                                                    <table class="table align-middle table-row-dashed fs-6 gy-5">
                                                        <!--begin::Table row-->
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
																    <input class="form-check-input" type="checkbox" name="admin" id="admin_checkbox"
																           value="full" {{ $user->isAdmin() ? 'checked' : '' }} />
																    <span class="form-check-label fs-5">{{ __('general.full_access_all') }}</span>
																</label>
																<!--end::Checkbox-->
				                        					</td>
                                                        </tr>
                                                        <!--end::Table row-->
                                                        <!--begin::Table row-->
                                                      	@foreach ($roles as $role)
														    @if ($role->subject == 'admin')
														        @continue
														    @endif
														    <tr>
														        <td class="fs-4 fw-bold">{{ __('general.' . $role->subject) }}</td>
														        <td>
														            <div class="d-flex">
														                @foreach ($levels as $level)
														                    <label class="form-check form-check-sm form-check-custom form-check-solid me-5">
														                        <input class="form-check-input" type="checkbox" 
														                               name="roles[{{ $role->id }}][]" 
														                               value="{{ $level }}"
														                               {{ !empty($userPermissions[$role->id]) && in_array($level, $userPermissions[$role->id]) ? 'checked' : '' }}>
														                        <span class="form-check-label fs-5">{{ __('general.' . $level) }}</span>
														                    </label>
														                @endforeach
														            </div>
														        </td>
														    </tr>
														@endforeach
                                                        <!--end::Table row-->
                                                    </table>
                                                    <!--end::Table-->
                                                </div>
                                                <!--end::Table wrapper-->
                                            </div>
                                            <!--end::Body-->

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

				                        </form>
				                        <!--end:Form-->
                                    </div>
                                </div>
								<!--end::Departments-->
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
	@include('assets._data_table_scripts')

	<script src="{{ asset('assets/js/models/user/permissions-profile.js') }}"></script>
	<!--end::Javascript-->

	<script>
    	const permissionsProfiles = {
    	    junior: @json($junior_permissions),
    	    senior: @json($senior_permissions),
    	    manager: @json($manager_permissions),
    	    hr_manager: @json($hr_manager_permissions),
    	    accountant: @json($accountant_permissions),
    	};

    	const roleMap = @json($roles->pluck('id', 'subject'));
	</script>


</body>
<!--end::Body-->
</html>