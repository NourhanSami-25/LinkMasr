<?php

namespace App\Services\client;

use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\Auth;
use App\Models\client\BillingAddress;

class BillingAddressService
{
    public function getAll()
    {
        return BillingAddress::all();
    }

    public function store(array $data)
    {
        return BillingAddress::create($data);
    }

    public function update($id, array $data)
    {
        $billingAddress = BillingAddress::findOrFail($id);
        $billingAddress->update($data);
        return $billingAddress;
    }

    public function destroy($id)
    {
        $billingAddress = BillingAddress::findOrFail($id);
        $billingAddress->delete();
    }
}
