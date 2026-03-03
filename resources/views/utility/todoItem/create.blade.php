<div class="modal fade" id="kt_modal_new_target_create_todoItem" tabindex="-1" aria-hidden="true">
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
				<form action="{{ route('todoItems.store') }}" method="POST" id="kt_modal_new_target_form" class="form" enctype="multipart/form-data">
					@csrf
					
                    <!--begin::Heading-->
					<div class="mb-5 text-center">
						<!--begin::Title-->
						<h1 class="mb-3">{{ __('general.create_new_todoItem') }}</h1>
						<!--end::Title-->
					</div>
					<!--end::Heading-->

                    <!--begin::Input group-->
					<div class="row g-9 mb-8">
                        <!--begin::Col-->
						<div class="col-md-12 fv-row">
						    <!--begin::Label-->
						    <label class="required d-flex align-items-center fs-6 fw-semibold mb-2">
						    	<span class="">{{ __('general.todo_list') }}</span>
						    </label>
						    <!--end::Label-->
						    <input type="text" class="form-control" name="todo" value="{{$todo->subject}}" data-required="true" readonly/>
						    <input type="text" class="form-control" name="todo_id" value="{{$todo->id}}" data-required="true" hidden/>
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
								<input name="date" value="{{ date('Y-m-d H:i') }}"  placeholder="{{ __('general.select_a_date') }}" class="flatpickr-date form-control mb-2" data-type="dateTime" data-required="true"/>
								<!--end::Datepicker-->
							</div>
							<!--end::Input-->
						</div>
						<!--end::Col-->
						<!--begin::Col-->
						<div class="col-md-6 fv-row">	
                            <label class="required fs-6 fw-semibold mb-2">{{__('general.status')}}</label>
							<select class="form-select" data-control="select2"
								data-hide-search="true" name="status" data-required="true">
								<option value="pending" selected="selected">{{__('general.pending')}}</option>
								<option value="completed">{{__('general.completed')}}</option>
							</select>
						</div>
                        <!--end::Col-->
					</div>
					<!--end::Input group-->
                    
					<!--begin::Input group-->
					<div class="row g-9 mb-8">
                        <!--begin::Col-->
						<div class="col-md-12 fv-row">
						    <!--begin::Label-->
						    <label class="required d-flex align-items-center fs-6 fw-semibold mb-2">
						    	<span class="">{{ __('general.subject') }}</span>
						    </label>
						    <!--end::Label-->
						    <textarea type="text" class="form-control" name="subject" data-required="true"></textarea>
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