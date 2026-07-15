<x-guest-layout>
    <div class="p-8">
        <div class="mb-8 text-center">
            <h1 class="text-3xl font-bold text-white mb-2">Reset Password</h1>
            <p class="text-slate-400">Forgot your password? No problem. Just let us know your email address and we will email you a password reset link.</p>
        </div>

        <!-- Session Status -->
        @if (session('status'))
            <div class="mb-6 bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 px-4 py-3 rounded-xl text-sm font-medium">
                <i class="fas fa-check-circle mr-2"></i> {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
            @csrf

            <!-- Email Address -->
            <div>
                <label for="email" class="block text-sm font-medium text-slate-300 mb-2">Email Address</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                    class="w-full bg-slate-800/50 border border-slate-700 rounded-xl px-4 py-3 text-white placeholder-slate-500 focus:outline-none focus:border-teal-500 focus:ring-1 focus:ring-teal-500 transition-colors">
                <x-input-error :messages="$errors->get('email')" class="mt-2 text-rose-400" />
            </div>

            <button type="submit" class="w-full bg-gradient-to-r from-teal-500 to-emerald-500 hover:from-teal-400 hover:to-emerald-400 text-white font-bold py-3 px-4 rounded-xl shadow-lg shadow-teal-500/25 transition-all duration-200 transform hover:-translate-y-0.5 mt-2">
                Email Password Reset Link
            </button>
            
            <div class="mt-8 text-center text-sm text-slate-400">
                Remember your password? 
                <a href="{{ route('login') }}" class="font-medium text-teal-400 hover:text-teal-300 transition-colors">Sign in here</a>
            </div>
        </form>
    </div>
</x-guest-layout>
