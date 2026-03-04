<?php

namespace App\Services\business;


use App\Models\business\Proposal;
use App\Models\client\Client;
use Illuminate\Support\Facades\Auth;


class ProposalService
{
    public function getAll()
    {
        return Proposal::all();
    }

    public function create(array $data)
    {
        $data['created_by'] = Auth::id();
        $data['user_id'] = Auth::id(); // Add user_id
        $data['related'] = 'proposal'; // Add default related value
        $data['payment_currency'] = $data['currency'] ?? 'EGP'; // Add payment_currency
        $proposal = new Proposal();
        $proposal->fill($data);
        if ($data['client_id']) {
            $client_name = Client::find($data['client_id'])->name;  // SIMULATOR
            $proposal->client_name = $client_name;
        }
        $proposal->save();
        return $proposal;
    }

    public function getItemById($id)
    {
        $proposal = Proposal::findOrFail($id);
        return $proposal;
    }

    public function update($id, $data)
    {
        $proposal = Proposal::findOrFail($id);
        $proposal->update($data);
        return $proposal;
    }

    public function delete($id)
    {
        $proposal = Proposal::findOrFail($id);
        $proposal->delete();
    }
}
