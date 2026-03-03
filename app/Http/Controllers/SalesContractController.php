<?php

namespace App\Http\Controllers;

use App\Models\SalesContract;
use App\Models\project\Project;
use App\Models\client\Client;
use App\Services\SalesContractService;
use Illuminate\Http\Request;

class SalesContractController extends Controller
{
    protected $contractService;

    public function __construct(SalesContractService $contractService)
    {
        $this->contractService = $contractService;
    }

    /**
     * Show create contract form
     */
    public function create($projectId)
    {
        $project = Project::findOrFail($projectId);
        $availableUnits = $project->units()->where('status', 'available')->get();
        $clients = Client::all();
        
        return view('sales.contracts.create', compact('project', 'availableUnits', 'clients'));
    }

    /**
     * Store new contract
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'unit_id' => 'required|exists:property_units,id',
            'client_id' => 'required|exists:clients,id',
            'total_price' => 'required|numeric|min:0',
            'down_payment' => 'required|numeric|min:0',
            'installment_months' => 'nullable|integer|min:0',
            'contract_date' => 'required|date',
            'delivery_date' => 'nullable|date',
            'notes' => 'nullable|string'
        ]);

        $contract = $this->contractService->createContract($validated);

        return redirect()->route('sales.contracts.show', $contract->id)
            ->with('success', 'تم إنشاء العقد بنجاح');
    }

    /**
     * Show contract details
     */
    public function show($id)
    {
        $summary = $this->contractService->getContractSummary($id);
        
        return view('sales.contracts.show', compact('summary'));
    }

    /**
     * Record payment
     */
    public function recordPayment(Request $request)
    {
        $validated = $request->validate([
            'schedule_id' => 'required|exists:payment_schedules,id',
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date',
            'notes' => 'nullable|string'
        ]);

        $this->contractService->recordPayment(
            $validated['schedule_id'],
            $validated['amount'],
            $validated['date'],
            ['notes' => $validated['notes'] ?? null]
        );

        return redirect()->back()->with('success', 'تم تسجيل الدفعة بنجاح');
    }
}
