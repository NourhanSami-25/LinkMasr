<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Services\client\AddressService;
use App\Http\Requests\client\AddressRequest;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    protected $addressService;

    public function __construct(AddressService $addressService)
    {
        $this->addressService = $addressService;
    }

    public function store(AddressRequest $request)
    {
        $this->authorize('accessclient', ['details']);
        $address = $this->addressService->store($request->validated());
        return redirect()->back()->with('success', 'Client address created successfully');
    }

    public function update(AddressRequest $request, $id)
    {
        $this->authorize('accessclient', ['details']);
        $address = $this->addressService->update($id, $request->validated());
        return redirect()->back()->with('success', 'Client address updated successfully');
    }

    public function destroy($id)
    {
        $this->authorize('accessclient', ['modify']);
        $this->addressService->destroy($id);
        return redirect()->back()->with('success', 'Client address deleted successfull');
    }
}
