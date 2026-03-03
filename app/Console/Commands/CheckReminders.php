<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\reminder\Reminder;
use Illuminate\Support\Carbon;
use App\Jobs\SendReminderJob;

class CheckReminders extends Command
{
    protected $signature = 'reminders:check';
    protected $description = 'Check and process all pending reminders';

    public function handle()
    {
        $now = Carbon::now();

        // Optional: only look at reminders within 60 days for performance
        Reminder::where('date', '<=', $now->copy()->addDays(60))
            ->where(function ($query) {
                $query->where('before_reminded', false)
                    ->orWhere('event_reminded', false);
            })
            ->chunk(100, function ($reminders) use ($now) {
                foreach ($reminders as $reminder) {

                    // Handle 'before' reminder
                    if (
                        $reminder->remind_before &&
                        !$reminder->before_reminded &&
                        $now->greaterThanOrEqualTo(
                            Carbon::parse($reminder->date)->subMinutes($reminder->remind_before)
                        )
                    ) {
                        SendReminderJob::dispatch($reminder, 'before');
                        $reminder->update(['before_reminded' => true]);
                    }

                    // Handle 'at event time' reminder
                    if (
                        $reminder->remind_at_event &&
                        !$reminder->event_reminded &&
                        $now->greaterThanOrEqualTo(Carbon::parse($reminder->date))
                    ) {
                        SendReminderJob::dispatch($reminder, 'at_event');
                        $reminder->update(['event_reminded' => true, 'status' => 'completed']);
                    }
                }
            });

        $this->info('Reminder check completed.');
    }
}
