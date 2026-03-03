<?php

use App\Http\Controllers\reminder\ReminderController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\event\EventController;

Route::resource('events', EventController::class);
