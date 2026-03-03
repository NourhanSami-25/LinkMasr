<?php

namespace App\Observers;

use App\Models\client\Client;
use App\Models\common\Note;
use App\Models\common\File;
use App\Models\reminder\Reminder;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Services\common\FileService;


class ClientObserver
{
    protected $fileService;
    public function __construct(FileService $fileService)
    {
        $this->fileService = $fileService;
    }

    public function deleting(Client $client)
    {
        try {
            Note::where('referable_type', Client::class)
                ->where('referable_id', $client->id)
                ->delete();

            Reminder::where('referable_type', Client::class)
                ->where('referable_id', $client->id)
                ->delete();

            $files = File::where('referable_type', Client::class)
                ->where('referable_id', $client->id)
                ->get();

            foreach ($files as $file) {
                if ($file->path) {
                    Storage::disk('public')->delete($file->path);
                }
                $file->delete();
            }

            // Delete the model's directory after all files are deleted
            $folderName = $this->fileService->getModelFolder($client->id, $client->created_at);
            $directoryPath = "lexpro/client/{$folderName}";
            if (Storage::disk('public')->exists($directoryPath)) {
                Storage::disk('public')->deleteDirectory($directoryPath);
            }
        } catch (\Exception $e) {
            Log::error('Error cleaning up related records for deleted client: ' . $e->getMessage());
        }
    }

    /**
     * Handle the Client "created" event.
     */
    public function created(Client $client): void
    {
        //
    }

    /**
     * Handle the Client "updated" event.
     */
    public function updated(Client $client): void
    {
        //
    }

    /**
     * Handle the Client "deleted" event.
     */
    public function deleted(Client $client): void
    {
        //
    }

    /**
     * Handle the Client "restored" event.
     */
    public function restored(Client $client): void
    {
        //
    }

    /**
     * Handle the Client "force deleted" event.
     */
    public function forceDeleted(Client $client): void
    {
        //
    }
}
