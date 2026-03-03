<?php

namespace App\Http\Controllers\finance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\task\Task;

use App\Models\user\User;
use App\Models\project\Project;
use App\Models\client\Client;
use App\Models\finance\CreditNote;
use App\Models\setting\Currency;
use App\Services\finance\CreditNoteService;
use App\Http\Requests\finance\CreditNoteRequest;
use Exception;

class CreditNoteController extends Controller
{
    protected $creditNoteService, $creditNoteFunctionController, $pymentFunctionController;

    public function __construct(CreditNoteService $creditNoteService, CreditNoteFunctionController $creditNoteFunctionController, PymentFunctionController $pymentFunctionController)
    {
        $this->creditNoteService = $creditNoteService;
        $this->creditNoteFunctionController = $creditNoteFunctionController;
        $this->pymentFunctionController = $pymentFunctionController;
    }


    public function index()
    {
        $this->authorize('accessfinance', ['view']);
        $creditNotes = $this->creditNoteService->getAll()->reverse();
        return view('finance.creditnote.index', compact('creditNotes'));
    }


    public function create()
    {
        $this->authorize('accessfinance', ['create']);
        $tasks = Task::select('id', 'subject', 'client_id')->get();
        $projects = Project::select('id', 'subject', 'client_id')->get();
        
        $users = User::select('id', 'name')->where('status', 'active')->get();
        $clients = Client::with('address')->select('id', 'name', 'currency')->where('status', 'active')->get();
        $currencies = Currency::select('code')->get();
        $creditNote_number = $this->creditNoteFunctionController->calculate_creditNote_number();
        return view('finance.creditnote.create', compact('projects', 'tasks', 'users', 'clients', 'currencies', 'creditNote_number'));
    }


    public function store(CreditNoteRequest $request)
    {
        try {
            $creditNoteData = $request->all();
            $creditNote = $this->creditNoteService->create($request->validated());

            $items = array_filter($request->finance_items, function ($item) {
                return !is_null($item['name']) && !is_null($item['amount']); // Filter out items where name or amount is null
            });

            if (isset($creditNoteData['finance_items']) && is_array($creditNoteData['finance_items'])) {
                foreach ($items as $itemData) {
                    $creditNote->financeItems()->create([
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
                $paymentData = $this->pymentFunctionController->get_pyment_data_from_finance_item($creditNote, 'creditNote');
                $this->pymentFunctionController->create_pyment_from_finance_item($paymentData);
            }

            $pdfUrl = route('creditNote_show_pdf', $creditNote->id);

            return redirect()->route('creditNotes.show', $creditNote->id)->with('success', 'CreditNote Created Successfully')->with('finance_pdf_url', $pdfUrl);  
        } catch (Exception $e) {
            throw $e;
        }
    }


    public function show($id)
    {
        $this->authorize('accessfinance', ['details']);
        $financeModel = CreditNote::findOrFail($id);
        $modelItems = $financeModel->financeItems;
        $model = 'creditNote';
        return view('finance.common.show', compact('financeModel', 'modelItems', 'model'));
    }


    public function edit($id)
    {
        $this->authorize('accessfinance', ['modify']);
        $creditNote = CreditNote::find($id);
        $tasks = Task::select('id', 'subject', 'client_id')->get();
        $projects = Project::select('id', 'subject', 'client_id')->get();
        
        $users = User::select('id', 'name')->where('status', 'active')->get();
        $clients = Client::with('address')->select('id', 'name', 'currency')->where('status', 'active')->get();
        $currencies = Currency::select('code')->get();
        $creditNote_number = $this->creditNoteFunctionController->calculate_creditNote_number();
        $items = $creditNote->financeItems;
        return view('finance.creditnote.edit', compact('creditNote', 'tasks','projects', 'users', 'clients', 'currencies', 'creditNote_number', 'items'));
    }


    public function update(CreditNoteRequest $request, $id)
    {
        try {
            $creditNoteData = $request->all();
            $creditNote = $this->creditNoteService->update($id, $request->validated(), $creditNote['finance_items'] ?? []);

            $items = array_filter($request->finance_items, function ($item) {
                return !is_null($item['name']) && !is_null($item['amount']);
            });

            // Delete old items
            $creditNote->financeItems()->delete();

            // Re-create finance items 
            if (isset($creditNoteData['finance_items']) && is_array($creditNote['finance_items'])) {
                foreach ($items as $itemData) {
                    $creditNote->financeItems()->create([
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
                $paymentData = $this->pymentFunctionController->get_pyment_data_from_finance_item($creditNote, 'creditNote');
                $this->pymentFunctionController->create_pyment_from_finance_item($paymentData);
            }

            return redirect()->route('creditNotes.show', $creditNote->id)->with('success', 'Credit Note Updated Successfully');
        } catch (Exception $e) {
            throw $e;
        }
    }


    public function destroy($id)
    {
        try {
            $this->authorize('accessfinance', ['delete']);
            $this->creditNoteService->delete($id);
            return redirect()->route('creditNotes.index')->with('success', 'CreditNote Deleted Successfully');
        } catch (Exception $e) {
            throw $e;
        }
    }
}
