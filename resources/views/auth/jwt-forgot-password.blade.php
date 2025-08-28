<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }} - Forgot Password</title>
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

        .forgot-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(15px);
            border-radius: 20px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            width: 100%;
            max-width: 400px;
        }

        .forgot-header {
            background: var(--primary-gradient);
            color: white;
            padding: 2rem;
            text-align: center;
        }

        .forgot-body {
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
    </style>
</head>
<body>
    <div class="forgot-container">
        <div class="forgot-header">
            <div class="mb-3">
                <i class="fas fa-key fa-3x"></i>
            </div>
            <h3 class="mb-0">Forgot Password</h3>
            <p class="mb-0 opacity-75">Enter your email to reset your password</p>
        </div>

        <div class="forgot-body">
            <div id="alert-container"></div>

            <form id="forgotForm">
                <div class="form-floating">
                    <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com" required>
                    <label for="email">Email address</label>
                </div>

                <button type="submit" class="btn btn-primary w-100" id="submitBtn">
                    <span class="btn-text">Send Reset Link</span>
                    <span class="loading">
                        <span class="spinner-border spinner-border-sm me-2" role="status"></span>
                        Sending...
                    </span>
                </button>
            </form>

            <div class="text-center mt-3">
                <a href="{{ route('jwt.login') }}" class="text-decoration-none">
                    <i class="fas fa-arrow-left me-1"></i>Back to Login
                </a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        class ForgotPasswordManager {
            constructor() {
                this.baseUrl = '/api';
                this.init();
            }

            init() {
                this.setupEventListeners();
            }

            setupEventListeners() {
                document.getElementById('forgotForm').addEventListener('submit', (e) => this.handleSubmit(e));
            }

            async handleSubmit(e) {
                e.preventDefault();
                
                const formData = new FormData(e.target);
                const email = formData.get('email');

                this.showLoading(true);
                this.clearAlerts();

                try {
                    const response = await fetch(`${this.baseUrl}/forgot-password`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({ email })
                    });

                    const data = await response.json();

                    if (response.ok) {
                        this.showAlert(data.message || 'Reset link sent successfully!', 'success');
                        document.getElementById('forgotForm').reset();
                    } else {
                        this.showAlert(data.message || 'Failed to send reset link', 'danger');
                    }
                } catch (error) {
                    this.showAlert('Network error. Please try again.', 'danger');
                } finally {
                    this.showLoading(false);
                }
            }

            showLoading(show) {
                const btn = document.getElementById('submitBtn');
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

        // Initialize forgot password manager
        document.addEventListener('DOMContentLoaded', () => {
            new ForgotPasswordManager();
        });
    </script>
</body>
</html>
