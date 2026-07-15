<section>
    <header>
        <h2 class="text-2xl font-bold text-slate-800 flex items-center gap-3">
            <div class="w-10 h-10 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center">
                <i class="fas fa-lock"></i>
            </div>
            Update Password
        </h2>
        <p class="mt-2 text-sm text-slate-500">
            Ensure your account is using a long, random password to stay secure.
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-8 space-y-6 max-w-xl">
        @csrf
        @method('put')

        <div x-data="{ showCurrentPassword: false }">
            <label for="update_password_current_password" class="block text-sm font-semibold text-slate-700 mb-2">Current Password</label>
            <div class="relative">
                <input id="update_password_current_password" name="current_password" x-bind:type="showCurrentPassword ? 'text' : 'password'" autocomplete="current-password"
                       class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition-all text-slate-700 bg-slate-50 focus:bg-white placeholder-slate-400 pr-12">
                <button type="button" @click="showCurrentPassword = !showCurrentPassword" class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-blue-500 focus:outline-none transition-colors">
                    <i class="fas fa-fw" :class="showCurrentPassword ? 'fa-eye-slash' : 'fa-eye'"></i>
                </button>
            </div>
            @if($errors->updatePassword->has('current_password'))
                <p class="mt-2 text-sm text-rose-500"><i class="fas fa-exclamation-circle mr-1"></i>{{ $errors->updatePassword->first('current_password') }}</p>
            @endif
        </div>

        <div x-data="{ showNewPassword: false }">
            <label for="update_password_password" class="block text-sm font-semibold text-slate-700 mb-2">New Password</label>
            <div class="relative">
                <input id="update_password_password" name="password" x-bind:type="showNewPassword ? 'text' : 'password'" autocomplete="new-password"
                       class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition-all text-slate-700 bg-slate-50 focus:bg-white placeholder-slate-400 pr-12">
                <button type="button" @click="showNewPassword = !showNewPassword" class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-blue-500 focus:outline-none transition-colors">
                    <i class="fas fa-fw" :class="showNewPassword ? 'fa-eye-slash' : 'fa-eye'"></i>
                </button>
            </div>
            @if($errors->updatePassword->has('password'))
                <p class="mt-2 text-sm text-rose-500"><i class="fas fa-exclamation-circle mr-1"></i>{{ $errors->updatePassword->first('password') }}</p>
            @endif
        </div>

        <div x-data="{ showConfirmPassword: false }">
            <label for="update_password_password_confirmation" class="block text-sm font-semibold text-slate-700 mb-2">Confirm Password</label>
            <div class="relative">
                <input id="update_password_password_confirmation" name="password_confirmation" x-bind:type="showConfirmPassword ? 'text' : 'password'" autocomplete="new-password"
                       class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition-all text-slate-700 bg-slate-50 focus:bg-white placeholder-slate-400 pr-12">
                <button type="button" @click="showConfirmPassword = !showConfirmPassword" class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-blue-500 focus:outline-none transition-colors">
                    <i class="fas fa-fw" :class="showConfirmPassword ? 'fa-eye-slash' : 'fa-eye'"></i>
                </button>
            </div>
            @if($errors->updatePassword->has('password_confirmation'))
                <p class="mt-2 text-sm text-rose-500"><i class="fas fa-exclamation-circle mr-1"></i>{{ $errors->updatePassword->first('password_confirmation') }}</p>
            @endif
        </div>

        <div class="flex items-center gap-4 pt-4 border-t border-slate-100">
            <button type="submit" class="px-6 py-3 rounded-xl font-medium text-white bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 transition-all shadow-md shadow-blue-500/20 flex items-center gap-2">
                <i class="fas fa-key"></i> Update Password
            </button>

            @if (session('status') === 'password-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)" class="text-sm font-medium text-blue-600 flex items-center gap-2">
                    <i class="fas fa-check-circle"></i> Password updated.
                </p>
            @endif
        </div>
    </form>
</section>
