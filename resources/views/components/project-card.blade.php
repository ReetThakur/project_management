@props(['project'])

<div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
    <div class="flex justify-between items-start">
        <div>
            <h3 class="text-lg font-semibold">
                <a href="{{ route('projects.show', $project) }}" class="text-blue-600 dark:text-blue-400 hover:underline">
                    {{ $project->title }}
                </a>
            </h3>
            <p class="text-gray-600 dark:text-gray-300 mt-1">{{ Str::limit($project->description, 100) }}</p>
            <div class="mt-2">
                <x-status-badge :status="$project->status" />
            </div>
        </div>
        <div class="flex space-x-2">
            @can('update', $project)
                <a href="{{ route('projects.edit', $project) }}"
                    class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                    Edit
                </a>
            @endcan
            @can('delete', $project)
                <form action="{{ route('projects.destroy', $project) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300"
                        onclick="return confirm('Are you sure you want to delete this project?')">
                        Delete
                    </button>
                </form>
            @endcan
        </div>
    </div>
    <div class="mt-4 text-sm text-gray-500 dark:text-gray-400">
        <p>Created by: {{ $project->creator->name }}</p>
        <p>Start Date: {{ $project->start_date->format('M d, Y') }}</p>
        <p>Due Date: {{ $project->due_date->format('M d, Y') }}</p>
        <p>Tasks: {{ $project->tasks->count() }}</p>
    </div>
</div> 