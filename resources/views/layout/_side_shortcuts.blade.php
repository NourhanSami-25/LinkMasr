<div id="kt_app_aside" class="app-aside flex-column" data-kt-drawer="true"
					data-kt-drawer-name="app-aside" data-kt-drawer-activate="{default: true, lg: false}"
					data-kt-drawer-overlay="true" data-kt-drawer-width="auto" data-kt-drawer-direction="end"
					data-kt-drawer-toggle="#kt_app_aside_mobile_toggle">
					<!--begin::Wrapper-->
					<div id="kt_app_aside_wrapper"
						class="d-flex flex-column align-items-center hover-scroll-y mt-lg-n3 py-5 py-lg-0 gap-4"
						data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}"
						data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_app_header"
						data-kt-scroll-wrappers="#kt_app_aside_wrapper" data-kt-scroll-offset="5px">
						<a href="{{route('calendar.index')}}"
							class="btn btn-icon btn-color-primary bg-hover-body h-45px w-45px flex-shrink-0"
							data-bs-toggle="tooltip" title="{{ __('general.calendar') }}" data-bs-custom-class="tooltip-inverse">
							<i class="ki-outline ki-calendar fs-2x"></i>
						</a>
						<a href="{{route('users.show' , Auth()->id())}}"
							class="btn btn-icon btn-color-warning bg-hover-body h-45px w-45px flex-shrink-0"
							data-bs-toggle="tooltip" title="{{ __('general.my_profile') }}" data-bs-custom-class="tooltip-inverse">
							<i class="ki-outline ki-address-book fs-2x"></i>
						</a>
						<a href="{{route('todos.index')}}"
							class="btn btn-icon btn-color-success bg-hover-body h-45px w-45px flex-shrink-0"
							data-bs-toggle="tooltip" title="{{ __('general.todo_list') }}" data-bs-custom-class="tooltip-inverse">
							<i class="ki-outline ki-tablet-ok fs-2x"></i>
						</a>
						<a href="{{route('tasks.index')}}"
							class="btn btn-icon btn-color-info bg-hover-body h-45px w-45px flex-shrink-0"
							data-bs-toggle="tooltip" title="{{ __('general.tasks') }}" data-bs-custom-class="tooltip-inverse">
							<i class="ki-outline ki-calendar-add fs-2x"></i>
						</a>
					</div>
					<!--end::Wrapper-->
				</div>