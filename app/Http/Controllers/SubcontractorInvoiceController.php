<?php

namespace App\Http\Controllers;

use App\Models\Subcontract;
use App\Models\SubcontractItem;
use App\Models\SubcontractorInvoice;
use App\Models\SubcontractorInvoiceItem;
use Illuminate\Http\Request;

class SubcontractorInvoiceController extends Controller
{
    /**
     * Display a listing of invoices.
     */
    public function index(Request $request)
    {
        $this->authorize('accessinvoices', ['view']);
        
        $query = SubcontractorInvoice::with(['subcontract.project', 'subcontract.vendor']);
        
        if ($request->subcontract_id) {
            $query->where('subcontract_id', $request->subcontract_id);
        }
        
        if ($request->status) {
            $query->where('status', $request->status);
        }
        
        $invoices = $query->orderBy('created_at', 'desc')->paginate(20);
        $subcontracts = Subcontract::with('vendor')->get();
        
        return view('invoices.subcontractor.index', compact('invoices', 'subcontracts'));
    }

    /**
     * Show the form for creating a new invoice.
     */
    public function create(Request $request)
    {
        $this->authorize('accessinvoices', ['create']);
        
        $subcontract = null;
        $items = collect();
        
        if ($request->subcontract_id) {
            $subcontract = Subcontract::with('items.boq')->findOrFail($request->subcontract_id);
            
            // Get previous quantities for each item
            $items = $subcontract->items->map(function ($item) use ($subcontract) {
                // Get the last invoice's cumulative qty for this item
                $lastInvoiceItem = SubcontractorInvoiceItem::whereHas('invoice', function ($q) use ($subcontract) {
                    $q->where('subcontract_id', $subcontract->id)
                      ->whereIn('status', ['submitted', 'reviewed', 'approved', 'paid']);
                })->where('subcontract_item_id', $item->id)
                  ->orderBy('id', 'desc')
                  ->first();
                
                $item->previous_qty = $lastInvoiceItem ? $lastInvoiceItem->cumulative_qty : 0;
                $item->remaining_qty = $item->quantity - $item->previous_qty;
                
                return $item;
            });
        }
        
        $subcontracts = Subcontract::where('status', 'active')->with('vendor', 'project')->get();
        
        return view('invoices.subcontractor.create', compact('subcontracts', 'subcontract', 'items'));
    }

    /**
     * Store a newly created invoice.
     */
    public function store(Request $request)
    {
        $this->authorize('accessinvoices', ['create']);
        
        $validated = $request->validate([
            'subcontract_id' => 'required|exists:subcontracts,id',
            'period_from' => 'required|date',
            'period_to' => 'required|date|after_or_equal:period_from',
            'notes' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.subcontract_item_id' => 'required|exists:subcontract_items,id',
            'items.*.previous_qty' => 'required|numeric|min:0',
            'items.*.current_qty' => 'required|numeric|min:0',
            'items.*.unit_price' => 'required|numeric|min:0',
        ]);

        $subcontract = Subcontract::findOrFail($validated['subcontract_id']);
        
        // Create invoice
        $invoice = SubcontractorInvoice::create([
            'subcontract_id' => $validated['subcontract_id'],
            'invoice_no' => SubcontractorInvoice::generateInvoiceNo($validated['subcontract_id']),
            'sequence_no' => SubcontractorInvoice::getNextSequence($validated['subcontract_id']),
            'period_from' => $validated['period_from'],
            'period_to' => $validated['period_to'],
            'gross_amount' => 0,
            'retention_amount' => 0,
            'advance_deduction' => 0,
            'previous_payments' => 0,
            'net_amount' => 0,
            'status' => 'draft',
            'submitted_by' => auth()->id(),
            'notes' => $validated['notes'],
        ]);

        // Create invoice items
        foreach ($validated['items'] as $itemData) {
            if ($itemData['current_qty'] > 0) {
                SubcontractorInvoiceItem::create([
                    'invoice_id' => $invoice->id,
                    'subcontract_item_id' => $itemData['subcontract_item_id'],
                    'previous_qty' => $itemData['previous_qty'],
                    'current_qty' => $itemData['current_qty'],
                    'cumulative_qty' => $itemData['previous_qty'] + $itemData['current_qty'],
                    'unit_price' => $itemData['unit_price'],
                    'amount' => $itemData['current_qty'] * $itemData['unit_price'],
                ]);
            }
        }

        // Calculate totals
        $invoice->calculateTotals();

        return redirect()->route('subcontractor-invoices.show', $invoice->id)
            ->with('success', 'تم إنشاء المستخلص بنجاح');
    }

    /**
     * Display the specified invoice.
     */
    public function show($id)
    {
        $this->authorize('accessinvoices', ['view']);
        
        $invoice = SubcontractorInvoice::with([
            'subcontract.project',
            'subcontract.vendor',
            'items.subcontractItem.boq',
        ])->findOrFail($id);
        
        return view('invoices.subcontractor.show', compact('invoice'));
    }

    /**
     * Submit invoice for approval.
     */
    public function submit($id)
    {
        $this->authorize('accessinvoices', ['modify']);
        
        $invoice = SubcontractorInvoice::findOrFail($id);
        
        if ($invoice->status !== 'draft') {
            return redirect()->back()->with('error', 'لا يمكن تقديم هذا المستخلص');
        }
        
        $invoice->update(['status' => 'submitted']);

        return redirect()->back()->with('success', 'تم تقديم المستخلص للمراجعة');
    }

    /**
     * Approve invoice.
     */
    public function approve($id)
    {
        $this->authorize('accessinvoices', ['approve']);
        
        $invoice = SubcontractorInvoice::findOrFail($id);
        
        if (!in_array($invoice->status, ['submitted', 'reviewed'])) {
            return redirect()->back()->with('error', 'لا يمكن اعتماد هذا المستخلص');
        }
        
        $invoice->update([
            'status' => 'approved',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        return redirect()->back()->with('success', 'تم اعتماد المستخلص');
    }

    /**
     * Mark invoice as paid.
     */
    public function markPaid($id)
    {
        $this->authorize('accessinvoices', ['approve']);
        
        $invoice = SubcontractorInvoice::findOrFail($id);
        
        if ($invoice->status !== 'approved') {
            return redirect()->back()->with('error', 'يجب اعتماد المستخلص أولاً');
        }
        
        $invoice->update(['status' => 'paid']);

        return redirect()->back()->with('success', 'تم تسجيل دفع المستخلص');
    }

    /**
     * Remove the specified invoice.
     */
    public function destroy($id)
    {
        $this->authorize('accessinvoices', ['delete']);
        
        $invoice = SubcontractorInvoice::findOrFail($id);
        
        if ($invoice->status !== 'draft') {
            return redirect()->back()->with('error', 'لا يمكن حذف المستخلص بعد تقديمه');
        }
        
        $invoice->items()->delete();
        $invoice->delete();

        return redirect()->route('subcontractor-invoices.index')->with('success', 'تم حذف المستخلص');
    }

    /**
     * Print invoice.
     */
    public function print($id)
    {
        $invoice = SubcontractorInvoice::with([
            'subcontract.project',
            'subcontract.vendor',
            'items.subcontractItem.boq',
        ])->findOrFail($id);
        
        return view('invoices.subcontractor.print', compact('invoice'));
    }
}
