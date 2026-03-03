<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Notifications\DatabaseNotification;

class DeleteOldReadNotifications extends Command
{
    protected $signature = 'notifications:cleanup';
    protected $description = 'Delete read notifications older than 1 month';

    public function handle()
    {
        $cutoff = Carbon::now()->subMonth();
        $cutoff2Months = Carbon::now()->subMonths(2);


        $deletedCount = DatabaseNotification::whereNotNull('read_at')
            ->where('created_at', '<', $cutoff)
            ->delete();

        $deletedCount2Months = DatabaseNotification::where('created_at', '<', $cutoff2Months)
        ->delete();

        $this->info("Deleted $deletedCount read notifications older than 1 month , Deleted $deletedCount2Months read/unreaded notifications older than 2 month");
    }
}
