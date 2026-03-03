<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\project\ProjectController;

Route::resource('projects', ProjectController::class);

use App\Http\Controllers\ConstructionController;
Route::get('projects/{project}/construction', [ConstructionController::class, 'index'])->name('projects.construction.index');
Route::post('projects/{project}/construction/boq', [ConstructionController::class, 'storeBoq'])->name('projects.construction.boq.store');

Route::get('projects/{project}/construction/boq/{boq}/resources', [ConstructionController::class, 'resources'])->name('projects.construction.resources');
Route::post('projects/{project}/construction/boq/{boq}/resources', [ConstructionController::class, 'storeResource'])->name('projects.construction.resources.store');
