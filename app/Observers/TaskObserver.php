<?php

namespace App\Observers;

use App\Models\task\Task;
use App\Models\common\Note;
use App\Models\common\File;
use App\Models\common\Discussion;
use App\Models\reminder\Reminder;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Services\common\FileService;
use App\Services\utility\NotificationService;
use App\Models\user\User;


class TaskObserver
{
    protected $fileService;
    protected $notificationService;
    
    public function __construct(FileService $fileService, NotificationService $notificationService)
    {
        $this->fileService = $fileService;
        $this->notificationService = $notificationService;
    }

    public function deleting(Task $task)
    {
        try {
            Note::where('referable_type', Task::class)
                ->where('referable_id', $task->id)
                ->delete();

            Discussion::where('discussionable_type', Task::class)
                ->where('discussionable_id', $task->id)
                ->delete();

            Reminder::where('referable_type', Task::class)
                ->where('referable_id', $task->id)
                ->delete();

            $files = File::where('referable_type', Task::class)
                ->where('referable_id', $task->id)
                ->get();

            foreach ($files as $file) {
                if ($file->path) {
                    Storage::disk('public')->delete($file->path);
                }
                $file->delete();
            }

            // Delete the model's directory after all files are deleted
            $folderName = $this->fileService->getModelFolder($task->id, $task->created_at);
            $directoryPath = "lexpro/task/{$folderName}";
            if (Storage::disk('public')->exists($directoryPath)) {
                Storage::disk('public')->deleteDirectory($directoryPath);
            }
        } catch (\Exception $e) {
            Log::error('Error cleaning up related records for deleted task: ' . $e->getMessage());
        }
    }

    /**
     * Handle the Task "created" event.
     */
    public function created(Task $task): void
    {
        //
    }

    /**
     * Handle the Task "updated" event.
     * When task linked to BOQ is completed, update EVM progress.
     */
    public function updated(Task $task): void
    {
        // If task is linked to BOQ and status changed to completed
        if ($task->boq_id && $task->isDirty('status') && $task->status === 'completed') {
            $this->updateBoqProgress($task);
        }
    }

    /**
     * Update BOQ progress when linked task is completed
     */
    private function updateBoqProgress(Task $task): void
    {
        try {
            $boqItem = \App\Models\ConstructionBoq::find($task->boq_id);
            if (!$boqItem) return;

            // Create progress entry - assume task completion = 1 unit of work
            // You can customize this based on your business logic
            \App\Models\ConstructionProgress::create([
                'boq_id' => $task->boq_id,
                'date' => now()->format('Y-m-d'),
                'actual_quantity' => 1, // Default 1 unit, can be customized
                'notes' => 'Auto-logged from completed task: ' . $task->subject,
                'status' => 'approved',
            ]);

            // Notify project managers about EVM progress update
            $this->notifyBoqProgressUpdate($task, $boqItem);
        } catch (\Exception $e) {
            Log::error('Error updating BOQ progress from task: ' . $e->getMessage());
        }
    }

    /**
     * Notify about BOQ progress update from task completion
     */
    private function notifyBoqProgressUpdate(Task $task, $boqItem): void
    {
        try {
            // Notify task creator and project managers
            $userIds = [];
            if ($task->created_by) $userIds[] = $task->created_by;
            
            // Get project managers if project exists
            if ($boqItem->project_id) {
                $project = \App\Models\project\Project::find($boqItem->project_id);
                if ($project && $project->manager_id) {
                    $userIds[] = $project->manager_id;
                }
            }
            
            if (!empty($userIds)) {
                $users = User::whereIn('id', array_unique($userIds))->get();
                if ($users->isNotEmpty()) {
                    $subject = __('general.boq_progress_updated') ?? 'BOQ Progress Updated';
                    $message = __('general.task_completed_boq_updated', [
                        'task' => $task->subject,
                        'boq' => $boqItem->code ?? $boqItem->item_description
                    ]) ?? "Task '{$task->subject}' completed - BOQ progress updated";
                    
                    $this->notificationService->notify($subject, $message, '/construction/projects/' . $boqItem->project_id . '/evm', $users);
                }
            }
        } catch (\Exception $e) {
            Log::error('Failed to notify BOQ progress update: ' . $e->getMessage());
        }
    }

    /**
     * Handle the Task "deleted" event.
     */
    public function deleted(Task $task): void
    {
        //
    }

    /**
     * Handle the Task "restored" event.
     */
    public function restored(Task $task): void
    {
        //
    }

    /**
     * Handle the Task "force deleted" event.
     */
    public function forceDeleted(Task $task): void
    {
        //
    }
}
