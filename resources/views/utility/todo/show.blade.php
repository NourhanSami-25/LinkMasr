<!DOCTYPE html>

@if (app()->getLocale() == 'ar')
	@include('assets._language_ar')
@else
	@include('assets._language_en')
@endif

<head>

	<title>Link Masr | Todo List Details</title>
	@include('assets._meta_tags')
	@include('assets._misc')
	@include('assets._data_table_styles')


	@if (app()->getLocale() == 'ar')
		@include('assets._ar_fonts')
		@include('assets._main_styles_RTL')
	@else
		@include('assets._en_fonts')
		@include('assets._main_styles_LTR')
	@endif
	

</head>

<body id="kt_app_body" data-kt-app-header-fixed="true" data-kt-app-header-fixed-mobile="true"
	data-kt-app-sidebar-enabled="true" data-kt-app-sidebar-fixed="true" data-kt-app-sidebar-hoverable="true"
	data-kt-app-sidebar-push-toolbar="true" data-kt-app-sidebar-push-footer="true" data-kt-app-toolbar-enabled="true"
	data-kt-app-aside-enabled="true" data-kt-app-aside-fixed="true" data-kt-app-aside-push-toolbar="true"
	data-kt-app-aside-push-footer="true" class="app-default" data-kt-app-sidebar-minimize="on">
	
	
	

	@include('assets.dark_mode')
	<!--begin::App-->
	<div class="d-flex flex-column flex-root app-root" id="kt_app_root">
		<!--begin::Page-->
		<div class="app-page flex-column flex-column-fluid" id="kt_app_page">
			<!--begin::Header-->
			@include('layout._header')
			<!--end::Header-->
			<!--begin::Wrapper-->
			<div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">
				<!--begin::Sidebar-->
				@include('layout._side_bar')
				<!--end::Sidebar-->
				<!--begin::Main-->
				<div class="app-main flex-column flex-row-fluid" id="kt_app_main">
					<!--begin::Content wrapper-->
					<div class="d-flex flex-column flex-column-fluid">
						<!--begin::Toolbar-->
						<div id="kt_app_toolbar" class="app-toolbar pt-6 pb-2">
							<!--begin::Toolbar container-->
							<div id="kt_app_toolbar_container"
								class="app-container container-fluid d-flex align-items-stretch">
								<!--begin::Toolbar wrapper-->
								<div class="app-toolbar-wrapper d-flex flex-stack flex-wrap gap-4 w-100">
									<!--begin::Page title-->
									<div class="page-title d-flex flex-column justify-content-center gap-1 me-3">
										<!--begin::Title-->
										<h1
											class="page-heading d-flex flex-column justify-content-center text-gray-900 fw-bold fs-1 m-0">
											{{ __('general.todo_details') }} </h1>
										<!--end::Title-->
										<!--begin::Breadcrumb-->
										<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0">
											<!--begin::Item-->
											<li class="breadcrumb-item text-muted">
												<a href="{{ route('home')}}" class="text-muted text-hover-primary">{{ __('general.home_breadcrumb') }}</a>
											</li>
											<!--end::Item-->
											<!--begin::Item-->
											<li class="breadcrumb-item">
												<span class="bullet bg-gray-500 w-5px h-2px"></span>
											</li>
											<!--end::Item-->
											<!--begin::Item-->
											<li class="breadcrumb-item text-muted">{{ __('general.utilities') }}</li>
											<!--end::Item-->
											<!--begin::Item-->
											<li class="breadcrumb-item">
												<span class="bullet bg-gray-500 w-5px h-2px"></span>
											</li>
											<!--end::Item-->
											<!--begin::Item-->
											<li class="breadcrumb-item text-muted">{{ __('general.todo_lists') }}</li>
											<!--end::Item-->
											<!--begin::Item-->
											<li class="breadcrumb-item">
												<span class="bullet bg-gray-500 w-5px h-2px"></span>
											</li>
											<!--end::Item-->
											<!--begin::Item-->
											<li class="breadcrumb-item text-muted">{{ __('general.todo_list_details') }}</li>
											<!--end::Item-->
											
										</ul>
										<!--end::Breadcrumb-->
									</div>
									<!--end::Page title-->
									<!--begin::Actions-->
									<div class="d-flex align-items-center gap-2 gap-lg-3">
										<a href="javascript:history.back()" class="btn btn-flex btn-danger h-40px fs-7 fw-bold">{{ __('general.back') }}</a>											
									</div>
									<!--end::Actions-->
								</div>
								<!--end::Toolbar wrapper-->
							</div>
							<!--end::Toolbar container-->
						</div>
						<!--end::Toolbar-->
						<!--begin::Content-->
						<div id="kt_app_content" class="app-content flex-column-fluid">
							<!--begin::Content container-->
							<div id="kt_app_content_container" class="app-container container-fluid">
								<!--begin::Layout-->
								<div class="d-flex flex-column flex-lg-row">
									<!--begin::Content-->
									<div class="flex-lg-row-fluid order-2 order-lg-1 mb-10 mb-lg-0">
										<!--begin::Card-->
										<div class="card card-flush pt-3 mb-5 mb-xl-10">
											<!--begin::Card header-->
											<div class="card-header">
												<!--begin::Card title-->
												<div class="card-title">
													<h2 class="fw-bold">{{ __('general.todo_list_details') }}</h2>
												</div>
												<!--begin::Card title-->
												<!--begin::Card toolbar-->
												<div class="card-toolbar">
													<a href="#" class="btn btn-light-primary">{{ __('general.print_todo_list') }}</a>
												</div>
												<!--end::Card toolbar-->
											</div>
											<!--end::Card header-->
											<!--begin::Card body-->
											<div class="card-body pt-3">
												<!--begin::Section-->
												<div class="mb-10">
													<!--begin::Details-->
													<div class="d-flex flex-wrap py-5">
														<!--begin::Row-->
														<div class="flex-equal me-5">
															<!--begin::Details-->
															<table class="table fs-5 fw-semibold gs-0 gy-2 gx-2 me-0">
																<!--begin::Row-->
																<tr>
																	<td class="text-gray-600 min-w-250px w-250px">{{ __('general.subject') }}</td>
																	<td class="text-gray-800 fw-bold min-w-200px fw-bold">{{$todo->subject}}</td>
																</tr>
																<!--end::Row-->
                                                                <!--begin::Row-->
																<tr>
																	<td class="text-gray-600">{{ __('general.status') }}</td>
																	<td class="fw-bold min-w-200px">
																	    <span class="text-light fs-5 badge 
																	        @if($todo->status == 'pending') bg-primary
																	        @elseif($todo->status == 'completed') bg-success
																	        @endif">
																	        {{ $todo->status }}
																	    </span>
																	</td>
																</tr>
																<!--end::Row-->
                                                                <!--begin::Row-->
																<tr>
																	<td class="text-gray-600 min-w-175px w-175px">{{ __('general.username') }}</td>
																	<td class="text-gray-800 fw-bold">{{__getUserNameById($todo->user_id)}}</td>
																</tr>
																<!--end::Row-->
                                                                <!--begin::Row-->
																<tr>
																	<td class="text-gray-600">{{ __('general.created_at') }}</td>
																	<td class="text-gray-800 fw-bold">{{$todo->created_at}}</td>
																</tr>
																<!--end::Row-->
																<!--begin::Row-->
																<tr>
																	<td class="text-gray-600">{{ __('general.priority') }}</td>
																	<td class="fw-bold min-w-200px">
																	    <span class="text-light fs-5 badge 
																	        @if($todo->priority == 'normal') bg-primary
																	        @elseif($todo->priority == 'important') bg-warning
																	        @elseif($todo->priority == 'urgent') bg-danger
																	        @endif">
																	        {{ $todo->priority }}
																	    </span>
																	</td>
																</tr>
																<!--end::Row-->
                                                                <!--begin::Row-->
																<tr>
																	<td class="text-gray-600">{{ __('general.description') }}</td>
																	<td class="text-gray-800 fw-bold">{{$todo->description}}</td>
																</tr>
																<!--end::Row-->
															</table>
															<!--end::Details-->
														</div>
														<!--end::Row-->
													</div>
													<!--end::Row-->
												</div>
												<!--end::Section-->
											</div>
											<!--end::Card body-->
										</div>
										<!--end::Card-->
										<!--begin::todoItems-->
                                        <div class="card pt-4 mb-6 mb-xl-9">
                                            <!--begin::Card header-->
                                            <div class="card-header border-0">
                                                <!--begin::Card title-->
                                                <div class="card-title">
                                                    <h2>{{ __('general.session_todo_list_items') }}</h2>
                                                </div>
                                                <!--end::Card title-->
											
                                                <!--begin::Card toolbar-->
                                                <div class="card-toolbar">
                                                    <div class="d-flex align-items-center gap-2 gap-lg-3">
														@include('utility.todoItem.create',['todo' => $todo] )
                                                        <a href="#" class="btn btn-flex btn-primary h-40px fs-7 fw-bold" data-bs-toggle="modal" data-bs-target="#kt_modal_new_target_create_todoItem">{{ __('general.create_new_todoItem') }}</a>
                                                    </div>
                                                </div>
                                                <!--end::Card toolbar-->
                                            </div>
                                            <!--end::Card header-->
                                            <!--begin::Card body-->
                                            <div class="card-body pt-0 pb-5">
                                                <!--begin::Table-->
                                                 <table class="table align-middle table-row-dashed kt-datatable gy-3"
        										    id="kt_table_customers_payment">
        										    <thead class="border-bottom border-gray-200 fs-7 fw-bold">
        										        <tr class="text-muted text-uppercase gs-0">
        										            <th class="text-start min-w-50px">#</th>
        										            <th class="text-start min-w-100px">{{ __('general.subject') }}</th>
        										            <th class="text-start">{{ __('general.date') }}</th>
        										            <th class="text-start">{{ __('general.status') }}</th>
        										            <th class="text-start min-w-100px">{{ __('general.created_at') }}</th>
        										            <th class="text-end min-w-100px pe-4">{{ __('general.actions') }}</th>
        										        </tr>
        										    </thead>
        										    <tbody class="fs-6 fw-semibold text-gray-800">
        										        @foreach($todoItems as $todoItem)
													
        										        @include('utility.todoItem.show', ['todoItem' => $todoItem, 'modalId' => "kt_modal_new_target_todoItem_show_{$todoItem->id}"])
        										        @include('utility.todoItem.edit', ['todoItem' => $todoItem, 'modalId' => "kt_modal_new_target_todoItem_edit_{$todoItem->id}"])
        										      
													
        										        <tr>
        										            <td>
        										                {{ $todoItem->id }}</a>
        										            </td>
        										            <td class="text-start"><a href="#" class="text-gray-800 text-hover-primary mb-1" data-bs-toggle="modal" data-bs-target="#kt_modal_new_target_todoItem_show_{{ $todoItem->id }}">{{$todoItem->subject}}</a></td>
        										            <td class="text-start">{{ $todoItem->date }}</td>
        										            <td class="text-start">
        										                <div class="badge 
																	{{ $todoItem->status === 'pending' ? 'badge-light-primary' : '' }}
																	{{ $todoItem->status === 'completed' ? 'badge-light-success' : '' }}
																	{{ $todoItem->status === 'passed' ? 'badge-light-danger' : '' }}">
																	{{ __('general.' . $todoItem->status) }}
																</div>
        										            </td>
        										            <td class="text-start">{{ $todoItem->created_at }}</td>
        										            <td class="pe-0 text-end">
        										                <a href="#"
        										                    class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary"
        										                    data-kt-menu-trigger="click"
        										                    data-kt-menu-placement="bottom-end">{{ __('general.actions') }}
        										                    <i class="ki-outline ki-down fs-5 ms-1"></i></a>
        										                <!--begin::Menu-->
        										                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4"
        										                    data-kt-menu="true">
        										                    <!--begin::Menu item-->
																    <div class="menu-item px-3">
																    	<a href="#" data-bs-toggle="modal" data-bs-target="#kt_modal_new_target_todoItem_show_{{ $todoItem->id }}"
																    		class="menu-link px-3">{{ __('general.view') }}</a>
																    </div>
																    <!--end::Menu item-->
																    <!--begin::Menu item-->
																    <div class="menu-item px-3">
																    	<a href="#" data-bs-toggle="modal" data-bs-target="#kt_modal_new_target_todoItem_edit_{{ $todoItem->id }}"
																    		class="menu-link px-3">{{ __('general.edit') }}</a>
																    </div>
																    <!--end::Menu item-->
																    <!--begin::Menu item-->
																    <div class="menu-item px-3">
        										                        <form id="delete-form-{{ $todoItem->id }}" action="{{ route('todoItems.destroy', $todoItem->id) }}" method="POST">
																    		@csrf
																    		@method('DELETE')
																    		<div class="menu-item">
																    			<button type="button" onclick="showConfirmation('{{ addslashes($todoItem->message) }}', '{{ $todoItem->id }}');" class="dropdown-item menu-link fw-bold text-danger">{{ __('general.delete') }}</button>
																    		</div>
																    	</form>
																    </div>
																    <!--end::Menu item-->
        										                </div>
        										                <!--end::Menu-->
        										            </td>
        										        </tr>
        										        @endforeach
        										    </tbody>
        										    <!--end::Table body-->
        										</table>
                                                <!--end::Table-->
                                            </div>
                                            <!--end::Card body-->
                                        </div>
                                        <!--end::todoItems-->
									</div>
									<!--end::Content-->
								</div>
								<!--end::Layout-->
							</div>
							<!--end::Content container-->
						</div>
						<!--end::Content-->
					</div>
					<!--end::Content wrapper-->
					<!--begin::Footer-->
					@include('layout._footer')
					<!--end::Footer-->
				</div>
				<!--end:::Main-->
				<!--begin::aside-->
				@include('layout._side_shortcuts')
				<!--end::aside-->
			</div>
			<!--end::Wrapper-->
		</div>
		<!--end::Page-->
	</div>
	<!--end::App-->
	
	@include('layout._scroll_top')

	<!--begin::Javascript-->
	@include('assets._main_scripts')
	@include('assets._form_scripts')	
	@include('assets._data_table_scripts')
	<!--end::Javascript-->
</body>
<!--end::Body-->

</html>