<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SalesContractController;

Route::middleware(['auth', 'verified'])->prefix('sales')->group(function () {
    // Sales Contracts
    Route::get('projects/{project}/contracts/create', [SalesContractController::class, 'create'])->name('sales.contracts.create');
    Route::post('contracts', [SalesContractController::class, 'store'])->name('sales.contracts.store');
    Route::get('contracts/{contract}', [SalesContractController::class, 'show'])->name('sales.contracts.show');
    
    // Payments
    Route::post('payments/record', [SalesContractController::class, 'recordPayment'])->name('sales.payments.record');
});
