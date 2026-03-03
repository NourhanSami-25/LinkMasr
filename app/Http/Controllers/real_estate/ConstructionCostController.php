<?php

namespace App\Http\Controllers\real_estate;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\real_estate\ConstructionMaterial;
use App\Models\real_estate\MaterialPrice;
use App\Models\real_estate\CostEstimate;
use App\Models\project\Project;
use App\Services\ConstructionCostService;

class ConstructionCostController extends Controller
{
    protected $costService;

    public function __construct(ConstructionCostService $costService)
    {
        $this->costService = $costService;
    }

    // --- Materials Management ---
    public function indexMaterials()
    {
        $this->authorize('accessreal_estate', ['view']);
        
        $materials = ConstructionMaterial::with(['prices' => function($q) {
            $q->orderBy('date', 'desc');
        }])->get();
        
        // Add latest_price to each material
        foreach ($materials as $material) {
            $material->latest_price = $material->prices->first()?->price ?? 0;
        }
        
        return view('real_estate.materials.index', compact('materials'));
    }

    public function storeMaterial(Request $request)
    {
        $this->authorize('accessreal_estate', ['create']);
        
        $request->validate(['name' => 'required', 'unit' => 'required']);
        $material = ConstructionMaterial::create($request->only(['name', 'unit', 'description']));
        
        // If initial price is provided, create first price entry
        if ($request->filled('initial_price') && $request->initial_price > 0) {
            MaterialPrice::create([
                'material_id' => $material->id,
                'price' => $request->initial_price,
                'date' => now()->format('Y-m-d')
            ]);
        }
        
        return redirect()->back()->with('success', 'تم إضافة المادة بنجاح');
    }

    public function updateMaterial(Request $request, $id)
    {
        $this->authorize('accessreal_estate', ['modify']);
        
        $request->validate(['name' => 'required', 'unit' => 'required']);
        $material = ConstructionMaterial::findOrFail($id);
        $material->update($request->only(['name', 'unit', 'description']));
        return redirect()->back()->with('success', 'تم تحديث المادة بنجاح');
    }

    public function storePrice(Request $request, $materialId)
    {
        $this->authorize('accessreal_estate', ['create']);
        
        $request->validate(['price' => 'required|numeric', 'date' => 'required|date']);
        
        MaterialPrice::create([
            'material_id' => $materialId,
            'price' => $request->price,
            'date' => $request->date
        ]);
        
        return redirect()->back()->with('success', 'Price updated');
    }

    // --- Estimation ---
    public function indexEstimates()
    {
        $this->authorize('accessreal_estate', ['view']);
        
        $estimates = CostEstimate::with(['project', 'unit'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        
        return view('real_estate.estimates.index', compact('estimates'));
    }

    public function createEstimate()
    {
        $this->authorize('accessreal_estate', ['view']);
        
        $materials = ConstructionMaterial::all();
        $projects = Project::with('units')->get();
        
        return view('real_estate.estimates.create', compact('materials', 'projects'));
    }

    public function storeEstimate(Request $request)
    {
        $this->authorize('accessreal_estate', ['create']);
        
        $data = $request->validate([
            'title' => 'required',
            'type' => 'required',
            'project_id' => 'nullable|exists:projects,id',
            'unit_id' => 'nullable|exists:property_units,id',
            'licensing_fees' => 'nullable|numeric',
            'other_fees' => 'nullable|numeric',
            'items' => 'required|array',
            'items.*.material_id' => 'required|exists:construction_materials,id',
            'items.*.quantity' => 'required|numeric|min:0.1'
        ]);

        $estimate = $this->costService->createEstimate($data);

        return redirect()->route('estimates.show', $estimate->id)->with('success', 'Estimate Created');
    }

    public function showEstimate($id)
    {
        $this->authorize('accessreal_estate', ['view']);
        
        $estimate = CostEstimate::with('items.material')->findOrFail($id);
        return view('real_estate.estimates.show', compact('estimate'));
    }

    public function deleteEstimate($id)
    {
        $this->authorize('accessreal_estate', ['delete']);
        
        $estimate = CostEstimate::findOrFail($id);
        $estimate->items()->delete();
        $estimate->delete();
        
        return redirect()->route('estimates.index')->with('success', 'تم حذف التقدير بنجاح');
    }

    // API to get price for generic calculator interaction
    public function getPrice($materialId)
    {
        $price = $this->costService->getMaterialPrice($materialId);
        return response()->json(['price' => $price]);
    }
}
