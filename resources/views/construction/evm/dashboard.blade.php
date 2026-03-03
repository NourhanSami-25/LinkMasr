@extends('layout.app')

@section('title')
    {{ __('إدارة القيمة المكتسبة (EVM)') }}
@endsection

@section('styles')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script src="https://code.iconify.design/3/3.1.0/iconify.min.js"></script>
<style>
    /* ========================================
       Modern Minimal Card Design System
       ======================================== */
    
    /* Primary Metrics - Row 1 */
    .metric-card {
        background: #ffffff;
        border-radius: 16px;
        padding: 2rem;
        height: 100%;
        border: 1px solid rgba(0,0,0,0.04);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        transition: all 0.25s ease;
    }
    
    .metric-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 40px rgba(0,0,0,0.1);
    }
    
    .metric-card .metric-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1.25rem;
    }
    
    .metric-card .metric-icon {
        width: 56px;
        height: 56px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .metric-card .metric-label {
        font-size: 1.1rem;
        color: #1e293b;
        font-weight: 700;
    }
    
    .metric-card .metric-value {
        font-size: 2.75rem;
        font-weight: 700;
        line-height: 1;
        margin-bottom: 0.5rem;
    }
    
    .metric-card .metric-unit {
        font-size: 0.875rem;
        color: #94a3b8;
        font-weight: 500;
    }
    
    /* Color Variants */
    .metric-blue .metric-icon { color: #3b82f6; }
    .metric-blue .metric-value { color: #1e40af; }
    
    .metric-amber .metric-icon { color: #f59e0b; }
    .metric-amber .metric-value { color: #b45309; }
    
    .metric-emerald .metric-icon { color: #10b981; }
    .metric-emerald .metric-value { color: #047857; }
    
    .metric-violet .metric-icon { color: #8b5cf6; }
    .metric-violet .metric-value { color: #5b21b6; }
    
    /* Performance Indicators - Row 2 */
    .indicator-card {
        background: #ffffff;
        border-radius: 16px;
        padding: 1.5rem 1.75rem;
        height: 100%;
        border: 1px solid rgba(0,0,0,0.04);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        transition: all 0.25s ease;
    }
    
    .indicator-card:hover {
        box-shadow: 0 8px 30px rgba(0,0,0,0.1);
    }
    
    .indicator-card .indicator-content {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }
    
    .indicator-card .indicator-label {
        font-size: 1.1rem;
        color: #1e293b;
        font-weight: 700;
    }
    
    .indicator-card .indicator-value {
        font-size: 1.75rem;
        font-weight: 700;
    }
    
    /* Indicator Colors */
    .indicator-teal .indicator-value { color: #0f766e; }
    .indicator-amber .indicator-value { color: #b45309; }
    .indicator-indigo .indicator-value { color: #4338ca; }
    .indicator-pink .indicator-value { color: #be185d; }
    
    /* Chart & Table Cards */
    .content-card {
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid rgba(0,0,0,0.04);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        overflow: hidden;
    }
    
    .content-card .card-header {
        background: transparent;
        border-bottom: 1px solid #f1f5f9;
        padding: 1.25rem 1.75rem;
    }
    
    .content-card .card-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: #1e293b;
        margin: 0;
    }
    
    .content-card .card-body {
        padding: 1.5rem;
    }
    
    /* Table Styles */
    .content-card .table {
        font-size: 1rem;
        margin-bottom: 0;
    }
    
    .content-card .table thead th {
        font-size: 0.95rem;
        font-weight: 700;
        color: #1e293b;
        padding: 1.25rem 1.5rem;
        background: #f8fafc;
        border: none;
    }
    
    .content-card .table tbody td {
        font-size: 1rem;
        padding: 1.25rem 1.5rem;
        color: #334155;
        border-color: #f1f5f9;
    }
    
    .content-card .table tfoot td {
        font-size: 1rem;
        padding: 1.25rem 1.5rem;
        background: #f1f5f9;
        border: none;
    }
    
    .content-card .table thead th:first-child,
    .content-card .table tbody td:first-child,
    .content-card .table tfoot td:first-child {
        padding-right: 2.5rem;
    }
    
    .content-card .table thead th:last-child,
    .content-card .table tbody td:last-child,
    .content-card .table tfoot td:last-child {
        padding-left: 2.5rem;
    }
    
    .content-card .table-responsive {
        border-radius: 12px;
        overflow: hidden;
        margin: 1.5rem;
    }
    
    .content-card .btn.btn-success {
        font-size: 1rem;
        font-weight: 600;
        padding: 0.75rem 1.5rem;
        border-radius: 14px;
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
    }
</style>
@endsection

@section('content')
<!-- Primary Metrics - Row 1 -->
<div class="row g-4 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="metric-card metric-blue">
            <div class="metric-header">
                <span class="metric-label">{{ __('الموازنة الكلية') }}</span>
                <div class="metric-icon">
                    <span class="iconify" data-icon="solar:calendar-bold-duotone" data-width="40" data-height="40"></span>
                </div>
            </div>
            <div class="metric-value">{{ number_format($summary['bac'], 0) }}</div>
            <div class="metric-unit">{{ __('جنيه مصري') }}</div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6">
        <div class="metric-card metric-amber">
            <div class="metric-header">
                <span class="metric-label">{{ __('القيمة المخططة') }}</span>
                <div class="metric-icon">
                    <span class="iconify" data-icon="solar:notebook-bold-duotone" data-width="40" data-height="40"></span>
                </div>
            </div>
            <div class="metric-value">{{ number_format($summary['pv'], 0) }}</div>
            <div class="metric-unit">{{ __('جنيه مصري') }}</div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6">
        <div class="metric-card metric-emerald">
            <div class="metric-header">
                <span class="metric-label">{{ __('القيمة المكتسبة') }}</span>
                <div class="metric-icon">
                    <span class="iconify" data-icon="solar:verified-check-bold-duotone" data-width="40" data-height="40"></span>
                </div>
            </div>
            <div class="metric-value">{{ number_format($summary['ev'], 0) }}</div>
            <div class="metric-unit">{{ __('جنيه مصري') }}</div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6">
        <div class="metric-card metric-violet">
            <div class="metric-header">
                <span class="metric-label">{{ __('التكلفة الفعلية') }}</span>
                <div class="metric-icon">
                    <span class="iconify" data-icon="solar:calendar-mark-bold-duotone" data-width="40" data-height="40"></span>
                </div>
            </div>
            <div class="metric-value">{{ number_format($summary['ac'], 0) }}</div>
            <div class="metric-unit">{{ __('جنيه مصري') }}</div>
        </div>
    </div>
</div>

<!-- Performance Indicators - Row 2 -->
<div class="row g-4 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="indicator-card indicator-teal">
            <div class="indicator-content">
                <span class="indicator-label">{{ __('انحراف التكلفة') }}</span>
                <span class="indicator-value">{{ number_format($summary['cv'], 0) }}</span>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6">
        <div class="indicator-card indicator-amber">
            <div class="indicator-content">
                <span class="indicator-label">{{ __('انحراف الجدول') }}</span>
                <span class="indicator-value">{{ number_format($summary['sv'], 0) }}</span>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6">
        <div class="indicator-card indicator-indigo">
            <div class="indicator-content">
                <span class="indicator-label">{{ __('مؤشر أداء التكلفة') }}</span>
                <span class="indicator-value">{{ number_format($summary['cpi'], 2) }}</span>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6">
        <div class="indicator-card indicator-pink">
            <div class="indicator-content">
                <span class="indicator-label">{{ __('مؤشر أداء الجدول') }}</span>
                <span class="indicator-value">{{ number_format($summary['spi'], 2) }}</span>
            </div>
        </div>
    </div>
</div>

<!-- S-Curve Chart -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card content-card">
            <div class="card-header">
                <h4 class="card-title">{{ __('منحنى S - تتبع الأداء') }}</h4>
            </div>
            <div class="card-body">
                <canvas id="sCurveChart" height="80"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Cost Control Table -->
<div class="row">
    <div class="col-12">
        <div class="card content-card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title">{{ __('جدول التحكم في التكلفة') }}</h4>
                <button class="btn btn-success" onclick="exportToExcel()">
                    <i class="bi bi-file-earmark-excel-fill"></i> {{ __('تصدير') }}
                </button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle" id="costControlTable">
                        <thead class="table-light">
                            <tr>
                                <th>{{ __('البند') }}</th>
                                <th>{{ __('الكمية المخططة') }}</th>
                                <th>{{ __('الكمية الفعلية') }}</th>
                                <th>{{ __('سعر الوحدة') }}</th>
                                <th>{{ __('PV') }}</th>
                                <th>{{ __('EV') }}</th>
                                <th>{{ __('AC') }}</th>
                                <th>{{ __('CV') }}</th>
                                <th>{{ __('SV') }}</th>
                                <th>{{ __('CPI') }}</th>
                                <th>{{ __('SPI') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($costControlData as $item)
                            <tr>
                                <td><strong>{{ $item['item_name'] }}</strong></td>
                                <td>{{ number_format($item['planned_qty'], 2) }} {{ $item['unit'] }}</td>
                                <td>{{ number_format($item['actual_qty'], 2) }} {{ $item['unit'] }}</td>
                                <td>{{ number_format($item['unit_price'], 2) }}</td>
                                <td>{{ number_format($item['pv'], 2) }}</td>
                                <td class="fw-bold text-success">{{ number_format($item['ev'], 2) }}</td>
                                <td class="fw-bold text-danger">{{ number_format($item['ac'], 2) }}</td>
                                <td class="{{ $item['cv'] >= 0 ? 'text-success' : 'text-danger' }}">{{ number_format($item['cv'], 2) }}</td>
                                <td class="{{ $item['sv'] >= 0 ? 'text-success' : 'text-danger' }}">{{ number_format($item['sv'], 2) }}</td>
                                <td class="{{ $item['cpi'] >= 1 ? 'text-success' : 'text-danger' }}">{{ number_format($item['cpi'], 2) }}</td>
                                <td class="{{ $item['spi'] >= 1 ? 'text-success' : 'text-danger' }}">{{ number_format($item['spi'], 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="table-secondary fw-bold">
                            <tr>
                                <td colspan="4">{{ __('الإجمالي') }}</td>
                                <td>{{ number_format($summary['pv'], 2) }}</td>
                                <td>{{ number_format($summary['ev'], 2) }}</td>
                                <td>{{ number_format($summary['ac'], 2) }}</td>
                                <td class="{{ $summary['cv'] >= 0 ? 'text-success' : 'text-danger' }}">{{ number_format($summary['cv'], 2) }}</td>
                                <td class="{{ $summary['sv'] >= 0 ? 'text-success' : 'text-danger' }}">{{ number_format($summary['sv'], 2) }}</td>
                                <td class="{{ $summary['cpi'] >= 1 ? 'text-success' : 'text-danger' }}">{{ number_format($summary['cpi'], 2) }}</td>
                                <td class="{{ $summary['spi'] >= 1 ? 'text-success' : 'text-danger' }}">{{ number_format($summary['spi'], 2) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
const ctx = document.getElementById('sCurveChart').getContext('2d');
const chartData = @json($chartData);

new Chart(ctx, {
    type: 'line',
    data: {
        labels: chartData.dates,
        datasets: [
            { label: 'القيمة المخططة (PV)', data: chartData.pv, borderColor: '#8b5cf6', backgroundColor: 'rgba(139, 92, 246, 0.1)', borderDash: [5, 5], borderWidth: 2, tension: 0.4, fill: true },
            { label: 'القيمة المكتسبة (EV)', data: chartData.ev, borderColor: '#10b981', backgroundColor: 'rgba(16, 185, 129, 0.1)', borderWidth: 3, tension: 0.4, fill: true },
            { label: 'التكلفة الفعلية (AC)', data: chartData.ac, borderColor: '#f43f5e', backgroundColor: 'rgba(244, 63, 94, 0.1)', borderWidth: 2, tension: 0.4, fill: true }
        ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        interaction: { mode: 'index', intersect: false },
        plugins: {
            legend: { position: 'top', labels: { font: { size: 13, family: 'Cairo, sans-serif' }, usePointStyle: true, padding: 20 } },
            tooltip: { 
                backgroundColor: '#1e293b',
                padding: 12,
                cornerRadius: 8,
                callbacks: { label: function(context) { return context.dataset.label + ': ' + new Intl.NumberFormat('ar-EG').format(context.parsed.y) + ' جنيه'; } } 
            }
        },
        scales: {
            y: { 
                beginAtZero: true, 
                grid: { color: 'rgba(0,0,0,0.04)' },
                ticks: { callback: function(value) { return new Intl.NumberFormat('ar-EG', { notation: 'compact' }).format(value); } }
            },
            x: { grid: { display: false } }
        }
    }
});

function exportToExcel() {
    const table = document.getElementById('costControlTable');
    const wb = XLSX.utils.table_to_book(table, {sheet: 'Cost Control'});
    XLSX.writeFile(wb, 'cost_control_{{ $project->id }}_{{ date("Y-m-d") }}.xlsx');
}
</script>
<script src="https://cdn.sheetjs.com/xlsx-0.20.1/package/dist/xlsx.full.min.js"></script>
@endsection
