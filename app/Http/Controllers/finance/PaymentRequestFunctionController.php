<?php

namespace App\Http\Controllers\finance;

use App\Http\Controllers\Controller;
use App\Models\finance\PaymentRequest;
use Illuminate\Http\Request;

class PaymentRequestFunctionController extends Controller
{
    public function calculate_paymentRequest_number()
    {
        $lastPaymentRequest = PaymentRequest::orderBy('number', 'desc')->first();
        $nextPaymentRequestNumber = $lastPaymentRequest ? $lastPaymentRequest->number + 1 : 1;

        // Keep checking until an unused number is found
        while (PaymentRequest::where('number', $nextPaymentRequestNumber)->exists()) {
            $nextPaymentRequestNumber++;
        }

        return $nextPaymentRequestNumber;
    }

    public function paymentRequest_convert_paid($id)
    {
        $paymentRequest = PaymentRequest::find($id);
        $paymentRequest->status = 'paid';
        $paymentRequest->save();
        return redirect()->route('paymentRequests.index')->with('success', 'PaymentRequest status changed successfully');
    }

    public function paymentRequest_convert_partially_paid($id)
    {
        $paymentRequest = PaymentRequest::find($id);
        $paymentRequest->status = 'partially_paid';
        $paymentRequest->save();
        return redirect()->route('paymentRequests.index')->with('success', 'PaymentRequest status changed successfully');
    }

    public function paymentRequest_convert_unpaid($id)
    {
        $paymentRequest = PaymentRequest::find($id);
        $paymentRequest->status = 'unpaid';
        $paymentRequest->save();
        return redirect()->route('paymentRequests.index')->with('success', 'PaymentRequest status changed successfully');
    }

    public function paymentRequest_convert_overdue($id)
    {
        $paymentRequest = PaymentRequest::find($id);
        $paymentRequest->status = 'overdue';
        $paymentRequest->save();
        return redirect()->route('paymentRequests.index')->with('success', 'PaymentRequest status changed successfully');
    }

    public function paymentRequest_convert_draft($id)
    {
        $paymentRequest = PaymentRequest::find($id);
        $paymentRequest->status = 'draft';
        $paymentRequest->save();
        return redirect()->route('paymentRequests.index')->with('success', 'PaymentRequest status changed successfully');
    }
}
