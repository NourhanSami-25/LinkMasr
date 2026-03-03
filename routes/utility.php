<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\utility\AnnouncementController;
use App\Http\Controllers\utility\NotificationController;
use App\Http\Controllers\utility\TodoController;
use App\Http\Controllers\utility\TodoItemController;
use App\Http\Controllers\utility\GoalController;
use App\Http\Controllers\utility\PrintingController;


Route::resource('announcements', AnnouncementController::class);
Route::resource('todos', TodoController::class);
Route::resource('todoItems', TodoItemController::class);
Route::resource('goals', GoalController::class);


// Printing
// ---------------------------------------------------------------------------------------------------------------------------------------------------------------
Route::get('/print/{model}/{id}', [PrintingController::class, 'print'])->name('print.model');


// NOTIFICATIONS
// ---------------------------------------------------------------------------------------------------------------------------------------------------------------
Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
Route::get('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
Route::get('/notifications/{id}/unread', [NotificationController::class, 'markAsUnRead'])->name('notifications.markAsUnRead');
Route::get('/notifications/read', [NotificationController::class, 'markAllAsRead'])->name('notifications.markAllAsRead');
Route::delete('/notifications/{id}', [NotificationController::class, 'delete'])->name('notifications.destroy');
Route::delete('/notifications/delete-all', [NotificationController::class, 'deleteAllForUser'])->name('notifications.destroyAllForUser');
Route::delete('/notifications/delete-all-admin', [NotificationController::class, 'deleteAllNotifications']); // Admin-only
// Realtime update notifications (latest 20) to read
Route::post('/notifications/mark-as-read-latest', [NotificationController::class, 'markAsReadLatest'])->name('notifications.markAsReadLatest');
// Realtime fetch notifications (latest 20) to header, fetch every 30 Seconds
Route::get('/notifications/latest', [NotificationController::class, 'getLatestNotifications'])->name('notifications.latest');
// ---------------------------------------------------------------------------------------------------------------------------------------------------------------


// TodoList
// ---------------------------------------------------------------------------------------------------------------------------------------------------------------
Route::get('/todosget', [TodoController::class, 'getLatestTodos'])->name('todos.latest');
Route::get('/todos/{id}/toggle-status', [TodoController::class, 'toggleTodoStatus'])->name('todos.toggleStatus'); // Toggle Todolist Status
Route::post('/todo-items/{id}/toggle-status', [TodoItemController::class, 'toggleStatus']); // Toggle Todolist Item Status


// Announcement
// ---------------------------------------------------------------------------------------------------------------------------------------------------------------
Route::post('/announcements/expire', [AnnouncementController::class, 'expireAnnouncements'])
    ->name('announcements.expire');

// Route to delete all expired announcements
Route::delete('/announcements/delete-expired', [AnnouncementController::class, 'deleteExpiredAnnouncements'])
    ->name('announcements.deleteExpired');

// Route to toggle status for a specific announcement
Route::patch('/announcements/{id}/toggle-status', [AnnouncementController::class, 'toggleAnnouncementStatus'])
    ->name('announcements.toggleStatus');
