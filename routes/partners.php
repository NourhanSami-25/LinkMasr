<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PartnerController;

Route::middleware(['auth', 'verified'])->prefix('partners')->group(function () {
    // Admin: Partners Management
    Route::get('/', [PartnerController::class, 'index'])->name('partners.index');
    Route::post('projects/{project}/add', [PartnerController::class, 'addPartner'])->name('partners.add');
    Route::put('projects/{project}/partner/{partner}', [PartnerController::class, 'updatePartner'])->name('partners.update');
    Route::post('withdrawals', [PartnerController::class, 'storeWithdrawal'])->name('partners.withdrawals.store');
    
    // Partner Dashboard (For Partner himself)
    Route::get('{partner}/dashboard', [PartnerController::class, 'dashboard'])->name('partners.dashboard');
    Route::get('{partner}/projects/{project}', [PartnerController::class, 'projectDetails'])->name('partners.project.details');
    
    // Revenue Distribution
    Route::get('projects/{project}/distribution', [PartnerController::class, 'calculateDistribution'])->name('partners.distribution.calculate');
    Route::post('projects/{project}/distribution', [PartnerController::class, 'saveDistribution'])->name('partners.distribution.save');
    
    // Management Fees Account
    Route::get('management-fees', [PartnerController::class, 'managementFeesAccount'])->name('partners.management.fees');
});
