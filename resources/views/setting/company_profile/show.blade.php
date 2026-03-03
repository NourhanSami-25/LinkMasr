<!DOCTYPE html>

@if (app()->getLocale() == 'ar')
	@include('assets._language_ar')
@else
	@include('assets._language_en')
@endif

<head>

	<title>Link Masr | Company Profile</title>
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
											{{ __('general.company_profile_details') }} </h1>
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
												<a href="{{ route('companyProfiles.index')}}" class="text-muted text-hover-primary">{{ __('general.company_profiles') }}</a>
											</li>
											<!--end::Item-->
											<!--begin::Item-->
											<li class="breadcrumb-item">
												<span class="bullet bg-gray-500 w-5px h-2px"></span>
											</li>
											<!--end::Item-->
											<!--begin::Item-->
											<li class="breadcrumb-item text-muted">{{ __('general.company_profile_details') }}</li>
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
											<div class="card-header d-flex justify-content-between align-items-center">
											    <!--begin::Title & Logo-->
											    <div class="d-flex align-items-center gap-4">
											        <!--begin::Card title-->
											        <div class="card-title mb-0">
											            <h2 class="fw-bold mb-0">{{ __('general.company_profile_details') }}</h2>
											        </div>
											        <!--end::Card title-->
												
											        <!--begin::Logo-->
											        @if($companyProfile->logo)
											            @php
											                $logoPath = app()->environment('production') 
											                    ? asset($companyProfile->logo)
											                    : asset('storage/' . $companyProfile->logo);
											            @endphp
											            <img src="{{ $logoPath }}" alt="profile picture"
											                style="height: 40px; width: auto; border-radius: 6px; border: 1px solid #dee2e6;"
											                class="shadow-sm" />
											        @endif
											        <!--end::Logo-->
											    </div>
											
											    <!--begin::Card toolbar-->
											    <div class="card-toolbar d-flex align-items-center gap-2 gap-lg-3">
											        <a href="{{ route('print.model', ['model' => 'setting\CompanyProfile', 'id' => $companyProfile->id]) }}" 
											           class="btn btn-light-primary" target="_blank">
											            {{ __('general.print&download') }}
											        </a>
											        @hasAccess('setting', 'modify')
											            <a href="{{ route('companyProfiles.edit' , $companyProfile->id)}}" 
											               class="btn btn-primary">
											                {{ __('general.edit') }}
											            </a>
											        @endhasAccess
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
																	<td class="text-gray-600 min-w-175px w-175px">{{ __('general.name') }}</td>
																	<td class="text-gray-800 fw-bold min-w-200px fw-bold">{{$companyProfile->name}}</td>
																</tr>
																<!--end::Row-->
                                                                <!--begin::Row-->
																<tr>
																	<td class="text-gray-600">{{ __('general.slogan') }}</td>
																	<td class="text-gray-800 fw-bold">{{$companyProfile->slogan}}</td>
																</tr>
																<!--end::Row-->
                                                                <!--begin::Row-->
																<tr>
																	<td class="text-gray-600">{{ __('general.business') }}</td>
																	<td class="text-gray-800 fw-bold">{{$companyProfile->business}}</td>
																</tr>
																<!--end::Row-->
																<!--begin::Row-->
																<tr>
																	<td class="text-gray-600">{{ __('general.currency') }}</td>
																	<td class="text-gray-800 fw-bold">{{$companyProfile->currency}}</td>
																</tr>
																<!--end::Row-->
                                                                <!--begin::Row-->
																<tr>
																	<td class="text-gray-600">{{ __('general.email') }}</td>
																	<td class="text-gray-800 fw-bold">{{$companyProfile->email}}</td>
																</tr>
																<!--end::Row-->
                                                                <!--begin::Row-->
																<tr>
																	<td class="text-gray-600">{{ __('general.secondary_email') }}</td>
																	<td class="text-gray-800 fw-bold">{{$companyProfile->email2}}</td>
																</tr>
																<!--end::Row-->
                                                                <!--begin::Row-->
																<tr>
																	<td class="text-gray-600">{{ __('general.support_email') }}</td>
																	<td class="text-gray-800 fw-bold">{{$companyProfile->supportEmail}}</td>
																</tr>
																<!--end::Row-->
                                                                <!--begin::Row-->
																<tr>
																	<td class="text-gray-600">{{ __('general.phone') }}</td>
																	<td class="text-gray-800 fw-bold">{{$companyProfile->phone}}</td>
																</tr>
																<!--end::Row-->
                                                                 <!--begin::Row-->
																<tr>
																	<td class="text-gray-600">{{ __('general.secondary_phone') }}</td>
																	<td class="text-gray-800 fw-bold">{{$companyProfile->phone2}}</td>
																</tr>
																<!--end::Row-->
                                                                <!--begin::Row-->
																<tr>
																	<td class="text-gray-600">{{ __('general.support_phone') }}</td>
																	<td class="text-gray-800 fw-bold">{{$companyProfile->supportPhone}}</td>
																</tr>
																<!--end::Row-->
                                                                <!--begin::Row-->
																<tr>
																	<td class="text-gray-600">{{ __('general.website') }}</td>
																	<td class="text-gray-800 fw-bold">{{$companyProfile->website}}</td>
																</tr>
																<!--end::Row-->
                                                                <!--begin::Row-->
																<tr>
																	<td class="text-gray-600">{{ __('general.bio') }}</td>
																	<td class="text-gray-800 fw-bold">{{$companyProfile->bio}}</td>
																</tr>
																<!--end::Row-->
																<!--begin::Row-->
																{{-- <tr>
																	<td class="text-gray-600">{{ __('general.company_pdf_profile') }}</td>
																	<td class="text-gray-800 fw-bold">
																		<span class="text-light fs-5 badge bg-primary"><a href="{{ route('files.preview', base64_encode($companyProfile->pdf_profile)) }}" target="_blank" class="text-light px-3">{{ __('general.preview') }}</a></span>
																		<span class="text-light fs-5 badge bg-success"><a href="{{ route('files.download', base64_encode($companyProfile->pdf_profile)) }}" target="_blank" class="text-light px-3">{{ __('general.download') }}</a></span>
																	</td>
																</tr> --}}
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
																		    @if($companyProfile->status == 'active') bg-primary
																		    @elseif($companyProfile->status == 'disabled') bg-danger
																		    @endif">
																		    {{ __('general.' . $companyProfile->status) }}
																		</span>
																	</td>
																</tr>
																<!--end::Row-->
                                                                <!--begin::Row-->
																<tr>
																	<td class="text-gray-600">{{ __('general.profile_type') }}</td>
																	<td class="fw-bold min-w-200px">
																	    <span class="text-light fs-5 badge 
																		    @if($companyProfile->type == 'main_profile') bg-primary
																		    @elseif($companyProfile->type == 'secondary_profile') bg-warning
																		    @endif">
																		    {{ __('general.' . $companyProfile->type) }}
																		</span>
																	</td>
																</tr>
																<!--end::Row-->
                                                                <!--begin::Row-->
																<tr>
																	<td class="text-gray-600">{{ __('general.country') }}</td>
																	<td class="text-gray-800 fw-bold">{{$companyProfile->country}}</td>
																</tr>
																<!--end::Row-->
																<!--begin::Row-->
																<tr>
																	<td class="text-gray-600">{{ __('general.city') }}</td>
																	<td class="text-gray-800 fw-bold">{{$companyProfile->city}}</td>
																</tr>
																<!--end::Row-->
																<!--begin::Row-->
																<tr>
																	<td class="text-gray-600">{{ __('general.address') }}</td>
																	<td class="text-gray-800 fw-bold">{{$companyProfile->address}}</td>
																</tr>
																<!--end::Row-->
																<!--begin::Row-->
																<tr>
																	<td class="text-gray-600">{{ __('general.country_code') }}</td>
																	<td class="text-gray-800 fw-bold">{{$companyProfile->country_code}}</td>
																</tr>
																<!--end::Row-->
																<!--begin::Row-->
																<tr>
																	<td class="text-gray-600">{{ __('general.zip_code') }}</td>
																	<td class="text-gray-800 fw-bold">{{$companyProfile->zip_code}}</td>
																</tr>
																<!--end::Row-->
																<!--begin::Row-->
																<tr>
																	<td class="text-gray-600">{{ __('general.tax_number') }}</td>
																	<td class="text-gray-800 fw-bold">{{$companyProfile->taxNumber}}</td>
																</tr>
																<!--end::Row-->
                                                                <!--begin::Row-->
																<tr>
																	<td class="text-gray-600">{{ __('general.registration_number') }}</td>
																	<td class="text-gray-800 fw-bold">{{$companyProfile->registrationNumber}}</td>
																</tr>
																<!--end::Row-->
                                                                <!--begin::Row-->
																<tr>
																	<td class="text-gray-600">{{ __('general.registration_date') }}</td>
																	<td class="text-gray-800 fw-bold">{{$companyProfile->registrationDate}}</td>
																</tr>
																<!--end::Row-->
                                                                <!--begin::Row-->
																<tr>
																	<td class="text-gray-600">{{ __('general.bank_account') }}</td>
																	<td class="text-gray-800 fw-bold">{{$companyProfile->bankAccount}}</td>
																</tr>
																<!--end::Row-->
                                                                <!--begin::Row-->
																<tr>
																	<td class="text-gray-600">{{ __('general.bank_account2') }}</td>
																	<td class="text-gray-800 fw-bold">{{$companyProfile->bankAccount2}}</td>
																</tr>
																<!--end::Row-->
                                                                <!--begin::Row-->
																<tr>
																	<td class="text-gray-600">{{ __('general.created_at') }}</td>
																	<td class="text-gray-800 fw-bold">{{$companyProfile->created_at}}</td>
																</tr>
																<!--end::Row-->
																{{-- <!--begin::Row-->
																<tr>
																	<td class="text-gray-600">{{ __('general.logo') }}</td>
																	<td class="text-gray-800 fw-bold">
																		<span class="text-light fs-5 badge bg-primary"><a href="{{ route('files.preview', base64_encode($companyProfile->logo)) }}" target="_blank" class="text-light px-3">{{ __('general.preview') }}</a></span>
																		<span class="text-light fs-5 badge bg-success"><a href="{{ route('files.download', base64_encode($companyProfile->logo)) }}" target="_blank" class="text-light px-3">{{ __('general.download') }}</a></span>
																	</td>
																</tr>
																<!--end::Row--> --}}
															</table>
															<!--end::Details-->
														</div>
														<!--end::Row-->
													</div>
													<!--end::Row-->
												</div>
												<!--end::Section-->
											</div>
											<!--end::Card body-->
										</div>
										<!--end::Card-->
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