@extends('layouts.admin')

@section('admin')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4 mt-4">
        <h1 class="h3 mb-0 text-gray-800">Category Details</h1>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-primary">
                <i class="fas fa-edit"></i> Edit Category
            </a>
            <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Categories
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Category Information -->
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Category Information</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Name:</strong></td>
                                    <td>{{ $category->name }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Description:</strong></td>
                                    <td>{{ $category->description ?? 'No description provided' }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Created:</strong></td>
                                    <td>{{ $category->created_at->format('M d, Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Last Updated:</strong></td>
                                    <td>{{ $category->updated_at->format('M d, Y H:i') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics -->
        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Statistics</h6>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-12 mb-3">
                            <div class="border-left-primary p-3">
                                <div class="text-primary font-weight-bold">{{ $complaintsCount }}</div>
                                <div class="text-xs text-uppercase">Total Complaints</div>
                            </div>
                        </div>
                        <div class="col-12 mb-3">
                            <div class="border-left-warning p-3">
                                <div class="text-warning font-weight-bold">{{ $pendingCount }}</div>
                                <div class="text-xs text-uppercase">Pending Complaints</div>
                            </div>
                        </div>
                        <div class="col-12 mb-3">
                            <div class="border-left-success p-3">
                                <div class="text-success font-weight-bold">{{ $resolvedCount }}</div>
                                <div class="text-xs text-uppercase">Resolved Complaints</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Complaints -->
    @if($category->complaints->count() > 0)
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Recent Complaints in this Category</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Title</th>
                                <th>Priority</th>
                                <th>Status</th>
                                <th>Created By</th>
                                <th>Assigned To</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($category->complaints as $complaint)
                                <tr>
                                    <td>{{ $complaint->id }}</td>
                                    <td>{{ Str::limit($complaint->title, 30) }}</td>
                                    <td>
                                        <span class="badge bg-{{ $complaint->priority == 'high' ? 'danger' : ($complaint->priority == 'medium' ? 'warning' : 'secondary') }} text-white">
                                            {{ ucfirst($complaint->priority) }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $complaint->status == 'resolved' ? 'success' : ($complaint->status == 'in_progress' ? 'info' : ($complaint->status == 'rejected' ? 'danger' : 'warning')) }} text-white">
                                            {{ ucfirst(str_replace('_', ' ', $complaint->status)) }}
                                        </span>
                                    </td>
                                    <td>{{ $complaint->creator->name ?? 'N/A' }}</td>
                                    <td>{{ $complaint->assignee->name ?? 'Unassigned' }}</td>
                                    <td>{{ $complaint->created_at->format('M d, Y') }}</td>
                                    <td>
                                        <a href="{{ route('admin.complaints.show', $complaint) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.complaints.edit', $complaint) }}" class="btn btn-sm btn-primary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                @if($complaintsCount > 10)
                    <div class="text-center mt-3">
                        <a href="{{ route('admin.complaints.index', ['category_id' => $category->id]) }}" class="btn btn-outline-primary">
                            View All {{ $complaintsCount }} Complaints in this Category
                        </a>
                    </div>
                @endif
            </div>
        </div>
    @else
        <div class="card shadow mb-4">
            <div class="card-body text-center">
                <i class="fas fa-inbox fa-3x text-gray-300 mb-3"></i>
                <h5 class="text-gray-600">No Complaints Yet</h5>
                <p class="text-gray-500">This category doesn't have any complaints associated with it yet.</p>
            </div>
        </div>
    @endif
</div>

<style>
.border-left-primary {
    border-left: 0.25rem solid #4e73df !important;
}

.border-left-success {
    border-left: 0.25rem solid #1cc88a !important;
}

.border-left-warning {
    border-left: 0.25rem solid #f6c23e !important;
}

.badge {
    font-size: 0.75em;
}
</style>
@endsection
