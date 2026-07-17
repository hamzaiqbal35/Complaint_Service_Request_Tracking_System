<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateComplaintStatusRequest;
use App\Models\Category;
use App\Models\Complaint;
use App\Models\ComplaintLog;
use App\Notifications\ComplaintStatusUpdated;
use Illuminate\Http\Request;

class StaffComplaintController extends Controller
{
    public function index(Request $request)
    {
        $query = Complaint::with('category', 'creator')
            ->where('assigned_to', auth()->id());

        // Apply filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Apply sorting with whitelist and safe fallbacks
        $allowedSorts = ['id', 'created_at', 'title', 'priority', 'status'];
        $requestedSortBy = $request->get('sort_by');
        $sortBy = in_array($requestedSortBy, $allowedSorts, true) && ! empty($requestedSortBy)
            ? $requestedSortBy
            : 'created_at';
        $sortOrder = $request->get('sort_order') === 'asc' ? 'asc' : 'desc';
        $query->orderBy($sortBy, $sortOrder);

        $complaints = $query->paginate(15)->withQueryString();
        $categories = Category::all();

        return view('staff.complaints.index', compact('complaints', 'categories'));
    }

    public function show(Complaint $complaint)
    {
        // Ensure staff can only view complaints assigned to them
        if ($complaint->assigned_to !== auth()->id()) {
            abort(403, 'You can only view complaints assigned to you.');
        }

        $complaint->load(['category', 'creator', 'assignee', 'logs.user']);

        return view('staff.complaints.show', compact('complaint'));
    }

    public function updateStatus(UpdateComplaintStatusRequest $request, Complaint $complaint)
    {
        if ($complaint->assigned_to !== auth()->id()) {
            abort(403);
        }

        $from = $complaint->status;
        $to = $request->input('status');

        if ($from === 'pending' && $to !== 'in_progress') {
            abort(403, 'Staff can only move pending complaints to in progress.');
        }
        if ($from === 'in_progress' && $to !== 'resolved') {
            abort(403, 'Staff can only move in progress complaints to resolved.');
        }
        if (in_array($from, ['resolved', 'rejected', 'withdrawn'])) {
            abort(403, 'This complaint is no longer active.');
        }

        $complaint->update([
            'status' => $to,
            'resolved_at' => $to === 'resolved' ? now() : null,
        ]);

        ComplaintLog::create([
            'complaint_id' => $complaint->id,
            'user_id' => auth()->id(),
            'action' => 'status_changed',
            'message' => $request->input('message'),
            'meta' => ['from' => $from, 'to' => $complaint->status],
        ]);

        if ($complaint->creator) {
            $complaint->creator->notify(new ComplaintStatusUpdated($complaint));
        }

        return back()->with('success', 'Status updated.');
    }

    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|string',
            'ids' => 'required|array',
            'ids.*' => 'integer|exists:complaints,id',
        ]);

        $action = $request->input('action');
        $ids = $request->input('ids');

        // Staff can only modify complaints assigned to them
        $complaints = Complaint::whereIn('id', $ids)
            ->where('assigned_to', auth()->id())
            ->get();

        $updatedCount = 0;
        $skippedCount = 0;

        foreach ($complaints as $complaint) {
            $from = $complaint->status;
            
            // Apply staff state machine rules
            if ($action === 'in_progress' && $from === 'pending') {
                $complaint->update(['status' => 'in_progress']);
            } elseif ($action === 'resolved' && $from === 'in_progress') {
                $complaint->update(['status' => 'resolved', 'resolved_at' => now()]);
            } else {
                $skippedCount++;
                continue;
            }

            ComplaintLog::create([
                'complaint_id' => $complaint->id,
                'user_id' => auth()->id(),
                'action' => 'status_changed',
                'message' => 'Status updated via bulk action',
                'meta' => ['from' => $from, 'to' => $action],
            ]);

            if ($complaint->creator) {
                $complaint->creator->notify(new ComplaintStatusUpdated($complaint));
            }
            $updatedCount++;
        }

        $message = "$updatedCount complaints updated successfully.";
        if ($skippedCount > 0) {
            $message .= " $skippedCount complaints skipped due to invalid state transitions.";
        }

        return back()->with($skippedCount > 0 && $updatedCount == 0 ? 'error' : 'success', $message);
    }
}
