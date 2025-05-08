<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">{{ __('Notifications') }}</h2>
    </x-slot>
    <div class="py-8">
        <div class="max-w-3xl mx-auto">
            <div class="rounded-2xl bg-white dark:bg-gray-800 shadow-sm p-8">
                @if($notifications->isEmpty())
                    <div class="flex flex-col items-center justify-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                        </svg>
                        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">No notifications found.</p>
                    </div>
                @else
                    <div class="space-y-4">
                        @foreach($notifications as $notification)
                            <div class="flex items-start space-x-4 p-4 rounded-xl shadow-sm {{ $notification->read ? 'bg-gray-50 dark:bg-gray-700' : 'bg-white dark:bg-gray-800' }}">
                                <div class="flex-1">
                                    <p class="text-gray-900 dark:text-white">{{ $notification->message }}</p>
                                    <div class="mt-2 flex items-center space-x-4 text-sm text-gray-500 dark:text-gray-400">
                                        <span>{{ $notification->created_at->diffForHumans() }}</span>
                                        @if($notification->task)
                                            <a href="{{ route('tasks.show', $notification->task) }}" class="text-blue-600 hover:underline">View Task</a>
                                        @endif
                                    </div>
                                </div>
                                <div class="flex space-x-2">
                                    @if(!$notification->read)
                                        <form action="{{ route('notifications.mark-as-read', $notification) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="text-xs text-blue-600 hover:underline font-medium">Mark as read</button>
                                        </form>
                                    @endif
                                    <x-delete-confirmation 
                                        :route="route('notifications.destroy', $notification)"
                                        title="Delete Notification"
                                        text="Are you sure you want to delete this notification?">
                                        <span class="text-xs text-red-600 hover:underline font-medium">Delete</span>
                                    </x-delete-confirmation>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-8">
                        {{ $notifications->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout> 