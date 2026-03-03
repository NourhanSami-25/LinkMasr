<!DOCTYPE html>

@if (app()->getLocale() == 'ar')
	@include('assets._language_ar')
@else
	@include('assets._language_en')
@endif

<head>

	<title>Link Masr | Project Details</title>
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
	


	<!--begin::Custom Styles-->
	
	<!--end::Custom Styles-->

	

</head>

<body id="kt_app_body" data-kt-app-header-fixed="true" data-kt-app-header-fixed-mobile="true"
	data-kt-app-sidebar-enabled="true" data-kt-app-sidebar-fixed="true" data-kt-app-sidebar-hoverable="true"
	data-kt-app-sidebar-push-toolbar="true" data-kt-app-sidebar-push-footer="true" data-kt-app-toolbar-enabled="true"
	data-kt-app-aside-enabled="true" data-kt-app-aside-fixed="true" data-kt-app-aside-push-toolbar="true"
	data-kt-app-aside-push-footer="true" class="app-default" data-kt-app-sidebar-minimize="on">
	<!--begin::Theme mode setup on page load-->
	
	<!--end::Theme mode setup on page load-->
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
											{{ __('general.project_details') }}</h1>
										<!--end::Title-->
										<!--begin::Breadcrumb-->
										<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0">
											<!--begin::Item-->
											
											<li class="breadcrumb-item text-muted">
												<a href="#" class="text-muted text-hover-primary">{{ __('general.home') }}</a>
											</li>
											<!--end::Item-->
											<!--begin::Item-->
											<li class="breadcrumb-item">
												<span class="bullet bg-gray-500 w-5px h-2px"></span>
											</li>
											<!--end::Item-->
											<!--begin::Item-->
											<li class="breadcrumb-item text-muted">
												<a href="{{ route('projects.index')}}" class="text-muted text-hover-primary">{{ __('general.projects') }}</a>
											</li>
											<!--end::Item-->
											<!--begin::Item-->
											<li class="breadcrumb-item">
												<span class="bullet bg-gray-500 w-5px h-2px"></span>
											</li>
											<!--end::Item-->
											<!--begin::Item-->
											<li class="breadcrumb-item text-muted">{{ __('general.project_details') }}</li>
											<!--end::Item-->
										</ul>
										<!--end::Breadcrumb-->
									</div>
									<!--end::Page title-->
									<!--begin::Actions-->
									<div class="d-flex align-items-center gap-2 gap-lg-3">
										<!--begin::Action menu-->
										<a href="#" class="btn btn-primary ps-7" data-kt-menu-trigger="click"
										data-kt-menu-attach="parent"
										data-kt-menu-placement="bottom-end">{{ __('general.actions') }}
										<i class="ki-outline ki-down fs-2 me-0"></i></a>
                                        <!-- Construction Module Link -->
                                        <a href="{{ route('projects.construction.index', $project->id) }}" class="btn btn-success ps-7">
                                            <i class="ki-outline ki-abstract-26 fs-2 me-2"></i> Construction
                                        </a>
										<a href="{{ route('projects.index')}}" class="btn btn-danger ps-7">{{ __('general.back') }}</a>
										<!--begin::Menu-->
										<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold py-4 w-250px fs-6"
										data-kt-menu="true">
										<!--begin::Menu item-->
										{{-- <div class="menu-item px-5">
											<a href="#" class="menu-link px-5">{{ __('general.invoice_project') }}</a>
										</div> --}}
										<!--end::Menu item-->
										{{-- <!--begin::Menu item-->
										<div class="menu-item px-5">
											<a href="#" data-bs-toggle="modal" data-bs-target="#kt_modal_new_target_update_status" class="menu-link flex-stack px-5">{{ __('general.update_status') }}
												<span class="ms-2" data-bs-toggle="tooltip"
													title="Specify a target name for future usage and reference">
												</span></a>
										</div>
										<!--end::Menu item--> --}}
										
										{{-- <!--begin::Menu separator-->
										<div class="separator my-3"></div>
										<!--end::Menu separator--> --}}
										<!--begin::Menu item-->
										<div class="menu-item px-5">
											<a href="#" class="menu-link px-5">{{ __('general.print') }}</a>
										</div>
										<!--end::Menu item-->
										<!--begin::Menu item-->
										<div class="menu-item px-5">
											<a href="#" class="menu-link px-5">{{ __('general.download') }}</a>
										</div>
										<!--end::Menu item-->
										<!--begin::Menu item-->
										<div class="menu-item px-5">
											<a href="{{route('projects.edit' , $project->id)}}" class="menu-link px-5">{{ __('general.edit') }}</a>
										</div>
										<!--end::Menu item-->
										<!--begin::Menu item-->
										<div class="menu-item px-5 my-1">
											<a href="#" class="menu-link px-5">{{ __('general.delete') }}</a>
										</div>
										<!--end::Menu item-->
									</div>
									<!--end::Menu-->
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
								<div class="d-flex flex-column flex-xl-row">
									<!--begin::Content-->
									<div class="flex-lg-row-fluid">
										<!--begin:::Tabs-->
										<ul
											class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-6 fw-semibold mb-5">
											<!--begin:::Tab item-->
											<li class="nav-item">
												<a class="nav-link text-active-primary pb-4 active" data-bs-toggle="tab"
													href="#kt_customer_view_overview_tab">{{ __('general.overview') }}</a>
											</li>
											<!--end:::Tab item-->
											
											<!--begin:::Tab item-->
											{{-- <li class="nav-item">
												<a class="nav-link text-active-primary pb-4" data-kt-countup-tabs="true"
													data-bs-toggle="tab"
													href="#kt_customer_view_updates">{{ __('general.updates') }}</a>
											</li> --}}
											<!--end:::Tab item-->
											<!--begin:::Tab item-->
											<li class="nav-item">
												<a class="nav-link text-active-primary pb-4" data-bs-toggle="tab"
													href="#kt_project_view_tasks">{{ __('general.tasks') }}</a>
											</li>
											<!--end:::Tab item-->
											<!--begin:::Tab item-->
											<li class="nav-item">
												<a class="nav-link text-active-primary pb-4" data-bs-toggle="tab"
													href="#kt_project_view_files">{{ __('general.files') }}</a>
											</li>
											<!--end:::Tab item-->
											<!--begin:::Tab item-->
											<li class="nav-item">
												<a class="nav-link text-active-primary pb-4" data-bs-toggle="tab"
													href="#kt_project_view_reminders">{{ __('general.reminders') }}</a>
											</li>
											<!--end:::Tab item-->
											<!--begin:::Tab item-->
											<li class="nav-item">
												<a class="nav-link text-active-primary pb-4" data-kt-countup-tabs="true"
													data-bs-toggle="tab"
													href="#kt_project_view_notes">{{ __('general.notes') }}</a>
											</li>
											<!--end:::Tab item-->
											<!--begin:::Tab item-->
											<li class="nav-item">
												<a class="nav-link text-active-primary pb-4" data-bs-toggle="tab"
													href="#kt_task_view_discussion">{{ __('general.discussion') }}</a>
											</li>
											<!--end:::Tab item-->
											<!--begin:::Tab item - Construction-->
											<li class="nav-item">
												<a class="nav-link text-active-primary pb-4" data-bs-toggle="tab"
													href="#kt_project_view_construction">
													<i class="fa-solid fa-hard-hat me-2"></i>{{ __('general.construction') ?? 'Construction' }}
												</a>
											</li>
											<!--end:::Tab item-->
											<!--begin:::Tab item - Partners-->
											<li class="nav-item">
												<a class="nav-link text-active-primary pb-4" data-bs-toggle="tab"
													href="#kt_project_view_partners">
													<i class="fa-solid fa-handshake me-2"></i>{{ __('general.partners') ?? 'Partners' }}
												</a>
											</li>
											<!--end:::Tab item-->
											<!--begin:::Tab item - Financials-->
											<li class="nav-item">
												<a class="nav-link text-active-primary pb-4" data-bs-toggle="tab"
													href="#kt_project_view_financials">
													<i class="fa-solid fa-chart-pie me-2"></i>{{ __('general.financials') ?? 'Financials' }}
												</a>
											</li>
											<!--end:::Tab item-->
											<!--begin:::Tab item - Drawings-->
											<li class="nav-item">
												<a class="nav-link text-active-primary pb-4" data-bs-toggle="tab"
													href="#kt_project_view_drawings">
													<i class="fa-solid fa-drafting-compass me-2"></i>{{ __('general.drawings') ?? 'Drawings' }}
												</a>
											</li>
											<!--end:::Tab item-->
										</ul>
										<!--end:::Tabs-->
										<!--begin:::Tab content-->
										<div class="tab-content" id="myTabContent">
											<!--begin:::Tab pane-->
											@include('project._show_overview')
											<!--end:::Tab pane-->
											<!--begin:::Tab pane-->
											@include('project._show_tasks')
											<!--end:::Tab pane-->
											
											<!--begin:::Tab pane-->
											{{-- @include('project._show_updates') --}}
											<!--end:::Tab pane-->
											<!--begin:::Tab pane-->
											@include('project._show_files')
											<!--end:::Tab pane-->
											<!--begin:::Tab pane-->
											@include('project._show_reminders')
											<!--end:::Tab pane-->
											<!--begin:::Tab pane-->
											@include('project._show_notes')
											<!--end:::Tab pane-->
											<!--begin:::Tab pane-->
											<div class="tab-pane fade" id="kt_task_view_discussion" role="tabpanel">
												@include('common.discussion.index', ['discussion' => $project->discussion])
											</div>
											<!--end:::Tab pane-->

											<!--begin:::Tab pane - Construction-->
											<div class="tab-pane fade" id="kt_project_view_construction" role="tabpanel">
												<div class="card">
													<div class="card-header">
														<h3 class="card-title">{{ __('general.construction_management') ?? 'Construction Management' }}</h3>
														<div class="card-toolbar">
															<a href="{{ route('projects.construction.index', $project->id) }}" class="btn btn-sm btn-primary">
																<i class="fa-solid fa-external-link me-2"></i>{{ __('general.open_full_view') ?? 'Open Full View' }}
															</a>
														</div>
													</div>
													<div class="card-body">
														<div class="row g-5">
															<!-- BOQ Summary -->
															<div class="col-md-4">
																<div class="card bg-light-primary">
																	<div class="card-body">
																		<div class="d-flex align-items-center">
																			<i class="fa-solid fa-list-check fs-2x text-primary me-3"></i>
																			<div>
																				<div class="fs-4 fw-bold">{{ $project->boqItems->count() ?? 0 }}</div>
																				<div class="fs-7 text-muted">BOQ Items</div>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
															<!-- Budget -->
															<div class="col-md-4">
																<div class="card bg-light-success">
																	<div class="card-body">
																		<div class="d-flex align-items-center">
																			<i class="fa-solid fa-coins fs-2x text-success me-3"></i>
																			<div>
																				<div class="fs-4 fw-bold">{{ number_format($project->boqItems->sum('total_price') ?? 0, 2) }}</div>
																				<div class="fs-7 text-muted">Total Budget (BAC)</div>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
															<!-- Progress -->
															<div class="col-md-4">
																<div class="card bg-light-warning">
																	<div class="card-body">
																		<div class="d-flex align-items-center">
																			<i class="fa-solid fa-chart-line fs-2x text-warning me-3"></i>
																			<div>
																				<div class="fs-4 fw-bold">EVM</div>
																				<div class="fs-7 text-muted">Cost Control</div>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
														</div>
														<div class="mt-5">
															<a href="{{ route('projects.construction.index', $project->id) }}" class="btn btn-primary w-100">
																<i class="fa-solid fa-hard-hat me-2"></i>Go to Construction Management
															</a>
														</div>
													</div>
												</div>
											</div>
											<!--end:::Tab pane-->

											<!--begin:::Tab pane - Partners-->
											<div class="tab-pane fade" id="kt_project_view_partners" role="tabpanel">
												<div class="card">
													<div class="card-header">
														<h3 class="card-title">{{ __('general.project_partners') ?? 'Project Partners' }}</h3>
														<div class="card-toolbar">
															<button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modal_add_partner">
																<i class="fa-solid fa-plus me-2"></i>{{ __('general.add_partner') ?? 'Add Partner' }}
															</button>
														</div>
													</div>
													<div class="card-body">
														<div class="table-responsive">
															<table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
																<thead>
																	<tr class="fw-bold text-muted">
																		<th>{{ __('general.partner_name') ?? 'Partner Name' }}</th>
																		<th>{{ __('general.share_percentage') ?? 'Share %' }}</th>
																		<th>{{ __('general.management_fee') ?? 'Mgmt Fee %' }}</th>
																		<th>{{ __('general.partner_share') ?? 'Partner Share' }}</th>
																	</tr>
																</thead>
																<tbody>
																	@forelse($project->partners ?? [] as $partner)
																	<tr>
																		<td>{{ $partner->name }}</td>
																		<td>{{ $partner->pivot->share_percentage }}%</td>
																		<td>{{ $partner->pivot->management_fee_percentage }}%</td>
																		<td class="text-success fw-bold">-</td>
																	</tr>
																	@empty
																	<tr>
																		<td colspan="4" class="text-center text-muted">{{ __('general.no_partners') ?? 'No partners added yet' }}</td>
																	</tr>
																	@endforelse
																</tbody>
															</table>
														</div>
														<a href="{{ route('projects.partners', $project->id) }}" class="btn btn-light-primary w-100 mt-3">
															<i class="fa-solid fa-external-link me-2"></i>View Full Partners Management
														</a>
													</div>
												</div>
											</div>
											<!--end:::Tab pane-->

											<!--begin:::Tab pane - Financials-->
											<div class="tab-pane fade" id="kt_project_view_financials" role="tabpanel">
												<div class="card">
													<div class="card-header">
														<h3 class="card-title">{{ __('general.financial_overview') ?? 'Financial Overview' }}</h3>
													</div>
													<div class="card-body">
														<div class="row g-5">
															<!-- Revenue -->
															<div class="col-md-4">
																<div class="card bg-light-success">
																	<div class="card-body text-center">
																		<i class="fa-solid fa-arrow-trend-up fs-2x text-success mb-2"></i>
																		<div class="fs-2 fw-bold text-success">{{ number_format($project->invoices->where('status', 'paid')->sum('total') ?? 0, 2) }}</div>
																		<div class="fs-7 text-muted">{{ __('general.revenue') ?? 'Revenue' }}</div>
																	</div>
																</div>
															</div>
															<!-- OPEX -->
															<div class="col-md-4">
																<div class="card bg-light-warning">
																	<div class="card-body text-center">
																		<i class="fa-solid fa-coins fs-2x text-warning mb-2"></i>
																		<div class="fs-2 fw-bold text-warning">{{ number_format($project->expenses->where('category', 'operational')->sum('total') ?? 0, 2) }}</div>
																		<div class="fs-7 text-muted">{{ __('general.operational_expenses') ?? 'OPEX' }}</div>
																	</div>
																</div>
															</div>
															<!-- CAPEX -->
															<div class="col-md-4">
																<div class="card bg-light-info">
																	<div class="card-body text-center">
																		<i class="fa-solid fa-building fs-2x text-info mb-2"></i>
																		<div class="fs-2 fw-bold text-info">{{ number_format($project->expenses->where('category', 'capital')->sum('total') ?? 0, 2) }}</div>
																		<div class="fs-7 text-muted">{{ __('general.capital_expenses') ?? 'CAPEX' }}</div>
																	</div>
																</div>
															</div>
														</div>
														<a href="{{ route('projects.financials', $project->id) }}" class="btn btn-light-primary w-100 mt-5">
															<i class="fa-solid fa-external-link me-2"></i>View Full Financial Report
														</a>
													</div>
												</div>
											</div>
											<!--end:::Tab pane-->

											<!--begin:::Tab pane - Drawings-->
											<div class="tab-pane fade" id="kt_project_view_drawings" role="tabpanel">
												<div class="card">
													<div class="card-header">
														<h3 class="card-title">{{ __('general.project_drawings') ?? 'Project Drawings' }}</h3>
														<div class="card-toolbar">
															<a href="{{ route('projects.drawings', $project->id) }}" class="btn btn-sm btn-primary">
																<i class="fa-solid fa-plus me-2"></i>{{ __('general.manage_drawings') ?? 'Manage Drawings' }}
															</a>
														</div>
													</div>
													<div class="card-body">
														<div class="row g-5">
															@forelse($project->drawings ?? [] as $drawing)
															<div class="col-md-4">
																<div class="card border border-dashed">
																	<div class="card-body text-center">
																		<i class="fa-solid fa-drafting-compass fs-2x text-primary mb-3"></i>
																		<div class="fw-bold">{{ $drawing->title }}</div>
																		<div class="badge badge-light-primary">{{ $drawing->type }}</div>
																	</div>
																</div>
															</div>
															@empty
															<div class="col-12">
																<div class="text-center text-muted py-10">
																	<i class="fa-solid fa-drafting-compass fs-3x text-muted mb-3"></i>
																	<p>{{ __('general.no_drawings') ?? 'No drawings uploaded yet' }}</p>
																	<a href="{{ route('projects.drawings', $project->id) }}" class="btn btn-primary">
																		<i class="fa-solid fa-upload me-2"></i>Upload Drawings
																	</a>
																</div>
															</div>
															@endforelse
														</div>
													</div>
												</div>
											</div>
											<!--end:::Tab pane-->
											
										</div>
										<!--end:::Tab content-->
									</div>
									<!--end::Content-->
								</div>
								<!--end::Layout-->
								<!--begin::Modals-->
								@include('project._update_status')
								
								<!-- Modal: Add Partner -->
								<div class="modal fade" id="modal_add_partner" tabindex="-1" aria-hidden="true">
									<div class="modal-dialog modal-dialog-centered">
										<div class="modal-content">
											<form action="{{ route('projects.partners.store', $project->id) }}" method="POST">
												@csrf
												<div class="modal-header">
													<h2 class="fw-bold">{{ __('general.add_partner') ?? 'Add Partner' }}</h2>
													<div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
														<i class="ki-outline ki-cross fs-1"></i>
													</div>
												</div>
												<div class="modal-body">
													<div class="fv-row mb-7">
														<label class="required fw-semibold fs-6 mb-2">{{ __('general.select_user') ?? 'Select User' }}</label>
														<select name="partner_id" class="form-select form-select-solid" required>
															<option value="">-- Select --</option>
															@foreach(\App\Models\user\User::all() as $user)
																<option value="{{ $user->id }}">{{ $user->name }}</option>
															@endforeach
														</select>
													</div>
													<div class="fv-row mb-7">
														<label class="required fw-semibold fs-6 mb-2">{{ __('general.share_percentage') ?? 'Share Percentage (%)' }}</label>
														<input type="number" step="0.01" name="share_percentage" class="form-control form-control-solid" required />
													</div>
													<div class="fv-row mb-7">
														<label class="fw-semibold fs-6 mb-2">{{ __('general.management_fee') ?? 'Management Fee (%)' }}</label>
														<input type="number" step="0.01" name="management_fee_percentage" class="form-control form-control-solid" value="0" />
													</div>
												</div>
												<div class="modal-footer">
													<button type="button" class="btn btn-light" data-bs-dismiss="modal">{{ __('general.close') ?? 'Close' }}</button>
													<button type="submit" class="btn btn-primary">{{ __('general.save') ?? 'Save' }}</button>
												</div>
											</form>
										</div>
									</div>
								</div>
								<!--end::Modals-->
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
	
	<!--begin::Scrolltop-->
	@include('layout._scroll_top')
	<!--end::Scrolltop-->
	
	<!--begin::Javascript-->
	@include('assets._main_scripts')
	@include('assets._form_scripts')
	@include('assets._data_table_scripts')
	@include('assets._file_scripts')
	@include('assets._discussion_scripts')
	@include('assets._taps_script')
	<!--end::Javascript-->
</body>
<!--end::Body-->

</html>