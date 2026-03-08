<!DOCTYPE html>

@if (app()->getLocale() == 'ar')
	@include('assets._language_ar')
@else
	@include('assets._language_en')
@endif

<head>
	<title>Link Masr | إدارة رسائل اتصل بنا</title>
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
										<h1 class="page-heading d-flex flex-column justify-content-center text-gray-900 fw-bold fs-1 m-0" style="font-size: 2.5rem !important">
											إدارة رسائل اتصل بنا
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
											<li class="breadcrumb-item text-muted">إدارة الرسائل</li>
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
								
								@if(session('success'))
									<div class="alert alert-success">
										{{ session('success') }}
									</div>
								@endif

								<!--begin::Card-->
								<div class="card card-flush">
									<!--begin::Card header-->
									<div class="card-header align-items-center py-5 gap-2 gap-md-5">
										<!--begin::Card title-->
										<div class="card-title">
											<!--begin::Search-->
											<div class="d-flex align-items-center position-relative my-1">
												<i class="ki-outline ki-magnifier fs-3 position-absolute ms-4"></i>
												<input type="text" data-kt-table="contact_messages_table" data-kt-filter="search"
													class="form-control form-control-solid w-250px ps-12"
													placeholder="{{ __('general.search_keyword') }}" />
											</div>
											<!--end::Search-->
										</div>
										<!--end::Card title-->
									</div>
									<!--end::Card header-->
									<!--begin::Card body-->
									<div class="card-body pt-0">
										<!--begin::Table-->
										<table class="table table-hover align-middle table-row-dashed fs-6 gy-3" id="contact_messages_table">
											<thead>
												<tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
													<th class="text-center">الرقم</th>
													<th class="text-center">الاسم</th>
													<th class="text-center">البريد الإلكتروني</th>
													<th class="text-center">الموضوع</th>
													<th class="text-center">الحالة</th>
													<th class="text-center">تاريخ الإرسال</th>
													<th class="text-center">{{ __('general.actions') }}</th>
												</tr>
											</thead>
											<tbody class="fw-semibold text-gray-800">
												@foreach($messages as $message)
												<tr>
													<td class="text-center">{{ $message->id }}</td>
													<td class="text-center">{{ $message->name }}</td>
													<td class="text-center">{{ $message->email }}</td>
													<td class="text-center">{{ $message->subject ?: 'بدون موضوع' }}</td>
													<td class="text-center">
														@if($message->status === 'new')
															<span class="badge badge-light-primary">جديدة</span>
														@elseif($message->status === 'read')
															<span class="badge badge-light-warning">مقروءة</span>
														@else
															<span class="badge badge-light-success">تم الرد</span>
														@endif
													</td>
													<td class="text-center">{{ $message->created_at->format('Y-m-d H:i') }}</td>
													<td class="text-center">
														<!--begin::Action menu-->
														<a href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary"
															data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
															{{ __('general.actions') }}
															<i class="ki-outline ki-down fs-5 ms-1"></i>
														</a>
														<!--begin::Menu-->
														<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4"
															data-kt-menu="true">
															<!--begin::Menu item-->
															<div class="menu-item px-3">
																<a href="{{ route('contact.show', $message->id) }}"
																	class="menu-link px-3">{{ __('general.view') }}</a>
															</div>
															<!--end::Menu item-->
															<!--begin::Menu item-->
															<div class="menu-item px-3">
																<form method="POST" action="{{ route('contact.destroy', $message->id) }}" 
																	  onsubmit="return confirm('هل أنت متأكد من حذف هذه الرسالة؟')">
																	@csrf
																	@method('DELETE')
																	<button type="submit" class="menu-link px-3 btn btn-link text-danger p-0">
																		{{ __('general.delete') }}
																	</button>
																</form>
															</div>
															<!--end::Menu item-->
														</div>
														<!--end::Menu-->
														<!--end::Action menu-->
													</td>
												</tr>
												@endforeach
											</tbody>
										</table>
										<!--end::Table-->
										
										<!--begin::Pagination-->
										<div class="d-flex justify-content-center">
											{{ $messages->links() }}
										</div>
										<!--end::Pagination-->
									</div>
									<!--end::Card body-->
								</div>
								<!--end::Card-->

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
	<!--end::Javascript-->
</body>
<!--end::Body-->

</html>