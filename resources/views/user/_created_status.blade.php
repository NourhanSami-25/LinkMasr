<!DOCTYPE html>

@if (app()->getLocale() == 'ar')
	@include('assets._language_ar')
@else
	@include('assets._language_en')
@endif

<head>

	<title>Link Masr | User Data</title>
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

<body id="kt_body" class="app-blank bgi-size-cover bgi-position-center bgi-no-repeat">
	@include('assets.dark_mode')
	<!--begin::Root-->
	<div class="d-flex flex-column flex-root" id="kt_app_root">
		<!--begin::Page bg image-->
		<style>
        	body {
        		background-image: url('{{ asset('assets/media/auth/bg4.jpg') }}');
        	}
        
        	[data-bs-theme="dark"] body {
        		background-image: url('{{ asset('assets/media/auth/bg1-dark.jpg') }}');
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
						<!--begin::Title-->
						<h1 class="fw-bolder fs-2hx text-gray-900 mb-4">User Created Successfully</h1>
						<!--end::Title-->
						<!--begin::Text-->
						<div class="fw-semibold fs-3 text-gray-800 mb-7">
                            <p>Name: <strong>{{ $data['name'] }}</strong></p>
                            <p>Email: <strong>{{ $data['email'] }}</strong></p>
                            <p>Password: <strong>{{ $data['password'] }}</strong></p>
                        </div>
						<!--end::Text-->
						<!--begin::Illustration-->
						<div class="mb-3">
							<img src="{{ asset('assets/media/auth/ok.png') }}"
								class="mw-100 mh-300px theme-light-show" alt="" />
							<img src="{{ asset('assets/media/auth/ok-dark.png') }}"
								class="mw-100 mh-300px theme-dark-show" alt="" />
						</div>
						<!--end::Illustration-->
						<!--begin::Link-->
						<div class="mb-0">
							<a href="{{route('users.index')}}" class="btn btn-sm btn-primary">{{__('general.back')}}</a>
						</div>
						<!--end::Link-->
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