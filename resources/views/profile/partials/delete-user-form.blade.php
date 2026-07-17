<section class="relative">
    <header>
        <h2 class="text-2xl font-bold text-white flex items-center gap-3">
            <div class="w-10 h-10 rounded-lg bg-rose-500/20 text-rose-400 flex items-center justify-center border border-rose-500/30">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            Delete Account
        </h2>
        <p class="mt-3 text-sm text-slate-400 max-w-xl">
            Deleting your account means your profile will no longer be accessible and active complaints will be withdrawn. Resolved and historical complaints will remain in our records for audit purposes. This action cannot be undone.
        </p>
    </header>

    <div class="mt-8">
        <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')" class="px-6 py-3 rounded-xl font-bold text-white bg-rose-600 hover:bg-rose-500 transition-all shadow-md shadow-rose-600/20 border border-rose-500 flex items-center gap-2">
            <i class="fas fa-trash-alt"></i> Delete Account
        </button>
    </div>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-8">
            @csrf
            @method('delete')

            <h2 class="text-xl font-bold text-slate-900 flex items-center gap-3">
                <i class="fas fa-exclamation-circle text-rose-600"></i> Are you sure you want to delete your account?
            </h2>

            <p class="mt-3 text-sm text-slate-600">
                <ul class="list-disc pl-5 mb-4 text-sm text-slate-600 space-y-1">
                    <li>Your profile will no longer be accessible.</li>
                    <li>Pending and In-Progress complaints will be automatically withdrawn.</li>
                    <li>Resolved, rejected, and withdrawn complaints will remain in our records for legal and audit purposes.</li>
                    <li>Your account will be deactivated and closed.</li>
                </ul>
                Please enter your password to confirm you would like to permanently close your account.
            </p>

            <div class="mt-6" x-data="{ showPassword: false }">
                <label for="password" class="sr-only">Password</label>
                <div class="relative">
                    <input id="password" name="password" x-bind:type="showPassword ? 'text' : 'password'" placeholder="Password"
                           class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-rose-500/20 focus:border-rose-500 outline-none transition-all text-slate-700 bg-slate-50 focus:bg-white placeholder-slate-400 pr-12">
                    <button type="button" @click="showPassword = !showPassword" class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-rose-500 focus:outline-none transition-colors">
                        <i class="fas fa-fw" :class="showPassword ? 'fa-eye-slash' : 'fa-eye'"></i>
                    </button>
                </div>
                @if($errors->userDeletion->has('password'))
                    <p class="mt-2 text-sm text-rose-500"><i class="fas fa-exclamation-circle mr-1"></i>{{ $errors->userDeletion->first('password') }}</p>
                @endif
            </div>

            <div class="mt-8 flex justify-end gap-3 pt-6 border-t border-slate-100">
                <button type="button" x-on:click="$dispatch('close')" class="px-6 py-2.5 rounded-xl font-medium text-slate-600 bg-slate-100 hover:bg-slate-200 transition-colors">
                    Cancel
                </button>

                <button type="submit" class="px-6 py-2.5 rounded-xl font-medium text-white bg-rose-600 hover:bg-rose-500 transition-all shadow-sm">
                    Delete Account
                </button>
            </div>
        </form>
    </x-modal>
</section>
