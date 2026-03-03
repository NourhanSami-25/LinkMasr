<?php

namespace App\Http\Controllers\finance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\task\Task;
use App\Models\project\Project;
use App\Models\user\User;

use App\Models\client\Client;
use App\Models\finance\Invoice;
use App\Services\finance\InvoiceService;
use App\Http\Requests\finance\InvoiceRequest;
use App\Models\finance\PaymentRequest;
use App\Models\setting\Currency;
use App\Services\utility\NotificationService;
use Exception;

class InvoiceController extends Controller
{
    protected $invoiceService, $invoiceFunctionController, $pymentFunctionController, $notificationService;

    public function __construct(InvoiceService $invoiceService, InvoiceFunctionController $invoiceFunctionController, PymentFunctionController $pymentFunctionController, NotificationService $notificationService)
    {
        $this->invoiceService = $invoiceService;
        $this->invoiceFunctionController = $invoiceFunctionController;
        $this->pymentFunctionController = $pymentFunctionController;
        $this->notificationService = $notificationService;
    }


    public function index()
    {
        $this->authorize('accessfinance', ['view']);
        $invoices = $this->invoiceService->getAll()->reverse();
        return view('finance.invoice.index', compact('invoices'));
    }


    public function create(Request $request)
    {
        $this->authorize('accessfinance', ['create']);
        $tasks = Task::select('id', 'subject', 'client_id')->get();
        $projects = Project::select('id', 'subject', 'client_id')->get();

        $users = User::select('id', 'name')->where('status', 'active')->get();
        $clients = Client::with('address')->select('id', 'name', 'currency')->where('status', 'active')->get();
        $currencies = Currency::select('code')->get();
        $paymentRequests = PaymentRequest::select('id', 'client_name', 'number', 'client_id')->get();
        $invoice_number = $this->invoiceFunctionController->calculate_invoice_number();

        $selected_client_id = $request->client_id;
        $selected_project_id = $request->project_id;
        $selected_task_id = $request->task_id;

        return view('finance.invoice.create', compact('tasks', 'projects', 'users', 'clients', 'currencies', 'paymentRequests', 'invoice_number', 'selected_client_id', 'selected_project_id', 'selected_task_id'));
    }


    public function store(InvoiceRequest $request)
    {
        try {
            $invoiceData = $request->all();
            $invoice = $this->invoiceService->create($request->validated(), $invoiceData['finance_items'] ?? []);

            // Send notification to admins about new invoice
            $admins = User::whereHas('roles', function ($q) {
                $q->where('name', 'admin'); })->get();
            if ($admins->isNotEmpty()) {
                $this->notificationService->notify(
                    __('general.new_invoice') . ': #' . $invoice->number,
                    __('general.amount') . ': ' . $invoice->total . ' ' . $invoice->currency,
                    route('invoices.show', $invoice->id),
                    $admins
                );
            }

            $items = array_filter($request->finance_items, function ($item) {
                return !is_null($item['name']) && !is_null($item['amount']);
            });

            if (isset($invoiceData['finance_items']) && is_array($invoiceData['finance_items'])) {
                foreach ($items as $itemData) {
                    $invoice->financeItems()->create([
                        'name' => $itemData['name'],
                        'description' => $itemData['description'],
                        'qty' => $itemData['qty'],
                        'amount' => $itemData['amount'],
                        'tax' => $itemData['tax'],
                        'subtotal' => $itemData['subtotal'],
                    ]);
                }
            }

            if ($request->create_payment) {
                $paymentData = $this->pymentFunctionController->get_pyment_data_from_finance_item($invoice, 'invoice');
                $this->pymentFunctionController->create_pyment_from_finance_item($paymentData);
            }

            $pdfUrl = route('invoice_show_pdf', $invoice->id);

            return redirect()->route('invoices.show', $invoice->id)->with('success', 'Invoice Created Successfully')->with('finance_pdf_url', $pdfUrl);
        } catch (Exception $e) {
            throw $e;
        }
    }


    public function show($id)
    {
        $this->authorize('accessfinance', ['details']);
        $financeModel = Invoice::findOrFail($id);
        $modelItems = $financeModel->financeItems;
        $model = 'invoice';
        $paymentRequest = PaymentRequest::find($financeModel->pymentRequest_id);
        return view('finance.common.show', compact('financeModel', 'modelItems', 'model', 'paymentRequest'));
    }


    public function edit($id)
    {

        $this->authorize('accessfinance', ['modify']);
        $invoice = Invoice::find($id);
        $tasks = Task::select('id', 'subject', 'client_id')->get();

        $projects = Project::select('id', 'subject', 'client_id')->get();
        $users = User::select('id', 'name')->where('status', 'active')->get();
        $clients = Client::with('address')->select('id', 'name', 'currency')->where('status', 'active')->get();
        $currencies = Currency::select('code')->get();
        $invoice_number = $this->invoiceFunctionController->calculate_invoice_number();
        $paymentRequests = PaymentRequest::select('id', 'client_name', 'number', 'client_id')->get();
        $items = $invoice->financeItems;
        return view('finance.invoice.edit', compact('invoice', 'tasks', 'projects', 'users', 'clients', 'currencies', 'paymentRequests', 'invoice_number', 'items'));
    }


    public function update(InvoiceRequest $request, $id)
    {
        try {
            $invoiceData = $request->all();
            $invoice = $this->invoiceService->update($id, $request->validated(), $invoiceData['finance_items'] ?? []);

            $items = array_filter($request->finance_items, function ($item) {
                return !is_null($item['name']) && !is_null($item['amount']);
            });

            // Delete old items
            $invoice->financeItems()->delete();

            // Re-create finance items 
            if (isset($invoiceData['finance_items']) && is_array($invoiceData['finance_items'])) {
                foreach ($items as $itemData) {
                    $invoice->financeItems()->create([
                        'name' => $itemData['name'],
                        'description' => $itemData['description'],
                        'qty' => $itemData['qty'],
                        'amount' => $itemData['amount'],
                        'tax' => $itemData['tax'],
                        'subtotal' => $itemData['subtotal'],
                    ]);
                }
            }

            if ($request->create_payment) {
                $paymentData = $this->pymentFunctionController->get_pyment_data_from_finance_item($invoice, 'invoice');
                $this->pymentFunctionController->create_pyment_from_finance_item($paymentData);
            }

            return redirect()->route('invoices.show', $invoice->id)->with('success', 'Invoice Updated Successfully');
        } catch (Exception $e) {
            throw $e;
        }
    }


    public function destroy($id)
    {
        try {
            $this->authorize('accessfinance', ['delete']);
            $this->invoiceService->delete($id);
            return redirect()->route('invoices.index')->with('success', 'Invoice Deleted Successfully');
        } catch (Exception $e) {
            throw $e;
        }
    }
}
