@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            <h1 class="text-3xl font-black text-slate-800 tracking-tight">Edit Category</h1>
            <p class="text-slate-500 mt-1">Update details for {{ $category->name }}.</p>
        </div>
        <a href="{{ route('admin.categories.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-white border border-slate-200 text-slate-700 hover:text-teal-600 hover:border-teal-200 hover:bg-teal-50 rounded-xl font-medium transition-all shadow-sm">
            <i class="fas fa-arrow-left text-sm"></i> Back to Categories
        </a>
    </div>

    <div class="max-w-4xl mx-auto grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Main Form -->
        <div class="lg:col-span-2">
            <form method="POST" action="{{ route('admin.categories.update', $category) }}" class="bg-white rounded-3xl shadow-sm border border-slate-100 p-6 md:p-8 relative overflow-hidden h-full">
                <div class="absolute top-0 right-0 w-64 h-64 bg-teal-500/5 rounded-full blur-3xl -z-10"></div>
                
                @csrf
                @method('PATCH')

                <h2 class="text-xl font-bold text-slate-800 mb-6 flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-teal-50 text-teal-600 flex items-center justify-center">
                        <i class="fas fa-edit"></i>
                    </div>
                    Edit Information
                </h2>

                <div class="space-y-6">
                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-semibold text-slate-700 mb-2">Category Name <span class="text-rose-500">*</span></label>
                        <input type="text" id="name" name="name" value="{{ old('name', $category->name) }}" required
                               class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 outline-none transition-all text-slate-700 bg-slate-50 focus:bg-white placeholder-slate-400 @error('name') border-rose-500 @enderror">
                        @error('name')
                            <p class="mt-2 text-sm text-rose-500"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-sm font-semibold text-slate-700 mb-2">Description</label>
                        <textarea id="description" name="description" rows="4"
                                  class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 outline-none transition-all text-slate-700 bg-slate-50 focus:bg-white placeholder-slate-400 @error('description') border-rose-500 @enderror">{{ old('description', $category->description) }}</textarea>
                        @error('description')
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
                    <i class="fas fa-info-circle text-teal-400"></i> Category Details
                </h2>
                
                <div class="space-y-5">
                    <div>
                        <p class="text-slate-400 text-sm font-medium mb-1">Created</p>
                        <p class="text-white font-medium">{{ $category->created_at->format('M d, Y H:i') }}</p>
                    </div>
                    <div>
                        <p class="text-slate-400 text-sm font-medium mb-1">Last Updated</p>
                        <p class="text-white font-medium">{{ $category->updated_at->format('M d, Y H:i') }}</p>
                    </div>
                    <div>
                        <p class="text-slate-400 text-sm font-medium mb-1">Total Complaints</p>
                        <div class="inline-flex items-center justify-center min-w-[2.5rem] h-8 px-3 rounded-full bg-teal-500/20 text-teal-400 font-bold border border-teal-500/30">
                            {{ $category->complaints()->count() }}
                        </div>
                    </div>
                </div>
            </div>
            
            <a href="{{ route('admin.categories.show', $category) }}" class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-white border border-slate-200 text-slate-600 hover:text-teal-600 hover:border-teal-200 hover:bg-teal-50 rounded-2xl font-medium transition-all shadow-sm">
                <i class="fas fa-eye text-sm"></i> View Category Profile
            </a>
        </div>
    </div>
</div>
@endsection
