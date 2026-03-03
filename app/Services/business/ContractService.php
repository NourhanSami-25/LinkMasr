<?php

namespace App\Services\business;


use App\Models\business\Contract;
use App\Models\client\Client;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;


class ContractService
{
    public function getAll()
    {
        return Contract::all();
    }

    public function create(array $data)
    {
        $data['created_by'] = Auth::id();
        $contract = new Contract();
        $contract->fill($data);
        if ($data['client_id']) {
            $client_name = Client::find($data['client_id'])->name; // SIMULATOR
            $contract->client_name = $client_name;
        }
        $contract->save();
        return $contract;
    }

    public function getItemById($id)
    {
        $contract = Contract::findOrFail($id);
        return $contract;
    }

    public function update($id, $data)
    {
        $contract = Contract::findOrFail($id);
        $contract->update($data);
        return $contract;
    }

    public function delete($id)
    {
        $contract = Contract::findOrFail($id);
        $contract->delete();
    }

    public function checkExpiration()
    {
        $today = Carbon::today();
        $nextMonth = Carbon::today()->addMonth();

        $aboutToExpireContracts = Contract::whereBetween('due_date', [$today, $nextMonth])
            ->pluck('id')
            ->toArray();

        // NOW WE WANT TO NOTIFY
        // appear on top of contracts page , 
    }
}
