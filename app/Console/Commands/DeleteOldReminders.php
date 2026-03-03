<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\reminder\Reminder;
use Illuminate\Support\Carbon;

class DeleteOldReminders extends Command
{
    protected $signature = 'reminders:cleanup';
    protected $description = 'Delete reminders that are older than one month past their event date, excluding contracts reminders, Runs once every week: at weekend (friday at 10 AM)';

    public function handle()
    {
        $cutoff = Carbon::now()->subMonth();

        $count = Reminder::where('date', '<', $cutoff)
            ->where('referable_type', '!=', 'App\Models\business\Contract')
            ->delete();

        $this->info("Deleted $count old reminders (excluding Contracts).");
    }
}
