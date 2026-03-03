<!DOCTYPE html>

@if (app()->getLocale() == 'ar')
	@include('assets._language_ar')
@else
	@include('assets._language_en')
@endif

<head>

	<title>Link Masr | Update Proposal</title>
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
										<h1 class="page-heading d-flex flex-column justify-content-center text-gray-900 fw-bold fs-1 m-0">
											{{ __('general.create_new_proposal') }}</h1>
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
											<li class="breadcrumb-item text-muted">{{ __('general.finance') }}</li>
											<!--end::Item-->
											<!--begin::Item-->
											<li class="breadcrumb-item">
												<span class="bullet bg-gray-500 w-5px h-2px"></span>
											</li>
											<!--end::Item-->
											<!--begin::Item-->
											<li class="breadcrumb-item text-muted">
												<a href="{{ route('proposals.index')}}" class="text-muted text-hover-primary">{{ __('general.proposals') }}</a>
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
								<!--begin::Layout-->
								<div class="d-flex flex-column flex-lg-row">
									<!--begin::Content-->
									<div class="flex-lg-row-fluid mb-10 mb-lg-0 me-lg-7 me-xl-10">
										<!--begin::Card-->
										<div class="card">
											<!--begin::Card body-->
											<div class="card-body p-12">
												<!--begin::Form-->
												
												<form  id="kt_invoice_form" action="{{route('proposals.update' , $proposal->id)}}" method="POST" enctype="multipart/form-data">
													@csrf					
													@method('PUT')								
													<!--begin::Wrapper-->
													<div class="d-flex flex-column align-items-start flex-xxl-row">
														<!--begin::Input group-->
														<div class="d-flex align-items-center flex-equal fw-row me-4 order-2"
															data-bs-toggle="tooltip" data-bs-trigger="hover"
															title="Specify Proposal date">
															<!--begin::Date-->
															<div class="fs-6 fw-bold text-gray-700 text-nowrap">{{ __('general.date') }}
															</div>
															<!--end::Date-->
															<!--begin::Input-->
															<div
																class="position-relative d-flex align-items-center w-150px">
																<!--begin::Datepicker-->
																<input
																	class="form-control form-control-transparent fw-bold pe-5"
																	placeholder="{{ __('general.select_date') }}" name="date" value="{{$proposal->date}}" data-required="true"/>
																<!--end::Datepicker-->
																<!--begin::Icon-->
																<i class="ki-outline ki-down fs-4 position-absolute ms-4 end-0"></i>
																<!--end::Icon-->
															</div>
															<!--end::Input-->
														</div>
														<!--end::Input group-->
														<!--begin::Input group-->
														<div class="d-flex flex-center flex-equal fw-row text-nowrap order-1 order-xxl-2 me-4"
															data-bs-toggle="tooltip" data-bs-trigger="hover"
															title="{{ __('general.Proposal_number_info') }}">
															<span class="fs-2x fw-bold text-gray-800">{{ __('general.proposal_#') }}</span>
															<input type="text" name="number" class="form-control form-control-flush fw-bold text-gray-800 fs-3 w-125px" value="{{$proposal->number}}" placehoder="2021001..." data-required="true"/>
														</div>
														<!--end::Input group-->
														<!--begin::Input group-->
														<div class="d-flex align-items-center justify-content-end flex-equal order-3 fw-row"
															data-bs-toggle="tooltip" data-bs-trigger="hover"
															title="Specify Proposal due date">
															<!--begin::Date-->
															<div class="fs-6 fw-bold text-gray-700 text-nowrap">{{ __('general.due_date') }}</div>
															<!--end::Date-->
															<!--begin::Input-->
															<div
																class="position-relative d-flex align-items-center w-150px">
																<!--begin::Datepicker-->
																<input
																	class="form-control form-control-transparent fw-bold pe-5"
																	placeholder="{{ __('general.select_date') }}" name="due_date" value="{{$proposal->due_date}}"/>
																<!--end::Datepicker-->
																<!--begin::Icon-->
																<i
																	class="ki-outline ki-down fs-4 position-absolute end-0 ms-4"></i>
																<!--end::Icon-->
															</div>
															<!--end::Input-->
														</div>
														<!--end::Input group-->
													</div>
													<!--end::Top-->
													<!--begin::Separator-->
													<div class="separator separator-dashed my-10"></div>
													<!--end::Separator-->
													<!--begin::Wrapper-->
													<div class="mb-0">
														<!--begin::Row-->
														<div class="row gx-10 mb-5">
															<!--begin::Col-->
															<div class="col-lg-6">
																<label
																	class="form-label fs-6 fw-bold text-gray-700 mb-3">{{ __('general.client_name') }}</label>
																<!--begin::Input group-->
																<div class="mb-5">
																	<select name="client_id" aria-label="Select a Timezone" id="clientSelect"
																		data-control="select2" data-placeholder="{{ __('general.client_name') }}"
																		class="form-select form-select-solid mb-2"  data-required="true">
																		<option></option>
																		@foreach($clients as $client)
																	        <option value="{{ $client->id }}" data-address="{{ $client->address->street_name ?? 'address' }}"
																	            {{ $proposal->client_id == $client->id ? 'selected' : '' }}>
																	            {{ $client->name }}
																	        </option>
																	    @endforeach
																	</select>
																</div>
																<!--end::Input group-->
															</div>
															<!--end::Col-->
															<!--begin::Col-->
															<div class="col-lg-6">
																<label
																	class="form-label fs-6 fw-bold text-gray-700 mb-3">{{ __('general.task_name') }}</label>
																<!--begin::Input group-->
																<div class="mb-5">
																	<select name="task_id" aria-label="Select a Timezone"
																		data-control="select2" data-placeholder="{{ __('general.task_name') }}"
																		class="form-select form-select-solid mb-2">
																		<option value=""></option>
																		@foreach($tasks as $task)
																	        <option value="{{ $task->id }}" data-client-id="{{ $task->client_id }}"{{ $proposal->task_id == $task->id ? 'selected' : '' }}>
																	            {{ $task->subject }}
																	        </option>
																	    @endforeach
																	</select>
																</div>
																<!--end::Input group-->
															</div>
															<!--end::Col-->
														</div>
														<!--end::Row-->
														<!--begin::Row-->
														<div class="row gx-10 mb-5">
															<!--begin::Col-->
															<div class="col-lg-6">
																<label class="form-label fs-6 fw-bold text-gray-700 mb-3">{{ __('general.bill_from') }}</label>
																<!--begin::Input group-->
																<div class="mb-5">
																	<input type="text"
																		class="form-control form-control-solid"
																		placeholder="{{ __('general.our_address') }}" value="Our Billing Address Here"/>
																</div>
																<!--end::Input group-->
																<!--begin::Input group-->
																<div class="mb-5">
																	<textarea name="notes"
																		class="form-control form-control-solid" rows="3"
																		placeholder="Who is this Contract from?">{{ __('general.write_our_company_info_here') }}</textarea> {{--  SIMULATOR --}}
																</div>
																<!--end::Input group-->
															</div>
															<!--end::Col-->
															<!--begin::Col-->
															<div class="col-lg-6">
																<label
																	class="form-label fs-6 fw-bold text-gray-700 mb-3">{{ __('general.bill_to') }}</label>
																<!--begin::Input group-->
																<div class="mb-5">
																	<input type="text" id="clientAddress" name="billing_address"
																		class="form-control form-control-solid"
																		placeholder="{{ __('general.client_address') }}"/>
																</div>
																<!--end::Input group-->
																<!--begin::Input group-->
																<div class="mb-5">
																	<textarea name="description"
																		class="form-control form-control-solid" rows="3"
																		placeholder="{{ __('general.description') }}"></textarea>
																</div>
																<!--end::Input group-->
															</div>
															<!--end::Col-->
														</div>
														<!--end::Row-->
														
														<!--begin::Separator-->
														<div class="separator separator-dashed my-10"></div>
														<!--end::Separator-->
														

														<!--begin::Row-->
														<div class="row gx-10 mb-5">
															<!--begin::Col-->
															<div class="col-6">
																<label class="form-label fs-6 fw-bold text-gray-700 mb-3">{{ __('general.subject') }}</label>
																<!--begin::Input group-->
																<div class="mb-5">
																	<input type="text"
																		class="form-control form-control-solid mb-2" name="subject" value="{{$proposal->subject}}"
																		placeholder="{{ __('general.proposal_subject') }}" data-required="true" data-minlength="5" data-maxlength="255"/>
																</div>
																<!--end::Input group-->
															</div>
															<div class="col-6">
																<label class="form-label fs-6 fw-bold text-gray-700 mb-3">{{ __('general.total_amount') }}</label>
																<!--begin::Input group-->
																<div class="mb-5">
																	<input type="number" data-type="number" min="0"
																		class="form-control form-control-solid mb-2" name="total" value="{{$proposal->total}}"
																		placeholder="{{ __('general.total_amount') }}" data-required="true"/>
																</div>
															</div>
															<!--end::Col-->
														</div>
														<!--end::Row-->

														<!--begin::Row-->
														<div class="row gx-10 mb-5">
															<!--end::Input group-->
															<label class="form-label fs-6 fw-bold text-gray-700 mb-3">{{ __('general.message') }}</label>
															<div class="mb-5">
																<textarea name="message"
																	class="form-control form-control-solid" rows="4" 
																	placeholder="{{ __('general.message') }}">{{$proposal->message}}</textarea>
															</div>
															<!--end::Input group-->
														</div>
														<!--end::Row-->
													</div>
													<!--end::Wrapper-->
												
												<!--end::Form-->
											</div>
											<!--end::Card body-->
										</div>
										<!--end::Card-->
									</div>
									<!--end::Content-->
									<!--begin::Sidebar-->
									<div class="flex-lg-auto min-w-lg-300px">
										<!--begin::Card-->
										<div class="card" data-kt-sticky="true" data-kt-sticky-name="invoice"
											data-kt-sticky-offset="{default: false, lg: '200px'}"
											data-kt-sticky-width="{lg: '250px', lg: '300px'}" data-kt-sticky-left="auto"
											data-kt-sticky-top="150px" data-kt-sticky-animation="false"
											data-kt-sticky-zindex="95">
											<!--begin::Card body-->
											<div class="card-body p-10">
												<!--begin::Input group-->
												<div class="mb-5">
													<!--begin::Label-->
													<label class="form-label fw-bold fs-6 text-gray-700">{{ __('general.project') }}</label>
													<!--end::Label-->
													<!--begin::Select2-->
													<select name="project_id" aria-label="Select a Timezone"
														data-control="select2" data-placeholder="{{ __('general.project_name') }}"
														class="form-select form-select-solid">
														<option value=""></option>
														@foreach($projects as $project)
													        <option value="{{ $project->id }}" {{ $proposal->project_id == $project->id ? 'selected' : '' }}>
													            {{ $project->subject }}
													        </option>
													    @endforeach
													</select>
													<!--end::Select2-->
												</div>
												<!--end::Input group-->
												<!--begin::Input group-->
												
												<!--begin::Input group-->
												<div class="mb-5">
													<!--begin::Label-->
													<label class="form-label fw-bold fs-6 text-gray-700">{{ __('general.sale_agent') }}</label>
													<!--end::Label-->
													<!--begin::Select2-->
													<select name="sale_agent" aria-label="Select a Timezone"
														data-control="select2" data-placeholder="{{ __('general.sale_agent') }}"
														class="form-select form-select-solid">
														<option value=""></option>
														@foreach($users as $user)
													        <option value="{{ $user->id }}" {{ $proposal->sale_agent == $user->id ? 'selected' : '' }}>
													            {{ $user->name }}
													        </option>
													    @endforeach
													</select>
													<!--end::Select2-->
												</div>
												<!--end::Input group-->
												<!--begin::Row-->
												<div class="row">
													<!--begin::Input group-->
													<div class="col mb-5">
														<!--begin::Label-->
														<label class="form-label fw-bold fs-6 text-gray-700">{{ __('general.currency') }}</label>
														<!--end::Label-->
														<!--begin::Select-->
														<select name="currency"
															data-control="select2" data-hide-search="true" data-placeholder="....."
															class="form-select form-select-solid">
															@foreach($currencies as $currency)
																@if($currency->currency_placement === 'default') <!-- SIMULATOR -->
																	<option value="{{ $currency->code }}" selected="selected">{{ $currency->code }}</option>
																@else
																	<option value="{{ $currency->code }}">{{ $currency->code }}</option>
																@endif
															@endforeach
														</select>
														<!--end::Select-->
													</div>
													<!--end::Input group-->													
												</div>
												<!--end::Row-->

												<!--begin::Separator-->
												<div class="separator separator-dashed mt-8 mb-8"></div>
												<!--end::Separator-->
												<!--begin::Input group-->
												<div class="mb-8">
													<!--begin::Option-->
													<label
														class="form-check form-switch form-switch-sm form-check-custom form-check-solid flex-stack mb-5">
														<span class="form-check-label ms-0 fw-bold fs-6 text-gray-700">{{ __('general.send_to_client') }}</span>
														<input class="form-check-input" type="checkbox" name="visible_to_client" value="1" {{ $proposal->visible_to_client == 1 ? 'checked' : '' }} />
													</label>
													<!--end::Option-->
												</div>
												<!--end::Input group-->
												
												<!--begin::Separator-->
												<div class="separator separator-dashed mb-8"></div>
												<!--end::Separator-->

												<div class="row">
													<div class="col mb-5">
														<!--begin::Label-->
														<label class="form-label fw-bold fs-6 text-gray-700">{{ __('general.status') }}</label>
														<!--end::Label-->
														<!--begin::Select-->
														<select name="status" aria-label="Select status"
														    data-control="select2" data-hide-search="true"
														    class="form-select form-select-solid">
														    <option value="draft" {{ $proposal->status == 'draft' ? 'selected' : '' }}>{{ __('general.draft') }}</option>
														    <option value="sent" {{ $proposal->status == 'sent' ? 'selected' : '' }}>{{ __('general.sent') }}</option>
														    <option value="open" {{ $proposal->status == 'open' ? 'selected' : '' }}>{{ __('general.open') }}</option>
														    <option value="revise" {{ $proposal->status == 'revise' ? 'selected' : '' }}>{{ __('general.revise') }}</option>
														    <option value="accepted" {{ $proposal->status == 'accepted' ? 'selected' : '' }}>{{ __('general.accepted') }}</option>
														    <option value="declined" {{ $proposal->status == 'declined' ? 'selected' : '' }}>{{ __('general.declined') }}</option>
														</select>
														<!--end::Select-->
													</div>
												</div>

												<!--begin::Actions-->
												<div class="mb-0">
												    <!-- Save as Regular Proposal -->
												    <button type="submit" name="action" class="btn btn-primary w-100">
												        <i class="ki-outline ki-triangle fs-3"></i>{{ __('general.save_changes') }}
												    </button>
												</div>
												<!--end::Actions-->

											</form>

											</div>
											<!--end::Card body-->
										</div>
										<!--end::Card-->
									</div>
									<!--end::Sidebar-->
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
	
	<!-- Script to show client address when select the client -->
	<script> 
		const clientsData = @json($clients);
	</script>

	<!--begin::Scrolltop-->
	@include('layout._scroll_top')
	<!--end::Scrolltop-->
	
	<!--begin::Javascript-->
	@include('assets._main_scripts')
	@include('assets._form_scripts')
	<script src="{{ asset('assets/js/custom/apps/business/create.js') }}"></script>
	<!--end::Javascript-->
</body>
<!--end::Body-->

</html>