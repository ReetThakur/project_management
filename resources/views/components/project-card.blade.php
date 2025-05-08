@props(['project'])

<div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 hover:shadow-md transition-shadow duration-200">
    <div class="p-6">
        <div class="flex justify-between items-start">
            <div class="flex-1 min-w-0">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 truncate">
                    <a href="{{ route('projects.show', $project) }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-200">
                        {{ $project->title }}
                    </a>
                </h3>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400 line-clamp-2">
                    {{ $project->description }}
                </p>
                <div class="mt-3">
                    <x-status-badge :status="$project->status" />
                </div>
            </div>
            <div class="ml-4 flex-shrink-0">
                <div class="relative" x-data="{ open: false }" @click.away="open = false">
                    <button @click="open = !open" class="p-1 rounded-full text-gray-400 hover:text-gray-500 dark:hover:text-gray-300 focus:outline-none">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"/>
                        </svg>
                    </button>
                    <div x-show="open" 
                         x-transition:enter="transition ease-out duration-100"
                         x-transition:enter-start="transform opacity-0 scale-95"
                         x-transition:enter-end="transform opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="transform opacity-100 scale-100"
                         x-transition:leave-end="transform opacity-0 scale-95"
                         class="absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white dark:bg-gray-800 ring-1 ring-black ring-opacity-5 z-10">
                        <div class="py-1">
                            @can('update', $project)
                                <a href="{{ route('projects.edit', $project) }}" 
                                   class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                    Edit
                                </a>
                            @endcan
                            @can('delete', $project)
                                <form action="{{ route('projects.destroy', $project) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="flex items-center w-full px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-gray-100 dark:hover:bg-gray-700"
                                            onclick="return confirm('Are you sure you want to delete this project?')">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                        Delete
                                    </button>
                                </form>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-6 border-t border-gray-200 dark:border-gray-700 pt-4">
            <dl class="grid grid-cols-2 gap-4 text-sm">
                <div>
                    <dt class="text-gray-500 dark:text-gray-400">Created by</dt>
                    <dd class="mt-1 text-gray-900 dark:text-gray-100">{{ $project->creator->name }}</dd>
                </div>
                <div>
                    <dt class="text-gray-500 dark:text-gray-400">Tasks</dt>
                    <dd class="mt-1 text-gray-900 dark:text-gray-100">{{ $project->tasks->count() }}</dd>
                </div>
                <div>
                    <dt class="text-gray-500 dark:text-gray-400">Start Date</dt>
                    <dd class="mt-1 text-gray-900 dark:text-gray-100">{{ $project->start_date->format('M d, Y') }}</dd>
                </div>
                <div>
                    <dt class="text-gray-500 dark:text-gray-400">Due Date</dt>
                    <dd class="mt-1 text-gray-900 dark:text-gray-100">{{ $project->due_date->format('M d, Y') }}</dd>
                </div>
            </dl>
        </div>
    </div>
</div> 