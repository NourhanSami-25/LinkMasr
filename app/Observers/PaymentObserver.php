<?php

namespace App\Observers;

use App\Models\finance\Pyment;
use App\Models\RevenueDistribution;
use App\Models\RevenueDistributionItem;
use App\Models\real_estate\ProjectPartner;
use App\Services\utility\NotificationService;
use App\Models\user\User;

class PaymentObserver
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }
    /**
     * Handle the Pyment "created" event.
     * When a payment is received for a project, distribute to partners automatically.
     */
    public function created(Pyment $payment): void
    {
        $this->distributeToPartners($payment);
    }

    /**
     * Handle the Pyment "updated" event.
     */
    public function updated(Pyment $payment): void
    {
        // If payment amount changed, recalculate distribution
        if ($payment->isDirty('total')) {
            $this->distributeToPartners($payment);
        }
    }

    /**
     * Distribute payment to project partners
     */
    private function distributeToPartners(Pyment $payment): void
    {
        // Only process if payment is related to a project
        if (!$payment->project_id || $payment->related !== 'project') {
            return;
        }

        // Get project partners
        $partners = ProjectPartner::where('project_id', $payment->project_id)->get();
        
        if ($partners->isEmpty()) {
            return;
        }

        // Create or update distribution record for this date
        $distribution = RevenueDistribution::firstOrCreate([
            'project_id' => $payment->project_id,
            'distribution_date' => $payment->date ?? now()->format('Y-m-d'),
        ], [
            'total_revenue' => 0,
            'total_capital_expenses' => 0,
            'total_revenue_expenses' => 0,
            'total_management_fees' => 0,
            'distributable_amount' => 0,
            'breakeven_reached' => false,
            'notes' => 'Auto-generated from payment #' . $payment->number
        ]);

        // Add this payment to total revenue
        $distribution->total_revenue += $payment->total;
        $distribution->distributable_amount = $distribution->total_revenue - $distribution->total_capital_expenses - $distribution->total_revenue_expenses;
        $distribution->save();

        // Distribute to each partner
        foreach ($partners as $partner) {
            $shareAmount = ($payment->total * ($partner->share_percentage / 100));
            $managementFee = $shareAmount * ($partner->management_fee_percentage / 100);
            $netAmount = $shareAmount - $managementFee;

            // Create or update partner's distribution item
            $item = RevenueDistributionItem::firstOrNew([
                'distribution_id' => $distribution->id,
                'partner_id' => $partner->user_id,
            ]);

            $item->capital_share_percentage = $partner->share_percentage;
            $item->management_fee_percentage = $partner->management_fee_percentage;
            $item->share_amount = ($item->share_amount ?? 0) + $shareAmount;
            $item->management_fee_amount = ($item->management_fee_amount ?? 0) + $managementFee;
            $item->total_amount = ($item->total_amount ?? 0) + $netAmount;
            $item->save();
        }

        // Update total management fees in distribution
        $distribution->total_management_fees = $distribution->items()->sum('management_fee_amount');
        $distribution->save();

        // Notify partners about their share
        $this->notifyPartners($payment, $partners);
    }

    /**
     * Notify partners about revenue distribution
     */
    private function notifyPartners(Pyment $payment, $partners): void
    {
        try {
            $partnerUserIds = $partners->pluck('user_id')->toArray();
            $users = User::whereIn('id', $partnerUserIds)->get();
            
            if ($users->isNotEmpty()) {
                $subject = __('general.new_revenue_distribution') ?? 'New Revenue Distribution';
                $message = __('general.revenue_distributed_from_payment', [
                    'number' => $payment->number,
                    'amount' => number_format($payment->total, 2)
                ]) ?? "Revenue distributed from payment #{$payment->number} - Amount: " . number_format($payment->total, 2);
                
                $this->notificationService->notify($subject, $message, '/partners/dashboard', $users);
            }
        } catch (\Exception $e) {
            // Log error but don't break the payment flow
            \Log::error('Failed to notify partners: ' . $e->getMessage());
        }
    }
}
