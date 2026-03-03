<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\calendar\CalendarController;
use App\Http\Controllers\calendar\CalendarFunctionController;
use App\Http\Controllers\event\EventController;
use App\Http\Controllers\event\EventFunctionController;


Route::get('calendar', [CalendarController::class, 'index'])->name('calendar.index');
Route::get('/calendar/events', [CalendarFunctionController::class, 'getCalendarEvents']);
Route::resource('events', EventController::class);
Route::delete('/events/{event}', [EventController::class, 'destroy'])->name('events.destroy');
