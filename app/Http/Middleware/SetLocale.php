<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && auth()->user()->language) {
            // Use the user's preferred language
            App::setLocale(auth()->user()->language);
            Session::put('app_locale', auth()->user()->language);
        } else {
            // Use the session value or fallback to Arabic
            $locale = Session::get('app_locale', 'ar');
            App::setLocale($locale);
        }

        return $next($request);
    }
}
