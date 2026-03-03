<?php

namespace App\Http\Controllers\finance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\finance\Invoice;
use App\Models\finance\Pyment;
use App\Models\finance\CreditNote;
use App\Models\finance\PaymentRequest;
use App\Models\finance\Expense;

class ConversionsController extends Controller
{
    protected $invoiceService, $invoiceFunctionController, $pymentFunctionController, $creditNoteFunctionController, $paymentRequestFunctionController, $expenseFunctionController;

    public function __construct(InvoiceFunctionController $invoiceFunctionController, PymentFunctionController $pymentFunctionController, CreditNoteFunctionController $creditNoteFunctionController, PaymentRequestFunctionController $paymentRequestFunctionController, ExpenseFunctionController $expenseFunctionController)
    {
        $this->invoiceFunctionController = $invoiceFunctionController;
        $this->pymentFunctionController = $pymentFunctionController;
        $this->creditNoteFunctionController = $creditNoteFunctionController;
        $this->paymentRequestFunctionController = $paymentRequestFunctionController;
        $this->expenseFunctionController = $expenseFunctionController;
    }


    public function convert_invoice_to_pyment(Request $request, $id)
    {
        $invoice = Invoice::find($id);
        if (!$invoice) {
            return redirect()->back()->with('error', 'Invoice not found');
        }

        return redirect()->route('pyments.create', [
            'invoice_id' => $invoice->id,
            'client_id' => $invoice->client_id,
            'total' => $invoice->remaining_balance,
            'currency' => $invoice->currency,
            'subject' => $invoice->description
        ]);
    }

    public function convert_expense_to_pyment($id)
    {
        $expense = Expense::find($id);
        if (!$expense) {
            return redirect()->back()->with('error', 'Expense not found');
        }

        return redirect()->route('pyments.create', [
            'expense_id' => $expense->id,
            'client_id' => $expense->client_id,
            'total' => $expense->remaining_balance,
            'currency' => $expense->currency,
            'subject' => $expense->description
        ]);
    }


    public function convert_expense_to_invoice($id)
    {
        $expense = Expense::find($id);
        if (!$expense) {
            return redirect()->back()->with('error', 'Expense not found');
        }

        $invoice_number = $this->invoiceFunctionController->calculate_invoice_number();

        $invoiceData = [
            'project_id' => $expense->project_id,
            'task_id' => $expense->task_id,
            'client_id' => $expense->client_id,
            'client_name' => $expense->client_name,
            'number' => $invoice_number,
            'description' => $expense->description,
            'date' => now(),
            'currency' => $expense->currency,
            'sale_agent' => $expense->sale_agent,
            'discount_type' => $expense->discount_type,
            'discount_amount_type' => $expense->discount_amount_type,
            'tax' => $expense->tax,
            'adjustment' => $expense->adjustment,
            'discount' => $expense->discount,
            'fixed_discount' => $expense->fixed_discount,
            'total' => $expense->total,
            'admin_note' => $expense->admin_note,
            'created_by' => $expense->created_by,
            'status' => 'paid',
        ];

        Invoice::create($invoiceData);
        return redirect()->back()->with('success', 'Invoice created successfully from Expense');
    }


    public function convert_creditNote_to_pyment($id)
    {
        $creditNote = CreditNote::find($id);
        if (!$creditNote) {
            return redirect()->back()->with('error', 'Credit Note not found');
        }

        return redirect()->route('pyments.create', [
            'creditNote_id' => $creditNote->id,
            'client_id' => $creditNote->client_id,
            'total' => $creditNote->total,
            'currency' => $creditNote->currency,
            'subject' => $creditNote->description
        ]);
    }


    public function convert_paymentRequest_to_pyment(Request $request, $id)
    {
        $paymentRequest = PaymentRequest::find($id);
        if (!$paymentRequest) {
            return redirect()->back()->with('error', 'Payment Request not found');
        }

        return redirect()->route('pyments.create', [
            'pymentRequest_id' => $paymentRequest->id,
            'client_id' => $paymentRequest->client_id,
            'total' => $paymentRequest->total,
            'currency' => $paymentRequest->currency,
            'subject' => $paymentRequest->description
        ]);
    }


