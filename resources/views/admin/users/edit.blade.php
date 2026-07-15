@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            <h1 class="text-3xl font-black text-slate-800 tracking-tight">Edit User</h1>
            <p class="text-slate-500 mt-1">Update details and role for {{ $user->name }}.</p>
        </div>
        <a href="{{ route('admin.users.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-white border border-slate-200 text-slate-700 hover:text-teal-600 hover:border-teal-200 hover:bg-teal-50 rounded-xl font-medium transition-all shadow-sm">
            <i class="fas fa-arrow-left text-sm"></i> Back to Users
        </a>
    </div>

    <div class="max-w-4xl mx-auto grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Main Form -->
        <div class="lg:col-span-2">
            <form method="POST" action="{{ route('admin.users.update', $user) }}" class="bg-white rounded-3xl shadow-sm border border-slate-100 p-6 md:p-8 relative overflow-hidden h-full">
                <div class="absolute top-0 right-0 w-64 h-64 bg-teal-500/5 rounded-full blur-3xl -z-10"></div>
                
                @csrf
                @method('PUT')

                <h2 class="text-xl font-bold text-slate-800 mb-6 flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-teal-50 text-teal-600 flex items-center justify-center">
                        <i class="fas fa-user-edit"></i>
                    </div>
                    Edit User Information
                </h2>

                <div class="space-y-6">
                    <!-- Full Name -->
                    <div>
                        <label for="name" class="block text-sm font-semibold text-slate-700 mb-2">Full Name <span class="text-rose-500">*</span></label>
                        <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required
                               class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 outline-none transition-all text-slate-700 bg-slate-50 focus:bg-white placeholder-slate-400 @error('name') border-rose-500 @enderror">
                        @error('name')
                            <p class="mt-2 text-sm text-rose-500"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-semibold text-slate-700 mb-2">Email Address <span class="text-rose-500">*</span></label>
                        <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required
                               class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 outline-none transition-all text-slate-700 bg-slate-50 focus:bg-white placeholder-slate-400 @error('email') border-rose-500 @enderror">
                        @error('email')
                            <p class="mt-2 text-sm text-rose-500"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Password -->
                        <div>
                            <label for="password" class="block text-sm font-semibold text-slate-700 mb-2">New Password <span class="text-slate-400 font-normal">(leave blank to keep current)</span></label>
                            <input type="password" id="password" name="password"
                                   class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 outline-none transition-all text-slate-700 bg-slate-50 focus:bg-white @error('password') border-rose-500 @enderror"
                                   placeholder="••••••••">
                            @error('password')
                                <p class="mt-2 text-sm text-rose-500"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div>
                            <label for="password_confirmation" class="block text-sm font-semibold text-slate-700 mb-2">Confirm New Password</label>
                            <input type="password" id="password_confirmation" name="password_confirmation"
                                   class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 outline-none transition-all text-slate-700 bg-slate-50 focus:bg-white"
                                   placeholder="••••••••">
                        </div>
                    </div>
                    
                    <!-- Role -->
                    <div>
                        <label for="role" class="block text-sm font-semibold text-slate-700 mb-2">Role <span class="text-rose-500">*</span></label>
                        <div class="relative">
                            <select id="role" name="role" required
                                    class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 outline-none transition-all text-slate-700 bg-slate-50 focus:bg-white appearance-none @error('role') border-rose-500 @enderror">
                                <option value="user" {{ old('role', $user->role) == 'user' ? 'selected' : '' }}>User</option>
                                <option value="staff" {{ old('role', $user->role) == 'staff' ? 'selected' : '' }}>Staff</option>
                                <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-slate-500">
                                <i class="fas fa-chevron-down text-sm"></i>
                            </div>
                        </div>
                        @error('role')
                            <p class="mt-2 text-sm text-rose-500"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex justify-end gap-3 pt-8 mt-8 border-t border-slate-100">
                    <button type="submit" class="px-6 py-3 rounded-xl font-medium text-white bg-gradient-to-r from-teal-500 to-emerald-600 hover:from-teal-600 hover:to-emerald-700 transition-all shadow-md shadow-teal-500/20 flex items-center gap-2">
                        <i class="fas fa-save"></i> Save Changes
                    </button>
                </div>
            </form>
        </div>

        <!-- Sidebar Info -->
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-slate-900 rounded-3xl shadow-[0_15px_40px_-10px_rgba(15,23,42,0.4)] border border-slate-800 p-6 md:p-8 relative overflow-hidden">
                <div class="absolute right-[-20%] bottom-[-20%] w-64 h-64 bg-teal-500/10 rounded-full blur-3xl"></div>
                <h2 class="text-lg font-bold text-white mb-6 flex items-center gap-2">
                    <i class="fas fa-info-circle text-teal-400"></i> User Details
                </h2>
                
                <div class="space-y-5">
                    <div>
                        <p class="text-slate-400 text-sm font-medium mb-1">Created At</p>
                        <p class="text-white font-medium">{{ $user->created_at->format('M d, Y H:i') }}</p>
                    </div>
                    <div>
                        <p class="text-slate-400 text-sm font-medium mb-1">Last Updated</p>
                        <p class="text-white font-medium">{{ $user->updated_at->format('M d, Y H:i') }}</p>
                    </div>
                    <div>
                        <p class="text-slate-400 text-sm font-medium mb-1">Status</p>
                        @if($user->email_verified_at)
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 text-xs font-bold">
                                <i class="fas fa-check-circle"></i> Verified
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-slate-500/10 text-slate-400 border border-slate-500/20 text-xs font-bold">
                                <i class="fas fa-clock"></i> Unverified
                            </span>
                        @endif
                    </div>
                </div>
            </div>
            
            <a href="{{ route('admin.users.show', $user) }}" class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-white border border-slate-200 text-slate-600 hover:text-teal-600 hover:border-teal-200 hover:bg-teal-50 rounded-2xl font-medium transition-all shadow-sm">
                <i class="fas fa-eye text-sm"></i> View User Profile
            </a>
        </div>
    </div>
</div>
@endsection
