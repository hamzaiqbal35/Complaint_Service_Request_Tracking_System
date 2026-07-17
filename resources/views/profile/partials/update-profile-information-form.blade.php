<section>
    <header>
        <h2 class="text-2xl font-bold text-slate-800 flex items-center gap-3">
            <div class="w-10 h-10 rounded-lg bg-teal-50 text-teal-600 flex items-center justify-center">
                <i class="fas fa-user-edit"></i>
            </div>
            Profile Information
        </h2>
        <p class="mt-2 text-sm text-slate-500">
            Update your account's profile information and email address.
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-8 space-y-6 max-w-xl">
        @csrf
        @method('patch')

        <div>
            <label for="name" class="block text-sm font-semibold text-slate-700 mb-2">Name</label>
            <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name"
                   {{ auth()->user()->isStaff() ? 'readonly disabled' : '' }}
                   class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 outline-none transition-all text-slate-700 {{ auth()->user()->isStaff() ? 'bg-slate-100 cursor-not-allowed' : 'bg-slate-50 focus:bg-white' }} placeholder-slate-400 @error('name') border-rose-500 @enderror">
            @error('name')
                <p class="mt-2 text-sm text-rose-500"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="email" class="block text-sm font-semibold text-slate-700 mb-2">Email</label>
            <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required autocomplete="username"
                   {{ auth()->user()->isStaff() ? 'readonly disabled' : '' }}
                   class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 outline-none transition-all text-slate-700 {{ auth()->user()->isStaff() ? 'bg-slate-100 cursor-not-allowed' : 'bg-slate-50 focus:bg-white' }} placeholder-slate-400 @error('email') border-rose-500 @enderror">
            @error('email')
                <p class="mt-2 text-sm text-rose-500"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
            @enderror

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-4 p-4 bg-amber-50 rounded-xl border border-amber-200">
                    <p class="text-sm text-amber-800">
                        Your email address is unverified.
                        <button form="send-verification" class="font-bold underline hover:text-amber-900 transition-colors">
                            Click here to re-send the verification email.
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-emerald-600 flex items-center gap-2">
                            <i class="fas fa-check-circle"></i> A new verification link has been sent to your email address.
                        </p>
                    @endif
                </div>
            @endif
        </div>

        @if(!auth()->user()->isStaff())
        <div class="flex items-center gap-4 pt-4 border-t border-slate-100">
            <button type="submit" class="px-6 py-3 rounded-xl font-medium text-white bg-gradient-to-r from-teal-500 to-emerald-600 hover:from-teal-600 hover:to-emerald-700 transition-all shadow-md shadow-teal-500/20 flex items-center gap-2">
                <i class="fas fa-save"></i> Save Changes
            </button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)" class="text-sm font-medium text-teal-600 flex items-center gap-2">
                    <i class="fas fa-check-circle"></i> Saved successfully.
                </p>
            @endif
        </div>
        @else
        <div class="pt-4 border-t border-slate-100">
            <p class="text-sm text-slate-500 flex items-start gap-2">
                <i class="fas fa-info-circle text-teal-500 mt-0.5"></i>
                <span>As a staff member, your name and email are managed by the administration and cannot be changed here.</span>
            </p>
        </div>
        @endif
    </form>
</section>
