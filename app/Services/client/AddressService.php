<?php

namespace App\Services\client;

use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\Auth;
use App\Models\client\Address;

class AddressService
{
    public function getAll()
    {
        return Address::all();
    }

    public function store(array $data)
    {
        return Address::create($data);
    }

    public function update($id, array $data)
    {
        $address = Address::findOrFail($id);
        $address->update($data);
        return $address;
    }

    public function destroy($id)
    {
        $address = Address::findOrFail($id);
        $address->delete();
    }
}
