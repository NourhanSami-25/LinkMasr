<!DOCTYPE html>

@if (app()->getLocale() == 'ar')
	@include('assets._language_ar')
@else
	@include('assets._language_en')
@endif

<head>

	<title>Link Masr | Print</title>
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
				size: A4;
                margin: 1cm;
			}

			body {
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

	<script>
		var defaultThemeMode = "light"; var themeMode; if (document.documentElement) { if (document.documentElement.hasAttribute("data-bs-theme-mode")) { themeMode = "light" } else { if (localStorage.getItem("data-bs-theme") !== null) { themeMode = "light"; } else { themeMode = "light" } } if (themeMode === "light") { themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "light" : "light"; } document.documentElement.setAttribute("data-bs-theme", themeMode); }
	</script>

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

			@php
			    $profile = app(App\Services\setting\CompanyProfileService::class)->get();
															
			    function joinIfNotEmpty(...$parts) {
			        return collect($parts)->filter()->implode(' - ');
			    }
			@endphp

			<!--begin::Main-->
			<div class="app-main flex-column flex-row-fluid" id="kt_app_main">
				<!--begin::Content wrapper-->
				<div class="d-flex flex-column flex-column-fluid">
					<!--begin::Content-->
					<div id="kt_app_content" class="app-content flex-column-fluid mb-0 mt-0 pb-0">
						<!--begin::Content container-->
						<div id="kt_app_content_container" class="app-container container-fluid">
							<!--begin::main-->
							<div class="card" style="box-shadow: none; border: none">
								<!--begin::Body-->
								<div class="card-body">
									<!--begin::Layout-->
									<div class="d-flex flex-column flex-xl-row">
										<!--begin::Content-->
										<div class="flex-lg-row-fluid me-xl-18 mb-10 mb-xl-0">
											<!--begin::Printing Content-->
											<div class="mt-n1">
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
												<!--begin::Title-->
                                                <div class="mb-6 mb-xl-9">
                                                    <!--begin::Title Content-->
                                                    <div class="card-body py-0 text-center">
                                                        <div class="text-black fw-bold mt-4 mb-0" style="font-size: 2rem">{{$title}}</div>
                                                        <div class="fs-4 fw-semibold text-black mb-5" style="width: 75%; margin: 0 auto; text-align: center;">{{$subtitle}}</div>
                                                    </div>
                                                    <!--end::Title Content-->
                                                </div>
                                                <!--end::Title-->
                                                <!--begin::Data-->
                                                <div class="row g-5 g-xl-10">
                                                    <div class="col-xl-12">
                                                		<div class="d-flex flex-column flex-xl-row gap-7 gap-lg-10">
    				                                        <!--begin::details-->
    				                                        <div class="card card-flush py-4 flex-row-fluid">
    				                                        	<!--begin::Card body-->
                                                                <div class="card-body pt-0">
                                                                    <div class="fw-semibold text-black fs-5">
                                                                        <!--begin::Data row-->
                                                                        @foreach ($data->chunk(2) as $row)
                                                                        <div class="row mb-4 align-items-center">
                                                                             @foreach ($row as $item)
                                                                                <div class="col-5">
                                                                                    <div class="d-flex justify-content-between fs-5">
                                                                                        <span class="text-black fw-semibold">{{ $item['label'] }}</span>
                                                                                        <span class="fw-bold text-black">
                                                                                            @if(empty($item['value']) || $item['value'] == 'null')
                                                                                                {{ __('general.not_exists')}}
                                                                                            @else
                                                                                                {{ $item['value']}}
                                                                                            @endif
                                                                                        </span>
                                                                                    </div>
                                                                                </div>
                                                                                @if ($loop->last && $row->count() === 1)
                                                                                    <div class="col-7"></div>
                                                                                @elseif ($loop->index === 0)
                                                                                    <div class="col-2 text-center">
                                                                                        <div class="border-start h-100 mx-auto" style="width: 1px; background-color: #dee2e6;"></div>
                                                                                    </div>
                                                                                @endif
                                                                            @endforeach
                                                                        </div>
                                                                        @endforeach
                                                                        <!--end::Data row-->
                                                                    </div>
                                                                </div>
                                                                <!--end::Card body-->
    				                                        </div>
    				                                        <!--end::details-->
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--end::Data-->
											</div>
											<!--end::Printing Content-->
										</div>
										<!--end::Content-->
									</div>
									<!--end::Layout-->
								</div>
								<!--end::Body-->
							</div>
							<!--end::main-->
						</div>
						<!--end::Content container-->
					</div>
					<!--end::Content-->
			    </div>
			</div>
            <!--end:::Main-->

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
	@include('assets._data_table_scripts')
	<!--end::Javascript-->
    
</body>
<!--end::Body-->

</html>