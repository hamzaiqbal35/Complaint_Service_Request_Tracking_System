<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateComplaintStatusRequest;
use App\Models\Complaint;
use App\Models\ComplaintLog;

class StaffComplaintController extends Controller
{
    public function index()
    {
        $complaints = Complaint::with('category','creator')
            ->where('assigned_to', auth()->id())
            ->latest()->paginate(15);
        return view('staff.complaints.index', compact('complaints'));
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


