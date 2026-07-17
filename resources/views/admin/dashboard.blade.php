@extends('layouts.admin')

@section('content')
<div x-data="{ filterOpen: {{ request()->hasAny(['status', 'priority', 'category_id', 'assigned_to', 'date_from', 'date_to', 'sort_by', 'sort_order']) ? 'true' : 'false' }} }">
    
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            <h1 class="text-3xl font-black text-slate-800 tracking-tight">Overview</h1>
            <p class="text-slate-500 mt-1">Welcome back. Here is what's happening today.</p>
        </div>
        <div class="flex items-center gap-3 w-full md:w-auto">
            <button @click="filterOpen = !filterOpen" class="flex-1 md:flex-none flex items-center justify-center gap-2 px-5 py-2.5 bg-white border border-slate-200 text-slate-700 rounded-xl hover:bg-slate-50 hover:border-teal-300 transition-all font-medium shadow-sm">
                <i class="fas fa-filter text-slate-400"></i> Filters
            </button>
            <a href="{{ route('admin.dashboard.export', request()->query()) }}" class="flex-1 md:flex-none flex items-center justify-center gap-2 px-5 py-2.5 bg-gradient-to-r from-teal-500 to-emerald-500 hover:from-teal-600 hover:to-emerald-600 text-white rounded-xl transition-all shadow-[0_8px_20px_-6px_rgba(16,185,129,0.4)] font-medium">
                <i class="fas fa-download"></i> Export
            </a>
        </div>
    </div>

    <!-- Filter Panel -->
    <div x-show="filterOpen" x-collapse x-cloak class="mb-8">
        <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
            <form method="GET" action="{{ route('admin.dashboard') }}">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
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
                    <!-- Assigned To -->
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Assigned To</label>
                        <select name="assigned_to" class="w-full bg-slate-50 border border-slate-200 text-slate-700 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 outline-none transition-all appearance-none">
                            <option value="">All Assignments</option>
                            <option value="unassigned" {{ request('assigned_to') == 'unassigned' ? 'selected' : '' }}>Unassigned</option>
                            @foreach($staffMembers as $staff)
                                <option value="{{ $staff->id }}" {{ request('assigned_to') == $staff->id ? 'selected' : '' }}>
                                    {{ $staff->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <!-- Date Range -->
                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">From</label>
                            <input type="date" name="date_from" id="date_from" value="{{ request('date_from') }}" class="w-full bg-slate-50 border border-slate-200 text-slate-700 rounded-xl px-3 py-2.5 focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 outline-none transition-all text-sm">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">To</label>
                            <input type="date" name="date_to" id="date_to" value="{{ request('date_to') }}" class="w-full bg-slate-50 border border-slate-200 text-slate-700 rounded-xl px-3 py-2.5 focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 outline-none transition-all text-sm">
                        </div>
                    </div>
                </div>
                
                <div class="flex items-center gap-3 mt-6 border-t border-slate-100 pt-6">
                    <button type="submit" class="px-6 py-2.5 bg-slate-800 hover:bg-slate-900 text-white rounded-xl transition-all shadow-md font-medium">
                        Apply Filters
                    </button>
                    <a href="{{ route('admin.dashboard') }}" class="px-6 py-2.5 bg-white border border-slate-200 hover:bg-slate-50 text-slate-600 rounded-xl transition-all font-medium">
                        Clear
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Bento Grid Stats -->
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-7 gap-6 mb-8">
        
        <!-- Primary Stat -->
        <div class="bg-gradient-to-br from-teal-500 to-emerald-600 rounded-3xl p-6 shadow-[0_15px_40px_-10px_rgba(16,185,129,0.4)] relative overflow-hidden text-white group col-span-2 md:col-span-3 lg:col-span-2 xl:col-span-1">
            <div class="absolute -right-6 -top-6 w-32 h-32 bg-white/10 rounded-full blur-2xl group-hover:scale-150 transition-transform duration-700"></div>
            <div class="relative z-10">
                <div class="flex justify-between items-start mb-4">
                    <div class="w-12 h-12 rounded-xl bg-white/20 flex items-center justify-center backdrop-blur-sm border border-white/20">
                        <i class="fas fa-clipboard-list text-xl"></i>
                    </div>
                </div>
                <h3 class="text-white/80 font-medium mb-1">Total Complaints</h3>
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

        <!-- Rejected -->
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 relative overflow-hidden group hover:shadow-md transition-shadow">
            <div class="absolute right-0 top-0 w-32 h-32 bg-rose-500/5 rounded-full blur-3xl group-hover:bg-rose-500/10 transition-colors duration-500"></div>
            <div class="flex justify-between items-start mb-4 relative z-10">
                <div class="w-12 h-12 rounded-xl bg-rose-50 flex items-center justify-center text-rose-500 border border-rose-100">
                    <i class="fas fa-times-circle text-xl"></i>
                </div>
            </div>
            <h3 class="text-slate-500 font-medium mb-1 relative z-10">Rejected</h3>
            <div class="text-3xl font-black text-slate-800 relative z-10">{{ $stats['rejected'] ?? 0 }}</div>
        </div>

        <!-- Withdrawn -->
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 relative overflow-hidden group hover:shadow-md transition-shadow">
            <div class="absolute right-0 top-0 w-32 h-32 bg-slate-500/5 rounded-full blur-3xl group-hover:bg-slate-500/10 transition-colors duration-500"></div>
            <div class="flex justify-between items-start mb-4 relative z-10">
                <div class="w-12 h-12 rounded-xl bg-slate-50 flex items-center justify-center text-slate-500 border border-slate-100">
                    <i class="fas fa-ban text-xl"></i>
                </div>
            </div>
            <h3 class="text-slate-500 font-medium mb-1 relative z-10">Withdrawn</h3>
            <div class="text-3xl font-black text-slate-800 relative z-10">{{ $stats['withdrawn'] ?? 0 }}</div>
        </div>

        <!-- Resolution Rate -->
        <div class="bg-slate-900 rounded-3xl p-6 shadow-[0_15px_40px_-10px_rgba(15,23,42,0.4)] relative overflow-hidden text-white group col-span-2 md:col-span-1 lg:col-span-1 xl:col-span-1">
            <div class="absolute right-[-20%] bottom-[-20%] w-32 h-32 bg-teal-500/20 rounded-full blur-3xl"></div>
            <div class="relative z-10 flex flex-col h-full">
                <div class="w-12 h-12 rounded-xl bg-slate-800 flex items-center justify-center text-teal-400 border border-slate-700 mb-4">
                    <i class="fas fa-chart-line text-xl"></i>
                </div>
                <h3 class="text-slate-400 font-medium mb-1 relative z-10">Resolution Rate</h3>
                <div class="text-3xl font-black text-white relative z-10">{{ $additionalStats['resolution_rate'] }}%</div>
            </div>
        </div>

    </div>

    <!-- Analytics Charts -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <!-- Line Chart -->
        <div class="lg:col-span-2 bg-white rounded-3xl shadow-sm border border-slate-100 p-6 flex flex-col">
            <h3 class="text-lg font-bold text-slate-800 mb-4">Complaints Trend (Last 30 Days)</h3>
            <div class="relative w-full flex-1 h-72">
                <canvas id="trendLineChart"></canvas>
            </div>
        </div>
        <!-- Pie Chart -->
        <div class="lg:col-span-1 bg-white rounded-3xl shadow-sm border border-slate-100 p-6 flex flex-col">
            <h3 class="text-lg font-bold text-slate-800 mb-4">Status Distribution</h3>
            <div class="relative w-full flex-1 h-72 flex items-center justify-center">
                <canvas id="statusPieChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Secondary Bento Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        
        <!-- Key Metrics -->
        <div class="lg:col-span-2 bg-white rounded-3xl shadow-sm border border-slate-100 p-6 md:p-8 flex flex-col h-full justify-center">
            <h2 class="text-lg font-bold text-slate-800 mb-6 md:mb-10">System Health</h2>
            <div class="grid grid-cols-2 gap-y-8 gap-x-6 flex-1 items-center">
                <!-- Avg Time -->
                <div>
                    <p class="text-sm font-medium text-slate-500 mb-2">Resolution Time</p>
                    <p class="text-2xl lg:text-3xl font-black text-slate-800">{{ abs($additionalStats['avg_resolution_time']) }}<span class="text-base text-slate-400 font-medium ml-1">hrs</span></p>
                </div>
                <!-- High Priority -->
                <div>
                    <p class="text-sm font-medium text-slate-500 mb-2">High Priority</p>
                    <p class="text-2xl lg:text-3xl font-black text-rose-500">{{ $additionalStats['high_priority_pending'] }}</p>
                </div>
                <!-- Rejected -->
                <div>
                    <p class="text-sm font-medium text-slate-500 mb-2">Rejected</p>
                    <p class="text-2xl lg:text-3xl font-black text-slate-800">{{ $stats['rejected'] }}</p>
                </div>
                <!-- Unassigned -->
                <div>
                    <p class="text-sm font-medium text-slate-500 mb-2">Unassigned</p>
                    <p class="text-2xl lg:text-3xl font-black text-slate-800">{{ $stats['unassigned'] }}</p>
                </div>
            </div>
        </div>

        <!-- Users Summary -->
        <div class="bg-slate-900 rounded-3xl shadow-[0_15px_40px_-10px_rgba(15,23,42,0.4)] border border-slate-800 p-6 md:p-8 relative overflow-hidden">
            <div class="absolute right-[-20%] bottom-[-20%] w-64 h-64 bg-teal-500/10 rounded-full blur-3xl"></div>
            <h2 class="text-lg font-bold text-white mb-6">User Base</h2>
            <div class="space-y-6">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-slate-800 flex items-center justify-center text-teal-400 border border-slate-700">
                        <i class="fas fa-users text-xl"></i>
                    </div>
                    <div>
                        <p class="text-white text-2xl font-black">{{ $additionalStats['total_users'] ?? 0 }}</p>
                        <p class="text-slate-400 text-sm font-medium">Total Users</p>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-slate-800 flex items-center justify-center text-emerald-400 border border-slate-700">
                        <i class="fas fa-user-tie text-xl"></i>
                    </div>
                    <div>
                        <p class="text-white text-2xl font-black">{{ $additionalStats['total_staff'] }}</p>
                        <p class="text-slate-400 text-sm font-medium">Staff Members</p>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-slate-800 flex items-center justify-center text-amber-400 border border-slate-700">
                        <i class="fas fa-tags text-xl"></i>
                    </div>
                    <div>
                        <p class="text-white text-2xl font-black">{{ $additionalStats['total_categories'] }}</p>
                        <p class="text-slate-400 text-sm font-medium">Active Categories</p>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Data Table -->
    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-6 md:p-8 border-b border-slate-100 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="text-lg font-bold text-slate-800">Recent Complaints</h2>
                <p class="text-sm text-slate-500 mt-1">Latest tickets requiring attention.</p>
            </div>
            <a href="{{ route('admin.complaints.index') }}" class="text-teal-600 hover:text-teal-700 font-medium text-sm flex items-center gap-1 group">
                View All <i class="fas fa-arrow-right text-xs group-hover:translate-x-1 transition-transform"></i>
            </a>
        </div>
        <div class="overflow-x-auto">
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
                                    <span class="text-xs text-slate-400 mt-0.5">#{{ $complaint->id }} • {{ $complaint->creator->name ?? 'Unknown' }}</span>
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
                                    <a href="{{ route('admin.complaints.show', $complaint) }}" class="w-8 h-8 rounded-lg bg-white border border-slate-200 flex items-center justify-center text-slate-400 hover:text-teal-600 hover:border-teal-200 hover:bg-teal-50 transition-all shadow-sm">
                                        <i class="fas fa-eye text-sm"></i>
                                    </a>
                                    <a href="{{ route('admin.complaints.edit', $complaint) }}" class="w-8 h-8 rounded-lg bg-white border border-slate-200 flex items-center justify-center text-slate-400 hover:text-blue-600 hover:border-blue-200 hover:bg-blue-50 transition-all shadow-sm">
                                        <i class="fas fa-edit text-sm"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center text-slate-400">
                                    <i class="fas fa-inbox text-4xl mb-3 text-slate-300"></i>
                                    <p class="text-sm font-medium">No complaints found matching criteria.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="p-6 border-t border-slate-100 flex justify-center">
            {{ $complaints->links('pagination::tailwind') }}
        </div>
    </div>

</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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

document.addEventListener('DOMContentLoaded', function() {
    const chartData = @json($chartData ?? ['pie' => [], 'line' => ['labels' => [], 'data' => []]]);
    
    // Pie Chart
    const pieCtx = document.getElementById('statusPieChart').getContext('2d');
    new Chart(pieCtx, {
        type: 'doughnut',
        data: {
            labels: ['Pending', 'In Progress', 'Resolved', 'Rejected', 'Withdrawn'],
            datasets: [{
                data: [
                    chartData.pie.pending || 0,
                    chartData.pie.in_progress || 0,
                    chartData.pie.resolved || 0,
                    chartData.pie.rejected || 0,
                    chartData.pie.withdrawn || 0
                ],
                backgroundColor: [
                    '#f59e0b', // amber-500
                    '#3b82f6', // blue-500
                    '#10b981', // emerald-500
                    '#f43f5e', // rose-500
                    '#64748b'  // slate-500
                ],
                borderWidth: 0,
                hoverOffset: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 20,
                        usePointStyle: true,
                        pointStyle: 'circle'
                    }
                }
            },
            cutout: '70%'
        }
    });

    // Line Chart
    const lineCtx = document.getElementById('trendLineChart').getContext('2d');
    new Chart(lineCtx, {
        type: 'line',
        data: {
            labels: chartData.line.labels,
            datasets: [{
                label: 'New Complaints',
                data: chartData.line.data,
                borderColor: '#14b8a6', // teal-500
                backgroundColor: 'rgba(20, 184, 166, 0.1)',
                borderWidth: 2,
                tension: 0.4,
                fill: true,
                pointBackgroundColor: '#fff',
                pointBorderColor: '#14b8a6',
                pointBorderWidth: 2,
                pointRadius: 4,
                pointHoverRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    mode: 'index',
                    intersect: false,
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    },
                    grid: {
                        color: '#f1f5f9', // slate-100
                        drawBorder: false
                    }
                },
                x: {
                    grid: {
                        display: false,
                        drawBorder: false
                    },
                    ticks: {
                        maxTicksLimit: 7
                    }
                }
            },
            interaction: {
                mode: 'nearest',
                axis: 'x',
                intersect: false
            }
        }
    });
});
</script>
@endpush
@endsection
