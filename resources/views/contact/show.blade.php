<!DOCTYPE html>

@if (app()->getLocale() == 'ar')
	@include('assets._language_ar')
@else
	@include('assets._language_en')
@endif

<head>
	<title>Link Masr | عرض الرسالة</title>
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
											عرض الرسالة #{{ $message->id }}
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
											<li class="breadcrumb-item text-muted">
												<a href="{{ route('contact.admin') }}" class="text-muted text-hover-primary">إدارة الرسائل</a>
											</li>
											<!--end::Item-->
											<!--begin::Item-->
											<li class="breadcrumb-item">
												<span class="bullet bg-gray-500 w-5px h-2px"></span>
											</li>
											<!--end::Item-->
											<!--begin::Item-->
											<li class="breadcrumb-item text-muted">عرض الرسالة</li>
											<!--end::Item-->
										</ul>
										<!--end::Breadcrumb-->
									</div>
									<!--end::Page title-->
									<!--begin::Actions-->
									<div class="d-flex align-items-center gap-2 gap-lg-3">
										<a href="{{ route('contact.admin') }}" class="btn btn-flex btn-secondary h-40px fs-7 fw-bold">{{ __('general.back') }}</a>
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
								
								@if(session('success'))
									<div class="alert alert-success">
										{{ session('success') }}
									</div>
								@endif

								<!--begin::Row-->
								<div class="row g-5 g-xl-10">
									<!--begin::Col-->
									<div class="col-xl-8">
										<!--begin::Message Card-->
										<div class="card card-flush mb-5">
											<!--begin::Card header-->
											<div class="card-header">
												<div class="card-title">
													<h3 class="fw-bold m-0">تفاصيل الرسالة</h3>
												</div>
												<div class="card-toolbar">
													@if($message->status === 'new')
														<span class="badge badge-light-primary">جديدة</span>
													@elseif($message->status === 'read')
														<span class="badge badge-light-warning">مقروءة</span>
													@else
														<span class="badge badge-light-success">تم الرد</span>
													@endif
												</div>
											</div>
											<!--end::Card header-->
											<!--begin::Card body-->
											<div class="card-body">
												<!--begin::Details-->
												<div class="d-flex flex-wrap gap-5 mb-7">
													<div class="flex-equal">
														<label class="fs-6 fw-semibold form-label">الاسم:</label>
														<div class="fw-bold text-gray-800">{{ $message->name }}</div>
													</div>
													<div class="flex-equal">
														<label class="fs-6 fw-semibold form-label">البريد الإلكتروني:</label>
														<div class="fw-bold text-gray-800">{{ $message->email }}</div>
													</div>
												</div>
												
												<div class="d-flex flex-wrap gap-5 mb-7">
													<div class="flex-equal">
														<label class="fs-6 fw-semibold form-label">الموضوع:</label>
														<div class="fw-bold text-gray-800">{{ $message->subject ?: 'بدون موضوع' }}</div>
													</div>
													<div class="flex-equal">
														<label class="fs-6 fw-semibold form-label">تاريخ الإرسال:</label>
														<div class="fw-bold text-gray-800">{{ $message->created_at->format('Y-m-d H:i') }}</div>
													</div>
												</div>

												<div class="mb-7">
													<label class="fs-6 fw-semibold form-label mb-3">الرسالة:</label>
													<div class="p-5 bg-light-primary rounded">
														{{ $message->message }}
													</div>
												</div>
												<!--end::Details-->
											</div>
											<!--end::Card body-->
										</div>
										<!--end::Message Card-->

										@if($message->admin_reply)
										<!--begin::Reply Card-->
										<div class="card card-flush">
											<!--begin::Card header-->
											<div class="card-header">
												<div class="card-title">
													<h3 class="fw-bold m-0">الرد الإداري</h3>
												</div>
											</div>
											<!--end::Card header-->
											<!--begin::Card body-->
											<div class="card-body">
												<div class="p-5 bg-light-success rounded mb-5">
													{{ $message->admin_reply }}
												</div>
												<div class="d-flex justify-content-between text-muted">
													<span>تم الرد بواسطة: {{ $message->repliedBy->name ?? 'غير محدد' }}</span>
													<span>في: {{ $message->replied_at ? $message->replied_at->format('Y-m-d H:i') : '' }}</span>
												</div>
											</div>
											<!--end::Card body-->
										</div>
										<!--end::Reply Card-->
										@endif
									</div>
									<!--end::Col-->

									<!--begin::Col-->
									<div class="col-xl-4">
										<!--begin::Reply Form-->
										<div class="card card-flush">
											<!--begin::Card header-->
											<div class="card-header">
												<div class="card-title">
													<h3 class="fw-bold m-0">
														@if($message->admin_reply)
															تحديث الرد
														@else
															إضافة رد
														@endif
													</h3>
												</div>
											</div>
											<!--end::Card header-->
											<!--begin::Card body-->
											<div class="card-body">
												<!--begin::Form-->
												<form method="POST" action="{{ route('contact.reply', $message->id) }}">
													@csrf
													<!--begin::Input group-->
													<div class="fv-row mb-7">
														<!--begin::Label-->
														<label class="required fs-6 fw-semibold form-label mb-2">الرد:</label>
														<!--end::Label-->
														<!--begin::Input-->
														<textarea class="form-control form-control-solid @error('admin_reply') is-invalid @enderror" 
																  rows="8" name="admin_reply" placeholder="اكتب ردك هنا...">{{ old('admin_reply', $message->admin_reply) }}</textarea>
														@error('admin_reply')
															<div class="invalid-feedback">{{ $message }}</div>
														@enderror
														<!--end::Input-->
													</div>
													<!--end::Input group-->
													<!--begin::Submit-->
													<button type="submit" class="btn btn-primary w-100">
														<span class="indicator-label">
															@if($message->admin_reply)
																تحديث الرد
															@else
																إرسال الرد
															@endif
														</span>
													</button>
													<!--end::Submit-->
												</form>
												<!--end::Form-->
											</div>
											<!--end::Card body-->
										</div>
										<!--end::Reply Form-->
									</div>
									<!--end::Col-->
								</div>
								<!--end::Row-->

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