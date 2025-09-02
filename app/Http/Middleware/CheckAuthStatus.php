<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

class CheckAuthStatus
{
    protected $except = [
        'login',
        'logout',
        'password/reset*',
        'register',
        'email/verify*',
        'jwt/*',
        'api/*'
    ];

    public function handle(Request $request, Closure $next): Response
    {
        // Skip for specific routes
        if ($this->inExceptArray($request)) {
            return $next($request);
        }

        $response = $next($request);

        // If user is not authenticated and this is a GET request, redirect to login
        if (!Auth::check() && $request->isMethod('get')) {
            // Clear any existing session data
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            
            // Redirect to login with cache control headers
            return redirect()->route('login')
                ->header('Cache-Control', 'no-store, no-cache, must-revalidate, post-check=0, pre-check=0')
                ->header('Pragma', 'no-cache')
                ->header('Expires', 'Sat, 01 Jan 2000 00:00:00 GMT');
        }

        // Prevent caching of authenticated pages
        return $response->header('Cache-Control', 'no-store, no-cache, must-revalidate, post-check=0, pre-check=0')
            ->header('Pragma', 'no-cache')
            ->header('Expires', 'Sat, 01 Jan 2000 00:00:00 GMT');
    }

    protected function inExceptArray($request)
    {
        foreach ($this->except as $except) {
            if ($except !== '/') {
                $except = trim($except, '/');
            }

            if ($request->fullUrlIs($except) || $request->is($except)) {
                return true;
            }
        }

        return false;
    }
}
