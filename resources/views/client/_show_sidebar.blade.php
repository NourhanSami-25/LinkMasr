<div class="flex-column flex-lg-row-auto w-100 w-xl-350px mb-10">
    <!--begin::Card-->
    <div class="card mb-5 mb-xl-8">
        <!--begin::Card body-->
        <div class="card-body pt-15">
            <!--begin::Summary-->
            <div class="d-flex flex-center flex-column mb-5">
                <!--begin::Avatar-->
                <div class="symbol symbol-100px symbol-circle mb-7">
                    @if(auth()->check() && $client->photo)
                        @if(app()->environment('production'))
                            <img src="{{ asset( $client->photo) }}" alt="profile picture" />
                        @else
                            <img src="{{ asset('storage/' . $client->photo) }}" alt="profile picture" />
                        @endif
                    @else
                        @if($client->type == 'person')
                            <img src="{{ asset('assets/media/avatars/client.png') }}" alt="profile picture"/>
                        @else
                            <img src="{{ asset('assets/media/avatars/company.png') }}" alt="profile picture"/>
                        @endif
                    @endif
                </div>
                <!--end::Avatar-->
                <!--begin::Name-->
                <a href="#" class="fs-3 text-gray-800 text-hover-primary fw-bold mb-1">{{$client->name}}</a>
                <!--end::Name-->
                <!--begin::Position-->
                <div class="fs-5 fw-semibold text-muted mb-6">{{ __('general.' . $client->type) }}</div>
                <!--end::Position-->
            </div>
            <!--end::Summary-->
            <!--begin::Details toggle-->
            <div class="d-flex flex-stack fs-4 py-3">
                <div class="fw-bold rotate collapsible" data-bs-toggle="collapse"
                    href="#kt_customer_view_details" role="button"
                    aria-expanded="false" aria-controls="kt_customer_view_details">
                    {{ __('general.details') }}
                    <span class="ms-2 rotate-180">
                        <i class="ki-outline ki-down fs-3"></i>
                    </span>
                </div>
                @hasAccess('client','modify')
                <span data-bs-toggle="tooltip" data-bs-trigger="hover">
                    <a href="{{route('clients.edit' , $client->id)}}" class="btn btn-sm btn-light-primary">{{ __('general.update') }}</a>
                </span>
                @endhasAccess
            </div>
            <!--end::Details toggle-->
            <div class="separator separator-dashed my-3"></div>
            <!--begin::Details content-->
            <div id="kt_customer_view_details" class="collapse show">
                <div class="py-5 fs-6">
                    <!--begin::Badge-->
                    <div class="badge badge-light-info d-inline">{{ __('general.' . $client->status) }}</div>
                    <!--begin::Badge-->
                    <!--begin::Details item-->
                    <div class="fw-bold mt-5">{{ __('general.name') }}</div>
                    <div class="text-gray-600">{{$client->name}}</div>
                    <!--begin::Details item-->
                    <!--begin::Details item-->
                    <div class="fw-bold mt-5">{{ __( 'general.phone') }}</div>
                    <div class="text-gray-600">{{$client->phone}}</div>
                    <!--begin::Details item-->
                    @if($client->phone2)
                    <!--begin::Details item-->
                    <div class="fw-bold mt-5">{{ __( 'general.phone2') }}</div>
                    <div class="text-gray-600">{{$client->phone2}}</div>
                    <!--begin::Details item-->
                    @endif
                    <!--begin::Details item-->
                    <div class="fw-bold mt-5">{{ __('general.email') }}</div>
                    <div class="text-gray-600">{{$client->email}}</div>
                    <!--begin::Details item-->
                    @if($client->website)
                    <!--begin::Details item-->
                    <div class="fw-bold mt-5">{{ __('general.website') }}</div>
                    <div class="text-gray-600">{{$client->website}}</div>
                    <!--begin::Details item-->
                    @endif
                </div>
            </div>
            <!--end::Details content-->
        </div>
        <!--end::Card body-->
    </div>
    <!--end::Card-->
</div>