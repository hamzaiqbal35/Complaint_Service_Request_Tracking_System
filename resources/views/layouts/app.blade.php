<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'CSRTS') }}</title>

    <!-- Fonts & Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- AlpineJS for interactivity -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <!-- Toastr & jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    @stack('styles')
    
    <style>
        body { font-family: 'Inter', sans-serif; }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-slate-50 text-slate-900 antialiased selection:bg-teal-500 selection:text-white" x-data="{ sidebarOpen: false }">

    <div class="flex h-screen overflow-hidden">
        
        <!-- Sidebar Backdrop (Mobile) -->
        <div x-show="sidebarOpen" x-transition:enter="transition-opacity ease-linear duration-300"
             x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-linear duration-300" x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-40 bg-slate-900/80 backdrop-blur-sm lg:hidden" @click="sidebarOpen = false" x-cloak></div>

        <!-- Sidebar -->
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
               class="fixed inset-y-0 left-0 z-50 w-72 bg-slate-900 flex flex-col transition-transform duration-300 ease-in-out lg:static lg:translate-x-0 shadow-2xl lg:shadow-none">
            
            <!-- Branding -->
            <div class="flex items-center justify-between h-20 px-6 border-b border-slate-800/50 bg-slate-900/50">
                <a href="{{ auth()->check() && auth()->user()->isStaff() ? route('staff.dashboard') : route('dashboard') }}" class="flex items-center gap-3 group">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-teal-500 to-emerald-600 flex items-center justify-center shadow-lg shadow-teal-500/30 group-hover:scale-105 transition-transform">
                        <i class="fas fa-shield-alt text-white"></i>
                    </div>
                    <span class="text-xl font-bold text-white tracking-tight">CSRTS <span class="text-teal-500">{{ auth()->check() && auth()->user()->isStaff() ? 'Staff' : 'Portal' }}</span></span>
                </a>
                <button @click="sidebarOpen = false" class="lg:hidden text-slate-400 hover:text-white">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <!-- Navigation Links -->
            <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto custom-scrollbar">
                
                <p class="px-3 text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2 mt-4">Overview</p>
                
                @if(auth()->check() && auth()->user()->isStaff())
                    <a href="{{ route('staff.dashboard') }}" 
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all {{ request()->routeIs('staff.dashboard') ? 'bg-gradient-to-r from-teal-500/20 to-emerald-500/10 text-teal-400 border border-teal-500/20 shadow-inner' : 'text-slate-400 hover:bg-slate-800 hover:text-slate-200' }}">
                        <i class="fas fa-home w-5 text-center"></i>
                        <span class="font-medium">Dashboard</span>
                    </a>

                    <p class="px-3 text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2 mt-6">Management</p>

                    <a href="{{ route('staff.complaints.index') }}" 
                       class="flex items-center justify-between px-3 py-2.5 rounded-xl transition-all {{ request()->routeIs('staff.complaints.*') ? 'bg-gradient-to-r from-teal-500/20 to-emerald-500/10 text-teal-400 border border-teal-500/20 shadow-inner' : 'text-slate-400 hover:bg-slate-800 hover:text-slate-200' }}">
                        <div class="flex items-center gap-3">
                            <i class="fas fa-ticket-alt w-5 text-center"></i>
                            <span class="font-medium">Assigned Complaints</span>
                        </div>
                    </a>
                @else
                    <a href="{{ route('dashboard') }}" 
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all {{ request()->routeIs('dashboard') ? 'bg-gradient-to-r from-teal-500/20 to-emerald-500/10 text-teal-400 border border-teal-500/20 shadow-inner' : 'text-slate-400 hover:bg-slate-800 hover:text-slate-200' }}">
                        <i class="fas fa-home w-5 text-center"></i>
                        <span class="font-medium">Dashboard</span>
                    </a>

                    <p class="px-3 text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2 mt-6">My Activity</p>

                    <a href="{{ route('complaints.index') }}" 
                       class="flex items-center justify-between px-3 py-2.5 rounded-xl transition-all {{ request()->routeIs('complaints.*') ? 'bg-gradient-to-r from-teal-500/20 to-emerald-500/10 text-teal-400 border border-teal-500/20 shadow-inner' : 'text-slate-400 hover:bg-slate-800 hover:text-slate-200' }}">
                        <div class="flex items-center gap-3">
                            <i class="fas fa-list w-5 text-center"></i>
                            <span class="font-medium">My Complaints</span>
                        </div>
                    </a>
                    
                    <a href="{{ route('complaints.create') }}" 
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all {{ request()->routeIs('complaints.create') ? 'bg-gradient-to-r from-teal-500/20 to-emerald-500/10 text-teal-400 border border-teal-500/20 shadow-inner' : 'text-slate-400 hover:bg-slate-800 hover:text-slate-200' }}">
                        <i class="fas fa-plus-circle w-5 text-center"></i>
                        <span class="font-medium">New Complaint</span>
                    </a>
                @endif
            </nav>
            
            <!-- Bottom Action -->
            <div class="p-4 border-t border-slate-800/50">
                <form method="POST" action="{{ route('logout') }}" id="logout-form">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-2.5 bg-slate-800/50 hover:bg-slate-700 text-slate-300 hover:text-white rounded-xl transition-colors border border-slate-700/50">
                        <i class="fas fa-sign-out-alt text-sm"></i>
                        <span class="font-medium">Sign Out</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content Wrapper -->
        <div class="flex-1 flex flex-col overflow-hidden relative">
            
            <!-- Top Header -->
            <header class="h-20 bg-white/80 backdrop-blur-md border-b border-slate-200/50 flex items-center justify-between px-4 sm:px-6 z-30">
                <div class="flex items-center gap-4">
                    <button @click="sidebarOpen = true" class="lg:hidden w-10 h-10 flex items-center justify-center rounded-xl bg-slate-100 text-slate-600 hover:bg-slate-200 transition-colors">
                        <i class="fas fa-bars"></i>
                    </button>
                </div>
                
                <div class="flex items-center gap-4">

                    <!-- Notifications Dropdown (Alpine) -->
                    <div class="relative" x-data="{ 
                        notifOpen: false, 
                        unreadCount: {{ auth()->user()->unreadNotifications->count() }},
                        markAllRead() {
                            fetch('{{ route('notifications.mark-all-read') }}', {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Accept': 'application/json'
                                }
                            }).then(res => res.json()).then(data => {
                                if(data.success) {
                                    this.unreadCount = 0;
                                    document.querySelectorAll('.unread-indicator').forEach(el => el.remove());
                                }
                            });
                        }
                    }">
                        <button @click="notifOpen = !notifOpen" @click.away="notifOpen = false" class="relative p-2 text-slate-400 hover:text-teal-600 transition-colors focus:outline-none">
                            <i class="fas fa-bell text-xl"></i>
                            <span x-show="unreadCount > 0" x-text="unreadCount" class="absolute top-0 right-0 inline-flex items-center justify-center px-1.5 py-0.5 text-xs font-bold leading-none text-white transform translate-x-1/4 -translate-y-1/4 bg-rose-500 rounded-full"></span>
                        </button>
                        
                        <div x-show="notifOpen" x-transition
                             class="absolute right-0 mt-2 w-80 bg-white rounded-2xl shadow-[0_10px_40px_-10px_rgba(0,0,0,0.1)] border border-slate-100 py-2 z-50 overflow-hidden" x-cloak>
                            <div class="px-4 py-2 flex justify-between items-center border-b border-slate-50">
                                <span class="font-bold text-slate-700">Notifications</span>
                                <button @click="markAllRead()" x-show="unreadCount > 0" class="text-xs text-teal-600 hover:text-teal-700 font-medium">Mark all read</button>
                            </div>
                            <div class="max-h-80 overflow-y-auto custom-scrollbar">
                                @forelse(auth()->user()->notifications->take(5) as $notification)
                                    <a href="{{ $notification->data['url'] ?? '#' }}" class="block px-4 py-3 hover:bg-slate-50 transition-colors border-b border-slate-50 relative {{ $notification->read_at ? 'opacity-70' : '' }}">
                                        @if(!$notification->read_at)
                                            <span class="unread-indicator absolute top-3 right-4 w-2 h-2 bg-teal-500 rounded-full"></span>
                                        @endif
                                        <p class="text-sm font-semibold text-slate-800">{{ $notification->data['title'] }}</p>
                                        <p class="text-xs text-slate-500 mt-1 line-clamp-2">{{ $notification->data['message'] }}</p>
                                        <p class="text-[10px] text-slate-400 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                                    </a>
                                @empty
                                    <div class="px-4 py-6 text-center text-slate-500 text-sm">
                                        No notifications yet.
                                    </div>
                                @endforelse
                            </div>
                            <div class="px-4 py-2 border-t border-slate-50 flex items-center justify-between">
                                <span class="text-xs text-slate-400">Showing latest 5</span>
                                <a href="{{ route('notifications.index') }}" class="text-xs font-semibold text-teal-600 hover:text-teal-700">View All</a>
                            </div>
                        </div>
                    </div>

                    <!-- Profile Dropdown (Alpine) -->
                    <div class="relative" x-data="{ profileOpen: false }">
                        <button @click="profileOpen = !profileOpen" @click.away="profileOpen = false" class="flex items-center gap-3 focus:outline-none bg-white hover:bg-slate-50 border border-slate-200 rounded-xl p-1.5 pl-2 transition-colors shadow-sm">
                            <div class="hidden sm:block text-right">
                                <p class="text-sm font-semibold text-slate-700 leading-tight">{{ Auth::user()->name ?? 'User' }}</p>
                                <p class="text-[10px] text-slate-500 font-medium uppercase tracking-wider">{{ auth()->check() && auth()->user()->isStaff() ? 'Staff Member' : 'User' }}</p>
                            </div>
                            <div class="w-9 h-9 rounded-lg bg-gradient-to-br from-teal-500 to-emerald-600 flex items-center justify-center text-white font-bold shadow-sm">
                                {{ substr(Auth::user()->name ?? 'U', 0, 1) }}
                            </div>
                            <i class="fas fa-chevron-down text-xs text-slate-400 pr-2 hidden sm:block"></i>
                        </button>
                        
                        <div x-show="profileOpen" x-transition
                             class="absolute right-0 mt-2 w-48 bg-white rounded-2xl shadow-[0_10px_40px_-10px_rgba(0,0,0,0.1)] border border-slate-100 py-2 z-50 overflow-hidden" x-cloak>
                            <a href="{{ route('profile.edit') }}" class="flex items-center px-4 py-2.5 text-sm text-slate-700 hover:bg-slate-50 hover:text-teal-600 transition-colors">
                                <i class="fas fa-user-circle mr-3 w-4 text-slate-400"></i> Profile Settings
                            </a>
                            <div class="border-t border-slate-100 my-1"></div>
                            <form method="POST" action="{{ route('logout') }}" class="logout-form-dropdown">
                                @csrf
                                <button type="submit" class="w-full flex items-center text-left px-4 py-2.5 text-sm text-rose-600 hover:bg-rose-50 transition-colors">
                                    <i class="fas fa-sign-out-alt mr-3 w-4 text-rose-400"></i> Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Scrollable Area -->
            <main class="flex-1 overflow-y-auto bg-slate-50 p-4 sm:p-6 lg:p-8 relative">
                <!-- Background decorative elements -->
                <div class="absolute top-0 left-0 w-full h-64 bg-gradient-to-b from-slate-100 to-slate-50 pointer-events-none"></div>
                
                <div class="relative max-w-7xl mx-auto">
                    <!-- Here goes the content -->
                    @hasSection('content')
                        @yield('content')
                    @else
                        {{ $slot ?? '' }}
                    @endif
                </div>
            </main>
        </div>
    </div>
    
    <script>
        // Toastr Configuration
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "timeOut": "4000",
        };

        @if(session('success'))
            toastr.success("{{ session('success') }}");
        @endif

        @if(session('error'))
            toastr.error("{{ session('error') }}");
        @endif

        // Handle logout with confirmation
        document.addEventListener('DOMContentLoaded', function() {
            // Handle logout form submission
            const logoutForms = document.querySelectorAll('form[action*="logout"]');
            
            logoutForms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    Swal.fire({
                        title: 'Are you sure?',
                        text: 'You are about to log out of your account.',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, log me out',
                        cancelButtonText: 'Cancel',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Remove JWT token from localStorage if it exists
                            if (typeof localStorage !== 'undefined') {
                                localStorage.removeItem('jwt_token');
                            }
                            // Submit the form
                            this.submit();
                        }
                    });
                });
            });
        });

        // Clear any existing session storage
        sessionStorage.clear();
        
        // Store current URL in session storage
        sessionStorage.setItem('validSession', '1');
        
        // Prevent back button after logout
        window.history.pushState(null, null, window.location.href);
        window.onpopstate = function() {
            // If session is no longer valid, redirect to login
            if (!sessionStorage.getItem('validSession')) {
                window.location.href = '/login';
            } else {
                window.history.pushState(null, null, window.location.href);
            }
        };
        
        // Clear session flag on page unload
        window.addEventListener('beforeunload', function(event) {
            // Don't clear if this is a form submission or link click
            if (event.target && !event.target.href && !event.target.form) {
                sessionStorage.removeItem('validSession');
            }
        });
    </script>

    @stack('scripts')
</body>
</html>