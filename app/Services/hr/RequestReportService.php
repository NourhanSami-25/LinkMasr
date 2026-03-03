<?php

namespace App\Services\hr;


use Illuminate\Support\Collection;
use App\Models\request\VacationRequest;
use App\Models\request\MissionRequest;
use App\Models\request\PermissionRequest;
use App\Models\request\MoneyRequest;
use App\Models\request\OvertimeRequest;
use App\Models\request\SupportRequest;
use App\Models\request\WorkhomeRequest;
use Illuminate\Support\Facades\DB;

class RequestReportService
{

    public function getRequests($type = null): Collection
    {
        $requests = collect();

        $types = [
            'vacation' => VacationRequest::class,
            'mission' => MissionRequest::class,
            'permission' => PermissionRequest::class,
            'money' => MoneyRequest::class,
            'overtime' => OvertimeRequest::class,
            'support' => SupportRequest::class,
            'workhome' => WorkhomeRequest::class,
        ];

        foreach ($types as $key => $model) {
            if (!$type || $type === $key) {
                $requests = $requests->merge(
                    $model::with('user')
                        ->select('*', DB::raw("'$key' as request_type"))
                        ->get()
                );
            }
        }

        return $requests->sortByDesc('created_at')->values();
    }
  
}
