<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\client\ClientController;
use App\Http\Controllers\client\ClientFunctionController;
use App\Http\Controllers\client\AddressController;
use App\Http\Controllers\client\BillingAddressController;
use App\Http\Controllers\client\ClientContactController;


Route::resource('clients', ClientController::class);
Route::resource('addresses', AddressController::class);
Route::resource('billing-addresses', BillingAddressController::class);
Route::resource('client-contacts', ClientContactController::class);


// Full report routes
Route::get('client-statment/{id}', [ClientFunctionController::class, 'statment'])->name('clientStatment');
Route::get('print-statment/{id}', [ClientFunctionController::class, 'printStatment'])->name('client.printStatment');
Route::get('client/activate/{id}', [ClientFunctionController::class, 'activate'])->name('clients.activate');
Route::get('client/disable/{id}', [ClientFunctionController::class, 'disable'])->name('clients.disable');
