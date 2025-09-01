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
        $query = Category::withCount('complaints');

        // Apply filters
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Apply sorting
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
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
        $category->load(['complaints' => function($query) {
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
        // Check if category has complaints
        if ($category->complaints()->exists()) {
            return redirect()->route('admin.categories.index')
                ->with('error', 'Cannot delete category with associated complaints.');
        }

        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category deleted successfully.');
    }

    public function export(Request $request)
    {
        $query = Category::withCount('complaints');

        // Apply same filters as index
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $categories = $query->get();

        $filename = 'categories_export_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($categories) {
            $file = fopen('php://output', 'w');
            
            // Add CSV headers
            fputcsv($file, [
                'ID',
                'Name',
                'Description',
                'Total Complaints',
                'Created At',
                'Updated At'
            ]);

            // Add data rows
            foreach ($categories as $category) {
                fputcsv($file, [
                    $category->id,
                    $category->name,
                    $category->description ?? 'N/A',
                    $category->complaints_count,
                    $category->created_at->format('Y-m-d H:i:s'),
                    $category->updated_at->format('Y-m-d H:i:s')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
