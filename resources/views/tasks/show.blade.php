<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ $task->title }}
            </h2>
            <div class="flex space-x-2">
                @can('update', $task)
                    <a href="{{ route('tasks.edit', $task) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Edit Task
                    </a>
                @endcan
                @can('delete', $task)
                    <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded"
                            onclick="return confirm('Are you sure you want to delete this task?')">
                            Delete Task
                        </button>
                    </form>
                @endcan
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Task Details -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-lg font-semibold mb-2">Task Details</h3>
                            <p class="text-gray-600 dark:text-gray-300 mb-4">{{ $task->description }}</p>
                            <div class="space-y-2">
                                <p><span class="font-semibold">Status:</span> 
                                    <span class="px-2 py-1 text-sm rounded-full bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100">
                                        {{ ucfirst($task->status) }}
                                    </span>
                                </p>
                                <p><span class="font-semibold">Priority:</span>
                                    <span class="px-2 py-1 text-sm rounded-full bg-purple-100 text-purple-800 dark:bg-purple-800 dark:text-purple-100">
                                        {{ ucfirst($task->priority) }}
                                    </span>
                                </p>
                                <p><span class="font-semibold">Due Date:</span> {{ $task->due_date->format('M d, Y') }}</p>
                                <p><span class="font-semibold">Assigned to:</span> {{ $task->assignee->name }}</p>
                                <p><span class="font-semibold">Project:</span> 
                                    <a href="{{ route('projects.show', $task->project) }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                        {{ $task->project->title }}
                                    </a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Comments Section -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold mb-4">Comments</h3>
                        
                        <!-- Comment Form -->
                        <form action="{{ route('tasks.comments.store', $task) }}" method="POST" class="mb-6">
                            @csrf
                            <div>
                                <x-input-label for="content" :value="__('Add a comment')" />
                                <textarea id="content" name="content" rows="3" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm" required>{{ old('content') }}</textarea>
                                <x-input-error class="mt-2" :messages="$errors->get('content')" />
                            </div>
                            <div class="mt-4">
                                <x-primary-button>{{ __('Post Comment') }}</x-primary-button>
                            </div>
                        </form>

                        <!-- Comments List -->
                        @if($task->comments->isEmpty())
                            <p class="text-center text-gray-500 dark:text-gray-400">No comments yet.</p>
                        @else
                            <div class="space-y-4">
                                @foreach($task->comments->sortByDesc('created_at') as $comment)
                                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                        <div class="flex justify-between items-start">
                                            <div class="flex-grow">
                                                <div class="flex items-center space-x-2">
                                                    <span class="font-semibold">{{ $comment->user->name }}</span>
                                                    <span class="text-gray-500 dark:text-gray-400 text-sm">
                                                        {{ $comment->created_at->diffForHumans() }}
                                                    </span>
                                                </div>
                                                <p class="mt-2 text-gray-600 dark:text-gray-300">{{ $comment->content }}</p>
                                            </div>
                                            @can('delete', $comment)
                                                <form action="{{ route('comments.destroy', $comment) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300"
                                                        onclick="return confirm('Are you sure you want to delete this comment?')">
                                                        Delete
                                                    </button>
                                                </form>
                                            @endcan
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
