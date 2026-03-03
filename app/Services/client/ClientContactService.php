<?php

namespace App\Services\client;

use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\Auth;
use App\Models\client\ClientContact;

class ClientContactService
{
    public function getAll()
    {
        return ClientContact::all();
    }

    public function store(array $data)
    {
        return ClientContact::create($data);
    }

    public function update($id, array $data)
    {
        $contact = ClientContact::findOrFail($id);
        $contact->update($data);
        return $contact;
    }

    public function destroy($id)
    {
        $contact = ClientContact::findOrFail($id);
        $contact->delete();
    }
}
