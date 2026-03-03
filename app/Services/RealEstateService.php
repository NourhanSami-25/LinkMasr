<?php

namespace App\Services;

use App\Models\project\Project;
use App\Models\finance\Invoice;
use App\Models\finance\Expense;
use App\Models\real_estate\ProjectPartner;

class RealEstateService
{
    /**
     * Calculate Net Income for a Project
     * Revenue (Invoices Paid) - Operational Expenses
     */
    public function calculateProjectNetIncome($projectId)
    {
        // 1. Total Revenue: Sum of paid invoices or payments
        // Assuming 'status' = 'paid' for invoices, or summing payments table.
        // Let's use Invoice payments relation if available, or just Invoices for simplicity for now.
        // Better: Use Invoice `total` where status is paid.
        $revenue = Invoice::where('project_id', $projectId)
            ->where('status', 'paid') // Adjust status based on actual enum
            ->sum('total');

        // 2. Operational Expenses
        $opex = Expense::where('project_id', $projectId)
            ->where('category', 'operational')
            ->sum('total');

        return $revenue - $opex;
    }

    /**
     * Calculate Partner's Share
     * (Net Income - Mgmt Fee) * Partner Share %
     */
    public function calculatePartnerShare($projectId, $partnerId)
    {
        $projectPartner = ProjectPartner::where('project_id', $projectId)
            ->where('partner_id', $partnerId)
            ->first();

        if (!$projectPartner) {
            return 0;
        }

        $netIncome = $this->calculateProjectNetIncome($projectId);

        // Management Fee
        $mgmtFeePercent = $projectPartner->management_fee_percentage;
        $mgmtFee = $netIncome * ($mgmtFeePercent / 100);

        // Net Distributable
        $distributable = $netIncome - $mgmtFee;

        // Partner Share
        $sharePercent = $projectPartner->share_percentage;
        $shareAmount = $distributable * ($sharePercent / 100);

        return [
            'net_income' => $netIncome,
            'management_fee' => $mgmtFee,
            'distributable' => $distributable,
            'share_percentage' => $sharePercent,
            'share_amount' => $shareAmount
        ];
    }
}
