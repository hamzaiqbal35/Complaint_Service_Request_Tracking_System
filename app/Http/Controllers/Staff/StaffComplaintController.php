<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateComplaintStatusRequest;
use App\Models\Complaint;
use App\Models\ComplaintLog;
use App\Models\Category;
use Illuminate\Http\Request;

class StaffComplaintController extends Controller
{
    public function index(Request $request)
    {
        $query = Complaint::with('category','creator')
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

        // Apply sorting
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
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
        if ($complaint->assigned_to !== auth()->id()) abort(403);

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

        return back()->with('success', 'Status updated.');
    }
}


