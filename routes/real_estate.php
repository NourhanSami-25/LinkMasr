<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\real_estate\RealEstateController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('projects/{project}/partners', [RealEstateController::class, 'projectPartners'])->name('projects.partners');
    Route::post('projects/{project}/partners', [RealEstateController::class, 'storePartner'])->name('projects.partners.store');
    
    Route::get('projects/{project}/financials', [RealEstateController::class, 'projectFinancials'])->name('projects.financials');
    
    // Drawings Logic
    Route::get('projects/{project}/drawings', [RealEstateController::class, 'projectDrawings'])->name('projects.drawings');
    Route::get('projects/{project}/drawings/{drawing}', [RealEstateController::class, 'showDrawing'])->name('projects.drawings.show');
    Route::post('projects/{project}/drawings', [RealEstateController::class, 'storeDrawing'])->name('projects.drawings.store');
    Route::post('projects/{project}/units/{unit}/coordinates', [RealEstateController::class, 'updateUnitCoordinates'])->name('projects.units.coordinates');

    // Construction Cost Module
    Route::get('materials', [\App\Http\Controllers\real_estate\ConstructionCostController::class, 'indexMaterials'])->name('materials.index');
    Route::post('materials', [\App\Http\Controllers\real_estate\ConstructionCostController::class, 'storeMaterial'])->name('materials.store');
    Route::put('materials/{id}', [\App\Http\Controllers\real_estate\ConstructionCostController::class, 'updateMaterial'])->name('materials.update');
    Route::post('materials/{id}/prices', [\App\Http\Controllers\real_estate\ConstructionCostController::class, 'storePrice'])->name('materials.prices.store');

    Route::get('estimates', [\App\Http\Controllers\real_estate\ConstructionCostController::class, 'indexEstimates'])->name('estimates.index');
    Route::get('estimates/create', [\App\Http\Controllers\real_estate\ConstructionCostController::class, 'createEstimate'])->name('estimates.create');
    Route::post('estimates', [\App\Http\Controllers\real_estate\ConstructionCostController::class, 'storeEstimate'])->name('estimates.store');
    Route::get('estimates/{id}', [\App\Http\Controllers\real_estate\ConstructionCostController::class, 'showEstimate'])->name('estimates.show');
    Route::delete('estimates/{id}', [\App\Http\Controllers\real_estate\ConstructionCostController::class, 'deleteEstimate'])->name('estimates.delete');
    
    // Units Inventory
    Route::get('projects/{project}/units/inventory', [RealEstateController::class, 'unitsInventory'])->name('units.inventory');
    Route::post('units/{unit}/status', [RealEstateController::class, 'updateUnitStatus'])->name('units.status.update');
});
