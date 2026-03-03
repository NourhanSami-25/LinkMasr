<?php
// App\Services\reminder\AutoReminderService.php

namespace App\Services\reminder;

use App\Models\reminder\Reminder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class AutoReminderService
{
    protected static $dateFields = [
        'contract' => 'due_date',
        'paymentRequest' => 'due_date',
        'project' => 'due_date',
        'task' => 'due_date',
        'client' => 'poa_expire_date'
    ];


    protected static $modelReminderStages = [
        'contract' => [43200, 10080, 4320, 2880, 1440], // month, week, 3d, 2d, 1d
        'paymentRequest' => [10080, 4320, 2880, 1440],
        'project' => [10080, 4320, 2880, 1440],
        'task' => [10080, 4320, 2880, 1440],
        'client' => [10080, 4320, 2880, 1440],
    ];

    public static function create(string $parentPath, string $modelType, $model)
    {
        $modelClass = self::getModelClass($parentPath, $modelType);
        $dateField = self::$dateFields[$modelType] ?? null;
        if (!$dateField) return;

        $reminderDate = $model->{$dateField};

        // Skip if target date is null or invalid
        if (!$reminderDate) {
            return;
        }

        $intervals = self::$modelReminderStages[$modelType] ?? [1440]; // default: 1 day before

        // Calculate duration logic to filter irrelevant reminders
        $startDate = $model->start_date ?? $model->created_at;
        $endDate = $reminderDate;
        
        $durationInMinutes = 0;
        if ($startDate && $endDate) {
            $start = Carbon::parse($startDate);
            $end = Carbon::parse($endDate);
            $durationInMinutes = $start->diffInMinutes($end, false);
        }

        foreach ($intervals as $minutes) {
            // Skip if reminder time is larger than the task duration itself
            if ($durationInMinutes > 0 && $minutes >= $durationInMinutes) {
                continue;
            }
            $readableTime = self::readableInterval($minutes);
            Reminder::create([
                'referable_type' => $modelClass,
                'referable_id' => $model->id,
                'user_id' => auth()->id(),
                'assigned_to' => auth()->id(),
                'date' => $reminderDate,
                'subject' => "{$modelType} auto reminder - {$readableTime}",
                'description' => '',
                'priority' => 'urgent',
                'remind_before' => $minutes,
                'status' => 'pending',
                'is_repeated' => 0,
                'repeat_every' => null,
                'repeat_every_type' => null,
                'created_by' => auth()->id(),
            ]);
        }
    }

    public static function update($model)
    {
        // Find model type from class name
        $className = get_class($model);
        $parts = explode('\\', $className);
        $modelType = lcfirst(end($parts));
        $parentPath = strtolower($parts[count($parts)-2]);

        // Delete existing auto-reminders for this model
        Reminder::where('referable_type', $className)
            ->where('referable_id', $model->id)
            ->where('subject', 'like', "{$modelType} auto reminder%")
            ->delete();

        // Re-create
        self::create($parentPath, $modelType, $model);
    }

    protected static function getModelClass(string $parentPath, string $modelType)
    {
        return "App\\Models\\{$parentPath}\\" . ucfirst($modelType);
    }

    protected static function readableInterval(int $minutes)
    {
        if ($minutes >= 43200) return intval($minutes / 43200) . " month(s)";
        if ($minutes >= 10080) return intval($minutes / 10080) . " week(s)";
        if ($minutes >= 1440) return intval($minutes / 1440) . " day(s)";
        return $minutes . " minute(s)";
    }
}
