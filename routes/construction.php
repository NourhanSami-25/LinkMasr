<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ConstructionController;
use App\Http\Controllers\BoqBreakdownController;
use App\Http\Controllers\ScheduleController;

Route::middleware(['auth', 'verified'])->prefix('construction')->group(function () {
    // Construction Projects List
    Route::get('/', [ConstructionController::class, 'index'])->name('construction.index');
    
    // EVM Dashboard
    Route::get('projects/{project}/evm', [ConstructionController::class, 'evmDashboard'])->name('construction.evm.dashboard');
    
    // BOQ Management
    Route::get('projects/{project}/boq', [ConstructionController::class, 'boqIndex'])->name('construction.boq.index');
    Route::post('projects/{project}/boq', [ConstructionController::class, 'boqStore'])->name('construction.boq.store');
    
    // BOQ Breakdown Analysis
    Route::get('boq/{boq}/breakdown', [BoqBreakdownController::class, 'show'])->name('construction.boq.breakdown');
    Route::post('boq/{boq}/breakdown', [BoqBreakdownController::class, 'store'])->name('construction.boq.breakdown.store');
    Route::put('breakdown/{item}', [BoqBreakdownController::class, 'update'])->name('construction.breakdown.update');
    Route::delete('breakdown/{item}', [BoqBreakdownController::class, 'destroy'])->name('construction.breakdown.destroy');
    Route::get('boq/{boq}/breakdown/items', [BoqBreakdownController::class, 'getItems'])->name('construction.boq.breakdown.items');
    Route::post('boq/{boq}/breakdown/import', [BoqBreakdownController::class, 'import'])->name('construction.boq.breakdown.import');
    
    // Progress Tracking
    Route::get('projects/{project}/progress/create', [ConstructionController::class, 'progressCreate'])->name('construction.progress.create');
    Route::post('projects/{project}/progress', [ConstructionController::class, 'progressStore'])->name('construction.progress.store');
    
    // Schedule / Gantt Chart
    Route::get('schedules', [ScheduleController::class, 'index'])->name('schedules.index');
    Route::get('schedules/create', [ScheduleController::class, 'create'])->name('schedules.create');
    Route::post('schedules', [ScheduleController::class, 'store'])->name('schedules.store');
    Route::get('schedules/{id}', [ScheduleController::class, 'show'])->name('schedules.show');
    Route::post('schedules/{id}/tasks', [ScheduleController::class, 'addTask'])->name('schedules.tasks.store');
    Route::put('tasks/{taskId}', [ScheduleController::class, 'updateTask'])->name('schedules.tasks.update');
    Route::delete('tasks/{taskId}', [ScheduleController::class, 'deleteTask'])->name('schedules.tasks.destroy');
    Route::post('dependencies', [ScheduleController::class, 'addDependency'])->name('schedules.dependencies.store');
    Route::delete('dependencies/{predecessorId}/{successorId}', [ScheduleController::class, 'removeDependency'])->name('schedules.dependencies.destroy');
    Route::get('schedules/{id}/tasks-json', [ScheduleController::class, 'getTasksJson'])->name('schedules.tasks.json');
    Route::post('tasks/{taskId}/progress', [ScheduleController::class, 'updateProgress'])->name('schedules.tasks.progress');
    
    // BOQ Description Presets Management
    Route::get('boq/description-presets', [ConstructionController::class, 'getDescriptionPresets'])->name('construction.boq.presets.index');
    Route::post('boq/description-presets', [ConstructionController::class, 'storeDescriptionPreset'])->name('construction.boq.presets.store');
    Route::put('boq/description-presets/{preset}', [ConstructionController::class, 'updateDescriptionPreset'])->name('construction.boq.presets.update');
    Route::delete('boq/description-presets/{preset}', [ConstructionController::class, 'destroyDescriptionPreset'])->name('construction.boq.presets.destroy');
});
