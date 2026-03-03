<div class="modal fade" id="{{ $modalId }}" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
	<div class="modal-dialog modal-dialog-centered mw-950px">
		<!--begin::Modal content-->
		<div class="modal-content rounded">

			<!--begin::Modal body-->
			<div class="modal-body scroll-y px-10 px-lg-15 pt-0 pb-15">
                <!--begin::Additional details-->
	            <div class="d-flex flex-column gap-5 mt-7">
                    <!--begin::Title-->
                    <div class="mt-5 mb-5">
                        <h1 class="mb-0">{{ __('general.todoItem_details') }}</h1>
                    </div>
                    <!--end::Title-->
                    <!--begin::Row-->
	            	<div class="d-flex flex-column gap-1">
                        <div class="row">
                            <div class="col">
                                <div class="fw-bold text-muted">{{ __('general.todo_list_subject') }}</div>
	            		        <div class="fw-bold fs-5">{{$todoItem->todo->subject}}</div>
                            </div>
                            <div class="col">
                                <div class="fw-bold text-muted">{{ __('general.date') }}</div>
	            		        <div class="fw-bold fs-5">{{$todoItem->date}}</div>
                            </div>
                        </div>
	            	</div>
	            	<!--end::Row-->
                    <!--begin::Row-->
	            	<div class="d-flex flex-column gap-1">
                        <div class="row">
                            <div class="col">
                                <div class="fw-bold text-muted">{{ __('general.subject') }}</div>
	            		        <div class="fw-bold fs-5">{{$todoItem->subject}}</div>
                            </div>
                        </div>
	            	</div>
	            	<!--end::Row-->
                    <!--begin::Row-->
	            	<div class="d-flex flex-column gap-1">
                        <div class="row">
                            <div class="col">
                                <div class="fw-bold text-muted">{{ __('general.date') }}</div>
	            		        <div class="fw-bold fs-5">{{$todoItem->date}}</div>
                            </div>
                            <div class="col">
                                <div class="fw-bold text-muted">{{ __('general.status') }}</div>
	            		        <div class="fw-bold fs-5">{{ __('general.' . $todoItem->status) }}</div>
                            </div>
                        </div>
	            	</div>
	            	<!--end::Row-->
                    <!--begin::Row-->
	            	<div class="d-flex flex-column gap-1">
                        <div class="row">
                            <div class="col">
                                <div class="fw-bold text-muted">{{ __('general.created_by') }}</div>
	            		        <div class="fw-bold fs-5">{{__getUserNameById($todoItem->todo->user_id)}}</div>
                            </div>
                            <div class="col">
                                <div class="fw-bold text-muted">{{ __('general.created_at') }}</div>
	            		        <div class="fw-bold fs-5">{{$todoItem->created_at}}</div>
                            </div>
                        </div>
	            	</div>
	            	<!--end::Row-->
	            </div>
	            <!--end::Additional details-->
            </div>
        </div>
    </div>
</div>