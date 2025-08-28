<x-guest-layout>
    <div class="min-h-[75vh] flex items-center justify-center bg-gradient-to-br from-emerald-600 via-teal-600 to-cyan-600/90 py-10">
        <div class="w-full max-w-md">
            <div class="bg-white/95 backdrop-blur rounded-2xl shadow-xl overflow-hidden ring-1 ring-black/5">
                <div class="px-6 py-5 bg-gradient-to-r from-emerald-600 to-teal-600 text-white">
                    <div class="flex items-center gap-3">
                        <div class="h-10 w-10 rounded-xl bg-white/20 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </div>
                        <div>
                            <h1 class="text-xl font-bold">Create Account</h1>
                            <p class="text-white/80 text-sm">Join and start tracking complaints</p>
                        </div>
                    </div>
                </div>

                <div class="px-6 py-6">
                    <form method="POST" action="{{ route('register') }}" class="space-y-5">
                        @csrf

                        <!-- Name -->
                        <div>
                            <x-input-label for="name" :value="__('Full name')" class="text-gray-700" />
                            <x-text-input id="name" class="block mt-1 w-full rounded-xl border-gray-300 focus:border-emerald-500 focus:ring-emerald-500" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <!-- Email Address -->
                        <div>
                            <x-input-label for="email" :value="__('Email address')" class="text-gray-700" />
                            <x-text-input id="email" class="block mt-1 w-full rounded-xl border-gray-300 focus:border-emerald-500 focus:ring-emerald-500" type="email" name="email" :value="old('email')" required autocomplete="username" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <!-- Role -->
                        <div>
                            <x-input-label for="role" :value="__('Register as')" class="text-gray-700" />
                            <select id="role" name="role" class="block mt-1 w-full rounded-xl border-gray-300 focus:border-emerald-500 focus:ring-emerald-500" required>
                                <option value="user" {{ old('role') === 'user' ? 'selected' : '' }}>User</option>
                                <option value="staff" {{ old('role') === 'staff' ? 'selected' : '' }}>Staff</option>
                            </select>
                            <x-input-error :messages="$errors->get('role')" class="mt-2" />
                        </div>

                        <!-- Password -->
                        <div>
                            <x-input-label for="password" :value="__('Password')" class="text-gray-700" />
                            <x-text-input id="password" class="block mt-1 w-full rounded-xl border-gray-300 focus:border-emerald-500 focus:ring-emerald-500" type="password" name="password" required autocomplete="new-password" />
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <!-- Confirm Password -->
                        <div>
                            <x-input-label for="password_confirmation" :value="__('Confirm password')" class="text-gray-700" />
                            <x-text-input id="password_confirmation" class="block mt-1 w-full rounded-xl border-gray-300 focus:border-emerald-500 focus:ring-emerald-500" type="password" name="password_confirmation" required autocomplete="new-password" />
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                        </div>

                        <x-primary-button class="w-full justify-center bg-emerald-600 hover:bg-emerald-700 focus:bg-emerald-700 active:bg-emerald-800 border-0 rounded-xl py-3 text-base font-semibold">
                            {{ __('Create account') }}
                        </x-primary-button>

                        <div class="text-center text-sm text-gray-500">
                            Already have an account?
                            <a href="{{ route('login') }}" class="text-emerald-600 hover:text-emerald-700 font-medium">Sign in</a>
                        </div>
                    </form>
                </div>
            </div>

            <p class="text-center text-white/90 text-xs mt-4">Only Users & Staff can self-register</p>
        </div>
    </div>
</x-guest-layout>
