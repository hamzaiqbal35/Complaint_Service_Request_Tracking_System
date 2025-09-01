<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LogoutController extends Controller
{
    public function logout(Request $request)
    {
        try {
            $user = $request->user();
            
            Auth::logout();
            
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            
            Log::info('User logged out successfully', [
                'user_id' => $user ? $user->id : null,
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent()
            ]);
            
            return redirect('/');
        } catch (\Exception $e) {
            Log::error('Logout failed', [
                'error' => $e->getMessage(),
                'user_id' => $request->user() ? $request->user()->id : null,
                'ip' => $request->ip(),
                'trace' => $e->getTraceAsString()
            ]);
            
            // Still log the user out even if logging fails
            Auth::logout();
            $request->session()->invalidate();
            
            return redirect('/')->with('error', 'An error occurred during logout. You have been logged out for security.');
        }
    }
}
