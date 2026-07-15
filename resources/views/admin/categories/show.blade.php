@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            <h1 class="text-3xl font-black text-slate-800 tracking-tight">Category Details</h1>
            <p class="text-slate-500 mt-1">Viewing information and stats for {{ $category->name }}.</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('admin.categories.edit', $category) }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-gradient-to-r from-teal-500 to-emerald-600 hover:from-teal-600 hover:to-emerald-700 text-white rounded-xl font-medium transition-all shadow-md shadow-teal-500/20">
                <i class="fas fa-edit text-sm"></i> Edit Category
            </a>
            <a href="{{ route('admin.categories.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-white border border-slate-200 text-slate-700 hover:text-teal-600 hover:border-teal-200 hover:bg-teal-50 rounded-xl font-medium transition-all shadow-sm">
                <i class="fas fa-arrow-left text-sm"></i> Back
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Left Column: Category Info -->
        <div class="lg:col-span-1 space-y-6">
            <!-- Profile Card -->
            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-8 text-center relative overflow-hidden group">
                <div class="absolute inset-0 bg-gradient-to-b from-teal-500/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                
                <div class="w-20 h-20 mx-auto rounded-2xl bg-gradient-to-br from-teal-500 to-emerald-600 flex items-center justify-center text-white text-3xl font-black shadow-lg shadow-teal-500/30 mb-6 transform group-hover:scale-105 transition-transform">
                    <i class="fas fa-tags text-2xl"></i>
                </div>
                
                <h2 class="text-2xl font-bold text-slate-800 mb-2 relative z-10">{{ $category->name }}</h2>
                <p class="text-slate-500 text-sm relative z-10">{{ $category->description ?? 'No description provided' }}</p>
            </div>

            <!-- Meta Data Card -->
            <div class="bg-slate-900 rounded-3xl shadow-[0_15px_40px_-10px_rgba(15,23,42,0.4)] border border-slate-800 p-6 relative overflow-hidden">
                <div class="absolute right-[-20%] bottom-[-20%] w-64 h-64 bg-teal-500/10 rounded-full blur-3xl"></div>
                
                <div class="space-y-4 relative z-10">
                    <div class="flex justify-between items-center py-2 border-b border-slate-800/50">
                        <span class="text-slate-400 text-sm font-medium">Created</span>
                        <span class="text-white text-sm font-medium">{{ $category->created_at->format('M d, Y') }}</span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-slate-800/50">
                        <span class="text-slate-400 text-sm font-medium">Updated</span>
                        <span class="text-white text-sm font-medium">{{ $category->updated_at->format('M d, Y') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column: Stats & Complaints -->
        <div class="lg:col-span-2 space-y-6">
            
            <h3 class="text-lg font-bold text-slate-800 px-2 flex items-center gap-2">
                <i class="fas fa-chart-pie text-teal-500"></i> Category Statistics
            </h3>

            <!-- Stats Bento Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                <!-- Total -->
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 relative overflow-hidden group hover:shadow-md transition-shadow">
                    <div class="absolute right-0 top-0 w-32 h-32 bg-blue-500/5 rounded-full blur-3xl group-hover:bg-blue-500/10 transition-colors duration-500"></div>
                    <h4 class="text-slate-500 font-medium mb-1 relative z-10">Total Complaints</h4>
                    <div class="text-4xl font-black text-slate-800 relative z-10">{{ $complaintsCount }}</div>
                </div>

                <!-- Pending -->
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 relative overflow-hidden group hover:shadow-md transition-shadow">
                    <div class="absolute right-0 top-0 w-32 h-32 bg-amber-500/5 rounded-full blur-3xl group-hover:bg-amber-500/10 transition-colors duration-500"></div>
                    <h4 class="text-slate-500 font-medium mb-1 relative z-10">Pending</h4>
                    <div class="text-4xl font-black text-slate-800 relative z-10">{{ $pendingCount }}</div>
                </div>

                <!-- Resolved -->
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 relative overflow-hidden group hover:shadow-md transition-shadow">
                    <div class="absolute right-0 top-0 w-32 h-32 bg-emerald-500/5 rounded-full blur-3xl group-hover:bg-emerald-500/10 transition-colors duration-500"></div>
                    <h4 class="text-slate-500 font-medium mb-1 relative z-10">Resolved</h4>
                    <div class="text-4xl font-black text-slate-800 relative z-10">{{ $resolvedCount }}</div>
                </div>
            </div>

            <!-- Recent Complaints -->
            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden mt-6">
                <div class="px-6 py-5 border-b border-slate-100">
                    <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                        <i class="fas fa-list text-teal-500"></i> Recent Complaints in this Category
                    </h3>
                </div>
                
                @if($category->complaints->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr>
                                    <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider bg-slate-50/50">ID</th>
                                    <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider bg-slate-50/50">Title</th>
                                    <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider bg-slate-50/50">Priority</th>
                                    <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider bg-slate-50/50">Status</th>
                                    <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider bg-slate-50/50">Date</th>
                                    <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider bg-slate-50/50 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 bg-white">
                                @foreach($category->complaints->take(5) as $complaint)
                                    <tr class="hover:bg-slate-50/50 transition-colors group">
                                        <td class="px-6 py-4 text-sm font-medium text-slate-500">#{{ $complaint->id }}</td>
                                        <td class="px-6 py-4">
                                            <span class="text-sm font-bold text-slate-700">{{ Str::limit($complaint->title, 30) }}</span>
                                        </td>
                                        <td class="px-6 py-4">
                                            @php
                                                $priorityColors = [
                                                    'high' => 'bg-rose-50 text-rose-600 border-rose-200',
                                                    'medium' => 'bg-amber-50 text-amber-600 border-amber-200',
                                                    'low' => 'bg-emerald-50 text-emerald-600 border-emerald-200'
                                                ];
                                                $pColor = $priorityColors[$complaint->priority] ?? 'bg-slate-50 text-slate-600 border-slate-200';
                                            @endphp
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-bold border {{ $pColor }}">
                                                {{ ucfirst($complaint->priority) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            @php
                                                $statusColors = [
                                                    'pending' => 'bg-amber-50 text-amber-600 border-amber-200',
                                                    'in_progress' => 'bg-blue-50 text-blue-600 border-blue-200',
                                                    'resolved' => 'bg-emerald-50 text-emerald-600 border-emerald-200',
                                                    'rejected' => 'bg-rose-50 text-rose-600 border-rose-200'
                                                ];
                                                $sColor = $statusColors[$complaint->status] ?? 'bg-slate-50 text-slate-600 border-slate-200';
                                            @endphp
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-bold border {{ $sColor }}">
                                                {{ ucfirst(str_replace('_', ' ', $complaint->status)) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-slate-500 font-medium">
                                            {{ $complaint->created_at->format('M d, Y') }}
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <a href="{{ route('admin.complaints.show', $complaint) }}" class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-teal-50 text-teal-600 hover:bg-teal-500 hover:text-white transition-colors" title="View Details">
                                                <i class="fas fa-eye text-xs"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="p-12 text-center">
                        <div class="w-16 h-16 rounded-full bg-slate-50 flex items-center justify-center text-slate-300 mx-auto mb-4">
                            <i class="fas fa-folder-open text-2xl"></i>
                        </div>
                        <h4 class="text-slate-700 font-bold mb-1">No Complaints</h4>
                        <p class="text-sm text-slate-500">There are currently no complaints in this category.</p>
                    </div>
                @endif
            </div>
            
        </div>
    </div>
</div>
@endsection
