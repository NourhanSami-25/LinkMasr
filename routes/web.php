<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\dashboard\DashboardController;
use App\Http\Controllers\error\ErrorController;

Route::middleware(['web', 'logging', 'auth', 'verified'])
    ->group(function () {

        Route::get('/', [DashboardController::class, 'index'])->name('index');

        Route::get('comming-soon', function () {
            return view('support.comming_soon'); // Ensure 'comming_soon.blade.php' exists in resources/views
        })->name('comming_soon');

        Route::get('error-details/{message}', [ErrorController::class, 'index'])->name('error.index'); // Error Message Details Route - Finall 

        // Language switcher route
        Route::get('/switch-language/{lang}', function ($lang) {
            if (!in_array($lang, ['en', 'ar'])) {  // Validate the language parameter
                abort(400);
            }
            session(['app_locale' => $lang]); // Store the language in the session

            if (auth()->check()) {
                auth()->user()->update(['language' => $lang]);
            }

            return redirect()->back();
        })->name('switch-language');

        Route::get('print', function () {
            return view('utility.print.index'); // Ensure 'comming_soon.blade.php' exists in resources/views
        })->name('print');





        require __DIR__ . '/business.php';
        require __DIR__ . '/calendar.php';
        require __DIR__ . '/client.php';
        require __DIR__ . '/common.php';
        require __DIR__ . '/dashboard.php';
        require __DIR__ . '/documentation.php';
        require __DIR__ . '/finance.php';
        require __DIR__ . '/hr.php';
        require __DIR__ . '/log.php';
        require __DIR__ . '/media.php';
        require __DIR__ . '/project.php';
        require __DIR__ . '/request.php';
        require __DIR__ . '/reminder.php';
        require __DIR__ . '/setting.php';
        require __DIR__ . '/static.php';
        require __DIR__ . '/setting.php';
        require __DIR__ . '/support.php';
        require __DIR__ . '/task.php';
        require __DIR__ . '/user.php';
        require __DIR__ . '/utility.php';
        require __DIR__ . '/real_estate.php';
        require __DIR__ . '/construction.php';
        require __DIR__ . '/partners.php';
        require __DIR__ . '/sales.php';
        require __DIR__ . '/procurement.php';
    });

require __DIR__ . '/auth.php';
