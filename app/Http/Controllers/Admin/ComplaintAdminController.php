<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AssignComplaintRequest;
use App\Http\Requests\UpdateComplaintStatusRequest;
use App\Models\Complaint;
use App\Models\ComplaintLog;
use App\Models\User;

class ComplaintAdminController extends Controller
{
    public function index()
    {
        $complaints = Complaint::with('category','creator','assignee')->latest()->paginate(15);
        return view('admin.complaints.index', compact('complaints'));
    }

    public function edit(Complaint $complaint)
    {
        $staff = User::where('role','staff')->orderBy('name')->get();
        return view('admin.complaints.edit', compact('complaint','staff'));
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

        return back()->with('success', 'Status updated.');
    }
}


