<?php

namespace App\Http\Controllers\business;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\task\Task;
use App\Models\project\Project;
use App\Models\user\User;
use App\Models\client\Client;
use App\Models\business\Lead;
use App\Services\business\LeadService;
use App\Http\Requests\business\LeadRequest;
use App\Models\setting\Currency;

use Exception;

class LeadController extends Controller
{
    protected $leadService;
    protected $leadFunctionController;


    public function __construct(LeadService $leadService, LeadFunctionController $leadFunctionController)
    {
        $this->leadService = $leadService;
        $this->leadFunctionController = $leadFunctionController;
    }


    public function index()
    {
        $this->authorize('accesslead', ['view']);
        $leads = $this->leadService->getAll()->reverse();
        return view('business.lead.index', compact('leads'));
    }


    public function create()
    {
        $this->authorize('accesslead', ['create']);
        $users = User::select('id', 'name')->where('status', 'active')->get();
        $currencies = Currency::select('code')->get();
        $lead_number = $this->leadFunctionController->calculate_lead_number();
        return view('business.lead.create', compact( 'users', 'currencies', 'lead_number'));
    }


    public function store(LeadRequest $request)
    {
        try {
            $lead = $this->leadService->create($request->validated());
            return redirect()->route('leads.show', $lead->id)->with('success', 'Lead Created Successfully');
        } catch (Exception $e) {
            throw $e;
        }
    }


    public function show($id)
    {
        $this->authorize('accesslead', ['details']);
        $lead = $this->leadService->getItemById($id);
        return view('business.lead.show', compact('lead'));
    }


    public function edit($id)
    {
        $this->authorize('accesslead', ['modify']);
        $lead = Lead::find($id);
        $users = User::select('id', 'name')->where('status', 'active')->get();
        $currencies = Currency::select('code')->get();
        return view('business.lead.edit', compact('lead',  'users', 'currencies'));
    }


    public function update(LeadRequest $request, $id)
    {
        try {
            $lead = $this->leadService->update($id, $request->validated());
            return redirect()->route('leads.show', $lead->id)->with('success', 'Lead Updated Successfully');
        } catch (Exception $e) {
            throw $e;
        }
    }


    public function destroy($id)
    {
        try {
            $this->authorize('accesslead', ['delete']);
            $this->leadService->delete($id);
            return redirect()->route('leads.index')->with('success', 'Lead Deleted Successfully');
        } catch (Exception $e) {
            throw $e;
        }
    }
}
