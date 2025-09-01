@extends('layouts.admin')

@section('admin')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4 mt-4">
        <h1 class="h3 mb-0 text-gray-800">Complaint Details #{{ $complaint->id }}</h1>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.complaints.edit', $complaint) }}" class="btn btn-primary">
                <i class="fas fa-edit"></i> Edit
            </a>
            <a href="{{ route('admin.complaints.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to List
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Complaint Information -->
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Complaint Information</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Title:</strong></td>
                                    <td>{{ $complaint->title }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Category:</strong></td>
                                    <td>{{ $complaint->category->name ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Priority:</strong></td>
                                    <td>
                                        <span class="badge bg-{{ $complaint->priority == 'high' ? 'danger' : ($complaint->priority == 'medium' ? 'warning' : 'secondary') }} text-white">
                                            {{ ucfirst($complaint->priority) }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Status:</strong></td>
                                    <td>
                                        <span class="badge bg-{{ $complaint->status == 'resolved' ? 'success' : ($complaint->status == 'in_progress' ? 'info' : ($complaint->status == 'rejected' ? 'danger' : 'warning')) }} text-white">
                                            {{ ucfirst(str_replace('_', ' ', $complaint->status)) }}
                                        </span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Created By:</strong></td>
                                    <td>{{ $complaint->creator->name ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Assigned To:</strong></td>
                                    <td>{{ $complaint->assignee->name ?? 'Unassigned' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Created At:</strong></td>
                                    <td>{{ $complaint->created_at->format('M d, Y H:i') }}</td>
                                </tr>
                                @if($complaint->resolved_at)
                                <tr>
                                    <td><strong>Resolved At:</strong></td>
                                    <td>{{ $complaint->resolved_at->format('M d, Y H:i') }}</td>
                                </tr>
                                @endif
                            </table>
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <h5 class="font-weight-bold">Description</h5>
                        <div class="border p-3 rounded">
                            {{ $complaint->description }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Activity Log -->
        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Activity Log</h6>
                </div>
                <div class="card-body">
                    <div class="activity-feed">
                        @forelse($complaint->logs as $log)
                            <div class="activity-item mb-3">
                                <div class="d-flex justify-content-between">
                                    <strong>{{ $log->user->name ?? 'System' }}</strong>
                                    <small class="text-muted">{{ $log->created_at->diffForHumans() }}</small>
                                </div>
                                <div class="small text-muted">
                                    {{ ucfirst($log->action) }}: {{ $log->message }}
                                </div>
                                @if(!empty($log->meta))
                                    <div class="small text-muted mt-1">
                                        @foreach($log->meta as $key => $value)
                                            {{ ucfirst($key) }}: {{ is_array($value) ? json_encode($value) : $value }}<br>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        @empty
                            <p class="text-muted">No activity logs found.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
