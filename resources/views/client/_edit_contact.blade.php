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
				<form action="{{ route('client-contacts.update' , $contact->id) }}" method="POST" id="kt_modal_new_target_form" class="form" enctype="multipart/form-data">
					@csrf
                    @method('PUT')

                    <!--begin::Heading-->
					<div class="mb-5 text-center">
						<!--begin::Title-->
						<h1 class="mb-3">{{ __('general.edit_client_contact') }}</h1>
						<!--end::Title-->
					</div>
					<!--end::Heading-->

                    <!--begin::Input group-->
					<div class="row g-9 mt-5 mb-8">
                        <!--begin::Col-->
						<div class="col-md-6 fv-row">
							<label class="required fs-6 fw-semibold mb-2">{{ __('general.name') }}</label>
							<!--begin::Input-->
							<div class="position-relative d-flex align-items-center">
								<!--begin::Icon-->
								<i class="ki-outline fs-2 position-absolute mx-4"></i>
								<!--end::Icon-->
								<!--begin::input-->
						        <input class="form-control" name="name" value="{{$contact->name}}" data-minlength="3" data-maxlength="255" data-required="true"/>
						        <input class="form-control" name="client_id" value="{{$contact->client_id}}" hidden/>
								<!--end::input-->
							</div>
							<!--end::Input-->
						</div>
						<!--end::Col-->
                        <!--begin::Col-->
						<div class="col-md-6 fv-row">
							<label class="fs-6 fw-semibold mb-2">{{ __('general.phone') }}</label>
							<!--begin::Input-->
							<div class="position-relative d-flex align-items-center">
								<!--begin::Icon-->
								<i class="ki-outline fs-2 position-absolute mx-4"></i>
								<!--end::Icon-->
								<!--begin::input-->
						        <input type="text" class="form-control" name="phone" value="{{$contact->phone}}"/>
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
							<label class="required fs-6 fw-semibold mb-2">{{ __('general.email') }}</label>
							<!--begin::Input-->
							<div class="position-relative d-flex align-items-center">
								<!--begin::Icon-->
								<i class="ki-outline fs-2 position-absolute mx-4"></i>
								<!--end::Icon-->
								<!--begin::input-->
						        <input class="form-control" name="email" value="{{$contact->email}}" data-minlength="3" data-maxlength="255" data-type="email" data-required="true"/>
								<!--end::input-->
							</div>
							<!--end::Input-->
						</div>
						<!--end::Col-->
                        <!--begin::Col-->
						<div class="col-md-6 fv-row">
							<label class="fs-6 fw-semibold mb-2">{{ __('general.position') }}</label>
							<!--begin::Input-->
							<div class="position-relative d-flex align-items-center">
								<!--begin::Icon-->
								<i class="ki-outline fs-2 position-absolute mx-4"></i>
								<!--end::Icon-->
								<!--begin::input-->
						        <input type="text" class="form-control" name="position" value="{{$contact->position}}"/>
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
                            <label class="fs-6 fw-semibold mb-2">{{__('general.is_primary')}}</label>
							<select class="form-select" data-control="select2"
								data-hide-search="true" data-placeholder="{{ __('general.select_an_option') }}"
								name="is_primary">
								<option></option>
								<option value="0" {{ $contact->is_primary === 1 ? 'selected' : '' }}>{{ __('general.yes') }}</option>
								<option value="1" {{ $contact->is_primary === 0 ? 'selected' : '' }}>{{ __('general.no') }}</option>
							</select>
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
								<option></option>
								<option value="active" {{ $contact->status === 'active' ? 'selected' : '' }}>{{ __('general.active') }}</option>
								<option value="disabled" {{ $contact->status === 'disabled' ? 'selected' : '' }}>{{ __('general.disabled') }}</option>
							</select>
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

