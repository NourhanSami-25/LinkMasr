<?php

namespace App\Http\Controllers\request;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\request\OvertimeRequest;
use App\Services\request\OvertimeRequestService;
use App\Http\Requests\request\OvertimeRequestRequest;
use App\Models\task\Task;
use App\Models\project\Project;

use App\Models\client\Client;
use App\Models\user\User;
use App\Services\utility\NotificationService;
use Illuminate\Support\Facades\Gate;
use App\Services\policy\AccessPolicyService;
use Exception;

class OvertimeRequestController extends Controller
{
    protected
        $overtimeRequestService, $accessPolicyService, $approveController, $notificationService;

    public function __construct(OvertimeRequestService $overtimeRequestService, ApproveController $approveController, AccessPolicyService  $accessPolicyService, NotificationService $notificationService)
    {
        $this->overtimeRequestService = $overtimeRequestService;
        $this->approveController = $approveController;
        $this->notificationService = $notificationService;
        $this->accessPolicyService = $accessPolicyService;
    }

    public function index()
    {
        $overtimeRequests = $this->overtimeRequestService->getAll()->reverse();
        return view('request.overtime.index', compact('overtimeRequests'));
    }


    public function create()
    {
        $tasks = Task::select('id', 'subject', 'client_id')->get();
        $projects = Project::select('id', 'subject', 'client_id')->get();
        
        $clients = Client::select('id', 'name')->where('status', 'active')->get();
        $users = User::select('id', 'name')->where('status', 'active')->get();
        return view('request.overtime.create', compact('tasks', 'projects', 'clients', 'users'));
    }


    public function store(OvertimeRequestRequest $request)
    {
        try {
            $overtimeRequest = $this->overtimeRequestService->create($request->validated());
            $approver_id = $this->approveController->getApproverId($overtimeRequest);
            $this->notificationService->notify('Create User Request: ' . $overtimeRequest->subject, '', 'none', __getUsersFromManyIds($overtimeRequest->follower, $overtimeRequest->handover, json_encode($approver_id)));
            return redirect()->route('overtime-requests.index')->with('success', 'OvertimeRequest Created Successfully');
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function show($id)
    {
        $request = OvertimeRequest::find($id);
        $request->type = 'overtime';
        $approver_id = $this->approveController->getApproverId($request);
        return view('request.all.show', compact('request', 'approver_id'));
    }

    public function edit($id)
    {
        $this->authorize('accessrequest', ['modify']);
        $request = OvertimeRequest::findOrFail($id);
        $model = 'overtime-requests';
        $tasks = Task::select('id', 'subject', 'client_id')->get();
        $projects = Project::select('id', 'subject', 'client_id')->get();
        
        $clients = Client::select('id', 'name')->where('status', 'active')->get();
        $users = User::select('id', 'name')->where('status', 'active')->get();
        return view('request.all.edit', compact('request', 'model', 'tasks', 'projects', 'clients', 'users'));
    }



    public function update(OvertimeRequestRequest $request, $id)
    {
        try {
            $overtimeRequest = $this->overtimeRequestService->update($id, $request->validated());
            $approver_id = $this->approveController->getApproverId($overtimeRequest);
            $this->notificationService->notify('Update User Request: ' . $overtimeRequest->subject, '', 'none', __getUsersFromManyIds($overtimeRequest->follower, $overtimeRequest->handover, json_encode($approver_id)));
            return redirect()->route('overtime-requests.show', $overtimeRequest->id)->with('success', 'OvertimeRequest updated successfully');
        } catch (Exception $e) {
            throw $e;
        }
    }



    public function destroy($id)
    {
        try {
            $this->authorize('accessrequest', ['delete']);
            $this->overtimeRequestService->delete($id);
            return redirect()->back()->with('success', 'OvertimeRequest Deleted Successfully');
        } catch (Exception $e) {
            throw $e;
        }
    }
}
