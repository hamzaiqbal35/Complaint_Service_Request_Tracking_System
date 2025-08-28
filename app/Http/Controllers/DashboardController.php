<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $complaints = Complaint::with('category', 'assignee')
            ->where('created_by', auth()->id())
            ->latest()
            ->paginate(10);

        // Get statistics for the user
        $stats = [
            'total' => Complaint::where('created_by', auth()->id())->count(),
            'pending' => Complaint::where('created_by', auth()->id())->where('status', 'pending')->count(),
            'in_progress' => Complaint::where('created_by', auth()->id())->where('status', 'in_progress')->count(),
            'resolved' => Complaint::where('created_by', auth()->id())->where('status', 'resolved')->count(),
            'rejected' => Complaint::where('created_by', auth()->id())->where('status', 'rejected')->count(),
        ];

        return view('dashboard', compact('complaints', 'stats'));
    }
}
