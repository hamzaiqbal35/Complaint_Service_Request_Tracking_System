@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            <h1 class="text-3xl font-black text-slate-800 tracking-tight">Manage Complaint #{{ $complaint->id }}</h1>
            <p class="text-slate-500 mt-1">Review and update complaint status and assignment.</p>
        </div>
        <a href="{{ route('admin.complaints.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-white border border-slate-200 text-slate-700 hover:text-teal-600 hover:border-teal-200 hover:bg-teal-50 rounded-xl font-medium transition-all shadow-sm">
            <i class="fas fa-arrow-left text-sm"></i> Back to List
        </a>
    </div>



    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Main Details -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-6 md:p-8 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-64 h-64 bg-teal-500/5 rounded-full blur-3xl -z-10"></div>
                
                <h2 class="text-xl font-bold text-slate-800 mb-6 flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-teal-50 text-teal-600 flex items-center justify-center">
                        <i class="fas fa-file-alt"></i>
                    </div>
                    Complaint Details
                </h2>

                <div class="space-y-6">
                    <div>
                        <span class="block text-sm font-semibold text-slate-500 mb-1">Title</span>
                        <p class="text-lg font-bold text-slate-800">{{ $complaint->title }}</p>
                    </div>
                    
                    <div class="bg-slate-50 rounded-2xl p-5 border border-slate-100">
                        <span class="block text-sm font-semibold text-slate-500 mb-2">Description</span>
                        <p class="text-slate-700 whitespace-pre-wrap leading-relaxed">{{ $complaint->description }}</p>
                    </div>
                    
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div>
                            <span class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Category</span>
                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg bg-slate-100 text-slate-700 text-sm font-medium">
                                {{ $complaint->category->name }}
                            </span>
                        </div>
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
                        <div class="md:col-span-2">
                            <span class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Created By</span>
                            <div class="flex items-center gap-2">
                                <div class="w-6 h-6 rounded-full bg-teal-100 text-teal-600 flex items-center justify-center text-xs font-bold">
                                    {{ substr($complaint->creator->name ?? 'U', 0, 1) }}
                                </div>
                                <span class="text-sm font-medium text-slate-700">{{ $complaint->creator->name ?? 'Unknown' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Management Actions -->
        <div class="lg:col-span-1 space-y-6">
            
            <!-- Assign Staff -->
            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-6 relative overflow-hidden group">
                <div class="absolute right-[-10%] top-[-10%] w-32 h-32 bg-blue-500/5 rounded-full blur-2xl group-hover:bg-blue-500/10 transition-colors"></div>
                
                <h3 class="text-lg font-bold text-slate-800 mb-4 flex items-center gap-2 relative z-10">
                    <i class="fas fa-user-tie text-blue-500"></i> Assign Staff
                </h3>
                
                <form method="POST" action="{{ route('admin.complaints.assign', $complaint) }}" class="relative z-10">
                    @csrf
                    @method('PATCH')
                    
                    <div class="mb-4 relative">
                        <select name="assigned_to" id="assigned_to" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition-all text-slate-700 bg-slate-50 focus:bg-white appearance-none cursor-pointer">
                            <option value="">Unassigned</option>
                            @foreach($staff as $member)
                                <option value="{{ $member->id }}" {{ $complaint->assigned_to == $member->id ? 'selected' : '' }}>
                                    {{ $member->name }}
                                </option>
                            @endforeach
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-slate-500">
                            <i class="fas fa-chevron-down text-sm"></i>
                        </div>
                    </div>
                    
                    <button type="submit" class="w-full py-2.5 rounded-xl font-medium text-blue-700 bg-blue-50 hover:bg-blue-100 border border-blue-200 transition-colors flex items-center justify-center gap-2">
                        <i class="fas fa-user-plus"></i> Update Assignment
                    </button>
                </form>
            </div>

            <!-- Update Status -->
            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-6 relative overflow-hidden group">
                <div class="absolute right-[-10%] top-[-10%] w-32 h-32 bg-teal-500/5 rounded-full blur-2xl group-hover:bg-teal-500/10 transition-colors"></div>
                
                <h3 class="text-lg font-bold text-slate-800 mb-4 flex items-center gap-2 relative z-10">
                    <i class="fas fa-tasks text-teal-500"></i> Update Status
                </h3>
                
                <form method="POST" action="{{ route('admin.complaints.update-status', $complaint) }}" class="relative z-10">
                    @csrf
                    @method('PATCH')
                    
                    <div class="mb-4 relative">
                        <select name="status" id="status" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 outline-none transition-all text-slate-700 bg-slate-50 focus:bg-white appearance-none cursor-pointer">
                            <option value="pending" {{ $complaint->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="in_progress" {{ $complaint->status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                            <option value="resolved" {{ $complaint->status == 'resolved' ? 'selected' : '' }}>Resolved</option>
                            <option value="rejected" {{ $complaint->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-slate-500">
                            <i class="fas fa-chevron-down text-sm"></i>
                        </div>
                    </div>
                    
                    <button type="submit" class="w-full py-2.5 rounded-xl font-medium text-teal-700 bg-teal-50 hover:bg-teal-100 border border-teal-200 transition-colors flex items-center justify-center gap-2">
                        <i class="fas fa-sync-alt"></i> Update Status
                    </button>
                </form>
            </div>
            
            <div class="text-center mt-4">
                <a href="{{ route('admin.complaints.show', $complaint) }}" class="inline-flex items-center gap-1 text-sm font-medium text-slate-500 hover:text-teal-600 transition-colors">
                    <i class="fas fa-eye"></i> View Full Details & Activity Log
                </a>
            </div>

        </div>
    </div>
</div>
@endsection
