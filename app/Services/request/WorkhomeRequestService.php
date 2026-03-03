<?php

namespace App\Services\request;


use App\Models\request\WorkhomeRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\user\User;


class WorkhomeRequestService
{

    public function getAll()
    {
        $authUser = auth()->user();
        if ($authUser->isAdmin() || $authUser->hasAccess('request', 'full') || $authUser->hasAccess('request', 'view_global')) {
            return WorkhomeRequest::all();
        }
        else
        {
            $workhomeRequests = WorkhomeRequest::where('user_id', $authUser->id)
                ->orWhereJsonContains('follower', (string) $authUser->id) // Convert user_id to string for JSON match
                ->orWhereJsonContains('handover', (string) $authUser->id)
                ->get();
            return $workhomeRequests;
        }
    }

    public function create(array $data)
    {
        $data['user_id'] = Auth::id();
        $data['status'] = 'pending';
        if (!empty($data['follower'])) {
            $data['follower'] = json_encode($data['follower']);
        }
        if (!empty($data['handover'])) {
            $data['handover'] = json_encode($data['handover']);
        }

        switch ($data['related']) {
            case 'task':
                $data['related_work'] = $data['task'];
                break;
            case 'project':
                $data['related_work'] = $data['project'];
                break;
            case 'client':
                $data['related_work'] = $data['client'];
                break;
            default:
                $data['related_work'] = 'none   ';
        }
        return WorkhomeRequest::create($data);
    }

    public function update($id, $data)
    {
        $workhomeRequest = WorkhomeRequest::findOrFail($id);
        $workhomeRequest->update($data);
        return $workhomeRequest;
    }

    public function delete($id)
    {
        $workhomeRequest = WorkhomeRequest::findOrFail($id);
        $workhomeRequest->delete();
    }
}
