<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    public function create(): View
    {
        if (!session()->has('url.intended')) {
            $previous = url()->previous();
            // Don't redirect to API endpoints or notification URLs after login
            if (!str_contains($previous, '/notifications/') && 
                !str_contains($previous, '/api/') && 
                $previous !== url()->current()) {
                session()->put('url.intended', $previous);
            }
        }
        return view('auth.login');
    }

    public function store(LoginRequest $request): RedirectResponse
    {
        $credentials = $request->only('email', 'password'); // Extract email and password from the request
        $remember = $request->has('remember'); // Check if the "Remember Me" checkbox is checked

        if (Auth::attempt($credentials, $remember)) {
            // Regenerate session on successful login
            $request->session()->regenerate();

            // Get intended URL and validate it's not an API endpoint
            $intendedUrl = session()->pull('url.intended', route('index'));
            
            // If intended URL is an API endpoint or notification URL, redirect to dashboard instead
            if (str_contains($intendedUrl, '/notifications/') || 
                str_contains($intendedUrl, '/api/') ||
                str_contains($intendedUrl, 'login')) {
                return redirect()->route('index');
            }
            
            return redirect()->intended($intendedUrl);
        }

        // Redirect back with an error message if authentication fails
        return back()->withErrors(['login' => 'Invalid email or password'])->onlyInput('email');
    }


    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
