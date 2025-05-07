@props(['task'])

<div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
    <div class="flex justify-between items-start">
        <div>
            <h3 class="text-lg font-semibold">
                <a href="{{ route('tasks.show', $task) }}" class="text-blue-600 dark:text-blue-400 hover:underline">
                    {{ $task->title }}
                </a>
            </h3>
            <p class="text-gray-600 dark:text-gray-300 mt-1">{{ Str::limit($task->description, 100) }}</p>
            <div class="mt-2 flex space-x-2">
                <x-status-badge :status="$task->status" />
                <x-status-badge :status="$task->priority" />
            </div>
        </div>
        <div class="flex space-x-2">
            @can('update', $task)
                <a href="{{ route('tasks.edit', $task) }}"
                    class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                    Edit
                </a>
            @endcan
            @can('delete', $task)
                <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300"
                        onclick="return confirm('Are you sure you want to delete this task?')">
                        Delete
                    </button>
                </form>
            @endcan
        </div>
    </div>
    <div class="mt-4 text-sm text-gray-500 dark:text-gray-400">
        <p>Project: <a href="{{ route('projects.show', $task->project) }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">{{ $task->project->title }}</a></p>
        <p>Assigned to: {{ $task->assignee->name }}</p>
        <p>Due: {{ $task->due_date->format('M d, Y') }}</p>
    </div>
</div> 