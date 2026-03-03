<?php

namespace App\Http\Controllers\request;

use App\Http\Controllers\Controller;
use App\Models\hr\Department;
use App\Models\hr\Sector;
use Illuminate\Http\Request;
use App\Models\request\MissionRequest;
use App\Models\request\MoneyRequest;
use App\Models\request\OvertimeRequest;
use App\Models\request\PermissionRequest;
use App\Models\request\WorkhomeRequest;
use App\Models\request\VacationRequest;
use App\Models\request\SupportRequest;
use App\Models\user\User;
use Illuminate\Support\Facades\Auth;
use App\Services\policy\AccessPolicyService;
use App\Services\utility\NotificationService;

class ApproveController extends Controller
{
    protected $accessPolicyService, $notificationService;
    protected $models = [
        'mission' => MissionRequest::class,
        'money' => MoneyRequest::class,
        'overtime' => OvertimeRequest::class,
        'permission' => PermissionRequest::class,
        'workhome' => WorkhomeRequest::class,
        'vacation' => VacationRequest::class,
        'support' => SupportRequest::class,
    ];


    public function __construct(AccessPolicyService $accessPolicyService, NotificationService $notificationService)
    {
        $this->accessPolicyService = $accessPolicyService;
        $this->notificationService = $notificationService;
    }

    public function managed_requests($userId)
    {
        // 0- Get user
        $user = User::findOrFail($userId);

        // 1- Check approve policy
        $this->authorize('accessapprove', ['full']);

        // Separate collections for sector and department requests
        $sectorRequests = collect();
        $departmentRequests = collect();

        // 2- Check if user is a sector manager
        if ($user->managedSectors()->exists()) {
            $sectorIds = $user->managedSectors->pluck('id');

            // Get department managers of the sectors managed by this user
            $departmentManagers = Department::whereIn('sector_id', $sectorIds)
                ->whereNotNull('manager_id')
                ->where('manager_id', '!=', $user->id) // Exclude the current user
                ->pluck('manager_id');

            foreach ($this->models as $type => $model) {
                $model::whereIn('user_id', $departmentManagers)
                    ->lazy()
                    ->each(fn ($item) => $sectorRequests->push(
                        $item->setAttribute('type', $type)->setAttribute('source', 'sector')
                    ));
            }
        }


        // 3- Check if user is a department manager
        if ($user->managedDepartment()->exists()) {
            // Get all users in the department except the manager himself
            $userIds = User::whereIn('department_id', $user->managedDepartment->pluck('id'))
                ->where(
                    'id',
                    '!=',
                    $user->id
                ) // Exclude the current user
                ->pluck('id');

            foreach ($this->models as $type => $model) {
                $model::whereIn('user_id', $userIds)
                    ->lazy()
                    ->each(fn ($item) => $departmentRequests->push(
                        $item->setAttribute('type', $type)->setAttribute('source', 'department')
                    ));
            }
        }


        // 4- Apply uniqueness separately
        $sectorRequests = $sectorRequests->unique(fn ($request) => $request['type'] . '-' . $request['id']);
        $departmentRequests = $departmentRequests->unique(fn ($request) => $request['type'] . '-' . $request['id']);

        // 5- Merge and apply final uniqueness
        $allRequests = $sectorRequests->merge($departmentRequests)->unique(fn ($request) => $request['type'] . '-' . $request['id']);


        // 6- Return requests
        return view('request.all.managed_requests', compact('allRequests'));
    }


    public function getApproverId($request)
    {
        $user = User::findOrFail($request->user_id);
        $approver_id = null;
        if ($user->managedSectors()->exists()) {
            $approver_id = $user->id;
            return  $approver_id;
        } elseif ($user->managedDepartment()->exists()) {
            $approver_id = $user->department->sector->manager_id ?? null;
            return  $approver_id;
        } else {
            $approver_id = $user->department->manager_id ?? null;
            return  $approver_id;
        }
    }


    public function getRequestModel($type, $id)
    {
        if (!isset($this->models[$type])) {
            return null;
        }
        return $this->models[$type]::find($id);
    }


