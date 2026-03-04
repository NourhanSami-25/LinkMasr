<?php

namespace App\Services\business;


use App\Models\business\Lead;
use App\Models\client\Client;
use Illuminate\Support\Facades\Auth;


class LeadService
{
    public function getAll()
    {
        return Lead::all();
    }

    public function create(array $data)
    {
        $data['created_by'] = Auth::id();
        $data['user_id'] = Auth::id(); // Set user_id for compatibility
        $data['client_id'] = 1; // Set default client_id
        $data['created_since'] = $data['date'] ?? now(); // Use date field or current time
        
        // Set default status if not provided
        if (!isset($data['status'])) {
            $data['status'] = 'in_progress';
        }
        
        // Set lead_name from client_name if not provided
        if (!isset($data['lead_name']) || empty($data['lead_name'])) {
            $data['lead_name'] = $data['client_name'] ?? 'عميل محتمل';
        }
        
        $lead = new Lead();
        $lead->fill($data);
        $lead->save();
        return $lead;
    }

    public function getItemById($id)
    {
        $lead = Lead::findOrFail($id);
        return $lead;
    }

    public function update($id, $data)
    {
        $lead = Lead::findOrFail($id);
        $lead->update($data);
        return $lead;
    }

    public function delete($id)
    {
        $lead = Lead::findOrFail($id);
        $lead->delete();
    }
}
