


<div id="kt_app_header" class="app-header d-flex flex-column flex-stack">
    <!--begin::Header main-->
    <div class="d-flex flex-stack flex-grow-1">
        <div class="app-header-logo d-flex align-items-center ps-lg-12" id="kt_app_header_logo">
            
            <!--begin::Sidebar toggle-->
            <div id="kt_app_sidebar_toggle"
                class="app-sidebar-toggle btn btn-sm btn-icon bg-body btn-color-gray-500 btn-active-color-primary w-30px h-30px ms-n2 me-4 d-none d-lg-flex"
                data-kt-toggle="true" data-kt-toggle-state="active" data-kt-toggle-target="body"
                data-kt-toggle-name="app-sidebar-minimize">
                <i class="ki-outline ki-abstract-14 fs-3 mt-1"></i>
            </div>
            <!--end::Sidebar toggle-->

            <!--begin::Sidebar mobile toggle-->
            <div class="btn btn-icon btn-active-color-primary w-35px h-35px ms-3 me-2 d-flex d-lg-none"
                id="kt_app_sidebar_mobile_toggle">
                <i class="ki-outline ki-abstract-14 fs-2"></i>
            </div>
            <!--end::Sidebar mobile toggle-->

            <!--begin::Logo-->
            <a href="{{route('home')}}" class="app-sidebar-logo">
                <img alt="Logo" src="{{ asset('assets/media/logos/logo_dark.webp') }}"
                    class="h-30px theme-light-show" />
                <img alt="Logo" src="{{ asset('assets/media/logos/logo_dark.webp') }}"
                    class="h-30px theme-dark-show" style="filter: invert(1) hue-rotate(180deg) saturate(3) brightness(0.9) contrast(1.1);" />
            </a>
            <!--end::Logo-->

        </div>
        <!--begin::Navbar-->

        {{-- @include('layout._response_message') --}}

        <div class="app-navbar flex-grow-1 justify-content-end" id="kt_app_header_navbar">
            
            <!--begin::Status Message-->
            <div class="w-100">
                <!-- Desktop Alert (visible on lg and up) -->
                <div class="d-none d-lg-block app-navbar-item flex-grow-1" style="padding-left:1.25rem !important;">
                    @include('layout._response_message')
                </div>
            
                <!-- Mobile Alert (visible only on small screens) -->
                <div class="d-block d-lg-none position-fixed top-0 start-0 w-100 z-index-50 mb-5" style="margin-top: 60px;">
                    <div class="px-3">
                        @include('layout._response_message')
                    </div>
                </div>
            </div>
            <!--end::Status Message-->



            <!--begin::Notifications-->
            <div class="app-navbar-item ms-1 ms-lg-6">
                <!--begin::Menu- wrapper-->
                <div class="btn btn-icon btn-custom btn-color-gray-600 btn-active-color-primary w-35px h-35px w-md-40px h-md-40px position-relative"
                    data-kt-menu-trigger="{default: 'click', lg: 'click'}" data-kt-menu-attach="parent"
                    data-kt-menu-placement="bottom-end" id="notifications-dropdown">
                    <i class="ki-outline ki-notification-on fs-1"></i>
                    <span class="position-absolute top-0 start-100 translate-middle w-15px h-15px ms-n4 mt-3 p-3" id="notification-count">0</span>
                </div>
            
                <!--begin::Menu-->
                <div class="menu menu-sub menu-sub-dropdown menu-column w-350px w-lg-500px" data-kt-menu="true">
                    <!--begin::Heading-->
                    <div class="d-flex flex-column bgi-no-repeat rounded-top">
                        <div class="d-flex align-items-center justify-content-between px-9 mt-10 mb-6">
                            <h3 class="text-gray-800 fw-semibold m-0">
                                {{ __('general.notifications') }}<span class="fs-8 opacity-75 pe-3 px-2" id="unread-notifications-count">0 {{ __('general.unread') }}</span>
                            </h3>
                            <div class="d-flex align-items-center"> 
                                <button id="markAsReadButton" class="btn btn-primary" style="font-size: 10px; padding: 5px 8px;">{{ __('general.mark_as_read') }}</button>
                            </div>
                        </div>
                    </div>
                    <!--end::Heading-->
                
                    <!--begin::Tab content-->
                    <div class="tab-content">
                        <!--begin::Items-->
                        <div class="scroll-y mh-325px my-5 px-8" id="notifications-container">
                            <span class="text-muted">{{ __('general.loading') }}...</span>
                        </div>
                        <!--end::Items-->
                    
                        <!--begin::View more-->
                        <div class="py-3 text-center border-top">
                            <a href="{{ route('notifications.index') }}" class="btn btn-color-gray-600 btn-active-color-primary" target="_blank">
                                {{ __('general.view_all') }}
                                <i class="ki-outline ki-arrow-right fs-5"></i>
                            </a>
                        </div>
                        <!--end::View more-->
                    </div>
                    <!--end::Tab content-->
                </div>
                <!--end::Menu-->
            </div>
            <!--end::Notifications-->
            
            <!--begin::Quick links-->
            <div class="app-navbar-item ms-1 ms-lg-6">
                <!--begin::Menu- wrapper-->
                <div class="btn btn-icon btn-custom btn-color-gray-600 btn-active-color-primary w-35px h-35px w-md-40px h-md-40px"
                    data-kt-menu-trigger="{default: 'click', lg: 'click'}" data-kt-menu-attach="parent"
                    data-kt-menu-placement="bottom-end" data-bs-toggle="tooltip" title="{{ __('general.quick_actions') }}" data-bs-custom-class="tooltip-inverse">
                    <i class="ki-outline ki-plus-square fs-1"></i>
                </div>
                <!--begin::Menu-->
                <div class="menu menu-sub menu-sub-dropdown menu-column w-250px w-lg-325px"
                    data-kt-menu="true">
                    <!--begin::Heading-->
                    <div class="d-flex flex-column flex-center bgi-no-repeat rounded-top px-9 py-10">
                        <!--begin::Title-->
                        <h3 class="fw-semibold mb-3"> {{ __('general.quick_links') }}</h3>
                        <!--end::Title-->
                        <!--begin::Status-->
                        <span class="badge bg-primary text-inverse-primary py-2 px-3">{{ __('general.create_new_elements') }}</span>
                        <!--end::Status-->
                    </div>
                    <!--end::Heading-->
                    <!--begin:Nav-->
                    <div class="row g-0">
                        @hasAccess('task', 'create')
                        <!--begin:Item-->
                        <div class="col-4">
                            <a href="{{route('tasks.create')}}"
                                class="d-flex flex-column flex-center h-100 p-6 bg-hover-light border-end border-bottom">
                                <i class="ki-outline ki-burger-menu fs-3x text-primary mb-2"></i>
                                <span class="fs-5 fw-semibold text-gray-800 mb-0"> {{ __('general.task') }}</span>
                            </a>
                        </div>
                        <!--end:Item-->
                        @endhasAccess
                      
                        @hasAccess('project', 'create')
                        <!--begin:Item-->
                        <div class="col-4">
                            <a href="{{route('projects.create')}}"
                                class="d-flex flex-column flex-center h-100 p-6 bg-hover-light border-end border-bottom">
                                <i class="ki-outline ki-chart-pie-3 fs-3x text-primary mb-2"></i>
                                <span class="fs-5 fw-semibold text-gray-800 mb-0"> {{ __('general.project') }}</span>
                            </a>
                        </div>
                        <!--end:Item-->
                        @endhasAccess
                        @hasAccess('client', 'create')
                        <!--begin:Item-->
                        <div class="col-4">
                            <a href="{{route('clients.create')}}"
                                class="d-flex flex-column flex-center h-100 p-6 bg-hover-light border-end border-bottom">
                                <i class="ki-outline ki-user fs-3x text-primary mb-2"></i>
                                <span class="fs-5 fw-semibold text-gray-800 mb-0"> {{ __('general.client') }}</span>
                            </a>
                        </div>
                        <!--end:Item-->
                        @endhasAccess
                        @hasAccess('finance', 'create')
                        <!--begin:Item-->
                        <div class="col-4">
                            <a href="{{route('invoices.create')}}"
                                class="d-flex flex-column flex-center h-100 p-6 bg-hover-light border-end border-bottom">
                                <i class="ki-outline ki-dollar fs-3x text-primary mb-2"></i>
                                <span class="fs-5 fw-semibold text-gray-800 mb-0"> {{ __('general.invoice') }}</span>
                            </a>
                        </div>
                        <!--end:Item-->
                        <!--begin:Item-->
                        <div class="col-4">
                            <a href="{{route('paymentRequests.create')}}"
                                class="d-flex flex-column flex-center h-100 p-6 bg-hover-light border-end border-bottom">
                                <i class="ki-outline ki-financial-schedule fs-3x text-primary mb-2"></i>
                                <span class="fs-5 fw-semibold text-gray-800 mb-0"> {{ __('general.paymentRequest') }}</span>
                            </a>
                        </div>
                        <!--end:Item-->
                        <!--begin:Item-->
                        <div class="col-4">
                            <a href="{{route('proposals.create')}}"
                                class="d-flex flex-column flex-center h-100 p-6 bg-hover-light border-end border-bottom">
                                <i class="ki-outline ki-send fs-3x text-primary mb-2"></i>
                                <span class="fs-5 fw-semibold text-gray-800 mb-0"> {{ __('general.proposal') }}</span>
                            </a>
                        </div>
                        <!--end:Item-->
                        @endhasAccess
                        <!--begin:Item-->
                        <div class="col-4">
                            <a href="{{route('expenses.create')}}"
                                class="d-flex flex-column flex-center h-100 p-6 bg-hover-light border-end border-bottom">
                                <i class="ki-outline ki-handcart fs-3x text-primary mb-2"></i>
                                <span class="fs-5 fw-semibold text-gray-800 mb-0"> {{ __('general.expense') }}</span>
                            </a>
                        </div>
                        <!--end:Item-->
                        <!--begin:Item-->
                        <div class="col-4">
                            <a href="{{route('vacation-requests.create')}}"
                                class="d-flex flex-column flex-center h-100 p-6 bg-hover-light border-end border-bottom">
                                <i class="ki-outline ki-time fs-3x text-primary mb-2"></i>
                                <span class="fs-5 fw-semibold text-gray-800 mb-0"> {{ __('general.reminder') }}</span>
                            </a>
                        </div>
                        <!--end:Item-->
                        <!--begin:Item-->
                        <div class="col-4">
                            <a href="{{route('permission-requests.create')}}"
                                class="d-flex flex-column flex-center h-100 p-6 bg-hover-light border-end border-bottom">
                                <i class="ki-outline ki-briefcase fs-3x text-primary mb-2"></i>
                                <span class="fs-5 fw-semibold text-gray-800 mb-0"> {{ __('general.permission') }}</span>
                            </a>
                        </div>
                        <!--end:Item-->
                         <!--begin:Item-->
                        <div class="col-4">
                            <a href="{{route('mission-requests.create')}}"
                                class="d-flex flex-column flex-center h-100 p-6 bg-hover-light border-end border-bottom">
                                <i class="ki-outline ki-magnifier fs-3x text-primary mb-2"></i>
                                <span class="fs-5 fw-semibold text-gray-800 mb-0"> {{ __('general.mission') }}</span>
                            </a>
                        </div>
                        <!--end:Item-->
                        <!--begin:Item-->
                        <div class="col-4">
                            <a href="{{route('vacation-requests.create')}}"
                                class="d-flex flex-column flex-center h-100 p-6 bg-hover-light border-end border-bottom">
                                <i class="ki-outline ki-home fs-3x text-primary mb-2"></i>
                                <span class="fs-5 fw-semibold text-gray-800 mb-0"> {{ __('general.vacation') }}</span>
                            </a>
                        </div>
                        <!--end:Item-->
                    </div>
                    <!--end:Nav-->
                </div>
                <!--end::Menu-->
                <!--end::Menu wrapper-->
            </div>
            <!--end::Quick links-->

            <!--begin::Todo List-->
            @include('layout._todo_drawer')
            <div class="app-navbar-item ms-1 ms-lg-6">
                <!--begin::Menu wrapper-->
                <div class="btn btn-icon btn-custom btn-color-gray-600 btn-active-color-primary w-35px h-35px w-md-40px h-md-40px position-relative"
                    id="kt_drawer_chat_toggle" data-bs-toggle="tooltip" title="{{ __('general.todo_list') }}" data-bs-custom-class="tooltip-inverse">
                    <i class="ki-outline ki-pin fs-1"></i>
                </div>
                <!--end::Menu wrapper-->
            </div>
            <!--end::Chat-->
            
            <!--begin::Header menu toggle-->
            <div class="app-navbar-item ms-1 ms-lg-6 ms-n2 me-3 d-flex d-lg-none">
                <div class="btn btn-icon btn-custom btn-color-gray-600 btn-active-color-primary w-35px h-35px w-md-40px h-md-40px" id="kt_app_aside_mobile_toggle">
                    <i class="ki-outline ki-burger-menu-2 fs-2"></i>
                </div>
            </div>
            <!--end::Header menu toggle-->

            <!--begin::User Menu-->
            <div class="app-navbar-item ms-0 ms-lg-6 me-lg-10 me-3" id="kt_header_user_menu_toggle" style="width: 30px !important">
                <!--begin::Menu wrapper-->
                <div class="cursor-pointer symbol symbol-circle symbol-30px symbol-lg-25px"
                    data-kt-menu-trigger="{default: 'click', lg: 'click'}" data-kt-menu-attach="parent"
                    data-kt-menu-placement="bottom-end">
                    @if(auth()->check() && auth()->user()->photo)
                        @if(app()->environment('production'))
                            <img src="{{ asset( auth()->user()->photo) }}" alt="profile picture" />
                        @else
                            <img src="{{ asset('storage/' . auth()->user()->photo) }}" alt="profile picture" />
                        @endif
                    @else
                        <img src="{{ asset('assets/media/avatars/user.webp') }}" alt="profile picture"/>
                    @endif
                </div>
                <!--begin::User account menu-->
                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-6 w-275px"
                    data-kt-menu="true">
                    <!--begin::Menu item-->
                    <div class="menu-item px-3">
                        <div class="menu-content d-flex align-items-center px-3">
                            <!--begin::Avatar-->
                            <div class="symbol symbol-50px me-5">
                                @if(auth()->check() && auth()->user()->photo)
                                    @if(app()->environment('production'))
                                        <img src="{{ asset( auth()->user()->photo) }}" alt="profile picture" />
                                    @else
                                        <img src="{{ asset('storage/' . auth()->user()->photo) }}" alt="profile picture" />
                                    @endif
                                @else
                                    <img src="{{ asset('assets/media/avatars/user.webp') }}" alt="profile picture"/>
                                @endif
                            </div>
                            <!--end::Avatar-->
                            <!--begin::Username-->
                            <div class="d-flex flex-column">
                                <div class="fw-bold d-flex align-items-center fs-6">{{auth()->user()->name}}
                                    <span
                                        class="badge badge-light-success fw-bold fs-8 px-2 py-1 ms-2">{{auth()->user()->status}}</span>
                                </div>
                                <a href="#"
                                    class="fw-semibold text-muted text-hover-primary fs-7">{{auth()->user()->email}}</a>
                            </div>
                            <!--end::Username-->
                        </div>
                    </div>
                    <!--end::Menu item-->
                    <!--begin::Menu separator-->
                    <div class="separator my-2"></div>
                    <!--end::Menu separator-->
                    <!--begin::Menu item-->
                    <div class="menu-item px-5">
                        <a href="{{route('users.show' , Auth()->id())}}" class="menu-link px-5">{{ __('general.my_profile') }}</a>
                    </div>
                    <!--end::Menu item-->
                    <!--begin::Menu item-->
                    <div class="menu-item px-5" data-kt-menu-trigger="{default: 'click', lg: 'hover'}"
                        data-kt-menu-placement="left-start" data-kt-menu-offset="-15px, 0">
                        <a href="#" class="menu-link px-5">
                            <span class="menu-title">{{ __('general.language') }}</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <!--begin::Menu sub-->
                        <div class="menu-sub menu-sub-dropdown w-175px py-4">
                            <!--begin::Menu item-->
                            <div class="menu-item px-3">
                                <a href="{{ route('switch-language', ['lang' => 'ar']) }}" class="menu-link px-5 d-flex align-items-center fw-bold">
                                    <img src="{{ asset(path: 'assets/media/flags/ar.svg')}}" alt="Arabic Flag" class="me-2" width="20">
                                    العربية
                                </a>
                            </div>
                            <!--end::Menu item-->

                            <!--begin::Menu item-->
                            <div class="menu-item px-3">
                                <a href="{{ route('switch-language', ['lang' => 'en']) }}" class="menu-link px-5 d-flex align-items-center fw-bold">
                                    <img src="{{ asset(path: 'assets/media/flags/en.svg')}}" alt="English Flag" class="me-2" width="20">
                                    English
                                </a>
                            </div>
                            <!--end::Menu item-->
                        </div>
                        <!--end::Menu sub-->

                    </div>
                    <!--end::Menu item-->
                     <!--begin::Menu item-->
                    <div class="menu-item px-5" data-kt-menu-trigger="{default: 'click', lg: 'hover'}"
                        data-kt-menu-placement="left-start" data-kt-menu-offset="-15px, 0">
                        <a href="#" class="menu-link px-5">
                            <span class="menu-title position-relative">{{ __('general.mode') }}
                                <span class="ms-5 position-absolute translate-middle-y top-50 end-0">
                                    <i class="ki-outline ki-night-day theme-light-show fs-2"></i>
                                    <i class="ki-outline ki-moon theme-dark-show fs-2"></i>
                                </span></span>
                        </a>
                        <!--begin::Menu-->
                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-title-gray-700 menu-icon-gray-500 menu-active-bg menu-state-color fw-semibold py-4 fs-base w-150px"
                            data-kt-menu="true" data-kt-element="theme-mode-menu">
                            <!--begin::Menu item-->
                            <div class="menu-item px-3 my-0">
                                <a href="#" class="menu-link px-3 py-2" data-kt-element="mode"
                                    data-kt-value="light">
                                    <span class="menu-icon" data-kt-element="icon">
                                        <i class="ki-outline ki-night-day fs-2"></i>
                                    </span>
                                    <span class="menu-title">{{ __('general.light') }}</span>
                                </a>
                            </div>
                            <!--end::Menu item-->
                            <!--begin::Menu item-->
                            <div class="menu-item px-3 my-0">
                                <a href="#" class="menu-link px-3 py-2" data-kt-element="mode"
                                    data-kt-value="dark">
                                    <span class="menu-icon" data-kt-element="icon">
                                        <i class="ki-outline ki-moon fs-2"></i>
                                    </span>
                                    <span class="menu-title">{{ __('general.dark') }}</span>
                                </a>
                            </div>
                            <!--end::Menu item-->
                            <!--begin::Menu item-->
                            <div class="menu-item px-3 my-0">
                                <a href="#" class="menu-link px-3 py-2" data-kt-element="mode"
                                    data-kt-value="system">
                                    <span class="menu-icon" data-kt-element="icon">
                                        <i class="ki-outline ki-screen fs-2"></i>
                                    </span>
                                    <span class="menu-title">{{ __('general.system') }}</span>
                                </a>
                            </div>
                            <!--end::Menu item-->
                        </div>
                        <!--end::Menu-->
                    </div>
                    <!--end::Menu item-->
                    <!--begin::Menu item-->
                    <div class="menu-item px-5">
                        <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                            @csrf
                            <button type="submit" class="menu-link fw-bold px-5 py-2" style="background: none; border: none; padding: 0; font-size: inherit; color: rgb(212, 31, 31); cursor: pointer;">
                                {{ __('general.logout') }}
                            </button>
                        </form>
                    </div>

                    <!--end::Menu item-->
                </div>
                <!--end::User account menu-->
                <!--end::Menu wrapper-->
            </div>
            <!--end::User Menu-->

            {{-- <!--begin::Logout-->
            <div class="app-navbar-item ms-0 ms-lg-6 me-lg-6" >
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-icon btn-custom btn-color-gray-600 btn-active-color-primary w-35px h-35px w-md-40px h-md-40px" data-bs-toggle="tooltip" title="{{ __('general.logout') }}" data-bs-custom-class="tooltip-inverse">
                        <i class="ki-outline ki-exit-right fs-1"></i>
                    </button>
                </form>
            </div>
            <!--end::Logout--> --}}

        </div>
        <!--end::Navbar-->
    </div>
    <!--end::Header main-->

    <!--begin::Separator-->
    <div class="app-header-separator"></div>
    <!--end::Separator-->
    
</div>
