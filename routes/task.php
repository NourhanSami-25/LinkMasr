<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\task\TaskController;
use App\Http\Controllers\task\TaskFunctionController;

Route::resource('tasks', TaskController::class);
Route::get('tasks/{task}/change-status/{status}', [TaskFunctionController::class, 'change_status'])->name('tasks.change-status');
