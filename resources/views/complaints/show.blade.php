<x-app-layout>
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            <a href="{{ route('complaints.index') }}" class="text-sm font-bold text-teal-600 hover:text-teal-700 flex items-center gap-2 mb-2 transition-colors">
                <i class="fas fa-arrow-left"></i> Back to Complaints
            </a>
            <h1 class="text-3xl font-black text-slate-800 tracking-tight">Complaint Details</h1>
            <p class="text-slate-500 mt-1">Review the information and status of your complaint.</p>
        </div>
    </div>

    <!-- Main Content -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Left Column: Details -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden relative group">
                <!-- Decorative background element -->
                <div class="absolute right-0 top-0 w-64 h-64 bg-slate-50 rounded-full blur-3xl pointer-events-none"></div>
                
                <div class="p-8 relative z-10">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
                        <div>
                            <span class="text-sm font-bold text-slate-400 block mb-1">COMPLAINT ID</span>
                            <span class="text-2xl font-black text-slate-800">#{{ $complaint->id }}</span>
                        </div>
                        <div class="flex flex-wrap items-center gap-2">
                            @php
                                $statusColors = [
                                    'resolved' => 'bg-emerald-50 text-emerald-600 border-emerald-200',
                                    'in_progress' => 'bg-blue-50 text-blue-600 border-blue-200',
                                    'rejected' => 'bg-rose-50 text-rose-600 border-rose-200',
                                    'pending' => 'bg-amber-50 text-amber-600 border-amber-200'
                                ];
                                $colorClass = $statusColors[$complaint->status] ?? 'bg-slate-50 text-slate-600 border-slate-200';
                            @endphp
                            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-bold border {{ $colorClass }}">
                                <i class="fas fa-circle text-[10px] mr-2"></i> {{ ucfirst(str_replace('_', ' ', $complaint->status)) }}
                            </span>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-8">
                        <div>
                            <span class="text-sm font-bold text-slate-400 block mb-2">CATEGORY</span>
                            <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl bg-slate-100 text-slate-700 text-sm font-medium">
                                <i class="fas fa-tag text-slate-400"></i>
                                {{ $complaint->category->name ?? 'N/A' }}
                            </div>
                        </div>
                        <div>
                            <span class="text-sm font-bold text-slate-400 block mb-2">PRIORITY</span>
                            @php
                                $priorityColors = [
                                    'high' => 'bg-rose-50 text-rose-600 border-rose-100',
                                    'medium' => 'bg-amber-50 text-amber-600 border-amber-100',
                                    'low' => 'bg-emerald-50 text-emerald-600 border-emerald-100'
                                ];
                                $pClass = $priorityColors[$complaint->priority] ?? 'bg-slate-50 text-slate-600 border-slate-100';
                            @endphp
                            <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl border text-sm font-bold {{ $pClass }}">
                                <i class="fas {{ $complaint->priority == 'high' ? 'fa-arrow-up' : ($complaint->priority == 'low' ? 'fa-arrow-down' : 'fa-minus') }}"></i>
                                {{ ucfirst($complaint->priority) }}
                            </div>
                        </div>
                    </div>

                    <div class="mb-8">
                        <span class="text-sm font-bold text-slate-400 block mb-2">TITLE</span>
                        <h2 class="text-xl font-bold text-slate-800">{{ $complaint->title }}</h2>
                    </div>

                    <div>
                        <span class="text-sm font-bold text-slate-400 block mb-2">DESCRIPTION</span>
                        <div class="p-5 bg-slate-50 rounded-2xl border border-slate-100 text-slate-700 leading-relaxed">
                            {{ $complaint->description }}
                        </div>
                    </div>
                </div>
            </div>

            @if($complaint->logs && $complaint->logs->count() > 0)
                <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
                    <div class="p-6 md:p-8 border-b border-slate-100">
                        <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                            <i class="fas fa-history text-slate-400"></i> Activity Log
                        </h3>
                    </div>
                    <div class="p-6 md:p-8">
                        <div class="space-y-6">
                            @foreach($complaint->logs as $log)
                                <div class="relative pl-6 sm:pl-8 border-l-2 border-slate-100 last:pb-0 pb-6">
                                    <div class="absolute w-4 h-4 bg-white border-2 border-teal-500 rounded-full -left-[9px] top-1 shadow-[0_0_0_4px_rgba(255,255,255,1)]"></div>
                                    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start gap-2 mb-2">
                                        <div>
                                            <span class="font-bold text-slate-800">{{ $log->user->name ?? 'System' }}</span>
                                            <span class="text-slate-500 mx-1">updated the status to</span>
                                            <span class="font-bold text-slate-700">{{ ucfirst(str_replace('_', ' ', $log->action)) }}</span>
                                        </div>
                                        <span class="text-sm font-medium text-slate-400 whitespace-nowrap">{{ $log->created_at->format('M d, Y h:i A') }}</span>
                                    </div>
                                    @if($log->message)
                                        <div class="mt-3 p-4 bg-slate-50 rounded-xl border border-slate-100 text-sm text-slate-600 break-words whitespace-pre-wrap">
                                            {{ $log->message }}
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Right Column: Sidebar -->
        <div class="space-y-6">
            <!-- Assignment Card -->
            <div class="bg-slate-900 rounded-3xl shadow-[0_15px_40px_-10px_rgba(15,23,42,0.4)] border border-slate-800 p-6 relative overflow-hidden">
                <div class="absolute right-[-20%] bottom-[-20%] w-48 h-48 bg-teal-500/20 rounded-full blur-3xl pointer-events-none"></div>
                <h3 class="text-sm font-bold text-slate-400 mb-6 relative z-10 tracking-wider">ASSIGNMENT</h3>
                
                @if($complaint->assignee)
                    <div class="flex items-center gap-4 relative z-10">
                        <div class="w-12 h-12 rounded-xl bg-teal-500/20 flex items-center justify-center text-teal-400 border border-teal-500/30 text-lg font-bold">
                            {{ substr($complaint->assignee->name, 0, 1) }}
                        </div>
                        <div>
                            <p class="text-white font-bold">{{ $complaint->assignee->name }}</p>
                            <p class="text-slate-400 text-sm font-medium">Support Staff</p>
                        </div>
                    </div>
                @else
                    <div class="flex items-center gap-4 relative z-10">
                        <div class="w-12 h-12 rounded-xl bg-slate-800 flex items-center justify-center text-slate-500 border border-slate-700 text-lg">
                            <i class="fas fa-user-clock"></i>
                        </div>
                        <div>
                            <p class="text-white font-bold">Unassigned</p>
                            <p class="text-slate-400 text-sm font-medium">Waiting for staff</p>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Quick Actions -->
            <div class="bg-slate-900 rounded-3xl shadow-[0_15px_40px_-10px_rgba(15,23,42,0.4)] border border-slate-800 p-6 relative overflow-hidden mb-6">
                <div class="absolute right-[-20%] top-[-20%] w-48 h-48 bg-slate-700/30 rounded-full blur-3xl pointer-events-none"></div>
                <h3 class="text-sm font-bold text-slate-400 mb-6 relative z-10 tracking-wider">QUICK ACTIONS</h3>
                <div class="flex flex-col gap-4 relative z-10">
                    @if($complaint->status === 'pending')
                        <button onclick="confirmWithdraw()" class="w-full flex items-center gap-3 p-3 rounded-xl bg-rose-500/10 border border-rose-500/20 text-rose-500 hover:bg-rose-500/20 hover:border-rose-500/30 transition-all text-left">
                            <div class="w-8 h-8 rounded-lg bg-rose-500/20 flex items-center justify-center">
                                <i class="fas fa-times"></i>
                            </div>
                            <span class="font-bold text-sm">Withdraw Complaint</span>
                        </button>
                        
                        <form id="withdraw-form" action="{{ route('complaints.update', $complaint) }}" method="POST" class="hidden">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="withdrawn">
                        </form>

                        <script>
                            function confirmWithdraw() {
                                Swal.fire({
                                    title: 'Are you sure?',
                                    text: "You won't be able to revert this! The complaint will be withdrawn.",
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonColor: '#3085d6',
                                    cancelButtonColor: '#d33',
                                    confirmButtonText: 'Yes, withdraw it!',
                                    reverseButtons: true
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        document.getElementById('withdraw-form').submit();
                                    }
                                })
                            }
                        </script>
                    @endif
                    <a href="{{ route('complaints.index') }}" class="w-full flex items-center gap-3 p-3 rounded-xl bg-slate-800 border border-slate-700 text-white hover:bg-slate-700 hover:border-slate-600 transition-all text-left">
                        <div class="w-8 h-8 rounded-lg bg-slate-700/50 flex items-center justify-center">
                            <i class="fas fa-list text-slate-300"></i>
                        </div>
                        <span class="font-bold text-sm">Back to List</span>
                    </a>
                </div>
            </div>

            <!-- Timeline Summary Card -->
            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-6">
                <h3 class="text-sm font-bold text-slate-400 mb-6 tracking-wider">TIMELINE</h3>
                <div class="space-y-6">
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-xl bg-slate-50 flex items-center justify-center text-slate-400 border border-slate-100 shrink-0">
                            <i class="fas fa-plus"></i>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-slate-800">Created</p>
                            <p class="text-xs font-medium text-slate-500">{{ $complaint->created_at->format('M d, Y h:i A') }}</p>
                        </div>
                    </div>
                    
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-xl bg-slate-50 flex items-center justify-center text-slate-400 border border-slate-100 shrink-0">
                            <i class="fas fa-pen"></i>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-slate-800">Last Updated</p>
                            <p class="text-xs font-medium text-slate-500">{{ $complaint->updated_at->format('M d, Y h:i A') }}</p>
                        </div>
                    </div>

                    @if($complaint->resolved_at)
                        <div class="flex gap-4">
                            <div class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-500 border border-emerald-100 shrink-0">
                                <i class="fas fa-check"></i>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-emerald-600">Resolved</p>
                                <p class="text-xs font-medium text-emerald-500/80">{{ $complaint->resolved_at->format('M d, Y h:i A') }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
