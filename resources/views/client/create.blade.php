@extends('layout.app')

@section('title', __('general.create_new_client'))

@section('breadcrumb')
    <li class="breadcrumb-item">
        <span class="bullet bg-gray-500 w-5px h-2px"></span>
    </li>
    <li class="breadcrumb-item text-muted">
        <a href="{{ route('clients.index')}}" class="text-muted text-hover-primary">{{ __('general.clients') }}</a>
    </li>
    <li class="breadcrumb-item">
        <span class="bullet bg-gray-500 w-5px h-2px"></span>
    </li>
    <li class="breadcrumb-item text-muted">{{ __('general.create') }}</li>
@endsection

@section('actions')
    <a href="javascript:history.back()" class="btn btn-flex btn-danger h-40px fs-7 fw-bold">{{ __('general.back') }}</a>
@endsection

@section('content')
    <!--begin::Form-->
    <form action="{{route('clients.store')}}" method="POST" enctype="multipart/form-data"
        class="form d-flex flex-column flex-lg-row">
        @csrf
        <!--begin::Aside column-->
        <div class="d-flex flex-column gap-7 gap-lg-10 w-100 w-lg-300px mb-7 me-lg-10">
            <!--begin::Thumbnail settings-->
            <div class="card card-flush py-4">
                <!--begin::Card header-->
                <div class="card-header">
                    <!--begin::Card title-->
                    <div class="card-title">
                        <h2>{{ __('general.profile_picture') }}</h2>
                    </div>
                    <!--end::Card title-->
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body text-center pt-0">
                    <!--begin::Image input-->
                    <style>
                        .avatar-company {
                            background-image: url("{{ asset('assets/media/avatars/company.png') }}") !important;
                        }

                        .avatar-person {
                            background-image: url("{{ asset('assets/media/avatars/client.png') }}") !important;
                        }

                        [data-bs-theme="dark"] .avatar-company {
                            background-image: url("{{ asset('assets/media/avatars/company-dark.png') }}") !important;
                        }

                        [data-bs-theme="dark"] .avatar-person {
                            background-image: url("{{ asset('assets/media/avatars/client-dark.png') }}") !important;
                        }
                    </style>
                    <div class="image-input image-input-empty image-input-outline image-input-placeholder mb-3 avatar-person"
                        data-kt-image-input="true" id="avatarBox">
                        <!--begin::Preview existing avatar-->
                        <div class="image-input-wrapper w-150px h-150px"></div>
                        <!--end::Preview existing avatar-->
                        <!--begin::Label-->
                        <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                            data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Change avatar">
                            <i class="ki-outline ki-pencil fs-7"></i>
                            <!--begin::Inputs-->
                            <input type="file" name="photo" data-label="{{ __('general.photo') }}"
                                accept=".png, .jpg, .jpeg" />
                            <input type="hidden" name="avatar_remove" />
                            <!--end::Inputs-->
                        </label>
                        <!--end::Label-->
                        <!--begin::Cancel-->
                        <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                            data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Cancel avatar">
                            <i class="ki-outline ki-cross fs-2"></i>
                        </span>
                        <!--end::Cancel-->
                        <!--begin::Remove-->
                        <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                            data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="Remove avatar">
                            <i class="ki-outline ki-cross fs-2"></i>
                        </span>
                        <!--end::Remove-->
                    </div>
                    <!--end::Image input-->
                    <!--begin::Description-->
                    <div class="text-muted fs-7">{{ __('general.profile_picture_info') }}</div>
                    <!--end::Description-->
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Thumbnail settings-->
            <!--begin::Status-->
            <div class="card card-flush py-4">
                <!--begin::Card header-->
                <div class="card-header">
                    <!--begin::Card title-->
                    <div class="card-title">
                        <h2>{{ __('general.status') }}</h2>
                    </div>
                    <!--end::Card title-->
                    <!--begin::Card toolbar-->
                    <div class="card-toolbar">
                        <div class="rounded-circle bg-success w-15px h-15px" id="kt_ecommerce_add_product_status"></div>
                    </div>
                    <!--begin::Card toolbar-->
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body pt-0">
                    <!--begin::Select2-->
                    <select class="form-select mb-2" data-control="select2" name="status"
                        data-label="{{ __('general.status') }}" data-hide-search="true"
                        data-placeholder="{{ __('general.select_an_option') }}" id="kt_ecommerce_add_product_status_select"
                        required>
                        <option value="active" selected="selected">{{ __('general.active') }}</option>
                        <option value="disabled">{{ __('general.disabled') }}</option>
                    </select>
                    <!--end::Select2-->
                    <!--begin::Description-->
                    <div class="text-muted fs-7">{{ __('general.status_info') }}</div>
                    <!--end::Description-->
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Status-->
        </div>
        <!--end::Aside column-->
        <!--begin::Main column-->
        <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
            <!--begin::Tab content-->
            <div class="tab-content">
                <!--begin::Tab pane-->
                <div class="tab-pane fade show active" role="tab-panel">
                    <div class="d-flex flex-column gap-7 gap-lg-10">
                        <!--begin::General options-->
                        <div class="card card-flush py-4">
                            <!--begin::Card header-->
                            <div class="card-header">
                                <div class="card-title">
                                    <h2>{{ __('general.please_fill_data') }}</h2>
                                </div>
                            </div>
                            <!--end::Card header-->
                            <!--begin::Card body-->
                            <div class="card-body pt-0">
                                <!--begin::Input group-->
                                <div class="fv-row w-100 flex-md-root">
                                    <!--begin::Label-->
                                    <label class="required form-label">{{ __('general.type') }}</label>
                                    <!--end::Label-->
                                    <!--begin::Select2-->
                                    <select class="form-select mb-2" name="type" data-label="{{ __('general.type') }}"
                                        data-control="select2" data-hide-search="true" id="clientTypeSelect"
                                        data-placeholder="{{ __('general.select_an_option') }}" data-required="true">
                                        <option value="person">{{ __('general.person') }}</option>
                                        <option value="company">{{ __('general.company') }}</option>
                                        <option value="government">{{ __('general.government') }}</option>
                                    </select>
                                    <!--end::Select2-->
                                </div>
                                <!--end::Input group-->
                                <!--begin::Input Row-->
                                <div class="d-flex flex-wrap gap-5 mb-5">
                                    <!--begin::Input group-->
                                    <div class="fv-row w-100 flex-md-root">
                                        <!--begin::Label-->
                                        <label class="required form-label">{{ __('general.name') }}</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input type="text" name="name" data-label="{{ __('general.name') }}"
                                            value="{{old('name')}}" class="form-control mb-2" data-required="true"
                                            data-maxlength="50" />
                                        <!--end::Input-->
                                        <!--begin::Description-->
                                        <div class="text-muted fs-7">{{ __('general.mandatory_field_message') }}</div>
                                        <!--end::Description-->
                                    </div>
                                    <!--end::Input group-->

                                </div>
                                <!--end::Input Row-->
                                <!--begin::Input Row-->
                                <div class="d-flex flex-wrap gap-5 mb-5">
                                    <!--begin::Input group-->
                                    <div class="fv-row w-100 flex-md-root">
                                        <!--begin::Label-->
                                        <label class="required form-label">{{ __('general.email') }}</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input type="email" name="email" data-label="{{ __('general.email') }}"
                                            value="{{old('email')}}" class="form-control mb-2" data-required="true"
                                            data-maxlength="50" />
                                        <!--end::Input-->
                                        <!--begin::Description-->
                                        <div class="text-muted fs-7">{{ __('general.mandatory_field_message') }}</div>
                                        <!--end::Description-->
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Input group-->
                                    <div class="fv-row w-100 flex-md-root">
                                        <!--begin::Label-->
                                        <label class="required form-label">{{ __('general.phone') }}</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input type="text" name="phone" data-label="{{ __('general.phone') }}"
                                            value="{{old('phone')}}" class="form-control mb-2" data-required="true"
                                            data-minlength="5" data-maxlength="50" />
                                        <!--end::Input-->
                                        <!--begin::Description-->
                                        <div class="text-muted fs-7">{{ __('general.mandatory_field_message') }}</div>
                                        <!--end::Description-->
                                    </div>
                                    <!--end::Input group-->
                                    <div class="fv-row w-100 flex-md-root">
                                        <!--begin::Label-->
                                        <label class="form-label">{{ __('general.phone2') }}</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input type="text" name="phone2" data-label="{{ __('general.phone2') }}"
                                            value="{{old('phone2')}}" class="form-control mb-2" data-maxlength="50" />
                                        <!--end::Input-->
                                        <!--begin::Description-->
                                        <div class="text-muted fs-7">{{ __('general.optional_message') }}</div>
                                        <!--end::Description-->
                                    </div>
                                </div>
                                <!--end:Input Row-->

                                <!--begin::Input Row-->
                                <div class="d-flex flex-wrap gap-5 mb-5">
                                    <!--begin::Input group-->
                                    <div class="fv-row w-100 flex-md-root">
                                        <!--begin::Label-->
                                        <label class="required form-label">{{ __('general.currency') }}</label>
                                        <!--end::Label-->
                                        <!--begin::Select2-->
                                        <select class="form-select mb-2" name="currency"
                                            data-label="{{ __('general.currency') }}" data-control="select2"
                                            data-hide-search="true" data-placeholder="{{ __('general.select_an_option') }}"
                                            data-required="true">
                                            @foreach($currencies as $currency)
                                                <option value="{{$currency->code}}" @selected(old('currency') == $currency->code)>
                                                    {{$currency->code}}</option>
                                            @endforeach
                                        </select>
                                        <!--end::Select2-->
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Input group-->
                                    <div class="fv-row w-100 flex-md-root">
                                        <!--begin::Label-->
                                        <label class="required form-label">{{ __('general.default_language') }}</label>
                                        <!--end::Label-->
                                        <!--begin::Select2-->
                                        <select class="form-select mb-2" name="default_language"
                                            data-label="{{ __('general.default_language') }}" data-control="select2"
                                            data-hide-search="true" data-placeholder="{{ __('general.select_an_option') }}"
                                            data-required="true">
                                            <option value="arabic">arabic</option>
                                            <option value="english">english</option>
                                        </select>
                                        <!--end::Select2-->
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Input group-->
                                    <div class="fv-row w-100 flex-md-root">
                                        <!--begin::Label-->
                                        <label class="form-label">{{ __('general.website') }}</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input type="text" class="form-control mb-2" name="website"
                                            data-label="{{ __('general.website') }}"
                                        value="{{old('website')}}" data-maxlength="255" />
                                        <!--end::Input-->
                                        <!--begin::Description-->
                                        <div class="text-muted fs-7">{{ __('general.optional_message') }}</div>
                                        <!--end::Description-->
                                    </div>
                                    <!--end::Input group-->
                                </div>
                                <!--end:Input Row-->
                                <!--begin::Input Row-->
                                <div class="d-flex flex-wrap gap-5 mb-5">
                                    <!--begin::Input group-->
                                    <div class="fv-row w-100 flex-md-root">
                                        <!--begin::Label-->
                                        <label class="form-label">{{ __('general.tax_number') }}</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input type="text" class="form-control mb-2" name="tax_number"
                                            data-label="{{ __('general.tax_number') }}"
                                                value="{{old('tax_number')}}" data-maxlength="50" />
                                        <!--end::Input-->
                                        <!--begin::Description-->
                                        <div class="text-muted fs-7">{{ __('general.optional_message') }}</div>
                                        <!--end::Description-->
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Input group-->
                                    <div class="fv-row w-100 flex-md-root">
                                        <!--begin::Label-->
                                        <label class="form-label">{{ __('general.computer_number') }}</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input type="text" class="form-control mb-2" name="computer_number"
                                            data-label="{{ __('general.computer_number') }}"
                                            value="{{old('computer_number')}}" maxlength="20" />
                                        <!--end::Input-->
                                        <!--begin::Description-->
                                        <div class="text-muted fs-7">{{ __('general.optional_message') }}</div>
                                        <!--end::Description-->
                                    </div>
                                    <!--end::Input group-->
                                </div>
                                <!--end:Input Row-->

                                <!--begin::Input group-->
                                <div class="mb-5 mt-5">
                                    <!--begin::Label-->
                                    <label class="form-label">{{ __('general.bio') }}</label>
                                    <!--end::Label-->
                                    <!--begin::Editor-->
                                    <textarea class="form-control mb-2" name="bio" data-label="{{ __('general.bio') }}"
                                        maxlength="1024">{{old('bio')}}</textarea>
                                    <!--end::Editor-->
                                    <!--begin::Description-->
                                    <div class="text-muted fs-7">{{ __('general.optional_message') }}</div>
                                    <!--end::Description-->
                                </div>
                                <!--end::Input group-->
                            </div>
                            <!--end::Card body-->
                        </div>
                        <!--end::General options-->
                    </div>
                </div>
                <!--end::Tab pane-->
            </div>

            @include('error.form_errors')

            <!--end::Tab content-->
            <div class="d-flex justify-content-end">
                <!--begin::Button-->
                <button type="button" class="btn btn-light me-5"
                    onclick="showCancelConfirmation('javascript:history.back()');">{{ __('general.cancel') }}</button>
                <!--end::Button-->
                <!--begin::Button-->
                <button type="submit" id="kt_ecommerce_add_product_submit" class="btn btn-primary">
                    <span class="indicator-label">{{ __('general.save_changes') }}</span>
                    <span class="indicator-progress">{{ __('general.please_wait') }}
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                </button>
                <!--end::Button-->
            </div>
        </div>
        <!--end::Main column-->
    </form>
    <!--end::Form-->

@endsection

@section('scripts')
    {{-- Client Avatar Switch for Client type --}}
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const select = $('#clientTypeSelect'); // استخدم jQuery لأن Select2 يعتمد عليه
            const box = document.getElementById("avatarBox");

            function updateAvatar(value) {
                if (!box) return;
                box.classList.remove("avatar-person", "avatar-company");

                if (value === "person") {
                    box.classList.add("avatar-person");
                } else {
                    box.classList.add("avatar-company");
                }
            }

            // عند أول تحميل
            if (select.length) {
                updateAvatar(select.val());

                // حدث التغيير عبر Select2
                select.on('change', function () {
                    updateAvatar($(this).val());
                });
            }
        });
    </script>
@endsection