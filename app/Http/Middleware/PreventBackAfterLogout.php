<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

class PreventBackAfterLogout
{
    protected $except = [
        'login',
        'register',
        'password/reset*',
        'email/verify*',
        'jwt/*',
        'api/*',
        '_debugbar/*',
        'horizon/*',
        'telescope/*',
    ];

    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Skip for specific routes
        if ($this->inExceptArray($request)) {
            return $response;
        }

        // Add cache control headers to all responses
        $response->headers->set('Cache-Control', 'no-cache, no-store, must-revalidate, post-check=0, pre-check=0');
        $response->headers->set('Pragma', 'no-cache');
        $response->headers->set('Expires', 'Sat, 01 Jan 2000 00:00:00 GMT');
        $response->headers->set('Last-Modified', gmdate('D, d M Y H:i:s') . ' GMT');

        // For authenticated users, add additional headers
        if (Auth::check()) {
            $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
            $response->headers->set('X-Content-Type-Options', 'nosniff');
            $response->headers->set('X-XSS-Protection', '1; mode=block');
        }

        return $response;
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
