<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AssignComplaintRequest;
use App\Http\Requests\UpdateComplaintStatusRequest;
use App\Models\Category;
use App\Models\Complaint;
use App\Models\ComplaintLog;
use App\Models\User;
use App\Notifications\ComplaintAssigned;
use App\Notifications\ComplaintRejected;
use App\Notifications\ComplaintStatusUpdated;
use Illuminate\Http\Request;

class ComplaintAdminController extends Controller
{
    public function index(Request $request)
    {
        $query = Complaint::with('category', 'creator', 'assignee')->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('id', $search);
            });
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $complaints = $query->paginate(15)->withQueryString();

        // Provide categories for the filter dropdown
        $categories = Category::all();

        // System-wide statistics (unfiltered for top dashboard)
        $stats = [
            'total' => Complaint::count(),
            'pending' => Complaint::where('status', 'pending')->count(),
            'in_progress' => Complaint::where('status', 'in_progress')->count(),
            'resolved' => Complaint::where('status', 'resolved')->count(),
            'rejected' => Complaint::where('status', 'rejected')->count(),
            'unassigned' => Complaint::whereNull('assigned_to')->count(),
            'total_users' => User::where('role', 'user')->count(),
            'total_staff' => User::where('role', 'staff')->count(),
        ];

        return view('admin.complaints.index', compact('complaints', 'stats', 'categories'));
    }

    public function show(Complaint $complaint)
    {
        $complaint->load(['category', 'creator', 'assignee', 'logs.user']);

        return view('admin.complaints.show', compact('complaint'));
    }

    public function edit(Complaint $complaint)
    {
        $staff = User::where('role', 'staff')->orderBy('name')->get();

        return view('admin.complaints.edit', compact('complaint', 'staff'));
    }

    public function assign(AssignComplaintRequest $request, Complaint $complaint)
    {
        $complaint->update(['assigned_to' => $request->input('assigned_to')]);

        ComplaintLog::create([
            'complaint_id' => $complaint->id,
            'user_id' => auth()->id(),
            'action' => 'assigned',
            'message' => 'Assigned to staff',
            'meta' => ['assigned_to' => $complaint->assigned_to],
        ]);

        if ($complaint->assignee) {
            $complaint->assignee->notify(new ComplaintAssigned($complaint));
        }

        return back()->with('success', 'Assignment updated.');
    }

    public function updateStatus(UpdateComplaintStatusRequest $request, Complaint $complaint)
    {
        $from = $complaint->status;
        $complaint->update([
            'status' => $request->input('status'),
            'resolved_at' => $request->input('status') === 'resolved' ? now() : null,
        ]);

        ComplaintLog::create([
            'complaint_id' => $complaint->id,
            'user_id' => auth()->id(),
            'action' => 'status_changed',
            'message' => $request->input('message'),
            'meta' => ['from' => $from, 'to' => $complaint->status],
        ]);

        if ($complaint->status === 'rejected') {
            $complaint->creator->notify(new ComplaintRejected($complaint));
        } else {
            $complaint->creator->notify(new ComplaintStatusUpdated($complaint));
        }

        return back()->with('success', 'Status updated.');
    }

    public function update(Request $request, Complaint $complaint)
    {
        $validated = $request->validate([
            'status' => 'sometimes|in:pending,in_progress,resolved,rejected',
            'resolution' => 'nullable|string',
            'priority' => 'sometimes|in:low,medium,high',
        ]);

        $complaint->update($validated);

        return redirect()->route('admin.complaints.index')->with('success', 'Complaint updated.');
    }
}
