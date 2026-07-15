<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $query = auth()->user()->notifications();

        if ($request->filled('status')) {
            if ($request->status === 'unread') {
                $query->whereNull('read_at');
            } elseif ($request->status === 'read') {
                $query->whereNotNull('read_at');
            }
        }

        if ($request->filled('sort')) {
            if ($request->sort === 'oldest') {
                // Laravel's database notifications use latest() by default, so we reorder if oldest is requested
                $query->reorder()->orderBy('created_at', 'asc');
            }
        }

        $notifications = $query->paginate(15)->withQueryString();

        return view('notifications.index', compact('notifications'));
    }

    public function markAsRead(Request $request, $id)
    {
        $notification = auth()->user()->notifications()->findOrFail($id);
        $notification->markAsRead();

        if ($request->wantsJson()) {
            return response()->json(['success' => true]);
        }

        return back();
    }

    public function markAllAsRead(Request $request)
    {
        auth()->user()->unreadNotifications->markAsRead();

        if ($request->wantsJson()) {
            return response()->json(['success' => true]);
        }

        return back()->with('success', 'All notifications marked as read.');
    }

    public function destroy($id)
    {
        $notification = auth()->user()->notifications()->findOrFail($id);
        $notification->delete();

        return back()->with('success', 'Notification deleted.');
    }

    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:read,delete',
            'notifications' => 'required|array',
            'notifications.*' => 'exists:notifications,id',
        ]);

        $notifications = auth()->user()->notifications()->whereIn('id', $request->notifications)->get();

        if ($request->action === 'read') {
            $notifications->markAsRead();
            $message = 'Selected notifications marked as read.';
        } elseif ($request->action === 'delete') {
            foreach ($notifications as $notification) {
                $notification->delete();
            }
            $message = 'Selected notifications deleted.';
        }

        return back()->with('success', $message);
    }
}
