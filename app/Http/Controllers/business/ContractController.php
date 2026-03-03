<?php

namespace App\Http\Controllers\business;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\task\Task;
use App\Models\project\Project;

use App\Models\user\User;
use App\Models\client\Client;
use App\Models\business\Contract;
use App\Services\business\ContractService;
use App\Http\Requests\business\ContractRequest;
use App\Models\setting\Currency;
use App\Services\reminder\AutoReminderService;
use Exception;

class ContractController extends Controller
{
    protected $contractService;
    protected $contractFunctionController;


    public function __construct(ContractService $contractService, ContractFunctionController $contractFunctionController)
    {
        $this->contractService = $contractService;
        $this->contractFunctionController = $contractFunctionController;
    }


    public function index()
    {
        $this->authorize('accesscontract', ['view']);
        $contracts = $this->contractService->getAll()->reverse();
        return view('business.contract.index', compact('contracts'));
    }


    public function create()
    {
        $this->authorize('accesscontract', ['create']);
        $tasks = Task::select('id', 'subject', 'client_id')->get();
        $projects = Project::select('id', 'subject', 'client_id')->get();
       
        // dd($lit  igations);
        $users = User::select('id', 'name')->where('status', 'active')->get();
        $clients = Client::with('address')->select('id', 'name', 'currency')->where('status', 'active')->get();
        $currencies = Currency::select('code')->get();
        $contract_number = $this->contractFunctionController->calculate_contract_number();
        return view('business.contract.create', compact('tasks', 'projects', 'users', 'clients', 'currencies', 'contract_number'));
    }


    public function store(ContractRequest $request)
    {
        try {
            $contract = $this->contractService->create($request->validated());
            AutoReminderService::create('business', 'contract', $contract);
            return redirect()->route('contracts.show', $contract->id)->with('success', 'Contract Created Successfully');
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function show($id)
    {
        $this->authorize('accesscontract', ['details']);
        $contract = $this->contractService->getItemById($id);
        $files = $contract?->files()?->get() ?? collect();
        $reminders = $contract?->reminders?->reverse() ?? collect();
        $users = User::select('id', 'name')->where('status', 'active')->get();
        return view('business.contract.show', compact('contract', 'users', 'files', 'reminders'));
    }


    public function edit($id)
    {
        $this->authorize('accesscontract', ['modify']);
        $contract = Contract::find($id);
        $tasks = Task::select('id', 'subject', 'client_id')->get();
        $projects = Project::select('id', 'subject', 'client_id')->get();
        $users = User::select('id', 'name')->where('status', 'active')->get();
        $clients = Client::with('address')->select('id', 'name', 'currency')->where('status', 'active')->get();
        $currencies = Currency::select('code')->get();
        return view('business.contract.edit', compact('contract', 'tasks', 'projects', 'users', 'clients', 'currencies'));
    }

    public function update(ContractRequest $request, $id)
    {
        try {
            $contract = $this->contractService->update($id, $request->validated());
            AutoReminderService::update($contract);

            $this->contractService->checkExpiration();
            return redirect()->route('contracts.show', $contract->id)->with('success', 'Contract Updated Successfully');
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function destroy($id)
    {
        try {
            $this->authorize('accesscontract', ['delete']);
            $this->contractService->delete($id);
            return redirect()->route('contracts.index')->with('success', 'Contract Deleted Successfully');
        } catch (Exception $e) {
            throw $e;
        }
    }
}
