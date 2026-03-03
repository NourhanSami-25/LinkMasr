<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\business\Contract;
use Illuminate\Support\Carbon;
use App\Services\utility\NotificationService;

class CheckContractExpirations extends Command
{
    protected $signature = 'contracts:check-expiration';
    protected $description = 'Check contracts that are due and mark them as expired, notify the user, and disable the client';

    public function handle()
    {
        $today = Carbon::today();
        $notificationService = new NotificationService();
        $processedExpired = [];
        $processedAboutToExpire = [];

        $contracts = Contract::whereIn('status', ['active', 'about_to_expire'])
            ->where('due_date', '<=', $today->copy()->addDays(60))
            ->with(['client'])
            ->get();

        foreach ($contracts as $contract) {
            $dueDate = Carbon::parse($contract->due_date);

            // Mark as about to expire if due in 60 days or less and still active
            if ($contract->status === 'active' && $dueDate->diffInDays($today) <= 60 && $dueDate->isAfter($today)) {
                $contract->update(['status' => 'about_to_expire']);
                $message = "📄 Contract \"{$contract->subject}\" is about to expire.";
                $route = route('contracts.index');
                $notifiedUsers = $notificationService->getNotifiedUsers([], $contract->created_by);
                $notificationService->notify($message, $message, $route, $notifiedUsers);

                $processedAboutToExpire[] = [
                    'contract' => $contract->subject,
                    'client' => $contract->client->name ?? 'Unknown',
                ];
            }

            // If already past due date, expire it
            if ($dueDate->lessThan($today)) {
                $contract->update(['status' => 'expired']);

                $notifiedUsers = $notificationService->getNotifiedUsers([], $contract->created_by);

                $message = "📄 Contract \"{$contract->subject}\" has expired.";
                $route = route('contracts.index');
                $notificationService->notify($message, $message, $route, $notifiedUsers);

                if ($contract->client) {
                    $contract->client->update(['status' => 'disabled']);
                }

                $processedExpired[] = [
                    'contract' => $contract->subject,
                    'client' => $contract->client->name ?? 'Unknown',
                ];
            }
        }


        // Output info summary
        if (count($processedExpired)) {
            $this->info("✅ Expired Contracts:");
            foreach ($processedExpired as $item) {
                $this->line("- Contract: {$item['contract']}, Client: {$item['client']}");
            }
        }

        if (count($processedAboutToExpire)) {
            $this->info("⏳ Contracts Marked About to Expire:");
            foreach ($processedAboutToExpire as $item) {
                $this->line("- Contract: {$item['contract']}, Client: {$item['client']}");
            }
        }

        if (!count($processedExpired) && !count($processedAboutToExpire)) {
            $this->info("No contracts processed today.");
        }
    }
}