    public function approve_request(Request $request, $type, $id)
    {
        $this->authorize('accessapprove', ['full']);
        $requestModel = $this->getRequestModel($type, $id);
        if (!$requestModel) {
            return redirect()->back()->with('warning', 'Invalid request type or ID');
        }
        if (in_array($requestModel->status, ['approved', 'canceled'])) {
            return redirect()->back()->with('warning', 'Request cannot be approved');
        }
        
        // Deduct vacation balance when vacation request is approved
        if ($type === 'vacation') {
            $user = User::find($requestModel->user_id);
            if ($user && $user->balance) {
                $balance = $user->balance;
                $vacationDays = $this->calculateVacationDays($requestModel);
                
                // Check if user has enough balance
                if ($balance->vacation_balance < $vacationDays) {
                    return redirect()->back()->with('warning', 'رصيد الإجازات غير كافٍ');
                }
                
                // Deduct from vacation balance
                $balance->vacation_balance -= $vacationDays;
                $balance->save();
            }
        }
        
        // Deduct permission balance when permission request is approved
        if ($type === 'permission') {
            $user = User::find($requestModel->user_id);
            if ($user && $user->balance) {
                $balance = $user->balance;
                $permissionHours = $requestModel->hours ?? 0;
                
                // Check monthly limit (e.g., 4 hours max per month)
                $monthlyLimit = 4;
                $usedThisMonth = $this->getMonthlyPermissionHours($requestModel->user_id);
                
                if (($usedThisMonth + $permissionHours) > $monthlyLimit) {
                    return redirect()->back()->with('warning', 'تم تجاوز الحد الأقصى الشهري للأذونات (' . $monthlyLimit . ' ساعات)');
                }
            }
        }
        
        $requestModel->update(['status' => 'approved']);
        $requestModel->update(['approver' => $request->approver]);
        return redirect()->back()->with('success', 'Request approved successfully');
    }
    
    /**
     * Calculate vacation days from request
     */
    private function calculateVacationDays($vacationRequest)
    {
        if ($vacationRequest->date_from && $vacationRequest->date_to) {
            $from = \Carbon\Carbon::parse($vacationRequest->date_from);
            $to = \Carbon\Carbon::parse($vacationRequest->date_to);
            return $from->diffInDays($to) + 1;
        }
        return $vacationRequest->days ?? 1;
    }
    
    /**
     * Get total permission hours used this month
     */
    private function getMonthlyPermissionHours($userId)
    {
        $startOfMonth = \Carbon\Carbon::now()->startOfMonth();
        $endOfMonth = \Carbon\Carbon::now()->endOfMonth();
        
        return \App\Models\request\PermissionRequest::where('user_id', $userId)
            ->where('status', 'approved')
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->sum('hours');
    }


    public function reject_request(Request $request, $type, $id)
    {
        $this->authorize('accessapprove', ['full']);
        $requestModel = $this->getRequestModel($type, $id);
        if (!$requestModel) {
            return redirect()->back()->with('warning', 'Invalid request type or ID');
        }
        if (in_array($requestModel->status, ['rejected', 'canceled'])) {
            return redirect()->back()->with('warning', 'Request cannot be rejected');
        }
        $requestModel->update(['status' => 'rejected']);
        $requestModel->update(['approver' => $request->approver]);
        return redirect()->back()->with('success', 'Request rejected successfully');
    }



    public function cancel_request($type, $id)
    {
        $requestModel = $this->getRequestModel($type, $id);
        if (!$requestModel) {
            return redirect()->back()->with('warning', 'Invalid request type or ID');
        }
        if (in_array($requestModel->status, ['approved', 'rejected', 'canceled'])) {
            return redirect()->back()->with('warning', 'Request cannot be canceled');
        }
        $requestModel->update(['status' => 'canceled']);
        $approver_id = $this->getApproverId($requestModel);
        $this->notificationService->notify('Cancel User Request: ' . $requestModel->subject, '', 'none', __getUsersFromManyIds($requestModel->follower, $requestModel->handover, json_encode($approver_id)));
        return redirect()->back()->with('success', 'Request canceled successfully');
    }
}
