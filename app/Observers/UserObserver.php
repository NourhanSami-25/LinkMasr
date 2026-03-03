<?php

namespace App\Observers;

use App\Models\user\User;
use App\Models\common\Note;
use App\Models\common\File;
use App\Models\reminder\Reminder;
use App\Models\hr\Balance;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Services\common\FileService;


class UserObserver
{
    protected $fileService;
    public function __construct(FileService $fileService)
    {
        $this->fileService = $fileService;
    }

    public function deleting(User $user)
    {
        try {
            Balance::where('user_id', $user->id )->delete();
            
            Reminder::where('referable_type', User::class)
                ->where('referable_id', $user->id)
                ->delete();

            $files = File::where('referable_type', User::class)
                ->where('referable_id', $user->id)
                ->get();

            foreach ($files as $file) {
                if ($file->path) {
                    Storage::disk('public')->delete($file->path);
                }
                $file->delete();
            }

            // Delete the model's directory after all files are deleted
            $folderName = $this->fileService->getModelFolder($user->id, $user->created_at);
            $directoryPath = "lexpro/user/{$folderName}";
            if (Storage::disk('public')->exists($directoryPath)) {
                Storage::disk('public')->deleteDirectory($directoryPath);
            }
        } catch (\Exception $e) {
            Log::error('Error cleaning up related records for deleted user: ' . $e->getMessage());
        }
    }

    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        //
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        //
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        //
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        //
    }
}
