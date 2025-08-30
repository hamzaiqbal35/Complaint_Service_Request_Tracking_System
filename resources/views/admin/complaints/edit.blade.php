@extends('layouts.admin')

@section('content')  <!-- Change from @section('admin') to @section('content') -->
<div class="container mx-auto px-4">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Manage Complaint #{{ $complaint->id }}</h1>
        <a href="{{ route('admin.complaints.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md text-sm font-medium">
            Back to List
        </a>
    </div>

    @if(session('success'))
        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Complaint Details -->
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="p-6">
                <h3 class="text-lg font-semibold mb-4">Complaint Details</h3>
                
                <div class="space-y-4">
                    <div>
                        <span class="block text-sm font-medium text-gray-700">Title</span>
                        <p class="mt-1 text-sm text-gray-900">{{ $complaint->title }}</p>
                    </div>
                    
                    <div>
                        <span class="block text-sm font-medium text-gray-700">Description</span>
                        <p class="mt-1 text-sm text-gray-900">{{ $complaint->description }}</p>
                    </div>
                    
                    <div>
                        <span class="block text-sm font-medium text-gray-700">Category</span>
                        <p class="mt-1 text-sm text-gray-900">{{ $complaint->category->name }}</p>
                    </div>
                    
                    <div>
                        <span class="block text-sm font-medium text-gray-700">Priority</span>
                        @php
                            $priorityClasses = [
                                'high' => 'badge bg-danger',
                                'medium' => 'badge bg-warning',
                                'low' => 'badge bg-success'
                            ];
                            $priorityClass = $priorityClasses[$complaint->priority] ?? 'badge bg-secondary';
                        @endphp
                        <span class="mt-1 {{ $priorityClass }}">
                            {{ ucfirst($complaint->priority) }}
                        </span>
                    </div>
                    
                    <div>
                        <span class="block text-sm font-medium text-gray-700">Created By</span>
                        <p class="mt-1 text-sm text-gray-900">{{ $complaint->creator->name }}</p>
                    </div>
                    
                    <div>
                        <span class="block text-sm font-medium text-gray-700">Created At</span>
                        <p class="mt-1 text-sm text-gray-900">{{ $complaint->created_at->format('M d, Y H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Management Actions -->
        <div class="space-y-6">
            <!-- Assign Staff -->
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Assign Staff</h3>
                    
                    <form method="POST" action="{{ route('admin.complaints.assign', $complaint) }}">
                        @csrf
                        @method('PATCH')
                        
                        <div class="mb-4">
                            <label for="assigned_to" class="block text-sm font-medium text-gray-700">Assign to Staff</label>
                            <select name="assigned_to" id="assigned_to" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Unassigned</option>
                                @foreach($staff as $member)
                                    <option value="{{ $member->id }}" {{ $complaint->assigned_to == $member->id ? 'selected' : '' }}>
                                        {{ $member->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-black bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <i class="fas fa-user-plus mr-2"></i>
                            Update Assignment
                        </button>
                    </form>
                </div>
            </div>

            <!-- Update Status -->
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Update Status</h3>
                    
                    <form method="POST" action="{{ route('admin.complaints.update-status', $complaint) }}">
                        @csrf
                        @method('PATCH')
                        
                        <div class="mb-4">
                            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                            <select name="status" id="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                <option value="pending" {{ $complaint->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="in_progress" {{ $complaint->status === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="resolved" {{ $complaint->status === 'resolved' ? 'selected' : '' }}>Resolved</option>
                                <option value="rejected" {{ $complaint->status === 'rejected' ? 'selected' : '' }}>Rejected</option>
                            </select>
                        </div>
                        
                        <div class="mb-4">
                            <label for="message" class="block text-sm font-medium text-gray-700">Message (Optional)</label>
                            <textarea name="message" id="message" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" placeholder="Add a note about this status change..."></textarea>
                        </div>
                        
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-black bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            <i class="fas fa-sync-alt mr-2"></i>
                            Update Status
                        </button>
                    </form>
                </div>
            </div>

            <!-- Current Status -->
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Current Status</h3>
                    
                    <div class="space-y-3">
                        <div>
                            <span class="block text-sm font-medium text-gray-700">Status</span>
                            @php
                                $statusClasses = [
                                    'pending' => 'badge bg-warning',
                                    'in_progress' => 'badge bg-info',
                                    'resolved' => 'badge bg-success',
                                    'rejected' => 'badge bg-danger'
                                ];
                                $statusClass = $statusClasses[$complaint->status] ?? 'badge bg-secondary';
                            @endphp
                            <span class="mt-1 {{ $statusClass }}">
                                {{ ucfirst(str_replace('_', ' ', $complaint->status)) }}
                            </span>
                        </div>
                        
                        <div>
                            <span class="block text-sm font-medium text-gray-700">Assigned To</span>
                            <p class="mt-1 text-sm text-gray-900">{{ $complaint->assignee ? $complaint->assignee->name : 'Unassigned' }}</p>
                        </div>
                        
                        @if($complaint->resolved_at)
                            <div>
                                <span class="block text-sm font-medium text-gray-700">Resolved At</span>
                                <p class="mt-1 text-sm text-gray-900">{{ $complaint->resolved_at->format('M d, Y H:i') }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.badge {
    display: inline-block;
    padding: 0.35em 0.65em;
    font-size: 0.75em;
    font-weight: 700;
    line-height: 1;
    color: #fff;
    text-align: center;
    white-space: nowrap;
    vertical-align: baseline;
    border-radius: 0.25rem;
}

.bg-info {
    background-color: #36b9cc !important;
}

.bg-warning {
    background-color: #f6c23e !important;
}

.bg-danger {
    background-color: #e74a3b !important;
}

.bg-success {
    background-color: #1cc88a !important;
}

.bg-secondary {
    background-color: #858796 !important;
}

button {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-height: 2.5rem;
    margin-top: 0.5rem;
    transition: all 0.2s;
    width: auto !important;
    min-width: 150px;
}

button:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

button:active {
    transform: translateY(0);
}

.fas {
    display: inline-block;
    line-height: 1;
}
</style>
@endsection
