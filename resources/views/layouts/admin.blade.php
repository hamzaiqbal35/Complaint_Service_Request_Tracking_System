@extends('layouts.app')

@section('content')
<div class="min-h-screen flex">
    <aside class="w-64 bg-gray-900 text-white p-4 hidden md:block">
        <h2 class="text-xl font-semibold mb-4">Admin</h2>
        <nav class="space-y-2">
            <a href="{{ route('admin.complaints.index') }}" class="block px-2 py-1 rounded hover:bg-gray-700">Complaints</a>
        </nav>
    </aside>
    <main class="flex-1 p-4">
        @if (session('success'))
            <div class="mb-4 rounded bg-green-100 border border-green-200 text-green-800 px-4 py-2">
                {{ session('success') }}
            </div>
        @endif
        @yield('admin')
    </main>
    </div>
@endsection


