<!DOCTYPE html>

@if (app()->getLocale() == 'ar')
	@include('assets._language_ar')
@else
	@include('assets._language_en')
@endif

<head>

	<title>Link Masr | Update Credit Note</title>
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
											{{ __('general.update_creditNote') }}</h1>
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
												<a href="{{ route('creditNotes.index')}}" class="text-muted text-hover-primary">{{ __('general.creditNotes') }}</a>
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
										<a href="{{route('creditNotes.index')}}" class="btn btn-flex btn-primary h-40px fs-7 fw-bold">{{ __('general.creditNotes') }}</a>
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
												<form  id="kt_invoice_form" action="{{route('creditNotes.update' , $creditNote->id)}}" method="POST" enctype="multipart/form-data">
													@csrf											
                                                    @method('PUT')		
													<!--begin::Wrapper-->
													<div class="d-flex flex-column align-items-start flex-xxl-row">
														<!--begin::Input group-->
														<div class="d-flex align-items-center flex-equal fw-row me-4 order-2"
															data-bs-toggle="tooltip" data-bs-trigger="hover"
															title="Specify creditNote date">
															<!--begin::Date-->
															<div class="fs-6 fw-bold text-gray-700 text-nowrap">{{ __('general.date') }}
															</div>
															<!--end::Date-->
															<!--begin::Input-->
															<div
																class="position-relative d-flex align-items-center w-150px">
																<!--begin::Datepicker-->
																<input 
																	class="flatpickr-date form-control form-control-transparent fw-bold pe-5" 
																	placeholder="{{ __('general.select_date') }}" name="date" value="{{ $creditNote->date }}" data-type="date" data-required="true"/>
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
															title="{{ __('general.creditNote_number_info') }}">
															<span class="fs-2x fw-bold text-gray-800">{{ __('general.creditNote_#') }}</span>
															<input name="number" class="form-control form-control-flush fw-bold text-gray-800 fs-3 w-125px" value="{{$creditNote->number}}" placehoder="2021001..."data-type="number" data-required="true"/>
														</div>
														<!--end::Input group-->
														<!--begin::Input group-->
														<div class="d-flex align-items-center justify-content-end flex-equal order-3 fw-row"
															data-bs-toggle="tooltip" data-bs-trigger="hover"
															title="Specify creditNote due date">
															<!--begin::Date-->
															<div class="fs-6 fw-bold text-gray-700 text-nowrap">{{ __('general.due_date') }}</div>
															<!--end::Date-->
															<!--begin::Input-->
															<div class="position-relative d-flex align-items-center w-150px">
																<!--begin::Datepicker-->
																<input class="flatpickr-date form-control form-control-transparent fw-bold pe-5" 
																	placeholder="{{ __('general.select_date') }}" name="due_date" value="{{ $creditNote->due_date }}" data-type="date"/>
																<!--end::Datepicker-->
																<!--begin::Icon-->
																<i class="ki-outline ki-down fs-4 position-absolute end-0 ms-4"></i>
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
																<label class="form-label fs-6 fw-bold text-gray-700 mb-3">{{ __('general.client_name') }}</label>
																<!--begin::Input group-->
																<div class="mb-5">
																	<select name="client_id" id="clientSelect"
																		data-control="select2" data-placeholder="{{ __('general.client_name') }}"
																		class="form-select form-select-solid mb-2" data-required="true">
																		<option></option>
																		@foreach($clients as $client)
																			@if($client->address)
																				<option value="{{$client->id}}" data-address="{{$client->address->street_name}}" {{ old('client_id', $creditNote->client_id ?? '') == $client->id ? 'selected' : '' }}>{{$client->name}}
                                                                                </option>
																			@else
																				<option value="{{$client->id}}" data-address="address" {{ old('client_id', $creditNote->client_id ?? '') == $client->id ? 'selected' : '' }}>{{$client->name}}</option>
																			@endif
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
																		class="form-select form-select-solid">
																		<option value=""></option>
																		@foreach($tasks as $task)
																	        <option value="{{ $task->id }}" data-client-id="{{ $task->client_id }}"
																	            {{ old('task_id', $creditNote->task_id ?? '') == $task->id ? 'selected' : '' }}>
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
														<div class="row gx-10 mb-2">
															<!--begin::Col-->
															<div class="col-lg-6">
																<label class="form-label fs-6 fw-bold text-gray-700 mb-3">{{ __('general.bill_from') }}</label>
																<!--begin::Input group-->
																<div class="mb-2">
																	<input type="text"
																		class="form-control form-control-solid"
																		placeholder="{{ __('general.our_address') }}" value="{{ app(App\Services\setting\CompanyProfileService::class)->get()->address }}" data-required="true"/>
																</div>
																<!--end::Input group-->
															</div>
															<!--end::Col-->
															<!--begin::Col-->
															<div class="col-lg-6">
																<label class="form-label fs-6 fw-bold text-gray-700 mb-3">{{ __('general.bill_to') }}</label>
																<!--begin::Input group-->
																<div class="mb-5">
																	<input type="text" id="clientAddress" name="billing_address"
																		class="form-control form-control-solid"
																		placeholder="{{ __('general.client_address') }}" value="{{$creditNote->billing_address}}"/>
																</div>
																<!--end::Input group-->
															</div>
															<!--end::Col-->
														</div>
														<!--end::Row-->
														<!--begin::Row-->
														<div class="row gx-10 mb-5">
															<!--begin::Col-->
															<div class="col-lg-12">
																<!--begin::Input group-->
																<div class="mb-5">
																	<textarea name="description"
																		class="form-control form-control-solid" rows="3"
																		placeholder="{{ __('general.description') }}">{{$creditNote->description}}</textarea>
																</div>
																<!--end::Input group-->
															</div>
															<!--end::Col-->
														</div>
														<!--end::Row-->
														<!--begin::Table wrapper-->
														<div class="table-responsive mb-10">
															<!--begin::Table-->
															<table class="table g-5 gs-0 mb-0 fw-bold text-gray-700"
																data-kt-element="items">
																<!--begin::Table head-->
																<thead>
																	<tr
																		class="border-bottom fs-7 fw-bold text-gray-700 text-uppercase">
																		<th class="min-w-300px w-475px">{{ __('general.item') }}</th>
																		<th class="min-w-100px w-100px">{{ __('general.qty') }}</th>
																		<th class="min-w-200px w-200px">{{ __('general.price') }}</th>
																		<th class="min-w-100px w-100px">{{ __('general.tax') }} %</th>
																		<th class="min-w-100px w-200px text-end">{{ __('general.total') }}
																		</th>
																		<th class="min-w-70px w-70px text-end">{{ __('general.action') }}
																		</th>
																	</tr>
																</thead>
																<!--end::Table head-->
																<!--begin::Table body-->
																<tbody>
																	@foreach($items as $item)
																		<tr class="border-bottom border-bottom-dashed"
																			data-kt-element="item">
																			<td class="pe-7">
																				<input type="text"
																					class="form-control form-control-solid mb-2"
																					name="finance_items[{{ $loop->index }}][name]" value="{{$item->name}}" placeholder="Item name" maxlength="100" required/>
																				<input type="text"
																					class="form-control form-control-solid"
																					name="finance_items[{{ $loop->index }}][description]" value="{{$item->description}}"
																					placeholder="{{ __('general.description') }}" maxlength="255"/>
																			</td>
																			<td class="ps-0">
																				<input
																					class="form-control form-control-solid w-75"
																					type="number" min="1" max="99999" name="finance_items[{{ $loop->index }}][qty]"
																					placeholder="1" value="{{$item->qty}}"
																					data-kt-element="quantity" />
																			</td>
																			<td>
																				<input type="number"
																					class="form-control form-control-solid text-end"
																					name="finance_items[{{ $loop->index }}][amount]" value="{{$item->amount}}" min="1" max="99999999" placeholder="0.00"
																					data-kt-element="price" />
																			</td>
																			<td class="ps-0">
																				<input
																					class="form-control form-control-solid"
																					type="number" min="0" max="100" name="finance_items[{{ $loop->index }}][tax]"
																					placeholder="0" value="{{$item->tax}}"
																					data-kt-element="tax" />
																			</td>
																			<td class="pt-8 text-end text-nowrap">
																				<span data-kt-element="item-total">{{$item->subtotal}}</span>
																				<input type="hidden" name="finance_items[{{ $loop->index }}][subtotal]" value="{{$item->subtotal}}" data-kt-element="subtotal-input" />
																			</td>
																			<td class="pt-5 text-end">
																				<button type="button"
																					class="btn btn-sm btn-icon btn-active-color-primary"
																					data-kt-element="remove-item">
																					<i class="ki-outline ki-trash fs-3"></i>
																				</button>
																			</td>
																		</tr>
																	@endforeach
																</tbody>
																<!--end::Table body-->
																<!--begin::Table foot-->
																<tfoot>
																	<tr class="border-top border-top-dashed align-top fs-6 fw-bold text-gray-700">
																		<th class="text-primary">
																			<button class="btn btn-sm btn-primary" data-kt-element="add-item">{{ __('general.add_item') }}</button>
																		</th>
																		<th colspan="2"
																			class="border-bottom border-bottom-dashed ps-0">
																			<div class="d-flex flex-column align-items-start">
																				<div class="fs-5">{{ __('general.subtotal') }}</div>
																			</div>
																		</th>
																		<th colspan="2" class="border-bottom border-bottom-dashed text-end">$ <span data-kt-element="sub-total">0.00</span></th>
																	</tr>

																	<tr colspan="2" class="border-bottom border-bottom-dashed ps-0">
																		<th></th>
																		<th class="fs-5 ps-0">{{ __('general.tax') }} %</th>
																		<th>
																			<input class="form-control form-control-solid w-75" type="number" min="0" max="100" name="tax" placeholder="0" value="{{$creditNote->tax}}" data-kt-element="invoice-tax" />
																		</th>
																		<th colspan="2" class="border-bottom border-bottom-dashed text-end">$ <span data-kt-element="invoice-tax-field">{{$creditNote->total_tax}}</span></th>
																	</tr>

																	<tr colspan="2" class="border-bottom border-bottom-dashed ps-0">
																		<th></th>
																		<th class="fs-5 ps-0">{{ __('general.discount') }} %</th>
																		<th>
																			<input class="form-control form-control-solid w-75" type="number" min="0" max="100" name="discount" placeholder="0" value="{{$creditNote->discount}}" data-kt-element="invoice-discount" />
																		</th>
																		<th colspan="2" class="border-bottom border-bottom-dashed text-end">$ <span data-kt-element="invoice-discount-field">{{$creditNote->percentage_discount_value}}</span></th>
																	</tr>

																	<tr colspan="2" class="border-bottom border-bottom-dashed ps-0">
																		<th></th>
																		<th class="fs-5 ps-0">{{ __('general.fixed_discount') }}</th>
																		<th>
																			<input class="form-control form-control-solid w-75" type="number" min="0" max="99999999" name="fixed_discount" placeholder="0" value="{{$creditNote->fixed_discount}}" data-kt-element="invoice-fixed-discount" />
																		</th>
																		<th colspan="2" class="border-bottom border-bottom-solid text-end">$ <span data-kt-element="invoice-fixed-discount-field">{{$creditNote->fixed_discount}}</span></th>
																	</tr>
																	
																	<tr class="align-top fw-bold text-gray-800">
																		<th></th>
																		<th colspan="2" class="fs-2 ps-0">{{ __('general.grand_total') }}</th>
																		<th colspan="2" class="text-end fs-4 text-nowrap">$ <span data-kt-element="grand-total">0.00</span></th>
																		<input data-kt-element="grand-total-hidden-input" value="0" name="total" hidden />
																	</tr>
																</tfoot>
																<!--end::Table foot-->
															</table>
														</div>
														<!--end::Table-->
														<!--begin::Item template-->
														<table class="table d-none" data-kt-element="item-template">
															<tr class="border-bottom border-bottom-dashed"
																data-kt-element="item">
																<td class="pe-7">
																	<input type="text"
																		class="form-control form-control-solid mb-2"
																		name="finance_items[x][name]" placeholder="Item name" maxlength="100"/>
																	<input type="text"
																		class="form-control form-control-solid"
																		name="finance_items[x][description]"
																		placeholder="{{ __('general.description') }}" maxlength="255"/>
																</td>
																<td class="ps-0">
																	<input class="form-control form-control-solid w-75"
																		type="number" min="1" max="99999" name="finance_items[x][qty]"
																		placeholder="1" value="1" data-kt-element="quantity" />
																</td>
																<td>
																	<input type="text"
																		class="form-control form-control-solid text-end"
																		name="finance_items[x][amount]" placeholder="0.00"
																		data-kt-element="price" />
																</td>
																<td class="ps-0">
																	<input class="form-control form-control-solid"
																		type="number" min="0" name="finance_items[x][tax]"
																		placeholder="0" value="0" data-kt-element="tax" />
																</td>
																<td class="pt-8 text-end">$
																	<span data-kt-element="item-total">0.00</span>
																	<input type="hidden" name="finance_items[x][subtotal]" value="0.00" data-kt-element="subtotal-input" />
																</td>
																<td class="pt-5 text-end">
																	<button type="button"
																		class="btn btn-sm btn-icon btn-active-color-primary"
																		data-kt-element="remove-item">
																		<i class="ki-outline ki-trash fs-3"></i>
																	</button>
																</td>
															</tr>
														</table>
														<table class="table d-none" data-kt-element="empty-template">
															<tr data-kt-element="empty">
																<th colspan="5" class="text-muted text-center py-10">No
																	items</th>
															</tr>
														</table>
														<!--end::Item template-->
														<!--begin::Separator-->
														<div class="separator separator-dashed my-10"></div>
														<!--end::Separator-->
														<!--begin::Notes-->
														<div class="row mb-10">
															<div class="col">
																<label class="form-label fs-6 fw-bold text-gray-700">{{ __('general.client_note') }}</label>
																<textarea name="client_note" class="form-control form-control-solid" rows="3" placeholder="{{ __('general.note_info') }}">{{$creditNote->client_note}}</textarea>
															</div>
															<div class="col">
																<label class="form-label fs-6 fw-bold text-gray-700">{{ __('general.admin_note') }}</label>
															<textarea name="admin_note" class="form-control form-control-solid" rows="3" placeholder="{{ __('general.note_info') }}">{{$creditNote->admin_note}}</textarea>
															</div>
														</div>
														<!--end::Notes-->
														{{-- <!--begin::bank details-->
														<div class="mb-0">
															<label
																class="form-label fs-6 fw-bold text-gray-700">{{ __('general.bank_account_details') }}</label>
															<textarea name="bank_account_details"
																class="form-control form-control-solid" rows="3"
																placeholder="Thanks for your business">Our Bank Acc Details</textarea>
														</div>
														<!--end::bank details--> --}}
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
													<label class="form-label fw-bold fs-6 text-gray-700">{{ __('general.project_name') }}</label>
													<!--end::Label-->
													<!--begin::Select2-->
													<select name="project_id" aria-label="Select a Timezone"
														data-control="select2" data-placeholder="{{ __('general.project_name') }}"
														class="form-select form-select-solid">
														<option value=""></option>
														@foreach($projects as $project)
														    <option value="{{ $project->id }}" data-client-id="{{ $project->client_id }}" 
														        {{ old('project_id', $creditNote->project_id ?? '') == $project->id ? 'selected' : '' }}>
														        {{ $project->subject }}
														    </option>
														@endforeach
													</select>
													<!--end::Select2-->
												</div>
												<!--end::Input group-->
												
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
														    <option value="{{ $user->id }}" 
														        {{ old('sale_agent', $creditNote->sale_agent ?? '') == $user->id ? 'selected' : '' }}>
														        {{ $user->name }}
														    </option>
														@endforeach
													</select>
													<!--end::Select2-->
												</div>
												<!--end::Input group-->
												
												<!--begin::Separator-->
												<div class="separator separator-dashed mt-5 mb-5"></div>
												<!--end::Separator-->

												<!--begin::Row-->
												<div class="row">
													<!--begin::Input group-->
													<div class="col mb-5">
														<!--begin::Label-->
														<label class="form-label fw-bold fs-6 text-gray-700">{{ __('general.currency') }}</label>
														<!--end::Label-->
														<!--begin::Select-->
														<select name="currency" aria-label="Select a Timezone" id="clientCurrency"
															data-control="select2" data-hide-search="true"
															class="form-select form-select-solid" required>
                                                            @foreach($currencies as $currency)
														    <option value="{{ $currency->code }}" 
														        {{ old('currency', $creditNote->currency ?? '') == $currency->code ? 'selected' : '' }}>
														        {{ $currency->code }}
														    </option>
														@endforeach
														</select>
														<!--end::Select-->
													</div>
													<!--end::Input group-->													
												</div>
												<!--end::Row-->

												<div class="row">
													<div class="col mb-5">
														<!--begin::Label-->
														<label class="form-label fw-bold fs-6 text-gray-700">{{ __('general.discount_type') }}</label>
														<!--end::Label-->
														<!--begin::Select-->
														<select name="discount_type" aria-label="Select discount type"
															data-control="select2" data-hide-search="true" data-placeholder="....."
															class="form-select form-select-solid" data-kt-element="discount-type">
                                                            <option value="before_tax" {{ $creditNote->discount_type === 'before_tax' ? 'selected' : '' }}>{{ __('general.before_tax') }}</option>
                                                            <option value="after_tax" {{ $creditNote->discount_type === 'after_tax' ? 'selected' : '' }}>{{ __('general.after_tax') }}</option>
														</select>
														<!--end::Select-->
													</div>
												</div>
												<div class="row">
													<div class="col mb-5">
														<!--begin::Label-->
														<label class="form-label fw-bold fs-6 text-gray-700">{{ __('general.discount_amount_type') }}</label>
														<!--end::Label-->
														<!--begin::Select-->
														<select name="discount_amount_type" aria-label="Select discount type"
															data-control="select2" data-hide-search="true" data-placeholder="....."
															class="form-select form-select-solid" data-kt-element="discount-amount">
                                                            <option value="percentage" {{ $creditNote->discount_amount_type === 'percentage' ? 'selected' : '' }}>{{ __('general.percentage') }}</option>
                                                            <option value="fixed_amount" {{ $creditNote->discount_amount_type === 'fixed_amount' ? 'selected' : '' }}>{{ __('general.fixed_amount') }}</option>
														</select>
														<!--end::Select-->
													</div>
												</div>
												<!--begin::Separator-->
												<div class="separator separator-dashed mt-8 mb-8"></div>
												<!--end::Separator-->
												<!--begin::Input group-->
												<div class="mb-8">
													<!--begin::Option-->
													<label
														class="form-check form-switch form-switch-sm form-check-custom form-check-solid flex-stack mb-5">
														<span class="form-check-label ms-0 fw-bold fs-6 text-gray-700">{{ __('general.send_to_client') }}</span>
														<input class="form-check-input" type="checkbox" name="send_status"
															value="1" />
													</label>
													<!--end::Option-->
													<!--begin::Option-->
													<label
														class="form-check form-switch form-switch-sm form-check-custom form-check-solid flex-stack mb-5">
														<span class="form-check-label ms-0 fw-bold fs-6 text-gray-700">{{ __('general.create_payment') }}</span>
														<input class="form-check-input" type="checkbox" name="create_payment" value="1" />
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
                                                            <option value="unpaid" {{ $creditNote->status === 'unpaid' ? 'selected' : '' }}>{{ __('general.unpaid') }}</option>
                                                            <option value="paid" {{ $creditNote->status === 'paid' ? 'selected' : '' }}>{{ __('general.paid') }}</option>
                                                            <option value="partially" {{ $creditNote->status === 'partially' ? 'selected' : '' }}>{{ __('general.partially') }}</option>
                                                            <option value="draft" {{ $creditNote->status === 'draft' ? 'selected' : '' }}>{{ __('general.draft') }}</option>
														</select>
														<!--end::Select-->
													</div>
												</div>

												<!--begin::Actions-->
												<div class="mb-0">
												    <!-- Save as Regular Invoice -->
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
	<script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
	<!--begin::Custom Javascript(used for this page only)-->
	<script src="{{ asset('assets/js/models/finance/create.js') }}"></script>
	<!--end::Custom Javascript-->
	<!--end::Javascript-->
	
</body>
<!--end::Body-->
</html>