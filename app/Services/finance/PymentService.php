<?php

namespace App\Services\finance;
use Illuminate\Support\Facades\Auth;
use App\Models\finance\Pyment;
use App\Models\client\Client;

class PymentService
{
    public function getAll()
    {
        $authUser = auth()->user();
        if ($authUser->isAdmin() || $authUser->hasAccess('finance', 'full') || $authUser->hasAccess('finance', 'view_global')) {
            return Pyment::all();
        }
        else
        {
             return Pyment::where('created_by' , $authUser->id)->get();
        }
        
    }

    public function create(array $data)
    {
        $pyment = new Pyment();
        $data['created_by'] = Auth::id();
        $pyment->fill($data);
        if ($data['client_id']) {
            $client_name = Client::find($data['client_id'])->name;
            $pyment->client_name = $client_name;
        }
        $pyment->save();
        return $pyment;
    }

    public function update($id, $data)
    {
        $pyment = Pyment::findOrFail($id);
        if ($data['client_id']) {
            $client_name = Client::find($data['client_id'])->name;
            $pyment->client_name = $client_name;
        }
        $pyment->update($data);
        return $pyment;
    }

    public function delete($id)
    {
        $pyment = Pyment::findOrFail($id);
        $pyment->delete();
    }
}
