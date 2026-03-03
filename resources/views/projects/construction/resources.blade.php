<!DOCTYPE html>
@if (app()->getLocale() == 'ar')
	@include('assets._language_ar')
@else
	@include('assets._language_en')
@endif
<head>
	<title>Link Masr | Resource Breakdown</title>
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
<body id="kt_app_body" class="app-default">
	@include('assets.dark_mode')
	<div class="d-flex flex-column flex-root app-root" id="kt_app_root">
		<div class="app-page flex-column flex-column-fluid" id="kt_app_page">
			@include('layout._header')
			<div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">
				@include('layout._side_bar')
				<div class="app-main flex-column flex-row-fluid" id="kt_app_main">
					<div class="d-flex flex-column flex-column-fluid">
						<div id="kt_app_toolbar" class="app-toolbar pt-6 pb-2">
							<div class="app-container container-fluid d-flex align-items-stretch">
                                <div class="app-toolbar-wrapper d-flex flex-stack flex-wrap gap-4 w-100">
                                    <div class="page-title d-flex flex-column justify-content-center gap-1 me-3">
                                        <h1 class="page-heading d-flex flex-column justify-content-center text-gray-900 fw-bold fs-1 m-0">
                                            Resources: {{ $boqItem->code }} - {{ $boqItem->item_description }}
                                        </h1>
                                        <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0">
                                            <li class="breadcrumb-item text-muted"><a href="{{ route('projects.construction.index', $project->id) }}" class="text-muted text-hover-primary">Back to BOQ</a></li>
                                        </ul>
                                    </div>
                                    <div class="d-flex align-items-center gap-2 gap-lg-3">
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal_add_resource">
                                            Add Resource
                                        </button>
                                        <a href="{{ route('projects.construction.index', $project->id) }}" class="btn btn-secondary">Back</a>
                                    </div>
                                </div>
							</div>
						</div>
						
						<div id="kt_app_content" class="app-content flex-column-fluid">
							<div id="kt_app_content_container" class="app-container container-fluid">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
                                                <thead>
                                                    <tr class="fw-bold text-muted">
                                                        <th>Type</th>
                                                        <th>Description</th>
                                                        <th>Consumption Rate</th>
                                                        <th>Unit Cost</th>
                                                        <th>Cost per BOQ Unit</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($resources as $res)
                                                    <tr>
                                                        <td>{{ $res->type }}</td>
                                                        <td>{{ $res->description }}</td>
                                                        <td>{{ $res->consumption_rate }}</td>
                                                        <td>{{ number_format($res->unit_cost, 2) }}</td>
                                                        <td>{{ number_format($res->consumption_rate * $res->unit_cost, 2) }}</td>
                                                    </tr>
                                                    @endforeach
                                                    
                                                    @if($resources->isEmpty())
                                                    <tr>
                                                        <td colspan="5" class="text-center text-muted">No resources defined yet.</td>
                                                    </tr>
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
							</div>
						</div>
					</div>
					@include('layout._footer')
				</div>
				@include('layout._side_shortcuts')
			</div>
		</div>
	</div>
	
    <!-- Modal: Add Resource -->
    <div class="modal fade" id="modal_add_resource" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <div class="modal-content">
                <form action="{{ route('projects.construction.resources.store', ['project' => $project->id, 'boq' => $boqItem->id]) }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h2 class="fw-bold">Add Resource</h2>
                        <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                            <i class="ki-outline ki-cross fs-1"></i>
                        </div>
                    </div>
                    <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                        <div class="d-flex flex-column scroll-y me-n7 pe-7">
                            <div class="fv-row mb-7">
                                <label class="required fw-semibold fs-6 mb-2">Type</label>
                                <select name="type" class="form-select form-select-solid" required>
                                    <option value="Material">Material</option>
                                    <option value="Labor">Labor</option>
                                    <option value="Equipment">Equipment</option>
                                    <option value="Subcontractor">Subcontractor</option>
                                </select>
                            </div>
                            <div class="fv-row mb-7">
                                <label class="required fw-semibold fs-6 mb-2">Description</label>
                                <input type="text" name="description" class="form-control form-control-solid" placeholder="e.g. Cement, Excavator..." required />
                            </div>
                            <div class="row">
                                <div class="col-md-6 fv-row mb-7">
                                    <label class="required fw-semibold fs-6 mb-2">Consumption Rate</label>
                                    <input type="number" step="0.0001" name="consumption_rate" class="form-control form-control-solid" placeholder="Qty per BOQ Unit" required />
                                </div>
                                <div class="col-md-6 fv-row mb-7">
                                    <label class="required fw-semibold fs-6 mb-2">Unit Cost</label>
                                    <input type="number" step="0.01" name="unit_cost" class="form-control form-control-solid" placeholder="Cost per Resource Unit" required />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Resource</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
	@include('layout._scroll_top')
	@include('assets._main_scripts')
</body>
</html>
