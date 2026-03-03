<!DOCTYPE html>

@if (app()->getLocale() == 'ar')
	@include('assets._language_ar')
@else
	@include('assets._language_en')
@endif

<head>

	<title>Link Masr | Login</title>
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


	<style>
	.hover-link {
	    transition: color 0.3s ease, transform 0.3s ease;
	}
	
	.hover-link:hover {
	    color: #0056b3;
	    transform: scale(1.05);
	    text-decoration: underline;
	}
	</style>

</head>
<!--end::Head-->
<!--begin::Body-->
<body id="kt_body" class="app-blank bgi-size-cover bgi-position-center bgi-no-repeat">
	<!--begin::Theme mode setup on page load-->
		<!--end::Theme mode setup on page load-->
	<!--begin::Root-->
	<div class="d-flex flex-column flex-root" id="kt_app_root">
		<!--begin::Page bg image-->
		<style>
			body {
				background-image: url('assets/media/auth/bg15-dark.jpg');
			}

			[data-bs-theme="dark"] body {
				background-image: url('assets/media/auth/bg15-dark.jpg');
			}
		</style>
		<!--end::Page bg image-->
		<!--begin::Authentication - Signup Welcome Message -->
		<div class="d-flex flex-column flex-center flex-column-fluid">
			<!--begin::Content-->
			<div class="d-flex flex-column flex-center text-center p-10">
				<!--begin::Wrapper-->
				<!--begin::Card-->
				<div class="bg-body d-flex flex-column align-items-stretch flex-center rounded-4 w-md-600px p-20">
					<!--begin::Wrapper-->
					<div class="d-flex flex-center flex-column flex-column-fluid px-lg-10 pb-15 pb-lg-10">
						<!--begin::Form-->
						<form method="POST" action="{{ route('login') }}" class="form w-100" id="login-form">
							@csrf
							<!--begin::Heading-->
							<div class="text-center mb-10">
								<!--begin::Logo-->
								<div class="mb-15">
									<a href="#" class="">
										 <img alt="Logo" src="{{ asset('assets/media/logos/logo_dark.webp') }}"
                						    class="h-50px theme-light-show" />
                						<img alt="Logo" src="{{ asset('assets/media/logos/logo_dark.webp') }}"
                						    class="h-50px theme-dark-show" />
									</a>
								</div>
								<!--end::Logo-->
								<!--begin::Title-->
								<h1 class="text-gray-900 fw-bolder mb-3" style="font-size: 2.5rem">{{__('general.sign_in')}}</h1>
								<!--end::Title-->
							</div>
							<!--begin::Heading-->

    						<!--begin::error message -->
    						@if ($errors->has('login'))
    						    <div class="fs-5 fw-bold mb-5" style="color: rgb(212, 31, 31);">
    						        {{ $errors->first('login') }}
    						    </div>
    						@endif
							<!--end::error message -->

							<!--begin::Input group=-->
							<div class="fv-row mb-5">
								<!--begin::Email-->
								<input type="text" name="email" placeholder="{{__('general.email')}}" class="form-control bg-transparent"/>
								<div class="fs-5 fw-bold mt-2" id="email-error" style="color: rgb(212, 31, 31); display: none;"></div>
								<!--end::Email-->
							</div>
							<!--end::Input group=-->
							<div class="fv-row mb-10">
								<!--begin::Password-->
								<input type="password" name="password" placeholder="{{__('general.password')}}" class="form-control bg-transparent"/>
								<!--end::Password-->
								<div class="fs-5 fw-bold mt-2" id="password-error" style="color: rgb(212, 31, 31); display: none;"></div>
							</div>
							<!--end::Input group=-->
							<div class="fv-row mb-8 fv-plugins-icon-container">
    						    <label class="form-check form-check-inline">
    						        <input class="form-check-input" type="checkbox" name="remember" value="1">
    						        <span class="form-check-label fw-semibold text-gray-700 fs-base ms-1">{{__('general.remember_me')}}</span>
    						    </label>
    						</div>
							<!--begin::Submit button-->
							<div class="d-grid mb-10 mt-10">
								<button type="submit" id="kt_sign_in_submit" class="btn btn-primary">
									<!--begin::Indicator label-->
									<span class="indicator-label">{{__('general.sign_in')}}</span>
									<!--end::Indicator label-->
									<!--begin::Indicator progress-->
									<span class="indicator-progress">{{__('general.please_wait')}}
										<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
									<!--end::Indicator progress-->
								</button>
							</div>
							<!--end::Submit button-->
						</form>
						<!--end::Form-->
					</div>
					<!--end::Wrapper-->
					<!--begin::Footer-->
					<div class="d-flex flex-stack px-lg-10">
						{{-- <!--begin::Languages-->
						<div class="me-0">
							<!--begin::Toggle-->
							<button
								class="btn btn-flex btn-link btn-color-gray-700 btn-active-color-primary rotate fs-base"
								data-kt-menu-trigger="click" data-kt-menu-placement="bottom-start"
								data-kt-menu-offset="0px, 0px">
								<img data-kt-element="current-lang-flag" class="w-20px h-20px rounded me-3"
									src="{{ asset('assets/media/flags/united-states.svg') }}" alt="" />
								<span data-kt-element="current-lang-name" class="me-1">{{__('general.english')}}</span>
								<i class="ki-outline ki-down fs-5 text-muted rotate-180 m-0"></i>
							</button>
							<!--end::Toggle-->
							<!--begin::Menu-->
							<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px py-4 fs-7"
								data-kt-menu="true" id="kt_auth_lang_menu">
								<!--begin::Menu item-->
								<div class="menu-item px-3">
									<a href="#" class="menu-link d-flex px-5" data-kt-lang="English">
										<span class="symbol symbol-20px me-4">
											<img data-kt-element="lang-flag" class="rounded-1"
												src="{{ asset('assets/media/flags/united-states.svg') }}" alt="" />
										</span>
										<span data-kt-element="lang-name">{{__('general.english')}}</span>
									</a>
								</div>
								<!--end::Menu item-->
								<!--begin::Menu item-->
								<div class="menu-item px-3">
									<a href="#" class="menu-link d-flex px-5" data-kt-lang="Spanish">
										<span class="symbol symbol-20px me-4">
											<img data-kt-element="lang-flag" class="rounded-1"
												src="{{ asset('assets/media/flags/spain.svg') }}" alt="" />
										</span>
										<span data-kt-element="lang-name">{{__('general.arabic')}}</span>
									</a>
								</div>
								<!--end::Menu item-->
							</div>
							<!--end::Menu-->
						</div>
						<!--end::Languages--> --}}
						<!--begin::Links-->
						<div class="container text-center py-4">
						    <div class="d-inline-flex fw-semibold text-primary fs-5 gap-4">
						        <a href="https://www.lexpro.qa/support/" target="_blank" class="text-decoration-none hover-link">
						            {{ __('general.support') }}
						        </a>
						        <a href="https://www.lexpro.qa/" target="_blank" class="text-decoration-none hover-link">
						            {{ __('general.contact_us') }}
						        </a>
						    </div>
						</div>
						<!--end::Links-->
					</div>
					<!--end::Footer-->
				</div>
				<!--end::Card-->
				<!--end::Wrapper-->
			</div>
			<!--end::Content-->
		</div>
		<!--end::Authentication - Signup Welcome Message-->
	</div>
	<!--end::Root-->

	<!--begin::Javascript-->
	@include('assets._main_scripts')

	<!--begin::Custom Javascript(used for this page only)-->
	<script src="{{ asset('assets/js/custom/authentication/sign-up/coming-soon.js') }}"></script>
	<script src="{{ asset('assets/js/authintication/login.js') }}"></script>
	<!--end::Custom Javascript-->
	<!--end::Javascript-->

	
</body>
<!--end::Body-->

</html>