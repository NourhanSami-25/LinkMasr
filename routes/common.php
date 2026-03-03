<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;


use App\Http\Controllers\common\NoteController;
use App\Http\Controllers\common\CommentController;
use App\Http\Controllers\common\GroupController;
use App\Http\Controllers\common\FileController;
use App\Http\Controllers\common\ActivityLogController;
use App\Http\Controllers\common\DiscussionMessageController;
use App\Models\common\Discussion;

Route::resource('notes', NoteController::class);
Route::resource('comments', CommentController::class);
Route::resource('groups', GroupController::class);
Route::resource('activity-logs', ActivityLogController::class);



// File routes of granular methods
Route::post('/upload', [FileController::class, 'upload'])->name('files.upload');
Route::post('/update/{id}', [FileController::class, 'update'])->name('files.update');
Route::get('/download/{file}', action: [FileController::class, 'download'])->name('files.download');
Route::get('/file/preview/{file}', [FileController::class, 'preview'])->name('files.preview');
Route::delete('/delete/{id}', [FileController::class, 'delete'])->name('files.delete');


// Discussion
Route::get('/discussion-messages', [DiscussionMessageController::class, 'index']);
Route::post('/discussion-messages', [DiscussionMessageController::class, 'store']);
Route::delete('/discussion-messages/{message}', [DiscussionMessageController::class, 'destroy']);

Route::get('/discussions/create', function (Request $request, \App\Services\common\DiscussionService $service) {
    $modelClass = $request->input('type');
    $modelId = $request->input('id');

    if (!class_exists($modelClass)) {
        abort(404);
    }

    $item = $modelClass::findOrFail($modelId);
    $service->createFor($item);

    return redirect()->back()->with('success', __('general.discussion_created'));
})->name('discussions.create');
