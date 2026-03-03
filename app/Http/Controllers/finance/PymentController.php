<?php

namespace App\Http\Controllers\finance;

use App\Http\Controllers\Controller;
use App\Http\Requests\finance\PymentRequest;
use Illuminate\Http\Request;
use App\Models\task\Task;
use App\Models\project\Project;
use App\Models\user\User;
use App\Models\client\Client;
use App\Models\finance\Pyment;
use App\Services\finance\PymentService;
use App\Models\finance\CreditNote;
use App\Models\setting\Currency;
use App\Models\finance\Invoice;
use App\Models\finance\PaymentRequest;
use App\Models\finance\Expense;
use Exception;

class PymentController extends Controller
{
    protected $pymentService, $pymentFunctionController;

    public function __construct(PymentService $pymentService, PymentFunctionController $pymentFunctionController)
    {
        $this->pymentService = $pymentService;
        $this->pymentFunctionController = $pymentFunctionController;
    }

    /**
     * Get related finance item and validate payment amount
     */
    private function getRelatedFinanceItem(array $data): ?object
    {
        if (!empty($data['invoice_id'])) {
            return Invoice::find($data['invoice_id']);
        } elseif (!empty($data['expense_id'])) {
            return Expense::find($data['expense_id']);
        } elseif (!empty($data['pymentRequest_id'])) {
            return PaymentRequest::find($data['pymentRequest_id']);
        }
        return null;
    }


    public function index()
    {
        $this->authorize('accessfinance', ['view']);
        $pyments = $this->pymentService->getAll()->reverse();
        return view('finance.pyment.index', compact('pyments'));
    }


    public function create(Request $request)
    {
        $this->authorize('accessfinance', ['create']);
        $tasks = Task::select('id', 'subject', 'client_id')->get();
        $projects = Project::select('id', 'subject', 'client_id')->get();
        $invoices = Invoice::select('id', 'number', 'client_name', 'total', 'currency', 'client_id')->get();
        $creditNotes = CreditNote::select('id', 'number', 'client_name', 'total', 'currency', 'client_id')->get();
        $paymentRequests = PaymentRequest::select('id', 'number', 'client_name', 'total', 'currency', 'client_id')->get();
        $expenses = Expense::select('id', 'number', 'client_name', 'total', 'currency', 'client_id')->get();
        $users = User::select('id', 'name')->where('status', 'active')->get();
        $clients = Client::with('address')->select('id', 'name', 'currency')->where('status', 'active')->get();
        $currencies = Currency::select('code')->get();
        $pyment_number = $this->pymentFunctionController->calculate_pyment_number();

        // Pre-fill data if coming from conversion
        $prefilled = [
            'invoice_id' => $request->invoice_id,
            'expense_id' => $request->expense_id,
            'pymentRequest_id' => $request->pymentRequest_id,
            'creditNote_id' => $request->creditNote_id,
            'client_id' => $request->client_id,
            'total' => $request->total,
            'currency' => $request->currency,
            'subject' => $request->subject,
        ];

        return view('finance.pyment.create', compact(
            'tasks',
            'projects',
            'invoices',
            'creditNotes',
            'paymentRequests',
            'expenses',
            'users',
            'clients',
            'currencies',
            'pyment_number',
            'prefilled'
        ));
    }


    public function store(PymentRequest $request)
    {
        try {
            $validatedData = $request->validated();

            // Get related finance item and validate payment amount
            $financeItem = $this->getRelatedFinanceItem($validatedData);
            if ($financeItem && method_exists($financeItem, 'getRemainingBalanceAttribute')) {
                $validation = $this->pymentFunctionController->validatePaymentAmount(
                    $financeItem,
                    (float) $validatedData['total']
                );

                if (!$validation['valid']) {
                    return redirect()->back()
                        ->withInput()
                        ->with('error', $validation['message']);
                }
            }

            $pyment = $this->pymentService->create($validatedData);

            // Auto-update related finance item status
            if ($financeItem && method_exists($financeItem, 'updateStatusBasedOnPayments')) {
                $financeItem->updateStatusBasedOnPayments();
            }

            return redirect()->route('pyments.show', $pyment->id)->with('success', __('general.payment_created_successfully'));
        } catch (Exception $e) {
            throw $e;
        }
    }


