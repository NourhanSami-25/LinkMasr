<div class="modal fade" id="{{ $modalId }}" tabindex="-1" aria-hidden="true">
	<!--begin::Modal dialog-->
	<div class="modal-dialog modal-dialog-centered mw-800px">
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
				<form action="{{ route('reminders.update' , $reminder->id) }}" method="POST" id="kt_modal_new_target_form" class="form" enctype="multipart/form-data">
					@csrf
                    @method('PUT')

					<input class="form-control form-control-solid"  type="number" name="referable_id" value="{{$reminder->referable_id}}" hidden/>
                    <input class="form-control form-control-solid"  type="text" name="referable_type" value="{{$reminder->referable_type}}" hidden/>

                    <!--begin::Heading-->
					<div class="mb-5 text-center">
						<!--begin::Title-->
						<h1 class="mb-3">{{ __('general.update_reminder') }}</h1>
						<!--end::Title-->
					</div>
					<!--end::Heading-->

                    <!--begin::Input group-->
					<div class="row g-9 mb-8">
                        <!--begin::Col-->
						<div class="col-md-6 fv-row">
						    <!--begin::Label-->
						    <label class="required d-flex align-items-center fs-6 fw-semibold mb-2">
						    	<span class="">{{ __('general.subject') }}</span>
						    </label>
						    <!--end::Label-->
						    <input type="text" class="form-control" name="subject" value="{{$reminder->subject}}" data-required="true"/>
						</div>
						<!--end::Col-->
						 <!--begin::Col-->
						<div class="col-md-6 fv-row">
                            <label class="required fs-6 fw-semibold mb-2">{{__('general.status')}}</label>
							<select class="form-select" data-control="select2"
                                data-hide-search="true" name="status" data-required="true">
                                <option></option>
                                <option value="pending" {{ $reminder->status === 'pending' ? 'selected' : '' }}>{{ __('general.pending') }}</option>
                                <option value="passed" {{ $reminder->status === 'passed' ? 'selected' : '' }}>{{ __('general.passed') }}</option>
                            </select>
						</div>
                        <!--end::Col-->
					</div>
					<!--end::Input group-->

                    <!--begin::Input group-->
					<div class="row g-9 mb-8">
                        <!--begin::Col-->
						<div class="col-md-6 fv-row">
							<label class="required fs-6 fw-semibold mb-2">{{ __('general.date') }}</label>
							<!--begin::Input-->
							<div class="position-relative d-flex align-items-center">
								<!--begin::Datepicker-->
								<input name="date" placeholder="{{ __('general.select_a_date') }}" class="flatpickr-date form-control mb-2" value="{{$reminder->date}}" data-type="dateTime" data-required="true"/>
								<!--end::Datepicker-->
							</div>
							<!--end::Input-->
						</div>
						<!--end::Col-->
						<!--begin::Col-->
						<div class="col-md-6 fv-row">
                            <label class="fs-6 fw-semibold mb-2">{{__('general.priority')}}</label>
							<select class="form-select" data-control="select2"
                                data-hide-search="true" data-placeholder="{{ __('general.select_an_option') }}"
                                name="priority">
                                <option></option>
                                <option value="normal" {{ $reminder->priority === 'normal' ? 'selected' : '' }}>{{ __('general.normal') }}</option>
                                <option value="important" {{ $reminder->priority === 'important' ? 'selected' : '' }}>{{ __('general.important') }}</option>
                                <option value="urgent" {{ $reminder->priority === 'urgent' ? 'selected' : '' }}>{{ __('general.urgent') }}</option>
                            </select>
						</div>
                        <!--end::Col-->
					</div>
					<!--end::Input group-->
                    <!--begin::Input group-->
					<div class="row g-9 mb-8">
                        <!--begin::Col-->
						<div class="col-md-6 fv-row">
							<label class="required fs-6 fw-semibold mb-2">{{ __('general.remind_before') }}</label>
							<!--begin::Input-->
							<div class="position-relative d-flex align-items-center">
								<!--begin::Icon-->
								<i class="ki-outline fs-2 position-absolute mx-4"></i>
								<!--end::Icon-->
								<!--begin::Datepicker-->
						        <input type="number" class="form-control" name="remind_before" value="{{$reminder->remind_before}}" data-type="number" min="0" data-required="true"/>
								<!--end::Datepicker-->
							</div>
							<!--end::Input-->
						</div>
						<!--end::Col-->
						<!--begin::Col-->
						<div class="col-md-6 fv-row">
                            <label class="required fs-6 fw-semibold mb-2">{{__('general.remind_at_event')}}</label>
							<select class="form-select" data-control="select2" data-hide-search="true" 
                                data-placeholder="Select an option" name="remind_at_event" data-required="true">
                                <option></option>
                                <option value="1" {{ $reminder->remind_at_event === 1 ? 'selected' : '' }}>{{__('general.yes')}}</option>
                                <option value="0" {{ $reminder->remind_at_event === 0 ? 'selected' : '' }}>{{__('general.no')}}</option>
                            </select>
						</div>
                        <!--end::Col-->
					</div>
					<!--end::Input group-->

                    <!--begin::Input group-->	
					<div class="d-flex flex-column mb-8 fv-row">
                        <label class="fs-6 fw-semibold mb-2">{{__('general.members')}}</label>
						<select class="form-select mb-2" name="members[]"
				    	    data-control="select2" data-hide-search="true"
				    	    data-placeholder="{{ __('general.select_an_option') }}" multiple="multiple">
				    	    <option></option>
				    	    @foreach($users as $user)
        		    	        <option value="{{ $user->id }}"
								    @if(in_array($user->id, json_decode($reminder->members ?? '[]', true)))
								        selected
								    @endif>
								    {{ $user->name }}
								</option>
        		    	    @endforeach
				        </select>
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