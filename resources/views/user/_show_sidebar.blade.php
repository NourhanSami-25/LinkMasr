<div class="flex-column flex-lg-row-auto w-100 w-xl-350px mb-10">
    <!--begin::Card-->
    <div class="card mb-5 mb-xl-8">
        <!--begin::Card body-->
        <div class="card-body pt-15">
            <!--begin::Summary-->
            <div class="d-flex flex-center flex-column mb-5">
                <!--begin::Avatar-->
                <div class="symbol symbol-100px symbol-circle mb-7">
                    @if($user->photo)
                        @if(app()->environment('production'))
                            <img src="{{ asset($user->photo) }}" alt="User Photo" />
                        @else
                            <img src="{{ asset('storage/' . $user->photo) }}" alt="User Photo" />
                        @endif
                    @else
                        <img src="{{ asset('assets/media/avatars/user.webp') }}" alt="User Photo"/>
                    @endif
                </div>
                <!--end::Avatar-->
                <!--begin::Name-->
                <a href="#" class="fs-3 text-gray-800 text-hover-primary fw-bold mb-1">{{$user->name}}</a>
                <!--end::Name-->
                <!--begin::Position-->
                <div class="fs-5 fw-semibold text-muted mb-6">{{ $user->positionRelation->name ?? 'N/A' }}</div>
                <!--end::Position-->
              
            </div>
            <!--end::Summary-->
            <!--begin::Details toggle-->
            <div class="d-flex flex-stack fs-4 py-3">
                <div class="fw-bold rotate collapsible" data-bs-toggle="collapse"
                    href="#kt_customer_view_details" role="button"
                    aria-expanded="false" aria-controls="kt_customer_view_details">
                    Details
                    <span class="ms-2 rotate-180">
                        <i class="ki-outline ki-down fs-3"></i>
                    </span>
                </div>
                @hasAccess('user','modify')
                <span data-bs-toggle="tooltip" data-bs-trigger="hover">
                    <a href="{{route('users.edit' , $user->id)}}" class="btn btn-sm btn-light-primary">{{ __('general.update') }}</a>
                </span>
                @endhasAccess
            </div>
            <!--end::Details toggle-->
            <div class="separator separator-dashed my-3"></div>
            <!--begin::Details content-->
            <div id="kt_customer_view_details" class="collapse show">
                <div class="py-5 fs-6">
                    <!--begin::Badge-->
                    <div class="badge badge-light-info d-inline">{{$user->status}}</div>
                    <!--begin::Badge-->
                    <!--begin::Details item-->
                    <div class="fw-bold mt-5">{{ __('general.name') }}</div>
                    <div class="text-gray-600">{{$user->name}}</div>
                    <!--begin::Details item-->
                    @if($user->phone)
                    <!--begin::Details item-->
                    <div class="fw-bold mt-5">{{ __( 'general.phone') }}</div>
                    <div class="text-gray-600">{{$user->phone}}</div>
                    @endif
                    <!--begin::Details item-->
                    <div class="fw-bold mt-5">{{ __('general.email') }}</div>
                    <div class="text-gray-600">{{$user->email}}</div>
                    <!--begin::Details item-->
                    @if($user->facebook)
                    <!--begin::Details item-->
                    <div class="fw-bold mt-5">{{ __('general.facebook') }}</div>
                    <div class="text-gray-600">{{$user->facebook}}</div>
                    <!--begin::Details item-->
                    @endif
                    <!--begin::Details item-->
                    @if($user->linkedin)
                    <!--begin::Details item-->
                    <div class="fw-bold mt-5">{{ __( 'general.linkedin') }}</div>
                    <div class="text-gray-600">{{$user->linkedin}}</div>
                    @endif
                    <!--begin::Details item-->
                    @if($user->address)
                    <!--begin::Details item-->
                    <div class="fw-bold mt-5">{{ __( 'general.address') }}</div>
                    <div class="text-gray-600">{{$user->address}}</div>
                    @endif
                    @if($user->language)
                    <!--begin::Details item-->
                    <div class="fw-bold mt-5">{{ __( 'general.user_default_language') }}</div>
                    <div class="text-gray-600">
                        @if($user->language == 'ar')
                            العربية
                        @else
                            English
                        @endif
                    </div>
                    @endif
                </div>
            </div>
            <!--end::Details content-->
        </div>
        <!--end::Card body-->
    </div>
    <!--end::Card-->
</div>