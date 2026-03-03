<?php

namespace App\Observers;

use App\Models\project\Project;
use App\Models\common\Note;
use App\Models\common\File;
use App\Models\common\Discussion;
use App\Models\reminder\Reminder;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Services\common\FileService;

class ProjectObserver
{
    protected $fileService;
    public function __construct(FileService $fileService)
    {
        $this->fileService = $fileService;
    }
    public function deleting(Project $project)
    {
        try {
            Note::where('referable_type', Project::class)
                ->where('referable_id', $project->id)
                ->delete();

            Discussion::where('discussionable_type', Project::class)
                ->where('discussionable_id', $project->id)
                ->delete();

            Reminder::where('referable_type', Project::class)
                ->where('referable_id', $project->id)
                ->delete();

            $files = File::where('referable_type', Project::class)
                ->where('referable_id', $project->id)
                ->get();

            foreach ($files as $file) {
                if ($file->path) {
                    Storage::disk('public')->delete($file->path);
                }
                $file->delete();
            }

            // Delete the model's directory after all files are deleted
            $folderName = $this->fileService->getModelFolder($project->id, $project->created_at);
            $directoryPath = "lexpro/project/{$folderName}";
            if (Storage::disk('public')->exists($directoryPath)) {
                Storage::disk('public')->deleteDirectory($directoryPath);
            }
        } catch (\Exception $e) {
            Log::error('Error cleaning up related records for deleted project: ' . $e->getMessage());
        }
    }
    public function created(Project $project): void
    {
        //
    }

    /**
     * Handle the Project "updated" event.
     */
    public function updated(Project $project): void
    {
        //
    }

    /**
     * Handle the Project "deleted" event.
     */
    public function deleted(Project $project): void
    {
        //
    }

    /**
     * Handle the Project "restored" event.
     */
    public function restored(Project $project): void
    {
        //
    }

    /**
     * Handle the Project "force deleted" event.
     */
    public function forceDeleted(Project $project): void
    {
        //
    }
}
