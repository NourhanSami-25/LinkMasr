<?php

namespace App\Http\Controllers\request;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\request\WorkhomeRequest;
use App\Services\request\WorkhomeRequestService;
use App\Http\Requests\request\WorkhomeRequestRequest;
use App\Models\task\Task;
use App\Models\project\Project;

use App\Models\client\Client;
use App\Models\user\User;
use App\Services\utility\NotificationService;
use Illuminate\Support\Facades\Gate;
use App\Services\policy\AccessPolicyService;
use Exception;

class WorkhomeRequestController extends Controller
{
    protected
        $workhomeRequestService, $approveController, $accessPolicyService, $notificationService;

    public function __construct(WorkhomeRequestService $workhomeRequestService, AccessPolicyService  $accessPolicyService, ApproveController $approveController, NotificationService $notificationService)
    {
        $this->workhomeRequestService = $workhomeRequestService;
        $this->approveController = $approveController;
        $this->notificationService = $notificationService;
        $this->accessPolicyService = $accessPolicyService;
    }

    public function index()
    {
        $workhomeRequests = $this->workhomeRequestService->getAll()->reverse();
        return view('request.workhome.index', compact('workhomeRequests'));
    }


    public function create()
    {
        $tasks = Task::select('id', 'subject', 'client_id')->get();
        $projects = Project::select('id', 'subject', 'client_id')->get();
        
        $clients = Client::select('id', 'name')->where('status', 'active')->get();
        $users = User::select('id', 'name')->where('status', 'active')->get();
        return view('request.workhome.create', compact('tasks', 'projects', 'clients', 'users'));
    }


    public function store(WorkhomeRequestRequest $request)
    {
        try {
            $workhomeRequest = $this->workhomeRequestService->create($request->validated());
            $approver_id = $this->approveController->getApproverId($workhomeRequest);
            $this->notificationService->notify('Create User Request: ' . $workhomeRequest->subject, '', 'none', __getUsersFromManyIds($workhomeRequest->follower, $workhomeRequest->handover, json_encode($approver_id)));
            return redirect()->route('workhome-requests.index')->with('success', 'WorkhomeRequest Created Successfully');
        } catch (Exception $e) {
            throw $e;
        }
    }


    public function show($id)
    {
        $request = WorkhomeRequest::find($id);;
        $request->type = 'workhome';
        $approver_id = $this->approveController->getApproverId($request);
        return view('request.all.show', compact('request', 'approver_id'));
    }


    public function edit($id)
    {
        $this->authorize('accessrequest', ['modify']);
        $request = WorkhomeRequest::findOrFail($id);
        $model = 'workhome-requests';
        $tasks = Task::select('id', 'subject', 'client_id')->get();
        $projects = Project::select('id', 'subject', 'client_id')->get();
        
        $clients = Client::select('id', 'name')->where('status', 'active')->get();
        $users = User::select('id', 'name')->where('status', 'active')->get();
        return view('request.all.edit', compact('request', 'model', 'tasks', 'projects', 'clients', 'users'));
    }


    public function update(WorkhomeRequestRequest $request, $id)
    {
        try {
            $workhomeRequest = $this->workhomeRequestService->update($id, $request->validated());
            $approver_id = $this->approveController->getApproverId($workhomeRequest);
            $this->notificationService->notify('Update User Request: ' . $workhomeRequest->subject, '', 'none', __getUsersFromManyIds($workhomeRequest->follower, $workhomeRequest->handover, json_encode($approver_id)));
            return redirect()->route('workhome-requests.show', $workhomeRequest->id)->with('success', 'WorkhomeRequest updated successfully');
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function destroy($id)
    {
        try {
            $this->authorize('accessrequest', ['delete']);
            $this->workhomeRequestService->delete($id);
            return redirect()->back()->with('success', 'WorkhomeRequest Deleted Successfully');
        } catch (Exception $e) {
            throw $e;
        }
    }
}
