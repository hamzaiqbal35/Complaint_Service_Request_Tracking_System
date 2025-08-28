<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }} - Login</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --primary-color: #0d9488;
            --primary-dark: #0f766e;
            --primary-light: #14b8a6;
            --secondary-color: #059669;
            --accent-color: #f59e0b;
            --success-color: #10b981;
            --warning-color: #f59e0b;
            --danger-color: #ef4444;
            --dark-color: #1f2937;
            --light-color: #f8fafc;
            --white-color: #ffffff;
            
            --primary-gradient: linear-gradient(135deg, #0d9488 0%, #059669 100%);
            --hero-gradient: linear-gradient(135deg, #0d9488 0%, #059669 50%, #047857 100%);
        }

        body {
            font-family: 'Figtree', sans-serif;
            background: var(--hero-gradient);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(15px);
            border-radius: 20px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            width: 100%;
            max-width: 400px;
        }

        .login-header {
            background: var(--primary-gradient);
            color: white;
            padding: 2rem;
            text-align: center;
        }

        .login-body {
            padding: 2rem;
        }

        .form-floating {
            margin-bottom: 1rem;
        }

        .form-control {
            border-radius: 10px;
            border: 2px solid #e5e7eb;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(13, 148, 136, 0.25);
        }

        .btn-primary {
            background: var(--primary-gradient);
            border: none;
            border-radius: 10px;
            padding: 12px 24px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(13, 148, 136, 0.3);
        }

        .alert {
            border-radius: 10px;
            border: none;
        }

        .loading {
            display: none;
        }

        .spinner-border-sm {
            width: 1rem;
            height: 1rem;
        }

        .role-selector {
            margin-bottom: 1rem;
        }

        .role-btn {
            background: #f8f9fa;
            border: 2px solid #e5e7eb;
            border-radius: 10px;
            padding: 10px 15px;
            margin: 5px;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .role-btn.active {
            background: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
        }

        .role-btn:hover {
            border-color: var(--primary-color);
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <div class="mb-3">
                <i class="fas fa-shield-alt fa-3x"></i>
            </div>
            <h3 class="mb-0">Welcome Back</h3>
            <p class="mb-0 opacity-75">Sign in to your account</p>
        </div>

        <div class="login-body">
            <div id="alert-container"></div>

            <form id="loginForm">
                <div class="form-floating">
                    <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com" required>
                    <label for="email">Email address</label>
                </div>

                <div class="form-floating">
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                    <label for="password">Password</label>
                </div>

                <div class="role-selector">
                    <label class="form-label">Login as:</label>
                    <div class="d-flex justify-content-center">
                        <button type="button" class="role-btn active" data-role="user">
                            <i class="fas fa-user me-2"></i>User
                        </button>
                        <button type="button" class="role-btn" data-role="staff">
                            <i class="fas fa-tools me-2"></i>Staff
                        </button>
                        <button type="button" class="role-btn" data-role="admin">
                            <i class="fas fa-crown me-2"></i>Admin
                        </button>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-100" id="loginBtn">
                    <span class="btn-text">Sign In</span>
                    <span class="loading">
                        <span class="spinner-border spinner-border-sm me-2" role="status"></span>
                        Signing in...
                    </span>
                </button>
            </form>

            <div class="text-center mt-3">
                <a href="{{ route('register') }}" class="text-decoration-none">Don't have an account? Register</a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        class AuthManager {
            constructor() {
                this.baseUrl = '/api';
                this.tokenKey = 'jwt_token';
                this.userKey = 'user_data';
                this.currentRole = 'user';
                this.init();
            }

            init() {
                this.setupEventListeners();
                this.checkExistingAuth();
            }

            setupEventListeners() {
                document.getElementById('loginForm').addEventListener('submit', (e) => this.handleLogin(e));
                
                // Role selector
                document.querySelectorAll('.role-btn').forEach(btn => {
                    btn.addEventListener('click', (e) => this.selectRole(e));
                });
            }

            selectRole(e) {
                document.querySelectorAll('.role-btn').forEach(btn => btn.classList.remove('active'));
                e.target.classList.add('active');
                this.currentRole = e.target.dataset.role;
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
                    loading.style.display = 'inline-block';
                    btn.disabled = true;
                } else {
                    btnText.style.display = 'inline-block';
                    loading.style.display = 'none';
                    btn.disabled = false;
                }
            }

            showAlert(message, type) {
                const alertContainer = document.getElementById('alert-container');
                const alertHtml = `
                    <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                        <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-triangle'} me-2"></i>
                        ${message}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
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
    </script>
</body>
</html>
