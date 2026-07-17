<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreComplaintRequest;
use App\Models\Category;
use App\Models\Complaint;
use App\Models\ComplaintLog;
use App\Models\User;
use App\Notifications\ComplaintWithdrawn;
use App\Notifications\NewComplaintCreated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class ComplaintController extends Controller
{
    public function index()
    {
        $complaints = Complaint::with('category', 'assignee')
            ->where('created_by', auth()->id())
            ->latest()->paginate(10);

        return view('complaints.index', compact('complaints'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();

        return view('complaints.create', compact('categories'));
    }

    public function store(StoreComplaintRequest $request)
    {
        $complaint = Complaint::create([
            ...$request->validated(),
            'created_by' => auth()->id(),
            'status' => 'pending',
        ]);

        ComplaintLog::create([
            'complaint_id' => $complaint->id,
            'user_id' => auth()->id(),
            'action' => 'created',
            'message' => 'Complaint created',
        ]);

        $admins = User::where('role', 'admin')->get();
        Notification::send($admins, new NewComplaintCreated($complaint));

        return redirect()->route('complaints.index')->with('success', 'Complaint submitted.');
    }

    public function show(Complaint $complaint)
    {
        $this->authorizeView($complaint);
        $complaint->load('logs.user', 'category', 'assignee');

        return view('complaints.show', compact('complaint'));
    }

    public function update(Request $request, Complaint $complaint)
    {
        $this->authorizeView($complaint);

        $validated = $request->validate([
            'status' => 'sometimes|in:withdrawn',
        ]);

        if ($request->has('status') && $request->input('status') === 'withdrawn') {
            if ($complaint->status !== 'pending') {
                abort(403, 'You can only withdraw a pending complaint.');
            }

            $complaint->update(['status' => 'withdrawn']);

            ComplaintLog::create([
                'complaint_id' => $complaint->id,
                'user_id' => auth()->id(),
                'action' => 'withdrawn',
                'message' => 'Complaint withdrawn by user',
                'meta' => ['from' => 'pending', 'to' => 'withdrawn'],
            ]);

            $admins = User::where('role', 'admin')->get();
            Notification::send($admins, new ComplaintWithdrawn($complaint));

            if ($complaint->assignee) {
                $complaint->assignee->notify(new ComplaintWithdrawn($complaint));
            }

            return back()->with('success', 'Complaint withdrawn successfully.');
        }

        return redirect()->route('complaints.index')->with('success', 'Complaint updated.');
    }

    protected function authorizeView(Complaint $complaint): void
    {
        if ($complaint->created_by !== auth()->id() && ! auth()->user()->isAdmin()) {
            abort(403);
        }
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

        if ($action === 'withdraw') {
            $complaints = Complaint::whereIn('id', $ids)
                ->where('created_by', auth()->id())
                ->get();

            $withdrawnCount = 0;
            $skippedCount = 0;

            foreach ($complaints as $complaint) {
                if ($complaint->status !== 'pending') {
                    $skippedCount++;
                    continue;
                }

                $complaint->update(['status' => 'withdrawn']);

                ComplaintLog::create([
                    'complaint_id' => $complaint->id,
                    'user_id' => auth()->id(),
                    'action' => 'withdrawn',
                    'message' => 'Complaint withdrawn via bulk action',
                    'meta' => ['from' => 'pending', 'to' => 'withdrawn'],
                ]);

                $admins = User::where('role', 'admin')->get();
                Notification::send($admins, new ComplaintWithdrawn($complaint));

                if ($complaint->assignee) {
                    $complaint->assignee->notify(new ComplaintWithdrawn($complaint));
                }

                $withdrawnCount++;
            }

            $message = "$withdrawnCount complaints withdrawn successfully.";
            if ($skippedCount > 0) {
                $message .= " $skippedCount complaints skipped (only pending complaints can be withdrawn).";
            }

            return back()->with($skippedCount > 0 && $withdrawnCount == 0 ? 'error' : 'success', $message);
        }

        return back()->with('error', 'Invalid action selected.');
    }
}
