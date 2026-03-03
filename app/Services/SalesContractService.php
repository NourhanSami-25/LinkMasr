<?php

namespace App\Services;

use App\Models\SalesContract;
use App\Models\PaymentSchedule;
use Carbon\Carbon;

class SalesContractService
{
    /**
     * Create sales contract with payment schedule
     */
    public function createContract(array $data): SalesContract
    {
        // Generate contract number
        $contractNumber = $this->generateContractNumber($data['project_id']);
        
        // Calculate remaining amount
        $remainingAmount = $data['total_price'] - $data['down_payment'];
        
        // Create contract
        $contract = SalesContract::create([
            'contract_number' => $contractNumber,
            'project_id' => $data['project_id'],
            'unit_id' => $data['unit_id'],
            'client_id' => $data['client_id'],
            'total_price' => $data['total_price'],
            'down_payment' => $data['down_payment'],
            'remaining_amount' => $remainingAmount,
            'installment_months' => $data['installment_months'] ?? 0,
            'contract_date' => $data['contract_date'] ?? now(),
            'delivery_date' => $data['delivery_date'] ?? null,
            'status' => 'active',
            'notes' => $data['notes'] ?? null
        ]);
        
        // Generate payment schedule
        if ($data['installment_months'] > 0 && $remainingAmount > 0) {
            $this->generatePaymentSchedule($contract);
        }
        
        // Update unit status to sold
        $contract->unit()->update(['status' => 'sold']);
        
        return $contract->load('schedules');
    }
    
    /**
     * Generate payment schedule for contract
     */
    public function generatePaymentSchedule(SalesContract $contract): void
    {
        $installmentAmount = $contract->remaining_amount / $contract->installment_months;
        $startDate = Carbon::parse($contract->contract_date);
        
        for ($i = 1; $i <= $contract->installment_months; $i++) {
            PaymentSchedule::create([
                'contract_id' => $contract->id,
                'installment_number' => $i,
                'amount' => $installmentAmount,
                'due_date' => $startDate->copy()->addMonths($i),
                'status' => 'pending'
            ]);
        }
    }
    
    /**
     * Record payment against schedule
     */
    public function recordPayment(int $scheduleId, float $amount, string $date, array $paymentData = []): void
    {
        $schedule = PaymentSchedule::findOrFail($scheduleId);
        $contract = $schedule->contract;
        
        // Create payment record
        $payment = \App\Models\finance\Pyment::create([
            'project_id' => $contract->project_id,
            'contract_id' => $contract->id,
            'schedule_id' => $schedule->id,
            'client_id' => $contract->client_id,
            'total' => $amount,
            'date' => $date,
            'category' => 'unit_sale',
            'notes' => $paymentData['notes'] ?? "Payment for {$contract->contract_number} - Installment #{$schedule->installment_number}"
        ]);
        
        // Update schedule
        $schedule->paid_amount += $amount;
        $schedule->paid_date = $date;
        
        if ($schedule->paid_amount >= $schedule->amount) {
            $schedule->status = 'paid';
        } elseif ($schedule->paid_amount > 0) {
            $schedule->status = 'partial';
        }
        
        $schedule->save();
        
        // Check if contract is fully paid
        if ($contract->remaining_balance <= 0) {
            $contract->update(['status' => 'completed']);
        }
    }
    
    /**
     * Get contract summary
     */
    public function getContractSummary(int $contractId): array
    {
        $contract = SalesContract::with(['unit', 'client', 'schedules', 'payments'])->findOrFail($contractId);
        
        $totalScheduled = $contract->schedules->sum('amount');
        $totalPaid = $contract->total_paid;
        $remainingBalance = $contract->remaining_balance;
        
        $paidSchedules = $contract->schedules->where('status', 'paid')->count();
        $pendingSchedules = $contract->schedules->where('status', 'pending')->count();
        $overdueSchedules = $contract->schedules->filter(fn($s) => $s->is_overdue)->count();
        
        return [
            'contract' => $contract,
            'total_price' => $contract->total_price,
            'down_payment' => $contract->down_payment,
            'total_scheduled' => $totalScheduled,
            'total_paid' => $totalPaid,
            'remaining_balance' => $remainingBalance,
            'payment_progress' => $contract->payment_progress,
            'paid_schedules' => $paidSchedules,
            'pending_schedules' => $pendingSchedules,
            'overdue_schedules' => $overdueSchedules,
        ];
    }
    
    /**
     * Generate unique contract number
     */
    private function generateContractNumber(int $projectId): string
    {
        $project = \App\Models\project\Project::findOrFail($projectId);
        $count = SalesContract::where('project_id', $projectId)->count() + 1;
        
        return sprintf('SC-%s-%04d', date('Y'), $count);
    }
}
