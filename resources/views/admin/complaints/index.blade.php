@extends('layouts.admin')

@section('content')
<div x-data="{ filterOpen: {{ request()->hasAny(['search', 'status', 'priority', 'category_id']) ? 'true' : 'false' }} }">
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            <h1 class="text-3xl font-black text-slate-800 tracking-tight">Complaints Management</h1>
            <p class="text-slate-500 mt-1">Review, assign, and manage user complaints.</p>
        </div>
        <div class="flex flex-wrap items-center gap-3 w-full md:w-auto">
            <button @click="filterOpen = !filterOpen" class="flex-1 md:flex-none flex items-center justify-center gap-2 px-4 py-2.5 bg-white border border-slate-200 text-slate-700 rounded-xl hover:bg-slate-50 hover:border-teal-300 transition-all font-medium shadow-sm">
                <i class="fas fa-filter text-slate-400"></i> Filters
            </button>
            <a href="{{ route('admin.dashboard.export', request()->query()) }}" class="flex-1 md:flex-none flex items-center justify-center gap-2 px-4 py-2.5 bg-white border border-slate-200 text-slate-700 rounded-xl hover:bg-slate-50 hover:border-teal-300 transition-all font-medium shadow-sm">
                <i class="fas fa-download text-slate-400"></i> Export
            </a>
        </div>
    </div>

    
    <!-- Filter Panel -->
    <div x-show="filterOpen" x-collapse x-cloak class="mb-8">
        <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
            <form method="GET" action="{{ route('admin.complaints.index') }}">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <!-- Search -->
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Search</label>
                        <input type="text" name="search" placeholder="ID or Title" value="{{ request('search') }}" class="w-full bg-slate-50 border border-slate-200 text-slate-700 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 outline-none transition-all">
                    </div>
                    <!-- Status -->
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Status</label>
                        <select name="status" class="w-full bg-slate-50 border border-slate-200 text-slate-700 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 outline-none transition-all appearance-none">
                            <option value="">All Statuses</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                            <option value="resolved" {{ request('status') == 'resolved' ? 'selected' : '' }}>Resolved</option>
                            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                            <option value="withdrawn" {{ request('status') == 'withdrawn' ? 'selected' : '' }}>Withdrawn</option>
                        </select>
                    </div>
                    <!-- Priority -->
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Priority</label>
                        <select name="priority" class="w-full bg-slate-50 border border-slate-200 text-slate-700 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 outline-none transition-all appearance-none">
                            <option value="">All Priorities</option>
                            <option value="high" {{ request('priority') == 'high' ? 'selected' : '' }}>High</option>
                            <option value="medium" {{ request('priority') == 'medium' ? 'selected' : '' }}>Medium</option>
                            <option value="low" {{ request('priority') == 'low' ? 'selected' : '' }}>Low</option>
                        </select>
                    </div>
                    <!-- Category -->
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Category</label>
                        <select name="category_id" class="w-full bg-slate-50 border border-slate-200 text-slate-700 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 outline-none transition-all appearance-none">
                            <option value="">All Categories</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                
                <div class="flex items-center gap-3 mt-6 border-t border-slate-100 pt-6">
                    <button type="submit" class="px-6 py-2.5 bg-slate-800 hover:bg-slate-900 text-white rounded-xl transition-all shadow-md font-medium">
                        Apply Filters
                    </button>
                    <a href="{{ route('admin.complaints.index') }}" class="px-6 py-2.5 bg-white border border-slate-200 hover:bg-slate-50 text-slate-600 rounded-xl transition-all font-medium">
                        Clear
                    </a>
                </div>
            </form>
        </div>
    </div>
    <!-- Data Table -->
    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider border-b border-slate-100">ID / Title</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider border-b border-slate-100">Category</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider border-b border-slate-100">Status</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider border-b border-slate-100">People</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider border-b border-slate-100 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($complaints as $complaint)
                        <tr class="hover:bg-slate-50/80 transition-colors group">
                            <td class="px-6 py-4">
                                <div class="flex flex-col">
                                    <span class="text-sm font-bold text-slate-800 group-hover:text-teal-600 transition-colors">{{ Str::limit($complaint->title, 40) }}</span>
                                    <span class="text-xs text-slate-400 mt-0.5">#{{ $complaint->id }} • {{ $complaint->created_at->format('M d, Y') }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-slate-100 text-slate-600 text-xs font-medium border border-slate-200">
                                    <i class="fas fa-tag text-[10px] text-slate-400"></i>
                                    {{ $complaint->category->name ?? 'N/A' }}
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $statusColors = [
                                        'resolved' => 'bg-emerald-50 text-emerald-600 border-emerald-200',
                                        'in_progress' => 'bg-blue-50 text-blue-600 border-blue-200',
                                        'rejected' => 'bg-rose-50 text-rose-600 border-rose-200',
                                        'pending' => 'bg-amber-50 text-amber-600 border-amber-200'
                                    ];
                                    $colorClass = $statusColors[$complaint->status] ?? 'bg-slate-50 text-slate-600 border-slate-200';
                                    
                                    $priorityColors = [
                                        'high' => 'text-rose-500',
                                        'medium' => 'text-amber-500',
                                        'low' => 'text-emerald-500'
                                    ];
                                    $pColor = $priorityColors[$complaint->priority] ?? 'text-slate-400';
                                @endphp
                                <div class="flex items-center gap-3">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold border {{ $colorClass }}">
                                        {{ ucfirst(str_replace('_', ' ', $complaint->status)) }}
                                    </span>
                                    <span class="text-xs font-bold uppercase tracking-wider {{ $pColor }}" title="Priority: {{ ucfirst($complaint->priority) }}">
                                        <i class="fas {{ $complaint->priority == 'high' ? 'fa-arrow-up' : ($complaint->priority == 'low' ? 'fa-arrow-down' : 'fa-minus') }}"></i>
                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-col gap-1">
                                    <div class="flex items-center gap-2 text-xs text-slate-600">
                                        <i class="fas fa-user text-slate-400 w-3"></i> 
                                        <span class="font-medium" title="Created By">{{ $complaint->creator->name ?? 'Unknown' }}</span>
                                    </div>
                                    <div class="flex items-center gap-2 text-xs text-slate-600">
                                        <i class="fas fa-user-tie text-slate-400 w-3"></i> 
                                        <span class="font-medium {{ !$complaint->assignee ? 'text-slate-400 italic' : '' }}" title="Assigned To">
                                            {{ $complaint->assignee->name ?? 'Unassigned' }}
                                        </span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.complaints.show', $complaint) }}" class="w-8 h-8 rounded-lg bg-white border border-slate-200 flex items-center justify-center text-slate-400 hover:text-teal-600 hover:border-teal-200 hover:bg-teal-50 transition-all shadow-sm" title="View Details">
                                        <i class="fas fa-eye text-sm"></i>
                                    </a>
                                    <a href="{{ route('admin.complaints.edit', $complaint) }}" class="px-3 h-8 rounded-lg bg-white border border-slate-200 flex items-center justify-center text-slate-600 font-medium text-xs hover:text-blue-600 hover:border-blue-200 hover:bg-blue-50 transition-all shadow-sm">
                                        Manage
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center text-slate-400">
                                    <i class="fas fa-inbox text-4xl mb-3 text-slate-300"></i>
                                    <p class="text-sm font-medium">No complaints found.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($complaints->hasPages())
        <div class="p-6 border-t border-slate-100 flex justify-center">
            {{ $complaints->links('pagination::tailwind') }}
        </div>
        @endif
    </div>
</div>
@endsection
