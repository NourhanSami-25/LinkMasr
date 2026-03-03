<?php

namespace App\Http\Controllers\common;

use App\Models\common\File;
use App\Http\Controllers\Controller;
use App\Http\Requests\common\FileRequest;
use App\Services\common\FileService;
use Illuminate\Http\Request;

class FileController extends Controller
{
    protected $fileService;

    public function __construct(FileService $fileService)
    {
        $this->fileService = $fileService;
    }

    public function upload(FileRequest $request)
    {
        $this->fileService->uploadFile($request->validated());
        return redirect()->back()->with('success', 'File uploaded successfully');
    }


    public function update(Request $request, $id)
    {
        $this->fileService->updateFile($id, $request->only(['name', 'description', 'file']));
        return redirect()->back()->with('success', 'File updated successfully');
    }

    public function preview(File $file) // Using route model binding
    {
        return $this->fileService->previewFile($file);
    }

    public function download(File $file)
    {
        return $this->fileService->downloadFile($file);
    }

    public function delete($id)
    {
        $this->fileService->deleteFile($id);
        return redirect()->back()->with('success', 'File Deleted Successfully');
    }
}
