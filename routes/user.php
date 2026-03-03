<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\user\UserController;
use App\Http\Controllers\user\UserFunctionController;

Route::resource('users', UserController::class);
Route::get('user/activate/{id}', [UserFunctionController::class, 'activate'])->name('users.activate');
Route::get('user/disable/{id}', [UserFunctionController::class, 'disable'])->name('users.disable');
Route::get('/user/show-data', [UserController::class, 'showUserData'])->name('user.showData');
Route::get('/default-language/{lang}', [UserFunctionController::class, 'default_lang'])->name('default-language');
