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
                <form action="{{ route('files.update' , $file->id) }}" method="POST" id="kt_modal_new_target_form" class="form" enctype="multipart/form-data">
                    @csrf
                    <!--begin::Heading-->
                    <div class="mb-13 text-center">
                        <!--begin::Title-->
                        <h1 class="mb-3">{{ __('general.update_existing_file') }}</h1>
                        <!--end::Title-->
                    </div>
                    <!--end::Heading-->

                    <!--begin::Input group-->
                    <div class="d-flex flex-column mb-8">
                        <label class="fs-6 fw-semibold mb-2">{{ __('general.name') }}</label>
                        <input class="form-control form-control-solid" type="text" name="name" value="{{ $file->name }}" data-required="true"/>
                    </div>
                    <!--end::Input group-->

                    <!--begin::Input group-->
                    <div class="d-flex flex-column mb-8">
                        <label class="fs-6 fw-semibold mb-2">{{ __('general.description') }}</label>
                        <textarea class="form-control form-control-solid" rows="3" name="description" data-required="true">{{ $file->description }}</textarea>
                    </div>
                    <!--end::Input group-->
                     <!--begin::Input group-->
					<div class="d-flex flex-column mb-8">
					<label class="fs-6 fw-semibold mb-2">{{ __('general.upload_file') }}</label>
                       <div class="input-group">
                            <span class="input-group-text bg-primary text-white"></span>
                            <input type="file" name="file" class="form-control" accept=".ico,.png,.jpg,.jpeg,.svg,.jpf,.pdf,.doc,.docx,.xls,.xlsx,.zip,.rar,.txt,.psd,.mp3,.mp4,.ogg,.opus,.7z,.gif,.eps,.ppt,.pptx,.ai,.html,.php">
                        </div>
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