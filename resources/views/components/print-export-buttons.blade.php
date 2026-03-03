{{-- Print & Export Buttons Component --}}
{{-- Usage: @include('components.print-export-buttons', ['tableId' => 'myTable', 'title' => 'Report Title']) --}}

<div class="d-flex gap-2 flex-wrap" role="group">
    {{-- Print Button --}}
    <button type="button" class="btn btn-light-primary btn-sm" onclick="printTable('{{ $tableId ?? 'printArea' }}', '{{ $title ?? '' }}')">
        <i class="fa fa-print me-1"></i> {{ __('general.print') ?? 'طباعة' }}
    </button>
    
    {{-- Export Excel Button --}}
    <button type="button" class="btn btn-light-success btn-sm" onclick="exportTableToExcel('{{ $tableId ?? 'printArea' }}', '{{ $filename ?? 'export' }}')">
        <i class="fa fa-file-excel me-1"></i> {{ __('general.export_excel') ?? 'Excel' }}
    </button>
    
    {{-- Export PDF Button --}}
    <button type="button" class="btn btn-light-danger btn-sm" onclick="printToPDF('{{ $tableId ?? 'printArea' }}', '{{ $title ?? '' }}')">
        <i class="fa fa-file-pdf me-1"></i> {{ __('general.export_pdf') ?? 'PDF' }}
    </button>
</div>

@once
@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
<script>
// Print Table Function
function printTable(elementId, title) {
    var element = document.getElementById(elementId);
    if (!element) {
        console.error('Element not found:', elementId);
        return;
    }
    
    var printWindow = window.open('', '_blank');
    printWindow.document.write(`
        <!DOCTYPE html>
        <html dir="rtl" lang="ar">
        <head>
            <meta charset="UTF-8">
            <title>${title || 'Print'}</title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
            <style>
                body { 
                    font-family: 'Cairo', 'Segoe UI', Tahoma, sans-serif; 
                    padding: 20px;
                    direction: rtl;
                }
                .table { width: 100%; margin-bottom: 1rem; }
                .table th, .table td { padding: 8px; border: 1px solid #dee2e6; }
                .table thead th { background-color: #f8f9fa; }
                .print-header { 
                    text-align: center; 
                    margin-bottom: 20px;
                    border-bottom: 2px solid #333;
                    padding-bottom: 10px;
                }
                .print-header h2 { margin: 0; color: #333; }
                .print-header p { margin: 5px 0 0; color: #666; font-size: 12px; }
                .badge { 
                    padding: 4px 8px; 
                    border-radius: 4px; 
                    font-size: 11px;
                }
                .bg-success { background: #28a745 !important; color: white; }
                .bg-warning { background: #ffc107 !important; color: black; }
                .bg-info { background: #17a2b8 !important; color: white; }
                .bg-danger { background: #dc3545 !important; color: white; }
                @media print {
                    body { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
                }
            </style>
        </head>
        <body>
            <div class="print-header">
                <h2>${title || document.title}</h2>
                <p>تاريخ الطباعة: ${new Date().toLocaleDateString('ar-EG')}</p>
            </div>
            ${element.outerHTML}
        </body>
        </html>
    `);
    printWindow.document.close();
    setTimeout(() => {
        printWindow.print();
        printWindow.close();
    }, 500);
}

// Export to Excel Function
function exportTableToExcel(tableId, filename) {
    var table = document.getElementById(tableId);
    if (!table) {
        console.error('Table not found:', tableId);
        return;
    }
    
    // Clone table to remove action buttons
    var clonedTable = table.cloneNode(true);
    
    // Remove action columns (usually last column)
    var actionHeaders = clonedTable.querySelectorAll('th:last-child, td:last-child');
    actionHeaders.forEach(function(el) {
        if (el.textContent.includes('الإجراءات') || el.textContent.includes('Actions') || el.querySelector('button, a.btn')) {
            el.remove();
        }
    });
    
    var wb = XLSX.utils.table_to_book(clonedTable, {sheet: "Sheet1"});
    XLSX.writeFile(wb, (filename || 'export') + '_' + new Date().toISOString().slice(0,10) + '.xlsx');
}

// Print to PDF (uses browser print dialog with PDF option)
function printToPDF(elementId, title) {
    // Same as print, user can choose "Save as PDF" in print dialog
    printTable(elementId, title);
}
</script>
@endpush
@endonce
