<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\reminder\Reminder;
use App\Services\utility\NotificationService;

class SendReminderJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected Reminder $reminder;
    protected string $type; // 'before' or 'at_event'

    public function __construct(Reminder $reminder, string $type)
    {
        $this->reminder = $reminder;
        $this->type = $type;
    }

    public function handle()
    {
        // inject the NotificationService 
        $notificationService = new NotificationService();

        // Step 1: Get target users (created_by + members[])        
        $notifiedUsers = $notificationService->getNotifiedUsers(
            $this->reminder->members,
            $this->reminder->created_by
        );

        // Step 2: Create a message for the notification
        $message = $this->type === 'before'
            ? "⏰ Reminder: The \"{$this->reminder->subject}\" is coming up after " . $this->calculateRemindBeforeTime($this->reminder->remind_before)
            : "📅 It's time! The \"{$this->reminder->subject}\" is happening now";

        $route = route('tasks.index');
        // Step 3: Send the notification
        $notificationService->notify($this->reminder->subject, $message, $route, $notifiedUsers);
    }

    public function calculateRemindBeforeTime($value)
    {
        if ($value >= 1440) {
            $remind_before_value = floor($value / 1440) . ' ' . __('general.days');
        } elseif ($value >= 60) {
            $remind_before_value = floor($value / 60) . ' ' . __('general.hours');
        } else {
            $remind_before_value = $value . ' ' . __('general.minutes');
        }
        return $remind_before_value;
    }
}
