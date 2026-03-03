<?php

namespace App\Http\Controllers\reminder;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reminder\Reminder;
use App\Services\utility\NotificationService;
use Carbon\Carbon;
use App\Models\user\User;


class ReminderFunctionController extends Controller
{
    public $threshold;
    protected $notificationService;


    public function __construct(NotificationService $notificationService)
    {
        $this->threshold = 10;
        $this->notificationService = $notificationService;
    }

    public function markAsCompleted($id)
    {
        $reminder = Reminder::findOrFail($id);
        $reminder->status = 'completed';
        $reminder->save();
        return redirect()->back()->with('success', 'Reminder is marked as completed successfully');
    }

    public function markAsPending($id)
    {
        $reminder = Reminder::findOrFail($id);
        $reminder->status = 'pending';
        $reminder->save();
        return redirect()->back()->with('success', 'Reminder is marked as pending successfully');
    }


    public function handleRemindPopup($reminderIds)
    {
        $reminders = Reminder::whereIn('id', $reminderIds)->get();
    }


    public function getPendingReminders()
    {
        $pendingReminders = Reminder::where('status', 'pending')
            ->get(['id', 'date', 'notify_before', 'notify_before_type']);

        $currentReminders = [];
        $now = Carbon::now()->subMinutes(1); // 🔹 Shift `now` back by 1 minutes to avoid >= and <= and use the built-in methods
        $thresholdEnd = $now->copy()->addMinutes($this->threshold); // Now + Threshold

        foreach ($pendingReminders as $reminder) {
            $actualReminderTime = Carbon::parse($reminder->date);
            $remindTime = $this->calculateRemindTime(
                $reminder->date,
                $reminder->notify_before,
                $reminder->notify_before_type
            );

            // Check if `remindTime` is within [now → now + threshold] OR exactly equal to `now`
            if ($remindTime->between($now, $thresholdEnd) || $remindTime->equalTo($now)) {
                $currentReminders[] = $reminder->id;
            }

            // Check if `actualReminderTime` is within [now → now + threshold] OR exactly equal to `now`
            if ($actualReminderTime->between($now, $thresholdEnd) || $actualReminderTime->equalTo($now)) {
                $currentReminders[] = $reminder->id;
            }
        }

        return $currentReminders;
    }



    public function sendReminderNotifications()
    {
        // Get pending reminder IDs
        $reminderIds = $this->getPendingReminders();

        // Fetch the reminders based on IDs
        $reminders = Reminder::whereIn('id', $reminderIds)->get();

        foreach ($reminders as $reminder) {
            $notifiedUsers = $this->notificationService->getNotifiedUsers($reminder->members, $reminder->created_by);
            $this->notificationService->notify($reminder->subject, '', 'none', $notifiedUsers);
        }
    }



    /**
     * Calculate the remind time based on date, notify_before, and notify_before_type.
     */
    public function calculateRemindTime(string $date, int $notifyBefore, string $notifyBeforeType): Carbon
    {
        $date = Carbon::parse($date);
        switch ($notifyBeforeType) {
            case 'days':
                return $date->subDays($notifyBefore);
            case 'hours':
                return $date->subHours($notifyBefore);
            case 'minutes':
                return $date->subMinutes($notifyBefore);
            default:
                throw new \InvalidArgumentException("Invalid notify_before_type: $notifyBeforeType");
        }
    }



    /**
     * Update reminders with status "missing" and mark them as "expire" if they exceed the threshold.
     */
    public function updateMissingReminders(): void
    {
        $missingReminders = Reminder::where('status', 'missing')->get();

        $now = Carbon::now();

        foreach ($missingReminders as $reminder) {
            $remindTime = $this->calculateRemindTime(
                $reminder->date,
                $reminder->notify_before,
                $reminder->notify_before_type
            );

            $isExpired = false;

            switch ($reminder->notify_before_type) {
                case 'day':
                    $isExpired = $remindTime->diffInDays($now) > 30;
                    break;
                case 'hour':
                    $isExpired = $remindTime->diffInHours($now) > 24;
                    break;
                case 'minute':
                    $isExpired = $remindTime->diffInMinutes($now) > 60;
                    break;
            }

            if ($isExpired) {
                $reminder->update(['status' => 'expired']);
            }
        }
    }

    public function deleteExpiredReminders()
    {
        // Select and delete all expired reminders
        $deletedRows = Reminder::where('status', 'expired')->delete();

        return response()->json([
            'message' => 'Expired reminders deleted successfully.',
            'deleted_count' => $deletedRows
        ]);
    }
}
