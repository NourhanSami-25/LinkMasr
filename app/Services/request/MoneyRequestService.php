<?php

namespace App\Services\request;


use App\Models\request\MoneyRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\user\User;

class MoneyRequestService
{
    public function getAll()
    {
        $authUser = auth()->user();
        if ($authUser->isAdmin() || $authUser->hasAccess('request', 'full') || $authUser->hasAccess('request', 'view_global')) {
            return MoneyRequest::all();
        }
        else
        {
            $moneyRequests = MoneyRequest::where('user_id', $authUser->id)
                ->orWhereJsonContains('follower', (string) $authUser->id) // Convert user_id to string for JSON match
                ->orWhereJsonContains('handover', (string) $authUser->id)
                ->get();
            return $moneyRequests;
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

        $moneyRequest = new MoneyRequest();
        $moneyRequest->fill($data);
        $moneyRequest->save();
        return $moneyRequest;
        // return MoneyRequest::create($data);
    }

    public function update($id, $data)
    {
        $moneyRequest = MoneyRequest::findOrFail($id);
        $moneyRequest->update($data);
        return $moneyRequest;
    }

    public function delete($id)
    {
        $moneyRequest = MoneyRequest::findOrFail($id);
        $moneyRequest->delete();
    }
}
