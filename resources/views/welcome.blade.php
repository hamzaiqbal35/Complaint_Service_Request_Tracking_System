<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Complaint & Service Request Tracking System</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
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

            body {
                font-family: 'Figtree', sans-serif;
                overflow-x: hidden;
                background-color: var(--light-color);
            }

            .gradient-text {
                background: var(--primary-gradient);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
            }

            .hero-section {
                background: var(--hero-gradient);
                position: relative;
                overflow: hidden;
                min-height: 100vh;
            }

            .hero-section::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 1000"><polygon fill="rgba(255,255,255,0.05)" points="0,1000 1000,0 1000,1000"/></svg>');
                background-size: cover;
            }

            .floating-element {
                animation: float 6s ease-in-out infinite;
            }

            .floating-element:nth-child(2) {
                animation-delay: 2s;
            }

            .floating-element:nth-child(3) {
                animation-delay: 4s;
            }

            @keyframes float {
                0%, 100% { transform: translateY(0px) rotate(0deg); }
                33% { transform: translateY(-20px) rotate(5deg); }
                66% { transform: translateY(-10px) rotate(-5deg); }
            }

            .fade-in-up {
                animation: fadeInUp 1s ease-out;
            }

            @keyframes fadeInUp {
                from {
                    opacity: 0;
                    transform: translateY(50px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .slide-in-left {
                animation: slideInLeft 1s ease-out;
            }

            @keyframes slideInLeft {
                from {
                    opacity: 0;
                    transform: translateX(-100px);
                }
                to {
                    opacity: 1;
                    transform: translateX(0);
                }
            }

            .slide-in-right {
                animation: slideInRight 1s ease-out;
            }

            @keyframes slideInRight {
                from {
                    opacity: 0;
                    transform: translateX(100px);
                }
                to {
                    opacity: 1;
                    transform: translateX(0);
                }
            }

            .pulse-glow {
                animation: pulseGlow 2s ease-in-out infinite alternate;
            }

            @keyframes pulseGlow {
                from { 
                    box-shadow: 0 0 20px rgba(13, 148, 136, 0.4);
                    transform: scale(1);
                }
                to { 
                    box-shadow: 0 0 30px rgba(13, 148, 136, 0.8);
                    transform: scale(1.05);
                }
            }

            .feature-card {
                transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
                background: rgba(255, 255, 255, 0.95);
                backdrop-filter: blur(10px);
                border: 1px solid rgba(255, 255, 255, 0.2);
                border-radius: 16px;
            }

            .feature-card:hover {
                transform: translateY(-15px) scale(1.02);
                box-shadow: 0 25px 50px rgba(13, 148, 136, 0.15);
                background: rgba(255, 255, 255, 1);
                border-color: var(--primary-color);
            }

            .glass-effect {
                background: rgba(255, 255, 255, 0.1);
                backdrop-filter: blur(15px);
                border: 1px solid rgba(255, 255, 255, 0.2);
                box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            }

            .btn-modern {
                position: relative;
                overflow: hidden;
                transition: all 0.3s ease;
                border: none;
                font-weight: 600;
                letter-spacing: 0.5px;
                border-radius: 12px;
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
                box-shadow: 0 10px 25px rgba(13, 148, 136, 0.2);
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

            .stats-card {
                background: rgba(255, 255, 255, 0.1);
                backdrop-filter: blur(15px);
                border: 1px solid rgba(255, 255, 255, 0.2);
                transition: all 0.3s ease;
                border-radius: 16px;
            }

            .stats-card:hover {
                transform: translateY(-5px);
                background: rgba(255, 255, 255, 0.15);
            }

            .navbar-modern {
                background: rgba(255, 255, 255, 0.95);
                backdrop-filter: blur(20px);
                border-bottom: 1px solid rgba(255, 255, 255, 0.2);
                transition: all 0.3s ease;
            }

            .navbar-modern.scrolled {
                background: rgba(255, 255, 255, 0.98);
                box-shadow: 0 4px 20px rgba(13, 148, 136, 0.1);
            }

            .text-shadow {
                text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
            }

            .gradient-border {
                position: relative;
                background: white;
                border-radius: 20px;
            }

            .gradient-border::before {
                content: '';
                position: absolute;
                top: -2px;
                left: -2px;
                right: -2px;
                bottom: -2px;
                background: var(--primary-gradient);
                border-radius: 22px;
                z-index: -1;
            }

            .wave-animation {
                animation: wave 3s ease-in-out infinite;
            }

            @keyframes wave {
                0%, 100% { transform: rotate(0deg); }
                25% { transform: rotate(5deg); }
                75% { transform: rotate(-5deg); }
            }

            .section-divider {
                height: 100px;
                background: var(--primary-gradient);
                clip-path: polygon(0 0, 100% 0, 100% 100%, 0 70%);
            }

            .section-divider-reverse {
                height: 100px;
                background: var(--primary-gradient);
                clip-path: polygon(0 30%, 100% 0, 100% 100%, 0 100%);
            }

            .hero-title {
                font-size: 3.5rem;
                line-height: 1.2;
            }

            .hero-title .highlight {
                color: var(--accent-color);
                text-shadow: 0 2px 4px rgba(245, 158, 11, 0.3);
            }

            .feature-icon {
                width: 80px;
                height: 80px;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                margin: 0 auto 1.5rem;
                font-size: 2rem;
                color: white;
            }

            .feature-icon.primary {
                background: var(--primary-gradient);
            }

            .feature-icon.secondary {
                background: var(--secondary-gradient);
            }

            .feature-icon.accent {
                background: var(--accent-gradient);
            }

            .feature-icon.success {
                background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            }

            .bg-custom-light {
                background-color: #f8fafc;
            }

            .bg-custom-dark {
                background-color: var(--dark-color);
            }

            .text-custom-primary {
                color: var(--primary-color);
            }

            .text-custom-secondary {
                color: var(--secondary-color);
            }

            @media (max-width: 768px) {
                .hero-title {
                    font-size: 2.5rem !important;
                }
                
                .floating-element {
                    display: none;
                }
            }
        </style>
    </head>
    <body class="antialiased">
        <!-- Navigation -->
        <nav class="navbar navbar-expand-lg navbar-modern fixed-top" id="mainNavbar">
            <div class="container">
                <a class="navbar-brand d-flex align-items-center" href="#">
                    <div class="bg-primary rounded-lg p-2 me-2">
                        <i class="fas fa-shield-alt text-white"></i>
                    </div>
                    <span class="gradient-text fw-bold fs-4">Complaint Service Request Tracking System</span>
                </a>
            </div>
        </nav>

        <!-- Hero Section -->
        <section class="hero-section d-flex align-items-center position-relative" style="padding-top: 80px;">
            <!-- Floating Elements -->
            <div class="floating-element position-absolute" style="top: 15%; left: 10%; width: 80px; height: 80px; background: rgba(255,255,255,0.1); border-radius: 50%;"></div>
            <div class="floating-element position-absolute" style="top: 25%; right: 15%; width: 60px; height: 60px; background: rgba(255,255,255,0.08); border-radius: 50%;"></div>
            <div class="floating-element position-absolute" style="bottom: 20%; left: 20%; width: 100px; height: 100px; background: rgba(255,255,255,0.05); border-radius: 50%;"></div>
            
            <div class="container position-relative z-3">
                <div class="row align-items-center">
                    <div class="col-lg-6 fade-in-up">
                        <h1 class="hero-title fw-bold text-white text-shadow mb-4">
                            <span class="d-block">Efficient</span>
                            <span class="d-block">Complaint</span>
                            <span class="d-block highlight wave-animation">Management</span>
                            <span class="d-block highlight wave-animation">System</span>
                        </h1>
                        <p class="lead text-white-75 mb-5 fs-5">
                            Streamline your complaint and service request tracking with our comprehensive management system. 
                            Submit, track, and resolve issues efficiently with real-time updates and detailed reporting.
                        </p>
                        <div class="d-flex flex-column flex-sm-row gap-3">
                            @auth
                                @if(Auth::user() && Auth::user()->isAdmin())
                                    <a href="{{ route('admin.dashboard') }}" class="btn btn-light btn-lg btn-modern">
                                        <i class="fas fa-rocket me-2"></i>Go to Dashboard
                                    </a>
                                @elseif(Auth::user() && Auth::user()->isStaff())
                                    <a href="{{ route('staff.dashboard') }}" class="btn btn-light btn-lg btn-modern">
                                        <i class="fas fa-rocket me-2"></i>Go to Dashboard
                                    </a>
                                @else
                                    <a href="{{ route('dashboard') }}" class="btn btn-light btn-lg btn-modern">
                                        <i class="fas fa-rocket me-2"></i>Go to Dashboard
                                    </a>
                                @endif
                            @else
                                <a href="{{ route('register') }}" class="btn btn-light btn-lg btn-modern pulse-glow">
                                    <i class="fas fa-play me-2"></i>Get Started
                                </a>
                                <a href="{{ route('login') }}" class="btn btn-outline-light btn-lg btn-modern">
                                    <i class="fas fa-sign-in-alt me-2"></i>Sign In
                                </a>
                            @endauth
                        </div>
                    </div>
                    <div class="col-lg-6 d-none d-lg-block slide-in-right">
                        <div class="text-center">
                            <div class="gradient-border p-4 d-inline-block">
                                <i class="fas fa-chart-line text-primary" style="font-size: 8rem;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section class="py-5 bg-custom-light">
            <div class="section-divider"></div>
            <div class="container py-5">
                <div class="row justify-content-center text-center mb-5">
                    <div class="col-lg-8 slide-in-left">
                        <h2 class="display-5 fw-bold mb-4">
                            <span class="gradient-text">Powerful Features</span>
                        </h2>
                        <p class="lead text-muted">
                            Everything you need to manage complaints efficiently and provide excellent customer service
                        </p>
                    </div>
                </div>

                <div class="row g-4">
                    <div class="col-md-6 col-lg-3">
                        <div class="feature-card p-4 h-100 text-center">
                            <div class="feature-icon primary">
                                <i class="fas fa-plus"></i>
                            </div>
                            <h4 class="fw-bold mb-3">Easy Submission</h4>
                            <p class="text-muted">
                                Submit complaints quickly with our user-friendly form. Categorize and prioritize issues for efficient handling.
                            </p>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-3">
                        <div class="feature-card p-4 h-100 text-center">
                            <div class="feature-icon secondary">
                                <i class="fas fa-chart-line"></i>
                            </div>
                            <h4 class="fw-bold mb-3">Real-time Tracking</h4>
                            <p class="text-muted">
                                Track the status of your complaints in real-time. Get instant updates on progress and resolution.
                            </p>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-3">
                        <div class="feature-card p-4 h-100 text-center">
                            <div class="feature-icon accent">
                                <i class="fas fa-users"></i>
                            </div>
                            <h4 class="fw-bold mb-3">Role-based Access</h4>
                            <p class="text-muted">
                                Secure role-based access control for users, staff, and administrators with appropriate permissions.
                            </p>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-3">
                        <div class="feature-card p-4 h-100 text-center">
                            <div class="feature-icon success">
                                <i class="fas fa-file-alt"></i>
                            </div>
                            <h4 class="fw-bold mb-3">Smart Reports</h4>
                            <p class="text-muted">
                                Generate detailed reports and analytics to monitor performance and identify areas for improvement.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Stats Section -->
        <section class="py-5" style="background: var(--primary-gradient);">
            <div class="container">
                <div class="row g-4 text-center">
                    <div class="col-md-4">
                        <div class="stats-card p-4">
                            <div class="display-4 fw-bold text-white mb-2">99%</div>
                            <div class="text-white-75 fs-5">Resolution Rate</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="stats-card p-4">
                            <div class="display-4 fw-bold text-white mb-2">24/7</div>
                            <div class="text-white-75 fs-5">Support Available</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="stats-card p-4">
                            <div class="display-4 fw-bold text-white mb-2">5min</div>
                            <div class="text-white-75 fs-5">Average Response</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="py-5 bg-custom-dark">
            <div class="section-divider-reverse"></div>
            <div class="container py-5">
                <div class="row justify-content-center text-center">
                    <div class="col-lg-8">
                        <h2 class="display-5 fw-bold text-white mb-4">Ready to Get Started?</h2>
                        <p class="lead text-white-75 mb-5" style="color: white;">
                            Join thousands of organizations that trust our complaint management system
                        </p>
                        <div class="d-flex flex-column flex-sm-row gap-3 justify-content-center">
                            @auth
                                @if(Auth::user() && Auth::user()->isAdmin())
                                    <a href="{{ route('admin.dashboard') }}" class="btn btn-primary btn-lg btn-modern">
                                        <i class="fas fa-rocket me-2"></i>Access Dashboard
                                    </a>
                                @elseif(Auth::user() && Auth::user()->isStaff())
                                    <a href="{{ route('staff.dashboard') }}" class="btn btn-primary btn-lg btn-modern">
                                        <i class="fas fa-rocket me-2"></i>Access Dashboard
                                    </a>
                                @else
                                    <a href="{{ route('dashboard') }}" class="btn btn-primary btn-lg btn-modern">
                                        <i class="fas fa-rocket me-2"></i>Access Dashboard
                                    </a>
                                @endif
                            @else
                                <a href="{{ route('register') }}" class="btn btn-primary btn-lg btn-modern">
                                    <i class="fas fa-user-plus me-2"></i>Start Free Trial
                                </a>
                                <a href="{{ route('login') }}" class="btn btn-outline-light btn-lg btn-modern">
                                    <i class="fas fa-sign-in-alt me-2"></i>Sign In
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="bg-custom-dark text-white py-5">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-6 text-center text-md-start">
                        <div class="d-flex align-items-center justify-content-center justify-content-md-start mb-3">
                            <div class="bg-primary rounded-lg p-2 me-2">
                                <i class="fas fa-shield-alt text-white"></i>
                            </div>
                            <span class="gradient-text fw-bold fs-4">CSRTS</span>
                        </div>
                        <p class="text-white-75 mb-0">&copy; 2024 Complaint & Service Request Tracking System. All rights reserved.</p>
                    </div>
                    <div class="col-md-6 text-center text-md-end mt-3 mt-md-0">
                        <div class="d-flex justify-content-center justify-content-md-end gap-3">
                            <a href="#" class="text-white-50 hover:text-white transition-colors">
                                <i class="fab fa-twitter fs-4"></i>
                            </a>
                            <a href="#" class="text-white-50 hover:text-white transition-colors">
                                <i class="fab fa-facebook fs-4"></i>
                            </a>
                            <a href="#" class="text-white-50 hover:text-white transition-colors">
                                <i class="fab fa-linkedin fs-4"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </footer>

        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        
        <script>
            // Navbar scroll effect
            window.addEventListener('scroll', function() {
                const navbar = document.getElementById('mainNavbar');
                if (window.scrollY > 50) {
                    navbar.classList.add('scrolled');
                } else {
                    navbar.classList.remove('scrolled');
                }
            });

            // Intersection Observer for animations
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            }, observerOptions);

            // Observe feature cards
            document.querySelectorAll('.feature-card').forEach(card => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(30px)';
                card.style.transition = 'all 0.6s ease-out';
                observer.observe(card);
            });

            // Smooth scrolling for anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });
        </script>
    </body>
</html>
