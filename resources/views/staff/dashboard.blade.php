<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="fw-bold text-dark mb-0">
                <i class="fas fa-user-tie me-2 text-primary"></i>{{ __('Staff Dashboard') }}
            </h2>
            <div class="d-flex gap-2">
                <a href="{{ route('staff.complaints.index') }}" class="btn btn-outline-primary btn-modern">
                    <i class="fas fa-list me-2"></i>All Assigned Complaints
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-4">
        <div class="container-fluid">
            <!-- Welcome Section -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card border-0 shadow-sm bg-gradient-primary text-white">
                        <div class="card-body p-4">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <h3 class="fw-bold mb-2">Welcome back, {{ Auth::user()->name }}!</h3>
                                    <p class="mb-0 opacity-75">Manage your assigned complaints and track your performance metrics.</p>
                                </div>
                                <div class="col-md-4 text-md-end">
                                    <div class="d-inline-block bg-white bg-opacity-100 rounded-circle p-3">
                                        <i class="fas fa-tasks fa-2x text-primary"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="row g-4 mb-4">
                <div class="col-xl-2 col-lg-3 col-md-6">
                    <div class="card border-0 shadow-sm h-100 stats-card-modern">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <div class="stats-icon bg-primary bg-opacity-10 text-primary rounded-3 p-3">
                                        <i class="fas fa-user-check fa-lg"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="text-muted mb-1 fw-semibold">Assigned to Me</h6>
                                    <h3 class="fw-bold text-dark mb-0">{{ $stats['total_assigned'] }}</h3>
                                    <small class="text-primary">
                                        <i class="fas fa-arrow-right me-1"></i>Your workload
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-2 col-lg-3 col-md-6">
                    <div class="card border-0 shadow-sm h-100 stats-card-modern">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <div class="stats-icon bg-warning bg-opacity-10 text-warning rounded-3 p-3">
                                        <i class="fas fa-clock fa-lg"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="text-muted mb-1 fw-semibold">Pending</h6>
                                    <h3 class="fw-bold text-dark mb-0">{{ $stats['pending'] }}</h3>
                                    <small class="text-warning">
                                        <i class="fas fa-exclamation-triangle me-1"></i>Needs attention
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-2 col-lg-3 col-md-6">
                    <div class="card border-0 shadow-sm h-100 stats-card-modern">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <div class="stats-icon bg-info bg-opacity-10 text-info rounded-3 p-3">
                                        <i class="fas fa-cogs fa-lg"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="text-muted mb-1 fw-semibold">In Progress</h6>
                                    <h3 class="fw-bold text-dark mb-0">{{ $stats['in_progress'] }}</h3>
                                    <small class="text-info">
                                        <i class="fas fa-spinner me-1"></i>Being processed
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-2 col-lg-3 col-md-6">
                    <div class="card border-0 shadow-sm h-100 stats-card-modern">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <div class="stats-icon bg-success bg-opacity-10 text-success rounded-3 p-3">
                                        <i class="fas fa-check-circle fa-lg"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="text-muted mb-1 fw-semibold">Resolved</h6>
                                    <h3 class="fw-bold text-dark mb-0">{{ $stats['resolved'] }}</h3>
                                    <small class="text-success">
                                        <i class="fas fa-arrow-up me-1"></i>Completed
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-2 col-lg-3 col-md-6">
                    <div class="card border-0 shadow-sm h-100 stats-card-modern">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <div class="stats-icon bg-danger bg-opacity-10 text-danger rounded-3 p-3">
                                        <i class="fas fa-times-circle fa-lg"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="text-muted mb-1 fw-semibold">Rejected</h6>
                                    <h3 class="fw-bold text-dark mb-0">{{ $stats['rejected'] }}</h3>
                                    <small class="text-danger">
                                        <i class="fas fa-arrow-down me-1"></i>Not resolved
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-2 col-lg-3 col-md-6">
                    <div class="card border-0 shadow-sm h-100 stats-card-modern">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <div class="stats-icon bg-secondary bg-opacity-10 text-secondary rounded-3 p-3">
                                        <i class="fas fa-percentage fa-lg"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="text-muted mb-1 fw-semibold">Resolution Rate</h6>
                                    <h3 class="fw-bold text-dark mb-0">{{ $additionalStats['my_resolution_rate'] }}%</h3>
                                    <small class="text-success">
                                        <i class="fas fa-trending-up me-1"></i>Your performance
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Complaints Table with Filters -->
            <div class="row g-4 mb-4">
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white border-0 py-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="fw-bold text-dark mb-0">
                                    <i class="fas fa-list me-2 text-primary"></i>My Assigned Complaints
                                </h5>
                                <div class="d-flex gap-2">
                                    <button class="btn btn-outline-secondary btn-sm" data-bs-toggle="collapse" data-bs-target="#staffFilterCollapse">
                                        <i class="fas fa-filter me-1"></i>Filter
                                    </button>
                                    <a href="{{ route('staff.dashboard.export', request()->query()) }}" class="btn btn-outline-secondary btn-sm">
                                        <i class="fas fa-download me-1"></i>Export
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Filter Form -->
                        <div class="collapse" id="staffFilterCollapse">
                            <div class="card-body border-bottom">
                                <form method="GET" action="{{ route('staff.dashboard') }}" class="row g-3">
                                    <div class="col-md-3">
                                        <label for="status" class="form-label">Status</label>
                                        <select name="status" id="status" class="form-select">
                                            <option value="">All Statuses</option>
                                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                            <option value="resolved" {{ request('status') == 'resolved' ? 'selected' : '' }}>Resolved</option>
                                            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="priority" class="form-label">Priority</label>
                                        <select name="priority" id="priority" class="form-select">
                                            <option value="">All Priorities</option>
                                            <option value="low" {{ request('priority') == 'low' ? 'selected' : '' }}>Low</option>
                                            <option value="medium" {{ request('priority') == 'medium' ? 'selected' : '' }}>Medium</option>
                                            <option value="high" {{ request('priority') == 'high' ? 'selected' : '' }}>High</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="category_id" class="form-label">Category</label>
                                        <select name="category_id" id="category_id" class="form-select">
                                            <option value="">All Categories</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="sort_by" class="form-label">Sort By</label>
                                        <select name="sort_by" id="sort_by" class="form-select">
                                            <option value="created_at" {{ request('sort_by') == 'created_at' ? 'selected' : '' }}>Created Date</option>
                                            <option value="title" {{ request('sort_by') == 'title' ? 'selected' : '' }}>Title</option>
                                            <option value="priority" {{ request('sort_by') == 'priority' ? 'selected' : '' }}>Priority</option>
                                            <option value="status" {{ request('sort_by') == 'status' ? 'selected' : '' }}>Status</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="date_from" class="form-label">From Date</label>
                                        <input type="date" name="date_from" id="date_from" class="form-control" value="{{ request('date_from') }}">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="date_to" class="form-label">To Date</label>
                                        <input type="date" name="date_to" id="date_to" class="form-control" value="{{ request('date_to') }}">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="sort_order" class="form-label">Sort Order</label>
                                        <select name="sort_order" id="sort_order" class="form-select">
                                            <option value="desc" {{ request('sort_order') == 'desc' ? 'selected' : '' }}>Descending</option>
                                            <option value="asc" {{ request('sort_order') == 'asc' ? 'selected' : '' }}>Ascending</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3 d-flex align-items-end">
                                        <div class="d-flex gap-2 w-100">
                                            <button type="submit" class="btn btn-primary flex-fill">
                                                <i class="fas fa-search me-1"></i>Apply Filters
                                            </button>
                                            <a href="{{ route('staff.dashboard') }}" class="btn btn-outline-secondary">
                                                <i class="fas fa-times"></i>
                                            </a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="border-0 fw-semibold text-muted">ID</th>
                                            <th class="border-0 fw-semibold text-muted">Title</th>
                                            <th class="border-0 fw-semibold text-muted">Category</th>
                                            <th class="border-0 fw-semibold text-muted">Priority</th>
                                            <th class="border-0 fw-semibold text-muted">Status</th>
                                            <th class="border-0 fw-semibold text-muted">Created By</th>
                                            <th class="border-0 fw-semibold text-muted">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($complaints as $complaint)
                                            <tr class="complaint-row">
                                                <td class="align-middle">
                                                    <span class="badge bg-light text-dark">#{{ $complaint->id }}</span>
                                                </td>
                                                <td class="align-middle">
                                                    <div>
                                                        <div class="fw-semibold text-dark">{{ $complaint->title }}</div>
                                                        <small class="text-muted">{{ Str::limit($complaint->description, 50) }}</small>
                                                    </div>
                                                </td>
                                                <td class="align-middle">
                                                    <span class="badge bg-primary bg-opacity-10 text-primary">
                                                        {{ $complaint->category->name }}
                                                    </span>
                                                </td>
                                                <td class="align-middle">
                                                    <span class="badge 
                                                        @if($complaint->priority === 'high') bg-danger/10 text-danger
                                                        @elseif($complaint->priority === 'medium') bg-warning/10 text-warning
                                                        @else bg-success/10 text-success
                                                        @endif">
                                                        <i class="fas fa-flag me-1"></i>{{ ucfirst($complaint->priority) }}
                                                    </span>
                                                </td>
                                                <td class="align-middle">
                                                    <span class="badge 
                                                        @if($complaint->status === 'pending') bg-warning/10 text-warning
                                                        @elseif($complaint->status === 'in_progress') bg-info/10 text-info
                                                        @elseif($complaint->status === 'resolved') bg-success/10 text-success
                                                        @else bg-danger/10 text-danger
                                                        @endif">
                                                        <i class="fas fa-circle me-1"></i>{{ ucfirst(str_replace('_', ' ', $complaint->status)) }}
                                                    </span>
                                                </td>
                                                <td class="align-middle">
                                                    <div class="d-flex align-items-center">
                                                        <div class="avatar-sm bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center me-2">
                                                            {{ substr($complaint->creator->name, 0, 1) }}
                                                        </div>
                                                        <span class="fw-medium">{{ $complaint->creator->name }}</span>
                                                    </div>
                                                </td>
                                                <td class="align-middle">
                                                    <div class="btn-group" role="group">
                                                        <a href="{{ route('staff.complaints.show', $complaint) }}" 
                                                           class="btn btn-sm btn-outline-primary" 
                                                           data-bs-toggle="tooltip" 
                                                           title="View Details">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        <button class="btn btn-sm btn-outline-success" 
                                                                data-bs-toggle="modal" 
                                                                data-bs-target="#statusModal{{ $complaint->id }}"
                                                                title="Update Status">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center py-5">
                                                    <div class="empty-state">
                                                        <div class="empty-state-icon bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                                                            <i class="fas fa-tasks fa-2x text-muted"></i>
                                                        </div>
                                                        <h5 class="fw-bold text-dark mb-2">No assigned complaints</h5>
                                                        <p class="text-muted mb-4">You don't have any complaints assigned to you yet.</p>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            @if($complaints->hasPages())
                                <div class="card-footer bg-white border-0 py-3">
                                    <nav aria-label="Complaints pagination">
                                        {{ $complaints->links() }}
                                    </nav>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Status Update Modals -->
    @foreach($complaints as $complaint)
        <div class="modal fade" id="statusModal{{ $complaint->id }}" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Update Status - #{{ $complaint->id }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form method="POST" action="{{ route('staff.complaints.update-status', $complaint) }}">
                        @csrf
                        @method('PATCH')
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="status{{ $complaint->id }}" class="form-label">Status</label>
                                <select name="status" id="status{{ $complaint->id }}" class="form-select" required>
                                    <option value="pending" {{ $complaint->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="in_progress" {{ $complaint->status === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                    <option value="resolved" {{ $complaint->status === 'resolved' ? 'selected' : '' }}>Resolved</option>
                                    <option value="rejected" {{ $complaint->status === 'rejected' ? 'selected' : '' }}>Rejected</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="message{{ $complaint->id }}" class="form-label">Message (Optional)</label>
                                <textarea name="message" id="message{{ $complaint->id }}" rows="3" class="form-control" placeholder="Add a note about this status change..."></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Update Status</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach

    <style>
        .bg-gradient-primary { background: linear-gradient(135deg, #0d9488 0%, #059669 100%); }
        .stats-card-modern { transition: all 0.3s ease; border-radius: 12px; }
        .stats-card-modern:hover { transform: translateY(-5px); box-shadow: 0 10px 30px rgba(13, 148, 136, 0.1) !important; }
        .stats-icon { width: 50px; height: 50px; display: flex; align-items: center; justify-content: center; }
        .btn-modern { position: relative; overflow: hidden; transition: all 0.3s ease; border: none; font-weight: 600; letter-spacing: 0.5px; border-radius: 8px; }
        .btn-modern:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(13, 148, 136, 0.15); }
        .complaint-row { transition: all 0.2s ease; }
        .complaint-row:hover { background-color: rgba(13, 148, 136, 0.05); }
        .avatar-sm { width: 32px; height: 32px; font-size: 14px; font-weight: 600; }
        .card { border-radius: 12px; overflow: hidden; }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof bootstrap !== 'undefined') {
                var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
                var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                    return new bootstrap.Tooltip(tooltipTriggerEl)
                });
            }
        });
    </script>
</x-app-layout>
