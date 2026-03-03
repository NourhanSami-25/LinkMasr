<?php

use App\Http\Controllers\setting\ExchangeRateController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\setting\CurrencyController;
use App\Http\Controllers\setting\CompanyProfileController;
use App\Http\Controllers\setting\RoleController;
use App\Http\Controllers\setting\RoleFunctionController;

Route::resource('currencies', CurrencyController::class);
Route::resource('companyProfiles', CompanyProfileController::class);
Route::resource('roles', RoleController::class);
Route::resource('exchangeRates', ExchangeRateController::class);


Route::get('users-roles', [RoleFunctionController::class, 'users_roles_index'])->name('users_roles_index');
Route::get('users-roles-edit/{id}', [RoleFunctionController::class, 'users_roles_edit'])->name('users_roles_edit');
Route::post('users-roles-update/{id}', [RoleFunctionController::class, 'users_roles_update'])->name('users_roles_update');
// Route::get('roles-config', [RoleController::class, 'roles_config'])->name('roles_config');