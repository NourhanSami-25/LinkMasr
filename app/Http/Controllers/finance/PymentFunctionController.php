<?php

namespace App\Http\Controllers\finance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\finance\Pyment;
use App\Models\finance\Invoice;
use App\Models\finance\Expense;
use App\Models\finance\PaymentRequest;
use App\Models\finance\CreditNote;


class PymentFunctionController extends Controller
{
    public function calculate_pyment_number()
    {
        $lastPyment = Pyment::orderBy('number', 'desc')->first();
        $nextPymentNumber = $lastPyment ? $lastPyment->number + 1 : 1;

        // Keep checking until an unused number is found
        while (Pyment::where('number', $nextPymentNumber)->exists()) {
            $nextPymentNumber++;
        }

        return $nextPymentNumber;
    }

    public function expense_convert_paid($id)
    {
        $pyment = Pyment::find($id);
        $pyment->status = 'paid';
        $pyment->save();
        
        // Update related finance item status
        $this->updateRelatedFinanceStatus($pyment);
        
        return redirect()->back()->with('success', __('general.payment_status_changed'));
    }

    public function pyment_convert_draft($id)
    {
        $pyment = Pyment::find($id);
        $pyment->status = 'draft';
        $pyment->save();
        
        // Update related finance item status
        $this->updateRelatedFinanceStatus($pyment);
        
        return redirect()->back()->with('success', __('general.payment_status_changed'));
    }

    /**
     * Create payment from finance item with validation and auto-status update
     */
    public function create_pyment_from_finance_item($pymentData, $financeItem = null, $financeType = null)
    {
        $pyment = Pyment::create($pymentData);
        
        // Auto-update the related finance item status
        if ($financeItem && method_exists($financeItem, 'updateStatusBasedOnPayments')) {
            $financeItem->updateStatusBasedOnPayments();
        } elseif ($financeType) {
            $this->updateFinanceStatusByType($pyment, $financeType);
        }
        
        return $pyment;
    }

    /**
     * Update related finance item status based on payment
     */
    private function updateRelatedFinanceStatus(Pyment $pyment): void
    {
        if ($pyment->invoice_id) {
            $invoice = Invoice::find($pyment->invoice_id);
            if ($invoice) {
                $invoice->updateStatusBasedOnPayments();
            }
        }
        
        if ($pyment->expense_id) {
            $expense = Expense::find($pyment->expense_id);
            if ($expense) {
                $expense->updateStatusBasedOnPayments();
            }
        }
        
        if ($pyment->pymentRequest_id) {
            $paymentRequest = PaymentRequest::find($pyment->pymentRequest_id);
            if ($paymentRequest) {
                $paymentRequest->updateStatusBasedOnPayments();
            }
        }
    }

    /**
     * Update finance status by type after payment creation
     */
    private function updateFinanceStatusByType(Pyment $pyment, string $financeType): void
    {
        switch ($financeType) {
            case 'invoice':
                if ($pyment->invoice_id) {
                    $invoice = Invoice::find($pyment->invoice_id);
                    if ($invoice) $invoice->updateStatusBasedOnPayments();
                }
                break;
            case 'expense':
                if ($pyment->expense_id) {
                    $expense = Expense::find($pyment->expense_id);
                    if ($expense) $expense->updateStatusBasedOnPayments();
                }
                break;
            case 'paymentRequest':
                if ($pyment->pymentRequest_id) {
                    $paymentRequest = PaymentRequest::find($pyment->pymentRequest_id);
                    if ($paymentRequest) $paymentRequest->updateStatusBasedOnPayments();
                }
                break;
        }
    }

    /**
     * Validate payment amount doesn't exceed remaining balance
     */
    public function validatePaymentAmount($financeItem, float $paymentAmount): array
    {
        $remainingBalance = $financeItem->remaining_balance ?? $financeItem->total;
        
        if ($paymentAmount > $remainingBalance) {
            return [
                'valid' => false,
                'message' => __('general.payment_exceeds_remaining_balance', [
                    'amount' => $paymentAmount,
                    'remaining' => $remainingBalance
                ])
            ];
        }
        
        if ($paymentAmount <= 0) {
            return [
                'valid' => false,
                'message' => __('general.payment_amount_must_be_positive')
            ];
        }
        
        return ['valid' => true, 'message' => ''];
    }

    public function get_pyment_data_from_finance_item($finance, $financeType)
    {

        $pyment_number = $this->calculate_pyment_number();
        $pyment = [];

        $pyment = [
            'client_name' => $finance->client_name,
            'number' => $pyment_number,
            'subject' => $finance->description,
            'total' => $finance->total,
            'date' => $finance->date,
            'currency' => $finance->currency,
            'payment_mode' => 'Cash',
            'payment_method' => 'Cash',
            'transaction_number' => 'None',
            'note' => $finance->admin_note,
            'status' => 'paid',
            'created_by' => $finance->created_by,
        ];

        switch ($financeType) {
            case 'invoice':
                $pyment['invoice_id'] = $finance->id;
                $pyment['related'] = 'invoice';
                break;
            case 'paymentRequest':
                $pyment['pymentRequest_id'] = $finance->id;
                $pyment['related'] = 'paymentRequest';
                break;
            case 'creditNote':
                $pyment['creditNote_id'] = $finance->id;
                $pyment['related'] = 'creditNote';
                break;
            case 'expense':
                $pyment['expense_id'] = $finance->id;
                $pyment['related'] = 'expense';
                break;
        }

        return $pyment;
    }
}
