<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\hr\DepartmentController;
use App\Http\Controllers\hr\PositionController;
use App\Http\Controllers\hr\SectorController;
use App\Http\Controllers\hr\BalanceController;
use App\Http\Controllers\hr\RequestReportController;

Route::resource('sectors', SectorController::class);
Route::resource('departments', DepartmentController::class);
Route::resource('positions', PositionController::class);
Route::resource('balances', BalanceController::class);
Route::get('/reports/requests', [RequestReportController::class, 'requests_reports'])->name('report.requests');
