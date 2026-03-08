<!DOCTYPE html>

@if (app()->getLocale() == 'ar')
	@include('assets._language_ar')
@else
	@include('assets._language_en')
@endif

<head>
	<title>Link Masr | {{ __('general.contact') }}</title>
	@include('assets._meta_tags')
	@include('assets._misc')

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
										<h1 class="page-heading d-flex flex-column justify-content-center text-gray-900 fw-bold fs-1 m-0" style="font-size: 2.5rem !important">
											{{ __('general.contact') }}
										</h1>
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
											<li class="breadcrumb-item text-muted">{{ __('general.contact') }}</li>
											<!--end::Item-->
										</ul>
										<!--end::Breadcrumb-->
									</div>
									<!--end::Page title-->
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
								
								<!--begin::Contact Info-->
								<div class="row g-5 g-xl-10 mb-5 mb-xl-10">
									<!--begin::Col-->
									<div class="col-xl-6">
										<!--begin::Card-->
										<div class="card card-flush h-xl-100">
											<!--begin::Card header-->
											<div class="card-header pt-7">
												<!--begin::Title-->
												<h3 class="card-title align-items-start flex-column">
													<span class="card-label fw-bold text-gray-900">معلومات الاتصال</span>
													<span class="text-gray-500 mt-1 fw-semibold fs-6">تواصل معنا عبر الطرق التالية</span>
												</h3>
												<!--end::Title-->
											</div>
											<!--end::Card header-->
											<!--begin::Card body-->
											<div class="card-body pt-5">
												<!--begin::Item-->
												<div class="d-flex align-items-center mb-8">
													<!--begin::Bullet-->
													<span class="bullet bullet-vertical h-40px bg-primary"></span>
													<!--end::Bullet-->
													<!--begin::Description-->
													<div class="flex-grow-1 ms-5">
														<div class="text-gray-800 fw-bold fs-6">البريد الإلكتروني</div>
														<span class="text-gray-500 fw-semibold fs-7">info@linkmasr.com</span>
													</div>
													<!--end::Description-->
												</div>
												<!--end::Item-->
												<!--begin::Item-->
												<div class="d-flex align-items-center mb-8">
													<!--begin::Bullet-->
													<span class="bullet bullet-vertical h-40px bg-primary"></span>
													<!--end::Bullet-->
													<!--begin::Description-->
													<div class="flex-grow-1 ms-5">
														<div class="text-gray-800 fw-bold fs-6">الهاتف</div>
														<span class="text-gray-500 fw-semibold fs-7">+20 123 456 7890</span>
													</div>
													<!--end::Description-->
												</div>
												<!--end::Item-->
												<!--begin::Item-->
												<div class="d-flex align-items-center mb-8">
													<!--begin::Bullet-->
													<span class="bullet bullet-vertical h-40px bg-primary"></span>
													<!--end::Bullet-->
													<!--begin::Description-->
													<div class="flex-grow-1 ms-5">
														<div class="text-gray-800 fw-bold fs-6">العنوان</div>
														<span class="text-gray-500 fw-semibold fs-7">القاهرة، مصر</span>
													</div>
													<!--end::Description-->
												</div>
												<!--end::Item-->
												<!--begin::Item-->
												<div class="d-flex align-items-center">
													<!--begin::Bullet-->
													<span class="bullet bullet-vertical h-40px bg-primary"></span>
													<!--end::Bullet-->
													<!--begin::Description-->
													<div class="flex-grow-1 ms-5">
														<div class="text-gray-800 fw-bold fs-6">ساعات العمل</div>
														<span class="text-gray-500 fw-semibold fs-7">الأحد - الخميس: 9:00 ص - 6:00 م</span>
													</div>
													<!--end::Description-->
												</div>
												<!--end::Item-->
											</div>
											<!--end::Card body-->
										</div>
										<!--end::Card-->
									</div>
									<!--end::Col-->
									<!--begin::Col-->
									<div class="col-xl-6">
										<!--begin::Card-->
										<div class="card card-flush h-xl-100">
											<!--begin::Card header-->
											<div class="card-header pt-7">
												<!--begin::Title-->
												<h3 class="card-title align-items-start flex-column">
													<span class="card-label fw-bold text-gray-900">إرسال رسالة</span>
													<span class="text-gray-500 mt-1 fw-semibold fs-6">أرسل لنا رسالة وسنرد عليك قريباً</span>
												</h3>
												<!--end::Title-->
											</div>
											<!--end::Card header-->
											<!--begin::Card body-->
											<div class="card-body pt-5">
												
												@if(session('success'))
													<div class="alert alert-success">
														{{ session('success') }}
													</div>
												@endif

												@if(session('error'))
													<div class="alert alert-danger">
														{{ session('error') }}
													</div>
												@endif

												<!--begin::Form-->
												<form class="form" method="POST" action="{{ route('contact.store') }}">
													@csrf
													<!--begin::Input group-->
													<div class="fv-row mb-7">
														<!--begin::Label-->
														<label class="required fs-6 fw-semibold form-label mb-2">الاسم</label>
														<!--end::Label-->
														<!--begin::Input-->
														<input class="form-control form-control-solid @error('name') is-invalid @enderror" 
															   placeholder="أدخل اسمك" name="name" value="{{ old('name') }}" />
														@error('name')
															<div class="invalid-feedback">{{ $message }}</div>
														@enderror
														<!--end::Input-->
													</div>
													<!--end::Input group-->
													<!--begin::Input group-->
													<div class="fv-row mb-7">
														<!--begin::Label-->
														<label class="required fs-6 fw-semibold form-label mb-2">البريد الإلكتروني</label>
														<!--end::Label-->
														<!--begin::Input-->
														<input class="form-control form-control-solid @error('email') is-invalid @enderror" 
															   placeholder="أدخل بريدك الإلكتروني" name="email" type="email" value="{{ old('email') }}" />
														@error('email')
															<div class="invalid-feedback">{{ $message }}</div>
														@enderror
														<!--end::Input-->
													</div>
													<!--end::Input group-->
													<!--begin::Input group-->
													<div class="fv-row mb-7">
														<!--begin::Label-->
														<label class="fs-6 fw-semibold form-label mb-2">الموضوع</label>
														<!--end::Label-->
														<!--begin::Input-->
														<input class="form-control form-control-solid @error('subject') is-invalid @enderror" 
															   placeholder="موضوع الرسالة" name="subject" value="{{ old('subject') }}" />
														@error('subject')
															<div class="invalid-feedback">{{ $message }}</div>
														@enderror
														<!--end::Input-->
													</div>
													<!--end::Input group-->
													<!--begin::Input group-->
													<div class="fv-row mb-7">
														<!--begin::Label-->
														<label class="required fs-6 fw-semibold form-label mb-2">الرسالة</label>
														<!--end::Label-->
														<!--begin::Input-->
														<textarea class="form-control form-control-solid @error('message') is-invalid @enderror" 
																  rows="6" name="message" placeholder="اكتب رسالتك هنا...">{{ old('message') }}</textarea>
														@error('message')
															<div class="invalid-feedback">{{ $message }}</div>
														@enderror
														<!--end::Input-->
													</div>
													<!--end::Input group-->
													<!--begin::Submit-->
													<button type="submit" class="btn btn-primary">
														<span class="indicator-label">إرسال الرسالة</span>
													</button>
													<!--end::Submit-->
												</form>
												<!--end::Form-->
											</div>
											<!--end::Card body-->
										</div>
										<!--end::Card-->
									</div>
									<!--end::Col-->
								</div>
								<!--end::Contact Info-->

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