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
                        <h1 class="mb-0">{{ __('general.reminder_details') }}</h1>
                    </div>
                    <!--end::Title-->
                    <!--begin::Row-->
	            	<div class="d-flex flex-column gap-1">
                        <div class="row">
                            <div class="col">
                                <div class="fw-bold text-muted">{{ __('general.subject') }}</div>
	            		        <div class="fw-bold fs-5">{{$reminder->subject}}</div>
                            </div>
                            <div class="col">
                                <div class="fw-bold text-muted">{{ __('general.date') }}</div>
	            		        <div class="fw-bold fs-5">{{$reminder->date}}</div>
                            </div>
                        </div>
	            	</div>
	            	<!--end::Row-->
                    <!--begin::Row-->
	            	<div class="d-flex flex-column gap-1">
                        <div class="row">
                            <div class="col">
                                <div class="fw-bold text-muted">{{ __('general.remind_before') }}</div>
                                @php
                                    $value = $reminder->remind_before;
                                    if ($value >= 1440) {
                                        $remind_before_value = floor($value / 1440) . ' ' . __('general.days');
                                    } elseif ($value >= 60) {
                                        $remind_before_value = floor($value / 60) . ' ' . __('general.hours');
                                    } else {
                                        $remind_before_value = $value . ' ' . __('general.minutes');
                                    }
                                @endphp

	            		        <div class="fw-bold fs-5">{{$remind_before_value}}</div>
                            </div>
                            <div class="col">
                                <div class="fw-bold text-muted">{{ __('general.status') }}</div>
	            		        <div class="fw-bold fs-5">{{ __('general.' . $reminder->status) }}</div>
                            </div>
                        </div>
	            	</div>
	            	<!--end::Row-->
                    <!--begin::Row-->
	            	<div class="d-flex flex-column gap-1">
                        <div class="row">
                            <div class="col">
                                <div class="fw-bold text-muted">{{ __('general.priority') }}</div>
	            		        <div class="fw-bold fs-5">{{$reminder->priority}}</div>
                            </div>
                            <div class="col">
                                <div class="fw-bold text-muted">{{ __('general.remind_at_event') }}</div>
	            		        <div class="fw-bold fs-5">{{$reminder->remind_at_event ?  __('general.yes')  :  __('general.no') ;}}</div>
                            </div>
                        </div>
	            	</div>
	            	<!--end::Row-->
                     <!--begin::Row-->
	            	<div class="d-flex flex-column gap-1">
                        <div class="row">
                            <div class="col">
                                <div class="fw-bold text-muted">{{ __('general.before_reminded') }}</div>
	            		        <div class="fw-bold fs-5">{{$reminder->event_reminded ?  __('general.yes')  :  __('general.no') ;}}</div>
                            </div>
                            <div class="col">
                                <div class="fw-bold text-muted">{{ __('general.event_reminded') }}</div>
	            		        <div class="fw-bold fs-5">{{$reminder->event_reminded ?  __('general.yes')  :  __('general.no') ;}}</div>
                            </div>
                        </div>
	            	</div>
	            	<!--end::Row-->
                    <!--begin::Row-->
	            	<div class="d-flex flex-column gap-1">
                        <div class="row">
                            <div class="col">
                                <div class="fw-bold text-muted">{{ __('general.created_by') }}</div>
	            		        <div class="fw-bold fs-5">{{__getUserNameById($reminder->created_by)}}</div>
                            </div>
                            <div class="col">
                                <div class="fw-bold text-muted">{{ __('general.created_at') }}</div>
	            		        <div class="fw-bold fs-5">{{$reminder->created_at}}</div>
                            </div>
                        </div>
	            	</div>
	            	<!--end::Row-->
                    @php
                        $model = app($reminder->referable_type)::find($reminder->referable_id);
                        $modelName = class_basename($reminder->referable_type);
                    @endphp
                    <!--begin::Row-->
	            	<div class="d-flex flex-column gap-1">
                        <div class="row">
                            <div class="col">
                                <div class="fw-bold text-muted">{{ __('general.related_to') }}</div>
	            		        <div class="fw-bold fs-5">{{ $modelName }}</div>
                            </div>
                            <div class="col">
                                <div class="fw-bold text-muted">{{ __('general.related_to') }}</div>
                                @if($model)
	            		            <div class="fw-bold fs-5">{{ $model->subject ?? $model->name ?? $model->title ?? '—' }}</div>
                                @else
                                    <div class="fw-bold fs-5 text-danger">{{ __('general.model_not_found') }}</div>
                                @endif
                            </div>
                        </div>
	            	</div>
	            	<!--end::Row-->
                    <!--begin::Row-->
	            	<div class="d-flex flex-column gap-1">
                        <div class="row">
                            @if($reminder->members)
                                <div class="col">
                                    <div class="fw-bold text-muted">{{ __('general.members') }}</div>
	            	                <div class="fw-bold fs-5">
                                        {{__getUsersNamesByIds($reminder->members)}}
                                    </div>
                                </div>
                            @endif
                        </div>
	            	</div>
	            	<!--end::Row-->
	            </div>
	            <!--end::Additional details-->
            </div>
        </div>
    </div>
</div>