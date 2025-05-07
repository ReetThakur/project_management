<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-gray-900 dark:text-gray-100">
                            <h3 class="text-lg font-semibold mb-2">Total Projects</h3>
                            <p class="text-3xl font-bold">{{ $totalProjects }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-gray-900 dark:text-gray-100">
                            <h3 class="text-lg font-semibold mb-2">Tasks Due Today</h3>
                            <p class="text-3xl font-bold">{{ $tasksDueToday }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-gray-900 dark:text-gray-100">
                            <h3 class="text-lg font-semibold mb-2">Tasks Due This Week</h3>
                            <p class="text-3xl font-bold">{{ $tasksDueThisWeek }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Tasks -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-gray-100">Recent Tasks</h3>
                    @if($recentTasks->isEmpty())
                        <p class="text-gray-500 dark:text-gray-400">No tasks found.</p>
                    @else
                        <div class="space-y-4">
                            @foreach($recentTasks as $task)
                                <div class="border-b border-gray-200 dark:border-gray-700 pb-4 last:border-0 last:pb-0">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <h4 class="font-semibold text-gray-900 dark:text-gray-100">{{ $task->title }}</h4>
                                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                                Project: {{ $task->project->title }}
                                            </p>
                                            <div class="mt-1 flex space-x-2">
                                                <span class="px-2 py-1 text-xs rounded-full
                                                    @if($task->priority === 'high')
                                                        bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100
                                                    @elseif($task->priority === 'medium')
                                                        bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100
                                                    @else
                                                        bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100
                                                    @endif">
                                                    {{ ucfirst($task->priority) }}
                                                </span>
                                                <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100">
                                                    {{ ucfirst($task->status) }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">
                                            Due: {{ $task->due_date->format('M d, Y') }}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <!-- Notifications -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-gray-100">Recent Notifications</h3>
                    @if($notifications->isEmpty())
                        <p class="text-gray-500 dark:text-gray-400">No notifications found.</p>
                    @else
                        <div class="space-y-4">
                            @foreach($notifications as $notification)
                                <div class="flex items-start space-x-4">
                                    <div class="flex-1">
                                        <p class="text-gray-900 dark:text-gray-100">{{ $notification->message }}</p>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">
                                            {{ $notification->created_at->diffForHumans() }}
                                        </p>
                                    </div>
                                    <form action="{{ route('notifications.mark-as-read', $notification) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="text-sm text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                            Mark as read
                                        </button>
                                    </form>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
