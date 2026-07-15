<x-app-layout>
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            <a href="{{ route('complaints.index') }}" class="text-sm font-bold text-teal-600 hover:text-teal-700 flex items-center gap-2 mb-2 transition-colors">
                <i class="fas fa-arrow-left"></i> Back to Complaints
            </a>
            <h1 class="text-3xl font-black text-slate-800 tracking-tight">New Complaint</h1>
            <p class="text-slate-500 mt-1">Please provide details about your issue so we can help you.</p>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-3xl">
        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden relative group">
            <!-- Decorative background element -->
            <div class="absolute right-0 top-0 w-64 h-64 bg-teal-500/5 rounded-full blur-3xl group-hover:bg-teal-500/10 transition-colors duration-500 pointer-events-none"></div>
            
            <div class="p-8 relative z-10">
                <form method="POST" action="{{ route('complaints.store') }}" class="space-y-6">
                    @csrf

                    <!-- Category -->
                    <div>
                        <label for="category_id" class="block text-sm font-bold text-slate-700 mb-2">
                            Category <span class="text-rose-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fas fa-tag text-slate-400"></i>
                            </div>
                            <select id="category_id" name="category_id" class="w-full bg-slate-50 border border-slate-200 text-slate-700 rounded-xl pl-11 pr-4 py-3 focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 outline-none transition-all appearance-none font-medium @error('category_id') border-rose-300 focus:border-rose-500 focus:ring-rose-500/20 @enderror" required>
                                <option value="" disabled selected>Select a category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                <i class="fas fa-chevron-down text-slate-400 text-xs"></i>
                            </div>
                        </div>
                        @error('category_id')
                            <p class="text-rose-500 text-sm mt-1.5 font-medium"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Title -->
                    <div>
                        <label for="title" class="block text-sm font-bold text-slate-700 mb-2">
                            Title <span class="text-rose-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fas fa-heading text-slate-400"></i>
                            </div>
                            <input id="title" class="w-full bg-slate-50 border border-slate-200 text-slate-700 rounded-xl pl-11 pr-4 py-3 focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 outline-none transition-all font-medium placeholder-slate-400 @error('title') border-rose-300 focus:border-rose-500 focus:ring-rose-500/20 @enderror" type="text" name="title" value="{{ old('title') }}" required autofocus autocomplete="off" placeholder="Briefly summarize the issue" />
                        </div>
                        @error('title')
                            <p class="text-rose-500 text-sm mt-1.5 font-medium"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-sm font-bold text-slate-700 mb-2">
                            Description <span class="text-rose-500">*</span>
                        </label>
                        <textarea id="description" name="description" rows="5" class="w-full bg-slate-50 border border-slate-200 text-slate-700 rounded-xl px-4 py-3 focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 outline-none transition-all placeholder-slate-400 resize-y @error('description') border-rose-300 focus:border-rose-500 focus:ring-rose-500/20 @enderror" required placeholder="Provide as much detail as possible to help us understand the issue...">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="text-rose-500 text-sm mt-1.5 font-medium"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Priority -->
                    <div>
                        <label for="priority" class="block text-sm font-bold text-slate-700 mb-2">
                            Priority <span class="text-rose-500">*</span>
                        </label>
                        <div class="grid grid-cols-3 gap-4">
                            <!-- Low -->
                            <label class="cursor-pointer relative">
                                <input type="radio" name="priority" value="low" class="peer sr-only" {{ old('priority', 'low') == 'low' ? 'checked' : '' }}>
                                <div class="rounded-xl border border-slate-200 bg-slate-50 p-4 hover:bg-slate-100 transition-all peer-checked:border-emerald-500 peer-checked:bg-emerald-50 peer-checked:ring-1 peer-checked:ring-emerald-500 text-center">
                                    <i class="fas fa-arrow-down text-emerald-500 mb-2 text-xl block"></i>
                                    <span class="font-bold text-slate-700 block text-sm">Low</span>
                                </div>
                            </label>
                            
                            <!-- Medium -->
                            <label class="cursor-pointer relative">
                                <input type="radio" name="priority" value="medium" class="peer sr-only" {{ old('priority') == 'medium' ? 'checked' : '' }}>
                                <div class="rounded-xl border border-slate-200 bg-slate-50 p-4 hover:bg-slate-100 transition-all peer-checked:border-amber-500 peer-checked:bg-amber-50 peer-checked:ring-1 peer-checked:ring-amber-500 text-center">
                                    <i class="fas fa-minus text-amber-500 mb-2 text-xl block"></i>
                                    <span class="font-bold text-slate-700 block text-sm">Medium</span>
                                </div>
                            </label>

                            <!-- High -->
                            <label class="cursor-pointer relative">
                                <input type="radio" name="priority" value="high" class="peer sr-only" {{ old('priority') == 'high' ? 'checked' : '' }}>
                                <div class="rounded-xl border border-slate-200 bg-slate-50 p-4 hover:bg-slate-100 transition-all peer-checked:border-rose-500 peer-checked:bg-rose-50 peer-checked:ring-1 peer-checked:ring-rose-500 text-center">
                                    <i class="fas fa-arrow-up text-rose-500 mb-2 text-xl block"></i>
                                    <span class="font-bold text-slate-700 block text-sm">High</span>
                                </div>
                            </label>
                        </div>
                        @error('priority')
                            <p class="text-rose-500 text-sm mt-1.5 font-medium"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="pt-6 border-t border-slate-100 flex items-center justify-end gap-3">
                        <a href="{{ route('complaints.index') }}" class="px-6 py-2.5 bg-white border border-slate-200 text-slate-600 rounded-xl hover:bg-slate-50 transition-colors font-medium">
                            Cancel
                        </a>
                        <button type="submit" class="px-8 py-2.5 bg-gradient-to-r from-teal-500 to-emerald-500 hover:from-teal-600 hover:to-emerald-600 text-white rounded-xl transition-all shadow-[0_8px_20px_-6px_rgba(16,185,129,0.4)] font-bold flex items-center gap-2">
                            <span>Submit Complaint</span>
                            <i class="fas fa-paper-plane text-sm"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
