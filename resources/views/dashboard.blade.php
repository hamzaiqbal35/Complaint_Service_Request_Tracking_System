<x-app-layout>
<div x-data="{ filterOpen: {{ request()->hasAny(['status', 'priority', 'category_id', 'date_from', 'date_to', 'sort_by', 'sort_order']) ? 'true' : 'false' }} }">
    
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            <h1 class="text-3xl font-black text-slate-800 tracking-tight">Overview</h1>
            <p class="text-slate-500 mt-1">Welcome back, {{ Auth::user()->name }}! Here is what's happening today.</p>
        </div>
        <div class="flex items-center gap-3 w-full md:w-auto">
            <button @click="filterOpen = !filterOpen" class="flex-1 md:flex-none flex items-center justify-center gap-2 px-5 py-2.5 bg-white border border-slate-200 text-slate-700 rounded-xl hover:bg-slate-50 hover:border-teal-300 transition-all font-medium shadow-sm">
                <i class="fas fa-filter text-slate-400"></i> Filters
            </button>
            <a href="{{ route('complaints.create') }}" class="flex-1 md:flex-none flex items-center justify-center gap-2 px-5 py-2.5 bg-gradient-to-r from-teal-500 to-emerald-500 hover:from-teal-600 hover:to-emerald-600 text-white rounded-xl transition-all shadow-[0_8px_20px_-6px_rgba(16,185,129,0.4)] font-medium">
                <i class="fas fa-plus"></i> New Complaint
            </a>
            <a href="{{ route('dashboard.export', request()->query()) }}" class="flex-1 md:flex-none flex items-center justify-center gap-2 px-5 py-2.5 bg-slate-800 hover:bg-slate-900 text-white rounded-xl transition-all shadow-md font-medium">
                <i class="fas fa-download"></i> Export
            </a>
        </div>
    </div>

    <!-- Filter Panel -->
    <div x-show="filterOpen" x-collapse x-cloak class="mb-8">
        <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
            <form method="GET" action="{{ route('dashboard') }}">
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
                    <a href="{{ route('dashboard') }}" class="px-6 py-2.5 bg-white border border-slate-200 hover:bg-slate-50 text-slate-600 rounded-xl transition-all font-medium">
                        Clear
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Bento Grid Stats -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        
        <!-- Primary Stat -->
        <div class="bg-gradient-to-br from-teal-500 to-emerald-600 rounded-3xl p-6 shadow-[0_15px_40px_-10px_rgba(16,185,129,0.4)] relative overflow-hidden text-white group">
            <div class="absolute -right-6 -top-6 w-32 h-32 bg-white/10 rounded-full blur-2xl group-hover:scale-150 transition-transform duration-700"></div>
            <div class="relative z-10">
                <div class="flex justify-between items-start mb-4">
                    <div class="w-12 h-12 rounded-xl bg-white/20 flex items-center justify-center backdrop-blur-sm border border-white/20">
                        <i class="fas fa-clipboard-list text-xl"></i>
                    </div>
                </div>
                <h3 class="text-white/80 font-medium mb-1">My Complaints</h3>
                <div class="text-4xl font-black">{{ $stats['total'] }}</div>
            </div>
        </div>

        <!-- Pending -->
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 relative overflow-hidden group hover:shadow-md transition-shadow">
            <div class="absolute right-0 top-0 w-32 h-32 bg-amber-500/5 rounded-full blur-3xl group-hover:bg-amber-500/10 transition-colors duration-500"></div>
            <div class="flex justify-between items-start mb-4 relative z-10">
                <div class="w-12 h-12 rounded-xl bg-amber-50 flex items-center justify-center text-amber-500 border border-amber-100">
                    <i class="fas fa-clock text-xl"></i>
                </div>
            </div>
            <h3 class="text-slate-500 font-medium mb-1 relative z-10">Pending</h3>
            <div class="text-3xl font-black text-slate-800 relative z-10">{{ $stats['pending'] }}</div>
        </div>

        <!-- In Progress -->
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 relative overflow-hidden group hover:shadow-md transition-shadow">
            <div class="absolute right-0 top-0 w-32 h-32 bg-blue-500/5 rounded-full blur-3xl group-hover:bg-blue-500/10 transition-colors duration-500"></div>
            <div class="flex justify-between items-start mb-4 relative z-10">
                <div class="w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center text-blue-500 border border-blue-100">
                    <i class="fas fa-spinner text-xl"></i>
                </div>
            </div>
            <h3 class="text-slate-500 font-medium mb-1 relative z-10">In Progress</h3>
            <div class="text-3xl font-black text-slate-800 relative z-10">{{ $stats['in_progress'] }}</div>
        </div>

        <!-- Resolved -->
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 relative overflow-hidden group hover:shadow-md transition-shadow">
            <div class="absolute right-0 top-0 w-32 h-32 bg-emerald-500/5 rounded-full blur-3xl group-hover:bg-emerald-500/10 transition-colors duration-500"></div>
            <div class="flex justify-between items-start mb-4 relative z-10">
                <div class="w-12 h-12 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-500 border border-emerald-100">
                    <i class="fas fa-check-circle text-xl"></i>
                </div>
            </div>
            <h3 class="text-slate-500 font-medium mb-1 relative z-10">Resolved</h3>
            <div class="text-3xl font-black text-slate-800 relative z-10">{{ $stats['resolved'] }}</div>
        </div>

    </div>

    <!-- Main Content Area -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        
        <!-- Complaints Table -->
        <div class="lg:col-span-2 bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden flex flex-col">
            <div class="p-6 md:p-8 border-b border-slate-100 flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h2 class="text-lg font-bold text-slate-800">My Complaints</h2>
                    <p class="text-sm text-slate-500 mt-1">Track the status of your reported issues.</p>
                </div>
                <a href="{{ route('complaints.index') }}" class="text-teal-600 hover:text-teal-700 font-medium text-sm flex items-center gap-1 group">
                    View All <i class="fas fa-arrow-right text-xs group-hover:translate-x-1 transition-transform"></i>
                </a>
            </div>
            <div class="overflow-x-auto flex-1">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/50">
                            <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider border-b border-slate-100">ID / Title</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider border-b border-slate-100">Category</th>
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
                                        <a href="{{ route('complaints.show', $complaint) }}" class="w-8 h-8 rounded-lg bg-white border border-slate-200 flex items-center justify-center text-slate-400 hover:text-teal-600 hover:border-teal-200 hover:bg-teal-50 transition-all shadow-sm" title="View Details">
                                            <i class="fas fa-eye text-sm"></i>
                                        </a>

                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center text-slate-400">
                                        <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mb-4 border border-slate-100">
                                            <i class="fas fa-file-alt text-2xl text-slate-300"></i>
                                        </div>
                                        <h3 class="text-lg font-bold text-slate-700 mb-1">No complaints found</h3>
                                        <p class="text-sm font-medium mb-4">You haven't submitted any complaints that match this criteria.</p>
                                        <a href="{{ route('complaints.create') }}" class="px-5 py-2 bg-slate-800 hover:bg-slate-900 text-white rounded-xl transition-all shadow-md font-medium text-sm">
                                            Create First Complaint
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="p-6 border-t border-slate-100">
                {{ $complaints->links('pagination::tailwind') }}
            </div>
        </div>

        <!-- Sidebar Activity & Actions -->
        <div class="space-y-6">
            <!-- Quick Actions -->
            <div class="bg-slate-900 rounded-3xl shadow-[0_15px_40px_-10px_rgba(15,23,42,0.4)] border border-slate-800 p-6 relative overflow-hidden">
                <div class="absolute right-[-20%] bottom-[-20%] w-48 h-48 bg-teal-500/10 rounded-full blur-3xl"></div>
                <h2 class="text-lg font-bold text-white mb-6 relative z-10"><i class="fas fa-bolt text-amber-400 mr-2"></i> Quick Actions</h2>
                <div class="flex flex-col gap-4 relative z-10">
                    <a href="{{ route('complaints.create') }}" class="flex items-center gap-3 w-full p-3 rounded-xl bg-slate-800 border border-slate-700 text-white hover:bg-slate-700 hover:border-slate-600 transition-colors group">
                        <div class="w-10 h-10 rounded-lg bg-teal-500/20 text-teal-400 flex items-center justify-center group-hover:scale-105 transition-transform">
                            <i class="fas fa-plus"></i>
                        </div>
                        <span class="font-medium">New Complaint</span>
                    </a>
                    <a href="{{ route('complaints.index') }}" class="flex items-center gap-3 w-full p-3 rounded-xl bg-slate-800 border border-slate-700 text-slate-300 hover:bg-slate-700 hover:text-white transition-colors group">
                        <div class="w-10 h-10 rounded-lg bg-slate-700/50 text-slate-400 flex items-center justify-center group-hover:scale-105 transition-transform">
                            <i class="fas fa-list"></i>
                        </div>
                        <span class="font-medium">View All Complaints</span>
                    </a>
                    <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 w-full p-3 rounded-xl bg-slate-800 border border-slate-700 text-slate-300 hover:bg-slate-700 hover:text-white transition-colors group">
                        <div class="w-10 h-10 rounded-lg bg-slate-700/50 text-slate-400 flex items-center justify-center group-hover:scale-105 transition-transform">
                            <i class="fas fa-user-cog"></i>
                        </div>
                        <span class="font-medium">Profile Settings</span>
                    </a>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-6">
                <h2 class="text-lg font-bold text-slate-800 mb-6"><i class="fas fa-history text-slate-400 mr-2"></i> Recent Activity</h2>
                <div class="space-y-6">
                    @foreach($complaints->take(4) as $complaint)
                        <div class="flex gap-4 relative">
                            @if(!$loop->last)
                                <div class="absolute left-5 top-10 bottom-[-24px] w-px bg-slate-100"></div>
                            @endif
                            <div class="w-10 h-10 rounded-full bg-slate-50 border border-slate-100 flex items-center justify-center flex-shrink-0 z-10">
                                @if($complaint->status === 'resolved')
                                    <i class="fas fa-check text-emerald-500"></i>
                                @elseif($complaint->status === 'in_progress')
                                    <i class="fas fa-spinner text-blue-500"></i>
                                @elseif($complaint->status === 'rejected')
                                    <i class="fas fa-times text-rose-500"></i>
                                @else
                                    <i class="fas fa-clock text-amber-500"></i>
                                @endif
                            </div>
                            <div>
                                <p class="text-sm font-bold text-slate-800">{{ Str::limit($complaint->title, 35) }}</p>
                                <div class="flex items-center gap-2 mt-1">
                                    <span class="text-xs text-slate-400">{{ $complaint->created_at->diffForHumans() }}</span>
                                    <span class="w-1 h-1 rounded-full bg-slate-300"></span>
                                    <span class="text-xs font-medium 
                                        @if($complaint->status === 'resolved') text-emerald-600
                                        @elseif($complaint->status === 'in_progress') text-blue-600
                                        @elseif($complaint->status === 'rejected') text-rose-600
                                        @else text-amber-600
                                        @endif">
                                        {{ ucfirst(str_replace('_', ' ', $complaint->status)) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    
                    @if($complaints->isEmpty())
                        <div class="text-center py-4">
                            <p class="text-sm text-slate-400 italic">No recent activity</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

    </div>

</div>

@push('scripts')
<script>
document.addEventListener('alpine:init', () => {
    const dateFrom = document.getElementById('date_from');
    const dateTo = document.getElementById('date_to');
    
    if (dateFrom && dateTo) {
        if (dateFrom.value) dateTo.min = dateFrom.value;
        if (dateTo.value) dateFrom.max = dateTo.value;
        
        dateFrom.addEventListener('change', function() {
            dateTo.min = this.value;
            if (dateTo.value && dateTo.value < this.value) {
                dateTo.value = this.value;
            }
        });
        dateTo.addEventListener('change', function() {
            dateFrom.max = this.value;
            if (dateFrom.value > this.value) {
                dateFrom.value = this.value;
            }
        });
    }
});
</script>
@endpush
</x-app-layout>
