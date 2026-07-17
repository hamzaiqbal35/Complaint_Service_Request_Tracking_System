<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Complaint;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index(Request $request)
    {
        // Get all categories and staff for filters
        $categories = Category::orderBy('name')->get();
        $staffMembers = User::where('role', 'staff')->orderBy('name')->get();

        // Base query for statistics
        $baseQuery = Complaint::query();

        // Apply filters to base query
        $this->applyFilters($baseQuery, $request);

        // Basic statistics with filters applied
        $stats = [
            'total' => (clone $baseQuery)->count(),
            'pending' => (clone $baseQuery)->where('status', 'pending')->count(),
            'in_progress' => (clone $baseQuery)->where('status', 'in_progress')->count(),
            'resolved' => (clone $baseQuery)->where('status', 'resolved')->count(),
            'rejected' => (clone $baseQuery)->where('status', 'rejected')->count(),
            'withdrawn' => (clone $baseQuery)->where('status', 'withdrawn')->count(),
            'unassigned' => (clone $baseQuery)->whereNull('assigned_to')->count(),
        ];

        // Chart Data
        $chartData = [
            'pie' => [
                'pending' => $stats['pending'],
                'in_progress' => $stats['in_progress'],
                'resolved' => $stats['resolved'],
                'rejected' => $stats['rejected'],
                'withdrawn' => $stats['withdrawn'],
            ],
            'line' => [
                'labels' => [],
                'data' => []
            ]
        ];

        $thirtyDaysAgo = \Carbon\Carbon::now()->subDays(29)->startOfDay();
        $dailyCounts = (clone $baseQuery)
            ->where('created_at', '>=', $thirtyDaysAgo)
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->pluck('count', 'date');

        for ($i = 29; $i >= 0; $i--) {
            $date = \Carbon\Carbon::now()->subDays($i)->format('Y-m-d');
            $chartData['line']['labels'][] = \Carbon\Carbon::now()->subDays($i)->format('M d');
            $chartData['line']['data'][] = $dailyCounts->get($date, 0);
        }

        // Additional statistics
        $additionalStats = [
            'total_users' => User::where('role', 'user')->count(),
            'total_staff' => User::where('role', 'staff')->count(),
            'total_categories' => Category::count(),
            'high_priority_pending' => (clone $baseQuery)
                ->where('priority', 'high')
                ->where('status', 'pending')
                ->count(),
            'avg_resolution_time' => $this->calculateAverageResolutionTime(),
            'resolution_rate' => $stats['total'] > 0 ? round(($stats['resolved'] / $stats['total']) * 100) : 0,
        ];

        // Query for complaints with filters and relationships
        $complaintsQuery = Complaint::with(['category', 'creator', 'assignee']);

        // Apply same filters to complaints query
        $this->applyFilters($complaintsQuery, $request);

        // Apply sorting
        $sortBy = $request->input('sort_by', 'created_at');
        $sortOrder = $request->input('sort_order', 'desc');

        $complaints = $complaintsQuery->orderBy($sortBy, $sortOrder)
            ->paginate(10)
            ->appends($request->query());

        return view('admin.dashboard', compact(
            'categories',
            'staffMembers',
            'stats',
            'additionalStats',
            'complaints',
            'chartData'
        ));
    }

    /**
     * Apply filters to the query
     */
    private function applyFilters($query, $request)
    {
        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Priority filter
        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        // Category filter
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Assigned to filter
        if ($request->filled('assigned_to')) {
            if ($request->assigned_to === 'unassigned') {
                $query->whereNull('assigned_to');
            } else {
                $query->where('assigned_to', $request->assigned_to);
            }
        }

        // Date range filter
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
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
        // Build the same base query used on the dashboard list
        $complaintsQuery = Complaint::with(['category', 'creator', 'assignee']);

        // Reuse the exact same filters
        $this->applyFilters($complaintsQuery, $request);

        // Respect current sorting
        $sortBy = $request->input('sort_by', 'created_at');
        $sortOrder = $request->input('sort_order', 'desc');

        $complaints = $complaintsQuery->orderBy($sortBy, $sortOrder)->get();

        $csvFileName = 'complaints_'.date('Y-m-d_H-i-s').'.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="'.$csvFileName.'"',
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
            'Updated At',
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
                $complaint->created_at,
                $complaint->updated_at,
            ]);
        }

        rewind($handle);
        $csv = stream_get_contents($handle);
        fclose($handle);

        return response($csv, 200, $headers);
    }
}
