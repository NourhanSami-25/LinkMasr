<!DOCTYPE html>

@if (app()->getLocale() == 'ar')
	@include('assets._language_ar')
@else
	@include('assets._language_en')
@endif

<head>

	<title>Link Masr | Comming Soon</title>
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


	<!--begin::Custom Styles-->
	
	<!--end::Custom Styles-->

</head>

<body id="kt_body" class="app-blank bgi-size-cover bgi-position-center bgi-no-repeat">
	@include('assets.dark_mode')
	<!--begin::Theme mode setup on page load-->
    
	<!--end::Theme mode setup on page load-->
	<!--begin::Root-->
	<div class="d-flex flex-column flex-root" id="kt_app_root">
		<!--begin::Page bg image-->
		<style>
        	body {
        		background-image: url('{{ asset('assets/media/auth/bg7-dark.jpg') }}');
        	}
        
        	[data-bs-theme="dark"] body {
        		background-image: url('{{ asset('assets/media/auth/bg12-dark.jpg') }}');
        	}
        </style>
		<!--end::Page bg image-->
		<!--begin::Authentication - Signup Welcome Message -->
		<div class="d-flex flex-column flex-center flex-column-fluid">
			<!--begin::Content-->
			<div class="d-flex flex-column flex-center text-center p-10">
				<!--begin::Wrapper-->
				<div class="card card-flush w-lg-650px py-5">
					<div class="card-body py-15 py-lg-20">
						<!--begin::Logo-->
						<div class="mb-13">
							<a href="#" class="">
								 <img alt="Logo" src="{{ asset('assets/media/logos/logo_dark.webp') }}"
                				    class="h-50px theme-light-show" />
                				<img alt="Logo" src="{{ asset('assets/media/logos/logo_dark.webp') }}"
                				    class="h-50px theme-dark-show" />
							</a>
						</div>
						<!--end::Logo-->
						<!--begin::Title-->
						<h1 class="fw-bolder text-gray-900 mb-7">{{ __('general.comming_soon') }}</h1>
						<!--end::Title-->
						<!--begin::Text-->
						<div class="fw-semibold fs-4 text-gray-700 mb-7">{{ __('general.this_page_will_be_available_soon') }}
							<br />{{ __('general.if_you_need_more_information_please_contact_support') }}
						</div>
						<!--end::Text-->
					</div>
				</div>
				<!--end::Wrapper-->
			</div>
			<!--end::Content-->
		</div>
		<!--end::Authentication - Signup Welcome Message-->
	</div>
	<!--end::Root-->
	<!--begin::Javascript-->
	@include('assets._main_scripts')
	<!--end::Javascript-->
</body>
<!--end::Body-->

</html>