<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Models\Category;
use Illuminate\Http\Request;

class StaffDashboardController extends Controller
{
    public function index(Request $request)
    {
        $query = Complaint::with('category', 'assignee', 'creator')
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

        $complaints = $query->paginate(10)->withQueryString();

        // Get filtered statistics for assigned complaints
        $baseQuery = Complaint::where('assigned_to', auth()->id());
        
        if ($request->filled('status')) {
            $baseQuery->where('status', $request->status);
        }
        if ($request->filled('priority')) {
            $baseQuery->where('priority', $request->priority);
        }
        if ($request->filled('category_id')) {
            $baseQuery->where('category_id', $request->category_id);
        }
        if ($request->filled('date_from')) {
            $baseQuery->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $baseQuery->whereDate('created_at', '<=', $request->date_to);
        }

        $stats = [
            'total_assigned' => (clone $baseQuery)->count(),
            'pending' => (clone $baseQuery)->where('status', 'pending')->count(),
            'in_progress' => (clone $baseQuery)->where('status', 'in_progress')->count(),
            'resolved' => (clone $baseQuery)->where('status', 'resolved')->count(),
            'rejected' => (clone $baseQuery)->where('status', 'rejected')->count(),
        ];

        // Additional stats for staff dashboard
        $additionalStats = [
            'total_complaints' => Complaint::count(),
            'unassigned_complaints' => Complaint::whereNull('assigned_to')->count(),
            'my_resolution_rate' => $stats['total_assigned'] > 0 ? round(($stats['resolved'] / $stats['total_assigned']) * 100) : 0,
            'avg_response_time' => $this->getAverageResponseTime(),
        ];

        $categories = Category::all();

        return view('staff.dashboard', compact('complaints', 'stats', 'additionalStats', 'categories'));
    }

    public function export(Request $request)
    {
        $query = Complaint::with('category', 'assignee', 'creator')
            ->where('assigned_to', auth()->id());

        // Apply same filters as dashboard
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

        $complaints = $query->get();

        $filename = 'staff_complaints_export_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($complaints) {
            $file = fopen('php://output', 'w');
            
            // Add CSV headers
            fputcsv($file, [
                'ID',
                'Title',
                'Description',
                'Category',
                'Priority',
                'Status',
                'Created By',
                'Created At',
                'Updated At'
            ]);

            // Add data rows
            foreach ($complaints as $complaint) {
                fputcsv($file, [
                    $complaint->id,
                    $complaint->title,
                    $complaint->description,
                    $complaint->category->name ?? 'N/A',
                    ucfirst($complaint->priority),
                    ucfirst(str_replace('_', ' ', $complaint->status)),
                    $complaint->creator->name ?? 'N/A',
                    $complaint->created_at->format('Y-m-d H:i:s'),
                    $complaint->updated_at->format('Y-m-d H:i:s')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    private function getAverageResponseTime()
    {
        $resolvedComplaints = Complaint::where('assigned_to', auth()->id())
            ->where('status', 'resolved')
            ->whereNotNull('resolved_at')
            ->get();

        if ($resolvedComplaints->isEmpty()) {
            return 0;
        }

        $totalHours = 0;
        foreach ($resolvedComplaints as $complaint) {
            $totalHours += $complaint->created_at->diffInHours($complaint->resolved_at);
        }

        return round($totalHours / $resolvedComplaints->count(), 1);
    }
}
