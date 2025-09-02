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
            
            // Revoke the current user's token
            $user->currentAccessToken()->delete();
            
            // Clear the session
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            
            // Clear any existing tokens
            $user->tokens()->delete();
            
            // Clear the authentication state
            Auth::logout();
            
            // Redirect to login page
            return redirect('/login')
                ->with('status', 'You have been successfully logged out!');
                
        } catch (\Exception $e) {
            // Log the error
            \Log::error('Logout error: ' . $e->getMessage());
            
            // Still redirect to login even if there was an error
            return redirect('/login')
                ->with('error', 'There was an error during logout. Please try again.');
        }
    }
}