    public function show($id)
    {
        $this->authorize('accessfinance', ['details']);
        $financeModel = Pyment::findOrFail($id);
        $modelItems = $financeModel->financeItems;
        $model = 'pyment';
        return view('finance.common.show', compact('financeModel', 'modelItems', 'model'));
    }

    public function edit($id)
    {
        $this->authorize('accessfinance', ['modify']);
        $pyment = Pyment::find($id);
        $tasks = Task::select('id', 'subject', 'client_id')->get();
        $projects = Project::select('id', 'subject', 'client_id')->get();
        $invoices = Invoice::select('id', 'number', 'client_name')->get();
        $creditNotes = CreditNote::select('id', 'number', 'client_name')->get();
        $paymentRequests = PaymentRequest::select('id', 'number', 'client_name')->get();
        $users = User::select('id', 'name')->where('status', 'active')->get();
        $clients = Client::with('address')->select('id', 'name')->where('status', 'active')->get();
        $currencies = Currency::select('code')->get();
        $pyment_number = $this->pymentFunctionController->calculate_pyment_number();
        return view('finance.pyment.edit', compact('pyment', 'tasks', 'projects', 'invoices', 'creditNotes', 'paymentRequests', 'users', 'clients', 'currencies', 'pyment_number'));
    }


    public function update(PymentRequest $request, $id)
    {
        try {
            $validatedData = $request->validated();
            $oldPyment = Pyment::find($id);

            // Get related finance item for validation
            $financeItem = $this->getRelatedFinanceItem($validatedData);

            // Calculate remaining balance excluding current payment
            if ($financeItem && method_exists($financeItem, 'getRemainingBalanceAttribute')) {
                $remainingPlusOld = $financeItem->remaining_balance + ($oldPyment ? $oldPyment->total : 0);

                if ((float) $validatedData['total'] > $remainingPlusOld) {
                    return redirect()->back()
                        ->withInput()
                        ->with('error', __('general.payment_exceeds_remaining_balance', [
                            'amount' => $validatedData['total'],
                            'remaining' => $remainingPlusOld
                        ]));
                }
            }

            $pyment = $this->pymentService->update($id, $validatedData);

            // Auto-update related finance item status
            if ($financeItem && method_exists($financeItem, 'updateStatusBasedOnPayments')) {
                $financeItem->updateStatusBasedOnPayments();
            }

            return redirect()->route('pyments.show', $pyment->id)->with('success', __('general.payment_updated_successfully'));
        } catch (Exception $e) {
            throw $e;
        }
    }


    public function destroy($id)
    {
        try {
            $this->authorize('accessfinance', ['delete']);

            // Get payment before deletion to update related finance item
            $pyment = Pyment::find($id);
            $financeItem = null;

            if ($pyment) {
                if ($pyment->invoice_id) {
                    $financeItem = Invoice::find($pyment->invoice_id);
                } elseif ($pyment->expense_id) {
                    $financeItem = Expense::find($pyment->expense_id);
                } elseif ($pyment->pymentRequest_id) {
                    $financeItem = PaymentRequest::find($pyment->pymentRequest_id);
                }
            }

            $this->pymentService->delete($id);

            // Update related finance item status after deletion
            if ($financeItem && method_exists($financeItem, 'updateStatusBasedOnPayments')) {
                $financeItem->updateStatusBasedOnPayments();
            }

            return redirect()->route('pyments.index')->with('success', __('general.payment_deleted_successfully'));
        } catch (Exception $e) {
            throw $e;
        }
    }
}
