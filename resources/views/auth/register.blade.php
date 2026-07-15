<x-guest-layout>
    <div class="p-8">
        <div class="mb-8 text-center">
            <h1 class="text-3xl font-bold text-white mb-2">Create Account</h1>
            <p class="text-slate-400">Join to start tracking complaints</p>
        </div>

        <form method="POST" action="{{ route('register') }}" class="space-y-5">
            @csrf

            <!-- Name -->
            <div>
                <label for="name" class="block text-sm font-medium text-slate-300 mb-2">Full Name</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" 
                    class="w-full bg-slate-800/50 border border-slate-700 rounded-xl px-4 py-3 text-white placeholder-slate-500 focus:outline-none focus:border-teal-500 focus:ring-1 focus:ring-teal-500 transition-colors">
                <x-input-error :messages="$errors->get('name')" class="mt-2 text-rose-400" />
            </div>

            <!-- Email Address -->
            <div>
                <label for="email" class="block text-sm font-medium text-slate-300 mb-2">Email Address</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" 
                    class="w-full bg-slate-800/50 border border-slate-700 rounded-xl px-4 py-3 text-white placeholder-slate-500 focus:outline-none focus:border-teal-500 focus:ring-1 focus:ring-teal-500 transition-colors">
                <x-input-error :messages="$errors->get('email')" class="mt-2 text-rose-400" />
            </div>

            <input type="hidden" name="role" value="user">

            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-medium text-slate-300 mb-2">Password</label>
                <div class="relative">
                    <input id="password" type="password" name="password" required autocomplete="new-password" 
                        class="w-full bg-slate-800/50 border border-slate-700 rounded-xl px-4 py-3 text-white placeholder-slate-500 focus:outline-none focus:border-teal-500 focus:ring-1 focus:ring-teal-500 transition-colors pr-12">
                    <button type="button" class="absolute inset-y-0 right-0 px-4 flex items-center text-slate-400 hover:text-white transition-colors" onclick="togglePasswordVisibility('password', this)">
                        <i class="far fa-eye" id="eye-icon-password"></i>
                    </button>
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-2 text-rose-400" />
            </div>

            <!-- Confirm Password -->
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-slate-300 mb-2">Confirm Password</label>
                <div class="relative">
                    <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" 
                        class="w-full bg-slate-800/50 border border-slate-700 rounded-xl px-4 py-3 text-white placeholder-slate-500 focus:outline-none focus:border-teal-500 focus:ring-1 focus:ring-teal-500 transition-colors pr-12">
                    <button type="button" class="absolute inset-y-0 right-0 px-4 flex items-center text-slate-400 hover:text-white transition-colors" onclick="togglePasswordVisibility('password_confirmation', this)">
                        <i class="far fa-eye" id="eye-icon-password_confirmation"></i>
                    </button>
                </div>
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-rose-400" />
            </div>

            <button type="submit" class="w-full mt-6 bg-gradient-to-r from-teal-500 to-emerald-500 hover:from-teal-400 hover:to-emerald-400 text-white font-bold py-3 px-4 rounded-xl shadow-lg shadow-teal-500/25 transition-all duration-200 transform hover:-translate-y-0.5">
                Create Account
            </button>
        </form>

        <div class="mt-6 text-center text-sm text-slate-400">
            Already have an account? 
            <a href="{{ route('login') }}" class="font-medium text-teal-400 hover:text-teal-300 transition-colors">Sign in</a>
        </div>
    </div>

    @push('scripts')
        <script>
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