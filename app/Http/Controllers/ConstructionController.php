<?php

namespace App\Http\Controllers;

use App\Models\project\Project;
use App\Models\BoqDescriptionPreset;
use App\Services\ConstructionService;
use Illuminate\Http\Request;

class ConstructionController extends Controller
{
    protected $constructionService;

    public function __construct(ConstructionService $constructionService)
    {
        $this->constructionService = $constructionService;
    }

    /**
     * Show Construction Projects List with BOQ overview
     */
    public function index()
    {
        $this->authorize('accessconstruction', ['view']);
        
        $projects = Project::withCount('boqItems')
            ->with(['boqItems' => function($q) {
                $q->selectRaw('project_id, SUM(total_price) as total_budget, COUNT(*) as items_count')
                  ->groupBy('project_id');
            }])
            ->get()
            ->map(function($project) {
                $summary = $this->constructionService->getProjectSummary($project->id);
                $project->evm_summary = $summary;
                return $project;
            });

        return view('construction.index', compact('projects'));
    }

    /**
     * Show EVM Dashboard for a project
     */
    public function evmDashboard($projectId)
    {
        $this->authorize('accessconstruction', ['view']);
        
        $project = Project::findOrFail($projectId);
        
        // Get EVM Summary
        $summary = $this->constructionService->getProjectSummary($projectId);
        
        // Get Cost Control Table Data
        $costControlData = $this->constructionService->getCostControlTable($projectId);
        
        // Get Chart Data for S-Curve
        $chartDataRaw = $this->constructionService->getChartData($projectId);
        
        // Format chart data for Chart.js
        $chartData = [
            'dates' => $chartDataRaw['labels'],
            'pv' => $chartDataRaw['pv'],
            'ev' => $chartDataRaw['ev'],
            'ac' => $chartDataRaw['ac'],
        ];
        
        return view('construction.evm.dashboard', compact(
            'project',
            'summary',
            'costControlData',
            'chartData'
        ));
    }

    /**
     * Show BOQ Management Page
     */
    public function boqIndex($projectId)
    {
        $this->authorize('accessconstruction', ['view']);
        
        $project = Project::with('boqItems')->findOrFail($projectId);
        return view('construction.boq.index', compact('project'));
    }

    /**
     * Store new BOQ item
     */
    public function boqStore(Request $request, $projectId)
    {
        $this->authorize('accessconstruction', ['create']);
        
        $validated = $request->validate([
            'code' => 'nullable|string|max:50',
            'item_description' => 'required|string|max:1024',
            'quantity' => 'required|numeric|min:0',
            'unit' => 'required|string|max:20',
            'unit_price' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $project = Project::findOrFail($projectId);
        
        // Generate code if not provided
        $code = $validated['code'] ?? $this->generateBoqCode($projectId);
        
        $project->boqItems()->create([
            'code' => $code,
            'item_description' => $validated['item_description'],
            'quantity' => $validated['quantity'],
            'unit' => $validated['unit'],
            'unit_price' => $validated['unit_price'],
            'total_price' => $validated['quantity'] * $validated['unit_price'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
        ]);

        return redirect()->back()->with('success', 'تم إضافة بند BOQ بنجاح');
    }
    
    /**
     * Generate BOQ item code
     */
    private function generateBoqCode($projectId)
    {
        $count = \App\Models\ConstructionBoq::where('project_id', $projectId)->count() + 1;
        return sprintf('%04d-%03d', $projectId, $count);
    }

    /**
     * Show Progress Entry Page
     */
    public function progressCreate($projectId)
    {
        $this->authorize('accessconstruction', ['view']);
        
        $project = Project::with('boqItems')->findOrFail($projectId);
        return view('construction.progress.create', compact('project'));
    }

    /**
     * Store Progress Entry
     */
    public function progressStore(Request $request, $projectId)
    {
        $this->authorize('accessconstruction', ['create']);
        
        $validated = $request->validate([
            'boq_id' => 'required|exists:construction_boqs,id',
            'date' => 'required|date',
            'actual_quantity' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        \App\Models\ConstructionProgress::create([
            'boq_id' => $validated['boq_id'],
            'date' => $validated['date'],
            'actual_quantity' => $validated['actual_quantity'],
            'notes' => $validated['notes'],
            'status' => 'approved', // Auto-approve for now
        ]);

        return redirect()->back()->with('success', 'تم تسجيل التقدم بنجاح');
    }

    /**
     * Get all BOQ Description Presets
     */
    public function getDescriptionPresets()
    {
        $presets = BoqDescriptionPreset::active()->ordered()->get();
        return response()->json($presets);
    }

    /**
     * Store new BOQ Description Preset
     */
    public function storeDescriptionPreset(Request $request)
    {
        $this->authorize('accessconstruction', ['create']);
        
        $validated = $request->validate([
            'description' => 'required|string|max:1024|unique:boq_description_presets,description',
            'category' => 'nullable|string|max:255',
        ]);

        $maxOrder = BoqDescriptionPreset::max('sort_order') ?? 0;
        
        $preset = BoqDescriptionPreset::create([
            'description' => $validated['description'],
            'category' => $validated['category'] ?? null,
            'sort_order' => $maxOrder + 1,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'تم إضافة الوصف بنجاح',
            'preset' => $preset
        ]);
    }

    /**
     * Update BOQ Description Preset
     */
    public function updateDescriptionPreset(Request $request, $presetId)
    {
        $this->authorize('accessconstruction', ['edit']);
        
        $preset = BoqDescriptionPreset::findOrFail($presetId);
        
        $validated = $request->validate([
            'description' => 'required|string|max:1024|unique:boq_description_presets,description,' . $presetId,
            'category' => 'nullable|string|max:255',
        ]);

        $preset->update([
            'description' => $validated['description'],
            'category' => $validated['category'] ?? null,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'تم تحديث الوصف بنجاح',
            'preset' => $preset
        ]);
    }

    /**
     * Delete BOQ Description Preset
     */
    public function destroyDescriptionPreset($presetId)
    {
        $this->authorize('accessconstruction', ['delete']);
        
        $preset = BoqDescriptionPreset::findOrFail($presetId);
        $preset->delete();

        return response()->json([
            'success' => true,
            'message' => 'تم حذف الوصف بنجاح'
        ]);
    }
}
