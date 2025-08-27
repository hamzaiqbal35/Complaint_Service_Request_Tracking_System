<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreComplaintRequest;
use App\Models\Category;
use App\Models\Complaint;
use App\Models\ComplaintLog;

class ComplaintController extends Controller
{
    public function index()
    {
        $complaints = Complaint::with('category','assignee')
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

        return redirect()->route('complaints.index')->with('success', 'Complaint submitted.');
    }

    public function show(Complaint $complaint)
    {
        $this->authorizeView($complaint);
        $complaint->load('logs.user','category','assignee');
        return view('complaints.show', compact('complaint'));
    }

    protected function authorizeView(Complaint $complaint): void
    {
        if ($complaint->created_by !== auth()->id() && !auth()->user()->isAdmin()) abort(403);
    }
}


