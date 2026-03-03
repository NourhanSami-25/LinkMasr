<div class="modal fade" id="kt_modal_new_target_reminder_popup" tabindex="-1" aria-hidden="true">
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
            <div class="modal-body scroll-y px-10 px-lg-15 pt-0 pb-15 d-flex flex-column justify-content-center align-items-center">
                <!--begin::Logo-->
                <div class="mb-7">
                    <a href="/metronic8/demo39/index.html" class="">
                        <img alt="Timer" src="{{ asset('assets/media/icon/timer.png') }}" class="h-70px"> 
                    </a> 
                </div>
                <!--end::Logo-->

                <!--begin::Title-->
                <h3 class="fw-regular text-gray-500 fs-6 mb-2">{{ __('general.reminder_is_now') }}</h3>
                <h1 class="fw-bolder text-gray-900 mb-5">ReminderTitleHere</h1>
                <!--end::Title--> 
                
                <!--begin::Text-->
                <div class="fw-bolder fs-6 text-gray-900 mb-7 text-center">
                  <h1 class="fw-bold text-gray-900 mb-5" style="font-size: 3rem;">2025-01-09 14:25:00</h1>
                </div>
                <!--end::Text--> 
            
                <!--begin::Link-->
                <div class="row">
                    <div class="col"><a href="{{route('reminders.index')}}" class="btn btn-sm btn-primary">{{ __('general.go_to_reminders') }}</a></div>
                    <div class="col"><a href="#" class="btn btn-sm btn-primary">{{ __('general.mark_as_completed') }}</a></div>
                </div>    
                <!--end::Link-->
			</div>
			<!--end::Modal body-->
		</div>
		<!--end::Modal content-->
	</div>
	<!--end::Modal dialog-->
</div>