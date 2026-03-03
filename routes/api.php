<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\event\EventFunctionController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('calendarevents', [EventFunctionController::class, 'getCalendarEvents']);

// Construction BOQ Items API
Route::get('projects/{project}/boq-items', function($projectId) {
    return \App\Models\ConstructionBoq::where('project_id', $projectId)
        ->select('id', 'code', 'item_description')
        ->get();
});

// Materials Price API (for cost estimation)
Route::get('materials/{id}/price', [\App\Http\Controllers\real_estate\ConstructionCostController::class, 'getPrice']);

// Property Units API (for contract linking)
Route::get('projects/{project}/units', function($projectId) {
    return \App\Models\real_estate\PropertyUnit::where('project_id', $projectId)
        ->select('id', 'name', 'status', 'price')
        ->get();
});
