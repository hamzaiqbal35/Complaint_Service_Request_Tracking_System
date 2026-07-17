<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EmailVerificationPromptController extends Controller
{
    /**
     * Display the email verification prompt.
     */
    public function __invoke(Request $request): RedirectResponse|View
    {
        if ($request->user()->hasVerifiedEmail()) {
            $role = $request->user()->role;
            $routeName = 'dashboard';
            if ($role === 'admin') {
                $routeName = 'admin.dashboard';
            } elseif ($role === 'staff') {
                $routeName = 'staff.dashboard';
            }
            return redirect()->intended(route($routeName, absolute: false));
        }

        return view('auth.verify-email');
    }
}
