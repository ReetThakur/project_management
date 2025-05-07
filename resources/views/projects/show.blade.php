<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ $project->title }}
            </h2>
            <div class="flex space-x-2">
                @can('update', $project)
                    <a href="{{ route('projects.edit', $project) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Edit Project
                    </a>
                @endcan
                @can('delete', $project)
                    <form action="{{ route('projects.destroy', $project) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded"
                            onclick="return confirm('Are you sure you want to delete this project?')">
                            Delete Project
                        </button>
                    </form>
                @endcan
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Project Details -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-lg font-semibold mb-2">Project Details</h3>
                            <p class="text-gray-600 dark:text-gray-300 mb-4">{{ $project->description }}</p>
                            <div class="space-y-2">
                                <p><span class="font-semibold">Status:</span> 
                                    <x-status-badge :status="$project->status" />
                                </p>
                                <p><span class="font-semibold">Start Date:</span> {{ $project->start_date->format('M d, Y') }}</p>
                                <p><span class="font-semibold">Due Date:</span> {{ $project->due_date->format('M d, Y') }}</p>
                                <p><span class="font-semibold">Created by:</span> {{ $project->creator->name }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tasks Section -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold">Tasks</h3>
                        @can('create', [App\Models\Task::class, $project])
                            <a href="{{ route('projects.tasks.create', $project) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Add Task
                            </a>
                        @endcan
                    </div>

                    @if($project->tasks->isEmpty())
                        <p class="text-center text-gray-500 dark:text-gray-400">No tasks found for this project.</p>
                    @else
                        <div class="space-y-4">
                            @foreach($project->tasks as $task)
                                <x-task-card :task="$task" />
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
