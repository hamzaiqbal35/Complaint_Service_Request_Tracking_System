<x-guest-layout>
    <div class="min-h-[75vh] flex items-center justify-center bg-gradient-to-br from-emerald-600 via-teal-600 to-cyan-600/90 py-10">
        <div class="w-full max-w-md">
            <div class="bg-white/95 backdrop-blur rounded-2xl shadow-xl overflow-hidden ring-1 ring-black/5">
                <div class="px-6 py-5 bg-gradient-to-r from-emerald-600 to-teal-600 text-white">
                    <div class="flex items-center gap-3">
                        <div class="h-10 w-10 rounded-xl bg-white/20 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 01.163-.163l1.767-1.767a2.4 2.4 0 013.394 0l1.767 1.767c.058.058.112.119.163.183a2.4 2.4 0 002.28.72l2.49-.498a2.4 2.4 0 012.807 2.807l-.498 2.49a2.4 2.4 0 00.72 2.28c.064.051.125.105.183.163l1.767 1.767a2.4 2.4 0 010 3.394l-1.767 1.767a2.4 2.4 0 01-3.394 0l-1.767-1.767a2.4 2.4 0 00-2.28-.72l-2.49.498a2.4 2.4 0 01-2.807-2.807l.498-2.49a2.4 2.4 0 00-.72-2.28 6.945 6.945 0 01-.163-.183L8.229 5.08a2.4 2.4 0 011.606-.383z"/></svg>
                        </div>
                        <div>
                            <h1 class="text-xl font-bold">Welcome Back</h1>
                            <p class="text-white/80 text-sm">Sign in to continue</p>
                        </div>
                    </div>
                </div>

                <div class="px-6 py-6">
                    <!-- Session Status -->
                    <x-auth-session-status class="mb-4" :status="session('status')" />

                    <form id="login-form" method="POST" action="{{ route('login') }}" class="space-y-6">
                        @csrf

                        <!-- Email -->
                        <div>
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <!-- Password -->
                        <div class="mt-4">
                            <x-input-label for="password" :value="__('Password')" />
                            <div class="relative">
                                <x-text-input id="password" class="block mt-1 w-full pr-10"
                                            type="password"
                                            name="password"
                                            required autocomplete="current-password" />
                                <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-600 hover:text-gray-800"
                                        onclick="togglePasswordVisibility('password', this)">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                            </div>
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <!-- Remember Me -->
                        <div class="block mt-4">
                            <label for="remember" class="inline-flex items-center">
                                <input id="remember" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                            </label>
                        </div>

                        <div class="flex items-center justify-between mt-4">
                            @if (Route::has('password.request'))
                                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                                    {{ __('Forgot your password?') }}
                                </a>
                            @endif

                            <x-primary-button type="submit" class="ms-3">
                                {{ __('Log in') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>

            <p class="text-center text-white/90 text-xs mt-4">Protected by best practices</p>
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
                            // Show loading state
                            submitButton.disabled = true;
                            submitButton.innerHTML = 'Signing in...';
                            
                            const formData = new FormData(form);
                            const response = await window.axios.post(form.action, {
                                email: formData.get('email'),
                                password: formData.get('password'),
                                remember: formData.get('remember')
                            });
                            
                            // Store the token
                            if (response.data.token) {
                                if (window.auth && typeof window.auth.setToken === 'function') {
                                    window.auth.setToken(response.data.token);
                                    
                                    // Redirect based on response or default
                                    const redirectTo = response.data.redirect_to || '/dashboard';
                                    window.location.href = redirectTo;
                                } else {
                                    console.error('Auth module not loaded');
                                    alert('Authentication error. Please refresh the page and try again.');
                                }
                            }
                        } catch (error) {
                            console.error('Login error:', error);
                            let errorMessage = 'An error occurred during login';
                            
                            if (error.response) {
                                if (error.response.data.message) {
                                    errorMessage = error.response.data.message;
                                } else if (error.response.status === 422) {
                                    errorMessage = 'Invalid email or password';
                                }
                            }
                            
                            // Show error message
                            if (window.Swal) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Login Failed',
                                    text: errorMessage,
                                    confirmButtonColor: '#3085d6',
                                });
                            } else {
                                alert(errorMessage);
                            }
                        } finally {
                            // Reset button state
                            submitButton.disabled = false;
                            submitButton.innerHTML = originalButtonText;
                        }
                    });
                }
            });
        </script>
        <script>
            function togglePasswordVisibility(fieldId, button) {
                const field = document.getElementById(fieldId);
                const type = field.getAttribute('type') === 'password' ? 'text' : 'password';
                field.setAttribute('type', type);
                
                // Toggle icon directly in the clicked button
                const icon = button.querySelector('svg');
                if (type === 'text') {
                    icon.innerHTML = `
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                    `;
                } else {
                    icon.innerHTML = `
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    `;
                }
            }
        </script>
        @vite(['resources/js/app.js'])
    @endpush
</x-guest-layout>