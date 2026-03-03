<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\support\TicketController;
use App\Http\Controllers\support\TicketReplyController;

Route::resource('tickets', TicketController::class);
Route::resource('ticket-replies', TicketReplyController::class);