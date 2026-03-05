<!DOCTYPE html>

@if (app()->getLocale() == 'ar')
	@include('assets._language_ar')
@else
	@include('assets._language_en')
@endif

<head>

	<title>Link Masr | Update Balance</title>
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
											{{ __('general.update_balance') }}</h1>
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
												<a href="{{ route('balances.index')}}" class="text-muted text-hover-primary">{{ __('general.balances') }}</a>
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
								<form action="{{route('balances.update' , $balance->id)}}" method="POST" class="form d-flex flex-column flex-lg-row"
									data-kt-redirect="apps/ecommerce/catalog/products.html" enctype="multipart/form-data">
									@csrf
                                    @method('PUT')

									<input type="hidden" name="user_id" value="{{ $balance->user_id }}">

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
																	<label class="required form-label">{{ __('general.year') }}</label>
																	<!--end::Label-->
																	<!--begin::Input-->
																	<input type="text" name="year" class="form-control mb-2" value="{{ $balance->year }}" data-required="true" data-minlength="2" data-maxlength="255"/>																		
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
																	<label class="required form-label">{{ __('general.total_days') }}</label>
																	<!--end::Label-->
																	<!--begin::Input-->
																	<input type="number" step="0.5" name="total_days" class="form-control mb-2"
       																	value="{{ rtrim(rtrim(number_format($balance->total_days, 2, '.', ''), '0'), '.') }}"
       																	data-required="true"/>
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
																	<label class="required form-label">{{ __('general.used_days') }}</label>
																	<!--end::Label-->
																	<!--begin::Input-->
																	<input type="number" step="0.5" name="used_days" class="form-control mb-2"
       																	value="{{ rtrim(rtrim(number_format($balance->used_days, 2, '.', ''), '0'), '.') }}"
       																	data-required="true"/>																		
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
																	<label class="required form-label">{{ __('general.remaining_days') }}</label>
																	<!--end::Label-->
																	<!--begin::Input-->
																	<input type="number" step="0.5" name="remaining_days" class="form-control mb-2"
       																	value="{{ max(0, $balance->total_days - $balance->used_days)}}"
       																	data-required="true" readonly/>																		
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
																	<label class="form-label">{{ __('general.created_at') }}</label>
																	<!--end::Label-->
																	<!--begin::Input-->
																	<input type="text" class="form-control mb-2" value="{{ $balance->created_at }}" readonly/>																		
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

	<!--begin::Javascript-->
	@include('assets._main_scripts')
	@include('assets._form_scripts')
	<!--end::Javascript-->

	{{-- script to update remaining_days if total or used days changed --}}
	<script>	
	document.addEventListener('DOMContentLoaded', function () {
	    const totalInput = document.querySelector('input[name="total_days"]');
	    const usedInput = document.querySelector('input[name="used_days"]');
	    const remainingInput = document.querySelector('input[name="remaining_days"]');
	
	    function updateRemaining() {
	        const total = parseFloat(totalInput.value) || 0;
	        const used = parseFloat(usedInput.value) || 0;
	        const remaining = Math.max(0, total - used);
	        remainingInput.value = remaining % 1 === 0 ? remaining.toFixed(0) : remaining.toFixed(1);
	    }
	
	    totalInput.addEventListener('input', updateRemaining);
	    usedInput.addEventListener('input', updateRemaining);
	});
	</script>


</body>
<!--end::Body-->
</html>