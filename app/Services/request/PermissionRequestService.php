<?php

namespace App\Services\request;


use App\Models\request\PermissionRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\user\User;

class PermissionRequestService
{

    public function getAll()
    {
        $authUser = auth()->user();
        if ($authUser->isAdmin() || $authUser->hasAccess('request', 'full') || $authUser->hasAccess('request', 'view_global')) {
            return PermissionRequest::all();
        }
        else
        {
            $permissionRequests = PermissionRequest::where('user_id', $authUser->id)
                ->orWhereJsonContains('follower', (string) $authUser->id) // Convert user_id to string for JSON match
                ->orWhereJsonContains('handover', (string) $authUser->id)
                ->get();
            return $permissionRequests;
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
        return PermissionRequest::create($data);
    }

    public function update($id, $data)
    {
        $permissionRequest = PermissionRequest::findOrFail($id);
        $permissionRequest->update($data);
        return $permissionRequest;
    }

    public function delete($id)
    {
        $permissionRequest = PermissionRequest::findOrFail($id);
        $permissionRequest->delete();
    }
}
