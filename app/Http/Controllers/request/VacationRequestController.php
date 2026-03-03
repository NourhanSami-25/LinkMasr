<?php

namespace App\Http\Controllers\request;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\request\VacationRequest;
use App\Services\request\VacationRequestService;
use App\Http\Requests\request\VacationRequestRequest;
use App\Models\task\Task;
use App\Models\project\Project;

use App\Models\client\Client;
use App\Models\hr\Balance;
use App\Models\user\User;
use App\Services\utility\NotificationService;
use Illuminate\Support\Facades\Gate;
use App\Services\policy\AccessPolicyService;
use Illuminate\Support\Facades\Auth;
use Exception;

class VacationRequestController extends Controller
{
    protected
        $vacationRequestService, $accessPolicyService, $approveController, $notificationService;

    public function __construct(VacationRequestService $vacationRequestService, AccessPolicyService  $accessPolicyService, ApproveController $approveController, NotificationService $notificationService)
    {
        $this->vacationRequestService = $vacationRequestService;
        $this->approveController = $approveController;
        $this->notificationService = $notificationService;
        $this->accessPolicyService = $accessPolicyService;
    }

    public function index()
    {
        $vacationRequests = $this->vacationRequestService->getAll()->reverse();
        return view('request.vacation.index', compact('vacationRequests'));
    }


    public function create()
    {
        $users = User::select('id', 'name')->where('status', 'active')->get();
        $user = auth()->user();
        $balance = $user->balance;
        return view('request.vacation.create', compact('users', 'balance'));
    }


    public function store(VacationRequestRequest $request)
    {
        try {
            $vacationRequest = $this->vacationRequestService->create($request->validated());
            $approver_id = $this->approveController->getApproverId($vacationRequest);
            $this->notificationService->notify('Create User Request: ' . $vacationRequest->subject, '', 'none', __getUsersFromManyIds($vacationRequest->follower, $vacationRequest->handover, json_encode($approver_id)));
            return redirect()->route('vacation-requests.index')->with('success', 'VacationRequest Created Successfully');
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function show($id)
    {
        $request = VacationRequest::find($id);
        $request->type = 'vacation';
        $approver_id = $this->approveController->getApproverId($request);
        return view('request.all.show', compact('request', 'approver_id'));
    }


    public function edit($id)
    {
        $this->authorize('accessrequest', ['modify']);
        $request = VacationRequest::findOrFail($id);
        $model = 'vacation-requests';
        $tasks = Task::select('id', 'subject', 'client_id')->get();
        $projects = Project::select('id', 'subject', 'client_id')->get();
        
        $clients = Client::select('id', 'name')->where('status', 'active')->get();
        $users = User::select('id', 'name')->where('status', 'active')->get();
        return view('request.all.edit', compact('request', 'model', 'tasks', 'projects', 'clients', 'users'));
    }



    public function update(VacationRequestRequest $request, $id)
    {
        try {
            $vacationRequest = $this->vacationRequestService->update($id, $request->validated());
            $approver_id = $this->approveController->getApproverId($vacationRequest);
            $this->notificationService->notify('Update User Request: ' . $vacationRequest->subject, '', 'none', __getUsersFromManyIds($vacationRequest->follower, $vacationRequest->handover, json_encode($approver_id)));
            return redirect()->route('vacation-requests.show', $vacationRequest->id)->with('success', 'VacationRequest updated successfully');
        } catch (Exception $e) {
            throw $e;
        }
    }



    public function destroy($id)
    {
        try {
            $this->authorize('accessrequest', ['delete']);
            $this->vacationRequestService->delete($id);
            return redirect()->back()->with('success', 'VacationRequest Deleted Successfully');
        } catch (Exception $e) {
            throw $e;
        }
    }
}
