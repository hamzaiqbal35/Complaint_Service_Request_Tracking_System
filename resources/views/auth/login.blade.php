<x-guest-layout>
    <div class="p-8">
        <div class="mb-8 text-center">
            <h1 class="text-3xl font-bold text-white mb-2">Welcome Back</h1>
            <p class="text-slate-400">Sign in to continue to your dashboard</p>
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form id="login-form" method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-slate-300 mb-2">Email Address</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" 
                    class="w-full bg-slate-800/50 border border-slate-700 rounded-xl px-4 py-3 text-white placeholder-slate-500 focus:outline-none focus:border-teal-500 focus:ring-1 focus:ring-teal-500 transition-colors">
                <x-input-error :messages="$errors->get('email')" class="mt-2 text-rose-400" />
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-medium text-slate-300 mb-2">Password</label>
                <div class="relative">
                    <input id="password" type="password" name="password" required autocomplete="current-password" 
                        class="w-full bg-slate-800/50 border border-slate-700 rounded-xl px-4 py-3 text-white placeholder-slate-500 focus:outline-none focus:border-teal-500 focus:ring-1 focus:ring-teal-500 transition-colors pr-12">
                    <button type="button" class="absolute inset-y-0 right-0 px-4 flex items-center text-slate-400 hover:text-white transition-colors" onclick="togglePasswordVisibility('password', this)">
                        <i class="far fa-eye" id="eye-icon-password"></i>
                    </button>
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-2 text-rose-400" />
            </div>

            <!-- Remember Me -->
            <div class="flex items-center justify-between">
                <label for="remember" class="flex items-center cursor-pointer group">
                    <div class="relative flex items-center">
                        <input id="remember" type="checkbox" name="remember" class="peer sr-only">
                        <div class="w-5 h-5 border-2 border-slate-600 rounded bg-slate-800 peer-checked:bg-teal-500 peer-checked:border-teal-500 transition-colors"></div>
                        <i class="fas fa-check absolute left-[3px] top-[4px] text-[10px] text-white opacity-0 peer-checked:opacity-100 transition-opacity"></i>
                    </div>
                    <span class="ml-3 text-sm text-slate-300 group-hover:text-white transition-colors">Remember me</span>
                </label>

                @if (Route::has('password.request'))
                    <a class="text-sm font-medium text-teal-400 hover:text-teal-300 transition-colors" href="{{ route('password.request') }}">
                        Forgot password?
                    </a>
                @endif
            </div>

            <button type="submit" class="w-full bg-gradient-to-r from-teal-500 to-emerald-500 hover:from-teal-400 hover:to-emerald-400 text-white font-bold py-3 px-4 rounded-xl shadow-lg shadow-teal-500/25 transition-all duration-200 transform hover:-translate-y-0.5 mt-2">
                Sign In
            </button>
        </form>

        <div class="mt-8 text-center text-sm text-slate-400">
            Don't have an account? 
            <a href="{{ route('register') }}" class="font-medium text-teal-400 hover:text-teal-300 transition-colors">Create one now</a>
        </div>
    </div>

    @if(session('jwt_token'))
        <script>
            try {
                localStorage.setItem('jwt_token', @json(session('jwt_token')));
            } catch (e) {}
        </script>
    @endif

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const form = document.getElementById('login-form');
                
                if (form) {
                    form.addEventListener('submit', async function(e) {
                        e.preventDefault();
                        
                        const submitButton = form.querySelector('button[type="submit"]');
                        const originalButtonText = submitButton.innerHTML;
                        
                        try {
                            submitButton.disabled = true;
                            submitButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Signing in...';
                            
                            const formData = new FormData(form);
                            const response = await fetch(form.action, {
                                method: 'POST',
                                headers: {
                                    'Accept': 'application/json',
                                    'X-Requested-With': 'XMLHttpRequest',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                },
                                body: formData
                            });

                            const contentType = response.headers.get('content-type');
                            let data;
                            
                            if (contentType && contentType.includes('application/json')) {
                                data = await response.json();
                            } else {
                                window.location.href = response.url;
                                return;
                            }

                            if (response.ok) {
                                if (data.redirect) {
                                    window.location.href = data.redirect;
                                } else {
                                    window.location.href = '/dashboard';
                                }
                            } else {
                                if (data.errors) {
                                    Object.keys(data.errors).forEach(field => {
                                        const input = form.querySelector(`[name="${field}"]`);
                                        if (input) {
                                            input.classList.add('border-rose-500');
                                            const errorDiv = document.createElement('div');
                                            errorDiv.className = 'text-rose-400 text-sm mt-1';
                                            errorDiv.textContent = data.errors[field][0];
                                            input.parentNode.insertBefore(errorDiv, input.nextSibling);
                                        }
                                    });
                                } else if (data.message) {
                                    alert(data.message);
                                }
                            }
                        } catch (error) {
                            console.error('Login error:', error);
                            alert('An error occurred during login. Please try again.');
                        } finally {
                            submitButton.disabled = false;
                            submitButton.innerHTML = originalButtonText;
                        }
                    });
                }
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
        @vite(['resources/js/app.js'])
    @endpush
</x-guest-layout>