<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Category;
use App\Models\Complaint;
use Carbon\Carbon;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Get all categories and staff for filters
        $categories = Category::orderBy('name')->get();
        $staffMembers = User::where('role', 'staff')->orderBy('name')->get();

        // Basic statistics
        $stats = [
            'total' => Complaint::count(),
            'pending' => Complaint::where('status', 'pending')->count(),
            'in_progress' => Complaint::where('status', 'in_progress')->count(),
            'resolved' => Complaint::where('status', 'resolved')->count(),
            'rejected' => Complaint::where('status', 'rejected')->count(),
            'unassigned' => Complaint::whereNull('assigned_to')->count()
        ];

        // Additional statistics
        $additionalStats = [
            'total_users' => User::where('role', 'user')->count(),
            'total_staff' => User::where('role', 'staff')->count(),
            'total_categories' => Category::count(),
            'high_priority_pending' => Complaint::where('priority', 'high')
                                              ->where('status', 'pending')
                                              ->count(),
            'avg_resolution_time' => $this->calculateAverageResolutionTime()
        ];

        // Recent complaints with relationships
        $complaints = Complaint::with(['category', 'creator', 'assignee'])
                            ->orderBy('created_at', 'desc')
                            ->paginate(10);

        return view('admin.dashboard', compact(
            'categories',
            'staffMembers',
            'stats',
            'additionalStats',
            'complaints'
        ));
    }

    private function calculateAverageResolutionTime()
    {
        $resolvedComplaints = Complaint::where('status', 'resolved')
            ->whereNotNull('resolved_at')
            ->get();

        if ($resolvedComplaints->isEmpty()) {
            return 0;
        }

        $totalHours = $resolvedComplaints->sum(function ($complaint) {
            $created = Carbon::parse($complaint->created_at);
            $resolved = Carbon::parse($complaint->resolved_at);
            return $created->diffInHours($resolved);
        });

        return round($totalHours / $resolvedComplaints->count(), 1);
    }

    public function export(Request $request)
    {
        $complaints = Complaint::with(['category', 'creator', 'assignee'])
            ->orderBy('created_at', 'desc')
            ->get();

        $csvFileName = 'complaints_' . date('Y-m-d_H-i-s') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $csvFileName . '"',
        ];

        $handle = fopen('php://temp', 'r+');
        
        // Add CSV headers
        fputcsv($handle, [
            'ID',
            'Title',
            'Category',
            'Priority',
            'Status',
            'Created By',
            'Assigned To',
            'Created At',
            'Updated At'
        ]);

        // Add data rows
        foreach ($complaints as $complaint) {
            fputcsv($handle, [
                $complaint->id,
                $complaint->title,
                $complaint->category->name ?? 'N/A',
                ucfirst($complaint->priority),
                ucfirst(str_replace('_', ' ', $complaint->status)),
                $complaint->creator->name ?? 'N/A',
                $complaint->assignee->name ?? 'Unassigned',
                $complaint->created_at->format('Y-m-d H:i:s'),
                $complaint->updated_at->format('Y-m-d H:i:s')
            ]);
        }

        rewind($handle);
        $content = stream_get_contents($handle);
        fclose($handle);

        return Response::make($content, 200, $headers);
    }
}