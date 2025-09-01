@extends('layouts.admin')

@section('admin')
<div class="container mx-auto px-4">
    <!-- Modified header section to remove arrow -->
    <div class="flex justify-between items-center mb-6 mt-4">
        <h1 class="text-2xl font-bold text-gray-900">Complaints Management</h1>
    </div>

    @if(session('success'))
        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white shadow overflow-hidden sm:rounded-md">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Priority</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created By</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Assigned To</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($complaints as $complaint)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">#{{ $complaint->id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $complaint->title }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $complaint->category->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $priorityClasses = [
                                        'high' => 'badge bg-danger',
                                        'medium' => 'badge bg-warning',
                                        'low' => 'badge bg-success'
                                    ];
                                    $priorityClass = $priorityClasses[$complaint->priority] ?? 'badge bg-secondary';
                                @endphp
                                <span class="{{ $priorityClass }}">
                                    {{ ucfirst($complaint->priority) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $statusClasses = [
                                        'pending' => 'badge bg-warning',
                                        'in_progress' => 'badge bg-info',
                                        'resolved' => 'badge bg-success',
                                        'rejected' => 'badge bg-danger'
                                    ];
                                    $statusClass = $statusClasses[$complaint->status] ?? 'badge bg-secondary';
                                @endphp
                                <span class="{{ $statusClass }}">
                                    {{ ucfirst(str_replace('_', ' ', $complaint->status)) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $complaint->creator->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $complaint->assignee ? $complaint->assignee->name : 'Unassigned' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $complaint->created_at->format('M d, Y') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="{{ route('admin.complaints.edit', $complaint) }}" class="text-blue-600 hover:text-blue-900 mr-3">Manage</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                No complaints found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($complaints->hasPages())
        <div class="mt-4">
            {{ $complaints->links() }}
        </div>
    @endif
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
</style>
@endsection
