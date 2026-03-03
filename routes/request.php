<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\request\VacationRequestController;
use App\Http\Controllers\request\PermissionRequestController;
use App\Http\Controllers\request\MissionRequestController;
use App\Http\Controllers\request\MoneyRequestController;
use App\Http\Controllers\request\OvertimeRequestController;
use App\Http\Controllers\request\SupportRequestController;
use App\Http\Controllers\request\WorkhomeRequestController;
use App\Http\Controllers\request\ApproveController;
use App\Http\Controllers\request\RequestFunctionController;


Route::resource('vacation-requests', VacationRequestController::class);
Route::resource('permission-requests', PermissionRequestController::class);
Route::resource('mission-requests', MissionRequestController::class);
Route::resource('money-requests', MoneyRequestController::class);
Route::resource('overtime-requests', OvertimeRequestController::class);
Route::resource('support-requests', SupportRequestController::class);
Route::resource('workhome-requests', WorkhomeRequestController::class);

Route::get('all-requests', [RequestFunctionController::class, 'all_requests'])->name('requests.all_requests');
Route::get('staff-requests', [RequestFunctionController::class, 'staff_requests'])->name('requests.staff_requests');
Route::get('department-requests/{id}', [RequestFunctionController::class, 'department_requests'])->name('requests.department_requests');


Route::get('managed-requests/{id}', [ApproveController::class, 'managed_requests'])->name('requests.managed_requests');



Route::post('/requests/{type}/{id}/approve', [ApproveController::class, 'approve_request'])->name('requests.approve');
Route::post('/requests/{type}/{id}/reject', [ApproveController::class, 'reject_request'])->name('requests.reject');
Route::post('/requests/{type}/{id}/cancel', [ApproveController::class, 'cancel_request'])->name('requests.cancel');
