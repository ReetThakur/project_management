<x-app-layout>
    <x-slot name="header">
        Dashboard
    </x-slot>
    <div class="space-y-8">
        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="rounded-2xl bg-white dark:bg-gray-800 shadow-sm p-6 flex items-center gap-4">
                <div class="p-3 rounded-xl bg-blue-100 dark:bg-blue-900 flex items-center justify-center">
                    <svg class="w-7 h-7 text-blue-600 dark:text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
                <div>
                    <div class="text-sm text-gray-500 dark:text-gray-400 font-medium mb-1">Total Projects</div>
                    <div class="text-2xl font-bold text-gray-900 dark:text-white">{{ $totalProjects }}</div>
                </div>
            </div>
            <div class="rounded-2xl bg-white dark:bg-gray-800 shadow-sm p-6 flex items-center gap-4">
                <div class="p-3 rounded-xl bg-yellow-100 dark:bg-yellow-900 flex items-center justify-center">
                    <svg class="w-7 h-7 text-yellow-600 dark:text-yellow-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <div class="text-sm text-gray-500 dark:text-gray-400 font-medium mb-1">Tasks Due Today</div>
                    <div class="text-2xl font-bold text-gray-900 dark:text-white">{{ $tasksDueToday }}</div>
                </div>
            </div>
            <div class="rounded-2xl bg-white dark:bg-gray-800 shadow-sm p-6 flex items-center gap-4">
                <div class="p-3 rounded-xl bg-green-100 dark:bg-green-900 flex items-center justify-center">
                    <svg class="w-7 h-7 text-green-600 dark:text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div>
                    <div class="text-sm text-gray-500 dark:text-gray-400 font-medium mb-1">Tasks Due This Week</div>
                    <div class="text-2xl font-bold text-gray-900 dark:text-white">{{ $tasksDueThisWeek }}</div>
                </div>
            </div>
        </div>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Recent Tasks Card -->
            <div class="rounded-2xl bg-white dark:bg-gray-800 shadow-sm p-6 flex flex-col min-h-[320px]">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Recent Tasks</h3>
                    <a href="{{ route('projects.index') }}" class="text-sm text-blue-600 hover:underline">View all</a>
                </div>
                @if($recentTasks->isEmpty())
                    <div class="flex flex-col items-center justify-center flex-1 py-8">
                        <svg class="mx-auto h-12 w-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">No tasks found</p>
                    </div>
                @else
                    <div class="space-y-4">
                        @foreach($recentTasks as $task)
                            <div class="flex items-start space-x-4 p-4 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-200">
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center justify-between">
                                        <h4 class="text-base font-semibold text-gray-900 dark:text-white truncate">{{ $task->title }}</h4>
                                        <span class="text-xs text-gray-500 dark:text-gray-400">{{ $task->due_date->format('M d, Y') }}</span>
                                    </div>
                                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400 truncate">{{ $task->project->title }}</p>
                                    <div class="mt-2 flex space-x-2">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium @if($task->priority === 'high') bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100 @elseif($task->priority === 'medium') bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100 @else bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100 @endif">{{ ucfirst($task->priority) }}</span>
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100">{{ ucfirst($task->status) }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
            <!-- Notifications Card -->
            <div class="rounded-2xl bg-white dark:bg-gray-800 shadow-sm p-6 flex flex-col min-h-[320px]">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Recent Notifications</h3>
                    <a href="{{ route('notifications.index') }}" class="text-sm text-blue-600 hover:underline">View all</a>
                </div>
                @if($notifications->isEmpty())
                    <div class="flex flex-col items-center justify-center flex-1 py-8">
                        <svg class="mx-auto h-12 w-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                        </svg>
                        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">No notifications found</p>
                    </div>
                @else
                    <div class="space-y-4">
                        @foreach($notifications as $notification)
                            <div class="flex items-start space-x-4 p-4 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-200">
                                <div class="flex-shrink-0">
                                    <div class="p-2 rounded-full bg-blue-100 dark:bg-blue-900">
                                        <svg class="w-4 h-4 text-blue-600 dark:text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </div>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm text-gray-900 dark:text-white">{{ $notification->message }}</p>
                                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">{{ $notification->created_at->diffForHumans() }}</p>
                                </div>
                                <form action="{{ route('notifications.mark-as-read', $notification) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="text-xs text-blue-600 hover:underline">Mark as read</button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
