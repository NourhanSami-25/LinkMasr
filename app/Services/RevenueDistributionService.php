<?php

namespace App\Services;

use App\Models\project\Project;
use App\Models\RevenueDistribution;
use App\Models\RevenueDistributionItem;
use App\Models\PartnerWithdrawal;
use App\Models\finance\Expense;
use App\Models\finance\Pyment;
use Carbon\Carbon;

class RevenueDistributionService
{
    /**
     * Calculate revenue distribution for a project
     * 
     * @param int $projectId
     * @param string|null $asOfDate
     * @return array
     */
    public function calculateDistribution($projectId, $asOfDate = null): array
    {
        $project = Project::with('partners')->findOrFail($projectId);
        $asOfDate = $asOfDate ? Carbon::parse($asOfDate) : Carbon::now();
        
        // 1. Calculate Total Revenue (from unit sales / payments)
        $totalRevenue = $this->getTotalRevenue($projectId, $asOfDate);
        
        // 2. Calculate Capital Expenses
        $capitalExpenses = Expense::where('project_id', $projectId)
            ->where('expense_type', 'capital')
            ->whereDate('date', '<=', $asOfDate)
            ->sum('total');
        
        // 3. Calculate Revenue Expenses
        $revenueExpenses = Expense::where('project_id', $projectId)
            ->where('expense_type', 'revenue')
            ->whereDate('date', '<=', $asOfDate)
            ->sum('total');
        
        // 4. Calculate Breakeven Point
        $breakevenPoint = $capitalExpenses;
        $breakevenReached = $totalRevenue >= $breakevenPoint;
        
        // 5. Calculate Management Fees (only if breakeven reached)
        $totalManagementFees = 0;
        $partnerDistributions = [];
        
        if ($breakevenReached) {
            $netRevenue = $totalRevenue - $capitalExpenses - $revenueExpenses;
            
            // Calculate management fees for each partner
            foreach ($project->partners as $partner) {
                $managementFeePercentage = $partner->pivot->management_fee ?? 0;
                $managementFeeAmount = ($netRevenue * $managementFeePercentage) / 100;
                $totalManagementFees += $managementFeeAmount;
                
                $partnerDistributions[$partner->id] = [
                    'partner' => $partner,
                    'management_fee_percentage' => $managementFeePercentage,
                    'management_fee_amount' => $managementFeeAmount,
                ];
            }
            
            // 6. Calculate distributable amount
            $distributableAmount = $netRevenue - $totalManagementFees;
            
            // 7. Distribute to partners by capital share
            foreach ($project->partners as $partner) {
                $capitalSharePercentage = $partner->pivot->capital_share ?? 0;
                $shareAmount = ($distributableAmount * $capitalSharePercentage) / 100;
                
                $partnerDistributions[$partner->id]['capital_share_percentage'] = $capitalSharePercentage;
                $partnerDistributions[$partner->id]['share_amount'] = $shareAmount;
                $partnerDistributions[$partner->id]['total_amount'] = 
                    $shareAmount + $partnerDistributions[$partner->id]['management_fee_amount'];
            }
        } else {
            $distributableAmount = 0;
        }
        
        return [
            'project_id' => $projectId,
            'as_of_date' => $asOfDate->format('Y-m-d'),
            'total_revenue' => round($totalRevenue, 2),
            'capital_expenses' => round($capitalExpenses, 2),
            'revenue_expenses' => round($revenueExpenses, 2),
            'breakeven_point' => round($breakevenPoint, 2),
            'breakeven_reached' => $breakevenReached,
            'total_management_fees' => round($totalManagementFees, 2),
            'distributable_amount' => round($distributableAmount, 2),
            'partner_distributions' => $partnerDistributions,
        ];
    }
    
