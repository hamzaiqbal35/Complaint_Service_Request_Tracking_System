@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            <h1 class="text-3xl font-black text-slate-800 tracking-tight">User Profile</h1>
            <p class="text-slate-500 mt-1">Viewing details for {{ $user->name }}.</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('admin.users.edit', $user) }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-gradient-to-r from-teal-500 to-emerald-600 hover:from-teal-600 hover:to-emerald-700 text-white rounded-xl font-medium transition-all shadow-md shadow-teal-500/20">
                <i class="fas fa-edit text-sm"></i> Edit User
            </a>
            @if($user->id !== auth()->id())
                <button type="button" onclick="confirmDeleteUser()" class="inline-flex items-center gap-2 px-4 py-2.5 bg-white border border-rose-200 text-rose-600 hover:bg-rose-50 rounded-xl font-medium transition-all shadow-sm">
                    <i class="fas fa-trash-alt text-sm"></i> Delete User
                </button>
                <form id="delete-user-form" action="{{ route('admin.users.destroy', $user) }}" method="POST" class="hidden">
                    @csrf
                    @method('DELETE')
                </form>
                <script>
                    function confirmDeleteUser() {
                        Swal.fire({
                            title: 'Are you sure?',
                            text: "You won't be able to revert this! All user data will be permanently removed.",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#e11d48',
                            cancelButtonColor: '#94a3b8',
                            confirmButtonText: 'Yes, delete user!',
                            reverseButtons: true
                        }).then((result) => {
                            if (result.isConfirmed) {
                                document.getElementById('delete-user-form').submit();
                            }
                        })
                    }
                </script>
            @endif
            <a href="{{ route('admin.users.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-white border border-slate-200 text-slate-700 hover:text-teal-600 hover:border-teal-200 hover:bg-teal-50 rounded-xl font-medium transition-all shadow-sm">
                <i class="fas fa-arrow-left text-sm"></i> Back
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Left Column: User Profile -->
        <div class="lg:col-span-1 space-y-6">
            <!-- Profile Card -->
            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-8 text-center relative overflow-hidden group">
                <div class="absolute inset-0 bg-gradient-to-b from-teal-500/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                
                <div class="w-24 h-24 mx-auto rounded-2xl bg-gradient-to-br from-teal-500 to-emerald-600 flex items-center justify-center text-white text-3xl font-black shadow-lg shadow-teal-500/30 mb-6 transform group-hover:scale-105 transition-transform">
                    {{ substr($user->name, 0, 1) }}
                </div>
                
                <h2 class="text-2xl font-bold text-slate-800 mb-1 relative z-10">{{ $user->name }}</h2>
                <p class="text-slate-500 mb-6 relative z-10">{{ $user->email }}</p>
                
                @php
                    $roleColors = [
                        'admin' => 'bg-rose-50 text-rose-600 border-rose-200',
                        'staff' => 'bg-amber-50 text-amber-600 border-amber-200',
                        'user'  => 'bg-blue-50 text-blue-600 border-blue-200',
                    ];
                    $roleClass = $roleColors[$user->role] ?? 'bg-slate-50 text-slate-600 border-slate-200';
                @endphp
                <span class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full border text-sm font-bold {{ $roleClass }} relative z-10">
                    <i class="fas fa-shield-alt"></i> {{ ucfirst($user->role) }}
                </span>
            </div>

            <!-- Meta Data Card -->
            <div class="bg-slate-900 rounded-3xl shadow-[0_15px_40px_-10px_rgba(15,23,42,0.4)] border border-slate-800 p-6 relative overflow-hidden">
                <div class="absolute right-[-20%] bottom-[-20%] w-64 h-64 bg-teal-500/10 rounded-full blur-3xl"></div>
                
                <div class="space-y-4">
                    <div class="flex justify-between items-center py-2 border-b border-slate-800/50">
                        <span class="text-slate-400 text-sm font-medium">Status</span>
                        @if($user->email_verified_at)
                            <span class="text-emerald-400 text-sm font-bold flex items-center gap-1">
                                <i class="fas fa-check-circle"></i> Verified
                            </span>
                        @else
                            <span class="text-slate-400 text-sm font-bold flex items-center gap-1">
                                <i class="fas fa-clock"></i> Unverified
                            </span>
                        @endif
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-slate-800/50">
                        <span class="text-slate-400 text-sm font-medium">Created</span>
                        <span class="text-white text-sm font-medium">{{ $user->created_at->format('M d, Y') }}</span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-slate-800/50">
                        <span class="text-slate-400 text-sm font-medium">Updated</span>
                        <span class="text-white text-sm font-medium">{{ $user->updated_at->format('M d, Y') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column: Stats & Activity -->
        <div class="lg:col-span-2 space-y-6">
            
            <h3 class="text-lg font-bold text-slate-800 px-2 flex items-center gap-2">
                <i class="fas fa-chart-pie text-teal-500"></i> Activity Statistics
            </h3>

            <!-- Stats Bento Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6">
                <!-- Created -->
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 relative overflow-hidden group hover:shadow-md transition-shadow">
                    <div class="absolute right-0 top-0 w-32 h-32 bg-blue-500/5 rounded-full blur-3xl group-hover:bg-blue-500/10 transition-colors duration-500"></div>
                    <div class="w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center text-blue-500 border border-blue-100 mb-4">
                        <i class="fas fa-plus-circle text-xl"></i>
                    </div>
                    <h4 class="text-slate-500 font-medium mb-1">Complaints Created</h4>
                    <div class="text-3xl font-black text-slate-800">{{ $complaintsCreated ?? 0 }}</div>
                </div>

                @if($user->role === 'staff' || $user->role === 'admin')
                    <!-- Assigned -->
                    <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 relative overflow-hidden group hover:shadow-md transition-shadow">
                        <div class="absolute right-0 top-0 w-32 h-32 bg-amber-500/5 rounded-full blur-3xl group-hover:bg-amber-500/10 transition-colors duration-500"></div>
                        <div class="w-12 h-12 rounded-xl bg-amber-50 flex items-center justify-center text-amber-500 border border-amber-100 mb-4">
                            <i class="fas fa-clipboard-list text-xl"></i>
                        </div>
                        <h4 class="text-slate-500 font-medium mb-1">Assigned Tasks</h4>
                        <div class="text-3xl font-black text-slate-800">{{ $complaintsAssigned ?? 0 }}</div>
                    </div>

                    <!-- Resolved -->
                    <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 relative overflow-hidden group hover:shadow-md transition-shadow">
                        <div class="absolute right-0 top-0 w-32 h-32 bg-emerald-500/5 rounded-full blur-3xl group-hover:bg-emerald-500/10 transition-colors duration-500"></div>
                        <div class="w-12 h-12 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-500 border border-emerald-100 mb-4">
                            <i class="fas fa-check-circle text-xl"></i>
                        </div>
                        <h4 class="text-slate-500 font-medium mb-1">Tasks Resolved</h4>
                        <div class="text-3xl font-black text-slate-800">{{ $complaintsResolved ?? 0 }}</div>
                    </div>
                @endif
            </div>

            <!-- Place for recent complaints or feed if needed -->
            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-8 text-center mt-6">
                <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-300">
                    <i class="fas fa-folder-open text-2xl"></i>
                </div>
                <h3 class="text-slate-700 font-bold mb-1">No Recent Activity</h3>
                <p class="text-slate-500 text-sm">This section will show recent complaints associated with this user.</p>
            </div>
            
        </div>
    </div>
</div>
@endsection
