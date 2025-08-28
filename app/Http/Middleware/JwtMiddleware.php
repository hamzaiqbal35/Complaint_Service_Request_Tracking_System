<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\JWTException;

class JwtMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        try {
            $token = $request->header('Authorization');
            
            if (!$token) {
                // Check if token is in session (for web routes)
                $token = session('jwt_token');
            } else {
                // Remove 'Bearer ' prefix if present
                $token = str_replace('Bearer ', '', $token);
            }

            if (!$token) {
                return redirect()->route('jwt.login')->with('error', 'Authentication required');
            }

            // Set the token for JWTAuth
            JWTAuth::setToken($token);
            
            // Get the user
            $user = JWTAuth::authenticate($token);
            
            if (!$user) {
                return redirect()->route('jwt.login')->with('error', 'Invalid token');
            }

            // Log the user in for the web session
            auth()->login($user);
            
            // Store token in session for web routes
            session(['jwt_token' => $token]);
            
        } catch (TokenExpiredException $e) {
            return redirect()->route('jwt.login')->with('error', 'Token expired');
        } catch (TokenInvalidException $e) {
            return redirect()->route('jwt.login')->with('error', 'Invalid token');
        } catch (JWTException $e) {
            return redirect()->route('jwt.login')->with('error', 'Token not found');
        }

        return $next($request);
    }
}
