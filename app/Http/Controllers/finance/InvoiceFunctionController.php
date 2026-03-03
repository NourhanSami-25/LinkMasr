<?php

namespace App\Http\Controllers\finance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\finance\Invoice;
use App\Models\finance\Pyment;


class InvoiceFunctionController extends Controller
{
    public function calculate_invoice_number()
    {
        $lastInvoice = Invoice::orderBy('number', 'desc')->first();
        $nextInvoiceNumber = $lastInvoice ? $lastInvoice->number + 1 : 1;

        // Keep checking until an unused number is found
        while (Invoice::where('number', $nextInvoiceNumber)->exists()) {
            $nextInvoiceNumber++;
        }

        return $nextInvoiceNumber;
    }

    public function invoice_convert_paid($id)
    {
        $invoice = Invoice::find($id);
        $invoice->status = 'paid';
        $invoice->save();
        return redirect()->back()->with('success', 'Invoice status changed successfully');
    }

    public function invoice_convert_partially_paid($id)
    {
        $invoice = Invoice::find($id);
        $invoice->status = 'partially';
        $invoice->save();
        return redirect()->back()->with('success', 'Invoice status changed successfully');
    }

    public function invoice_convert_unpaid($id)
    {
        $invoice = Invoice::find($id);
        $invoice->status = 'unpaid';
        $invoice->save();
        return redirect()->back()->with('success', 'Invoice status changed successfully');
    }

    public function invoice_convert_overdue($id)
    {
        $invoice = Invoice::find($id);
        $invoice->status = 'overdue';
        $invoice->save();
        return redirect()->back()->with('success', 'Invoice status changed successfully');
    }

    public function invoice_convert_draft($id)
    {
        $invoice = Invoice::find($id);
        $invoice->status = 'draft';
        $invoice->save();
        return redirect()->back()->with('success', 'Invoice status changed successfully');
    }
}
