<x-app-layout>
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            <h1 class="text-3xl font-black text-slate-800 tracking-tight">My Complaints</h1>
            <p class="text-slate-500 mt-1">Track the status of your reported issues.</p>
        </div>
        <div class="flex items-center gap-3 w-full md:w-auto">
            <a href="{{ route('complaints.create') }}" class="flex-1 md:flex-none flex items-center justify-center gap-2 px-6 py-2.5 bg-gradient-to-r from-teal-500 to-emerald-500 hover:from-teal-600 hover:to-emerald-600 text-white rounded-xl transition-all shadow-[0_8px_20px_-6px_rgba(16,185,129,0.4)] font-bold">
                <i class="fas fa-plus"></i> New Complaint
            </a>
        </div>
    </div>



    <!-- Data Table -->
    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden flex flex-col">
        <div class="p-6 md:p-8 border-b border-slate-100 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="text-lg font-bold text-slate-800">Complaint History</h2>
                <p class="text-sm text-slate-500 mt-1">Review all your submitted complaints.</p>
            </div>
        </div>
        
        <div class="overflow-x-auto flex-1">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider border-b border-slate-100">ID / Title</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider border-b border-slate-100">Category</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider border-b border-slate-100">Status</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider border-b border-slate-100">Assigned To</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider border-b border-slate-100">Date</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider border-b border-slate-100 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($complaints as $complaint)
                        <tr class="hover:bg-slate-50/80 transition-colors group">
                            <td class="px-6 py-4">
                                <div class="flex flex-col">
                                    <span class="text-sm font-bold text-slate-800 group-hover:text-teal-600 transition-colors">{{ Str::limit($complaint->title, 40) }}</span>
                                    <span class="text-xs text-slate-400 mt-0.5">#{{ $complaint->id }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-slate-100 text-slate-600 text-xs font-medium">
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
                                        'pending' => 'bg-amber-50 text-amber-600 border-amber-200',
                                        'withdrawn' => 'bg-slate-100 text-slate-600 border-slate-300'
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
                                @if($complaint->assignee)
                                    <div class="flex items-center gap-2">
                                        <div class="w-6 h-6 rounded-md bg-slate-200 flex items-center justify-center text-[10px] font-bold text-slate-600">
                                            {{ substr($complaint->assignee->name, 0, 1) }}
                                        </div>
                                        <span class="text-sm text-slate-600 font-medium">{{ $complaint->assignee->name }}</span>
                                    </div>
                                @else
                                    <span class="text-sm text-slate-400 font-medium italic">Unassigned</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm text-slate-500 font-medium">{{ $complaint->created_at->format('M d, Y') }}</span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('complaints.show', $complaint) }}" class="w-8 h-8 rounded-lg bg-white border border-slate-200 flex items-center justify-center text-slate-400 hover:text-teal-600 hover:border-teal-200 hover:bg-teal-50 transition-all shadow-sm" title="View Details">
                                        <i class="fas fa-eye text-sm"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center text-slate-400">
                                    <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mb-4 border border-slate-100">
                                        <i class="fas fa-inbox text-2xl text-slate-300"></i>
                                    </div>
                                    <h3 class="text-lg font-bold text-slate-700 mb-1">No complaints found</h3>
                                    <p class="text-sm font-medium mb-4">You haven't submitted any complaints yet.</p>
                                    <a href="{{ route('complaints.create') }}" class="text-teal-600 hover:text-teal-700 font-bold text-sm">Submit your first complaint <i class="fas fa-arrow-right ml-1"></i></a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($complaints->hasPages())
            <div class="p-6 border-t border-slate-100">
                {{ $complaints->links('pagination::tailwind') }}
            </div>
        @endif
    </div>
</x-app-layout>
