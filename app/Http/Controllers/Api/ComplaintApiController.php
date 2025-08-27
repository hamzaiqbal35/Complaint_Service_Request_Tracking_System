<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use Illuminate\Http\Request;

class ComplaintApiController extends Controller
{
    public function index(Request $request)
    {
        $query = Complaint::with('category','creator','assignee');

        if ($request->user()->role === 'user') {
            $query->where('created_by', $request->user()->id);
        } elseif ($request->user()->role === 'staff') {
            $query->where('assigned_to', $request->user()->id);
        }

        return $query->latest()->paginate(20);
    }

    public function show(Complaint $complaint, Request $request)
    {
        $complaint->load('logs.user','category','assignee');
        if ($request->user()->role === 'user' && $complaint->created_by !== $request->user()->id) {
            abort(403);
        }
        if ($request->user()->role === 'staff' && $complaint->assigned_to !== $request->user()->id) {
            abort(403);
        }
        return $complaint;
    }
}


