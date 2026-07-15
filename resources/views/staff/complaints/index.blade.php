<x-app-layout>
<div x-data="{ 
    filterOpen: {{ request()->hasAny(['status', 'priority', 'category_id', 'date_from', 'date_to', 'sort_by', 'sort_order']) ? 'true' : 'false' }},
    showModal: null
}">
    
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            <h1 class="text-3xl font-black text-slate-800 tracking-tight">Assigned Complaints</h1>
            <p class="text-slate-500 mt-1">Manage and update the status of complaints assigned to you.</p>
        </div>
        <div class="flex items-center gap-3 w-full md:w-auto">
            <button @click="filterOpen = !filterOpen" class="flex-1 md:flex-none flex items-center justify-center gap-2 px-5 py-2.5 bg-white border border-slate-200 text-slate-700 rounded-xl hover:bg-slate-50 hover:border-teal-300 transition-all font-medium shadow-sm">
                <i class="fas fa-filter text-slate-400"></i> Filters
            </button>
            <a href="{{ route('staff.dashboard') }}" class="flex-1 md:flex-none flex items-center justify-center gap-2 px-5 py-2.5 bg-slate-800 hover:bg-slate-900 text-white rounded-xl transition-all shadow-md font-medium">
                <i class="fas fa-chart-pie"></i> Dashboard
            </a>
        </div>
    </div>

    <!-- Filter Panel -->
    <div x-show="filterOpen" x-collapse x-cloak class="mb-8">
        <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
            <form method="GET" action="{{ route('staff.complaints.index') }}">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
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
                            <option value="low" {{ request('priority') == 'low' ? 'selected' : '' }}>Low</option>
                            <option value="medium" {{ request('priority') == 'medium' ? 'selected' : '' }}>Medium</option>
                            <option value="high" {{ request('priority') == 'high' ? 'selected' : '' }}>High</option>
                        </select>
                    </div>
                    <!-- Category -->
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Category</label>
                        <select name="category_id" class="w-full bg-slate-50 border border-slate-200 text-slate-700 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 outline-none transition-all appearance-none">
                            <option value="">All Categories</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <!-- Sort By -->
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Sort By</label>
                        <select name="sort_by" class="w-full bg-slate-50 border border-slate-200 text-slate-700 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 outline-none transition-all appearance-none">
                            <option value="created_at" {{ request('sort_by') == 'created_at' ? 'selected' : '' }}>Created Date</option>
                            <option value="title" {{ request('sort_by') == 'title' ? 'selected' : '' }}>Title</option>
                            <option value="priority" {{ request('sort_by') == 'priority' ? 'selected' : '' }}>Priority</option>
                            <option value="status" {{ request('sort_by') == 'status' ? 'selected' : '' }}>Status</option>
                        </select>
                    </div>
                    <!-- Date Range -->
                    <div class="grid grid-cols-2 gap-2 lg:col-span-2">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">From</label>
                            <input type="date" name="date_from" id="date_from" value="{{ request('date_from') }}" class="w-full bg-slate-50 border border-slate-200 text-slate-700 rounded-xl px-3 py-2.5 focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 outline-none transition-all text-sm">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">To</label>
                            <input type="date" name="date_to" id="date_to" value="{{ request('date_to') }}" class="w-full bg-slate-50 border border-slate-200 text-slate-700 rounded-xl px-3 py-2.5 focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 outline-none transition-all text-sm">
                        </div>
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
                    <a href="{{ route('staff.complaints.index') }}" class="px-6 py-2.5 bg-white border border-slate-200 hover:bg-slate-50 text-slate-600 rounded-xl transition-all font-medium">
                        Clear
                    </a>
                </div>
            </form>
        </div>
    </div>



    <!-- Data Table -->
    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden flex flex-col">
        <div class="p-6 md:p-8 border-b border-slate-100 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="text-lg font-bold text-slate-800">All Assigned Complaints</h2>
                <p class="text-sm text-slate-500 mt-1">{{ $complaints->total() }} total complaints matching criteria.</p>
            </div>
        </div>
        <div class="overflow-x-auto flex-1">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider border-b border-slate-100">ID / Title</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider border-b border-slate-100">User / Category</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider border-b border-slate-100">Status</th>
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
                                    <span class="text-xs text-slate-400 mt-0.5">#{{ $complaint->id }} • {{ Str::limit($complaint->description, 30) }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-col gap-1.5">
                                    <div class="flex items-center gap-2">
                                        <div class="w-5 h-5 rounded-md bg-slate-200 flex items-center justify-center text-[10px] font-bold text-slate-600">
                                            {{ substr($complaint->creator->name, 0, 1) }}
                                        </div>
                                        <span class="text-sm text-slate-600 font-medium">{{ $complaint->creator->name }}</span>
                                    </div>
                                    <div class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-slate-100 text-slate-500 text-[10px] font-medium self-start">
                                        <i class="fas fa-tag"></i> {{ $complaint->category->name ?? 'N/A' }}
                                    </div>
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
                                <span class="text-sm text-slate-500 font-medium">{{ $complaint->created_at->format('M d, Y') }}</span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('staff.complaints.show', $complaint) }}" class="w-8 h-8 rounded-lg bg-white border border-slate-200 flex items-center justify-center text-slate-400 hover:text-teal-600 hover:border-teal-200 hover:bg-teal-50 transition-all shadow-sm" title="View Details">
                                        <i class="fas fa-eye text-sm"></i>
                                    </a>
                                    <button @click="showModal = {{ $complaint->id }}" class="w-8 h-8 rounded-lg bg-white border border-slate-200 flex items-center justify-center text-slate-400 hover:text-emerald-600 hover:border-emerald-200 hover:bg-emerald-50 transition-all shadow-sm" title="Update Status">
                                        <i class="fas fa-edit text-sm"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center text-slate-400">
                                    <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mb-4 border border-slate-100">
                                        <i class="fas fa-tasks text-2xl text-slate-300"></i>
                                    </div>
                                    <h3 class="text-lg font-bold text-slate-700 mb-1">No assigned complaints</h3>
                                    <p class="text-sm font-medium mb-4">You don't have any complaints assigned to you right now.</p>
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

    <!-- Modals for Status Updates (AlpineJS) -->
    @foreach($complaints as $complaint)
        <div x-show="showModal === {{ $complaint->id }}" 
             style="display: none"
             class="fixed inset-0 z-50 overflow-y-auto" 
             aria-labelledby="modal-title" 
             role="dialog" 
             aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <!-- Background overlay -->
                <div x-show="showModal === {{ $complaint->id }}" 
                     x-transition:enter="ease-out duration-300"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="ease-in duration-200"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"
                     class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" 
                     @click="showModal = null"
                     aria-hidden="true"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <!-- Modal panel -->
                <div x-show="showModal === {{ $complaint->id }}" 
                     x-transition:enter="ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave="ease-in duration-200"
                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     class="inline-block align-bottom bg-white rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full border border-slate-100">
                    
                    <form method="POST" action="{{ route('staff.complaints.update-status', $complaint) }}">
                        @csrf
                        @method('PATCH')
                        
                        <div class="bg-white px-6 pt-6 pb-6">
                            <div class="flex items-center justify-between mb-5">
                                <h3 class="text-xl font-bold text-slate-800" id="modal-title">Update Status</h3>
                                <button type="button" @click="showModal = null" class="w-8 h-8 rounded-xl bg-slate-50 text-slate-400 hover:text-slate-600 hover:bg-slate-100 flex items-center justify-center transition-colors">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                            
                            <div class="mb-4">
                                <p class="text-sm text-slate-500 font-medium mb-1">Complaint ID: <span class="text-slate-800 font-bold">#{{ $complaint->id }}</span></p>
                                <p class="text-sm font-bold text-slate-800">{{ Str::limit($complaint->title, 60) }}</p>
                            </div>

                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-2">New Status</label>
                                    <select name="status" class="w-full bg-slate-50 border border-slate-200 text-slate-700 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 outline-none transition-all appearance-none font-medium" required>
                                        <option value="pending" {{ $complaint->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="in_progress" {{ $complaint->status === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                        <option value="resolved" {{ $complaint->status === 'resolved' ? 'selected' : '' }}>Resolved</option>
                                        <option value="rejected" {{ $complaint->status === 'rejected' ? 'selected' : '' }}>Rejected</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-2">Note (Optional)</label>
                                    <textarea name="message" rows="3" class="w-full bg-slate-50 border border-slate-200 text-slate-700 rounded-xl px-4 py-3 focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 outline-none transition-all" placeholder="Add a note about this status change..."></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="bg-slate-50 px-6 py-4 flex items-center justify-end gap-3 border-t border-slate-100">
                            <button type="button" @click="showModal = null" class="px-5 py-2.5 bg-white border border-slate-200 text-slate-600 rounded-xl hover:bg-slate-50 transition-colors font-medium text-sm">
                                Cancel
                            </button>
                            <button type="submit" class="px-5 py-2.5 bg-slate-800 hover:bg-slate-900 text-white rounded-xl transition-all shadow-md font-medium text-sm">
                                Update Status
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach

</div>
</x-app-layout>
