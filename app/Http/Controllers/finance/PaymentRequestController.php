<?php

namespace App\Http\Controllers\finance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\task\Task;
use App\Models\user\User;

use App\Models\project\Project;
use App\Models\client\Client;
use App\Models\setting\Currency;
use App\Models\finance\PaymentRequest;
use App\Services\finance\PaymentRequestService;
use App\Http\Requests\finance\PaymentRequestRequest;
use App\Services\reminder\AutoReminderService;
use App\Services\utility\NotificationService;
use Exception;

class PaymentRequestController extends Controller
{
    protected $paymentRequestService, $paymentRequestFunctionController, $pymentFunctionController, $notificationService;

    public function __construct(PaymentRequestService $paymentRequestService, PaymentRequestFunctionController $paymentRequestFunctionController, PymentFunctionController $pymentFunctionController, NotificationService $notificationService)
    {
        $this->paymentRequestService = $paymentRequestService;
        $this->paymentRequestFunctionController = $paymentRequestFunctionController;
        $this->pymentFunctionController = $pymentFunctionController;
        $this->notificationService = $notificationService;
    }


    public function index()
    {
        $this->authorize('accessfinance', ['view']);
        $paymentRequests = $this->paymentRequestService->getAll()->reverse();
        return view('finance.paymentrequest.index', compact('paymentRequests'));
    }


    public function create()
    {
        $this->authorize('accessfinance', ['create']);
        $tasks = Task::select('id', 'subject', 'client_id')->get();
        $projects = Project::select('id', 'subject', 'client_id')->get();
        
        $users = User::select('id', 'name')->where('status', 'active')->get();
        $clients = Client::with('address')->select('id', 'name', 'currency')->where('status', 'active')->get();
        $currencies = Currency::select('code')->get();
        $paymentRequest_number = $this->paymentRequestFunctionController->calculate_paymentRequest_number();
        return view('finance.paymentrequest.create', compact('projects', 'tasks', 'users', 'clients', 'currencies', 'paymentRequest_number'));
    }


    public function store(PaymentRequestRequest $request)
    {
        try {
            $paymentRequestData = $request->all();
            $paymentRequest = $this->paymentRequestService->create($request->validated(), $paymentRequestData['finance_items'] ?? []);

            AutoReminderService::create('finance', 'paymentRequest', $paymentRequest);
            
            // Send notification to admins about new payment request
            $admins = User::whereHas('roles', function($q) { $q->where('name', 'admin'); })->get();
            if ($admins->isNotEmpty()) {
                $this->notificationService->notify(
                    __('general.new_payment_request') . ': #' . $paymentRequest->number,
                    __('general.amount') . ': ' . $paymentRequest->total . ' ' . $paymentRequest->currency,
                    route('paymentRequests.show', $paymentRequest->id),
                    $admins
                );
            }

            $items = array_filter($request->finance_items, function ($item) {
                return !is_null($item['name']) && !is_null($item['amount']); // Filter out items where name or amount is null
            });

            if (isset($paymentRequestData['finance_items']) && is_array($paymentRequestData['finance_items'])) {
                foreach ($items as $itemData) {
                    $paymentRequest->financeItems()->create([
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
                $paymentData = $this->pymentFunctionController->get_pyment_data_from_finance_item($paymentRequest, 'paymentRequest');
                $this->pymentFunctionController->create_pyment_from_finance_item($paymentData);
            }

            $pdfUrl = route('paymentRequest_show_pdf', $paymentRequest->id);

            return redirect()->route('paymentRequests.show', $paymentRequest->id)->with('success', 'PaymentRequest Created Successfully')->with('finance_pdf_url', $pdfUrl);
        } catch (Exception $e) {
            throw $e;
        }
    }


    public function show($id)
    {
        $this->authorize('accessfinance', ['details']);
        $financeModel = PaymentRequest::findOrFail($id);
        $modelItems = $financeModel->financeItems;
        $model = 'paymentRequest';
        return view('finance.common.show', compact('financeModel', 'modelItems', 'model'));
    }


    public function edit($id)
    {
        $this->authorize('accessfinance', ['modify']);
        $paymentRequest = PaymentRequest::find($id);
        $tasks = Task::select('id', 'subject', 'client_id')->get();
        
        $projects = Project::select('id', 'subject', 'client_id')->get();
        $users = User::select('id', 'name')->where('status', 'active')->get();
        $clients = Client::with('address')->select('id', 'name', 'currency')->where('status', 'active')->get();
        $currencies = Currency::select('code')->get();
        $paymentRequest_number = $this->paymentRequestFunctionController->calculate_paymentRequest_number();
        $items = $paymentRequest->financeItems;
        return view('finance.paymentrequest.edit', compact('paymentRequest', 'tasks', 'projects', 'users', 'clients', 'currencies', 'paymentRequest_number', 'items'));
    }


    public function update(PaymentRequestRequest $request, $id)
    {
        try {
            $paymentRequestData = $request->all();
            $paymentRequest = $this->paymentRequestService->update($id, $request->validated(), $paymentRequestData['finance_items'] ?? []);

            $items = array_filter($request->finance_items, function ($item) {
                return !is_null($item['name']) && !is_null($item['amount']);
            });

            // Delete old items
            $paymentRequest->financeItems()->delete();

            // Re-create finance items 
            if (isset($paymentRequestData['finance_items']) && is_array($paymentRequestData['finance_items'])) {
                foreach ($items as $itemData) {
                    $paymentRequest->financeItems()->create([
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
                $paymentData = $this->pymentFunctionController->get_pyment_data_from_finance_item($paymentRequest, 'paymentRequest');
                $this->pymentFunctionController->create_pyment_from_finance_item($paymentData);
            }

            return redirect()->route('paymentRequests.show', $paymentRequest->id)->with('success', 'PaymentRequest Updated Successfully');
        } catch (Exception $e) {
            throw $e;
        }
    }


    public function destroy($id)
    {
        try {
            $this->authorize('accessfinance', ['delete']);
            $this->paymentRequestService->delete($id);
            return redirect()->route('paymentRequests.index')->with('success', 'PaymentRequest Deleted Successfully');
        } catch (Exception $e) {
            throw $e;
        }
    }
}
