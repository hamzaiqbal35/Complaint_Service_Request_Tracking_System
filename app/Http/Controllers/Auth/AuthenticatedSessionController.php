<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();
        $user = $request->user();

        // Create a JWT token for this authenticated user and store in session
        try {
            $token = JWTAuth::fromUser($user);
            $request->session()->put('jwt_token', $token);
        } catch (\Throwable $e) {
            // If token creation fails, continue with session auth
        }

        if ($user->isAdmin()) {
            return redirect()->intended(route('admin.dashboard', absolute: false));
        }
        if ($user->isStaff()) {
            return redirect()->intended(route('staff.dashboard', absolute: false));
        }
        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        // Invalidate JWT if present
        if ($request->session()->has('jwt_token')) {
            try {
                $token = $request->session()->get('jwt_token');
                JWTAuth::setToken($token);
                JWTAuth::invalidate();
            } catch (\Throwable $e) {
                // ignore and continue logout
            }
        }

        Auth::guard('web')->logout();

        $request->session()->forget('jwt_token');
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
