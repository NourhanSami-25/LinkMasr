<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\SubcontractController;
use App\Http\Controllers\TenderController;
use App\Http\Controllers\SubcontractorInvoiceController;
use App\Http\Controllers\ClientInvoiceController;

Route::middleware(['auth', 'verified'])->group(function () {
    // Vendors
    Route::prefix('vendors')->group(function () {
        Route::get('/', [VendorController::class, 'index'])->name('vendors.index');
        Route::get('/create', [VendorController::class, 'create'])->name('vendors.create');
        Route::post('/', [VendorController::class, 'store'])->name('vendors.store');
        Route::get('/{id}', [VendorController::class, 'show'])->name('vendors.show');
        Route::get('/{id}/edit', [VendorController::class, 'edit'])->name('vendors.edit');
        Route::put('/{id}', [VendorController::class, 'update'])->name('vendors.update');
        Route::delete('/{id}', [VendorController::class, 'destroy'])->name('vendors.destroy');
        Route::post('/{id}/toggle-status', [VendorController::class, 'toggleStatus'])->name('vendors.toggle-status');
    });

    // Subcontracts
    Route::prefix('subcontracts')->group(function () {
        Route::get('/', [SubcontractController::class, 'index'])->name('subcontracts.index');
        Route::get('/create', [SubcontractController::class, 'create'])->name('subcontracts.create');
        Route::post('/', [SubcontractController::class, 'store'])->name('subcontracts.store');
        Route::get('/boq-items/{projectId}', [SubcontractController::class, 'getBoqItems'])->name('subcontracts.boq-items');
        Route::get('/{id}', [SubcontractController::class, 'show'])->name('subcontracts.show')->where('id', '[0-9]+');
        Route::get('/{id}/edit', [SubcontractController::class, 'edit'])->name('subcontracts.edit')->where('id', '[0-9]+');
        Route::put('/{id}', [SubcontractController::class, 'update'])->name('subcontracts.update')->where('id', '[0-9]+');
        Route::delete('/{id}', [SubcontractController::class, 'destroy'])->name('subcontracts.destroy')->where('id', '[0-9]+');
        Route::post('/{id}/activate', [SubcontractController::class, 'activate'])->name('subcontracts.activate')->where('id', '[0-9]+');
        Route::post('/{id}/complete', [SubcontractController::class, 'complete'])->name('subcontracts.complete')->where('id', '[0-9]+');
    });

    // Subcontractor Invoices
    Route::prefix('subcontractor-invoices')->group(function () {
        Route::get('/', [SubcontractorInvoiceController::class, 'index'])->name('subcontractor-invoices.index');
        Route::get('/create', [SubcontractorInvoiceController::class, 'create'])->name('subcontractor-invoices.create');
        Route::post('/', [SubcontractorInvoiceController::class, 'store'])->name('subcontractor-invoices.store');
        Route::get('/{id}', [SubcontractorInvoiceController::class, 'show'])->name('subcontractor-invoices.show');
        Route::delete('/{id}', [SubcontractorInvoiceController::class, 'destroy'])->name('subcontractor-invoices.destroy');
        Route::post('/{id}/submit', [SubcontractorInvoiceController::class, 'submit'])->name('subcontractor-invoices.submit');
        Route::post('/{id}/approve', [SubcontractorInvoiceController::class, 'approve'])->name('subcontractor-invoices.approve');
        Route::post('/{id}/paid', [SubcontractorInvoiceController::class, 'markPaid'])->name('subcontractor-invoices.paid');
        Route::get('/{id}/print', [SubcontractorInvoiceController::class, 'print'])->name('subcontractor-invoices.print');
    });

    // Client Invoices (Progress Claims)
    Route::prefix('client-invoices')->group(function () {
        Route::get('/', [ClientInvoiceController::class, 'index'])->name('client-invoices.index');
        Route::get('/create', [ClientInvoiceController::class, 'create'])->name('client-invoices.create');
        Route::post('/', [ClientInvoiceController::class, 'store'])->name('client-invoices.store');
        Route::get('/{id}', [ClientInvoiceController::class, 'show'])->name('client-invoices.show');
        Route::delete('/{id}', [ClientInvoiceController::class, 'destroy'])->name('client-invoices.destroy');
        Route::post('/{id}/submit', [ClientInvoiceController::class, 'submit'])->name('client-invoices.submit');
        Route::post('/{id}/certify', [ClientInvoiceController::class, 'certify'])->name('client-invoices.certify');
        Route::get('/{id}/print', [ClientInvoiceController::class, 'print'])->name('client-invoices.print');
    });
});
