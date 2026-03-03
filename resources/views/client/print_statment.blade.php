
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <title>{{ __('general.client_statment') }} - {{ $client->name }}</title>
    <meta charset="utf-8" />
    @if (app()->getLocale() == 'ar')
        @include('assets._ar_fonts')
        @include('assets._main_styles_RTL')
    @else
        @include('assets._en_fonts')
        @include('assets._main_styles_LTR')
    @endif
    <style>
        @media print {
            .no-print { display: none !important; }
            body { background: white !important; }
            .card { border: none !important; box-shadow: none !important; }
        }
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-white">
    <div class="container py-10">
        <div class="d-flex flex-stack mb-10">
            <div>
                <h1 class="fw-bolder">{{ __('general.client_statment') }}</h1>
                <h2 class="text-gray-600">{{ $client->name }}</h2>
            </div>
            <div class="text-end">
                <h4 class="fw-bold">{{ $companyProfile->company_name ?? 'Link Masr' }}</h4>
                <p class="text-gray-500">{{ now()->format('Y-m-d H:i') }}</p>
            </div>
        </div>

        <div class="row g-5 mb-10">
            <div class="col-4">
                <div class="border border-dashed border-gray-300 rounded p-5 text-center">
                    <div class="fs-6 fw-bold text-danger">{{ __('general.debit_balance') }}</div>
                    <div class="fs-2x fw-bolder">{{ number_format($debit_balance, 2) }} {{ $companyProfile->currency ?? 'EGP' }}</div>
                </div>
            </div>
            <div class="col-4">
                <div class="border border-dashed border-gray-300 rounded p-5 text-center">
                    <div class="fs-6 fw-bold text-success">{{ __('general.client_payments') }}</div>
                    <div class="fs-2x fw-bolder">{{ number_format($actually_paid, 2) }} {{ $companyProfile->currency ?? 'EGP' }}</div>
                </div>
            </div>
            <div class="col-4">
                <div class="border border-dashed border-gray-300 rounded p-5 text-center">
                    <div class="fs-6 fw-bold text-info">{{ __('general.current_balance') }}</div>
                    <div class="fs-2x fw-bolder">{{ number_format($current_balance, 2) }} {{ $companyProfile->currency ?? 'EGP' }}</div>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table align-middle table-row-dashed fs-6 gy-5">
                <thead>
                    <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                        <th>{{ __('general.date') }}</th>
                        <th>{{ __('general.type') }}</th>
                        <th>{{ __('general.number') }}</th>
                        <th>{{ __('general.status') }}</th>
                        <th>{{ __('general.amount') }}</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 fw-semibold">
                    @foreach($invoices as $item)
                    <tr>
                        <td>{{ $item->date }}</td>
                        <td>{{ __('general.invoice') }}</td>
                        <td>{{ $item->number }}</td>
                        <td>{{ $item->status }}</td>
                        <td>{{ number_format($item->total, 2) }} {{ $item->currency }}</td>
                    </tr>
                    @endforeach
                    @foreach($payments as $item)
                    <tr>
                        <td>{{ $item->date }}</td>
                        <td>{{ __('general.payment') }}</td>
                        <td>{{ $item->number }}</td>
                        <td>{{ $item->status }}</td>
                        <td>{{ number_format($item->total, 2) }} {{ $item->currency }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script>
        window.onload = function() {
            window.print();
        };
    </script>
</body>
</html>
