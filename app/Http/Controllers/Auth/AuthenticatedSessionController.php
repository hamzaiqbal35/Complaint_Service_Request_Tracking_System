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

        // If the user has not verified their email, send them to the
        // verification notice so they can self-verify before accessing the app.
        if (! $user->hasVerifiedEmail()) {
            return redirect()->route('verification.notice');
        }

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
        try {
            // Invalidate JWT token if it exists
            if ($token = $request->session()->get('jwt_token')) {
                try {
                    JWTAuth::setToken($token)->invalidate();
                } catch (\Throwable $e) {
                    // Token already invalid or expired
                }
                $request->session()->forget('jwt_token');
            }

            // Logout from all guards
            Auth::guard('web')->logout();
            
            // Invalidate the session
            $request->session()->invalidate();
            
            // Regenerate CSRF token
            $request->session()->regenerateToken();
            
            // Clear all session data
            $request->session()->flush();
            
            // Clear any cached authentication state
            if (isset($_SERVER['HTTP_COOKIE'])) {
                $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
                foreach($cookies as $cookie) {
                    $parts = explode('=', $cookie);
                    $name = trim($parts[0]);
                    if (strpos($name, 'XSRF-TOKEN') !== false || 
                        strpos($name, 'laravel_session') !== false || 
                        strpos($name, config('session.cookie')) !== false) {
                        setcookie($name, '', time() - 1000);
                        setcookie($name, '', time() - 1000, '/');
                    }
                }
            }
            
            // Redirect with cache control headers
            return redirect('/login')
                ->with('status', 'You have been successfully logged out!')
                ->header('Cache-Control', 'no-store, no-cache, must-revalidate, post-check=0, pre-check=0')
                ->header('Pragma', 'no-cache')
                ->header('Expires', 'Sat, 01 Jan 2000 00:00:00 GMT');
                
        } catch (\Exception $e) {
            // Log the error
            \Log::error('Logout error: ' . $e->getMessage());
            
            // Force logout and redirect even if there was an error
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            
            return redirect('/login')
                ->with('error', 'There was an error during logout. You have been logged out for security.');
        }
    }
}
