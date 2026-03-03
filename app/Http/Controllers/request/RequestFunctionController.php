<?php

namespace App\Http\Controllers\request;

use App\Http\Controllers\Controller;
use App\Models\hr\Department;
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


class RequestFunctionController extends Controller
{

    protected $accessPolicyService;


    public function __construct(AccessPolicyService  $accessPolicyService)
    {
        $this->accessPolicyService = $accessPolicyService;
    }

    protected $models = [
        'mission' => MissionRequest::class,
        'money' => MoneyRequest::class,
        'overtime' => OvertimeRequest::class,
        'permission' => PermissionRequest::class,
        'workhome' => WorkhomeRequest::class,
        'vacation' => VacationRequest::class,
        'support' => SupportRequest::class,
    ];

    protected function getRequestModel($type, $id)
    {
        if (!isset($this->models[$type])) {
            return null;
        }
        return $this->models[$type]::find($id);
    }

    public function is_department_manager($managerId)
    {
        if ($managerId !== auth::id())
            return true;
    }

    public function all_requests()
    {
        $allRequests = collect();
        foreach ($this->models as $type => $model) {
            $requests = $model::all()->map(function ($request) use ($type) {
                return $request->setAttribute('type', $type);
            });
            $allRequests = $allRequests->merge($requests);
        }
        $allRequests = $allRequests->sortByDesc('created_at');
        return view('request.all.staff_requests', compact('allRequests'));
    }

    public function staff_requests()
    {
        $userId = auth()->id(); // ✅ Get the logged-in user ID
        $allRequests = collect();

        foreach ($this->models as $type => $model) {
            $requests = $model::where('user_id', $userId)
                ->orWhereJsonContains('follower', (string) $userId)
                ->orWhereJsonContains('handover', (string) $userId)
                ->get()
                ->map(function ($request) use ($type) {
                    return $request->setAttribute('type', $type);
                });

            $allRequests = $allRequests->merge($requests);
        }

        $allRequests = $allRequests->sortByDesc('created_at');

        return view('request.all.staff_requests', compact('allRequests'));
    }
}
