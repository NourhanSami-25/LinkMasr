<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class Logging
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->isMethod('get')) {
            Log::channel('daily_requests')->info('Request logged:', [
                'method' => $request->method(),
                'url' => $request->fullUrl(),
                'ip' => $request->ip(),

                // need to add user , action
                'user' => $request->user() ? $request->user()->name : 'Guest', // Log user name or 'Guest'
                'action' => $request->route()->getActionName() // Log the action (controller@method)
            ]);
        }

        return $next($request);
    }
}
