<x-guest-layout>
    <div class="p-8">
        <div class="mb-8 text-center">
            <h1 class="text-3xl font-bold text-white mb-2">Forgot Password</h1>
            <p class="text-slate-400">Enter your email to reset your password</p>
        </div>

        <div id="alert-container" class="mb-6"></div>

        <form id="forgotForm" class="space-y-6">
            <!-- Email Address -->
            <div>
                <label for="email" class="block text-sm font-medium text-slate-300 mb-2">Email address</label>
                <input id="email" type="email" name="email" required autofocus placeholder="name@example.com"
                    class="w-full bg-slate-800/50 border border-slate-700 rounded-xl px-4 py-3 text-white placeholder-slate-500 focus:outline-none focus:border-teal-500 focus:ring-1 focus:ring-teal-500 transition-colors">
            </div>

            <button type="submit" id="submitBtn" class="w-full bg-gradient-to-r from-teal-500 to-emerald-500 hover:from-teal-400 hover:to-emerald-400 text-white font-bold py-3 px-4 rounded-xl shadow-lg shadow-teal-500/25 transition-all duration-200 transform hover:-translate-y-0.5 mt-2 flex items-center justify-center">
                <span class="btn-text">Send Reset Link</span>
                <span class="loading hidden items-center">
                    <i class="fas fa-spinner fa-spin mr-2"></i> Sending...
                </span>
            </button>
            
            <div class="mt-8 text-center text-sm text-slate-400">
                <a href="{{ route('jwt.login') }}" class="font-medium text-teal-400 hover:text-teal-300 transition-colors">
                    <i class="fas fa-arrow-left me-1"></i> Back to Login
                </a>
            </div>
        </form>
    </div>

    @push('scripts')
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

            // Initialize forgot password manager
            document.addEventListener('DOMContentLoaded', () => {
                new ForgotPasswordManager();
            });
        </script>
    @endpush
</x-guest-layout>
