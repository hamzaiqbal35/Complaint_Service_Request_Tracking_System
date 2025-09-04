@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4 mt-3">
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
                                        <span class="badge bg-{{ $user->role === 'admin' ? 'danger' : ($user->role === 'staff' ? 'warning' : 'info') }} text-white">
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
                                            <span class="badge bg-success">Verified</span>
                                            <br><small class="text-muted">{{ $user->email_verified_at->format('M d, Y H:i') }}</small>
                                        @else
                                            <span class="badge bg-secondary">Not Verified</span>
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
                            <div class="border-start border-primary border-3 p-3 rounded-4 rounded-4">
                                <div class="text-primary fw-bold">{{ $complaintsCreated ?? 0 }}</div>
                                <div class="text-uppercase small">Complaints Created</div>
                            </div>
                        </div>
                        @if($user->role === 'staff')
                            <div class="col-12 mb-3">
                                <div class="border-start border-warning border-3 p-3 rounded-4">
                                    <div class="text-warning fw-bold">{{ $complaintsAssigned ?? 0 }}</div>
                                    <div class="text-uppercase small">Complaints Assigned</div>
                                </div>
                            </div>
                            <div class="col-12 mb-3">
                                <div class="border-start border-success border-3 p-3 rounded-4">
                                    <div class="text-success fw-bold">{{ $complaintsResolved ?? 0 }}</div>
                                    <div class="text-uppercase small">Complaints Resolved</div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    @if($user->role === 'user' && ($complaintsCreated ?? 0) > 0)
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
                                        <span class="badge bg-{{ $complaint->priority === 'high' ? 'danger' : ($complaint->priority === 'medium' ? 'warning' : 'secondary') }}">
                                            {{ ucfirst($complaint->priority) }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $complaint->status === 'resolved' ? 'success' : ($complaint->status === 'in_progress' ? 'info' : ($complaint->status === 'rejected' ? 'danger' : 'warning')) }}">
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

    @if($user->role === 'staff' && ($complaintsAssigned ?? 0) > 0)
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
                                        <span class="badge bg-{{ $complaint->priority === 'high' ? 'danger' : ($complaint->priority === 'medium' ? 'warning' : 'secondary') }}">
                                            {{ ucfirst($complaint->priority) }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $complaint->status === 'resolved' ? 'success' : ($complaint->status === 'in_progress' ? 'info' : ($complaint->status === 'rejected' ? 'danger' : 'warning')) }}">
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
    .border-left-primary { border-left-color: #4e73df !important; }
    .border-left-warning { border-left-color: #f6c23e !important; }
    .border-left-success { border-left-color: #1cc88a !important; }
</style>
@endsection
