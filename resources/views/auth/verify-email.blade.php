<x-guest-layout>
    <div class="p-8">
        <div class="mb-8 text-center">
            <div class="w-16 h-16 bg-emerald-500/10 rounded-2xl flex items-center justify-center mx-auto mb-4 border border-emerald-500/20 shadow-inner">
                <i class="fas fa-envelope-open-text text-2xl text-emerald-400"></i>
            </div>
            <h1 class="text-3xl font-bold text-white mb-2">Verify Your Email</h1>
            <p class="text-slate-400">
                Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? 
                If you didn't receive the email, we will gladly send you another.
            </p>
        </div>

        @if (session('status') == 'verification-link-sent')
            <div class="mb-6 bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 px-4 py-3 rounded-xl text-sm font-medium text-center">
                <i class="fas fa-check-circle mr-2"></i> A new verification link has been sent to the email address you provided during registration.
            </div>
        @endif

        <div class="mt-4 flex flex-col sm:flex-row items-center justify-between gap-4">
            <form method="POST" action="{{ route('verification.send') }}" class="w-full sm:w-auto flex-1">
                @csrf
                <button type="submit" class="w-full bg-gradient-to-r from-teal-500 to-emerald-500 hover:from-teal-400 hover:to-emerald-400 text-white font-bold py-3 px-6 rounded-xl shadow-lg shadow-teal-500/25 transition-all duration-200 transform hover:-translate-y-0.5">
                    Resend Verification Email
                </button>
            </form>

            <form method="POST" action="{{ route('logout') }}" class="w-full sm:w-auto">
                @csrf
                <button type="submit" class="w-full sm:w-auto px-6 py-3 text-sm font-medium text-slate-400 hover:text-white transition-colors bg-slate-800/50 hover:bg-slate-700/50 rounded-xl border border-slate-700">
                    Log Out
                </button>
            </form>
        </div>
    </div>
</x-guest-layout>
