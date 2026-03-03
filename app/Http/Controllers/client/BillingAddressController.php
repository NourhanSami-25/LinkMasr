<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Services\client\BillingAddressService;
use App\Http\Requests\client\BillingAddressRequest;
use Illuminate\Http\Request;

class BillingAddressController extends Controller
{
    protected $billingAddressService;

    public function __construct(BillingAddressService $billingAddressService)
    {
        $this->billingAddressService = $billingAddressService;
    }

    public function store(BillingAddressRequest $request)
    {
        $this->authorize('accessclient', ['details']);
        $billingAddress = $this->billingAddressService->store($request->validated());
        return redirect()->back()->with('success', 'Billing address created successfully');
    }

    public function update(BillingAddressRequest $request, $id)
    {
        $this->authorize('accessclient', ['details']);
        $billingAddress = $this->billingAddressService->update($id, $request->validated());
        return redirect()->back()->with('success', 'Billing address updated successfully');
    }

    public function destroy($id)
    {
        $this->authorize('accessclient', ['modify']);
        $this->billingAddressService->destroy($id);
        return redirect()->back()->with('success', 'Billing address deleted successfull');
    }
}
