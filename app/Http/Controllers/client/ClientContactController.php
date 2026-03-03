<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Services\client\ClientContactService;
use App\Http\Requests\client\ClientContactRequest;
use Illuminate\Http\Request;

class ClientContactController extends Controller
{
    protected $clientContactService;

    public function __construct(ClientContactService $clientContactService)
    {
        $this->clientContactService = $clientContactService;
    }

    public function store(ClientContactRequest $request)
    {
        $this->authorize('accessclient', ['details']);
        $clientContact = $this->clientContactService->store($request->validated());
        return redirect()->back()->with('success', 'Client contact created successfully');
    }

    public function update(ClientContactRequest $request, $id)
    {
        $this->authorize('accessclient', ['details']);
        $clientContact = $this->clientContactService->update($id, $request->validated());
        return redirect()->back()->with('success', 'Client contact updated successfully');
    }

    public function destroy($id)
    {
        $this->authorize('accessclient', ['modify']);
        $this->clientContactService->destroy($id);
        return redirect()->back()->with('success', 'Client contact deleted successfull');
    }
}
