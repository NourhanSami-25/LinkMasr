<?php

use App\Http\Controllers\dashboard\DashboardController;
use Illuminate\Support\Facades\Route;


Route::get('dashboard', [DashboardController::class, 'index'])->name('home');
