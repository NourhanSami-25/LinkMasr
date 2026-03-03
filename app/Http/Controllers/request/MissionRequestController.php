<?php

namespace App\Http\Controllers\request;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\request\MissionRequest;
use App\Services\request\MissionRequestService;
use App\Http\Requests\request\MissionRequestRequest;
use App\Models\task\Task;
use App\Models\project\Project;

use App\Models\client\Client;
use App\Models\user\User;
use App\Services\utility\NotificationService;
use Illuminate\Support\Facades\Gate;
use App\Services\policy\AccessPolicyService;
use Exception;


class MissionRequestController extends Controller
{
    protected $missionRequestService, $notificationService, $accessPolicyService, $approveController;

    public function __construct(MissionRequestService $missionRequestService, ApproveController $approveController, AccessPolicyService  $accessPolicyService, NotificationService $notificationService)
    {
        $this->missionRequestService = $missionRequestService;
        $this->approveController = $approveController;
        $this->notificationService = $notificationService;
        $this->accessPolicyService = $accessPolicyService;
    }

    public function index()
    {
        $missionRequests = $this->missionRequestService->getAll()->reverse();
        return view('request.mission.index', compact('missionRequests'));
    }


    public function create()
    {
        $tasks = Task::select('id', 'subject', 'client_id')->get();
        $projects = Project::select('id', 'subject', 'client_id')->get();
        
        $clients = Client::select('id', 'name')->where('status', 'active')->get();
        $users = User::select('id', 'name')->where('status', 'active')->get();
        return view('request.mission.create', compact('tasks', 'projects', 'clients', 'users'));
    }


    public function store(MissionRequestRequest $request)
    {
        try {
            $missionRequest = $this->missionRequestService->create($request->validated());
            $approver_id = $this->approveController->getApproverId($missionRequest);
            $this->notificationService->notify('Create User Request: ' . $missionRequest->subject, '', 'none', __getUsersFromManyIds($missionRequest->follower, $missionRequest->handover, json_encode($approver_id)));
            return redirect()->route('mission-requests.index')->with('success', 'MissionRequest Created Successfully');
        } catch (Exception $e) {
            throw $e;
        }
    }


    public function show($id)
    {
        $request = MissionRequest::find($id);
        $request->type = 'mission';
        $approver_id = $this->approveController->getApproverId($request);
        return view('request.all.show', compact('request', 'approver_id'));
    }


    public function edit($id)
    {
        $this->authorize('accessrequest', ['modify']);
        $request = MissionRequest::findOrFail($id);
        $model = 'mission-requests';
        $tasks = Task::select('id', 'subject', 'client_id')->get();
        $projects = Project::select('id', 'subject', 'client_id')->get();
        
        $clients = Client::select('id', 'name')->where('status', 'active')->get();
        $users = User::select('id', 'name')->where('status', 'active')->get();
        return view('request.all.edit', compact('request', 'model', 'tasks', 'projects', 'clients', 'users'));
    }

    public function update(MissionRequestRequest $request, $id)
    {
        try {
            $missionRequest = $this->missionRequestService->update($id, $request->validated());
            $approver_id = $this->approveController->getApproverId($missionRequest);
            $this->notificationService->notify('Update User Request: ' . $missionRequest->subject, '', 'none', __getUsersFromManyIds($missionRequest->follower, $missionRequest->handover, json_encode($approver_id)));
            return redirect()->route('mission-requests.show', $missionRequest->id)->with('success', 'MissionRequest updated successfully');
        } catch (Exception $e) {
            throw $e;
        }
    }


    public function destroy($id)
    {
        try {
            $this->authorize('accessrequest', ['delete']);
            $this->missionRequestService->delete($id);
            return redirect()->back()->with('success', 'MissionRequest Deleted Successfully');
        } catch (Exception $e) {
            throw $e;
        }
    }
}
