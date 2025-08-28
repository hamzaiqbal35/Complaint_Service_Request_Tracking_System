<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="fw-bold text-dark mb-0">
                <i class="fas fa-tachometer-alt me-2 text-primary"></i>{{ __('Dashboard') }}
            </h2>
            <div class="d-flex gap-2">
                <a href="{{ route('complaints.create') }}" class="btn btn-primary btn-modern">
                    <i class="fas fa-plus me-2"></i>New Complaint
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
                                    <p class="mb-0 opacity-75">Here's an overview of your complaint management activities.</p>
                                </div>
                                <div class="col-md-4 text-md-end">
                                    <div class="d-inline-block bg-white bg-opacity-20 rounded-circle p-3">
                                        <i class="fas fa-chart-line fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistics Cards - Horizontal Layout -->
            <div class="row g-4 mb-4">
                <div class="col-xl-2 col-lg-3 col-md-6">
                    <div class="card border-0 shadow-sm h-100 stats-card-modern">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <div class="stats-icon bg-primary bg-opacity-10 text-primary rounded-3 p-3">
                                        <i class="fas fa-file-alt fa-lg"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="text-muted mb-1 fw-semibold">Total Complaints</h6>
                                    <h3 class="fw-bold text-dark mb-0">{{ $stats['total'] }}</h3>
                                    <small class="text-success">
                                        <i class="fas fa-arrow-up me-1"></i>12% from last month
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
                                        <i class="fas fa-arrow-up me-1"></i>85% success rate
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
                                        <i class="fas fa-arrow-down me-1"></i>5% of total
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
                                        <i class="fas fa-chart-pie fa-lg"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="text-muted mb-1 fw-semibold">Resolution Rate</h6>
                                    <h3 class="fw-bold text-dark mb-0">
                                        {{ $stats['total'] > 0 ? round(($stats['resolved'] / $stats['total']) * 100) : 0 }}%
                                    </h3>
                                    <small class="text-success">
                                        <i class="fas fa-trending-up me-1"></i>Excellent
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions & Recent Activity -->
            <div class="row g-4 mb-4">
                <div class="col-lg-8">
                    <!-- Complaints Table -->
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white border-0 py-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="fw-bold text-dark mb-0">
                                    <i class="fas fa-list me-2 text-primary"></i>My Complaints
                                </h5>
                                <div class="d-flex gap-2">
                                    <button class="btn btn-outline-secondary btn-sm">
                                        <i class="fas fa-filter me-1"></i>Filter
                                    </button>
                                    <button class="btn btn-outline-secondary btn-sm">
                                        <i class="fas fa-download me-1"></i>Export
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            @if(session('success'))
                                <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
                                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            @endif

                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="border-0 fw-semibold text-muted">ID</th>
                                            <th class="border-0 fw-semibold text-muted">Title</th>
                                            <th class="border-0 fw-semibold text-muted">Category</th>
                                            <th class="border-0 fw-semibold text-muted">Priority</th>
                                            <th class="border-0 fw-semibold text-muted">Status</th>
                                            <th class="border-0 fw-semibold text-muted">Assigned To</th>
                                            <th class="border-0 fw-semibold text-muted">Created</th>
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
                                                        @if($complaint->priority === 'high') bg-danger bg-opacity-10 text-danger
                                                        @elseif($complaint->priority === 'medium') bg-warning bg-opacity-10 text-warning
                                                        @else bg-success bg-opacity-10 text-success
                                                        @endif">
                                                        <i class="fas fa-flag me-1"></i>{{ ucfirst($complaint->priority) }}
                                                    </span>
                                                </td>
                                                <td class="align-middle">
                                                    <span class="badge 
                                                        @if($complaint->status === 'pending') bg-warning bg-opacity-10 text-warning
                                                        @elseif($complaint->status === 'in_progress') bg-info bg-opacity-10 text-info
                                                        @elseif($complaint->status === 'resolved') bg-success bg-opacity-10 text-success
                                                        @else bg-danger bg-opacity-10 text-danger
                                                        @endif">
                                                        <i class="fas fa-circle me-1"></i>{{ ucfirst(str_replace('_', ' ', $complaint->status)) }}
                                                    </span>
                                                </td>
                                                <td class="align-middle">
                                                    <div class="d-flex align-items-center">
                                                        @if($complaint->assignee)
                                                            <div class="avatar-sm bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center me-2">
                                                                {{ substr($complaint->assignee->name, 0, 1) }}
                                                            </div>
                                                            <span class="fw-medium">{{ $complaint->assignee->name }}</span>
                                                        @else
                                                            <span class="text-muted">Unassigned</span>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td class="align-middle">
                                                    <div>
                                                        <div class="fw-medium">{{ $complaint->created_at->format('M d, Y') }}</div>
                                                        <small class="text-muted">{{ $complaint->created_at->format('h:i A') }}</small>
                                                    </div>
                                                </td>
                                                <td class="align-middle">
                                                    <div class="btn-group" role="group">
                                                        <a href="{{ route('complaints.show', $complaint) }}" 
                                                           class="btn btn-sm btn-outline-primary" 
                                                           data-bs-toggle="tooltip" 
                                                           title="View Details">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        @if($complaint->status === 'pending')
                                                            <button class="btn btn-sm btn-outline-warning" 
                                                                    data-bs-toggle="tooltip" 
                                                                    title="Edit">
                                                                <i class="fas fa-edit"></i>
                                                            </button>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="8" class="text-center py-5">
                                                    <div class="empty-state">
                                                        <div class="empty-state-icon bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                                                            <i class="fas fa-file-alt fa-2x text-muted"></i>
                                                        </div>
                                                        <h5 class="fw-bold text-dark mb-2">No complaints yet</h5>
                                                        <p class="text-muted mb-4">Get started by creating your first complaint</p>
                                                        <a href="{{ route('complaints.create') }}" class="btn btn-primary btn-modern">
                                                            <i class="fas fa-plus me-2"></i>Create First Complaint
                                                        </a>
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

                <div class="col-lg-4">
                    <!-- Quick Actions -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white border-0 py-3">
                            <h5 class="fw-bold text-dark mb-0">
                                <i class="fas fa-bolt me-2 text-warning"></i>Quick Actions
                            </h5>
                        </div>
                        <div class="card-body p-3">
                            <div class="d-grid gap-2">
                                <a href="{{ route('complaints.create') }}" class="btn btn-primary btn-modern">
                                    <i class="fas fa-plus me-2"></i>New Complaint
                                </a>
                                <a href="{{ route('complaints.index') }}" class="btn btn-outline-primary">
                                    <i class="fas fa-list me-2"></i>View All Complaints
                                </a>
                                <a href="{{ route('profile.edit') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-user-cog me-2"></i>Profile Settings
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Activity -->
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white border-0 py-3">
                            <h5 class="fw-bold text-dark mb-0">
                                <i class="fas fa-history me-2 text-info"></i>Recent Activity
                            </h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="activity-timeline">
                                @foreach($complaints->take(5) as $complaint)
                                    <div class="activity-item p-3 border-bottom">
                                        <div class="d-flex">
                                            <div class="activity-icon bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                                <i class="fas fa-file-alt"></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <div class="fw-semibold text-dark">{{ $complaint->title }}</div>
                                                <div class="text-muted small">
                                                    {{ $complaint->created_at->diffForHumans() }}
                                                </div>
                                                <span class="badge 
                                                    @if($complaint->status === 'pending') bg-warning bg-opacity-10 text-warning
                                                    @elseif($complaint->status === 'in_progress') bg-info bg-opacity-10 text-info
                                                    @elseif($complaint->status === 'resolved') bg-success bg-opacity-10 text-success
                                                    @else bg-danger bg-opacity-10 text-danger
                                                    @endif">
                                                    {{ ucfirst(str_replace('_', ' ', $complaint->status)) }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        :root {
            --primary-color: #0d9488;
            --primary-dark: #0f766e;
            --primary-light: #14b8a6;
            --secondary-color: #059669;
            --secondary-dark: #047857;
            --secondary-light: #10b981;
            --accent-color: #f59e0b;
            --accent-dark: #d97706;
            --accent-light: #fbbf24;
            --success-color: #10b981;
            --warning-color: #f59e0b;
            --danger-color: #ef4444;
            --dark-color: #1f2937;
            --light-color: #f8fafc;
            --gray-color: #6b7280;
            --white-color: #ffffff;
            
            --primary-gradient: linear-gradient(135deg, #0d9488 0%, #059669 100%);
            --secondary-gradient: linear-gradient(135deg, #14b8a6 0%, #10b981 100%);
            --accent-gradient: linear-gradient(135deg, #f59e0b 0%, #fbbf24 100%);
            --dark-gradient: linear-gradient(135deg, #1f2937 0%, #374151 100%);
            --hero-gradient: linear-gradient(135deg, #0d9488 0%, #059669 50%, #047857 100%);
        }

        .bg-gradient-primary {
            background: var(--primary-gradient);
        }

        .stats-card-modern {
            transition: all 0.3s ease;
            border-radius: 12px;
        }

        .stats-card-modern:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(13, 148, 136, 0.1) !important;
        }

        .stats-icon {
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .btn-modern {
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
            border: none;
            font-weight: 600;
            letter-spacing: 0.5px;
            border-radius: 8px;
        }

        .btn-modern::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }

        .btn-modern:hover::before {
            left: 100%;
        }

        .btn-modern:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(13, 148, 136, 0.15);
        }

        .btn-primary {
            background: var(--primary-gradient);
            border: none;
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
        }

        .btn-outline-primary {
            border-color: var(--primary-color);
            color: var(--primary-color);
        }

        .btn-outline-primary:hover {
            background: var(--primary-color);
            border-color: var(--primary-color);
        }

        .complaint-row {
            transition: all 0.2s ease;
        }

        .complaint-row:hover {
            background-color: rgba(13, 148, 136, 0.05);
        }

        .avatar-sm {
            width: 32px;
            height: 32px;
            font-size: 14px;
            font-weight: 600;
        }

        .empty-state {
            padding: 2rem 1rem;
        }

        .empty-state-icon {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        }

        .activity-timeline .activity-item:last-child {
            border-bottom: none !important;
        }

        .activity-timeline .activity-item {
            transition: all 0.2s ease;
        }

        .activity-timeline .activity-item:hover {
            background-color: rgba(13, 148, 136, 0.05);
        }

        .card {
            border-radius: 12px;
            overflow: hidden;
        }

        .table {
            margin-bottom: 0;
        }

        .table th {
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .badge {
            font-size: 0.75rem;
            padding: 0.5em 0.75em;
        }

        @media (max-width: 768px) {
            .stats-card-modern {
                margin-bottom: 1rem;
            }
            
            .table-responsive {
                font-size: 0.875rem;
            }
        }
    </style>

    <script>
        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });

        // Add animation to stats cards
        document.addEventListener('DOMContentLoaded', function() {
            const statsCards = document.querySelectorAll('.stats-card-modern');
            
            const observer = new IntersectionObserver((entries) => {
                entries.forEach((entry, index) => {
                    if (entry.isIntersecting) {
                        setTimeout(() => {
                            entry.target.style.opacity = '1';
                            entry.target.style.transform = 'translateY(0)';
                        }, index * 100);
                    }
                });
            }, { threshold: 0.1 });

            statsCards.forEach(card => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                card.style.transition = 'all 0.6s ease-out';
                observer.observe(card);
            });
        });
    </script>
</x-app-layout>
