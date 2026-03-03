<!DOCTYPE html>

@if (app()->getLocale() == 'ar')
	@include('assets._language_ar')
@else
	@include('assets._language_en')
@endif

<head>

	<title>Link Masr | Print Statment</title>
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
    .card-row {
        display: flex !important;
        flex-direction: row !important;
        flex-wrap: nowrap !important;
        justify-content: space-between;
    }

    .card-row .card {
        width: 32% !important; /* 3 cards across with spacing */
        display: block;
        page-break-inside: avoid !important;
    }

	@media print {
			/* Ensure no margins on the body */
			@page {
				size: A4;
                margin: 1cm;
			}

			body {
				margin: 0;
				padding: 0;
			}            
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

	<script>
		var defaultThemeMode = "light"; var themeMode; if (document.documentElement) { if (document.documentElement.hasAttribute("data-bs-theme-mode")) { themeMode = "light" } else { if (localStorage.getItem("data-bs-theme") !== null) { themeMode = "light"; } else { themeMode = "light" } } if (themeMode === "light") { themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "light" : "light"; } document.documentElement.setAttribute("data-bs-theme", themeMode); }
	</script>
	
	@php
	    $profile = app(App\Services\setting\CompanyProfileService::class)->get();
													
	    function joinIfNotEmpty(...$parts) {
	        return collect($parts)->filter()->implode(' - ');
	    }
	@endphp

	<!--begin::App-->
	<div class="d-flex flex-column flex-root app-root" id="kt_app_root">
		<!--begin::Page-->
		<div class="app-page flex-column flex-column-fluid" id="kt_app_page">
			
			<!--begin::Toolbar-->
			<div id="kt_app_toolbar" class="app-toolbar pt-2 pb-5">
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

            @php
			    $profile = app(App\Services\setting\CompanyProfileService::class)->get();
			@endphp

           

			<!--begin::Wrapper-->
				<!--begin::Main-->
				<div class="app-main flex-column flex-row-fluid" id="kt_app_main">
					<!--begin::Content wrapper-->
					<div class="d-flex flex-column flex-column-fluid">
						<!--begin::Content-->
							<!--begin::Content container-->
							<div id="kt_app_content" class="app-content flex-column-fluid">
                                <!--begin::Content container-->
                                <div id="kt_app_content_container" class="app-container container">

                                    <!--begin::Title-->
                                    <div class="card mb-6 mb-xl-9">
                                        <!--begin::Title Content-->
                                        <div class="card-body py-0 text-center">
                                            <div class="row justify-content-between align-items-center mt-5 mb-5">
                                                <!-- Left Column -->
                                                <div class="col-md-6 text-start">
                                                    <div class="fw-bold text-black fs-2">{{ $profile->name }}</div>
                                                    <div class="text-muted fs-6">{{ $profile->slogan }}</div>
                                                </div>
                                            
                                                <!-- Right Column -->
                                                <div class="col-md-6 text-end">
                                                    <div class="fw-semibold text-black fs-6">
                                                        {{ $profile->email }}  |  {{ $profile->phone }}
                                                    </div>
                                                    <div class="text-muted fs-6">
                                                         {{ $profile->address }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--end::Title Content-->
                                    </div>
                                    <!--end::Title-->
            
                                    <!--begin::Toolbar-->
			                        <div id="kt_app_toolbar" class="app-toolbar pt-6 pb-2">
			                        	<!--begin::Toolbar container-->
			                        	<div id="kt_app_toolbar_container"
			                        		class="app-container container-fluid d-flex align-items-stretch">
			                        		<!--begin::Toolbar wrapper-->
			                        		<div class="app-toolbar-wrapper d-flex flex-stack flex-wrap justify-content-center gap-4 w-100">
			                        			<!--begin::Page title-->
			                        			<div class="page-title d-flex flex-column justify-content-center text-center me-3">
			                        			    <!--begin::Title-->
			                        			    <div>
			                        			        <h1 class="text-gray-900 fw-bold fs-2 fs-lg-1 mb-2 mb-md-3">{{ $client->name }}</h1>
			                        			        <div class="d-flex flex-column flex-md-row align-items-center justify-content-center gap-2">
			                        			            <span class="text-gray-600 fw-semibold fs-6 fs-lg-4">
			                        			                {{ __('general.report_for_the_finance_statment_at') }}
			                        			            </span>
			                        			            <span class="fw-bold text-primary fs-6">
			                        			                {{ now()->format('F j, Y') }}
			                        			            </span>
			                        			        </div>
			                        			    </div>
			                        			    <!--end::Title-->
			                        			</div>
			                        			<!--end::Page title-->
                                            
			                        		</div>
			                        		<!--begin::Actions-->
			                        		<div class="d-flex align-items-center gap-2 gap-lg-3">
                                            
			                        		</div>
			                        		<!--end::Actions-->
			                        		<!--end::Toolbar wrapper-->
			                        	</div>
			                        	<!--end::Toolbar container-->
			                        </div>
			                        <!--end::Toolbar-->

                                    <!--begin::Row-->
                                    <div class="row gy-5 gx-xl-10">
                                        <!--begin::Col-->
                                        <div class="col-sm-6 col-xl-3">
                                            <!--begin::Card widget 2-->
                                            <div class="card h-lg-75">
                                                <!--begin::Body-->
                                                <div
                                                    class="card-body d-flex justify-content-center align-items-center flex-column mb-7">
                                                    <!--begin::Icon-->
                                                    <div class="m-0">
                                                        <span class="fw-bold fs-3 text-warning lh-1 ls-n2">{{__('general.debit_balance')}}</span>
                                                    </div>
                                                    <!--end::Icon-->
                                                    <!--begin::Section-->
                                                    <div class="d-flex flex-column my-2">
                                                        <!--begin::Number-->
                                                        <span class="fw-semibold fs-3 text-gray-800 lh-1 ls-n2">{{ number_format($debit_balance, 2) }}</span>
                                                        <!--end::Number-->
                                                        <!--begin::Follower-->
                                                        <div class="m-0">
                                                            <span class="fw-semibold fs-6 text-gray-500">{{ $client->currency}}</span>
                                                        </div>
                                                        <!--end::Follower-->
                                                    </div>
                                                    <!--end::Section-->
                                                    <!--begin::Badge-->
                                                    {{-- <div class="text-center mb-1">
                                                        <!--begin::Link-->
                                                        <a class="btn btn-sm btn-primary me-2"
                                                            data-bs-target="#kt_modal_new_address"
                                                            data-bs-toggle="modal">{{__('general.details')}}</a>
                                                        <!--end::Link-->
                                                        <!--begin::Link-->
                                                        <a class="btn btn-sm btn-light"
                                                            href="apps/user-management/users/view.html">{{__('general.print')}}</a>
                                                        <!--end::Link-->
                                                    </div> --}}
                                                    <!--end::Badge-->
                                                </div>
                                                <!--end::Body-->
                                            </div>
                                            <!--end::Card widget 2-->
                                        </div>
                                        <!--end::Col-->
                                        <!--begin::Col-->
                                        <div class="col-sm-6 col-xl-3">
                                            <!--begin::Card widget 2-->
                                            <div class="card h-lg-75">
                                                <!--begin::Body-->
                                                <div
                                                    class="card-body d-flex justify-content-center align-items-center flex-column">
                                                    <!--begin::Icon-->
                                                    <div class="m-0">
                                                        <span class="fw-bold fs-3 text-success lh-1 ls-n2">{{__('general.credit_balance')}}</span>
                                                    </div>
                                                    <!--end::Icon-->
                                                    <!--begin::Section-->
                                                    <div class="d-flex flex-column my-2">
                                                        <!--begin::Number-->
                                                        <span class="fw-semibold fs-3 text-gray-800 lh-1 ls-n2">{{ number_format($credit_balance, 2) }}</span>
                                                        <!--end::Number-->
                                                        <!--begin::Follower-->
                                                        <div class="m-0">
                                                            <span class="fw-semibold fs-6 text-gray-500">{{ $client->currency}}</span>
                                                        </div>
                                                        <!--end::Follower-->
                                                    </div>
                                                    <!--end::Section-->
                                                    <!--begin::Badge-->
                                                    {{-- <div class="text-center mb-1">
                                                        <!--begin::Link-->
                                                        <a class="btn btn-sm btn-primary me-2"
                                                            data-bs-target="#kt_modal_new_address"
                                                            data-bs-toggle="modal">{{__('general.details')}}</a>
                                                        <!--end::Link-->
                                                        <!--begin::Link-->
                                                        <a class="btn btn-sm btn-light"
                                                            href="apps/user-management/users/view.html">{{__('general.print')}}</a>
                                                        <!--end::Link-->
                                                    </div> --}}
                                                    <!--end::Badge-->
                                                </div>
                                                <!--end::Body-->
                                            </div>
                                            <!--end::Card widget 2-->
                                        </div>
                                        <!--end::Col-->
                                        <!--begin::Col-->
                                        <div class="col-sm-6 col-xl-3">
                                            <!--begin::Card widget 2-->
                                            <div class="card h-lg-75">
                                                <!--begin::Body-->
                                                <div class="card-body d-flex justify-content-center align-items-center flex-column">
                                                    <!--begin::Icon-->
                                                    <div class="m-0">
                                                        <span class="fw-bold fs-3 lh-1 ls-n2 
                                                            {{ $current_balance < 0 ? 'text-danger' : 'text-primary' }}">
                                                            {{ __('general.current_balance') }}
                                                        </span>
                                                    </div>
                                                    <!--end::Icon-->
                                                    
                                                    <!--begin::Section-->
                                                    <div class="d-flex flex-column my-2">
                                                        <!--begin::Number-->
                                                        <span class="fw-semibold fs-3 text-gray-800 lh-1 ls-n2">
                                                            {{ number_format($current_balance, 2) }}
                                                        </span>
                                                        <!--end::Number-->
                                            
                                                        <!--begin::Follower-->
                                                        <div class="m-0">
                                                            <span class="fw-semibold fs-6 text-gray-500">{{ $client->currency }}</span>
                                                        </div>
                                                        <!--end::Follower-->
                                                    </div>
                                                    <!--end::Section-->
                                                </div>
                                                <!--end::Body-->
                                            </div>										
                                            <!--end::Card widget 2-->
                                        </div>
                                        <!--end::Col-->
                                        <!--begin::Col-->
                                        <div class="col-sm-6 col-xl-3">
                                            <!--begin::Card widget 2-->
                                            <div class="card h-lg-75">
                                                <!--begin::Body-->
                                                <div
                                                    class="card-body d-flex justify-content-center align-items-center flex-column">
                                                    <!--begin::Icon-->
                                                    <div class="m-0">
                                                        <span class="fw-bold fs-3 text-primary lh-1 ls-n2">{{__('general.client_payments')}}</span>
                                                    </div>
                                                    <!--end::Icon-->
                                                    <!--begin::Section-->
                                                    <div class="d-flex flex-column my-2">
                                                        <!--begin::Number-->
                                                        <span class="fw-semibold fs-3 text-gray-800 lh-1 ls-n2">{{ number_format($actually_paid, 2) }}</span>
                                                        <!--end::Number-->
                                                        <!--begin::Follower-->
                                                        <div class="m-0">
                                                            <span class="fw-semibold fs-6 text-gray-500">{{ $client->currency}}</span>
                                                        </div>
                                                        <!--end::Follower-->
                                                    </div>
                                                    <!--end::Section-->
                                                </div>
                                                <!--end::Body-->
                                            </div>
                                            <!--end::Card widget 2-->
                                        </div>
                                        <!--end::Col-->
                                    </div>
    
    
                                    {{-- @if(! $balance_status )
                                        <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
                                            <div class="col-xl-12">
                                                <div class="card mb-5 mb-xl-8">
                                                    <div class="card-body text-center py-10">
                                                        <span class="fw-bold fs-3 text-danger">{{ __('general.balane_error_message') }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif --}}
    
    
    
                                    <!--begin::Row-->
                                    <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
                                        <!--begin::Col-->
                                        <div class="col-xl-12">
    
                                            <div class="card mb-5 mb-xl-8">
                                                <!--begin::Header-->
                                                <div class="card-header border-0 pt-5">
                                                    <h3 class="card-title align-items-start flex-column">
                                                        <span class="card-label fw-bold text-gray-800">{{__('general.client_finance_summary')}}</span>
                                                        <span class="text-gray-500 mt-1 fw-semibold fs-6">{{__('general.statment_for_all_client_finances')}}</span>
                                                    </h3>
                                                    {{-- <div class="card-toolbar">
                                                        <a href="#" class="btn btn-sm btn-light-primary">{{__('general.print_report')}}</a>
                                                    </div> --}}
                                                </div>
                                                <!--end::Header-->
                                                <!--begin::Body-->
                                                <div class="card-body py-3">
                                                    <!--begin::Table container-->
                                                    <div class="table-responsive">
                                                        <!--begin::Table-->
                                                        <table class="table align-middle gs-0 gy-4">
                                                            <!--begin::Table head-->
                                                            <thead>
                                                                <tr class="fw-bold text-gray-900 bg-light">
                                                                    <th class="ps-4 min-w-200px rounded-start">{{__('general.finance_item')}}</th>
                                                                    <th class="min-w-200px">{{__('general.status')}}</th>
                                                                    <th class="min-w-200px">{{__('general.status')}}</th>
                                                                    <th class="min-w-200px">{{__('general.status')}}</th>
                                                                    <th class="min-w-200px">{{__('general.status')}}</th>
                                                                    <th class="min-w-200px">{{__('general.status')}}</th>
                                                                </tr>
                                                            </thead>
                                                            <!--end::Table head-->
                                                            <!--begin::Table body-->
                                                            <tbody>
                                                                <tr>
                                                                    <td>
                                                                        <div class="d-flex align-items-center">
                                                                            <div class="d-flex justify-content-start flex-column">
                                                                                <a href="#"
                                                                                    class="text-gray-900 fw-bold text-hover-primary mb-1 text-uppercase fs-6">{{__('general.payments')}}</a>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td class="text-start">
                                                                        <span class="text-gray-700 fw-semibold d-block fs-6">{{$paymentStatusData['paid']['count']}} {{__('general.paid')}}</span>
                                                                        <span class="text-gray-900 fw-bold d-block fs-6">{{$paymentStatusData['paid']['total']}} {{ $client->currency}}</span>
                                                                    </td>
                                                                    <td class="text-start">
                                                                        <span class="text-gray-700 fw-semibold d-block fs-6">{{$paymentStatusData['draft']['count']}} {{__('general.draft')}}</span>
                                                                        <span class="text-gray-900 fw-bold d-block fs-6">{{$paymentStatusData['draft']['total']}} {{ $client->currency}}</span>
                                                                    </td>
                                                                    <td class="text-start">
                                                                        <span class="text-gray-700 fw-semibold d-block fs-6"></span>
                                                                        <span class="text-gray-900 fw-bold d-block fs-6"></span>
                                                                    </td>
                                                                    <td class="text-start">
                                                                        <span class="text-gray-700 fw-semibold d-block fs-6"></span>
                                                                        <span class="text-gray-900 fw-bold d-block fs-6"></span>
                                                                    </td>
                                                                    <td class="text-start">
                                                                        <span class="text-gray-700 fw-semibold d-block fs-6"></span>
                                                                        <span class="text-gray-900 fw-bold d-block fs-6"></span>
                                                                    </td>
                                                                </tr>
    
                                                                <tr>
                                                                    <td>
                                                                        <div class="d-flex align-items-center">
                                                                            <div class="d-flex justify-content-start flex-column">
                                                                                <a href="#"
                                                                                    class="text-gray-900 fw-bold text-hover-primary mb-1 text-uppercase fs-6">{{__('general.invoices')}}</a>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td class="text-start">
                                                                        <span class="text-gray-700 fw-semibold d-block fs-6">{{$invoiceStatusData['paid']['count']}} {{__('general.paid')}}</span>
                                                                        <span class="text-gray-900 fw-bold d-block fs-6">{{$invoiceStatusData['paid']['total']}} {{ $client->currency}}</span>
                                                                    </td>
                                                                    <td class="text-start">
                                                                        <span class="text-gray-700 fw-semibold d-block fs-6">
                                                                            {{ $invoiceStatusData['unpaid']['count'] }} {{ __('general.unpaid') }}
                                                                        </span>
                                                                        <span class="fw-bold d-block fs-6 
                                                                            {{ $invoiceStatusData['unpaid']['count'] > 0 ? 'text-warning' : 'text-gray-900' }}">
                                                                            {{ $invoiceStatusData['unpaid']['total'] }} {{ $client->currency }}
                                                                        </span>
                                                                    </td>
                                                                    
                                                                    <td class="text-start">
                                                                        <span class="text-gray-700 fw-semibold d-block fs-6">{{$invoiceStatusData['partially']['count']}} {{__('general.partially')}}</span>
                                                                        <span class="text-gray-900 fw-bold d-block fs-6">{{$invoiceStatusData['partially']['total']}} {{ $client->currency}}</span>
                                                                    </td>
                                                                    <td class="text-start">
                                                                        <span class="text-gray-700 fw-semibold d-block fs-6">
                                                                            {{ $invoiceStatusData['overdue']['count'] }} {{ __('general.overdue') }}
                                                                        </span>
                                                                        
                                                                        <span class="fw-bold d-block fs-6 
                                                                            {{ $invoiceStatusData['overdue']['count'] > 0 ? 'text-danger' : 'text-gray-900' }}">
                                                                            {{ $invoiceStatusData['overdue']['total'] }} {{ $client->currency }}
                                                                        </span>
                                                                    </td>
                                                                    
                                                                    <td class="text-start">
                                                                        <span class="text-gray-700 fw-semibold d-block fs-6">{{$invoiceStatusData['draft']['count']}} {{__('general.draft')}}</span>
                                                                        <span class="text-gray-900 fw-bold d-block fs-6">{{$invoiceStatusData['draft']['total']}} {{ $client->currency}}</span>
                                                                    </td>
                                                                </tr>
    
                                                                <tr>
                                                                    <td>
                                                                        <div class="d-flex align-items-center">
                                                                            <div class="d-flex justify-content-start flex-column">
                                                                                <a href="#"
                                                                                    class="text-gray-900 fw-bold text-hover-primary mb-1 text-uppercase fs-6">{{__('general.paymentRequests')}}</a>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td class="text-start">
                                                                        <span class="text-gray-700 fw-semibold d-block fs-6">{{$paymentRequestStatusData['sent']['count']}} {{__('general.sent')}}</span>
                                                                        <span class="text-gray-900 fw-bold d-block fs-6">{{$paymentRequestStatusData['sent']['total']}} {{ $client->currency}}</span>
                                                                    </td>
                                                                    <td class="text-start">
                                                                        <span class="text-gray-700 fw-semibold d-block fs-6">{{$paymentRequestStatusData['accepted']['count']}} {{__('general.accepted')}}</span>
                                                                        <span class="text-gray-900 fw-bold d-block fs-6">{{$paymentRequestStatusData['accepted']['total']}} {{ $client->currency}}</span>
                                                                    </td>
                                                                    <td class="text-start">
                                                                        <span class="text-gray-700 fw-semibold d-block fs-6">
                                                                            {{ $paymentRequestStatusData['expired']['count'] }} {{ __('general.expired') }}
                                                                        </span>
                                                                        <span class="fw-bold d-block fs-6 
                                                                            {{ $paymentRequestStatusData['expired']['count'] > 0 ? 'text-warning' : 'text-gray-900' }}">
                                                                            {{ $paymentRequestStatusData['expired']['total'] }} {{ $client->currency }}
                                                                        </span>
                                                                    </td>
                                                                    
                                                                    <td class="text-start">
                                                                        <span class="text-gray-700 fw-semibold d-block fs-6">
                                                                            {{ $paymentRequestStatusData['declined']['count'] }} {{ __('general.declined') }}
                                                                        </span>
                                                                        <span class="fw-bold d-block fs-6 
                                                                            {{ $paymentRequestStatusData['declined']['count'] > 0 ? 'text-danger' : 'text-gray-900' }}">
                                                                            {{ $paymentRequestStatusData['declined']['total'] }} {{ $client->currency }}
                                                                        </span>
                                                                    </td>
                                                                    
                                                                    <td class="text-start">
                                                                        <span class="text-gray-700 fw-semibold d-block fs-6">{{$paymentRequestStatusData['draft']['count']}} {{__('general.draft')}}</span>
                                                                        <span class="text-gray-900 fw-bold d-block fs-6">{{$paymentRequestStatusData['draft']['total']}} {{ $client->currency}}</span>
                                                                    </td>
                                                                </tr>
    
                                                                <tr>
                                                                    <td>
                                                                        <div class="d-flex align-items-center">
                                                                            <div class="d-flex justify-content-start flex-column">
                                                                                <a href="#"
                                                                                    class="text-gray-900 fw-bold text-hover-primary mb-1 text-uppercase fs-6">{{__('general.creditNotes')}}</a>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td class="text-start">
                                                                        <span class="text-gray-700 fw-semibold d-block fs-6">{{$creditNoteStatusData['paid']['count']}} {{__('general.paid')}}</span>
                                                                        <span class="text-gray-900 fw-bold d-block fs-6">{{$creditNoteStatusData['paid']['total']}} {{ $client->currency}}</span>
                                                                    </td>
                                                                    <td class="text-start">
                                                                        <span class="d-block fs-6 text-gray-700 fw-semibold">
                                                                            {{ $creditNoteStatusData['unpaid']['count'] }} {{ __('general.unpaid') }}
                                                                        </span>
                                                                        
                                                                        <span class="d-block fs-6 fw-bold 
                                                                            {{ $creditNoteStatusData['unpaid']['count'] > 0 ? 'text-warning' : 'text-gray-900' }}">
                                                                            {{ $creditNoteStatusData['unpaid']['total']  }} {{ $client->currency }}
                                                                        </span>
                                                                    </td>
    
                                                                    <td class="text-start">
                                                                        <span class="text-gray-700 fw-semibold d-block fs-6">{{$creditNoteStatusData['partially']['count']}} {{__('general.partially')}}</span>
                                                                        <span class="text-gray-900 fw-bold d-block fs-6">{{$creditNoteStatusData['partially']['total']}} {{ $client->currency}}</span>
                                                                    </td>
                                                                    <td class="text-start">
                                                                        <span class="text-gray-700 fw-semibold d-block fs-6"></span>
                                                                        <span class="text-gray-900 fw-bold d-block fs-6"></span>
                                                                    </td>
                                                                    <td class="text-start">
                                                                        <span class="text-gray-700 fw-semibold d-block fs-6">{{$creditNoteStatusData['draft']['count']}} {{__('general.draft')}}</span>
                                                                        <span class="text-gray-900 fw-bold d-block fs-6">{{$creditNoteStatusData['draft']['total']}} {{ $client->currency}}</span>
                                                                    </td>
                                                                </tr>
    
                                                                <tr>
                                                                    <td>
                                                                        <div class="d-flex align-items-center">
                                                                            <div class="d-flex justify-content-start flex-column">
                                                                                <a href="#"
                                                                                    class="text-gray-900 fw-bold text-hover-primary mb-1 text-uppercase fs-6">{{__('general.expenses')}}</a>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td class="text-start">
                                                                        <span class="text-gray-700 fw-semibold d-block fs-6">{{$expenseStatusData['paid']['count']}} {{__('general.paid')}}</span>
                                                                        <span class="text-gray-900 fw-bold d-block fs-6">{{$expenseStatusData['paid']['total']}} {{ $client->currency}}</span>
                                                                    </td>
                                                                    <td class="text-start">
                                                                        <span class="text-gray-700 fw-semibold d-block fs-6">{{$expenseStatusData['unpaid']['count']}} {{__('general.unpaid')}}</span>
                                                                        <span class="text-gray-900 fw-bold d-block fs-6">{{$expenseStatusData['unpaid']['total']}} {{ $client->currency}}</span>
                                                                    </td>
                                                                    <td class="text-start">
                                                                        <span class="text-gray-700 fw-semibold d-block fs-6">{{$expenseStatusData['partially']['count']}} {{__('general.partially')}}</span>
                                                                        <span class="text-gray-900 fw-bold d-block fs-6">{{$expenseStatusData['partially']['total']}} {{ $client->currency}}</span>
                                                                    </td>
                                                                    <td class="text-start">
                                                                        <span class="text-gray-700 fw-semibold d-block fs-6"></span>
                                                                        <span class="text-gray-900 fw-bold d-block fs-6"></span>
                                                                    </td>
                                                                    <td class="text-start">
                                                                        <span class="text-gray-700 fw-semibold d-block fs-6">{{$expenseStatusData['draft']['count']}} {{__('general.draft')}}</span>
                                                                        <span class="text-gray-900 fw-bold d-block fs-6">{{$expenseStatusData['draft']['total']}} {{ $client->currency}}</span>
                                                                    </td>
                                                                </tr>
                                                                
                                                            </tbody>
                                                            <!--end::Table body-->
                                                        </table>
                                                        <!--end::Table-->
                                                    </div>
                                                    <!--end::Table container-->
                                                </div>
                                                <!--begin::Body-->
                                            </div>
                                        </div>
                                        <!--end::Col-->
                                    </div>
                                    <!--end::Row-->
    
                                    {{-- <!--begin::Row-->
                                    <div class="row g-5 g-xl-10 mb-xl-10 ">
                                        <div class="col-xl-12">
                                            <div class="card card-flush h-100 mb-5 mb-xl-10">
                                                <!--begin::Card header-->
                                                <div class="card-header cursor-pointer justify-content-center">
                                                    <!--begin::Card title-->
                                                    <div class="card-title m-0">
                                                        <h1 class="page-heading d-flex flex-column justify-content-center text-gray-900 fw-bold fs-1 m-0 text-center">
                                                            {{ __('general.client_data_summary') }}</h1>
                                                    </div>
                                                    <!--end::Card title-->
                                                </div>
                                                <!--begin::Card header-->
                                                <div class="card-body p-9">
                                                    <div class="row g-5">
                                                        <!-- First Column -->
                                                        <div class="col-md-6">
                                                            <div class="card card-flush h-md-100">
                                                                <div class="card-header">
                                                                    <h3 class="card-title text-gray-900 fw-bold">{{ __('general.contact_information') }}</h3>
                                                                </div>
                                                                <div class="card-body pt-0">
                                                                    <!-- Name -->
                                                                    <div class="d-flex flex-column mb-5">
                                                                        <span class="text-muted fw-semibold fs-6 mb-1">{{ __('general.name') }}</span>
                                                                        <span class="text-gray-800 fw-bold fs-4">{{ $client->name }}</span>
                                                                    </div>
                                                                    
                                                                    <!-- Phone -->
                                                                    <div class="d-flex flex-column mb-5">
                                                                        <span class="text-muted fw-semibold fs-6 mb-1">{{ __('general.phone') }}</span>
                                                                        <div class="d-flex align-items-center">
                                                                            <i class="fas fa-phone-alt text-muted me-2 fs-4"></i>
                                                                            <a href="tel:{{ $client->phone }}" class="text-gray-800 fw-bold fs-4 text-hover-primary">{{ $client->phone }}</a>
                                                                        </div>
                                                                    </div>
                                                                    
                                                                    <!-- Email -->
                                                                    <div class="d-flex flex-column mb-5">
                                                                        <span class="text-muted fw-semibold fs-6 mb-1">{{ __('general.email') }}</span>
                                                                        <div class="d-flex align-items-center">
                                                                            <i class="fas fa-envelope text-muted me-2 fs-4"></i>
                                                                            <a href="mailto:{{ $client->email }}" class="text-gray-800 fw-bold fs-4 text-hover-primary">{{ $client->email }}</a>
                                                                        </div>
                                                                    </div>
                                                                    
                                                                    <!-- Status -->
                                                                    <div class="d-flex flex-column">
                                                                        <span class="text-muted fw-semibold fs-6 mb-1">{{ __('general.status') }}</span>
                                                                        <span class="badge badge-light-{{ $client->status == 'active' ? 'success' : 'danger' }} fs-4 fw-bold py-2 px-3">
                                                                            {{ ucfirst($client->status) }}
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    
                                                        <!-- Second Column -->
                                                        <div class="col-md-6">
                                                            <div class="card card-flush h-md-100">
                                                                <div class="card-header">
                                                                    <h3 class="card-title text-gray-900 fw-bold">{{ __('general.administrative_information') }}</h3>
                                                                </div>
                                                                <div class="card-body pt-0">
                                                                    <!-- Tax Number -->
                                                                    <div class="d-flex flex-column mb-5">
                                                                        <span class="text-muted fw-semibold fs-6 mb-1">{{ __('general.tax_number') }}</span>
                                                                        <span class="text-gray-800 fw-bold fs-4">{{ $client->tax_number ?: '-' }}</span>
                                                                    </div>
                                                                    
                                                                    <!-- Created At -->
                                                                    <div class="d-flex flex-column">
                                                                        <span class="text-muted fw-semibold fs-6 mb-1">{{ __('general.created_at') }}</span>
                                                                        <div class="d-flex align-items-center">
                                                                            <i class="fas fa-clock text-muted me-2 fs-5"></i>
                                                                            <span class="text-gray-800 fw-bold fs-4">
                                                                                {{ \Carbon\Carbon::parse($client->created_at)->format('M d, Y \a\t h:i A') }}
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>	
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end::Row--> --}}
                                    
                                </div>
                                <!--end::Content container-->
                            </div>
							<!--end::Content container-->
						</div>
						<!--end::Content-->
					</div>
				</div>
				<!--end:::Main-->
			</div>
			<!--end::Wrapper-->
		</div>
		<!--end::Page-->
	</div>
	<!--end::App-->
</body>
</html>