    public function convert_paymentRequest_to_invoice($id)
    {
        $paymentRequest = PaymentRequest::find($id);
        if (!$paymentRequest) {
            return redirect()->back()->with('error', 'Payment Request not found');
        }

        $invoice_number = $this->invoiceFunctionController->calculate_invoice_number();

        $invoiceData = [
            'project_id' => $paymentRequest->project_id,
            'task_id' => $paymentRequest->task_id,
            'client_id' => $paymentRequest->client_id,
            'client_name' => $paymentRequest->client_name,
            'number' => $invoice_number,
            'description' => $paymentRequest->description,
            'date' => now(),
            'currency' => $paymentRequest->currency,
            'sale_agent' => 'auto',
            'discount_type' => $paymentRequest->discount_type,
            'discount_amount_type' => $paymentRequest->discount_amount_type,
            'tax' => $paymentRequest->tax,
            'adjustment' => $paymentRequest->adjustment,
            'discount' => $paymentRequest->discount,
            'fixed_discount' => $paymentRequest->fixed_discount,
            'total' => $paymentRequest->total,
            'admin_note' => $paymentRequest->admin_note,
            'created_by' => $paymentRequest->created_by,
            'status' => 'paid',
        ];

        Invoice::create($invoiceData);
        return redirect()->back()->with('success', 'Invoice created successfully from Payment Request');
    }


    public function convert_paymentRequest_to_expense($id)
    {
        $paymentRequest = PaymentRequest::find($id);
        if (!$paymentRequest) {
            return redirect()->back()->with('error', 'Payment Request not found');
        }

        $expense_number = $this->expenseFunctionController->calculate_expense_number();

        $expenseData = [
            'project_id' => $paymentRequest->project_id,
            'task_id' => $paymentRequest->task_id,
            'client_id' => $paymentRequest->client_id,
            'client_name' => $paymentRequest->client_name,
            'number' => $paymentRequest->expense_number,
            'type' => 'auto',
            'description' => $paymentRequest->description ?? 'auto',
            'date' => now(),
            'currency' => $paymentRequest->currency,
            'sale_agent' => $paymentRequest->sale_agent,
            'discount_type' => $paymentRequest->discount_type,
            'discount_amount_type' => $paymentRequest->discount_amount_type,
            'tax' => $paymentRequest->tax,
            'adjustment' => $paymentRequest->adjustment,
            'discount' => $paymentRequest->discount,
            'fixed_discount' => $paymentRequest->fixed_discount,
            'total' => $paymentRequest->total,
            'admin_note' => $paymentRequest->admin_note,
            'created_by' => $paymentRequest->created_by,
            'have_package' => 0,
            'status' => 'paid',
        ];

        Expense::create($expenseData);
        return redirect()->back()->with('success', 'Expense created successfully from Payment Request');
    }


    public function convert_invoice_to_creditNote($id)
    {
        $invoice = Invoice::find($id);
        if (!$invoice) {
            return redirect()->back()->with('error', 'Invoice not found');
        }

        $creditNote_number = $this->creditNoteFunctionController->calculate_creditNote_number();

        $creditNoteData = [
            'project_id' => $invoice->project_id,
            'task_id' => $invoice->task_id,
            'client_id' => $invoice->client_id,
            'invoice_id' => $invoice->id,
            'client_name' => $invoice->client_name,
            'number' => $creditNote_number,
            'description' => $invoice->description,
            'date' => now(),
            'currency' => $invoice->currency,
            'sale_agent' => $invoice->sale_agent,
            'discount_type' => $invoice->discount_type,
            'discount_amount_type' => $invoice->discount_amount_type,
            'tax' => $invoice->tax,
            'adjustment' => $invoice->adjustment,
            'discount' => $invoice->discount,
            'fixed_discount' => $invoice->fixed_discount,
            'total' => $invoice->total,
            'admin_note' => $invoice->admin_note,
            'created_by' => $invoice->created_by,
            'status' => 'Credit',
        ];

        CreditNote::create($creditNoteData);
        return redirect()->back()->with('success', 'Credit Note created successfully from Invoice');
    }
}
