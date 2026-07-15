@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            <h1 class="text-3xl font-black text-slate-800 tracking-tight">Create New Category</h1>
            <p class="text-slate-500 mt-1">Define a new category for complaint classification.</p>
        </div>
        <a href="{{ route('admin.categories.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-white border border-slate-200 text-slate-700 hover:text-teal-600 hover:border-teal-200 hover:bg-teal-50 rounded-xl font-medium transition-all shadow-sm">
            <i class="fas fa-arrow-left text-sm"></i> Back to Categories
        </a>
    </div>

    <div class="max-w-4xl mx-auto">
        <form method="POST" action="{{ route('admin.categories.store') }}" class="bg-white rounded-3xl shadow-sm border border-slate-100 p-6 md:p-10 relative overflow-hidden">
            <!-- Decorative blur -->
            <div class="absolute top-0 right-0 w-64 h-64 bg-teal-500/5 rounded-full blur-3xl -z-10"></div>
            
            @csrf

            <h2 class="text-xl font-bold text-slate-800 mb-6 flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-teal-50 text-teal-600 flex items-center justify-center">
                    <i class="fas fa-tags"></i>
                </div>
                Category Information
            </h2>

            <div class="space-y-6 mb-8">
                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-semibold text-slate-700 mb-2">Category Name <span class="text-rose-500">*</span></label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required
                           class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 outline-none transition-all text-slate-700 bg-slate-50 focus:bg-white placeholder-slate-400 @error('name') border-rose-500 focus:ring-rose-500/20 focus:border-rose-500 @enderror"
                           placeholder="e.g. IT Support">
                    @error('name')
                        <p class="mt-2 text-sm text-rose-500"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-semibold text-slate-700 mb-2">Description <span class="text-slate-400 font-normal">(optional)</span></label>
                    <textarea id="description" name="description" rows="4"
                              class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 outline-none transition-all text-slate-700 bg-slate-50 focus:bg-white placeholder-slate-400 @error('description') border-rose-500 @enderror"
                              placeholder="Describe what types of complaints fall under this category...">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-2 text-sm text-rose-500"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Info Box -->
            <div class="bg-blue-50/50 border border-blue-100 rounded-2xl p-5 mb-8">
                <div class="flex items-start gap-3">
                    <i class="fas fa-info-circle text-blue-500 mt-1"></i>
                    <div>
                        <h4 class="text-sm font-bold text-blue-900 mb-2">Category Examples:</h4>
                        <ul class="text-sm text-blue-800/80 space-y-1.5 list-disc list-inside">
                            <li><strong class="text-blue-900">HR:</strong> Human Resources related complaints</li>
                            <li><strong class="text-blue-900">IT:</strong> Information Technology issues</li>
                            <li><strong class="text-blue-900">Finance:</strong> Financial and accounting matters</li>
                            <li><strong class="text-blue-900">Facilities:</strong> Building and maintenance issues</li>
                            <li><strong class="text-blue-900">General:</strong> Other general complaints</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-6 border-t border-slate-100">
                <a href="{{ route('admin.categories.index') }}" class="px-6 py-3 rounded-xl font-medium text-slate-600 bg-slate-100 hover:bg-slate-200 transition-colors">Cancel</a>
                <button type="submit" class="px-6 py-3 rounded-xl font-medium text-white bg-gradient-to-r from-teal-500 to-emerald-600 hover:from-teal-600 hover:to-emerald-700 transition-all shadow-md shadow-teal-500/20 flex items-center gap-2">
                    <i class="fas fa-save"></i> Create Category
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
