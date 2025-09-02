<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Cache Control -->
        <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
        <meta http-equiv="Pragma" content="no-cache" />
        <meta http-equiv="Expires" content="0" />

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        <!-- Scripts -->
        @vite([
            'resources/css/app.css',
            'resources/js/app.js',
            'resources/js/auth.js',
            'resources/js/auth-handler.js'
        ])
        
        <!-- SweetAlert2 -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        
        @stack('scripts')
        
        <style>
            .sticky-nav {
                position: sticky;
                top: 0;
                z-index: 1030; /* Bootstrap's default z-index for fixed navbars */
                box-shadow: 0 2px 4px rgba(0,0,0,0.1);
                background-color: #fff; /* Or your preferred background color */
            }
            body {
                padding-top: 0px; /* Height of the navbar */
            }
            @media (min-width: 992px) {
                body {
                    padding-top: 15px; /* Adjust if your navbar height is different on desktop */
                }
            }
        </style>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            <div class="sticky-nav">
                @include('layouts.navigation')
            </div>

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                @hasSection('content')
                    @yield('content')
                @else
                    {{ $slot ?? '' }}
                @endif
            </main>
        </div>
        
        <!-- Bootstrap JavaScript -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        
        <script>
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
        </script>

        <script>
            // Clear any existing session storage
            sessionStorage.clear();
            
            // Only run this for authenticated users
            @if(auth()->check())
            // Store current URL in session storage
            sessionStorage.setItem('validSession', '1');
            
            // Prevent back button after logout
            window.history.pushState(null, null, window.location.href);
            window.onpopstate = function() {
                // If session is no longer valid, redirect to login
                if (!sessionStorage.getItem('validSession')) {
                    window.location.href = '{{ route("login") }}';
                }
                window.history.pushState(null, null, window.location.href);
            };
            
            // Clear session flag on page unload
            window.addEventListener('beforeunload', function() {
                // Don't clear if this is a form submission or link click
                if (!event.target.href && !event.target.form) {
                    sessionStorage.removeItem('validSession');
                }
            });
            @endif
        </script>
    </body>
</html>
