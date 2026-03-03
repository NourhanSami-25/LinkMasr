<!DOCTYPE html>

@if (app()->getLocale() == 'ar')
	@include('assets._language_ar')
@else
	@include('assets._language_en')
@endif

<head>

	<title>Link Masr | {{ \Illuminate\Support\Str::title($model) }}</title>
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
		@media print {
			/* Ensure no margins on the body */
			@page {
				margin: 0;
			}
			
			body {
				margin: 0;
				padding: 0;
			}
		
			#invoiceArea {
				width: 100%;
				margin: 0;
				padding: 0;
			}
		}
	</style>

</head>


<!--begin::Body-->
<body id="kt_app_body" data-kt-app-header-fixed="true" data-kt-app-header-fixed-mobile="true"
	data-kt-app-sidebar-enabled="true" data-kt-app-sidebar-fixed="true" data-kt-app-sidebar-hoverable="true"
	data-kt-app-sidebar-push-toolbar="true" data-kt-app-sidebar-push-footer="true" data-kt-app-toolbar-enabled="true"
	data-kt-app-aside-enabled="true" data-kt-app-aside-fixed="true" data-kt-app-aside-push-toolbar="true"
	data-kt-app-aside-push-footer="true" class="print-content-only app-default">
	@include('assets.dark_mode')
	<!--begin::App-->
	<div class="d-flex flex-column flex-root app-root" id="kt_app_root">
		<!--begin::Page-->
		<div class="app-page flex-column flex-column-fluid" id="kt_app_page">
			
			<!--begin::Toolbar-->
			<div id="kt_app_toolbar" class="app-toolbar pt-6 pb-2">
				<!--begin::Toolbar container-->
				<div id="kt_app_toolbar_container" class="app-container container-fluid d-flex justify-content-end align-items-center">
					<div class="btn-group" role="group">
						<button type="button" class="btn btn-primary btn-lg me-2" onclick="window.print();">
							<i class="bi bi-printer me-1"></i> {{ __('general.print') }}
						</button>
						<button type="button" class="btn btn-success btn-lg" onclick="window.print();">
							<i class="bi bi-download me-1"></i> {{ __('general.download') }}
						</button>
					</div>
				</div>
				<!--end::Toolbar container-->
			</div>
			<!--end::Toolbar-->

			<!--begin::Wrapper-->
				<!--begin::Main-->
				<div class="app-main flex-column flex-row-fluid" id="kt_app_main">
					<!--begin::Content wrapper-->
					<div class="d-flex flex-column flex-column-fluid">
						<!--begin::Content-->
						<div id="kt_app_content" class="app-content flex-column-fluid mb-0 mt-0 pb-0">
							<!--begin::Content container-->
							<div id="kt_app_content_container" class="app-container container-fluid">
								<!--begin::Invoice 2 main-->
								<div class="card" style="box-shadow: none; border: none">
									<!--begin::Body-->
									<div class="card-body">
										<!--begin::Layout-->
										<div class="d-flex flex-column flex-xl-row">
											<!--begin::Content-->
											<div class="flex-lg-row-fluid me-xl-18 mb-10 mb-xl-0">
												<!--begin::Invoice 2 content-->
												<div class="mt-n1">
													@if($model == 'expense')
													<!-- begin::Header-->
													<div class="d-flex justify-content-between flex-column flex-sm-row mb-5">
														<h4 class="fw-bolder text-gray-800 fs-2qx pe-5 pb-7">{{ __('general.'.$model.'#') }} {{$finance->number}}
															<span class="fs-5 text-gray-600 fw-semibold"><br/>{{ __('general.client') }} : {{$finance->client_name}}</span>
														</h4>
														<!--end::Logo-->
													</div>
													<!--end::Header-->
													@else
													<!-- begin::Header-->
													<div class="d-flex justify-content-between flex-column flex-sm-row mb-5">
														
														<h4 class="fw-bolder text-gray-800 fs-2qx pe-5 pb-7"><span class="text-uppercase">{{$model}}# </span>{{$finance->number}}
															<span class="fs-5 text-gray-600 fw-semibold"><br/>{{ __('general.to') }} : {{$finance->client_name}}</span>
														</h4>
														<!--end::Logo-->
														<div class="text-sm-end">
															<!--begin::Logo-->
															<a href="#" class="d-block mw-150px ms-sm-auto">
																	@if(app(App\Services\setting\CompanyProfileService::class)->get()->logo)
											            				@php
											            				    $logoPath = app()->environment('production') 
											            				        ? asset(app(App\Services\setting\CompanyProfileService::class)->get()->logo)
											            				        : asset('storage/' . app(App\Services\setting\CompanyProfileService::class)->get()->logo);
											            				@endphp
											            				<img src="{{ $logoPath }}" alt="profile picture"
											            				    class="w-150px" />
											        				@endif
															</a>
															<!--end::Logo-->
															<!--begin::Text-->
															<div class="text-sm-end fs-6 fw-semibold text-gray-700 mt-7">
																<div>{{ app(App\Services\setting\CompanyProfileService::class)->get()->name }} {{ app(App\Services\setting\CompanyProfileService::class)->get()->slogan }}</div>
																<div>{{ app(App\Services\setting\CompanyProfileService::class)->get()->email }} - {{ app(App\Services\setting\CompanyProfileService::class)->get()->phone }}</div>
															</div>
															<!--end::Text-->
														</div>
													</div>
													<!--end::Header-->
													@endif
													<!--begin::Wrapper-->
													<div class="m-0">
														<!--begin::Separator-->
														<div class="separator"></div>
														<!--begin::Separator-->
														<!--begin::Order details-->
														<div class="d-flex flex-column flex-sm-row gap-7 gap-md-10 fw-bold mt-5 mb-5">
															<div class="flex-root d-flex flex-column">
																<span class="text-muted">{{ __('general.serial') }}</span>
																<span class="fs-5">#{{$finance->number}}</span>
															</div>
															<div class="flex-root d-flex flex-column">
																<span class="text-muted">{{ __('general.date') }}</span>
																<span class="fs-5">{{$finance->date}}</span>
															</div>
															@if($finance->due_date)
															<div class="flex-root d-flex flex-column">
																<span class="text-muted">{{ __('general.due_date') }}</span>
																<span class="fs-5">{{$finance->due_date}}</span>
															</div>
															@elseif($model == 'pyment')
															<div class="flex-root d-flex flex-column">
																<span class="text-muted">{{ __('general.subject') }}</span>
																<span class="fs-5">{{$finance->subject}}</span>
															</div>
															@endif
															<div class="flex-root d-flex flex-column">
																<span class="text-muted">{{ __('general.currency') }}</span>
																<span class="fs-5">{{$finance->currency}}</span>
															</div>
														</div>
														<!--end::Order details-->
														<!--begin::Separator-->
														<div class="separator"></div>
														<!--begin::Separator-->
														@if($model != 'expense')
														<!--begin::Billing & shipping-->
														<div class="d-flex flex-column flex-sm-row gap-7 gap-md-10 fw-bold mt-5 mb-10">
														    <div class="flex-root d-flex flex-column">
														        <span class="text-muted">{{ __('general.issue_for') }}</span>
														        <span class="fs-6">
														            @if(!empty($finance->client?->name))
														                {{ $finance->client->name }} 
														            @endif
																
														            @if(!empty($finance->client?->email))
														                - {{ $finance->client->email }}<br />
														            @endif
																
														            @if(!empty($finance->client?->tax_number))
														                {{ __('general.tax_number') }} : {{ $finance->client->tax_number }}
														            @endif
														        </span>
														    </div>
														
														    <div class="flex-root d-flex flex-column">
														        <span class="text-muted">{{ __('general.client_address') }}</span>
														        <span class="fs-6">
														            @if(!empty($finance->billing_address))
														                {{ $finance->billing_address }}<br />
														            @endif
																
														            @if(!empty($finance->client?->address?->country))
														                {{ $finance->client->address->country }}-{{ $finance->client->address->city }}
														            @endif
														        </span>
														    </div>
														</div>
														<!--end::Billing & shipping-->
														@endif

														@if($model != 'pyment')
														<!--begin::Content-->
														<div class="flex-grow-1">
															<!--begin::Table-->
															<div class="table-responsive border-bottom mb-9">
																<table class="table mb-3">
																	<thead>
																		<tr
																			class="border-bottom fs-6 fw-bold text-muted">
																			<th class="min-w-175px pb-2">{{ __('general.item') }}
																			</th>
																			<th class="min-w-70px text-start pb-2">{{ __('general.quantity') }}
																			</th>
																			<th class="min-w-80px text-start pb-2">{{ __('general.price') }}
																			</th>
																			<th class="min-w-100px text-start pb-2">{{ __('general.special_tax') }}
																			</th>
																			<th class="min-w-100px text-start pb-2">{{ __('general.total') }}
																			</th>
																		</tr>
																	</thead>
																	<tbody>
																		@foreach($modelItems as $item)
																			<tr class="fw-bold text-gray-700 fs-5 text-start">
																				<td class="d-flex align-items-start flex-column ">
																					<h4 class="fs-4 text-gray-900 fw-bolder">{{$item->name}}</h4>
																					<p class="fs-6 text-gray-600 mt-0 mb-0">{{$item->description}}</p>
																				</td>
																				<td class="fs-4 text-gray-900 fw-bolder">{{$item->qty}}</td>
																				<td class="fs-4 text-gray-900 fw-bolder">{{$item->amount}} {{$finance->currency}}</td>
																				<td class="fs-4 text-gray-900 fw-bolder">
																					{{$item->tax}} %</td>
																				<td class="fs-5 text-gray-900 fw-bolder ">
																					{{$item->subtotal}} {{$finance->currency}}</td>
																			</tr>
																		@endforeach
																	</tbody>
																</table>
															</div>
															<!--end::Table-->
															<!--begin::Container-->
															<div class="d-flex justify-content-end">
																<!--begin::Section-->
																<div class="mw-600px w-350px">
																	{{-- <!--begin::Item-->
																	<div class="d-flex flex-stack mb-5 border-bottom pb-4">
																		<!--begin::Accountname-->
																		<div
																			class="fw-semibold pe-10 text-gray-600 fs-4">
																			{{ __('general.adjustment') }}</div>
																		<!--end::Accountname-->
																		<!--begin::Label-->
																		<div
																			class="text-end fw-bold fs-4 text-gray-800">
																			{{$finance->adjustment}} {{$finance->currency}}</div>
																		<!--end::Label-->
																	</div>
																	<!--end::Item--> --}}
																	<!--begin::Item-->
																	<div class="d-flex flex-stack mb-5 border-bottom pb-4">
																		<!--begin::Accountname-->
																		<div
																			class="fw-semibold pe-10 text-gray-600 fs-4">
																			{{ __('general.subtotal') }}</div>
																		<!--end::Accountname-->
																		<!--begin::Label-->
																		<div
																			class="text-end fw-bold fs-4 text-gray-800">
																			{{$finance->subtotal}} {{$finance->currency}}</div>
																		<!--end::Label-->
																	</div>
																	<!--end::Item-->
																	<!--begin::Item-->
																	<div class="d-flex flex-stack mb-5 border-bottom pb-4">
																		<!--begin::Accountname-->
																		<div
																			class="fw-semibold pe-10 text-gray-600 fs-4">
																			{{ __('general.tax') }} @if($finance->tax > 0){{$finance->tax}}% @endif</div>
																		<!--end::Accountname-->
																		<!--begin::Label-->
																		<div
																			class="text-end fw-bold fs-4 text-gray-800">
																			{{$finance->overall_tax_value}} {{$finance->currency}}</div>
																		<!--end::Label-->
																	</div>
																	<!--end::Item-->
																	@if($finance->discount_amount_type == 'percentage')
																	<!--begin::Item-->
																	<div class="d-flex flex-stack mb-5 border-bottom pb-4">
																		<!--begin::Accountnumber-->
																		<div
																			class="fw-semibold pe-10 text-gray-600 fs-4">
																			{{ __('general.discount') }} {{$finance->discount}}%</div>
																		<!--end::Accountnumber-->
																		<!--begin::Number-->
																		<div
																			class="text-end fw-bold fs-4 text-gray-800">
																			 {{$finance->total_discount}} {{$finance->currency}}</div>
																		<!--end::Number-->
																	</div>
																	<!--end::Item-->
																	@elseif($finance->discount_amount_type == 'fixed_amount')
																	<!--begin::Item-->
																	<div class="d-flex flex-stack mb-5 border-bottom pb-4">
																		<!--begin::Accountnumber-->
																		<div
																			class="fw-semibold pe-10 text-gray-600 fs-4">
																			{{ __('general.discount') }}</div>
																		<!--end::Accountnumber-->
																		<!--begin::Number-->
																		<div
																			class="text-end fw-bold fs-4 text-gray-800">
																			 {{$finance->total_discount}} {{$finance->currency}}</div>
																		<!--end::Number-->
																	</div>
																	<!--end::Item-->
																	@else
																	<!--begin::Item-->
																	<div class="d-flex flex-stack mb-5 border-bottom pb-4">
																		<!--begin::Accountnumber-->
																		<div
																			class="fw-semibold pe-10 text-gray-600 fs-4">
																			{{ __('general.discount') }} {{$finance->discount}}%</div>
																		<!--end::Accountnumber-->
																		<!--begin::Number-->
																		<div
																			class="text-end fw-bold fs-4 text-gray-800">
																			 {{$finance->total_discount}} {{$finance->currency}}</div>
																		<!--end::Number-->
																	</div>
																	<!--end::Item-->
																	@endif
																	<!--begin::Item-->
																	<div class="d-flex flex-stack">
																		<!--begin::Code-->
																		<div
																			class="fw-semibold pe-10 text-gray-600 fs-1">
																			{{ __('general.total') }}</div>
																		<!--end::Code-->
																		<!--begin::Label-->
																		<div
																			class="text-end fw-bold fs-1 text-gray-800">
																			{{$finance->total}} {{$finance->currency}}</div>
																		<!--end::Label-->
																	</div>
																	<!--end::Item-->
																</div>
																<!--end::Section-->
															</div>
															<!--end::Container-->
														</div>
														<!--end::Content-->
														@elseif($model == 'pyment')
														<!--begin::Content-->
														<div class="flex-grow-1">
															<!--begin::Table-->
															<div class="table-responsive mb-9">
																<table class="table mb-3">
																	<thead>
																		<tr
																			class="border-bottom fs-6 fw-bold text-muted">
																			<th class="min-w-100px pb-2">{{ __('general.payment_mode') }}
																			</th>
																			<th class="min-w-100px text-end pb-2">{{ __('general.total') }}
																			</th>
																			<th class="min-w-100px text-end pb-2">{{ __('general.currency') }}
																			</th>
																			<th class="min-w-100px text-end pb-2">{{ __('general.total') }}
																			</th>
																		</tr>
																	</thead>
																	<tbody>
																		<tr class="fw-bold text-gray-700 fs-5 text-end">
																			<td class="d-flex align-items-start flex-column ">
																				<h4 class="fs-4 text-gray-900 fw-bolder">{{$finance->payment_mode}} - {{$finance->payment_method}}</h4>
																				<p class="fs-6 text-gray-600 mt-0 mb-0">{{$finance->transaction_number}}</p>
																			</td>
																			<td class="fs-4 text-gray-900 fw-bolder">{{$finance->total}}</td>
																			<td class="fs-4 text-gray-900 fw-bolder">{{$finance->currency}}</td>
																			<td class="fs-5 text-gray-900 fw-bolder ">
																				{{$finance->total}}</td>
																		</tr>
																	</tbody>
																</table>
															</div>
															<!--end::Table-->
														</div>
														<!--end::Content-->
														@endif
													</div>
													<!--end::Wrapper-->

													@php
													    $profile = app(App\Services\setting\CompanyProfileService::class)->get();
																									
													    function joinIfNotEmpty(...$parts) {
													        return collect($parts)->filter()->implode(' - ');
													    }
													@endphp
													
													@if($model != 'expense')
													<div class="mt-7">
													    <div class="row">
													        <div class="col text-center">
													            @if(!empty($profile->name))
													                <h4 class="fs-4 text-gray-900 w-bolder border-top pt-7 mb-2">{{ $profile->name }}</h4>
													            @endif
													            <div class="mb-5">
													                <!--begin::Text-->
													                @php
													                    $line1 = joinIfNotEmpty($profile->slogan, __('general.tax_number') . ' : ' . $profile->taxNumber, $profile->registrationNumber);
													                    $line2 = joinIfNotEmpty($profile->address, $profile->website);
													                    $line3 = joinIfNotEmpty($profile->email, $profile->phone, $profile->phone2);
													                @endphp
													
													                @if($line1)
													                    <p class="fw-semibold fs-7 text-gray-600 mb-0">{{ $line1 }}</p>
													                @endif
													                @if($line2)
													                    <p class="fw-semibold fs-7 text-gray-600 mb-0">{{ $line2 }}</p>
													                @endif
													                @if($line3)
													                    <p class="fw-semibold fs-7 text-gray-600 mb-0">{{ $line3 }}</p>
													                @endif
													                <!--end::Text-->
													            </div>
													        </div>
													    </div>
													
													    <div class="row border-top pt-7 mb-2">
													        <div class="col text-center">
													            <div class="mb-5">
													                <!--begin::Text-->
													                @php
													                    $bankAccounts = joinIfNotEmpty($profile->bankAccount, $profile->bankAccount2);
													                    $supportLine = joinIfNotEmpty(__('general.for_support') . ' : ' . $profile->supportEmail, $profile->supportPhone);
													                @endphp
													
													                @if($bankAccounts)
													                    <p class="fw-semibold fs-7 text-gray-600 mb-0">{{ __('general.bank_accounts') }} : {{ $bankAccounts }}</p>
													                @endif
																
													                @if($supportLine)
													                    <p class="fw-semibold fs-7 text-gray-600 mb-0">{{ $supportLine }}</p>
													                @endif
													                <!--end::Text-->
													            </div>
													        </div>
													    </div>
													</div>
													@endif
													
												</div>
												<!--end::Finance content-->
											</div>
											<!--end::Content-->
										</div>
										<!--end::Layout-->
									</div>
									<!--end::Body-->
								</div>
								<!--end::Invoice 2 main-->
							</div>
							<!--end::Content container-->
						</div>
						<!--end::Content-->
					
				</div>
				<!--end:::Main-->

				

			</div>
			<!--end::Wrapper-->
		</div>
		<!--end::Page-->
	</div>
	<!--end::App-->
		
	{{-- Automatically triggers the print dialog when the page loads --}}
	<script type="text/javascript">
        window.onload = function() {
            window.print(); 
        };
    </script>
	
	<!--begin::Javascript-->
	@include('assets._main_scripts')

	
	<!--begin::Vendors Javascript(used for this page only)-->
	<script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
	<!--end::Vendors Javascript-->

	<!--begin::Custom Javascript(used for this page only)-->
	<script src="{{ asset('assets/js/widgets.bundle.js') }}"></script>
	<script src="{{ asset('assets/js/custom/widgets.js') }}"></script>
	<script src="{{ asset('assets/js/custom/apps/chat/chat.js') }}"></script>
	<script src="{{ asset('assets/js/custom/utilities/modals/upgrade-plan.js') }}"></script>
	<script src="{{ asset('assets/js/custom/utilities/modals/create-campaign.js') }}"></script>
	<script src="{{ asset('assets/js/custom/utilities/modals/users-search.js') }}"></script>
	<!--end::Custom Javascript-->
	<!--end::Javascript-->
</body>
<!--end::Body-->

</html>