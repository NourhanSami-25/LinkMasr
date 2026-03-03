<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\reminder\ReminderController;
use App\Http\Controllers\reminder\ReminderFunctionController;
use App\Models\Reminder\Reminder;


Route::resource('reminders', ReminderController::class);
Route::get('reminders/mark-completed/{id}', [ReminderFunctionController::class, 'markAsCompleted'])->name('reminders.markCompleted');
Route::get('reminders/mark-pending/{id}', [ReminderFunctionController::class, 'markAsPending'])->name('reminders.markPending');





// TEST
Route::get('checkReminder', [ReminderFunctionController::class, 'getPendingReminders'])->name('reminders.getPendingReminders');
