<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        \Illuminate\Support\Facades\DB::transaction(function () use ($user) {
            // Withdraw active complaints
            $activeComplaints = $user->complaints()->whereIn('status', ['pending', 'in_progress'])->get();
            foreach ($activeComplaints as $complaint) {
                $complaint->update(['status' => 'withdrawn']);
                
                \App\Models\ComplaintLog::create([
                    'complaint_id' => $complaint->id,
                    'user_id' => $user->id,
                    'action' => 'withdrawn',
                    'message' => 'Withdrawn due to account closure.',
                    'meta' => ['auto_withdrawn' => true]
                ]);

                $admins = \App\Models\User::where('role', 'admin')->get();
                \Illuminate\Support\Facades\Notification::send($admins, new \App\Notifications\ComplaintWithdrawn($complaint));

                if ($complaint->assignee) {
                    $complaint->assignee->notify(new \App\Notifications\ComplaintWithdrawn($complaint));
                }
            }

            // Append suffix to email to allow future re-registration
            $user->email = $user->email . '::deleted_' . time();
            $user->save();

            // Soft delete the user
            $user->delete();
        });

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
