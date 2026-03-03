<?php

namespace App\Http\Controllers\finance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\finance\CreditNote;


class CreditNoteFunctionController extends Controller
{
    public function calculate_creditNote_number()
    {
        $lastCreditNote = CreditNote::orderBy('number', 'desc')->first();
        $nextCreditNoteNumber = $lastCreditNote ? $lastCreditNote->number + 1 : 1;

        // Keep checking until an unused number is found
        while (CreditNote::where('number', $nextCreditNoteNumber)->exists()) {
            $nextCreditNoteNumber++;
        }

        return $nextCreditNoteNumber;
    }

    public function creditNote_convert_paid($id)
    {
        $creditNote = CreditNote::find($id);
        $creditNote->status = 'paid';
        $creditNote->save();
        return redirect()->back()->with('success', 'CreditNote status changed successfully');
    }

    public function creditNote_convert_partially_paid($id)
    {
        $creditNote = CreditNote::find($id);
        $creditNote->status = 'partially_paid';
        $creditNote->save();
        return redirect()->back()->with('success', 'CreditNote status changed successfully');
    }

    public function creditNote_convert_unpaid($id)
    {
        $creditNote = CreditNote::find($id);
        $creditNote->status = 'unpaid';
        $creditNote->save();
        return redirect()->back()->with('success', 'CreditNote status changed successfully');
    }

    public function creditNote_convert_overdue($id)
    {
        $creditNote = CreditNote::find($id);
        $creditNote->status = 'overdue';
        $creditNote->save();
        return redirect()->back()->with('success', 'CreditNote status changed successfully');
    }

    public function creditNote_convert_draft($id)
    {
        $creditNote = CreditNote::find($id);
        $creditNote->status = 'draft';
        $creditNote->save();
        return redirect()->back()->with('success', 'CreditNote status changed successfully');
    }
}
