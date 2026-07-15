<x-guest-layout>
    <div class="p-8">
        <div class="mb-8 text-center">
            <h1 class="text-3xl font-bold text-white mb-2">Welcome Back</h1>
            <p class="text-slate-400">Sign in to your account</p>
        </div>

        <div id="alert-container" class="mb-6"></div>

        <form id="loginForm" class="space-y-6">
            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-slate-300 mb-2">Email Address</label>
                <input id="email" type="email" name="email" required autofocus autocomplete="username" placeholder="name@example.com"
                    class="w-full bg-slate-800/50 border border-slate-700 rounded-xl px-4 py-3 text-white placeholder-slate-500 focus:outline-none focus:border-teal-500 focus:ring-1 focus:ring-teal-500 transition-colors">
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-medium text-slate-300 mb-2">Password</label>
                <div class="relative">
                    <input id="password" type="password" name="password" required autocomplete="current-password" placeholder="Password"
                        class="w-full bg-slate-800/50 border border-slate-700 rounded-xl px-4 py-3 text-white placeholder-slate-500 focus:outline-none focus:border-teal-500 focus:ring-1 focus:ring-teal-500 transition-colors pr-12">
                    <button type="button" class="absolute inset-y-0 right-0 px-4 flex items-center text-slate-400 hover:text-white transition-colors" onclick="togglePasswordVisibility('password', this)">
                        <i class="far fa-eye" id="eye-icon-password"></i>
                    </button>
                </div>
            </div>

            <div class="flex items-center justify-between">
                <a class="text-sm font-medium text-teal-400 hover:text-teal-300 transition-colors" href="{{ route('jwt.forgot.password') }}">
                    Forgot password?
                </a>
            </div>

            <button type="submit" id="loginBtn" class="w-full bg-gradient-to-r from-teal-500 to-emerald-500 hover:from-teal-400 hover:to-emerald-400 text-white font-bold py-3 px-4 rounded-xl shadow-lg shadow-teal-500/25 transition-all duration-200 transform hover:-translate-y-0.5 mt-2 flex items-center justify-center">
                <span class="btn-text">Sign In</span>
                <span class="loading hidden items-center">
                    <i class="fas fa-spinner fa-spin mr-2"></i> Signing in...
                </span>
            </button>
        </form>

        <div class="mt-8 text-center text-sm text-slate-400">
            Don't have an account? 
            <a href="{{ route('register') }}" class="font-medium text-teal-400 hover:text-teal-300 transition-colors">Register</a>
        </div>
    </div>

    @push('scripts')
        <script>
            class AuthManager {
                constructor() {
                    this.baseUrl = '/api';
                    this.tokenKey = 'jwt_token';
                    this.userKey = 'user_data';
                    this.init();
                }

                init() {
                    this.setupEventListeners();
                    this.checkExistingAuth();
                }

                setupEventListeners() {
                    document.getElementById('loginForm').addEventListener('submit', (e) => this.handleLogin(e));
                }

                async handleLogin(e) {
                    e.preventDefault();
                    
                    const formData = new FormData(e.target);
                    const credentials = {
                        email: formData.get('email'),
                        password: formData.get('password')
                    };

                    this.showLoading(true);
                    this.clearAlerts();

                    try {
                        const response = await fetch(`${this.baseUrl}/login`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: JSON.stringify(credentials)
                        });

                        const data = await response.json();

                        if (response.ok) {
                            this.handleSuccessfulLogin(data);
                        } else {
                            this.showAlert(data.message || 'Login failed', 'danger');
                        }
                    } catch (error) {
                        this.showAlert('Network error. Please try again.', 'danger');
                    } finally {
                        this.showLoading(false);
                    }
                }

                handleSuccessfulLogin(data) {
                    // Store token and user data
                    localStorage.setItem(this.tokenKey, data.authorization.token);
                    localStorage.setItem(this.userKey, JSON.stringify(data.user));
                    
                    this.showAlert('Login successful! Redirecting...', 'success');
                    
                    // Redirect based on role
                    setTimeout(() => {
                        this.redirectToDashboard(data.user.role);
                    }, 1000);
                }

                redirectToDashboard(role) {
                    let redirectUrl = '/dashboard';
                    
                    switch(role) {
                        case 'admin':
                            redirectUrl = '/admin/complaints';
                            break;
                        case 'staff':
                            redirectUrl = '/staff/complaints';
                            break;
                        case 'user':
                        default:
                            redirectUrl = '/dashboard';
                            break;
                    }
                    
                    window.location.href = redirectUrl;
                }

                checkExistingAuth() {
                    const token = localStorage.getItem(this.tokenKey);
                    const userData = localStorage.getItem(this.userKey);
                    
                    if (token && userData) {
                        try {
                            const user = JSON.parse(userData);
                            this.redirectToDashboard(user.role);
                        } catch (error) {
                            this.clearAuth();
                        }
                    }
                }

                clearAuth() {
                    localStorage.removeItem(this.tokenKey);
                    localStorage.removeItem(this.userKey);
                }

                showLoading(show) {
                    const btn = document.getElementById('loginBtn');
                    const btnText = btn.querySelector('.btn-text');
                    const loading = btn.querySelector('.loading');
                    
                    if (show) {
                        btnText.style.display = 'none';
                        loading.style.display = 'inline-flex';
                        btn.disabled = true;
                    } else {
                        btnText.style.display = 'inline-block';
                        loading.style.display = 'none';
                        btn.disabled = false;
                    }
                }

                showAlert(message, type) {
                    const alertContainer = document.getElementById('alert-container');
                    
                    // Tailwind styles mapping
                    let bgColor, textColor, borderColor, icon;
                    if(type === 'success') {
                        bgColor = 'bg-emerald-500/10';
                        borderColor = 'border-emerald-500/20';
                        textColor = 'text-emerald-400';
                        icon = 'fa-check-circle';
                    } else {
                        bgColor = 'bg-rose-500/10';
                        borderColor = 'border-rose-500/20';
                        textColor = 'text-rose-400';
                        icon = 'fa-exclamation-triangle';
                    }

                    const alertHtml = `
                        <div class="flex items-start ${bgColor} border ${borderColor} ${textColor} px-4 py-3 rounded-xl text-sm font-medium" role="alert">
                            <i class="fas ${icon} mt-0.5 mr-2"></i>
                            <div class="flex-1">${message}</div>
                        </div>
                    `;
                    alertContainer.innerHTML = alertHtml;
                }

                clearAlerts() {
                    document.getElementById('alert-container').innerHTML = '';
                }
            }

            // Initialize auth manager
            document.addEventListener('DOMContentLoaded', () => {
                new AuthManager();
            });

            function togglePasswordVisibility(fieldId, button) {
                const field = document.getElementById(fieldId);
                const type = field.getAttribute('type') === 'password' ? 'text' : 'password';
                field.setAttribute('type', type);
                
                const icon = button.querySelector('i');
                if (type === 'text') {
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                } else {
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                }
            }
        </script>
    @endpush
</x-guest-layout>
