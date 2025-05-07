<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Notifications') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if($notifications->isEmpty())
                        <p class="text-center text-gray-500 dark:text-gray-400">No notifications found.</p>
                    @else
                        <div class="space-y-4">
                            @foreach($notifications as $notification)
                                <div class="flex items-start space-x-4 p-4 {{ $notification->read ? 'bg-gray-50 dark:bg-gray-700' : 'bg-white dark:bg-gray-800' }} rounded-lg">
                                    <div class="flex-1">
                                        <p class="text-gray-900 dark:text-gray-100">{{ $notification->message }}</p>
                                        <div class="mt-2 flex items-center space-x-4 text-sm text-gray-500 dark:text-gray-400">
                                            <span>{{ $notification->created_at->diffForHumans() }}</span>
                                            @if($notification->task)
                                                <a href="{{ route('tasks.show', $notification->task) }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                                    View Task
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="flex space-x-2">
                                        @if(!$notification->read)
                                            <form action="{{ route('notifications.mark-as-read', $notification) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="text-sm text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                                    Mark as read
                                                </button>
                                            </form>
                                        @endif
                                        <x-delete-confirmation 
                                            :route="route('notifications.destroy', $notification)"
                                            title="Delete Notification"
                                            text="Are you sure you want to delete this notification?">
                                            Delete
                                        </x-delete-confirmation>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-6">
                            {{ $notifications->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 