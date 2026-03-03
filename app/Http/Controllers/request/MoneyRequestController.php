<?php

namespace App\Http\Controllers\request;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\request\MoneyRequest;
use App\Services\request\MoneyRequestService;
use App\Http\Requests\request\MoneyRequestRequest;
use App\Models\task\Task;
use App\Models\project\Project;

use App\Models\client\Client;
use App\Models\user\User;
use App\Services\utility\NotificationService;
use Illuminate\Support\Facades\Gate;
use App\Services\policy\AccessPolicyService;
use Exception;

class MoneyRequestController extends Controller
{
    protected $moneyRequestService, $accessPolicyService, $approveController, $notificationService;

    public function __construct(MoneyRequestService $moneyRequestService, AccessPolicyService  $accessPolicyService, ApproveController $approveController, NotificationService $notificationService)
    {
        $this->moneyRequestService = $moneyRequestService;
        $this->approveController = $approveController;
        $this->notificationService = $notificationService;
        $this->accessPolicyService = $accessPolicyService;
    }

    public function index()
    {
        $moneyRequests = $this->moneyRequestService->getAll()->reverse();
        return view('request.money.index', compact('moneyRequests'));
    }


    public function create()
    {
        $tasks = Task::select('id', 'subject', 'client_id')->get();
        $projects = Project::select('id', 'subject', 'client_id')->get();
        
        $clients = Client::select('id', 'name')->where('status', 'active')->get();
        $users = User::select('id', 'name')->where('status', 'active')->get();
        return view('request.money.create', compact('tasks', 'projects', 'clients','users'));
    }


    public function store(MoneyRequestRequest $request)
    {
        try {
            $moneyRequest = $this->moneyRequestService->create($request->validated());
            $approver_id = $this->approveController->getApproverId($moneyRequest);
            $this->notificationService->notify('Create User Request: ' . $moneyRequest->subject, '', 'none', __getUsersFromManyIds($moneyRequest->follower, $moneyRequest->handover, json_encode($approver_id)));
            return redirect()->route('money-requests.index')->with('success', 'MoneyRequest Created Successfully');
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function show($id)
    {
        $request = MoneyRequest::find($id);
        $request->type = 'money';
        $approver_id = $this->approveController->getApproverId($request);
        return view('request.all.show', compact('request', 'approver_id'));
    }

    public function edit($id)
    {
        $this->authorize('accessrequest', ['modify']);
        $request = MoneyRequest::findOrFail($id);
        $model = 'money-requests';
        $tasks = Task::select('id', 'subject', 'client_id')->get();
        $projects = Project::select('id', 'subject', 'client_id')->get();
        
        $clients = Client::select('id', 'name')->where('status', 'active')->get();
        $users = User::select('id', 'name')->where('status', 'active')->get();
        return view('request.all.edit', compact('request', 'model', 'tasks', 'projects', 'clients', 'users'));
    }



    public function update(MoneyRequestRequest $request, $id)
    {
        try {
            $moneyRequest = $this->moneyRequestService->update($id, $request->validated());
            $approver_id = $this->approveController->getApproverId($moneyRequest);
            $this->notificationService->notify('Update User Request: ' . $moneyRequest->subject, '', 'none', __getUsersFromManyIds($moneyRequest->follower, $moneyRequest->handover, json_encode($approver_id)));
            return redirect()->route('money-requests.show', $moneyRequest->id)->with('success', 'MoneyRequest updated successfully');
        } catch (Exception $e) {
            throw $e;
        }
    }



    public function destroy($id)
    {
        try {
            $this->authorize('accessrequest', ['delete']);
            $this->moneyRequestService->delete($id);
            return redirect()->back()->with('success', 'MoneyRequest Deleted Successfully');
        } catch (Exception $e) {
            throw $e;
        }
    }
}
