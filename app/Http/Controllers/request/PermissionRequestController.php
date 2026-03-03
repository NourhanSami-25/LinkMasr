<?php

namespace App\Http\Controllers\request;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\request\PermissionRequest;
use App\Services\request\PermissionRequestService;
use App\Http\Requests\request\PermissionRequestRequest;
use App\Models\task\Task;
use App\Models\project\Project;

use App\Models\client\Client;
use App\Models\user\User;
use App\Services\utility\NotificationService;
use Illuminate\Support\Facades\Gate;
use App\Services\policy\AccessPolicyService;
use Exception;

class PermissionRequestController extends Controller
{
    protected $permissionRequestService, $notificationService, $accessPolicyService, $approveController;

    public function __construct(PermissionRequestService $permissionRequestService, AccessPolicyService  $accessPolicyService, ApproveController $approveController, NotificationService $notificationService)
    {
        $this->permissionRequestService = $permissionRequestService;
        $this->approveController = $approveController;
        $this->notificationService = $notificationService;
        $this->accessPolicyService = $accessPolicyService;
    }

    public function index()
    {
        $permissionRequests = $this->permissionRequestService->getAll()->reverse();
        return view('request.permission.index', compact('permissionRequests'));
    }


    public function create()
    {
        $users = User::select('id', 'name')->where('status', 'active')->get();
        return view('request.permission.create', compact('users'));
    }


    public function store(PermissionRequestRequest $request)
    {
        try {
            $permissionRequest = $this->permissionRequestService->create($request->validated());
            $approver_id = $this->approveController->getApproverId($permissionRequest);
            $this->notificationService->notify('Create User Request: ' . $permissionRequest->subject, '', 'none', __getUsersFromManyIds($permissionRequest->follower, $permissionRequest->handover, json_encode($approver_id)));
            return redirect()->route('permission-requests.index')->with('success', 'PermissionRequest Created Successfully');
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function show($id)
    {
        $request = PermissionRequest::find($id);
        $request->type = 'permission';
        $approver_id = $this->approveController->getApproverId($request);
        return view('request.all.show', compact('request', 'approver_id'));
    }


    public function edit($id)
    {
        $this->authorize('accessrequest', ['modify']);
        $request = PermissionRequest::findOrFail($id);
        $model = 'permission-requests';
        $tasks = Task::select('id', 'subject', 'client_id')->get();
        $projects = Project::select('id', 'subject', 'client_id')->get();
        
        $clients = Client::select('id', 'name')->where('status', 'active')->get();
        $users = User::select('id', 'name')->where('status', 'active')->get();
        return view('request.all.edit', compact('request', 'model', 'tasks', 'projects', 'clients', 'users'));
    }



    public function update(PermissionRequestRequest $request, $id)
    {
        try {
            $permissionRequest = $this->permissionRequestService->update($id, $request->validated());
            $approver_id = $this->approveController->getApproverId($permissionRequest);
            $this->notificationService->notify('Update User Request: ' . $permissionRequest->subject, '', 'none', __getUsersFromManyIds($permissionRequest->follower, $permissionRequest->handover, json_encode($approver_id)));
            return redirect()->route('permission-requests.show', $permissionRequest->id)->with('success', 'PermissionRequest updated successfully');
        } catch (Exception $e) {
            throw $e;
        }
    }



    public function destroy($id)
    {
        try {
            $this->authorize('accessrequest', ['delete']);
            $this->permissionRequestService->delete($id);
            return redirect()->back()->with('success', 'PermissionRequest Deleted Successfully');
        } catch (Exception $e) {
            throw $e;
        }
    }
}
