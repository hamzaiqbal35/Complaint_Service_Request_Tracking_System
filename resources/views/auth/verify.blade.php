<x-guest-layout>
    <div class="p-8">
        <div class="mb-8 text-center">
            <div class="w-16 h-16 bg-emerald-500/10 rounded-2xl flex items-center justify-center mx-auto mb-4 border border-emerald-500/20 shadow-inner">
                <i class="fas fa-envelope-open-text text-2xl text-emerald-400"></i>
            </div>
            <h1 class="text-3xl font-bold text-white mb-2">Verify Your Email</h1>
            <p class="text-slate-400">
                Before proceeding, please check your email for a verification link.
            </p>
        </div>

        @if (session('resent'))
            <div class="mb-6 bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 px-4 py-3 rounded-xl text-sm font-medium text-center">
                <i class="fas fa-check-circle mr-2"></i> A fresh verification link has been sent to your email address.
            </div>
        @endif

        <div class="mt-4 flex flex-col items-center justify-center gap-4 text-center">
            <p class="text-slate-400 text-sm">If you did not receive the email,</p>
            <form method="POST" action="{{ route('verification.resend') }}" class="w-full">
                @csrf
                <button type="submit" class="w-full bg-gradient-to-r from-teal-500 to-emerald-500 hover:from-teal-400 hover:to-emerald-400 text-white font-bold py-3 px-6 rounded-xl shadow-lg shadow-teal-500/25 transition-all duration-200 transform hover:-translate-y-0.5">
                    Click here to request another
                </button>
            </form>
        </div>
    </div>
</x-guest-layout>
