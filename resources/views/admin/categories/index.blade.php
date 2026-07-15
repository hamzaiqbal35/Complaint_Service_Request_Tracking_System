@extends('layouts.admin')

@section('content')
<div x-data="{ 
    filterOpen: {{ request()->hasAny(['search', 'sort_by', 'sort_order']) ? 'true' : 'false' }},
    deleteModalOpen: false,
    categoryToDelete: null,
    categoryNameToDelete: '',
    confirmDelete(id, name) {
        this.categoryToDelete = id;
        this.categoryNameToDelete = name;
        this.deleteModalOpen = true;
        document.getElementById('deleteForm').action = '/admin/categories/' + id;
    }
}">

    <!-- Page Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            <h1 class="text-3xl font-black text-slate-800 tracking-tight">Category Management</h1>
            <p class="text-slate-500 mt-1">Organize and manage complaint categories.</p>
        </div>
        <div class="flex flex-wrap items-center gap-3 w-full md:w-auto">
            <button @click="filterOpen = !filterOpen" class="flex-1 md:flex-none flex items-center justify-center gap-2 px-4 py-2.5 bg-white border border-slate-200 text-slate-700 rounded-xl hover:bg-slate-50 hover:border-teal-300 transition-all font-medium shadow-sm">
                <i class="fas fa-filter text-slate-400"></i> Filters
            </button>
            <a href="{{ route('admin.categories.export', request()->query()) }}" class="flex-1 md:flex-none flex items-center justify-center gap-2 px-4 py-2.5 bg-white border border-slate-200 text-slate-700 rounded-xl hover:bg-slate-50 hover:border-teal-300 transition-all font-medium shadow-sm">
                <i class="fas fa-file-export text-slate-400"></i> Export
            </a>
            <a href="{{ route('admin.categories.create') }}" class="flex-1 md:flex-none flex items-center justify-center gap-2 px-5 py-2.5 bg-gradient-to-r from-teal-500 to-emerald-500 hover:from-teal-600 hover:to-emerald-600 text-white rounded-xl transition-all shadow-[0_8px_20px_-6px_rgba(16,185,129,0.4)] font-medium">
                <i class="fas fa-plus"></i> Add Category
            </a>
        </div>
    </div>

    <!-- Filter Panel -->
    <div x-show="filterOpen" x-collapse x-cloak class="mb-8">
        <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
            <form method="GET" action="{{ route('admin.categories.index') }}">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Search -->
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Search</label>
                        <input type="text" name="search" placeholder="Name or Description" value="{{ request('search') }}" class="w-full bg-slate-50 border border-slate-200 text-slate-700 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 outline-none transition-all">
                    </div>
                    <!-- Sort By -->
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Sort By</label>
                        <select name="sort_by" class="w-full bg-slate-50 border border-slate-200 text-slate-700 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 outline-none transition-all appearance-none">
                            <option value="created_at" {{ request('sort_by') == 'created_at' ? 'selected' : '' }}>Created Date</option>
                            <option value="name" {{ request('sort_by') == 'name' ? 'selected' : '' }}>Name</option>
                            <option value="complaints_count" {{ request('sort_by') == 'complaints_count' ? 'selected' : '' }}>Complaints Count</option>
                        </select>
                    </div>
                    <!-- Sort Order -->
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Sort Order</label>
                        <select name="sort_order" class="w-full bg-slate-50 border border-slate-200 text-slate-700 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 outline-none transition-all appearance-none">
                            <option value="desc" {{ request('sort_order') == 'desc' ? 'selected' : '' }}>Descending</option>
                            <option value="asc" {{ request('sort_order') == 'asc' ? 'selected' : '' }}>Ascending</option>
                        </select>
                    </div>
                </div>
                
                <div class="flex items-center gap-3 mt-6 border-t border-slate-100 pt-6">
                    <button type="submit" class="px-6 py-2.5 bg-slate-800 hover:bg-slate-900 text-white rounded-xl transition-all shadow-md font-medium">
                        Apply Filters
                    </button>
                    <a href="{{ route('admin.categories.index') }}" class="px-6 py-2.5 bg-white border border-slate-200 hover:bg-slate-50 text-slate-600 rounded-xl transition-all font-medium">
                        Clear
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 flex items-center justify-between group hover:shadow-md transition-all relative overflow-hidden">
            <div class="absolute right-[-10%] top-[-10%] w-24 h-24 bg-blue-500/5 rounded-full blur-2xl group-hover:bg-blue-500/10 transition-colors"></div>
            <div class="relative z-10">
                <p class="text-sm font-bold text-slate-400 uppercase tracking-wider mb-1">Total Categories</p>
                <p class="text-3xl font-black text-slate-800">{{ $stats['total'] }}</p>
            </div>
            <div class="relative z-10 w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center text-blue-500 border border-blue-100 group-hover:scale-110 transition-transform">
                <i class="fas fa-tags text-xl"></i>
            </div>
        </div>
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 flex items-center justify-between group hover:shadow-md transition-all relative overflow-hidden">
            <div class="absolute right-[-10%] top-[-10%] w-24 h-24 bg-emerald-500/5 rounded-full blur-2xl group-hover:bg-emerald-500/10 transition-colors"></div>
            <div class="relative z-10">
                <p class="text-sm font-bold text-slate-400 uppercase tracking-wider mb-1">With Complaints</p>
                <p class="text-3xl font-black text-slate-800">{{ $stats['with_complaints'] }}</p>
            </div>
            <div class="relative z-10 w-12 h-12 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-500 border border-emerald-100 group-hover:scale-110 transition-transform">
                <i class="fas fa-check-circle text-xl"></i>
            </div>
        </div>
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 flex items-center justify-between group hover:shadow-md transition-all relative overflow-hidden">
            <div class="absolute right-[-10%] top-[-10%] w-24 h-24 bg-amber-500/5 rounded-full blur-2xl group-hover:bg-amber-500/10 transition-colors"></div>
            <div class="relative z-10">
                <p class="text-sm font-bold text-slate-400 uppercase tracking-wider mb-1">Without Complaints</p>
                <p class="text-3xl font-black text-slate-800">{{ $stats['without_complaints'] }}</p>
            </div>
            <div class="relative z-10 w-12 h-12 rounded-xl bg-amber-50 flex items-center justify-center text-amber-500 border border-amber-100 group-hover:scale-110 transition-transform">
                <i class="fas fa-exclamation-circle text-xl"></i>
            </div>
        </div>
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 flex items-center justify-between group hover:shadow-md transition-all relative overflow-hidden">
            <div class="absolute right-[-10%] top-[-10%] w-24 h-24 bg-teal-500/5 rounded-full blur-2xl group-hover:bg-teal-500/10 transition-colors"></div>
            <div class="relative z-10">
                <p class="text-sm font-bold text-slate-400 uppercase tracking-wider mb-1">Total Complaints</p>
                <p class="text-3xl font-black text-slate-800">{{ $stats['total_complaints'] }}</p>
            </div>
            <div class="relative z-10 w-12 h-12 rounded-xl bg-teal-50 flex items-center justify-center text-teal-500 border border-teal-100 group-hover:scale-110 transition-transform">
                <i class="fas fa-clipboard-list text-xl"></i>
            </div>
        </div>
    </div>

    <!-- Data Table -->
    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider border-b border-slate-100">Category</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider border-b border-slate-100">Description</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider border-b border-slate-100">Complaints</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider border-b border-slate-100">Created At</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider border-b border-slate-100 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($categories as $category)
                        <tr class="hover:bg-slate-50/80 transition-colors group">
                            <td class="px-6 py-4">
                                <div class="flex flex-col">
                                    <span class="text-sm font-bold text-slate-800 group-hover:text-teal-600 transition-colors">{{ $category->name }}</span>
                                    <span class="text-xs text-slate-400 mt-0.5">ID: #{{ $category->id }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-sm text-slate-500 max-w-xs truncate" title="{{ $category->description }}">
                                    {{ Str::limit($category->description ?? 'No description', 50) }}
                                </p>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold border {{ $category->complaints_count > 0 ? 'bg-emerald-50 text-emerald-600 border-emerald-200' : 'bg-slate-100 text-slate-500 border-slate-200' }}">
                                    {{ $category->complaints_count }} Tickets
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm text-slate-500 font-medium">{{ $category->created_at->format('M d, Y') }}</span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.categories.show', $category) }}" class="w-8 h-8 rounded-lg bg-white border border-slate-200 flex items-center justify-center text-slate-400 hover:text-teal-600 hover:border-teal-200 hover:bg-teal-50 transition-all shadow-sm" title="View">
                                        <i class="fas fa-eye text-sm"></i>
                                    </a>
                                    <a href="{{ route('admin.categories.edit', $category) }}" class="w-8 h-8 rounded-lg bg-white border border-slate-200 flex items-center justify-center text-slate-400 hover:text-blue-600 hover:border-blue-200 hover:bg-blue-50 transition-all shadow-sm" title="Edit">
                                        <i class="fas fa-edit text-sm"></i>
                                    </a>
                                    
                                    @if($category->unresolved_count == 0)
                                        <button type="button" @click="confirmDelete({{ $category->id }}, '{{ addslashes($category->name) }}')" class="w-8 h-8 rounded-lg bg-white border border-slate-200 flex items-center justify-center text-slate-400 hover:text-rose-600 hover:border-rose-200 hover:bg-rose-50 transition-all shadow-sm" title="Delete">
                                            <i class="fas fa-trash-alt text-sm"></i>
                                        </button>
                                    @else
                                        <button type="button" disabled class="w-8 h-8 rounded-lg bg-slate-50 border border-slate-200 flex items-center justify-center text-slate-300 cursor-not-allowed" title="Cannot delete - has unresolved complaints">
                                            <i class="fas fa-ban text-sm"></i>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center text-slate-400">
                                    <i class="fas fa-tags text-4xl mb-3 text-slate-300"></i>
                                    <p class="text-sm font-medium">No categories found.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="p-6 border-t border-slate-100 flex justify-center">
            {{ $categories->links('pagination::tailwind') }}
        </div>
    </div>

    <!-- Delete Modal -->
    <div x-show="deleteModalOpen" x-cloak class="fixed inset-0 z-[100] flex items-center justify-center overflow-y-auto overflow-x-hidden bg-slate-900/50 backdrop-blur-sm p-4 text-center sm:p-0">
        <div x-show="deleteModalOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="relative overflow-hidden rounded-2xl bg-white text-left shadow-xl sm:my-8 sm:w-full sm:max-w-lg border border-slate-100" @click.away="deleteModalOpen = false">
            <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-rose-100 sm:mx-0 sm:h-10 sm:w-10">
                        <i class="fas fa-exclamation-triangle text-rose-600"></i>
                    </div>
                    <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                        <h3 class="text-lg font-bold leading-6 text-slate-900" id="modal-title">Delete Category</h3>
                        <div class="mt-2">
                            <p class="text-sm text-slate-500">Are you sure you want to delete <strong class="text-slate-800" x-text="categoryNameToDelete"></strong>? <br><br> <span class="text-rose-500 font-medium"><i class="fas fa-info-circle"></i> This will also permanently delete all resolved and rejected complaints associated with this category.</span> This action cannot be undone.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-slate-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6 border-t border-slate-100">
                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex w-full justify-center rounded-xl bg-rose-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-rose-500 sm:ml-3 sm:w-auto">Delete</button>
                </form>
                <button type="button" @click="deleteModalOpen = false" class="mt-3 inline-flex w-full justify-center rounded-xl bg-white px-3 py-2 text-sm font-semibold text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 hover:bg-slate-50 sm:mt-0 sm:w-auto">Cancel</button>
            </div>
        </div>
    </div>

</div>
@endsection
