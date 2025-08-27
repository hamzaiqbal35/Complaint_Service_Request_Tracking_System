<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl">New Complaint</h2></x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg p-6">
                <form method="POST" action="{{ route('complaints.store') }}">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-medium">Category</label>
                        <select name="category_id" class="mt-1 block w-full border rounded">
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium">Title</label>
                        <input name="title" class="mt-1 block w-full border rounded" />
                        @error('title') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium">Description</label>
                        <textarea name="description" rows="5" class="mt-1 block w-full border rounded"></textarea>
                        @error('description') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                    </div>
                    <div class="mb-6">
                        <label class="block text-sm font-medium">Priority</label>
                        <select name="priority" class="mt-1 block w-full border rounded">
                            <option>low</option><option selected>medium</option><option>high</option>
                        </select>
                    </div>
                    <div class="text-right">
                        <button class="px-4 py-2 bg-blue-600 text-white rounded">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>


