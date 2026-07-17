@extends('layouts.admin')

@section('content')
<div x-data="{ 
    filterOpen: {{ request()->hasAny(['role', 'search', 'sort_by', 'sort_order']) ? 'true' : 'false' }},
    deleteModalOpen: false,
    userToDelete: null,
    userNameToDelete: '',
    selected: [],
    selectAll: false,
    pageIds: {{ json_encode($users->pluck('id')) }},
    toggleAll() {
        this.selected = this.selectAll ? [...this.pageIds] : [];
    },
    confirmDelete(id, name) {
        this.userToDelete = id;
        this.userNameToDelete = name;
        this.deleteModalOpen = true;
        // The form action will be dynamically constructed in Blade, but we can just use the base URL and append ID
        document.getElementById('deleteForm').action = '/admin/users/' + id;
    }
}">

    <!-- Page Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            <h1 class="text-3xl font-black text-slate-800 tracking-tight">User Management</h1>
            <p class="text-slate-500 mt-1">Manage all system users, roles, and permissions.</p>
        </div>
        <div class="flex flex-wrap items-center gap-3 w-full md:w-auto">
            <button @click="filterOpen = !filterOpen" class="flex-1 md:flex-none flex items-center justify-center gap-2 px-4 py-2.5 bg-white border border-slate-200 text-slate-700 rounded-xl hover:bg-slate-50 hover:border-teal-300 transition-all font-medium shadow-sm">
                <i class="fas fa-filter text-slate-400"></i> Filters
            </button>
            <a href="{{ route('admin.users.export', request()->query()) }}" class="flex-1 md:flex-none flex items-center justify-center gap-2 px-4 py-2.5 bg-white border border-slate-200 text-slate-700 rounded-xl hover:bg-slate-50 hover:border-teal-300 transition-all font-medium shadow-sm">
                <i class="fas fa-download text-slate-400"></i> Export
            </a>
            <a href="{{ route('admin.users.create') }}" class="flex-1 md:flex-none flex items-center justify-center gap-2 px-5 py-2.5 bg-gradient-to-r from-teal-500 to-emerald-500 hover:from-teal-600 hover:to-emerald-600 text-white rounded-xl transition-all shadow-[0_8px_20px_-6px_rgba(16,185,129,0.4)] font-medium">
                <i class="fas fa-plus"></i> Add User
            </a>
        </div>
    </div>

    <!-- Filter Panel -->
    <div x-show="filterOpen" x-collapse x-cloak class="mb-8">
        <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
            <form method="GET" action="{{ route('admin.users.index') }}">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <!-- Role -->
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Role</label>
                        <select name="role" class="w-full bg-slate-50 border border-slate-200 text-slate-700 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 outline-none transition-all appearance-none">
                            <option value="">All Roles</option>
                            <option value="user" {{ request('role') == 'user' ? 'selected' : '' }}>User</option>
                            <option value="staff" {{ request('role') == 'staff' ? 'selected' : '' }}>Staff</option>
                            <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                    </div>
                    <!-- Search -->
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Search</label>
                        <input type="text" name="search" placeholder="Name or Email" value="{{ request('search') }}" class="w-full bg-slate-50 border border-slate-200 text-slate-700 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 outline-none transition-all">
                    </div>
                    <!-- Sort By -->
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Sort By</label>
                        <select name="sort_by" class="w-full bg-slate-50 border border-slate-200 text-slate-700 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 outline-none transition-all appearance-none">
                            <option value="created_at" {{ request('sort_by') == 'created_at' ? 'selected' : '' }}>Created Date</option>
                            <option value="name" {{ request('sort_by') == 'name' ? 'selected' : '' }}>Name</option>
                            <option value="email" {{ request('sort_by') == 'email' ? 'selected' : '' }}>Email</option>
                            <option value="role" {{ request('sort_by') == 'role' ? 'selected' : '' }}>Role</option>
                        </select>
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
                    <a href="{{ route('admin.users.index') }}" class="px-6 py-2.5 bg-white border border-slate-200 hover:bg-slate-50 text-slate-600 rounded-xl transition-all font-medium">
                        Clear
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 flex items-center justify-between group hover:shadow-md transition-all">
            <div>
                <p class="text-sm font-bold text-slate-400 uppercase tracking-wider mb-1">Total Users</p>
                <p class="text-3xl font-black text-slate-800">{{ $stats['total'] }}</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-teal-50 flex items-center justify-center text-teal-500 border border-teal-100 group-hover:scale-110 transition-transform">
                <i class="fas fa-users text-xl"></i>
            </div>
        </div>
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 flex items-center justify-between group hover:shadow-md transition-all">
            <div>
                <p class="text-sm font-bold text-slate-400 uppercase tracking-wider mb-1">Regular Users</p>
                <p class="text-3xl font-black text-slate-800">{{ $stats['users'] }}</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center text-blue-500 border border-blue-100 group-hover:scale-110 transition-transform">
                <i class="fas fa-user text-xl"></i>
            </div>
        </div>
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 flex items-center justify-between group hover:shadow-md transition-all">
            <div>
                <p class="text-sm font-bold text-slate-400 uppercase tracking-wider mb-1">Staff Members</p>
                <p class="text-3xl font-black text-slate-800">{{ $stats['staff'] }}</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-amber-50 flex items-center justify-center text-amber-500 border border-amber-100 group-hover:scale-110 transition-transform">
                <i class="fas fa-user-tie text-xl"></i>
            </div>
        </div>
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 flex items-center justify-between group hover:shadow-md transition-all">
            <div>
                <p class="text-sm font-bold text-slate-400 uppercase tracking-wider mb-1">Administrators</p>
                <p class="text-3xl font-black text-slate-800">{{ $stats['admins'] }}</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-rose-50 flex items-center justify-center text-rose-500 border border-rose-100 group-hover:scale-110 transition-transform">
                <i class="fas fa-user-shield text-xl"></i>
            </div>
        </div>
    </div>

    <!-- Mass Actions Bar -->
    <div x-show="selected.length > 0" x-collapse x-cloak class="mb-6 bg-teal-50 border border-teal-100 rounded-2xl p-4 shadow-sm flex items-center justify-between">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded-full bg-teal-200/50 text-teal-700 flex items-center justify-center font-bold">
                <span x-text="selected.length"></span>
            </div>
            <span class="text-teal-800 font-medium">users selected</span>
        </div>
        <form action="{{ route('admin.users.bulk') }}" method="POST" class="flex flex-wrap items-center gap-2" id="bulk-action-form">
            @csrf
            <template x-for="id in selected" :key="id">
                <input type="hidden" name="ids[]" :value="id">
            </template>
            <select name="action" class="bg-white border border-teal-200 text-teal-800 rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 outline-none font-medium appearance-none min-w-[160px]" required>
                <option value="">Choose action...</option>
                <option value="verify">Mark as Verified</option>
                <option value="delete">Delete Selected</option>
            </select>
            <button type="submit" class="px-5 py-2 bg-teal-600 hover:bg-teal-700 text-white rounded-xl text-sm font-medium transition-all shadow-sm" onclick="return confirm('Are you sure you want to perform this action on selected users?')">
                Apply Action
            </button>
        </form>
    </div>

    <!-- Data Table -->
    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th class="px-6 py-4 w-12 border-b border-slate-100">
                            <input type="checkbox" x-model="selectAll" @change="toggleAll" class="w-4 h-4 rounded border-slate-300 text-teal-600 focus:ring-teal-500/30 transition-all cursor-pointer">
                        </th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider border-b border-slate-100">User Details</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider border-b border-slate-100">Role</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider border-b border-slate-100">Verification</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider border-b border-slate-100">Joined</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider border-b border-slate-100 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($users as $user)
                        <tr class="hover:bg-slate-50/80 transition-colors group" :class="{ 'bg-teal-50/30': selected.includes({{ $user->id }}) }">
                            <td class="px-6 py-4">
                                <input type="checkbox" x-model="selected" value="{{ $user->id }}" class="w-4 h-4 rounded border-slate-300 text-teal-600 focus:ring-teal-500/30 transition-all cursor-pointer">
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-teal-500 to-emerald-600 flex items-center justify-center text-white font-bold text-sm shadow-sm">
                                        {{ substr($user->name, 0, 1) }}
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="text-sm font-bold text-slate-800 group-hover:text-teal-600 transition-colors">{{ $user->name }}</span>
                                        <span class="text-xs text-slate-500 mt-0.5">{{ $user->email }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $roleColors = [
                                        'admin' => 'bg-rose-50 text-rose-600 border-rose-200',
                                        'staff' => 'bg-amber-50 text-amber-600 border-amber-200',
                                        'user' => 'bg-blue-50 text-blue-600 border-blue-200'
                                    ];
                                    $rColor = $roleColors[$user->role] ?? 'bg-slate-50 text-slate-600 border-slate-200';
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold border {{ $rColor }}">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                @if($user->email_verified_at)
                                    <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-emerald-50 border border-emerald-100 text-emerald-600 text-xs font-medium">
                                        <i class="fas fa-check-circle"></i> Verified
                                    </div>
                                @else
                                    <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-slate-50 border border-slate-200 text-slate-500 text-xs font-medium mb-1">
                                        <i class="fas fa-clock"></i> Pending
                                    </div>
                                    <form action="{{ route('admin.users.verify-email', $user->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="text-[10px] font-bold text-teal-600 hover:text-teal-700 hover:underline">
                                            Verify Now
                                        </button>
                                    </form>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm text-slate-500 font-medium">{{ $user->created_at->format('M d, Y') }}</span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.users.show', $user) }}" class="w-8 h-8 rounded-lg bg-white border border-slate-200 flex items-center justify-center text-slate-400 hover:text-teal-600 hover:border-teal-200 hover:bg-teal-50 transition-all shadow-sm" title="View">
                                        <i class="fas fa-eye text-sm"></i>
                                    </a>
                                    <a href="{{ route('admin.users.edit', $user) }}" class="w-8 h-8 rounded-lg bg-white border border-slate-200 flex items-center justify-center text-slate-400 hover:text-blue-600 hover:border-blue-200 hover:bg-blue-50 transition-all shadow-sm" title="Edit">
                                        <i class="fas fa-edit text-sm"></i>
                                    </a>
                                    
                                    @if(!$user->hasVerifiedEmail())
                                        <form action="{{ route('admin.users.verify-email', $user) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="w-8 h-8 rounded-lg bg-white border border-slate-200 flex items-center justify-center text-slate-400 hover:text-emerald-600 hover:border-emerald-200 hover:bg-emerald-50 transition-all shadow-sm" title="Verify Email">
                                                <i class="fas fa-check text-sm"></i>
                                            </button>
                                        </form>
                                    @endif

                                    @if($user->id !== auth()->id())
                                        <button type="button" @click="confirmDelete({{ $user->id }}, '{{ addslashes($user->name) }}')" class="w-8 h-8 rounded-lg bg-white border border-slate-200 flex items-center justify-center text-slate-400 hover:text-rose-600 hover:border-rose-200 hover:bg-rose-50 transition-all shadow-sm" title="Delete">
                                            <i class="fas fa-trash-alt text-sm"></i>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center text-slate-400">
                                    <i class="fas fa-users-slash text-4xl mb-3 text-slate-300"></i>
                                    <p class="text-sm font-medium">No users found.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="p-6 border-t border-slate-100 flex justify-center">
            {{ $users->links('pagination::tailwind') }}
        </div>
    </div>

    <!-- Delete Modal -->
    <div x-show="deleteModalOpen" x-cloak class="fixed inset-0 z-[100] flex items-center justify-center overflow-y-auto overflow-x-hidden bg-slate-900/50 backdrop-blur-sm p-4 text-center sm:p-0">
        <div x-show="deleteModalOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="relative overflow-hidden rounded-2xl bg-white text-left shadow-xl sm:my-8 sm:w-full sm:max-w-lg border border-slate-100" @click.away="deleteModalOpen = false">
            <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-rose-100 sm:mx-0 sm:h-10 sm:w-10">
                        <i class="fas fa-exclamation-triangle text-rose-600"></i>
                    </div>
                    <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                        <h3 class="text-lg font-bold leading-6 text-slate-900" id="modal-title">Delete User</h3>
                        <div class="mt-2">
                            <p class="text-sm text-slate-500">Are you sure you want to delete <strong class="text-slate-800" x-text="userNameToDelete"></strong>? All of their data will be permanently removed. This action cannot be undone.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-slate-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6 border-t border-slate-100">
                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex w-full justify-center rounded-xl bg-rose-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-rose-500 sm:ml-3 sm:w-auto">Delete</button>
                </form>
                <button type="button" @click="deleteModalOpen = false" class="mt-3 inline-flex w-full justify-center rounded-xl bg-white px-3 py-2 text-sm font-semibold text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 hover:bg-slate-50 sm:mt-0 sm:w-auto">Cancel</button>
            </div>
        </div>
    </div>

</div>
@endsection
