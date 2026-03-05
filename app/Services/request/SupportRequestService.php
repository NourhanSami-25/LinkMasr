<?php

namespace App\Services\request;


use App\Models\request\SupportRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\user\User;
use App\Services\utility\NotificationService;

class SupportRequestService
{

    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function getAll()
    {
        $authUser = auth()->user();
        if ($authUser->isAdmin() || $authUser->hasAccess('request', 'full') || $authUser->hasAccess('request', 'view_global')) {
            return SupportRequest::all();
        }
        else
        {
            $supportRequests = SupportRequest::where('user_id', $authUser->id)
                ->orWhereJsonContains('follower', (string) $authUser->id) // Convert user_id to string for JSON match
                ->orWhereJsonContains('handover', (string) $authUser->id)
                ->get();
            return $supportRequests;
        }
    }


    public function create(array $data)
    {
        $data['user_id'] = Auth::id();
        $data['status'] = 'pending';
        $data['approver_id'] = 1;
        $data['approver_name'] = 'Administrator';
        if (!empty($data['follower'])) {
            $data['follower'] = json_encode($data['follower']);
        }
        if (!empty($data['handover'])) {
            $data['handover'] = json_encode($data['handover']);
        }
        $supportRequest = SupportRequest::create($data);

        // $this->notificationService->notify($supportRequest->subject, 'www.google.com', Auth::user());

        return $supportRequest;
    }

    public function update($id, $data)
    {
        $supportRequest = SupportRequest::findOrFail($id);
        $supportRequest->update($data);
        return $supportRequest;
    }

    public function delete($id)
    {
        $supportRequest = SupportRequest::findOrFail($id);
        $supportRequest->delete();
    }
}
