<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="fw-bold text-dark mb-0">
                <i class="fas fa-eye me-2 text-primary"></i>{{ __('Complaint Details') }}
            </h2>
            <div class="d-flex gap-2">
                <a href="{{ route('staff.complaints.index') }}" class="btn btn-outline-secondary btn-modern">
                    <i class="fas fa-arrow-left me-2"></i>Back to List
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-4">
        <div class="container-fluid">
            <div class="row">
                <!-- Main Complaint Details -->
                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white border-0 py-3">
                            <h5 class="fw-bold text-dark mb-0">
                                <i class="fas fa-info-circle me-2 text-primary"></i>Complaint Information
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-muted">Complaint ID</label>
                                    <div class="fw-medium">#{{ $complaint->id }}</div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-muted">Category</label>
                                    <div>
                                        <span class="badge bg-info bg-opacity-10 text-info">
                                            <i class="fas fa-tag me-1"></i>{{ $complaint->category->name ?? 'N/A' }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-muted">Priority</label>
                                    <div>
                                        @php
                                            $priorityClasses = [
                                                'high' => 'bg-danger bg-opacity-10 text-danger',
                                                'medium' => 'bg-warning bg-opacity-10 text-warning',
                                                'low' => 'bg-secondary bg-opacity-10 text-secondary'
                                            ];
                                            $priorityClass = $priorityClasses[$complaint->priority] ?? 'bg-secondary bg-opacity-10 text-secondary';
                                        @endphp
                                        <span class="badge {{ $priorityClass }}">
                                            <i class="fas fa-flag me-1"></i>{{ ucfirst($complaint->priority) }}
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-muted">Status</label>
                                    <div>
                                        @php
                                            $statusClasses = [
                                                'pending' => 'bg-warning bg-opacity-10 text-warning',
                                                'in_progress' => 'bg-info bg-opacity-10 text-info',
                                                'resolved' => 'bg-success bg-opacity-10 text-success',
                                                'rejected' => 'bg-danger bg-opacity-10 text-danger'
                                            ];
                                            $statusClass = $statusClasses[$complaint->status] ?? 'bg-secondary bg-opacity-10 text-secondary';
                                        @endphp
                                        <span class="badge {{ $statusClass }}">
                                            <i class="fas fa-circle me-1"></i>{{ ucfirst(str_replace('_', ' ', $complaint->status)) }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold text-muted">Title</label>
                                <div class="fw-medium">{{ $complaint->title }}</div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold text-muted">Description</label>
                                <div class="p-3 bg-light rounded">
                                    {{ $complaint->description }}
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-muted">Created By</label>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center me-2">
                                            {{ substr($complaint->creator->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="fw-medium">{{ $complaint->creator->name }}</div>
                                            <small class="text-muted">{{ $complaint->creator->email }}</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-muted">Assigned To</label>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm bg-success bg-opacity-10 text-success rounded-circle d-flex align-items-center justify-content-center me-2">
                                            {{ substr($complaint->assignee->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="fw-medium">{{ $complaint->assignee->name }}</div>
                                            <small class="text-muted">{{ $complaint->assignee->email }}</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Activity Log -->
                    @if($complaint->logs && $complaint->logs->count() > 0)
                        <div class="card border-0 shadow-sm">
                            <div class="card-header bg-white border-0 py-3">
                                <h5 class="fw-bold text-dark mb-0">
                                    <i class="fas fa-history me-2 text-primary"></i>Activity Log
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="timeline">
                                    @foreach($complaint->logs as $log)
                                        <div class="timeline-item">
                                            <div class="timeline-marker bg-primary"></div>
                                            <div class="timeline-content">
                                                <div class="d-flex justify-content-between align-items-start mb-2">
                                                    <div class="fw-medium">{{ $log->user->name ?? 'System' }}</div>
                                                    <small class="text-muted">{{ $log->created_at->format('M d, Y H:i') }}</small>
                                                </div>
                                                <div class="text-muted mb-1">{{ ucfirst(str_replace('_', ' ', $log->action)) }}</div>
                                                @if($log->message)
                                                    <div class="p-2 bg-light rounded">{{ $log->message }}</div>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Sidebar -->
                <div class="col-lg-4">
                    <!-- Quick Actions -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white border-0 py-3">
                            <h5 class="fw-bold text-dark mb-0">
                                <i class="fas fa-bolt me-2 text-primary"></i>Quick Actions
                            </h5>
                        </div>
                        <div class="card-body">
                            <button class="btn btn-primary w-100 mb-2" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#statusModal">
                                <i class="fas fa-edit me-2"></i>Update Status
                            </button>
                            <a href="{{ route('staff.complaints.index') }}" class="btn btn-outline-secondary w-100">
                                <i class="fas fa-list me-2"></i>Back to List
                            </a>
                        </div>
                    </div>

                    <!-- Complaint Timeline -->
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white border-0 py-3">
                            <h5 class="fw-bold text-dark mb-0">
                                <i class="fas fa-clock me-2 text-primary"></i>Timeline
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="timeline-simple">
                                <div class="timeline-item-simple">
                                    <div class="timeline-marker-simple bg-info"></div>
                                    <div class="timeline-content-simple">
                                        <div class="fw-medium">Created</div>
                                        <small class="text-muted">{{ $complaint->created_at->format('M d, Y H:i') }}</small>
                                    </div>
                                </div>
                                <div class="timeline-item-simple">
                                    <div class="timeline-marker-simple bg-warning"></div>
                                    <div class="timeline-content-simple">
                                        <div class="fw-medium">Last Updated</div>
                                        <small class="text-muted">{{ $complaint->updated_at->format('M d, Y H:i') }}</small>
                                    </div>
                                </div>
                                @if($complaint->resolved_at)
                                    <div class="timeline-item-simple">
                                        <div class="timeline-marker-simple bg-success"></div>
                                        <div class="timeline-content-simple">
                                            <div class="fw-medium">Resolved</div>
                                            <small class="text-muted">{{ $complaint->resolved_at->format('M d, Y H:i') }}</small>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Status Update Modal -->
    <div class="modal fade" id="statusModal" tabindex="-1" aria-labelledby="statusModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="statusModalLabel">Update Complaint Status</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('staff.complaints.update-status', $complaint) }}">
                    @csrf
                    @method('PATCH')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="status" class="form-label">New Status</label>
                            <select name="status" id="status" class="form-select" required>
                                <option value="">Select Status</option>
                                <option value="in_progress" {{ $complaint->status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="resolved" {{ $complaint->status == 'resolved' ? 'selected' : '' }}>Resolved</option>
                                <option value="rejected" {{ $complaint->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="message" class="form-label">Message (Optional)</label>
                            <textarea name="message" id="message" class="form-control" rows="3" 
                                      placeholder="Add a note about this status change..."></textarea>
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

    <style>
    .avatar-sm {
        width: 40px;
        height: 40px;
        font-size: 14px;
        font-weight: 600;
    }

    .timeline {
        position: relative;
        padding-left: 30px;
    }

    .timeline::before {
        content: '';
        position: absolute;
        left: 15px;
        top: 0;
        bottom: 0;
        width: 2px;
        background: #e9ecef;
    }

    .timeline-item {
        position: relative;
        margin-bottom: 20px;
    }

    .timeline-marker {
        position: absolute;
        left: -23px;
        top: 5px;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        border: 2px solid white;
        box-shadow: 0 0 0 2px #e9ecef;
    }

    .timeline-content {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 8px;
        border-left: 3px solid #007bff;
    }

    .timeline-simple {
        position: relative;
        padding-left: 25px;
    }

    .timeline-simple::before {
        content: '';
        position: absolute;
        left: 10px;
        top: 0;
        bottom: 0;
        width: 2px;
        background: #e9ecef;
    }

    .timeline-item-simple {
        position: relative;
        margin-bottom: 15px;
    }

    .timeline-marker-simple {
        position: absolute;
        left: -18px;
        top: 3px;
        width: 8px;
        height: 8px;
        border-radius: 50%;
        border: 2px solid white;
        box-shadow: 0 0 0 1px #e9ecef;
    }

    .btn-modern {
        border-radius: 8px;
        font-weight: 500;
        padding: 8px 16px;
        transition: all 0.2s ease;
    }

    .btn-modern:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }

    .card {
        border-radius: 12px;
        overflow: hidden;
    }

    .badge {
        font-size: 0.75rem;
        padding: 6px 10px;
        border-radius: 6px;
    }
    </style>
</x-app-layout>
