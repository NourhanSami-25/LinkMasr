<!DOCTYPE html>

@if (app()->getLocale() == 'ar')
	@include('assets._language_ar')
@else
	@include('assets._language_en')
@endif

<head>

	<title>Link Masr | Update Company</title>
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
											{{ __('general.update_company_profile') }}</h1>
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
								<form action="{{route('companyProfiles.update' , $companyProfile->id)}}" method="POST" class="form d-flex flex-column flex-lg-row"
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
																	<label class="required form-label">{{ __('general.name') }}</label>
																	<!--end::Label-->
																	<!--begin::Input-->
																	<input type="text" name="name" class="form-control mb-2" value="{{$companyProfile->name}}" data-required="true" data-minlength="2" data-maxlength="255"/>																		
																	<!--end::Input-->
																</div>
																<!--end::Input group-->
                                                                <!--begin::Input group-->
																<div class="fv-row w-100 flex-md-root">
																	<!--begin::Label-->
																	<label class="form-label">{{ __('general.slogan') }}</label>
																	<!--end::Label-->
																	<!--begin::Input-->
																	<input type="text" name="slogan" class="form-control mb-2" value="{{$companyProfile->slogan}}"/>																		
																	<!--end::Input-->
                                                                    
																</div>
																<!--end::Input group-->
                                                            </div>
                                                            <!--end::InpudRow-->
                                                            <!--begin::InpudRow-->
															<div class="d-flex flex-wrap gap-5 mb-5">
																<!--begin::Input group-->
	                                                            <div class="fv-row w-100 flex-md-root">
	                                                            	<!--begin::Label-->
	                                                            	<label class="required form-label">{{ __('general.profile_type') }}</label>
	                                                            	<!--end::Label-->
	                                                            	<!--begin::Select2-->
	                                                            	<select class="form-select mb-2" name="type"
	                                                            		data-control="select2" data-hide-search="true"
	                                                            		data-placeholder="{{ __('general.select_an_option') }}" data-required="true">
	                                                            		<option></option>
                                                                        <option value="main_profile" {{ $companyProfile->type === 'main_profile' ? 'selected' : '' }}>{{ __('general.main_profile') }}</option>
                                                                        <option value="secondary_profile" {{ $companyProfile->type === 'secondary_profile' ? 'selected' : '' }}>{{ __('general.secondary_profile') }}</option>
	                                                            	</select>
	                                                            	<!--end::Select2-->
	                                                            </div>
	                                                            <!--end::Input group-->
                                                                <!--begin::Input group-->
	                                                            <div class="fv-row w-100 flex-md-root">
	                                                            	<!--begin::Label-->
	                                                            	<label class="required form-label">{{ __('general.status') }}</label>
	                                                            	<!--end::Label-->
	                                                            	<!--begin::Select2-->
	                                                            	<select class="form-select mb-2" name="status"
	                                                            		data-control="select2" data-hide-search="true"
	                                                            		data-placeholder="{{ __('general.select_an_option') }}" data-required="true">
	                                                            		<option></option>
                                                                        <option value="active" {{ $companyProfile->status === 'active' ? 'selected' : '' }}>{{ __('general.active') }}</option>
                                                                        <option value="disabled" {{ $companyProfile->status === 'disabled' ? 'selected' : '' }}>{{ __('general.disabled') }}</option>
	                                                            	</select>
	                                                            	<!--end::Select2-->
	                                                            </div>
	                                                            <!--end::Input group-->
																<!--begin::Input group-->
																<div class="col mb-5">
																	<!--begin::Label-->
																	<label class="required form-label fw-bold fs-6 text-gray-700">{{ __('general.currency') }} <span class="fw-regular fs-7 text-warning">({{ __('general.change_currency_note') }})</span></label>
																	<!--end::Label-->
																	<!--begin::Select-->
																	<select name="currency" aria-label="Select a currency"
																		data-control="select2" data-hide-search="true" data-placeholder="....."
																		class="form-select" data-required="true">
																		<option></option>
																		@foreach($currencies as $currency)
																	    <option value="{{ $currency->code }}" 
																	        {{ old('currency', $companyProfile->currency ?? '') == $currency->code ? 'selected' : '' }}>
																	        {{ $currency->code }}
																	    </option>
																		@endforeach
																	</select>
																	<!--end::Select-->
																</div>
																<!--end::Input group-->
                                                            </div>
                                                            <!--end::InpudRow-->
                                                            <!--begin::InpudRow-->
															<div class="d-flex flex-wrap gap-5 mb-5">
                                                                <!--begin::Input group-->
																<div class="fv-row w-100 flex-md-root">
																	<!--begin::Label-->
																	<label class="form-label">{{ __('general.about_company') }}</label>
																	<!--end::Label-->
																	<!--begin::Input-->
																	<textarea type="text" name="bio" class="form-control mb-2">{{$companyProfile->bio}}</textarea>																		
																	<!--end::Input-->
                                                                    
																</div>
																<!--end::Input group-->
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
																<h2>{{ __('general.contact_data') }}</h2>
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
																	<label class="required form-label">{{ __('general.email') }}</label>
																	<!--end::Label-->
																	<!--begin::Input-->
																	<input type="text" name="email" class="form-control mb-2" value="{{$companyProfile->email}}" data-type="email" data-required="true" data-minlength="2" data-maxlength="50"/>																		
																	<!--end::Input-->
																</div>
																<!--end::Input group-->
                                                             	<!--begin::Input group-->
																<div class="fv-row w-100 flex-md-root">
																	<!--begin::Label-->
																	<label class="form-label">{{ __('general.secondary_email') }}</label>
																	<!--end::Label-->
																	<!--begin::Input-->
																	<input type="text" name="email2" class="form-control mb-2" value="{{$companyProfile->email2}}" data-type="email" data-minlength="2" data-maxlength="50"/>																		
																	<!--end::Input-->
                                                                     
																</div>
																<!--end::Input group-->
                                                                <!--begin::Input group-->
																<div class="fv-row w-100 flex-md-root">
																	<!--begin::Label-->
																	<label class="form-label">{{ __('general.support_email') }}</label>
																	<!--end::Label-->
																	<!--begin::Input-->
																	<input type="text" name="supportEmail" class="form-control mb-2" value="{{$companyProfile->supportEmail}}" data-type="email" data-minlength="2" data-maxlength="50"/>																		
																	<!--end::Input-->
                                                                     
																</div>
																<!--end::Input group-->
                                                            </div>
                                                            <!--end::InpudRow-->
                                                            <!--begin::InpudRow-->
															<div class="d-flex flex-wrap gap-5 mb-5">
																<!--begin::Input group-->
																<div class="fv-row w-100 flex-md-root">
																	<!--begin::Label-->
																	<label class="required form-label">{{ __('general.phone') }}</label>
																	<!--end::Label-->
																	<!--begin::Input-->
																	<input type="text" name="phone" class="form-control mb-2" value="{{$companyProfile->phone}}" data-required="true" data-minlength="5" data-maxlength="50"/>																		
																	<!--end::Input-->
																</div>
																<!--end::Input group-->
                                                                <!--begin::Input group-->
																<div class="fv-row w-100 flex-md-root">
																	<!--begin::Label-->
																	<label class="form-label">{{ __('general.secondary_phone') }}</label>
																	<!--end::Label-->
																	<!--begin::Input-->
																	<input type="text" name="phone2" class="form-control mb-2" value="{{$companyProfile->phone2}}" data-minlength="5" data-maxlength="50"/>																		
																	<!--end::Input-->
                                                                    
																</div>
																<!--end::Input group-->
                                                                <!--begin::Input group-->
																<div class="fv-row w-100 flex-md-root">
																	<!--begin::Label-->
																	<label class="form-label">{{ __('general.support_phone') }}</label>
																	<!--end::Label-->
																	<!--begin::Input-->
																	<input type="text" name="supportPhone" class="form-control mb-2" value="{{$companyProfile->supportPhone}}" data-minlength="5" data-maxlength="50"/>																		
																	<!--end::Input-->
                                                                    
																</div>
																<!--end::Input group-->
                                                            </div>
                                                            <!--end::InpudRow-->
                                                            <!--begin::InpudRow-->
															<div class="d-flex flex-wrap gap-5 mb-5">
																<!--begin::Input group-->
																<div class="fv-row w-100 flex-md-root">
																	<!--begin::Label-->
																	<label class="form-label">{{ __('general.website') }}</label>
																	<!--end::Label-->
																	<!--begin::Input-->
																	<input type="text" name="website" class="form-control mb-2" value="{{$companyProfile->website}}"  data-minlength="2" data-maxlength="255"/>																		
																	<!--end::Input-->
                                                                    
																</div>
																<!--end::Input group-->
                                                                <!--begin::Input group-->
																<div class="fv-row w-100 flex-md-root">
																	<!--begin::Label-->
																	<label class="required form-label">{{ __('general.country') }}</label>
																	<!--end::Label-->
																	<!--begin::Input-->
																	<input type="text" name="country" class="form-control mb-2" value="{{$companyProfile->country}}" data-required="true" data-minlength="2" data-maxlength="255"/>																		
																	<!--end::Input-->
																</div>
																<!--end::Input group-->
                                                                <!--begin::Input group-->
																<div class="fv-row w-100 flex-md-root">
																	<!--begin::Label-->
																	<label class="required form-label">{{ __('general.address') }}</label>
																	<!--end::Label-->
																	<!--begin::Input-->
																	<input type="text" name="address" class="form-control mb-2" value="{{$companyProfile->address}}" data-required="true" data-minlength="2" data-maxlength="255"/>																		
																	<!--end::Input-->
																</div>
																<!--end::Input group-->
                                                            </div>
                                                            <!--end::InpudRow-->
															<!--begin::InpudRow-->
															<div class="d-flex flex-wrap gap-5 mb-5">
																<!--begin::Input group-->
																<div class="fv-row w-100 flex-md-root">
																	<!--begin::Label-->
																	<label class="form-label">{{ __('general.city') }}</label>
																	<!--end::Label-->
																	<!--begin::Input-->
																	<input type="text" name="city" class="form-control mb-2" value="{{ $companyProfile->city }}"  data-minlength="2" data-maxlength="255"/>																		
																	<!--end::Input-->
																</div>
																<!--end::Input group-->
                                                                <!--begin::Input group-->
																<div class="fv-row w-100 flex-md-root">
																	<!--begin::Label-->
																	<label class="form-label">{{ __('general.zip_code') }}</label>
																	<!--end::Label-->
																	<!--begin::Input-->
																	<input type="text" name="zip_code" class="form-control mb-2" value="{{ $companyProfile->zip_code }}" data-minlength="2" data-maxlength="255"/>																		
																	<!--end::Input-->
																</div>
																<!--end::Input group-->
                                                                <!--begin::Input group-->
																<div class="fv-row w-100 flex-md-root">
																	<!--begin::Label-->
																	<label class="form-label">{{ __('general.country_code') }}</label>
																	<!--end::Label-->
																	<!--begin::Input-->
																	<input type="text" name="country_code" class="form-control mb-2" value="{{ $companyProfile->country_code }}" data-minlength="2" data-maxlength="255"/>																		
																	<!--end::Input-->
																</div>
																<!--end::Input group-->
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
																<h2>{{ __('general.tax_registration_data') }}</h2>
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
																	<label class="form-label">{{ __('general.tax_number') }}</label>
																	<!--end::Label-->
																	<!--begin::Input-->
																	<input type="text" name="taxNumber" class="form-control mb-2" value="{{$companyProfile->taxNumber}}" data-minlength="2" data-maxlength="50"/>																		
																	<!--end::Input-->
                                                                    
																</div>
																<!--end::Input group-->
                                                                <!--begin::Input group-->
																<div class="fv-row w-100 flex-md-root">
																	<!--begin::Label-->
																	<label class="form-label">{{ __('general.registration_number') }}</label>
																	<!--end::Label-->
																	<!--begin::Input-->
																	<input type="text" name="registrationNumber" class="form-control mb-2" value="{{$companyProfile->registrationNumber}}" data-minlength="2" data-maxlength="50"/>																		
																	<!--end::Input-->
                                                                    
																</div>
																<!--end::Input group-->
                                                                <!--begin::Input group-->
																<div class="fv-row w-100 flex-md-root">
																	<!--begin::Label-->
																	<label class="form-label">{{ __('general.registration_date') }}</label>
																	<!--end::Label-->
																	<!--begin::Input-->
																	<input class="flatpickr-date form-control mb-2" name="registrationDate" value="{{$companyProfile->registrationDate}}" placeholder="{{ __('general.select_a_date') }}" data-type="dateTime"/>																		
																	<!--end::Input-->
                                                                    
																</div>
																<!--end::Input group-->
                                                            </div>
                                                            <!--end::InpudRow-->
                                                            <!--begin::InpudRow-->
															<div class="d-flex flex-wrap gap-5 mb-5">
																<!--begin::Input group-->
																<div class="fv-row w-100 flex-md-root">
																	<!--begin::Label-->
																	<label class="required form-label">{{ __('general.business') }}</label>
																	<!--end::Label-->
																	<!--begin::Input-->
																	<input type="text" name="business" class="form-control mb-2" value="{{$companyProfile->business}}" data-required="true" data-minlength="2" data-maxlength="255"/>																		
																	<!--end::Input-->
																</div>
																<!--end::Input group-->
                                                                <!--begin::Input group-->
																<div class="fv-row w-100 flex-md-root">
																	<!--begin::Label-->
																	<label class="form-label">{{ __('general.bank_account') }}</label>
																	<!--end::Label-->
																	<!--begin::Input-->
																	<input type="text" name="bankAccount" class="form-control mb-2" value="{{$companyProfile->bankAccount}}" data-minlength="2" data-maxlength="255"/>																		
																	<!--end::Input-->
                                                                    
																</div>
																<!--end::Input group-->
                                                                <!--begin::Input group-->
																<div class="fv-row w-100 flex-md-root">
																	<!--begin::Label-->
																	<label class="form-label">{{ __('general.bank_account2') }}</label>
																	<!--end::Label-->
																	<!--begin::Input-->
																	<input type="text" name="bankAccount2" class="form-control mb-2" value="{{$companyProfile->bankAccount2}}" data-minlength="2" data-maxlength="255"/>																		
																	<!--end::Input-->
                                                                    
																</div>
																<!--end::Input group-->
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
																<h2>{{ __('general.files') }}</h2>
															</div>
														</div>
														<!--end::Card header-->
														<!--begin::Card body-->
														<div class="card-body pt-0">
														
														    <!--begin::Input Row for PDF Profile-->
														    {{-- <div class="d-flex flex-wrap gap-5 mb-5">
														        <div class="fv-row w-100 flex-md-root">
														            <label class="form-label">{{ __('general.company_pdf_profile') }}</label>
														            <input type="file" name="pdf_profile" accept="application/pdf" 
														                   class="form-control mb-2" data-label="{{ __('general.pdf_profile') }}"/>
																
														            @if($companyProfile->pdf_profile)
														                <div class="mt-2">
														                    <a href="{{ asset('storage/' . $companyProfile->pdf_profile) }}" 
														                       target="_blank" class="btn btn-sm btn-outline-secondary">
														                        {{ __('general.view_current_pdf') }}
														                    </a>
														                </div>
														            @endif
														        </div>
														    </div> --}}
														
														    <!--begin::Input Row for Logo-->
														    <div class="d-flex flex-wrap gap-5 mb-5">
														        <div class="fv-row w-100 flex-md-root">
														            <label class="form-label">{{ __('general.logo') }}</label>
														            <input type="file" name="logo" accept=".png, .jpg, .jpeg"
														                   class="form-control mb-2" onchange="previewLogo(this)"
														                   data-label="{{ __('general.logo') }}"/>
																
														            <!-- Logo preview -->
														            <div id="logo-preview-container" class="mt-3" style="{{ $companyProfile->logo ? '' : 'display: none;' }}">
														                <img id="logo-preview" 
														                     src="{{ $companyProfile->logo ? (app()->environment('production') ? asset($companyProfile->logo) : asset('storage/' . $companyProfile->logo)) : '' }}" 
														                     alt="Logo Preview"
														                     style="max-height: 100px; border: 1px solid #ccc; padding: 5px;"
														                     class="rounded shadow-sm" />
														                <button type="button" onclick="removeLogo()"
														                        class="btn btn-sm btn-light-danger ms-2">
														                    {{ __('general.remove') }}
														                </button>
														            </div>
														        </div>
														    </div>
														
														</div>
														<!--end::Card body-->
													</div>
													<!--end::General options-->
												</div>
												<!--end::Tab pane - Card Body -->
												
												<!--begin::Tab pane - Modules Settings -->
												<div class="d-flex flex-column gap-7 gap-lg-10 mb-10">
													<!--begin::Modules Settings Card-->
													<div class="card card-flush py-4">
														<!--begin::Card header-->
														<div class="card-header">
															<div class="card-title">
																<h2>{{ __('general.modules_settings') ?? 'Module Settings' }}</h2>
															</div>
														</div>
														<!--end::Card header-->
														<!--begin::Card body-->
														<div class="card-body pt-0">
															<p class="text-muted mb-5">{{ __('general.modules_settings_desc') ?? 'Enable or disable system modules' }}</p>
															
															<!--begin::Modules Row-->
															<div class="d-flex flex-wrap gap-5 mb-5">
																<!--begin::Construction Module-->
																<div class="fv-row w-100 flex-md-root">
																	<div class="form-check form-switch form-check-custom form-check-solid">
																		<input class="form-check-input" type="checkbox" name="enable_construction" 
																		       value="1" {{ ($companyProfile->enable_construction ?? 1) ? 'checked' : '' }} id="enable_construction"/>
																		<label class="form-check-label fw-semibold" for="enable_construction">
																			{{ __('general.enable_construction_module') ?? 'Enable Construction Module' }}
																		</label>
																	</div>
																	<small class="text-muted">{{ __('general.construction_module_desc') ?? 'BOQ, EVM, and progress tracking' }}</small>
																</div>
																<!--end::Construction Module-->
																
																<!--begin::Partners Module-->
																<div class="fv-row w-100 flex-md-root">
																	<div class="form-check form-switch form-check-custom form-check-solid">
																		<input class="form-check-input" type="checkbox" name="enable_partners" 
																		       value="1" {{ ($companyProfile->enable_partners ?? 1) ? 'checked' : '' }} id="enable_partners"/>
																		<label class="form-check-label fw-semibold" for="enable_partners">
																			{{ __('general.enable_partners_module') ?? 'Enable Partners Module' }}
																		</label>
																	</div>
																	<small class="text-muted">{{ __('general.partners_module_desc') ?? 'Partners management and revenue distribution' }}</small>
																</div>
																<!--end::Partners Module-->
																
																<!--begin::Real Estate Module-->
																<div class="fv-row w-100 flex-md-root">
																	<div class="form-check form-switch form-check-custom form-check-solid">
																		<input class="form-check-input" type="checkbox" name="enable_real_estate" 
																		       value="1" {{ ($companyProfile->enable_real_estate ?? 1) ? 'checked' : '' }} id="enable_real_estate"/>
																		<label class="form-check-label fw-semibold" for="enable_real_estate">
																			{{ __('general.enable_real_estate_module') ?? 'Enable Real Estate Module' }}
																		</label>
																	</div>
																	<small class="text-muted">{{ __('general.real_estate_module_desc') ?? 'Units, cost estimates, and materials' }}</small>
																</div>
																<!--end::Real Estate Module-->
															</div>
															<!--end::Modules Row-->
															
															<!--begin::Management Fee Row-->
															<div class="d-flex flex-wrap gap-5 mb-5">
																<div class="fv-row w-100 flex-md-root" style="max-width: 300px;">
																	<label class="form-label">{{ __('general.default_management_fee') ?? 'Default Management Fee %' }}</label>
																	<input type="number" name="default_management_fee" class="form-control" 
																	       value="{{ $companyProfile->default_management_fee ?? 10 }}" 
																	       min="0" max="100" step="0.5"/>
																	<small class="text-muted">{{ __('general.management_fee_desc') ?? 'Applied to partner revenue distributions' }}</small>
																</div>
															</div>
															<!--end::Management Fee Row-->
														</div>
														<!--end::Card body-->
													</div>
													<!--end::Modules Settings Card-->
												</div>
												<!--end::Tab pane - Modules Settings -->
											</div>
											<!--end::Tab pane-->
										</div>
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

	<!--begin::JS Files Preview Script-->
	<script>
	    function previewLogo(input) {
	        const container = document.getElementById('logo-preview-container');
	        const preview = document.getElementById('logo-preview');
		
	        if (input.files && input.files[0]) {
	            const reader = new FileReader();
	            reader.onload = function (e) {
	                preview.src = e.target.result;
	                container.style.display = 'block';
	            };
	            reader.readAsDataURL(input.files[0]);
	        }
	    }
	
	    function removeLogo() {
	        const input = document.querySelector('input[name="logo"]');
	        const container = document.getElementById('logo-preview-container');
	        const preview = document.getElementById('logo-preview');
		
	        input.value = '';
	        preview.src = '';
	        container.style.display = 'none';
	    }
	</script>
	<!--end::JS Files Preview Script-->
		
	<!--begin::Javascript-->
	@include('assets._main_scripts')
	@include('assets._form_scripts')
	<!--end::Javascript-->
</body>
<!--end::Body-->

</html>