<!DOCTYPE html>
@if (app()->getLocale() == 'ar')
	@include('assets._language_ar')
@else
	@include('assets._language_en')
@endif
<head>
	<title>Link Masr | Construction Management</title>
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
                                            Construction Management: {{ $project->name }}
                                        </h1>
                                        <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0">
                                            <li class="breadcrumb-item text-muted"><a href="{{ route('projects.index') }}" class="text-muted text-hover-primary">Projects</a></li>
                                            <li class="breadcrumb-item"><span class="bullet bg-gray-500 w-5px h-2px"></span></li>
                                            <li class="breadcrumb-item text-muted"><a href="{{ route('projects.show', $project->id) }}" class="text-muted text-hover-primary">{{ $project->name }}</a></li>
                                            <li class="breadcrumb-item"><span class="bullet bg-gray-500 w-5px h-2px"></span></li>
                                            <li class="breadcrumb-item text-muted">Construction</li>
                                        </ul>
                                    </div>
                                    <div class="d-flex align-items-center gap-2 gap-lg-3">
                                        <a href="{{ route('projects.show', $project->id) }}" class="btn btn-secondary">Back to Project</a>
                                    </div>
                                </div>
							</div>
						</div>
						
						<div id="kt_app_content" class="app-content flex-column-fluid">
							<div id="kt_app_content_container" class="app-container container-fluid">
                                <div class="card">
                                    <div class="card-header card-header-stretch">
                                        <h3 class="card-title">{{ __('general.Project Control') }}</h3>
                                        <div class="card-toolbar">
                                            <ul class="nav nav-tabs nav-line-tabs nav-stretch fs-6 border-0">
                                                <li class="nav-item">
                                                    <a class="nav-link active" data-bs-toggle="tab" href="#tab_boq">{{ __('general.BOQ & Breakdown') }}</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" data-bs-toggle="tab" href="#tab_cost_control">{{ __('general.Cost Control (EVM)') }}</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" data-bs-toggle="tab" href="#tab_dashboard">{{ __('general.Dashboard & S-Curve') }}</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="tab-content" id="myTabContent">
                                            <!-- BOQ TAB -->
                                            <div class="tab-pane fade show active" id="tab_boq" role="tabpanel">
                                                <div class="d-flex justify-content-end mb-4">
                                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal_add_boq">
                                                        Add BOQ Item
                                                    </button>
                                                </div>
                                                <div class="table-responsive">
                                                    <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
                                                        <thead>
                                                            <tr class="fw-bold text-muted">
                                                                <th>Code</th>
                                                                <th>Description</th>
                                                                <th>Unit</th>
                                                                <th>Qty</th>
                                                                <th>Rate</th>
                                                                <th>Total (BAC)</th>
                                                                <th>Start</th>
                                                                <th>End</th>
                                                                <th>Actions</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($boqItems as $item)
                                                            <tr>
                                                                <td>{{ $item->code }}</td>
                                                                <td>{{ $item->item_description }}</td>
                                                                <td>{{ $item->unit }}</td>
                                                                <td>{{ $item->quantity }}</td>
                                                                <td>{{ number_format($item->unit_price, 2) }}</td>
                                                                <td>{{ number_format($item->total_price, 2) }}</td>
                                                                <td>{{ $item->start_date }}</td>
                                                                <td>{{ $item->end_date }}</td>
                                                                <td>
                                                                    <a href="{{ route('projects.construction.resources', ['project' => $project->id, 'boq' => $item->id]) }}" class="btn btn-sm btn-light btn-active-light-primary">Breakdown</a>
                                                                </td>
                                                            </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                            <!-- COST CONTROL TAB -->
                                            <div class="tab-pane fade" id="tab_cost_control" role="tabpanel">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-striped align-middle gs-0 gy-4">
                                                        <thead class="bg-light">
                                                            <tr class="fw-bold text-gray-800">
                                                                <th rowspan="2">Item</th>
                                                                <th colspan="3" class="text-center">Values (Currency)</th>
                                                                <th colspan="2" class="text-center">Variances</th>
                                                                <th colspan="2" class="text-center">Indices</th>
                                                            </tr>
                                                            <tr class="fw-bold text-gray-800">
                                                                <th>PV (Planned)</th>
                                                                <th>EV (Earned)</th>
                                                                <th>AC (Actual)</th>
                                                                <th>CV (Cost)</th>
                                                                <th>SV (Schedule)</th>
                                                                <th>CPI</th>
                                                                <th>SPI</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($boqItems as $item)
                                                            @php $metrics = $evmData[$item->id] ?? []; @endphp
                                                            <tr>
                                                                <td>{{ $item->code }} - {{ $item->item_description }}</td>
                                                                <td>{{ number_format($metrics['PV'] ?? 0, 2) }}</td>
                                                                <td>{{ number_format($metrics['EV'] ?? 0, 2) }}</td>
                                                                <td>{{ number_format($metrics['AC'] ?? 0, 2) }}</td>
                                                                
                                                                <td class="{{ ($metrics['CV'] ?? 0) < 0 ? 'text-danger' : 'text-success' }}">
                                                                    {{ number_format($metrics['CV'] ?? 0, 2) }}
                                                                </td>
                                                                <td class="{{ ($metrics['SV'] ?? 0) < 0 ? 'text-danger' : 'text-success' }}">
                                                                    {{ number_format($metrics['SV'] ?? 0, 2) }}
                                                                </td>
                                                                
                                                                <td class="{{ ($metrics['CPI'] ?? 0) < 1 ? 'text-danger fw-bold' : 'text-success' }}">
                                                                    {{ number_format($metrics['CPI'] ?? 0, 2) }}
                                                                </td>
                                                                <td class="{{ ($metrics['SPI'] ?? 0) < 1 ? 'text-danger fw-bold' : 'text-success' }}">
                                                                    {{ number_format($metrics['SPI'] ?? 0, 2) }}
                                                                </td>
                                                            </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                            <!-- DASHBOARD TAB -->
                                            <div class="tab-pane fade" id="tab_dashboard" role="tabpanel">
                                                <div class="alert alert-info">S-Curve Visualization</div>
                                                <!-- Canvas for S-Curve -->
                                                <div style="height: 400px;">
                                                    <canvas id="evmSCurveChart"></canvas>
                                                </div>
                                            </div>
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
	@include('layout._scroll_top')
	@include('assets._main_scripts')

    <!-- Chart.js CDN (Assuming not bundled, else use existing asset) -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var ctx = document.getElementById('evmSCurveChart').getContext('2d');
            var chartData = @json($chartData);

            var myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: chartData.labels,
                    datasets: [
                        {
                            label: 'Planned Value (PV)',
                            data: chartData.pv,
                            borderColor: 'blue',
                            fill: false,
                            tension: 0.1
                        },
                        {
                            label: 'Earned Value (EV)',
                            data: chartData.ev,
                            borderColor: 'green',
                            fill: false,
                            tension: 0.1
                        },
                        {
                            label: 'Actual Cost (AC)',
                            data: chartData.ac,
                            borderColor: 'red',
                            fill: false,
                            tension: 0.1,
                            borderDash: [5, 5]
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Cumulative Cost (Currency)'
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Project Timeline'
                            }
                        }
                    }
                }
            });
        });
    </script>
    
    <!-- Modal: Add BOQ -->
    <div class="modal fade" id="modal_add_boq" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <div class="modal-content">
                <form action="{{ route('projects.construction.boq.store', $project->id) }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h2 class="fw-bold">Add BOQ Item</h2>
                        <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                            <i class="ki-outline ki-cross fs-1"></i>
                        </div>
                    </div>
                    <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                        <div class="d-flex flex-column scroll-y me-n7 pe-7">
                            <div class="fv-row mb-7">
                                <label class="required fw-semibold fs-6 mb-2">Item Code</label>
                                <input type="text" name="code" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="e.g. 001-C" required />
                            </div>
                            <div class="fv-row mb-7">
                                <label class="required fw-semibold fs-6 mb-2">Description</label>
                                <input type="text" name="item_description" class="form-control form-control-solid mb-3 mb-lg-0" required />
                            </div>
                            <div class="row">
                                <div class="col-md-6 fv-row mb-7">
                                    <label class="required fw-semibold fs-6 mb-2">Unit</label>
                                    <input type="text" name="unit" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="m3" required />
                                </div>
                                <div class="col-md-6 fv-row mb-7">
                                    <label class="required fw-semibold fs-6 mb-2">Quantity</label>
                                    <input type="number" step="0.01" name="quantity" class="form-control form-control-solid mb-3 mb-lg-0" required />
                                </div>
                            </div>
                            <div class="fv-row mb-7">
                                <label class="required fw-semibold fs-6 mb-2">Unit Rate (Budget)</label>
                                <input type="number" step="0.01" name="unit_price" class="form-control form-control-solid mb-3 mb-lg-0" required />
                            </div>
                            <div class="row">
                                <div class="col-md-6 fv-row mb-7">
                                    <label class="fw-semibold fs-6 mb-2">Start Date</label>
                                    <input type="date" name="start_date" class="form-control form-control-solid mb-3 mb-lg-0" />
                                </div>
                                <div class="col-md-6 fv-row mb-7">
                                    <label class="fw-semibold fs-6 mb-2">End Date</label>
                                    <input type="date" name="end_date" class="form-control form-control-solid mb-3 mb-lg-0" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Item</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
