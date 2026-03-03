<?php

namespace App\Http\Controllers\business;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\task\Task;
use App\Models\project\Project;
use App\Models\user\User;
use App\Models\client\Client;
use App\Models\business\Proposal;
use App\Services\business\ProposalService;
use App\Http\Requests\business\ProposalRequest;
use App\Models\setting\Currency;

use Exception;

class ProposalController extends Controller
{
    protected $proposalService;
    protected $proposalFunctionController;


    public function __construct(ProposalService $proposalService, ProposalFunctionController $proposalFunctionController)
    {
        $this->proposalService = $proposalService;
        $this->proposalFunctionController = $proposalFunctionController;
    }


    public function index()
    {
        $this->authorize('accessproposal', ['view']);
        $proposals = $this->proposalService->getAll()->reverse();
        return view('business.proposal.index', compact('proposals'));
    }


    public function create()
    {
        $this->authorize('accessproposal', ['create']);
        $tasks = Task::select('id', 'subject', 'client_id')->get();
        $projects = Project::select('id', 'subject', 'client_id')->get();
        
        $users = User::select('id', 'name')->where('status', 'active')->get();
        $clients = Client::with('address')->select('id', 'name','currency')->where('status', 'active')->get();
        $currencies = Currency::select('code')->get();
        $proposal_number = $this->proposalFunctionController->calculate_proposal_number();
        return view('business.proposal.create', compact('tasks', 'projects', 'users', 'clients', 'currencies', 'proposal_number'));
    }


    public function store(ProposalRequest $request)
    {
        try {
            $proposal = $this->proposalService->create($request->validated());
            return redirect()->route('proposals.show', $proposal->id)->with('success', 'Proposal Created Successfully');
        } catch (Exception $e) {
            throw $e;
        }
    }


    public function show($id)
    {
        $this->authorize('accessproposal', ['details']);
        $proposal = $this->proposalService->getItemById($id);
        return view('business.proposal.show', compact('proposal'));
    }


    public function edit($id)
    {
        $this->authorize('accessproposal', arguments: ['modify']);
        $proposal = Proposal::find($id);
        $tasks = Task::select('id', 'subject', 'client_id')->get();
        $projects = Project::select('id', 'subject', 'client_id')->get();
        
        $users = User::select('id', 'name')->where('status', 'active')->get();
        $clients = Client::with('address')->select('id', 'name','currency')->where('status', 'active')->get();
        $currencies = Currency::select('code')->get();
        return view('business.proposal.edit', compact('proposal', 'tasks', 'projects', 'users', 'clients', 'currencies'));
    }


    public function update(ProposalRequest $request, $id)
    {
        try {
            $proposal = $this->proposalService->update($id, $request->validated());
            return redirect()->route('proposals.show', $proposal->id)->with('success', 'Proposal Updated Successfully');
        } catch (Exception $e) {
            throw $e;
        }
    }


    public function destroy($id)
    {
        try {
            $this->authorize('accessproposal', ['delete']);
            $this->proposalService->delete($id);
            return redirect()->route('proposals.index')->with('success', 'Proposal Deleted Successfully');
        } catch (Exception $e) {
            throw $e;
        }
    }
}
