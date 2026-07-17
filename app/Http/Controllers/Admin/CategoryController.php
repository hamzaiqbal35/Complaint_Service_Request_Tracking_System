<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Category::withCount([
            'complaints',
            'complaints as unresolved_count' => function ($query) {
                $query->whereNotIn('status', ['resolved', 'rejected']);
            },
        ]);

        // Apply filters
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Apply sorting (whitelist columns)
        $allowedSorts = ['created_at', 'name', 'complaints_count'];
        $sortBy = in_array($request->get('sort_by', 'created_at'), $allowedSorts, true)
            ? $request->get('sort_by', 'created_at')
            : 'created_at';
        $sortOrder = $request->get('sort_order', 'desc') === 'asc' ? 'asc' : 'desc';
        $query->orderBy($sortBy, $sortOrder);

        // Clone the query for statistics before pagination
        $statsQuery = clone $query;

        $categories = $query->paginate(15)->withQueryString();

        // Get statistics based on the filtered query
        $filteredCategories = $statsQuery->get();
        $stats = [
            'total' => $filteredCategories->count(),
            'with_complaints' => $filteredCategories->where('complaints_count', '>', 0)->count(),
            'without_complaints' => $filteredCategories->where('complaints_count', '==', 0)->count(),
            'total_complaints' => $filteredCategories->sum('complaints_count'),
        ];

        return view('admin.categories.index', compact('categories', 'stats'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:categories'],
            'description' => ['nullable', 'string', 'max:500'],
        ]);

        Category::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category created successfully.');
    }

    public function show(Category $category)
    {
        $category->load(['complaints' => function ($query) {
            $query->with('creator', 'assignee')->latest()->limit(10);
        }]);

        $complaintsCount = $category->complaints()->count();
        $pendingCount = $category->complaints()->where('status', 'pending')->count();
        $resolvedCount = $category->complaints()->where('status', 'resolved')->count();

        return view('admin.categories.show', compact('category', 'complaintsCount', 'pendingCount', 'resolvedCount'));
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('categories')->ignore($category->id)],
            'description' => ['nullable', 'string', 'max:500'],
        ]);

        $category->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category)
    {
        $unresolvedCount = $category->complaints()->whereNotIn('status', ['resolved', 'rejected'])->count();

        if ($unresolvedCount > 0) {
            return redirect()->route('admin.categories.index')
                ->with('error', 'Cannot delete category with unresolved complaints.');
        }

        // Delete all associated complaints first due to restrictOnDelete
        $category->complaints()->delete();
        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category and its resolved/rejected complaints deleted successfully.');
    }

    public function export(Request $request)
    {
        $query = Category::withCount([
            'complaints',
            'complaints as unresolved_count' => function ($query) {
                $query->whereNotIn('status', ['resolved', 'rejected']);
            },
        ]);

        // Apply same filters as index
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Apply same sorting as index
        $allowedSorts = ['created_at', 'name', 'complaints_count'];
        $sortBy = in_array($request->get('sort_by', 'created_at'), $allowedSorts, true)
            ? $request->get('sort_by', 'created_at')
            : 'created_at';
        $sortOrder = $request->get('sort_order', 'desc') === 'asc' ? 'asc' : 'desc';
        $query->orderBy($sortBy, $sortOrder);

        $categories = $query->get();

        $filename = 'categories_export_'.date('Y-m-d_H-i-s').'.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="'.$filename.'"',
        ];

        $callback = function () use ($categories) {
            $file = fopen('php://output', 'w');

            // Add CSV headers
            fputcsv($file, [
                'ID',
                'Name',
                'Description',
                'Total Complaints',
                'Created At',
                'Updated At',
            ]);

            // Add data rows
            foreach ($categories as $category) {
                fputcsv($file, [
                    $category->id,
                    $category->name,
                    $category->description ?? 'N/A',
                    $category->complaints_count,
                    $category->created_at->format('Y-m-d H:i:s'),
                    $category->updated_at->format('Y-m-d H:i:s'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|string',
            'ids' => 'required|array',
            'ids.*' => 'integer|exists:categories,id',
        ]);

        $action = $request->input('action');
        $ids = $request->input('ids');

        if ($action === 'delete') {
            $categories = Category::with('complaints')->whereIn('id', $ids)->get();
            $deletedCount = 0;
            $skippedCount = 0;

            foreach ($categories as $category) {
                $unresolvedCount = $category->complaints()->whereNotIn('status', ['resolved', 'rejected'])->count();
                if ($unresolvedCount > 0) {
                    $skippedCount++;
                    continue;
                }
                $category->complaints()->delete();
                $category->delete();
                $deletedCount++;
            }

            $message = "$deletedCount categories deleted successfully.";
            if ($skippedCount > 0) {
                $message .= " $skippedCount categories skipped due to unresolved complaints.";
            }

            return back()->with($skippedCount > 0 && $deletedCount == 0 ? 'error' : 'success', $message);
        }

        return back()->with('error', 'Invalid action selected.');
    }
}
