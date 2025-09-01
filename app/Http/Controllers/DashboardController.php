<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $query = Complaint::with('category', 'assignee')
            ->where('created_by', auth()->id());

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

        // Apply sorting with whitelist and safe fallbacks
        $allowedSorts = ['id', 'created_at', 'title', 'priority', 'status'];
        $requestedSortBy = $request->get('sort_by');
        $sortBy = in_array($requestedSortBy, $allowedSorts, true) && !empty($requestedSortBy)
            ? $requestedSortBy
            : 'created_at';
        $sortOrder = $request->get('sort_order') === 'asc' ? 'asc' : 'desc';
        $query->orderBy($sortBy, $sortOrder);

        $complaints = $query->paginate(10)->withQueryString();

        // Get filtered statistics
        $baseQuery = Complaint::where('created_by', auth()->id());
        
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
            'total' => (clone $baseQuery)->count(),
            'pending' => (clone $baseQuery)->where('status', 'pending')->count(),
            'in_progress' => (clone $baseQuery)->where('status', 'in_progress')->count(),
            'resolved' => (clone $baseQuery)->where('status', 'resolved')->count(),
            'rejected' => (clone $baseQuery)->where('status', 'rejected')->count(),
        ];

        $categories = Category::all();

        return view('dashboard', compact('complaints', 'stats', 'categories'));
    }

    public function export(Request $request)
    {
        $query = Complaint::with('category', 'assignee', 'creator')
            ->where('created_by', auth()->id());

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

        // Apply sorting consistent with index
        $allowedSorts = ['id', 'created_at', 'title', 'priority', 'status'];
        $requestedSortBy = $request->get('sort_by');
        $sortBy = in_array($requestedSortBy, $allowedSorts, true) && !empty($requestedSortBy)
            ? $requestedSortBy
            : 'created_at';
        $sortOrder = $request->get('sort_order') === 'asc' ? 'asc' : 'desc';
        $query->orderBy($sortBy, $sortOrder);

        $complaints = $query->get();

        $filename = 'complaints_export_' . date('Y-m-d_H-i-s') . '.csv';
        
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
                'Assigned To',
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
                    $complaint->assignee->name ?? 'Unassigned',
                    $complaint->created_at->format('Y-m-d H:i:s'),
                    $complaint->updated_at->format('Y-m-d H:i:s')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
