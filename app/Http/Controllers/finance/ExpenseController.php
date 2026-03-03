<?php

namespace App\Http\Controllers\finance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\task\Task;
use App\Models\project\Project;

use App\Models\user\User;
use App\Models\client\Client;
use App\Models\finance\Expense;
use App\Services\finance\ExpenseService;
use App\Http\Requests\finance\ExpenseRequest;
use App\Models\setting\Currency;
use App\Services\common\FileService;
use App\Services\utility\NotificationService;
use Exception;

class ExpenseController extends Controller
{
    protected $expenseService, $expenseFunctionController, $pymentFunctionController, $fileService, $notificationService;

    public function __construct(
        ExpenseService $expenseService,
        ExpenseFunctionController $expenseFunctionController,
        PymentFunctionController $pymentFunctionController,
        FileService $fileService,
        NotificationService $notificationService
    ) {
        $this->expenseService = $expenseService;
        $this->expenseFunctionController = $expenseFunctionController;
        $this->pymentFunctionController = $pymentFunctionController;
        $this->fileService = $fileService;
        $this->notificationService = $notificationService;
    }


    public function index()
    {
        $this->authorize('accessexpense', ['view']);
        $expenses = $this->expenseService->getAll()->reverse();
        return view('finance.expense.index', compact('expenses'));
    }


    public function create(Request $request)
    {
        $this->authorize('accessexpense', ['create']);
        $tasks = Task::select('id', 'subject', 'client_id')->get();
        $projects = Project::select('id', 'subject', 'client_id')->get();

        $users = User::select('id', 'name')->where('status', 'active')->get();
        $clients = Client::with('address')->select('id', 'name', 'currency')->where('status', 'active')->get();
        $currencies = Currency::select('code')->get();
        $expense_number = $this->expenseFunctionController->calculate_expense_number();

        $selected_client_id = $request->client_id;
        $selected_project_id = $request->project_id;
        $selected_task_id = $request->task_id;

        return view('finance.expense.create', compact('tasks', 'projects', 'users', 'clients', 'currencies', 'expense_number', 'selected_client_id', 'selected_project_id', 'selected_task_id'));
    }


    public function store(ExpenseRequest $request)
    {

        try {
            $expenseData = $request->all();
            $expense = $this->expenseService->create($request->validated(), $expenseData['finance_items'] ?? []);

            $items = array_filter($request->finance_items, function ($item) {
                return !is_null($item['name']) && !is_null($item['amount']);
            });

            if (isset($expenseData['finance_items']) && is_array($expenseData['finance_items'])) {
                foreach ($items as $itemData) {
                    $expense->financeItems()->create([
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
                $paymentData = $this->pymentFunctionController->get_pyment_data_from_finance_item($expense, 'expense');
                $this->pymentFunctionController->create_pyment_from_finance_item($paymentData);
            }

            // Upload attachments
            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $index => $file) {
                    $this->fileService->uploadFile([
                        'file' => $file,
                        'model_type' => \App\Models\finance\Expense::class,
                        'model_id' => $expense->id,
                        'description' => 'no description',
                        'category' => 'expense attach',
                    ]);
                }
            }

            // Send notification to admins
            $admins = User::whereHas('roles', function ($q) {
                $q->where('name', 'admin'); })->get();
            foreach ($admins as $admin) {
                $this->notificationService->create([
                    'user_id' => $admin->id,
                    'title' => __('general.new_expense'),
                    'description' => __('general.new_expense') . ' #' . $expense->number . ' - ' . __('general.amount') . ': ' . $expense->total . ' ' . $expense->currency,
                    'link' => route('expenses.show', $expense->id),
                    'type' => 'expense',
                ]);
            }

            $pdfUrl = route('expense_show_pdf', $expense->id);

            return redirect()->route('expenses.show', $expense->id)->with('success', 'Expense Created Successfully')->with('finance_pdf_url', $pdfUrl);
        } catch (Exception $e) {
            throw $e;
        }
    }


    public function show($id)
    {
        $this->authorize('accessexpense', ['details']);
        $financeModel = Expense::findOrFail($id);
        $modelItems = $financeModel->financeItems;
        $model = 'expense';
        $files = $financeModel->files()->get();
        return view('finance.common.show', compact('financeModel', 'modelItems', 'model', 'files'));
    }


    public function edit($id)
    {
        $this->authorize('accessexpense', ['modify']);
        $expense = Expense::find($id);
        $tasks = Task::select('id', 'subject', 'client_id')->get();
        $projects = Project::select('id', 'subject', 'client_id')->get();

        $users = User::select('id', 'name')->where('status', 'active')->get();
        $clients = Client::with('address')->select('id', 'name', 'currency')->where('status', 'active')->get();
        $currencies = Currency::select('code')->get();
        $expense_number = $this->expenseFunctionController->calculate_expense_number();
        $items = $expense->financeItems;
        return view('finance.expense.edit', compact('expense', 'tasks', 'projects', 'users', 'clients', 'currencies', 'expense_number', 'items'));
    }


    public function update(ExpenseRequest $request, $id)
    {
        try {
            $expenseData = $request->all();
            $expense = $this->expenseService->update($id, $request->validated(), $expenseData['finance_items'] ?? []);

            $items = array_filter($request->finance_items, function ($item) {
                return !is_null($item['name']) && !is_null($item['amount']);
            });

            // Delete old items
            $expense->financeItems()->delete();

            // Re-create finance items 
            if (isset($expenseData['finance_items']) && is_array($expenseData['finance_items'])) {
                foreach ($items as $itemData) {
                    $expense->financeItems()->create([
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
                $paymentData = $this->pymentFunctionController->get_pyment_data_from_finance_item($expense, 'expense');
                $this->pymentFunctionController->create_pyment_from_finance_item($paymentData);
            }

            return redirect()->route('expenses.show', $expense->id)->with('success', 'Expense Updated Successfully');
        } catch (Exception $e) {
            throw $e;
        }
    }


    public function destroy($id)
    {
        try {
            $this->authorize('accessexpense', ['delete']);
            $this->expenseService->delete($id);
            return redirect()->route('expenses.index')->with('success', 'Expense Deleted Successfully');
        } catch (Exception $e) {
            throw $e;
        }
    }
}
