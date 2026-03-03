<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $invoice->invoice_no }} - طباعة المستخلص</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            direction: rtl;
            padding: 20px;
            font-size: 12px;
            line-height: 1.6;
        }
        .print-header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
        }
        .print-header h1 {
            font-size: 24px;
            margin-bottom: 10px;
        }
        .print-header h2 {
            font-size: 18px;
            color: #555;
        }
        .info-section {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            gap: 20px;
        }
        .info-box {
            flex: 1;
            border: 1px solid #ddd;
            padding: 15px;
            border-radius: 5px;
        }
        .info-box h3 {
            font-size: 14px;
            margin-bottom: 10px;
            color: #333;
            border-bottom: 1px solid #eee;
            padding-bottom: 5px;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
        }
        .info-label {
            font-weight: bold;
            color: #555;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #333;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #f0f0f0;
            font-weight: bold;
        }
        .text-right {
            text-align: right;
        }
        .text-left {
            text-align: left;
        }
        .totals-table {
            width: 50%;
            margin-right: auto;
            margin-left: 0;
        }
        .totals-table td {
            padding: 10px;
        }
        .totals-table .label {
            text-align: right;
            font-weight: bold;
        }
        .totals-table .value {
            text-align: left;
            font-weight: bold;
        }
        .totals-table .grand-total {
            background-color: #333;
            color: #fff;
            font-size: 14px;
        }
        .notes-section {
            margin-top: 20px;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .notes-section h3 {
            margin-bottom: 10px;
        }
        .signatures {
            display: flex;
            justify-content: space-around;
            margin-top: 50px;
            padding-top: 20px;
        }
        .signature-box {
            text-align: center;
            width: 200px;
        }
        .signature-line {
            border-top: 1px solid #333;
            margin-top: 60px;
            padding-top: 10px;
        }
        .status-badge {
            display: inline-block;
            padding: 5px 15px;
            border-radius: 20px;
            font-weight: bold;
            margin-top: 10px;
        }
        .status-draft { background: #f0f0f0; color: #666; }
        .status-submitted { background: #fff3cd; color: #856404; }
        .status-certified { background: #cce5ff; color: #004085; }
        .status-invoiced { background: #d4edda; color: #155724; }
        .status-paid { background: #d1ecf1; color: #0c5460; }
        
        @media print {
            body { padding: 0; }
            .no-print { display: none; }
        }
    </style>
</head>
<body>
    <div class="no-print" style="text-align: center; margin-bottom: 20px;">
        <button onclick="window.print()" style="padding: 10px 30px; font-size: 16px; cursor: pointer;">
            طباعة
        </button>
        <button onclick="window.close()" style="padding: 10px 30px; font-size: 16px; cursor: pointer; margin-right: 10px;">
            إغلاق
        </button>
    </div>

    <div class="print-header">
        <h1>مستخلص أعمال</h1>
        <h2>{{ $invoice->invoice_no }}</h2>
        <span class="status-badge status-{{ $invoice->status }}">
            @switch($invoice->status)
                @case('draft') مسودة @break
                @case('submitted') مقدم للاعتماد @break
                @case('certified') معتمد @break
                @case('invoiced') مفوتر @break
                @case('paid') مدفوع @break
            @endswitch
        </span>
    </div>

    <div class="info-section">
        <div class="info-box">
            <h3>معلومات المشروع</h3>
            <div class="info-row">
                <span class="info-label">المشروع:</span>
                <span>{{ $invoice->project->subject ?? '-' }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">العميل:</span>
                <span>{{ $invoice->client->name ?? '-' }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">قيمة العقد:</span>
                <span>{{ number_format($invoice->project->boqItems->sum('total_price') ?? 0, 2) }}</span>
            </div>
        </div>
        <div class="info-box">
            <h3>معلومات المستخلص</h3>
            <div class="info-row">
                <span class="info-label">رقم المستخلص:</span>
                <span>{{ $invoice->invoice_no }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">التسلسل:</span>
                <span>{{ $invoice->sequence_no }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">الفترة:</span>
                <span>{{ $invoice->period_from->format('Y-m-d') }} إلى {{ $invoice->period_to->format('Y-m-d') }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">تاريخ الإنشاء:</span>
                <span>{{ $invoice->created_at->format('Y-m-d') }}</span>
            </div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 5%;">#</th>
                <th style="width: 8%;">الكود</th>
                <th style="width: 25%;">الوصف</th>
                <th style="width: 8%;">الوحدة</th>
                <th style="width: 10%;">الكمية السابقة</th>
                <th style="width: 10%;">الكمية الحالية</th>
                <th style="width: 10%;">الكمية التراكمية</th>
                <th style="width: 10%;">سعر الوحدة</th>
                <th style="width: 14%;">المبلغ الحالي</th>
            </tr>
        </thead>
        <tbody>
            @foreach($invoice->items as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item->boq->code ?? '-' }}</td>
                <td class="text-right">{{ $item->boq->item_description ?? $item->description ?? '-' }}</td>
                <td>{{ $item->boq->unit ?? '-' }}</td>
                <td>{{ number_format($item->previous_qty, 2) }}</td>
                <td>{{ number_format($item->current_qty, 2) }}</td>
                <td>{{ number_format($item->cumulative_qty, 2) }}</td>
                <td>{{ number_format($item->unit_price, 2) }}</td>
                <td>{{ number_format($item->amount ?? ($item->current_qty * $item->unit_price), 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <table class="totals-table">
        <tr>
            <td class="label">إجمالي الأعمال الحالية:</td>
            <td class="value">{{ number_format($invoice->gross_amount, 2) }}</td>
        </tr>
        @if($invoice->retention_amount > 0)
        <tr>
            <td class="label">المحجوز ({{ $invoice->retention_percentage ?? 10 }}%):</td>
            <td class="value" style="color: red;">-{{ number_format($invoice->retention_amount, 2) }}</td>
        </tr>
        @endif
        @if($invoice->advance_deduction > 0)
        <tr>
            <td class="label">خصم الدفعة المقدمة:</td>
            <td class="value" style="color: red;">-{{ number_format($invoice->advance_deduction, 2) }}</td>
        </tr>
        @endif
        @if($invoice->vat_amount > 0)
        <tr>
            <td class="label">ضريبة القيمة المضافة ({{ $invoice->vat_percentage ?? 15 }}%):</td>
            <td class="value">{{ number_format($invoice->vat_amount, 2) }}</td>
        </tr>
        @endif
        <tr class="grand-total">
            <td class="label">صافي المستحق:</td>
            <td class="value">{{ number_format($invoice->net_amount, 2) }}</td>
        </tr>
        @if($invoice->previous_certified > 0)
        <tr>
            <td class="label">المعتمد السابق:</td>
            <td class="value">{{ number_format($invoice->previous_certified, 2) }}</td>
        </tr>
        <tr>
            <td class="label">المستحق الحالي:</td>
            <td class="value">{{ number_format($invoice->net_amount - $invoice->previous_certified, 2) }}</td>
        </tr>
        @endif
    </table>

    @if($invoice->notes)
    <div class="notes-section">
        <h3>ملاحظات:</h3>
        <p>{{ $invoice->notes }}</p>
    </div>
    @endif

    <div class="signatures">
        <div class="signature-box">
            <div class="signature-line">المقاول</div>
        </div>
        <div class="signature-box">
            <div class="signature-line">مهندس المشروع</div>
        </div>
        <div class="signature-box">
            <div class="signature-line">المالك / الاستشاري</div>
        </div>
    </div>

    <script>
        // Auto print on load (optional)
        // window.onload = function() { window.print(); }
    </script>
</body>
</html>
