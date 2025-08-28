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

                    <form method="POST" action="{{ route('login') }}" class="space-y-5">
                        @csrf

                        <!-- Email Address -->
                        <div>
                            <x-input-label for="email" :value="__('Email address')" class="text-gray-700" />
                            <x-text-input id="email" class="block mt-1 w-full rounded-xl border-gray-300 focus:border-emerald-500 focus:ring-emerald-500" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <!-- Password -->
                        <div>
                            <div class="flex items-center justify-between">
                                <x-input-label for="password" :value="__('Password')" class="text-gray-700" />
                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}" class="text-sm text-emerald-600 hover:text-emerald-700 font-medium">Forgot?</a>
                                @endif
                            </div>

                            <x-text-input id="password" class="block mt-1 w-full rounded-xl border-gray-300 focus:border-emerald-500 focus:ring-emerald-500" type="password" name="password" required autocomplete="current-password" />
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <!-- Remember Me -->
                        <div class="flex items-center justify-between">
                            <label for="remember_me" class="inline-flex items-center">
                                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-emerald-600 shadow-sm focus:ring-emerald-500" name="remember">
                                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                            </label>
                            <a href="{{ route('register') }}" class="text-sm text-gray-500 hover:text-gray-700">Create account</a>
                        </div>

                        <x-primary-button class="w-full justify-center bg-emerald-600 hover:bg-emerald-700 focus:bg-emerald-700 active:bg-emerald-800 border-0 rounded-xl py-3 text-base font-semibold">
                            {{ __('Sign in') }}
                        </x-primary-button>
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
</x-guest-layout>
