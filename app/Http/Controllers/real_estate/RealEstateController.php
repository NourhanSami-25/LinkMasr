<?php

namespace App\Http\Controllers\real_estate;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\project\Project;
use App\Models\user\User;
use App\Services\RealEstateService;
use App\Models\real_estate\ProjectDrawing;

class RealEstateController extends Controller
{
    protected $realEstateService;

    public function __construct(RealEstateService $realEstateService)
    {
        $this->realEstateService = $realEstateService;
    }

    // --- Partners ---

    public function projectPartners($projectId)
    {
        $this->authorize('accessreal_estate', ['view']);
        
        $project = Project::with('partners')->findOrFail($projectId);
        $users = User::all(); // For adding new partners
        
        // Calculate shares for each partner
        $partnersData = $project->partners->map(function($partner) use ($projectId) {
            $financials = $this->realEstateService->calculatePartnerShare($projectId, $partner->id);
            $partner->financials = $financials;
            return $partner;
        });

        return view('real_estate.project.partners', compact('project', 'partnersData', 'users'));
    }

    public function storePartner(Request $request, $projectId)
    {
        $this->authorize('accessreal_estate', ['create']);
        
        $project = Project::findOrFail($projectId);
        $project->partners()->attach($request->partner_id, [
            'share_percentage' => $request->share_percentage,
            'management_fee_percentage' => $request->management_fee_percentage ?? 0
        ]);

        return redirect()->back()->with('success', 'Partner added successfully');
    }

    // --- Financials ---

    public function projectFinancials($projectId)
    {
        $this->authorize('accessreal_estate', ['view']);
        
        $project = Project::findOrFail($projectId);
        $netIncome = $this->realEstateService->calculateProjectNetIncome($projectId);
        
        // Get generic expenses but categorize them
        $operationalExpenses = $project->expenses()->where('category', 'operational')->get();
        $capitalExpenses = $project->expenses()->where('category', 'capital')->get();
        
        return view('real_estate.project.financials', compact('project', 'netIncome', 'operationalExpenses', 'capitalExpenses'));
    }

    // --- Drawings ---
    
    public function projectDrawings($projectId)
    {
        $this->authorize('accessreal_estate', ['view']);
        
        $project = Project::with('drawings.children', 'drawings.units')->findOrFail($projectId);
        return view('real_estate.project.drawings', compact('project'));
    }
    
    public function showDrawing($projectId, $drawingId)
    {
        $this->authorize('accessreal_estate', ['view']);
        
        $project = Project::findOrFail($projectId);
        $drawing = ProjectDrawing::with(['children', 'units'])->findOrFail($drawingId);
        
        return view('real_estate.project.drawing_viewer', compact('project', 'drawing'));
    }

    public function storeDrawing(Request $request, $projectId)
    {
        $this->authorize('accessreal_estate', ['create']);
        
        // Simple file upload logic mock
        $project = Project::findOrFail($projectId);
        // $path = $request->file('file')->store('drawings');
        
        // Mocking save for now
        $project->drawings()->create([
            'title' => $request->title,
            'file_path' => 'mock/path.jpg', 
            'type' => $request->type,
            'pos_x' => $request->pos_x,
            'pos_y' => $request->pos_y,
            'parent_id' => $request->parent_id
        ]);
        
        return redirect()->back();
    }
    
    public function updateUnitCoordinates(Request $request, $projectId, $unitId)
    {
        $this->authorize('accessreal_estate', ['modify']);
        
        $unit = \App\Models\real_estate\PropertyUnit::findOrFail($unitId);
        $unit->update([
            'pos_x' => $request->pos_x,
            'pos_y' => $request->pos_y
        ]);
        
        return response()->json(['success' => true]);
    }
}