    /**
     * Save distribution to database
     */
    public function saveDistribution($projectId, $asOfDate = null): RevenueDistribution
    {
        $calculation = $this->calculateDistribution($projectId, $asOfDate);
        
        $distribution = RevenueDistribution::create([
            'project_id' => $projectId,
            'distribution_date' => $calculation['as_of_date'],
            'total_revenue' => $calculation['total_revenue'],
            'total_capital_expenses' => $calculation['capital_expenses'],
            'total_revenue_expenses' => $calculation['revenue_expenses'],
            'total_management_fees' => $calculation['total_management_fees'],
            'distributable_amount' => $calculation['distributable_amount'],
            'breakeven_reached' => $calculation['breakeven_reached'],
        ]);
        
        // Save partner distribution items
        foreach ($calculation['partner_distributions'] as $partnerId => $data) {
            RevenueDistributionItem::create([
                'distribution_id' => $distribution->id,
                'partner_id' => $partnerId,
                'capital_share_percentage' => $data['capital_share_percentage'] ?? 0,
                'management_fee_percentage' => $data['management_fee_percentage'] ?? 0,
                'share_amount' => $data['share_amount'] ?? 0,
                'management_fee_amount' => $data['management_fee_amount'] ?? 0,
                'total_amount' => $data['total_amount'] ?? 0,
            ]);
        }
        
        return $distribution->load('items.partner');
    }
    
    /**
     * Get partner statement across all projects
     */
    public function getPartnerStatement($partnerId, $projectId = null): array
    {
        $query = RevenueDistributionItem::with(['distribution.project', 'partner'])
            ->where('partner_id', $partnerId);
        
        if ($projectId) {
            $query->whereHas('distribution', function($q) use ($projectId) {
                $q->where('project_id', $projectId);
            });
        }
        
        $distributions = $query->orderBy('created_at', 'desc')->get();
        
        // Calculate totals
        $totalShareAmount = $distributions->sum('share_amount');
        $totalManagementFees = $distributions->sum('management_fee_amount');
        $totalEarnings = $distributions->sum('total_amount');
        
        // Get withdrawals
        $withdrawalsQuery = PartnerWithdrawal::where('partner_id', $partnerId);
        if ($projectId) {
            $withdrawalsQuery->where('project_id', $projectId);
        }
        $withdrawals = $withdrawalsQuery->orderBy('date', 'desc')->get();
        $totalWithdrawals = $withdrawals->sum('amount');
        
        // Calculate balance
        $balance = $totalEarnings - $totalWithdrawals;
        
        return [
            'partner_id' => $partnerId,
            'total_share_amount' => round($totalShareAmount, 2),
            'total_management_fees' => round($totalManagementFees, 2),
            'total_earnings' => round($totalEarnings, 2),
            'total_withdrawals' => round($totalWithdrawals, 2),
            'balance' => round($balance, 2),
            'distributions' => $distributions,
            'withdrawals' => $withdrawals,
        ];
    }
    
    /**
     * Get total revenue for a project
     * (from payments/unit sales)
     */
    private function getTotalRevenue($projectId, $asOfDate): float
    {
        // Get all payments for this project
        $totalRevenue = Pyment::where('project_id', $projectId)
            ->whereDate('date', '<=', $asOfDate)
            ->sum('total');
        
        return $totalRevenue;
    }
    
    /**
     * Get management fees account summary
     */
    public function getManagementFeesAccount(): array
    {
        $allDistributions = RevenueDistributionItem::with(['distribution.project', 'partner'])
            ->where('management_fee_amount', '>', 0)
            ->orderBy('created_at', 'desc')
            ->get();
        
        $totalFees = $allDistributions->sum('management_fee_amount');
        
        // Group by project
        $byProject = $allDistributions->groupBy('distribution.project_id')->map(function($items) {
            return [
                'project' => $items->first()->distribution->project,
                'total_fees' => $items->sum('management_fee_amount'),
                'items' => $items
            ];
        });
        
        // Group by partner
        $byPartner = $allDistributions->groupBy('partner_id')->map(function($items) {
            return [
                'partner' => $items->first()->partner,
                'total_fees' => $items->sum('management_fee_amount'),
                'items' => $items
            ];
        });
        
        return [
            'total_fees' => round($totalFees, 2),
            'by_project' => $byProject,
            'by_partner' => $byPartner,
            'all_distributions' => $allDistributions,
        ];
    }
}
