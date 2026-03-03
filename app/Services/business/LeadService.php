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
