@extends(auth()->check() && auth()->user()->role === 'admin' ? 'layouts.admin' : 'layouts.app')

@section('content')
    <div class="{{ auth()->user()->role === 'admin' ? 'mb-8' : 'py-12 px-4 sm:px-6 lg:px-8 max-w-5xl mx-auto space-y-8' }}">
        
        @if(auth()->user()->role === 'admin')
            <h2 class="text-3xl font-black text-slate-800 tracking-tight">
                {{ __('Account Settings') }}
            </h2>
            <p class="text-slate-500 mt-1">Manage your profile, password, and account security.</p>
        @else
            <!-- For users, we add a similar header since x-slot name="header" is not used with extends -->
            <div class="mb-8">
                <h2 class="text-3xl font-black text-slate-800 tracking-tight">
                    {{ __('Account Settings') }}
                </h2>
                <p class="text-slate-500 mt-1">Manage your profile, password, and account security.</p>
            </div>
        @endif
        
    </div>

    <div class="{{ auth()->user()->role === 'admin' ? 'max-w-5xl space-y-8' : 'px-4 sm:px-6 lg:px-8 max-w-5xl mx-auto space-y-8' }}">
        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-6 sm:p-10 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-64 h-64 bg-teal-500/5 rounded-full blur-3xl -z-10"></div>
            @include('profile.partials.update-profile-information-form')
        </div>

        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-6 sm:p-10 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-64 h-64 bg-blue-500/5 rounded-full blur-3xl -z-10"></div>
            @include('profile.partials.update-password-form')
        </div>

        @if(auth()->user()->role === 'user')
            <div class="bg-slate-900 rounded-3xl shadow-[0_15px_40px_-10px_rgba(15,23,42,0.4)] border border-slate-800 p-6 sm:p-10 relative overflow-hidden">
                <div class="absolute right-[-20%] bottom-[-20%] w-64 h-64 bg-rose-500/10 rounded-full blur-3xl"></div>
                @include('profile.partials.delete-user-form')
            </div>
        @endif
    </div>
@endsection
