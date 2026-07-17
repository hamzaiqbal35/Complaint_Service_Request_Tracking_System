@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            <h1 class="text-3xl font-black text-slate-800 tracking-tight">Create New User</h1>
            <p class="text-slate-500 mt-1">Add a new user to the system and assign their role.</p>
        </div>
        <a href="{{ route('admin.users.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-white border border-slate-200 text-slate-700 hover:text-teal-600 hover:border-teal-200 hover:bg-teal-50 rounded-xl font-medium transition-all shadow-sm">
            <i class="fas fa-arrow-left text-sm"></i> Back to Users
        </a>
    </div>

    <div class="max-w-4xl mx-auto">
        <form method="POST" action="{{ route('admin.users.store') }}" class="bg-white rounded-3xl shadow-sm border border-slate-100 p-6 md:p-10 relative overflow-hidden">
            <!-- Decorative blur -->
            <div class="absolute top-0 right-0 w-64 h-64 bg-teal-500/5 rounded-full blur-3xl -z-10"></div>
            
            @csrf

            <h2 class="text-xl font-bold text-slate-800 mb-6 flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-teal-50 text-teal-600 flex items-center justify-center">
                    <i class="fas fa-user-plus"></i>
                </div>
                User Information
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <!-- Full Name -->
                <div>
                    <label for="name" class="block text-sm font-semibold text-slate-700 mb-2">Full Name <span class="text-rose-500">*</span></label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required
                           class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 outline-none transition-all text-slate-700 bg-slate-50 focus:bg-white placeholder-slate-400 @error('name') border-rose-500 focus:ring-rose-500/20 focus:border-rose-500 @enderror"
                           placeholder="John Doe">
                    @error('name')
                        <p class="mt-2 text-sm text-rose-500"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-semibold text-slate-700 mb-2">Email Address <span class="text-rose-500">*</span></label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required
                           class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 outline-none transition-all text-slate-700 bg-slate-50 focus:bg-white placeholder-slate-400 @error('email') border-rose-500 focus:ring-rose-500/20 focus:border-rose-500 @enderror"
                           placeholder="john@example.com">
                    @error('email')
                        <p class="mt-2 text-sm text-rose-500"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div x-data="{ show: false }">
                    <label for="password" class="block text-sm font-semibold text-slate-700 mb-2">Password <span class="text-rose-500">*</span></label>
                    <div class="relative">
                        <input x-bind:type="show ? 'text' : 'password'" id="password" name="password" required
                               class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 outline-none transition-all text-slate-700 bg-slate-50 focus:bg-white placeholder-slate-400 pr-12 @error('password') border-rose-500 focus:ring-rose-500/20 focus:border-rose-500 @enderror"
                               placeholder="••••••••">
                        <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-teal-600 focus:outline-none transition-colors">
                            <i class="fas fa-fw" :class="show ? 'fa-eye-slash' : 'fa-eye'"></i>
                        </button>
                    </div>
                    @error('password')
                        <p class="mt-2 text-sm text-rose-500"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div x-data="{ show: false }">
                    <label for="password_confirmation" class="block text-sm font-semibold text-slate-700 mb-2">Confirm Password <span class="text-rose-500">*</span></label>
                    <div class="relative">
                        <input x-bind:type="show ? 'text' : 'password'" id="password_confirmation" name="password_confirmation" required
                               class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 outline-none transition-all text-slate-700 bg-slate-50 focus:bg-white placeholder-slate-400 pr-12"
                               placeholder="••••••••">
                        <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-teal-600 focus:outline-none transition-colors">
                            <i class="fas fa-fw" :class="show ? 'fa-eye-slash' : 'fa-eye'"></i>
                        </button>
                    </div>
                </div>
                
                <!-- Role -->
                <div class="md:col-span-2">
                    <label for="role" class="block text-sm font-semibold text-slate-700 mb-2">Role <span class="text-rose-500">*</span></label>
                    <div class="relative">
                        <select id="role" name="role" required
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 outline-none transition-all text-slate-700 bg-slate-50 focus:bg-white appearance-none @error('role') border-rose-500 focus:ring-rose-500/20 focus:border-rose-500 @enderror">
                            <option value="">Select Role</option>
                            <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>User</option>
                            <option value="staff" {{ old('role') == 'staff' ? 'selected' : '' }}>Staff</option>
                            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                        <!-- Custom select chevron -->
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-slate-500">
                            <i class="fas fa-chevron-down text-sm"></i>
                        </div>
                    </div>
                    @error('role')
                        <p class="mt-2 text-sm text-rose-500"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Role Permissions Info -->
            <div class="bg-blue-50/50 border border-blue-100 rounded-2xl p-5 mb-8">
                <div class="flex items-start gap-3">
                    <i class="fas fa-info-circle text-blue-500 mt-1"></i>
                    <div>
                        <h4 class="text-sm font-bold text-blue-900 mb-2">Role Permissions:</h4>
                        <ul class="text-sm text-blue-800/80 space-y-1.5 list-disc list-inside">
                            <li><strong class="text-blue-900">User:</strong> Can create and view their own complaints</li>
                            <li><strong class="text-blue-900">Staff:</strong> Can view and manage assigned complaints</li>
                            <li><strong class="text-blue-900">Admin:</strong> Can manage all complaints, users, and system settings</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-6 border-t border-slate-100">
                <a href="{{ route('admin.users.index') }}" class="px-6 py-3 rounded-xl font-medium text-slate-600 bg-slate-100 hover:bg-slate-200 transition-colors">Cancel</a>
                <button type="submit" class="px-6 py-3 rounded-xl font-medium text-white bg-gradient-to-r from-teal-500 to-emerald-600 hover:from-teal-600 hover:to-emerald-700 transition-all shadow-md shadow-teal-500/20 flex items-center gap-2">
                    <i class="fas fa-save"></i> Create User
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
