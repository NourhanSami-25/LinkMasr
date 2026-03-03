<div class="modal fade" id="{{ $modalId }}" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
	<div class="modal-dialog modal-dialog-centered mw-950px">
		<!--begin::Modal content-->
		<div class="modal-content rounded">
			<!--begin::Modal body-->


            <!--begin::Modal body-->
				<div class="modal-body mt-10 pt-10 pb-15 px-5 px-xl-20">
					<!--begin::Heading-->
					<div class="mb-13 text-center">
						<h1 class="mb-3">{{ __('general.request_details') }} - {{class_basename($request)}}</h1>
						<div class="text-muted fw-semibold fs-5">{{ __('general.for_more_info') }}
							<a href="#" class="link-primary fw-bold">{{ __('general.user_guide') }}</a>.
						</div>
					</div>
					<!--end::Heading-->
					<!--begin::Plans-->
					<div class="d-flex flex-column">
						<!--begin::Row-->
						<div class="row mt-2">
							<!--begin::Col-->
							<div class="col-lg-6">
								<!--begin::Tab content-->
								<div class="tab-content rounded h-100 bg-light p-10">
									<!--begin::Tab Pane-->
									<div class="tab-pane fade show active" id="kt_upgrade_plan_startup">
                                        <!--begin::input group-->
										<div class="pb-5">
                                            <div class="text-muted fw-semibold fs-3">{{ __('general.username') }}</div>
											<h2 class="fw-bold text-gray-900">{{$request->user->name}}</h2>
										</div>
										<!--end::input group-->
                                        <!--begin::input group-->
										<div class="pb-5">
                                            <div class="text-muted fw-semibold fs-3">{{ __('general.subject') }}</div>
											<h2 class="fw-bold text-gray-900">{{$request->subject}}</h2>
										</div>
										<!--end::input group-->
                                        @if($request->vacation_type)
                                        <!--begin::input group-->
										<div class="pb-5">
                                            <div class="text-muted fw-semibold fs-3">{{ __('general.vacation_type') }}</div>
											<h2 class="fw-bold text-gray-900">{{$request->vacation_type}}</h2>
										</div>
										<!--end::input group-->
                                        @endif
                                        @if($request->amount)
                                        <!--begin::input group-->
										<div class="pb-5">
                                            <div class="text-muted fw-semibold fs-3">{{ __('general.amount') }}</div>
											<h2 class="fw-bold text-gray-900">{{$request->amount}}</h2>
										</div>
										<!--end::input group-->
                                        @endif
                                        <!--begin::input group-->
										<div class="pb-5">
                                            <div class="text-muted fw-semibold fs-3">{{ __('general.status') }}</div>
											<h2 class="fw-bold text-gray-900">{{ __('general.' . $request->status) }}</h2>
										</div>
										<!--end::input group-->
                                        <!--begin::input group-->
										<div class="pb-5">
                                            <div class="text-muted fw-semibold fs-3">{{ __('general.approver') }}</div>
											<h2 class="fw-bold text-gray-900">{{$request->approver}}</h2>
										</div>
										<!--end::input group-->
                                        <!--begin::input group-->
										<div class="pb-5">
                                            <div class="text-muted fw-semibold fs-3">{{ __('general.description') }}</div>
											<h2 class="fw-bold text-gray-900">{{$request->description}}</h2>
										</div>
										<!--end::input group-->
									</div>
									<!--end::Tab Pane-->
								</div>
								<!--end::Tab content-->
							</div>
							<!--end::Col-->
                            <!--begin::Col-->
							<div class="col-lg-6">
								<!--begin::Tab content-->
								<div class="tab-content rounded h-100 bg-light p-10">
									<!--begin::Tab Pane-->
									<div class="tab-pane fade show active" id="kt_upgrade_plan_startup">
                                        <!--begin::input group-->
										<div class="pb-5">
                                            <div class="text-muted fw-semibold fs-3">{{ __('general.start_date') }}</div>
											<h2 class="fw-bold text-gray-900">{{$request->start_date}}</h2>
										</div>
										<!--end::input group-->
                                        <!--begin::input group-->
										<div class="pb-5">
                                            <div class="text-muted fw-semibold fs-3">{{ __('general.due_date') }}</div>
											<h2 class="fw-bold text-gray-900">{{$request->due_date}}</h2>
										</div>
										<!--end::input group-->
                                        <!--begin::input group-->
										<div class="pb-5">
                                            <div class="text-muted fw-semibold fs-3">{{ __('general.created_at') }}</div>
											<h2 class="fw-bold text-gray-900">{{$request->created_at}}</h2>
										</div>
										<!--end::input group-->
                                        <!--begin::input group-->
										<div class="pb-5">
                                            <div class="text-muted fw-semibold fs-3">{{ __('general.followers') }}</div>
											<h2 class="fw-bold text-gray-900">{{__getUsersNamesByIds($request->follower)}}</h2>
										</div>
										<!--end::input group-->
                                        <!--begin::input group-->
										<div class="pb-5">
                                            <div class="text-muted fw-semibold fs-3">{{ __('general.handovers') }}</div>
											<h2 class="fw-bold text-gray-900">{{__getUsersNamesByIds($request->handover)}}</h2>
										</div>
										<!--end::input group-->
                                        
									</div>
									<!--end::Tab Pane-->
								</div>
								<!--end::Tab content-->
							</div>
							<!--end::Col-->
						</div>
						<!--end::Row-->
					</div>
					<!--end::Plans-->
					{{-- <!--begin::Actions-->
					<div class="d-flex flex-center flex-row-fluid gap-5 pt-12">
							<!--begin::Indicator label-->
							<button class="btn btn-primary" style="width: 150px;"><i class="fa-solid fa-check"></i>{{ __('general.approve') }}</button>
                            <button class="btn btn-danger" style="width: 150px;"><i class="fa-solid fa-ban"></i>{{ __('general.reject') }}</button>
							@if($request->user_id == auth()->id())
                            	<button class="btn btn-warning" style="width: 150px;"><i class="fa-solid fa-x"></i>{{ __('general.cancel') }}</button>
							@endif
                            <button class="btn btn-success" style="width: 150px;"><i class="fa-solid fa-print"></i>{{ __('general.print') }}</button>
							<!--end::Indicator label-->
							<!--begin::Indicator progress-->
							<span class="indicator-progress">{{ __('general.please_wait') }}
								<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
							<!--end::Indicator progress-->
						</button>
					</div>
					<!--end::Actions--> --}}
				</div>
				<!--end::Modal body-->
        </div>
    </div>
</div>