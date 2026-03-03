<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\log\LogController;


Route::get('requests-logs', [LogController::class, 'indexRequests'])->name('indexRequests');
Route::get('requests-logs-all', [LogController::class, 'indexRequestsAll'])->name('indexRequestsAll');

Route::get('errors-logs', [LogController::class, 'indexErrors'])->name('indexErrors');
Route::get('errors-logs-all', [LogController::class, 'indexErrorsAll'])->name('indexErrorsAll');

Route::get('monthly-requests-logs', [LogController::class, 'getMonthlyLogsRequests'])->name('getMonthlyLogsRequests');
Route::get('monthly-errors-logs', [LogController::class, 'getMonthlyLogsErrors'])->name('getMonthlyLogsErrors');

Route::delete('logs/delete-requests', [LogController::class, 'deleteRequestsLogs'])->name('deleteRequestsLogs');
Route::delete('logs/delete-errors', [LogController::class, 'deleteErrorsLogs'])->name('deleteErrorsLogs');
