<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\business\ContractController;
use App\Http\Controllers\business\LeadController;
use App\Http\Controllers\business\ProposalController;

Route::resource('contracts', ContractController::class);
Route::resource('leads', LeadController::class);
Route::resource('proposals', ProposalController::class);
