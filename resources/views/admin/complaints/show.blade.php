@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            <h1 class="text-3xl font-black text-slate-800 tracking-tight">Complaint #{{ $complaint->id }}</h1>
            <p class="text-slate-500 mt-1">Detailed view and activity log.</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('admin.complaints.edit', $complaint) }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-gradient-to-r from-teal-500 to-emerald-600 hover:from-teal-600 hover:to-emerald-700 text-white rounded-xl font-medium transition-all shadow-md shadow-teal-500/20">
                <i class="fas fa-edit text-sm"></i> Edit
            </a>
            <a href="{{ route('admin.complaints.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-white border border-slate-200 text-slate-700 hover:text-teal-600 hover:border-teal-200 hover:bg-teal-50 rounded-xl font-medium transition-all shadow-sm">
                <i class="fas fa-arrow-left text-sm"></i> Back
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Main Info -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-6 md:p-8 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-64 h-64 bg-teal-500/5 rounded-full blur-3xl -z-10"></div>
                
                <h2 class="text-xl font-bold text-slate-800 mb-6 flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-teal-50 text-teal-600 flex items-center justify-center">
                        <i class="fas fa-info-circle"></i>
                    </div>
                    Information
                </h2>

                <div class="space-y-6">
                    <!-- Title & Description -->
                    <div>
                        <span class="block text-sm font-semibold text-slate-500 mb-1">Title</span>
                        <p class="text-xl font-bold text-slate-800">{{ $complaint->title }}</p>
                    </div>
                    
                    <div class="bg-slate-50 rounded-2xl p-5 border border-slate-100">
                        <span class="block text-sm font-semibold text-slate-500 mb-2">Description</span>
                        <p class="text-slate-700 whitespace-pre-wrap leading-relaxed">{{ $complaint->description }}</p>
                    </div>
                    
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-6 pt-4 border-t border-slate-100">
                        <!-- Category -->
                        <div>
                            <span class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Category</span>
                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg bg-slate-100 text-slate-700 text-sm font-medium">
                                {{ $complaint->category->name ?? 'N/A' }}
                            </span>
                        </div>
                        
                        <!-- Priority -->
                        <div>
                            <span class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Priority</span>
                            @php
                                $priorityColors = [
                                    'high' => 'bg-rose-50 text-rose-600 border-rose-200',
                                    'medium' => 'bg-amber-50 text-amber-600 border-amber-200',
                                    'low' => 'bg-emerald-50 text-emerald-600 border-emerald-200'
                                ];
                                $pColor = $priorityColors[$complaint->priority] ?? 'bg-slate-50 text-slate-600 border-slate-200';
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg border {{ $pColor }} text-sm font-bold">
                                {{ ucfirst($complaint->priority) }}
                            </span>
                        </div>

                        <!-- Status -->
                        <div>
                            <span class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Status</span>
                            @php
                                $statusColors = [
                                    'pending' => 'bg-amber-50 text-amber-600 border-amber-200',
                                    'in_progress' => 'bg-blue-50 text-blue-600 border-blue-200',
                                    'resolved' => 'bg-emerald-50 text-emerald-600 border-emerald-200',
                                    'rejected' => 'bg-rose-50 text-rose-600 border-rose-200'
                                ];
                                $sColor = $statusColors[$complaint->status] ?? 'bg-slate-50 text-slate-600 border-slate-200';
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg border {{ $sColor }} text-sm font-bold">
                                {{ ucfirst(str_replace('_', ' ', $complaint->status)) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- User Context -->
                <div class="bg-slate-900 rounded-3xl shadow-[0_15px_40px_-10px_rgba(15,23,42,0.4)] border border-slate-800 p-6 relative overflow-hidden">
                    <div class="absolute right-[-20%] bottom-[-20%] w-64 h-64 bg-teal-500/10 rounded-full blur-3xl"></div>
                    
                    <h3 class="text-sm font-bold text-teal-400 mb-4 uppercase tracking-wider">People</h3>
                    
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-slate-400 text-sm font-medium">Created By</span>
                            <span class="text-white font-medium">{{ $complaint->creator->name ?? 'N/A' }}</span>
                        </div>
                        <div class="flex items-center justify-between pt-4 border-t border-slate-800">
                            <span class="text-slate-400 text-sm font-medium">Assigned To</span>
                            @if($complaint->assignee)
                                <span class="text-white font-medium flex items-center gap-2">
                                    <i class="fas fa-user-tie text-blue-400 text-xs"></i> {{ $complaint->assignee->name }}
                                </span>
                            @else
                                <span class="px-2 py-0.5 rounded text-xs font-bold bg-slate-800 text-slate-400">Unassigned</span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Timestamps -->
                <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-6">
                    <h3 class="text-sm font-bold text-slate-500 mb-4 uppercase tracking-wider">Timeline</h3>
                    
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-slate-500 text-sm font-medium">Created At</span>
                            <span class="text-slate-800 font-medium">{{ $complaint->created_at->format('M d, Y H:i') }}</span>
                        </div>
                        @if($complaint->resolved_at)
                        <div class="flex items-center justify-between pt-4 border-t border-slate-100">
                            <span class="text-emerald-600 text-sm font-medium">Resolved At</span>
                            <span class="text-emerald-700 font-bold">{{ $complaint->resolved_at->format('M d, Y H:i') }}</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

        </div>

        <!-- Right Sidebar: Activity Log -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-6 relative overflow-hidden h-full">
                <h3 class="text-lg font-bold text-slate-800 mb-6 flex items-center gap-2">
                    <i class="fas fa-history text-teal-500"></i> Activity Log
                </h3>
                
                <div class="space-y-6 relative before:absolute before:inset-0 before:ml-5 before:-translate-x-px before:h-full before:w-0.5 before:bg-gradient-to-b before:from-transparent before:via-slate-200 before:to-transparent">
                    @forelse($complaint->logs as $log)
                        <div class="relative flex items-start gap-4 group is-active">
                            <div class="flex items-center justify-center w-10 h-10 rounded-full border border-white bg-slate-100 text-slate-500 shrink-0 shadow-sm relative z-10">
                                @if(str_contains(strtolower($log->action), 'created'))
                                    <i class="fas fa-plus text-xs"></i>
                                @elseif(str_contains(strtolower($log->action), 'status'))
                                    <i class="fas fa-sync-alt text-xs text-blue-500"></i>
                                @elseif(str_contains(strtolower($log->action), 'assigned'))
                                    <i class="fas fa-user-check text-xs text-amber-500"></i>
                                @else
                                    <i class="fas fa-circle text-[8px]"></i>
                                @endif
                            </div>
                            
                            <div class="w-[calc(100%-3.5rem)] bg-slate-50 border border-slate-100 p-4 rounded-2xl shadow-sm mt-1">
                                <div class="flex flex-col xl:flex-row xl:items-center justify-between mb-1 gap-1 xl:gap-2">
                                    <span class="font-bold text-sm text-slate-800 break-words">{{ $log->user->name ?? 'System' }}</span>
                                    <time class="text-xs font-medium text-slate-400 whitespace-nowrap">{{ $log->created_at->diffForHumans() }}</time>
                                </div>
                                <div class="text-sm text-slate-600 font-medium">{{ ucfirst(str_replace('_', ' ', $log->action)) }}</div>
                                @if($log->message)
                                    <div class="mt-2 text-xs text-slate-500 bg-white p-2 rounded-lg border border-slate-100 break-words whitespace-pre-wrap">
                                        {{ $log->message }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8 text-slate-500 text-sm">
                            No activity recorded yet.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
