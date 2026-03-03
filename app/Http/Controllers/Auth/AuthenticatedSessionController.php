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
            session()->put('url.intended', url()->previous());
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

            // Redirect to intended URL or fallback
            $intendedUrl = session()->pull('url.intended', route('index'));
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
