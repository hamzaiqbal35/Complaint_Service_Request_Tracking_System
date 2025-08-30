@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">User Details</h1>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-primary">
                <i class="fas fa-edit"></i> Edit User
            </a>
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Users
            </a>
        </div>
    </div>

    <div class="row">
        <!-- User Information -->
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">User Information</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Name:</strong></td>
                                    <td>{{ $user->name }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Email:</strong></td>
                                    <td>{{ $user->email }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Role:</strong></td>
                                    <td>
                                        <span class="badge badge-{{ $user->role == 'admin' ? 'danger' : ($user->role == 'staff' ? 'warning' : 'info') }}">
                                            {{ ucfirst($user->role) }}
                                        </span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Email Verified:</strong></td>
                                    <td>
                                        @if($user->email_verified_at)
                                            <span class="badge badge-success">Verified</span>
                                            <br><small class="text-muted">{{ $user->email_verified_at->format('M d, Y H:i') }}</small>
                                        @else
                                            <span class="badge badge-secondary">Not Verified</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Created:</strong></td>
                                    <td>{{ $user->created_at->format('M d, Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Last Updated:</strong></td>
                                    <td>{{ $user->updated_at->format('M d, Y H:i') }}</td>
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
                    <h6 class="m-0 font-weight-bold text-primary">Activity Statistics</h6>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-12 mb-3">
                            <div class="border-left-primary p-3">
                                <div class="text-primary font-weight-bold">{{ $complaintsCreated }}</div>
                                <div class="text-xs text-uppercase">Complaints Created</div>
                            </div>
                        </div>
                        @if($user->role === 'staff')
                            <div class="col-12 mb-3">
                                <div class="border-left-warning p-3">
                                    <div class="text-warning font-weight-bold">{{ $complaintsAssigned }}</div>
                                    <div class="text-xs text-uppercase">Complaints Assigned</div>
                                </div>
                            </div>
                            <div class="col-12 mb-3">
                                <div class="border-left-success p-3">
                                    <div class="text-success font-weight-bold">{{ $complaintsResolved }}</div>
                                    <div class="text-xs text-uppercase">Complaints Resolved</div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    @if($user->role === 'user' && $user->complaints->count() > 0)
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Recent Complaints Created</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Title</th>
                                <th>Category</th>
                                <th>Priority</th>
                                <th>Status</th>
                                <th>Created At</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($user->complaints()->latest()->limit(5)->get() as $complaint)
                                <tr>
                                    <td>{{ $complaint->id }}</td>
                                    <td>{{ Str::limit($complaint->title, 30) }}</td>
                                    <td>{{ $complaint->category->name ?? 'N/A' }}</td>
                                    <td>
                                        <span class="badge badge-{{ $complaint->priority == 'high' ? 'danger' : ($complaint->priority == 'medium' ? 'warning' : 'secondary') }}">
                                            {{ ucfirst($complaint->priority) }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge badge-{{ $complaint->status == 'resolved' ? 'success' : ($complaint->status == 'in_progress' ? 'info' : ($complaint->status == 'rejected' ? 'danger' : 'warning')) }}">
                                            {{ ucfirst(str_replace('_', ' ', $complaint->status)) }}
                                        </span>
                                    </td>
                                    <td>{{ $complaint->created_at->format('M d, Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif

    @if($user->role === 'staff' && $user->assignedComplaints->count() > 0)
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Recent Assigned Complaints</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Title</th>
                                <th>Category</th>
                                <th>Priority</th>
                                <th>Status</th>
                                <th>Created By</th>
                                <th>Assigned At</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($user->assignedComplaints()->latest()->limit(5)->get() as $complaint)
                                <tr>
                                    <td>{{ $complaint->id }}</td>
                                    <td>{{ Str::limit($complaint->title, 30) }}</td>
                                    <td>{{ $complaint->category->name ?? 'N/A' }}</td>
                                    <td>
                                        <span class="badge badge-{{ $complaint->priority == 'high' ? 'danger' : ($complaint->priority == 'medium' ? 'warning' : 'secondary') }}">
                                            {{ ucfirst($complaint->priority) }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge badge-{{ $complaint->status == 'resolved' ? 'success' : ($complaint->status == 'in_progress' ? 'info' : ($complaint->status == 'rejected' ? 'danger' : 'warning')) }}">
                                            {{ ucfirst(str_replace('_', ' ', $complaint->status)) }}
                                        </span>
                                    </td>
                                    <td>{{ $complaint->creator->name ?? 'N/A' }}</td>
                                    <td>{{ $complaint->updated_at->format('M d, Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
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
