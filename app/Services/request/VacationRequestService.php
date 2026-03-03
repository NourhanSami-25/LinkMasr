<?php

namespace App\Services\request;


use App\Models\request\VacationRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\user\User;

class VacationRequestService
{

    public function getAll()
    {
        $authUser = auth()->user();
        if ($authUser->isAdmin() || $authUser->hasAccess('request', 'full') || $authUser->hasAccess('request', 'view_global')) {
            return VacationRequest::all();
        }
        else
        {
            $vacationRequests = VacationRequest::where('user_id', $authUser->id)
                ->orWhereJsonContains('follower', (string) $authUser->id) // Convert user_id to string for JSON match
                ->orWhereJsonContains('handover', (string) $authUser->id)
                ->get();
            return $vacationRequests;
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
        return VacationRequest::create($data);
    }

    public function update($id, $data)
    {
        $vacationRequest = VacationRequest::findOrFail($id);
        $vacationRequest->update($data);
        return $vacationRequest;
    }

    public function delete($id)
    {
        $vacationRequest = VacationRequest::findOrFail($id);
        
        // If the request was approved, restore the vacation balance
        if ($vacationRequest->status === 'approved') {
            $user = User::find($vacationRequest->user_id);
            if ($user && $user->balance) {
                $balance = $user->balance;
                $vacationDays = $this->calculateVacationDays($vacationRequest);
                
                // Restore vacation balance
                $balance->vacation_balance += $vacationDays;
                $balance->save();
            }
        }
        
        $vacationRequest->delete();
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
}
