<?php
namespace App\Services\finance;

use App\Models\finance\Invoice;
use App\Models\finance\PaymentRequest;
use App\Models\finance\CreditNote;
use App\Models\finance\Expense;
use App\Models\finance\Pyment;
use App\Models\client\Client;
use Illuminate\Support\Collection;
use App\Models\setting\ExchangeRate;
use App\Models\setting\CompanyProfile;

class FinanceService
{
    public function getAll(?string $type = null): array
{
    $records = collect();
    $totals = [
        'invoice' => 0,
        'expense' => 0,
        'payment_request' => 0,
        'credit_note' => 0,
        'payment' => 0,
    ];



    if (!$type || $type === 'invoice') {
        $baseCurrency = CompanyProfile::first()->currency ?? 'QAR';

        $invoices = Invoice::select('id', 'number', 'client_name', 'total', 'currency', 'status', 'created_at')
            ->get()
            ->map(function ($item) use (&$totals, $baseCurrency) {
                // get exchange rate for this invoice currency
                $rate = ExchangeRate::where('currency', $item->currency)->value('rate');

                // if invoice currency == base currency → no conversion
                if (strtoupper($item->currency) === strtoupper($baseCurrency)) {
                    $convertedTotal = $item->total;
                } else {
                    // if rate not found, keep original
                    $convertedTotal = $rate ? $item->total * $rate : $item->total;
                }

                $item->converted_total = $convertedTotal;
                $item->type = 'invoice';
                $totals['invoice'] += $convertedTotal;

                return $item;
            });

        $records = $records->merge($invoices);
    }


    if (!$type || $type === 'expense') {
        $baseCurrency = CompanyProfile::first()->currency ?? 'QAR';
    
        $expenses = Expense::select('id', 'number', 'client_name', 'total', 'currency', 'status', 'created_at')
            ->get()
            ->map(function ($item) use (&$totals, $baseCurrency) {
                // get exchange rate for this expense currency
                $rate = ExchangeRate::where('currency', $item->currency)->value('rate');
            
                // if expense currency == base currency → no conversion
                if (strtoupper($item->currency) === strtoupper($baseCurrency)) {
                    $convertedTotal = $item->total;
                } else {
                    // if rate not found, keep original
                    $convertedTotal = $rate ? $item->total * $rate : $item->total;
                }
            
                $item->converted_total = $convertedTotal;
                $item->type = 'expense';
                $totals['expense'] += $convertedTotal;
            
                return $item;
            });
        
        $records = $records->merge($expenses);
    }

    if (!$type || $type === 'payment_request') {
        $baseCurrency = CompanyProfile::first()->currency ?? 'QAR';
    
        $paymentRequests = PaymentRequest::select('id', 'number', 'client_name', 'total', 'currency', 'status', 'created_at')
            ->get()
            ->map(function ($item) use (&$totals, $baseCurrency) {
                // get exchange rate for this payment_request currency
                $rate = ExchangeRate::where('currency', $item->currency)->value('rate');
            
                // if payment_request currency == base currency → no conversion
                if (strtoupper($item->currency) === strtoupper($baseCurrency)) {
                    $convertedTotal = $item->total;
                } else {
                    // if rate not found, keep original
                    $convertedTotal = $rate ? $item->total * $rate : $item->total;
                }
            
                $item->converted_total = $convertedTotal;
                $item->type = 'payment_request';
                $totals['payment_request'] += $convertedTotal;
            
                return $item;
            });
        
        $records = $records->merge($paymentRequests);
    }

    if (!$type || $type === 'credit_note') {
        $baseCurrency = CompanyProfile::first()->currency ?? 'QAR';
    
        $creditNotes = CreditNote::select('id', 'number', 'client_name', 'total', 'currency', 'status', 'created_at')
            ->get()
            ->map(function ($item) use (&$totals, $baseCurrency) {
                // get exchange rate for this credit_note currency
                $rate = ExchangeRate::where('currency', $item->currency)->value('rate');
            
                // if credit_note currency == base currency → no conversion
                if (strtoupper($item->currency) === strtoupper($baseCurrency)) {
                    $convertedTotal = $item->total;
                } else {
                    // if rate not found, keep original
                    $convertedTotal = $rate ? $item->total * $rate : $item->total;
                }
            
                $item->converted_total = $convertedTotal;
                $item->type = 'credit_note';
                $totals['credit_note'] += $convertedTotal;
            
                return $item;
            });
        
        $records = $records->merge($creditNotes);
    }

    if (!$type || $type === 'payment') {
        $baseCurrency = CompanyProfile::first()->currency ?? 'QAR';
    
        $payments = Pyment::select('id', 'number', 'client_name', 'total', 'currency', 'status', 'created_at')
            ->get()
            ->map(function ($item) use (&$totals, $baseCurrency) {
                // get exchange rate for this payment currency
                $rate = ExchangeRate::where('currency', $item->currency)->value('rate');
            
                // if payment currency == base currency → no conversion
                if (strtoupper($item->currency) === strtoupper($baseCurrency)) {
                    $convertedTotal = $item->total;
                } else {
                    // if rate not found, keep original
                    $convertedTotal = $rate ? $item->total * $rate : $item->total;
                }
            
                $item->converted_total = $convertedTotal;
                $item->type = 'payment';
                $totals['payment'] += $convertedTotal;
            
                return $item;
            });
        
        $records = $records->merge($payments);
    }

    return [
        'records' => $records->sortByDesc('created_at')->values(),
        'totals' => $totals,
    ];
}

}
