<?php

namespace App\Services\common;

use Illuminate\Support\Facades\Storage;
use App\Models\common\File;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class FileService
{
    public function uploadFile(array $data)
    {
        $fileData = $this->prepareFileData($data);
        $path = $this->generateFilePath($fileData);
        $fileData['model']->files()->create([
            'name' => $fileData['file_name'],
            'type' => $fileData['mime_type'],
            'description' => $fileData['description'],
            'path' => $path,
            'category' => $fileData['category'],
            'created_by' => auth()->id(),
        ]);
    }

    public function updateFile($id, array $data)
    {
        $file = File::findOrFail($id);

        // Always update name/description
        $updateData = [
            'name' => $data['name'] ?? $file->name,
            'description' => $data['description'] ?? ($file->description ?? ''),
        ];

        // Check if a new file is being uploaded
        if (isset($data['file']) && $data['file']->isValid()) {
            // Delete old file from disk if it exists
            if ($file->path && Storage::disk('public')->exists($file->path)) {
                Storage::disk('public')->delete($file->path);
            }

            // Add model info to request data for reuse
            $data['model_type'] = get_class($file->referable); // assuming polymorphic
            $data['model_id'] = $file->referable_id;

            // Reuse your logic to prepare and store file
            $fileData = $this->prepareFileData($data);
            $path = $this->generateFilePath($fileData);

            // Update file path and type info
            $updateData['name'] = $fileData['file_name'];
            $updateData['type'] = $fileData['mime_type'];
            $updateData['path'] = $path;
        }

        // Save updates
        $file->update($updateData);
    }


    public function previewFile(File $file)
    {
        if (Storage::disk('public')->exists($file->path)) {
            return response()->file(storage_path('app/public/' . $file->path));
        }

        abort(404, 'File not found.');
    }

    public function downloadFile(File $file)
    {
        if (Storage::disk('public')->exists($file->path)) {
            return response()->download(storage_path('app/public/' . $file->path));
        }
        abort(404, 'File not found.');
    }

    public function deleteFile($id)
    {
        $file = File::find($id);

        // If file not found in DB
        if (!$file) {
            return response()->json([
                'status' => 'error',
                'message' => 'File not found.'
            ], 404);
        }

        // Delete the actual file from storage
        $this->deleteFileFromStorage($file->path);

        // Delete the DB record
        $file->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'File deleted successfully.'
        ]);
    }



    // Helper Methods

    private function prepareFileData(array $data): array
    {
        $file = $data['file'];
        // $fileName = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();
        $timestamp = now()->format('Ymd_His');
        $fileName = $data['name'] . '_' . $timestamp . '.' . $extension;
        $modelType = $data['model_type'];
        $modelId = $data['model_id'];
        $model = $modelType::findOrFail($modelId);
        $modelName = strtolower(class_basename($modelType));
        $model_folder = $this->getModelFolder($modelId, $model->created_at);

        return [
            'file' => $file,
            'file_name' => $fileName,
            'model' => $model,
            'model_id' => $modelId,
            'model_name' => $modelName,
            'mime_type' => $file->getClientMimeType(),
            'model_folder' => $model_folder,
            'description' => $data['description'] ?? null,
            'category' => $data['category'] ?? null,
        ];
    }

    public function generateFilePath($fileData)
    {
        return $fileData['file']->storeAs('lexpro/' . $fileData['model_name'] . '/' . $fileData['model_folder'], $fileData['file_name'], 'public');
    }

    public function getModelFolder($modelId, $createdAt)
    {
        $formattedDate = Carbon::parse($createdAt)->format('Ymd_His');
        return "{$modelId}-{$formattedDate}";
    }


    public function deleteFileFromStorage($path)
    {
        Storage::disk('public')->delete($path);
    }


    public function deleteFileRecord($file)
    {
        if (!$file) {
            return response()->json([
                'status' => 'error',
                'message' => 'File not found.'
            ], 404);
        }
        // Delete the DB record
        $file->delete();
    }

    public function deleteModelFolder($data)
    {
    }
}
