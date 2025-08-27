<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Complaint & Service Request Tracking System</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            .gradient-bg {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            }
            .hero-gradient {
                background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            }
            .floating {
                animation: floating 3s ease-in-out infinite;
            }
            @keyframes floating {
                0%, 100% { transform: translateY(0px); }
                50% { transform: translateY(-20px); }
            }
            .fade-in {
                animation: fadeIn 1s ease-in;
            }
            @keyframes fadeIn {
                from { opacity: 0; transform: translateY(30px); }
                to { opacity: 1; transform: translateY(0); }
            }
            .slide-in {
                animation: slideIn 0.8s ease-out;
            }
            @keyframes slideIn {
                from { transform: translateX(-100px); opacity: 0; }
                to { transform: translateX(0); opacity: 1; }
            }
            .pulse-glow {
                animation: pulseGlow 2s ease-in-out infinite alternate;
            }
            @keyframes pulseGlow {
                from { box-shadow: 0 0 20px rgba(59, 130, 246, 0.5); }
                to { box-shadow: 0 0 30px rgba(59, 130, 246, 0.8); }
            }
            .feature-card {
                transition: all 0.3s ease;
            }
            .feature-card:hover {
                transform: translateY(-10px);
                box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            }
            .glass-effect {
                background: rgba(255, 255, 255, 0.1);
                backdrop-filter: blur(10px);
                border: 1px solid rgba(255, 255, 255, 0.2);
            }
        </style>
    </head>
    <body class="antialiased">
        <!-- Navigation -->
        <nav class="bg-white/90 backdrop-blur-md shadow-lg fixed w-full z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <h1 class="text-2xl font-bold gradient-bg bg-clip-text text-transparent">
                                <i class="fas fa-shield-alt mr-2"></i>CSRTS
                            </h1>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200">
                                <i class="fas fa-tachometer-alt mr-1"></i>Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200">
                                <i class="fas fa-sign-in-alt mr-1"></i>Log in
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white px-4 py-2 rounded-md text-sm font-medium transition-all duration-200 pulse-glow">
                                    <i class="fas fa-user-plus mr-1"></i>Register
                                </a>
                            @endif
                        @endauth
                    </div>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <div class="relative overflow-hidden hero-gradient min-h-screen">
            <div class="absolute inset-0 bg-black opacity-20"></div>
            <div class="absolute inset-0">
                <div class="absolute inset-0 bg-gradient-to-r from-blue-600/20 to-purple-600/20"></div>
            </div>
            
            <!-- Floating Elements -->
            <div class="absolute top-20 left-10 w-20 h-20 bg-white/10 rounded-full floating"></div>
            <div class="absolute top-40 right-20 w-16 h-16 bg-white/10 rounded-full floating" style="animation-delay: 1s;"></div>
            <div class="absolute bottom-20 left-1/4 w-12 h-12 bg-white/10 rounded-full floating" style="animation-delay: 2s;"></div>
            
            <div class="relative z-10 flex items-center justify-center min-h-screen">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="text-center fade-in">
                        <h1 class="text-5xl md:text-7xl font-extrabold text-white mb-6 leading-tight">
                            <span class="block">Efficient Complaint</span>
                            <span class="block text-yellow-300">Management System</span>
                        </h1>
                        <p class="mt-6 text-xl text-white/90 max-w-3xl mx-auto leading-relaxed">
                            Streamline your complaint and service request tracking with our comprehensive management system. 
                            Submit, track, and resolve issues efficiently with real-time updates and detailed reporting.
                        </p>
                        <div class="mt-10 flex flex-col sm:flex-row gap-4 justify-center">
                            @auth
                                <a href="{{ url('/dashboard') }}" class="inline-flex items-center px-8 py-4 border-2 border-white text-white font-semibold rounded-full text-lg hover:bg-white hover:text-blue-600 transition-all duration-300 transform hover:scale-105">
                                    <i class="fas fa-rocket mr-2"></i>Go to Dashboard
                                </a>
                            @else
                                <a href="{{ route('register') }}" class="inline-flex items-center px-8 py-4 bg-white text-blue-600 font-semibold rounded-full text-lg hover:bg-gray-100 transition-all duration-300 transform hover:scale-105 shadow-lg">
                                    <i class="fas fa-play mr-2"></i>Get Started Free
                                </a>
                                <a href="{{ route('login') }}" class="inline-flex items-center px-8 py-4 border-2 border-white text-white font-semibold rounded-full text-lg hover:bg-white hover:text-blue-600 transition-all duration-300 transform hover:scale-105">
                                    <i class="fas fa-sign-in-alt mr-2"></i>Sign In
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Features Section -->
        <div class="py-20 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16 slide-in">
                    <h2 class="text-4xl font-bold text-gray-900 mb-4">
                        <span class="gradient-bg bg-clip-text text-transparent">Powerful Features</span>
                    </h2>
                    <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                        Everything you need to manage complaints efficiently and provide excellent customer service
                    </p>
                </div>

                <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                    <div class="feature-card bg-white p-8 rounded-2xl shadow-lg text-center">
                        <div class="w-16 h-16 bg-gradient-to-r from-blue-500 to-purple-500 rounded-full flex items-center justify-center mx-auto mb-6">
                            <i class="fas fa-plus text-white text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-4">Easy Submission</h3>
                        <p class="text-gray-600">
                            Submit complaints quickly with our user-friendly form. Categorize and prioritize issues for efficient handling.
                        </p>
                    </div>

                    <div class="feature-card bg-white p-8 rounded-2xl shadow-lg text-center">
                        <div class="w-16 h-16 bg-gradient-to-r from-green-500 to-teal-500 rounded-full flex items-center justify-center mx-auto mb-6">
                            <i class="fas fa-chart-line text-white text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-4">Real-time Tracking</h3>
                        <p class="text-gray-600">
                            Track the status of your complaints in real-time. Get instant updates on progress and resolution.
                        </p>
                    </div>

                    <div class="feature-card bg-white p-8 rounded-2xl shadow-lg text-center">
                        <div class="w-16 h-16 bg-gradient-to-r from-purple-500 to-pink-500 rounded-full flex items-center justify-center mx-auto mb-6">
                            <i class="fas fa-users text-white text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-4">Role-based Access</h3>
                        <p class="text-gray-600">
                            Secure role-based access control for users, staff, and administrators with appropriate permissions.
                        </p>
                    </div>

                    <div class="feature-card bg-white p-8 rounded-2xl shadow-lg text-center">
                        <div class="w-16 h-16 bg-gradient-to-r from-orange-500 to-red-500 rounded-full flex items-center justify-center mx-auto mb-6">
                            <i class="fas fa-file-alt text-white text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-4">Smart Reports</h3>
                        <p class="text-gray-600">
                            Generate detailed reports and analytics to monitor performance and identify areas for improvement.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Section -->
        <div class="py-20 bg-gradient-to-r from-blue-600 to-purple-600">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
                    <div class="glass-effect p-8 rounded-2xl">
                        <div class="text-4xl font-bold text-white mb-2">99%</div>
                        <div class="text-white/80">Resolution Rate</div>
                    </div>
                    <div class="glass-effect p-8 rounded-2xl">
                        <div class="text-4xl font-bold text-white mb-2">24/7</div>
                        <div class="text-white/80">Support Available</div>
                    </div>
                    <div class="glass-effect p-8 rounded-2xl">
                        <div class="text-4xl font-bold text-white mb-2">5min</div>
                        <div class="text-white/80">Average Response</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="bg-gray-900 text-white">
            <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <div class="flex justify-center space-x-6 mb-4">
                        <a href="#" class="text-gray-400 hover:text-white transition-colors duration-200">
                            <i class="fab fa-twitter text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors duration-200">
                            <i class="fab fa-facebook text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors duration-200">
                            <i class="fab fa-linkedin text-xl"></i>
                        </a>
                    </div>
                    <p class="text-gray-400">&copy; 2024 Complaint & Service Request Tracking System. All rights reserved.</p>
                </div>
            </div>
        </footer>

        <script>
            // Add scroll animations
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

            document.querySelectorAll('.feature-card').forEach(card => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(30px)';
                card.style.transition = 'all 0.6s ease-out';
                observer.observe(card);
            });
        </script>
    </body>
</html>
