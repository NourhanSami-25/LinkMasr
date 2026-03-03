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
				<form action="{{ route('convert_paymentRequest_to_pyment' , $paymentRequest->id) }}" method="GET" id="kt_modal_new_target_form" class="form" enctype="multipart/form-data">
					@csrf
                    <!--begin::Heading-->
					<div class="mb-13 text-center">
						<!--begin::Title-->
						<h1 class="mb-3">{{ __('general.create_payment') }}</h1>
						<!--end::Title-->
					</div>
					<!--end::Heading-->
                    
                    <!--begin::Input group - Hidden-->	
                    <input class="form-control form-control-solid"  type="number" name="model_id" value="{{$paymentRequest->id}}" hidden/>
                    <input class="form-control form-control-solid"  type="text" name="model_type" value="{{ get_class($paymentRequest) }}" hidden/>
                    <!--end::Input group - Hidden-->

                    <!--begin::Input group-->
					<div class="d-flex flex-column mb-8">
						<label class="fs-6 fw-semibold mb-2 fs-3">{{ __('general.Payment_total') }}</label>
						<input class="form-control form-control-solid fs-2" type="decimal" name="total" value="{{ $paymentRequest->total }}" data-required="true"/>
					</div>
					<!--end::Input group-->
                    
					<!--begin::Input group-->
					<div class="d-flex flex-column mb-8">
						<label class="fs-6 fw-semibold mb-2 fs-3">{{ __('general.notes') }}</label>
						<textarea class="form-control form-control-solid fs-4" rows="3" name="notes" data-label="{{ __('general.notes') }}" data-required="true"></textarea>
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