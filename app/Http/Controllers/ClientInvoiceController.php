<?php

namespace App\Http\Controllers;

use App\Models\ClientInvoice;
use App\Models\ClientInvoiceItem;
use App\Models\ConstructionBoq;
use App\Models\project\Project;
use Illuminate\Http\Request;

class ClientInvoiceController extends Controller
{
    /**
     * Display a listing of invoices.
     */
    public function index(Request $request)
    {
        $this->authorize('accessinvoices', ['view']);
        
        $query = ClientInvoice::with(['project', 'client']);
        
        if ($request->project_id) {
            $query->where('project_id', $request->project_id);
        }
        
        if ($request->status) {
            $query->where('status', $request->status);
        }
        
        $invoices = $query->orderBy('created_at', 'desc')->paginate(20);
        $projects = Project::all();
        
        return view('invoices.client.index', compact('invoices', 'projects'));
    }

    /**
     * Show the form for creating a new invoice.
     */
    public function create(Request $request)
    {
        $this->authorize('accessinvoices', ['create']);
        
        $project = null;
        $boqItems = collect();
        
        if ($request->project_id) {
            $project = Project::with('boqItems')->findOrFail($request->project_id);
            
            // Get previous quantities for each BOQ item
            $boqItems = $project->boqItems->map(function ($boq) use ($project) {
                $lastInvoiceItem = ClientInvoiceItem::whereHas('invoice', function ($q) use ($project) {
                    $q->where('project_id', $project->id)
                      ->whereIn('status', ['submitted', 'certified', 'invoiced', 'paid']);
                })->where('boq_id', $boq->id)
                  ->orderBy('id', 'desc')
                  ->first();
                
                $boq->previous_qty = $lastInvoiceItem ? $lastInvoiceItem->cumulative_qty : 0;
                $boq->remaining_qty = $boq->quantity - $boq->previous_qty;
                
                return $boq;
            });
        }
        
        $projects = Project::all();
        
        return view('invoices.client.create', compact('projects', 'project', 'boqItems'));
    }

    /**
     * Store a newly created invoice.
     */
    public function store(Request $request)
    {
        $this->authorize('accessinvoices', ['create']);
        
        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'period_from' => 'required|date',
            'period_to' => 'required|date|after_or_equal:period_from',
            'retention_percentage' => 'required|numeric|min:0|max:100',
            'vat_percentage' => 'required|numeric|min:0|max:100',
            'notes' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.boq_id' => 'required|exists:construction_boqs,id',
            'items.*.previous_qty' => 'required|numeric|min:0',
            'items.*.current_qty' => 'required|numeric|min:0',
            'items.*.unit_price' => 'required|numeric|min:0',
        ]);

        $project = Project::findOrFail($validated['project_id']);
        
        // Get previous certified amount
        $previousCertified = ClientInvoice::where('project_id', $validated['project_id'])
            ->whereIn('status', ['certified', 'invoiced', 'paid'])
            ->sum('gross_amount');
        
        // Create invoice
        $invoice = ClientInvoice::create([
            'project_id' => $validated['project_id'],
            'client_id' => $project->client_id ?? null,
            'invoice_no' => ClientInvoice::generateInvoiceNo($validated['project_id']),
            'sequence_no' => ClientInvoice::getNextSequence($validated['project_id']),
            'period_from' => $validated['period_from'],
            'period_to' => $validated['period_to'],
            'gross_amount' => 0,
            'retention_amount' => 0,
            'advance_deduction' => 0,
            'previous_certified' => $previousCertified,
            'net_amount' => 0,
            'vat_percentage' => $validated['vat_percentage'],
            'vat_amount' => 0,
            'total_with_vat' => 0,
            'status' => 'draft',
            'created_by' => auth()->id(),
            'notes' => $validated['notes'],
        ]);

        // Create invoice items
        foreach ($validated['items'] as $itemData) {
            if ($itemData['current_qty'] > 0) {
                ClientInvoiceItem::create([
                    'invoice_id' => $invoice->id,
                    'boq_id' => $itemData['boq_id'],
                    'previous_qty' => $itemData['previous_qty'],
                    'current_qty' => $itemData['current_qty'],
                    'cumulative_qty' => $itemData['previous_qty'] + $itemData['current_qty'],
                    'unit_price' => $itemData['unit_price'],
                    'amount' => $itemData['current_qty'] * $itemData['unit_price'],
                ]);
            }
        }

        // Calculate totals
        $invoice->calculateTotals($validated['retention_percentage'], $validated['vat_percentage']);

        return redirect()->route('client-invoices.show', $invoice->id)
            ->with('success', 'تم إنشاء المستخلص بنجاح');
    }

    /**
     * Display the specified invoice.
     */
    public function show($id)
    {
        $this->authorize('accessinvoices', ['view']);
        
        $invoice = ClientInvoice::with([
            'project',
            'client',
            'items.boq',
        ])->findOrFail($id);
        
        return view('invoices.client.show', compact('invoice'));
    }

    /**
     * Submit invoice for certification.
     */
    public function submit($id)
    {
        $this->authorize('accessinvoices', ['modify']);
        
        $invoice = ClientInvoice::findOrFail($id);
        
        if ($invoice->status !== 'draft') {
            return redirect()->back()->with('error', 'لا يمكن تقديم هذا المستخلص');
        }
        
        $invoice->update(['status' => 'submitted']);

        return redirect()->back()->with('success', 'تم تقديم المستخلص للاعتماد');
    }

    /**
     * Certify invoice.
     */
    public function certify($id)
    {
        $this->authorize('accessinvoices', ['approve']);
        
        $invoice = ClientInvoice::findOrFail($id);
        
        if ($invoice->status !== 'submitted') {
            return redirect()->back()->with('error', 'لا يمكن اعتماد هذا المستخلص');
        }
        
        $invoice->update([
            'status' => 'certified',
            'certified_by' => auth()->id(),
            'certified_at' => now(),
        ]);

        return redirect()->back()->with('success', 'تم اعتماد المستخلص');
    }

    /**
     * Remove the specified invoice.
     */
    public function destroy($id)
    {
        $this->authorize('accessinvoices', ['delete']);
        
        $invoice = ClientInvoice::findOrFail($id);
        
        if ($invoice->status !== 'draft') {
            return redirect()->back()->with('error', 'لا يمكن حذف المستخلص بعد تقديمه');
        }
        
        $invoice->items()->delete();
        $invoice->delete();

        return redirect()->route('client-invoices.index')->with('success', 'تم حذف المستخلص');
    }

    /**
     * Print invoice.
     */
    public function print($id)
    {
        $invoice = ClientInvoice::with([
            'project',
            'client',
            'items.boq',
        ])->findOrFail($id);
        
        return view('invoices.client.print', compact('invoice'));
    }
}
