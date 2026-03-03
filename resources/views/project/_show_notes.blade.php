<div class="tab-pane fade" id="kt_project_view_notes" role="tabpanel">
	
	<div class="d-flex flex-wrap flex-stack my-5">
		<h3 class="fw-bold my-2">{{__('general.project_notes')}}
		</h3>
		<div class="d-flex justify-content-end align-items-center gap-2 gap-lg-3">
	    	<a href="#" class="btn btn-primary ps-7" data-bs-toggle="modal" data-bs-target="#kt_modal_new_target_create_note">{{ __('general.create_note') }}</a>
		</div>
	</div>
	<div class="row gx-9 gy-6">
		@foreach($notes as $note)
        <!--begin::Col-->
        <div class="col-xl-6" data-kt-billing-element="card">
            <!--begin::Card-->
            <div class="card card-dashed h-xl-100 flex-row flex-stack flex-wrap p-6">
                <!--begin::Info-->
                <div class="d-flex flex-column py-2">
                    <!--begin::Owner-->
                    <div class="d-flex align-items-center fs-4 fw-bold mb-5">
                        <span class="badge badge-light-primary fs-7 ms-2"> {{__getUserNameById($note->created_by)}}</span>
                    </div>
                    <!--end::Owner-->
                    <!--begin::Wrapper-->
                    <div class="d-flex align-items-center">
                        <!--begin::Icon-->
                        <img src="/metronic8/demo39/assets/media/svg/card-logos/visa.svg" alt="" class="me-4">
                        <!--end::Icon-->
                        <!--begin::Details-->
                        <div>
                            <div class="fs-4 fw-bold">{{ $note->content }}</div>
                            <div class="fs-6 fw-semibold text-gray-500">{{ $note->created_at }}</div>
                        </div>
                        <!--end::Details-->
                    </div>
                    <!--end::Wrapper-->
                </div>
                <!--end::Info-->
                @hasAccess('project', 'details')
                <!--begin::Actions-->
                <div class="d-flex align-items-center py-2">
					<form id="delete-form-{{ $note->id }}" action="{{ route('notes.destroy', $note->id) }}" method="POST" class="d-inline">
    					@csrf
    					@method('DELETE')
						<button type="button" class="btn btn-sm btn-light btn-active-light-danger me-3" onclick="showConfirmation('{{ addslashes($note->name) }}', '{{ $note->id }}');" title="{{ __('general.delete') }}"><span class="indicator-label">Delete</span></button>
					</form>
                </div>
                <!--end::Actions-->
                @endhasAccess
            </div>
            <!--end::Card-->
        </div>
        <!--end::Col-->
		@endforeach
    </div>
</div>

@include('common.note.create_note', ['item' => $project])
