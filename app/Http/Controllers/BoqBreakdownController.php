<?php

namespace App\Http\Controllers;

use App\Models\ConstructionBoq;
use App\Models\BoqBreakdownItem;
use App\Models\BoqBreakdownCategory;
use App\Services\BoqBreakdownService;
use Illuminate\Http\Request;

class BoqBreakdownController extends Controller
{
    protected $breakdownService;

    public function __construct(BoqBreakdownService $breakdownService)
    {
        $this->breakdownService = $breakdownService;
    }

    /**
     * Show breakdown for a BOQ item.
     */
    public function show($boqId)
    {
        $this->authorize('accessconstruction', ['view']);
        
        $boq = ConstructionBoq::with(['project', 'breakdownItems.category'])->findOrFail($boqId);
        $categories = BoqBreakdownCategory::orderBy('sort_order')->get();
        $summary = $this->breakdownService->getBreakdownSummary($boq);
        
        return view('construction.boq.breakdown', compact('boq', 'categories', 'summary'));
    }

    /**
     * Store a new breakdown item.
     */
    public function store(Request $request, $boqId)
    {
        $this->authorize('accessconstruction', ['create']);
        
        $validated = $request->validate([
            'category_id' => 'required|exists:boq_breakdown_categories,id',
            'item_code' => 'nullable|string|max:50',
            'description' => 'required|string|max:255',
            'unit' => 'required|string|max:20',
            'quantity' => 'required|numeric|min:0',
            'unit_price' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        $boq = ConstructionBoq::findOrFail($boqId);
        
        $validated['boq_id'] = $boq->id;
        $validated['total_price'] = $validated['quantity'] * $validated['unit_price'];
        
        BoqBreakdownItem::create($validated);

        return redirect()->back()->with('success', 'تم إضافة عنصر التحليل بنجاح');
    }

    /**
     * Update a breakdown item.
     */
    public function update(Request $request, $itemId)
    {
        $this->authorize('accessconstruction', ['modify']);
        
        $validated = $request->validate([
            'category_id' => 'required|exists:boq_breakdown_categories,id',
            'item_code' => 'nullable|string|max:50',
            'description' => 'required|string|max:255',
            'unit' => 'required|string|max:20',
            'quantity' => 'required|numeric|min:0',
            'unit_price' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        $item = BoqBreakdownItem::findOrFail($itemId);
        $validated['total_price'] = $validated['quantity'] * $validated['unit_price'];
        
        $item->update($validated);

        return redirect()->back()->with('success', 'تم تحديث عنصر التحليل بنجاح');
    }

    /**
     * Delete a breakdown item.
     */
    public function destroy($itemId)
    {
        $this->authorize('accessconstruction', ['delete']);
        
        $item = BoqBreakdownItem::findOrFail($itemId);
        $item->delete();

        return redirect()->back()->with('success', 'تم حذف عنصر التحليل بنجاح');
    }

    /**
     * Get breakdown items as JSON (for AJAX).
     */
    public function getItems($boqId)
    {
        $boq = ConstructionBoq::findOrFail($boqId);
        $items = $boq->breakdownItems()->with('category')->get();
        
        return response()->json($items);
    }

    /**
     * Bulk import breakdown items.
     */
    public function import(Request $request, $boqId)
    {
        $this->authorize('accessconstruction', ['create']);
        
        $validated = $request->validate([
            'items' => 'required|array',
            'items.*.category_id' => 'required|exists:boq_breakdown_categories,id',
            'items.*.description' => 'required|string|max:255',
            'items.*.unit' => 'required|string|max:20',
            'items.*.quantity' => 'required|numeric|min:0',
            'items.*.unit_price' => 'required|numeric|min:0',
        ]);

        $boq = ConstructionBoq::findOrFail($boqId);
        
        foreach ($validated['items'] as $itemData) {
            $itemData['boq_id'] = $boq->id;
            $itemData['total_price'] = $itemData['quantity'] * $itemData['unit_price'];
            BoqBreakdownItem::create($itemData);
        }

        return redirect()->back()->with('success', 'تم استيراد عناصر التحليل بنجاح');
    }
}
