@extends('layouts.app')

@section('content')
<div class="min-h-screen">
    <main class="p-4">
        @if (session('success'))
            <div class="mb-4 rounded bg-green-100 border border-green-200 text-green-800 px-4 py-2">
                {{ session('success') }}
            </div>
        @endif
        @yield('admin')
    </main>
</div>
@endsection
