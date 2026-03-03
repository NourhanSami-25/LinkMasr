<div class="modal fade" id="{{ $modalId }}" tabindex="-1" aria-hidden="true">
	<!--begin::Modal dialog-->
	<div class="modal-dialog modal-dialog-centered mw-650px">
		<!--begin::Modal content-->
		<div class="modal-content rounded">
			<!--begin::Modal header-->
			<div class="modal-header pb-0 border-0 justify-content-end">
				<!--begin::Close-->
				<div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
					<i class="ki-outline ki-cross fs-1"></i>
				</div>
				<!--end::Close-->
			</div>
			<!--begin::Modal header-->
			<!--begin::Modal body-->
			<div class="modal-body scroll-y px-10 px-lg-15 pt-0 pb-15">
				<!--begin:Form-->
				<form action="{{ route('billing-addresses.update' , $address->id) }}" method="POST" id="kt_modal_new_target_form" class="form" enctype="multipart/form-data">
					@csrf
                    @method('PUT')
                    <!--begin::Heading-->
					<div class="mb-5 text-center">
						<!--begin::Title-->
						<h1 class="mb-3">{{ __('general.update_billing_address') }}</h1>
						<!--end::Title-->
					</div>
					<!--end::Heading-->

                    <!--begin::Input group-->
					<div class="row g-9 mt-5 mb-8">
                        <!--begin::Col-->
						<div class="col-md-6 fv-row">
							<label class="required fs-6 fw-semibold mb-2">{{ __('general.bank_name') }}</label>
							<!--begin::Input-->
							<div class="position-relative d-flex align-items-center">
								<!--begin::Icon-->
								<i class="ki-outline fs-2 position-absolute mx-4"></i>
								<!--end::Icon-->
								<!--begin::input-->
						        <input class="form-control" placeholder="{{ __('general.enter_bank_name') }}" name="bank_name" value="{{$address->bank_name}}" data-type="text" data-minlength="3" data-maxlength="255" data-required="true"/>
						        <input class="form-control" name="client_id" value="{{$address->client_id}}" hidden/>
								<!--end::input-->
							</div>
							<!--end::Input-->
						</div>
						<!--end::Col-->
                        <!--begin::Col-->
						<div class="col-md-6 fv-row">
							<label class="fs-6 fw-semibold mb-2">{{ __('general.bank_address') }}</label>
							<!--begin::Input-->
							<div class="position-relative d-flex align-items-center">
								<!--begin::Icon-->
								<i class="ki-outline fs-2 position-absolute mx-4"></i>
								<!--end::Icon-->
								<!--begin::input-->
						        <input type="text" class="form-control" placeholder="{{ __('general.enter_bank_address') }}" name="address" value="{{$address->address}}" />
								<!--end::input-->
							</div>
							<!--end::Input-->
						</div>
						<!--end::Col-->
					</div>
					<!--end::Input group-->

                    <!--begin::Input group-->
					<div class="row g-9 mb-8"> 
						<!--begin::Col-->
						<div class="col-md-12 fv-row">	
                            <label class="fs-6 fw-semibold mb-2">{{__('general.status')}}</label>
							<select class="form-select" data-control="select2"
								data-hide-search="true" data-placeholder="{{ __('general.select_an_option') }}"
								name="status">
								<option value="active" selected="selected">{{__('general.active')}}</option>
								<option value="expired">{{__('general.expired')}}</option>
							</select>
						</div>
                        <!--end::Col-->
					</div>
					<!--end::Input group-->

                    <!--begin::Input group-->
					<div class="row g-9 mb-8">
                        <!--begin::Col-->
						<div class="col-md-12 fv-row">
							<label class="fs-6 fw-semibold mb-2">{{ __('general.le_account') }}</label>
							<!--begin::Input-->
							<div class="position-relative d-flex align-items-center">
								<!--begin::Icon-->
								<i class="ki-outline fs-2 position-absolute mx-4"></i>
								<!--end::Icon-->
								<!--begin::input-->
						        <input class="form-control" placeholder="{{ __('general.enter_le_account_number') }}" name="le_account" value="{{$address->le_account}}"/>
								<!--end::input-->
							</div>
							<!--end::Input-->
						</div>
						<!--end::Col-->
					</div>
					<!--end::Input group-->
                    
                    <!--begin::Input group-->
					<div class="row g-9 mb-8">
                        <!--begin::Col-->
						<div class="col-md-6 fv-row">
							<label class="fs-6 fw-semibold mb-2">{{ __('general.le_iban') }}</label>
							<!--begin::Input-->
							<div class="position-relative d-flex align-items-center">
								<!--begin::Icon-->
								<i class="ki-outline fs-2 position-absolute mx-4"></i>
								<!--end::Icon-->
								<!--begin::input-->
						        <input class="form-control" placeholder="{{ __('general.enter_le_iban') }}" name="le_iban" value="{{$address->le_iban}}"/>
								<!--end::input-->
							</div>
							<!--end::Input-->
						</div>
						<!--end::Col-->
						 <!--begin::Col-->
						<div class="col-md-6 fv-row">
							<label class="fs-6 fw-semibold mb-2">{{ __('general.le_swift_code') }}</label>
							<!--begin::Input-->
							<div class="position-relative d-flex align-items-center">
								<!--begin::Icon-->
								<i class="ki-outline fs-2 position-absolute mx-4"></i>
								<!--end::Icon-->
								<!--begin::input-->
						        <input class="form-control" placeholder="{{ __('general.enter_le_swift_code') }}" name="le_swift_code" value="{{$address->le_swift_code}}"/>
								<!--end::input-->
							</div>
							<!--end::Input-->
						</div>
						<!--end::Col-->
					</div>
					<!--end::Input group-->
                    
                    <!--begin::Input group-->
					<div class="row g-9 mb-8">
                        <!--begin::Col-->
						<div class="col-md-12 fv-row">
							<label class="fs-6 fw-semibold mb-2">{{ __('general.us_account') }}</label>
							<!--begin::Input-->
							<div class="position-relative d-flex align-items-center">
								<!--begin::Icon-->
								<i class="ki-outline fs-2 position-absolute mx-4"></i>
								<!--end::Icon-->
								<!--begin::input-->
						        <input class="form-control" placeholder="{{ __('general.enter_us_account_number') }}" name="us_account" value="{{$address->us_account}}"/>
								<!--end::input-->
							</div>
							<!--end::Input-->
						</div>
						<!--end::Col-->
					</div>
					<!--end::Input group-->

                    <!--begin::Input group-->
					<div class="row g-9 mb-8">
                        <!--begin::Col-->
						<div class="col-md-6 fv-row">
							<label class="fs-6 fw-semibold mb-2">{{ __('general.us_iban') }}</label>
							<!--begin::Input-->
							<div class="position-relative d-flex align-items-center">
								<!--begin::Icon-->
								<i class="ki-outline fs-2 position-absolute mx-4"></i>
								<!--end::Icon-->
								<!--begin::input-->
						        <input class="form-control" placeholder="{{ __('general.enter_us_iban') }}" name="us_iban" value="{{$address->us_iban}}"/>
								<!--end::input-->
							</div>
							<!--end::Input-->
						</div>
						<!--end::Col-->
						 <!--begin::Col-->
						<div class="col-md-6 fv-row">
							<label class="fs-6 fw-semibold mb-2">{{ __('general.us_swift_code') }}</label>
							<!--begin::Input-->
							<div class="position-relative d-flex align-items-center">
								<!--begin::Icon-->
								<i class="ki-outline fs-2 position-absolute mx-4"></i>
								<!--end::Icon-->
								<!--begin::input-->
						        <input class="form-control" placeholder="{{ __('general.enter_us_swift_code') }}" name="us_swift_code" value="{{$address->us_swift_code}}"/>
								<!--end::input-->
							</div>
							<!--end::Input-->
						</div>
						<!--end::Col-->
					</div>
					<!--end::Input group-->
                   

					<!--begin::Actions-->
					<div class="text-center">
						
						<button type="submit" id="kt_modal_new_target_submit" class="btn btn-primary">
							<span class="indicator-label">{{ __('general.save') }}</span>
							<span class="indicator-progress">{{ __('general.please_wait') }}
								<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
						</button>
					</div>
					<!--end::Actions-->
                    
				</form>
				<!--end:Form-->
			</div>
			<!--end::Modal body-->
		</div>
		<!--end::Modal content-->
	</div>
	<!--end::Modal dialog-->
</div>

