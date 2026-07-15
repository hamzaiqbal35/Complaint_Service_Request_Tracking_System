@extends(auth()->check() && auth()->user()->role === 'admin' ? 'layouts.admin' : 'layouts.app')

@section('content')
<div class="{{ auth()->user()->role === 'admin' ? 'mb-8' : 'py-12 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto' }}">
    
    <div class="mb-8 flex justify-between items-end">
        <div>
            <h2 class="text-3xl font-black text-slate-800 tracking-tight">Notifications</h2>
            <p class="text-slate-500 mt-1">View and manage all your notifications.</p>
        </div>
    </div>

    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden relative">
        <div class="p-6 border-b border-slate-100 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <h3 class="font-bold text-slate-700">All Notifications</h3>
            
            <div class="flex items-center gap-3 w-full md:w-auto">
                <!-- Filter Form -->
                <form method="GET" action="{{ route('notifications.index') }}" class="flex items-center gap-2 flex-1 md:flex-none">
                    <select name="status" class="text-sm border-slate-200 rounded-xl focus:ring-teal-500 focus:border-teal-500" onchange="this.form.submit()">
                        <option value="">All Status</option>
                        <option value="unread" {{ request('status') === 'unread' ? 'selected' : '' }}>Unread</option>
                        <option value="read" {{ request('status') === 'read' ? 'selected' : '' }}>Read</option>
                    </select>
                    
                    <select name="sort" class="text-sm border-slate-200 rounded-xl focus:ring-teal-500 focus:border-teal-500" onchange="this.form.submit()">
                        <option value="newest" {{ request('sort') === 'newest' ? 'selected' : '' }}>Newest</option>
                        <option value="oldest" {{ request('sort') === 'oldest' ? 'selected' : '' }}>Oldest</option>
                    </select>
                </form>

                <form action="{{ route('notifications.mark-all-read') }}" method="POST">
                    @csrf
                    <button type="submit" class="text-sm text-teal-600 hover:text-teal-700 font-medium bg-teal-50 hover:bg-teal-100 px-4 py-2 rounded-xl transition-colors whitespace-nowrap">
                        Mark all read
                    </button>
                </form>
            </div>
        </div>

        <form action="{{ route('notifications.bulk-action') }}" method="POST" x-data="{ selected: [] }">
            @csrf
            
            <div x-show="selected.length > 0" x-transition class="bg-indigo-50 px-6 py-3 border-b border-indigo-100 flex items-center justify-between" x-cloak>
                <div class="text-sm text-indigo-800 font-medium">
                    <span x-text="selected.length"></span> items selected
                </div>
                <div class="flex items-center gap-3">
                    <button type="submit" name="action" value="read" class="text-sm bg-white border border-indigo-200 text-indigo-700 hover:bg-indigo-100 px-3 py-1.5 rounded-lg transition-colors shadow-sm font-medium">
                        Mark as Read
                    </button>
                    <button type="submit" name="action" value="delete" class="text-sm bg-white border border-rose-200 text-rose-600 hover:bg-rose-50 px-3 py-1.5 rounded-lg transition-colors shadow-sm font-medium">
                        Delete Selected
                    </button>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/80 border-b border-slate-100 text-xs uppercase tracking-wider text-slate-500 font-semibold">
                            <th class="px-6 py-4 w-12 text-center">
                                <input type="checkbox" 
                                    @click="selected = $event.target.checked ? {{ $notifications->pluck('id') }} : []"
                                    :checked="selected.length === {{ $notifications->count() }} && {{ $notifications->count() }} > 0"
                                    class="w-4 h-4 text-teal-600 bg-white border-slate-300 rounded focus:ring-teal-500 cursor-pointer">
                            </th>
                            <th class="px-6 py-4">Message</th>
                            <th class="px-6 py-4 w-48">Date</th>
                            <th class="px-6 py-4 w-32 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($notifications as $notification)
                            <tr class="hover:bg-slate-50/80 transition-colors {{ $notification->read_at ? 'opacity-70' : 'bg-teal-50/30' }}">
                                <td class="px-6 py-4 text-center">
                                    <input type="checkbox" name="notifications[]" value="{{ $notification->id }}" x-model="selected" class="w-4 h-4 text-teal-600 bg-white border-slate-300 rounded focus:ring-teal-500 cursor-pointer">
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-start gap-3">
                                        @if(!$notification->read_at)
                                            <div class="w-2 h-2 mt-2 bg-teal-500 rounded-full flex-shrink-0"></div>
                                        @endif
                                        <div>
                                            <p class="font-bold text-slate-800">{{ $notification->data['title'] ?? 'Notification' }}</p>
                                            <p class="text-sm text-slate-600 mt-0.5">{{ $notification->data['message'] ?? '' }}</p>
                                            @if(isset($notification->data['url']))
                                                <a href="{{ $notification->data['url'] }}" class="text-xs text-teal-600 hover:text-teal-700 font-medium mt-2 inline-block">View Details &rarr;</a>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-500">
                                    {{ $notification->created_at->format('M d, Y h:i A') }}
                                    <div class="text-xs text-slate-400 mt-1">{{ $notification->created_at->diffForHumans() }}</div>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        @if(!$notification->read_at)
                                            <button type="submit" name="action" value="read" formaction="{{ route('notifications.mark-read', $notification->id) }}" class="w-8 h-8 rounded-lg bg-white border border-slate-200 flex items-center justify-center text-slate-400 hover:text-teal-600 hover:border-teal-200 hover:bg-teal-50 transition-all shadow-sm tooltip" title="Mark as Read">
                                                <i class="fas fa-check-circle text-sm"></i>
                                            </button>
                                        @endif
                                        <button type="submit" name="_method" value="DELETE" formaction="{{ route('notifications.destroy', $notification->id) }}" class="w-8 h-8 rounded-lg bg-white border border-slate-200 flex items-center justify-center text-slate-400 hover:text-rose-600 hover:border-rose-200 hover:bg-rose-50 transition-all shadow-sm tooltip" title="Delete">
                                            <i class="fas fa-trash text-sm"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center">
                                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-slate-100 text-slate-400 mb-4">
                                        <i class="fas fa-bell text-2xl"></i>
                                    </div>
                                    <h3 class="text-lg font-bold text-slate-700">No Notifications</h3>
                                    <p class="text-slate-500 mt-1">You don't have any notifications yet.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </form>
        
        @if($notifications->hasPages())
            <div class="p-6 border-t border-slate-100 bg-slate-50/50">
                {{ $notifications->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
