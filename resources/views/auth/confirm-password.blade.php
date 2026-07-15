<x-guest-layout>
    <div class="p-8">
        <div class="mb-8 text-center">
            <h1 class="text-3xl font-bold text-white mb-2">Secure Area</h1>
            <p class="text-slate-400">Please confirm your password before continuing.</p>
        </div>

        <form method="POST" action="{{ route('password.confirm') }}" class="space-y-6">
            @csrf

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

            <button type="submit" class="w-full bg-gradient-to-r from-teal-500 to-emerald-500 hover:from-teal-400 hover:to-emerald-400 text-white font-bold py-3 px-4 rounded-xl shadow-lg shadow-teal-500/25 transition-all duration-200 transform hover:-translate-y-0.5 mt-2">
                Confirm Password
            </button>
        </form>
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
    @endpush
</x-guest-layout>
