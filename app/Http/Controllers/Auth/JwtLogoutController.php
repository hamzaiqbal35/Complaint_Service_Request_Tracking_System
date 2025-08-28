<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class JwtLogoutController extends Controller
{
    public function logout(Request $request)
    {
        try {
            // Get token from session
            $token = session('jwt_token');
            
            if ($token) {
                // Invalidate the token
                JWTAuth::setToken($token);
                JWTAuth::invalidate($token);
            }
            
            // Clear session
            $request->session()->forget('jwt_token');
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            
            // Logout user
            Auth::logout();
            
            return response()->json([
                'status' => 'success',
                'message' => 'Successfully logged out'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error during logout'
            ], 500);
        }
    }

    public function logoutWeb(Request $request)
    {
        try {
            // Get token from session
            $token = session('jwt_token');
            
            if ($token) {
                // Invalidate the token
                JWTAuth::setToken($token);
                JWTAuth::invalidate($token);
            }
            
            // Clear session
            $request->session()->forget('jwt_token');
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            
            // Logout user
            Auth::logout();
            
            return redirect()->route('jwt.login')->with('success', 'Successfully logged out');
            
        } catch (\Exception $e) {
            return redirect()->route('jwt.login')->with('error', 'Error during logout');
        }
    }
}
