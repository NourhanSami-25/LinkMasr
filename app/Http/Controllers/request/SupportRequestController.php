<?php

namespace App\Http\Controllers\request;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\request\SupportRequest;
use App\Services\request\SupportRequestService;
use App\Services\policy\AccessPolicyService;
use App\Http\Requests\request\SupportRequestRequest;
use App\Models\task\Task;
use App\Models\project\Project;

use App\Models\client\Client;
use App\Models\user\User;
use App\Models\setting\Role;
use Illuminate\Support\Facades\Auth;
use App\Services\utility\NotificationService;

use Exception;
use Illuminate\Support\Facades\Gate;



class SupportRequestController extends Controller
{
    protected $supportRequestService, $accessPolicyService, $notificationService, $approveController;


    public function __construct(SupportRequestService $supportRequestService, AccessPolicyService  $accessPolicyService, ApproveController $approveController, NotificationService $notificationService)
    {
        $this->supportRequestService = $supportRequestService;
        $this->accessPolicyService = $accessPolicyService;
        $this->approveController = $approveController;
        $this->notificationService = $notificationService;
    }


    public function index()
    {
        $supportRequests = $this->supportRequestService->getAll()->reverse();
        return view('request.support.index', compact('supportRequests'));
    }


    public function create()
    {
        // $this->accessPolicyService->authorizeAccess('Finance', 'modify');
        $users = User::select('id', 'name')->where('status', 'active')->get();
        return view('request.support.create', compact('users'));
    }


    public function store(SupportRequestRequest $request)
    {
        try {
            $supportRequest = $this->supportRequestService->create($request->validated());
            $approver_id = $this->approveController->getApproverId($supportRequest);
            $this->notificationService->notify('Create User Request: ' . $supportRequest->subject, '', 'none', __getUsersFromManyIds($supportRequest->follower, $supportRequest->handover, json_encode($approver_id)));
            return redirect()->back()->with('success', 'SupportRequest Created Successfully');
        } catch (Exception $e) {
            throw $e;
        }
    }


    public function show($id)
    {
        $request = SupportRequest::find($id);
        $request->type = 'support';
        $approver_id = $this->approveController->getApproverId($request);
        return view('request.all.show', compact('request', 'approver_id'));
    }


    public function edit($id)
    {
        $this->authorize('accessrequest', ['modify']);
        $request = SupportRequest::findOrFail($id);
        $model = 'support-requests';
        $tasks = Task::select('id', 'subject', 'client_id')->get();
        $projects = Project::select('id', 'subject', 'client_id')->get();
        
        $clients = Client::select('id', 'name')->where('status', 'active')->get();
        $users = User::select('id', 'name')->where('status', 'active')->get();
        return view('request.all.edit', compact('request', 'model', 'tasks', 'projects', 'clients', 'users'));
    }



    public function update(SupportRequestRequest $request, $id)
    {
        try {
            $supportRequest = $this->supportRequestService->update($id, $request->validated());
            $approver_id = $this->approveController->getApproverId($supportRequest);
            $this->notificationService->notify('Update User Request: ' . $supportRequest->subject, '', 'none', __getUsersFromManyIds($supportRequest->follower, $supportRequest->handover, json_encode($approver_id)));
            return redirect()->route('support-requests.show', $supportRequest->id)->with('success', 'SupportRequest updated successfully');
        } catch (Exception $e) {
            throw $e;
        }
    }



    public function destroy($id)
    {
        try {
            $this->authorize('accessrequest', ['delete']);
            $this->supportRequestService->delete($id);
            return redirect()->back()->with('success', 'SupportRequest Deleted Successfully');
        } catch (Exception $e) {
            throw $e;
        }
    }
}
