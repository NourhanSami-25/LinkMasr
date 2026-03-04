<?php

namespace App\Http\Controllers;

use App\Models\user\User;
use App\Models\project\Project;
use App\Models\real_estate\ProjectPartner;
use App\Models\PartnerWithdrawal;
use App\Services\RevenueDistributionService;
use Illuminate\Http\Request;

class PartnerController extends Controller
{
    protected $revenueService;

    public function __construct(RevenueDistributionService $revenueService)
    {
        $this->revenueService = $revenueService;
    }

    /**
     * Admin: Partners Management - All Partners List
     */
    public function index()
    {
        $this->authorize('accesspartners', ['view']);
        
        // Get all projects with their partners
        $projects = Project::with(['partners' => function($q) {
            $q->withPivot('share_percentage', 'management_fee_percentage');
        }])->get();

        // Get all users who are partners in any project
        $partners = User::whereHas('partnerProjects')->with(['partnerProjects' => function($q) {
            $q->withPivot('share_percentage', 'management_fee_percentage');
        }])->get();

        // Get recent withdrawals
        $recentWithdrawals = PartnerWithdrawal::with(['partner', 'project'])
            ->orderBy('date', 'desc')
            ->limit(10)
            ->get();

        return view('partners.index', compact('projects', 'partners', 'recentWithdrawals'));
    }

    /**
     * Admin: Create New Partner (User) and optionally add to project
     */
    public function createPartner(Request $request)
    {
        $this->authorize('accesspartners', ['create']);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|string|min:6',
            'address' => 'nullable|string',
            'project_id' => 'nullable|exists:projects,id',
            'share_percentage' => 'nullable|numeric|min:0|max:100',
            'management_fee_percentage' => 'nullable|numeric|min:0|max:100',
        ]);

        // Create the user
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'password' => bcrypt($validated['password']),
            'address' => $validated['address'] ?? null,
            'department_id' => 1, // Default to Administration department
            'position_id' => 1, // Default to Administrator position
            'role_id' => 1, // Default to Administrator role
            'status' => 'active',
        ]);

        // If project is selected, add as partner
        if ($validated['project_id'] && $validated['share_percentage'] !== null && $validated['management_fee_percentage'] !== null) {
            $project = Project::findOrFail($validated['project_id']);
            $project->partners()->attach($user->id, [
                'share_percentage' => $validated['share_percentage'],
                'management_fee_percentage' => $validated['management_fee_percentage'],
            ]);
        }

        return redirect()->back()->with('success', 'تم إنشاء الشريك بنجاح' . ($validated['project_id'] ? ' وإضافته للمشروع' : ''));
    }

    /**
     * Admin: Add Partner to Project
     */
    public function addPartner(Request $request, $projectId)
    {
        $this->authorize('accesspartners', ['create']);
        
        $validated = $request->validate([
            'partner_id' => 'required|exists:users,id',
            'share_percentage' => 'required|numeric|min:0|max:100',
            'management_fee_percentage' => 'required|numeric|min:0|max:100',
        ]);

        $project = Project::findOrFail($projectId);
        
        // Check if partner already exists
        if ($project->partners()->where('users.id', $validated['partner_id'])->exists()) {
            return redirect()->back()->with('error', 'هذا الشريك موجود بالفعل في المشروع');
        }

        $project->partners()->attach($validated['partner_id'], [
            'share_percentage' => $validated['share_percentage'],
            'management_fee_percentage' => $validated['management_fee_percentage'],
        ]);

        return redirect()->back()->with('success', 'تم إضافة الشريك بنجاح');
    }

    /**
     * Admin: Update Partner Share
     */
    public function updatePartner(Request $request, $projectId, $partnerId)
    {
        $this->authorize('accesspartners', ['modify']);
        
        $validated = $request->validate([
            'share_percentage' => 'required|numeric|min:0|max:100',
            'management_fee_percentage' => 'required|numeric|min:0|max:100',
        ]);

        $project = Project::findOrFail($projectId);
        $project->partners()->updateExistingPivot($partnerId, [
            'share_percentage' => $validated['share_percentage'],
            'management_fee_percentage' => $validated['management_fee_percentage'],
        ]);

        return redirect()->back()->with('success', 'تم تحديث بيانات الشريك بنجاح');
    }

    /**
     * Admin: Record Partner Withdrawal
     */
    public function storeWithdrawal(Request $request)
    {
        $this->authorize('accesspartners', ['create']);
        
        $validated = $request->validate([
            'partner_id' => 'required|exists:users,id',
            'project_id' => 'nullable|exists:projects,id',
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        PartnerWithdrawal::create($validated);

        return redirect()->back()->with('success', 'تم تسجيل المسحوبات بنجاح');
    }

    /**
     * Partner Dashboard - Portfolio View (For Partner himself)
     */
    public function dashboard($partnerId)
    {
        // Allow partners to view their own dashboard, or users with partners view access
        if (auth()->id() != $partnerId) {
            $this->authorize('accesspartners', ['view']);
        }
        
        $partner = User::findOrFail($partnerId);
        
        // Get partner's statement across all projects
        $statement = $this->revenueService->getPartnerStatement($partnerId);
        
        // Get all projects where this user is a partner
        $projects = Project::whereHas('partners', function($q) use ($partnerId) {
            $q->where('users.id', $partnerId);
        })->with('partners')->get();
        
        return view('partners.dashboard', compact('partner', 'statement', 'projects'));
    }

    /**
     * Partner Project Details
     */
    public function projectDetails($partnerId, $projectId)
    {
        // Allow partners to view their own details, or users with partners view access
        if (auth()->id() != $partnerId) {
            $this->authorize('accesspartners', ['view']);
        }
        
        $partner = User::findOrFail($partnerId);
        $project = Project::with('partners')->findOrFail($projectId);
        
        // Get statement for this specific project
        $statement = $this->revenueService->getPartnerStatement($partnerId, $projectId);
        
        // Get latest distribution calculation
        $distribution = $this->revenueService->calculateDistribution($projectId);
        
        return view('partners.project_details', compact('partner', 'project', 'statement', 'distribution'));
    }

    /**
     * Calculate Revenue Distribution for Project
     */
    public function calculateDistribution($projectId)
    {
        $this->authorize('accesspartners', ['view']);
        
        $project = Project::with('partners')->findOrFail($projectId);
        $distribution = $this->revenueService->calculateDistribution($projectId);
        
        return view('real_estate.project.revenue_distribution', compact('project', 'distribution'));
    }

    /**
     * Save Revenue Distribution
     */
    public function saveDistribution(Request $request, $projectId)
    {
        $this->authorize('accesspartners', ['create']);
        
        $distribution = $this->revenueService->saveDistribution($projectId, $request->as_of_date);
        
        return redirect()->back()->with('success', 'تم حفظ توزيع الإيرادات بنجاح');
    }

    /**
     * Management Fees Account
     */
    public function managementFeesAccount()
    {
        $this->authorize('accesspartners', ['view']);
        
        $account = $this->revenueService->getManagementFeesAccount();
        
        return view('finance.management_fees', compact('account'));
    }
}
