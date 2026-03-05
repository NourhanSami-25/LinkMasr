<?php

namespace App\Services\request;

use App\Models\request\MissionRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\user\User;


class MissionRequestService
{
    public function getAll()
    {
        $authUser = auth()->user();
        if ($authUser->isAdmin() || $authUser->hasAccess('request', 'full') || $authUser->hasAccess('request', 'view_global')) {
            return MissionRequest::all();
        }
        else
        {
            $missionRequests = MissionRequest::where('user_id', $authUser->id)
                ->orWhereJsonContains('follower', (string) $authUser->id) // Convert user_id to string for JSON match
                ->orWhereJsonContains('handover', (string) $authUser->id)
                ->get();
            return $missionRequests;
        }
    }

    public function create(array $data)
    {
        $data['user_id'] = Auth::id();
        $data['status'] = 'pending';
        $data['approver_id'] = 1; // Default approver
        $data['approver_name'] = 'Administrator'; // Default approver name

        if (!empty($data['follower'])) {
            $data['follower'] = json_encode($data['follower']);
        }
        if (!empty($data['handover'])) {
            $data['handover'] = json_encode($data['handover']);
        }

        switch ($data['related']) {
            case 'task':
                $data['related_work'] = $data['task'];
                $data['task_name'] = $data['task'];
                break;
            case 'project':
                $data['related_work'] = $data['project'];
                $data['task_name'] = null;
                break;
            case 'client':
                $data['related_work'] = $data['client'];
                $data['task_name'] = null;
                break;
            default:
                $data['related_work'] = 'none';
                $data['task_name'] = null;
        }

        return MissionRequest::create($data);
    }

    public function update($id, $data)
    {
        $missionRequest = MissionRequest::findOrFail($id);
        $missionRequest->update($data);
        return $missionRequest;
    }

    public function delete($id)
    {
        $missionRequest = MissionRequest::findOrFail($id);
        $missionRequest->delete();
    }
}
