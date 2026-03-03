@extends('layout.app')

@section('title', __('general.construction') ?? 'Construction')
@section('page_title', __('general.construction_projects') ?? 'Construction Projects')

@section('breadcrumb')
    <li class="breadcrumb-item text-muted">
        <a href="{{ route('home') }}" class="text-muted text-hover-primary">{{ __('general.home_breadcrumb') }}</a>
    </li>
    <li class="breadcrumb-item text-muted">{{ __('general.construction') ?? 'Construction' }}</li>
@endsection

@section('content')
<!-- Help Button -->
<div class="d-flex justify-content-end mb-4">
    <button class="btn btn-light-info" type="button" data-bs-toggle="offcanvas" data-bs-target="#helpOffcanvas">
        <i class="fa fa-question-circle me-2"></i> {{ __('general.help') ?? 'Help' }}
    </button>
</div>

<div class="card">
    <div class="card-header border-0 pt-6">
        <div class="card-title">
            <h3>{{ __('general.construction_projects') ?? 'Construction Projects - BOQ & EVM' }}</h3>
        </div>
    </div>
    <div class="card-body pt-0">
        @if($projects->count() > 0)
        <div class="table-responsive">
            <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
                <thead>
                    <tr class="fw-bold text-muted">
                        <th>#</th>
                        <th>{{ __('general.project') ?? 'Project' }}</th>
                        <th>{{ __('general.client') ?? 'Client' }}</th>
                        <th>{{ __('general.boq_items_count') ?? 'BOQ Items' }}</th>
                        <th>{{ __('general.total_budget') ?? 'Total Budget' }}</th>
                        <th>{{ __('general.cpi') ?? 'CPI' }}</th>
                        <th>{{ __('general.spi') ?? 'SPI' }}</th>
                        <th>{{ __('general.status') ?? 'Status' }}</th>
                        <th>{{ __('general.actions') ?? 'Actions' }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($projects as $project)
                    <tr>
                        <td>{{ $project->id }}</td>
                        <td>
                            <a href="{{ route('construction.boq.index', $project->id) }}" class="text-dark fw-bold text-hover-primary">
                                {{ $project->subject }}
                            </a>
                        </td>
                        <td>{{ $project->client->name ?? '-' }}</td>
                        <td>
                            <span class="badge badge-light-primary">{{ $project->boq_items_count ?? 0 }}</span>
                        </td>
                        <td>{{ number_format($project->evm_summary['bac'] ?? 0, 2) }}</td>
                        <td>
                            @php
                                $cpi = $project->evm_summary['cpi'] ?? 0;
                                $cpiClass = $cpi >= 1 ? 'success' : ($cpi >= 0.9 ? 'warning' : 'danger');
                            @endphp
                            <span class="badge badge-light-{{ $cpiClass }}">{{ number_format($cpi, 2) }}</span>
                        </td>
                        <td>
                            @php
                                $spi = $project->evm_summary['spi'] ?? 0;
                                $spiClass = $spi >= 1 ? 'success' : ($spi >= 0.9 ? 'warning' : 'danger');
                            @endphp
                            <span class="badge badge-light-{{ $spiClass }}">{{ number_format($spi, 2) }}</span>
                        </td>
                        <td>
                            @if(($project->evm_summary['cpi'] ?? 0) >= 1 && ($project->evm_summary['spi'] ?? 0) >= 1)
                                <span class="badge badge-light-success">{{ __('general.on_track') ?? 'On Track' }}</span>
                            @elseif(($project->evm_summary['cpi'] ?? 0) < 0.9 || ($project->evm_summary['spi'] ?? 0) < 0.9)
                                <span class="badge badge-light-danger">{{ __('general.at_risk') ?? 'At Risk' }}</span>
                            @else
                                <span class="badge badge-light-warning">{{ __('general.needs_attention') ?? 'Needs Attention' }}</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex gap-2">
                                <a href="{{ route('construction.boq.index', $project->id) }}" 
                                   class="btn btn-sm btn-light-primary" title="BOQ">
                                    <i class="fa fa-list"></i> BOQ
                                </a>
                                <a href="{{ route('construction.evm.dashboard', $project->id) }}" 
                                   class="btn btn-sm btn-light-info" title="EVM">
                                    <i class="fa fa-chart-line"></i> EVM
                                </a>
                                <a href="{{ route('construction.progress.create', $project->id) }}" 
                                   class="btn btn-sm btn-light-success" title="{{ __('general.add_progress') ?? 'Add Progress' }}">
                                    <i class="fa fa-plus"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="text-center py-10">
            <i class="fa fa-hard-hat fs-3x text-muted mb-5"></i>
            <h4 class="text-muted">{{ __('general.no_construction_projects') ?? 'No Construction Projects Yet' }}</h4>
            <p class="text-gray-500">{{ __('general.create_project_first') ?? 'Create a project first, then add BOQ items to it.' }}</p>
            <a href="{{ route('projects.create') }}" class="btn btn-primary mt-4">
                <i class="fa fa-plus"></i> {{ __('general.create_project') ?? 'Create Project' }}
            </a>
        </div>
        @endif
    </div>
</div>

<div class="card mt-5">
    <div class="card-header">
        <h4 class="card-title">{{ __('general.what_is_evm') ?? 'What is EVM?' }}</h4>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <h5>{{ __('general.evm_metrics') ?? 'EVM Metrics' }}</h5>
                <ul>
                    <li><strong>BAC</strong> - Budget at Completion: {{ __('general.bac_desc') ?? 'Total planned budget for the project' }}</li>
                    <li><strong>PV</strong> - Planned Value: {{ __('general.pv_desc') ?? 'Planned progress based on schedule' }}</li>
                    <li><strong>EV</strong> - Earned Value: {{ __('general.ev_desc') ?? 'Value of work actually completed' }}</li>
                    <li><strong>AC</strong> - Actual Cost: {{ __('general.ac_desc') ?? 'Actual money spent' }}</li>
                </ul>
            </div>
            <div class="col-md-6">
                <h5>{{ __('general.performance_indices') ?? 'Performance Indices' }}</h5>
                <ul>
                    <li><strong>CPI</strong> - Cost Performance Index: {{ __('general.cpi_desc') ?? 'EV/AC - Shows cost efficiency (1.0 = on budget)' }}</li>
                    <li><strong>SPI</strong> - Schedule Performance Index: {{ __('general.spi_desc') ?? 'EV/PV - Shows schedule efficiency (1.0 = on time)' }}</li>
                    <li><strong>CV</strong> - Cost Variance: {{ __('general.cv_desc') ?? 'EV-AC - Positive = under budget' }}</li>
                    <li><strong>SV</strong> - Schedule Variance: {{ __('general.sv_desc') ?? 'EV-PV - Positive = ahead of schedule' }}</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Help Offcanvas -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="helpOffcanvas" style="width: 450px;">
    <div class="offcanvas-header bg-primary">
        <h5 class="offcanvas-title text-white">
            <i class="fa fa-lightbulb me-2"></i> {{ __('general.help_construction') ?? 'Construction Help Guide' }}
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body">
        <div class="accordion" id="helpAccordion">
            <!-- What is this page -->
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#help1">
                        <i class="fa fa-info-circle text-primary me-2"></i> {{ __('general.help_what_is_page') ?? 'What is this page?' }}
                    </button>
                </h2>
                <div id="help1" class="accordion-collapse collapse show" data-bs-parent="#helpAccordion">
                    <div class="accordion-body">
                        <p>{{ __('general.help_construction_intro') ?? 'This page shows all your construction projects with their Budget (BOQ) and Earned Value Management (EVM) metrics.' }}</p>
                        <ul class="mb-0">
                            <li>{{ __('general.help_construction_view_all') ?? 'View all construction projects at a glance' }}</li>
                            <li>{{ __('general.help_construction_monitor') ?? 'Monitor project performance using EVM indicators' }}</li>
                            <li>{{ __('general.help_construction_track') ?? 'Track budget vs actual spending' }}</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- How to use BOQ -->
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#help2">
                        <i class="fa fa-list text-success me-2"></i> {{ __('general.help_boq_title') ?? 'How to use BOQ?' }}
                    </button>
                </h2>
                <div id="help2" class="accordion-collapse collapse" data-bs-parent="#helpAccordion">
                    <div class="accordion-body">
                        <ol>
                            <li><strong>{{ __('general.help_boq_step1') ?? 'Create a project' }}</strong> - {{ __('general.help_boq_step1_desc') ?? 'First create a project from Projects menu' }}</li>
                            <li><strong>{{ __('general.help_boq_step2') ?? 'Add BOQ items' }}</strong> - {{ __('general.help_boq_step2_desc') ?? 'Click BOQ button to add bill of quantities items' }}</li>
                            <li><strong>{{ __('general.help_boq_step3') ?? 'Enter quantities & prices' }}</strong> - {{ __('general.help_boq_step3_desc') ?? 'Fill in unit prices and quantities for each item' }}</li>
                            <li><strong>{{ __('general.help_boq_step4') ?? 'Track progress' }}</strong> - {{ __('general.help_boq_step4_desc') ?? 'Record actual progress to update EVM calculations' }}</li>
                        </ol>
                    </div>
                </div>
            </div>

            <!-- Understanding EVM -->
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#help3">
                        <i class="fa fa-chart-line text-info me-2"></i> {{ __('general.help_evm_title') ?? 'Understanding EVM Indicators' }}
                    </button>
                </h2>
                <div id="help3" class="accordion-collapse collapse" data-bs-parent="#helpAccordion">
                    <div class="accordion-body">
                        <div class="d-flex align-items-center mb-3">
                            <span class="badge badge-light-success me-2 fs-6">CPI ≥ 1</span>
                            <span>{{ __('general.help_cpi_good') ?? 'Under budget - spending less than planned' }}</span>
                        </div>
                        <div class="d-flex align-items-center mb-3">
                            <span class="badge badge-light-danger me-2 fs-6">CPI < 1</span>
                            <span>{{ __('general.help_cpi_bad') ?? 'Over budget - spending more than planned' }}</span>
                        </div>
                        <div class="d-flex align-items-center mb-3">
                            <span class="badge badge-light-success me-2 fs-6">SPI ≥ 1</span>
                            <span>{{ __('general.help_spi_good') ?? 'Ahead of schedule - progressing faster' }}</span>
                        </div>
                        <div class="d-flex align-items-center mb-3">
                            <span class="badge badge-light-danger me-2 fs-6">SPI < 1</span>
                            <span>{{ __('general.help_spi_bad') ?? 'Behind schedule - progressing slower' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Status meanings -->
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#help4">
                        <i class="fa fa-flag text-warning me-2"></i> {{ __('general.help_status_title') ?? 'Project Status Colors' }}
                    </button>
                </h2>
                <div id="help4" class="accordion-collapse collapse" data-bs-parent="#helpAccordion">
                    <div class="accordion-body">
                        <div class="d-flex align-items-center mb-3">
                            <span class="badge badge-light-success me-2">{{ __('general.on_track') ?? 'On Track' }}</span>
                            <span>{{ __('general.help_on_track_desc') ?? 'Project is on budget and on schedule' }}</span>
                        </div>
                        <div class="d-flex align-items-center mb-3">
                            <span class="badge badge-light-warning me-2">{{ __('general.needs_attention') ?? 'Needs Attention' }}</span>
                            <span>{{ __('general.help_attention_desc') ?? 'Minor issues - monitor closely' }}</span>
                        </div>
                        <div class="d-flex align-items-center mb-3">
                            <span class="badge badge-light-danger me-2">{{ __('general.at_risk') ?? 'At Risk' }}</span>
                            <span>{{ __('general.help_at_risk_desc') ?? 'Major issues - immediate action needed' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="alert alert-light-primary mt-4">
            <i class="fa fa-lightbulb me-2"></i>
            <strong>{{ __('general.help_tip') ?? 'Tip' }}:</strong> {{ __('general.help_construction_tip') ?? 'Click on any project name to view detailed BOQ and track progress.' }}
        </div>
    </div>
</div>
@endsection
