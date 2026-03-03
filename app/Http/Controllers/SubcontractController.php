<?php

namespace App\Http\Controllers;

use App\Models\Subcontract;
use App\Models\SubcontractItem;
use App\Models\Vendor;
use App\Models\ConstructionBoq;
use App\Models\project\Project;
use Illuminate\Http\Request;

class SubcontractController extends Controller
{
    /**
     * Display a listing of subcontracts.
     */
    public function index(Request $request)
    {
        $this->authorize('accesssubcontracts', ['view']);
        
        $query = Subcontract::with(['project', 'vendor']);
        
        if ($request->project_id) {
            $query->where('project_id', $request->project_id);
        }
        
        if ($request->status) {
            $query->where('status', $request->status);
        }
        
        if ($request->vendor_id) {
            $query->where('vendor_id', $request->vendor_id);
        }
        
        $subcontracts = $query->orderBy('created_at', 'desc')->paginate(20);
        $projects = Project::all();
        $vendors = Vendor::subcontractors()->active()->get();
        
        return view('contracts.subcontracts.index', compact('subcontracts', 'projects', 'vendors'));
    }

    /**
     * Show the form for creating a new subcontract.
     */
    public function create(Request $request)
    {
        $this->authorize('accesssubcontracts', ['create']);
        
        $projects = Project::all();
        $vendors = Vendor::subcontractors()->active()->get();
        $boqItems = [];
        
        if ($request->project_id) {
            $boqItems = ConstructionBoq::where('project_id', $request->project_id)->get();
        }
        
        return view('contracts.subcontracts.create', compact('projects', 'vendors', 'boqItems'));
    }

    /**
     * Store a newly created subcontract.
     */
    public function store(Request $request)
    {
        $this->authorize('accesssubcontracts', ['create']);
        
        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'vendor_id' => 'required|exists:vendors,id',
            'title' => 'required|string|max:255',
            'scope' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'retention_percentage' => 'required|numeric|min:0|max:100',
            'advance_percentage' => 'nullable|numeric|min:0|max:100',
            'insurance_percentage' => 'nullable|numeric|min:0|max:100',
            'terms' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.boq_id' => 'required|exists:construction_boqs,id',
            'items.*.quantity' => 'required|numeric|min:0',
            'items.*.unit_price' => 'required|numeric|min:0',
        ]);

        $contractNo = Subcontract::generateContractNo($validated['project_id']);
        
        $subcontract = Subcontract::create([
            'project_id' => $validated['project_id'],
            'vendor_id' => $validated['vendor_id'],
            'contract_no' => $contractNo,
            'title' => $validated['title'],
            'scope' => $validated['scope'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'retention_percentage' => $validated['retention_percentage'],
            'advance_percentage' => $validated['advance_percentage'] ?? 0,
            'insurance_percentage' => $validated['insurance_percentage'] ?? 0,
            'terms' => $validated['terms'],
            'contract_value' => 0,
            'status' => 'draft',
            'created_by' => auth()->id(),
        ]);

        $totalValue = 0;
        foreach ($validated['items'] as $itemData) {
            $boq = ConstructionBoq::find($itemData['boq_id']);
            $totalPrice = $itemData['quantity'] * $itemData['unit_price'];
            $totalValue += $totalPrice;
            
            SubcontractItem::create([
                'subcontract_id' => $subcontract->id,
                'boq_id' => $itemData['boq_id'],
                'description' => $boq->item_description,
                'quantity' => $itemData['quantity'],
                'unit_price' => $itemData['unit_price'],
                'total_price' => $totalPrice,
            ]);
        }
        
        $subcontract->update(['contract_value' => $totalValue]);

        return redirect()->route('subcontracts.show', $subcontract->id)
            ->with('success', 'تم إنشاء العقد بنجاح');
    }

    /**
     * Display the specified subcontract.
     */
    public function show($id)
    {
        $this->authorize('accesssubcontracts', ['view']);
        
        $subcontract = Subcontract::with([
            'project', 
            'vendor', 
            'items.boq', 
            'invoices'
        ])->findOrFail($id);
        
        return view('contracts.subcontracts.show', compact('subcontract'));
    }

    /**
     * Show the form for editing the specified subcontract.
     */
    public function edit($id)
    {
        $this->authorize('accesssubcontracts', ['modify']);
        
        $subcontract = Subcontract::with('items.boq')->findOrFail($id);
        
        if ($subcontract->status !== 'draft') {
            return redirect()->back()->with('error', 'لا يمكن تعديل العقد بعد تفعيله');
        }
        
        $projects = Project::all();
        $vendors = Vendor::subcontractors()->active()->get();
        $boqItems = ConstructionBoq::where('project_id', $subcontract->project_id)->get();
        
        return view('contracts.subcontracts.edit', compact('subcontract', 'projects', 'vendors', 'boqItems'));
    }

    /**
     * Update the specified subcontract.
     */
    public function update(Request $request, $id)
    {
        $this->authorize('accesssubcontracts', ['modify']);
        
        $subcontract = Subcontract::findOrFail($id);
        
        if ($subcontract->status !== 'draft') {
            return redirect()->back()->with('error', 'لا يمكن تعديل العقد بعد تفعيله');
        }
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'scope' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'retention_percentage' => 'required|numeric|min:0|max:100',
            'advance_percentage' => 'nullable|numeric|min:0|max:100',
            'insurance_percentage' => 'nullable|numeric|min:0|max:100',
            'terms' => 'nullable|string',
        ]);

        $subcontract->update($validated);

        return redirect()->route('subcontracts.show', $subcontract->id)
            ->with('success', 'تم تحديث العقد بنجاح');
    }

    /**
     * Activate the subcontract.
     */
    public function activate($id)
    {
        $this->authorize('accesssubcontracts', ['approve']);
        
        $subcontract = Subcontract::findOrFail($id);
        
        if ($subcontract->status !== 'draft') {
            return redirect()->back()->with('error', 'العقد مفعل بالفعل');
        }
        
        $subcontract->update(['status' => 'active']);

        return redirect()->back()->with('success', 'تم تفعيل العقد بنجاح');
    }

    /**
     * Complete the subcontract.
     */
    public function complete($id)
    {
        $this->authorize('accesssubcontracts', ['approve']);
        
        $subcontract = Subcontract::findOrFail($id);
        $subcontract->update(['status' => 'completed']);

        return redirect()->back()->with('success', 'تم إتمام العقد بنجاح');
    }

    /**
     * Remove the specified subcontract.
     */
    public function destroy($id)
    {
        $this->authorize('accesssubcontracts', ['delete']);
        
        $subcontract = Subcontract::findOrFail($id);
        
        if ($subcontract->status !== 'draft') {
            return redirect()->back()->with('error', 'لا يمكن حذف العقد بعد تفعيله');
        }
        
        if ($subcontract->invoices()->exists()) {
            return redirect()->back()->with('error', 'لا يمكن حذف العقد لوجود مستخلصات مرتبطة');
        }
        
        $subcontract->items()->delete();
        $subcontract->delete();

        return redirect()->route('subcontracts.index')->with('success', 'تم حذف العقد بنجاح');
    }

    /**
     * Get BOQ items for a project (AJAX).
     */
    public function getBoqItems($projectId)
    {
        $boqItems = ConstructionBoq::where('project_id', $projectId)
            ->select('id', 'code', 'item_description', 'unit', 'quantity', 'unit_price')
            ->get();
        
        return response()->json($boqItems);
    }
}
