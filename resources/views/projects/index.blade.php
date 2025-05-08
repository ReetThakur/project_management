<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                {{ __('Projects') }}
            </h2>
            @can('create', App\Models\Project::class)
                <a href="{{ route('projects.create') }}"
                   class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg shadow-sm transition">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Create Project
                </a>
            @endcan
        </div>
    </x-slot>
    <div class="space-y-8">
        <!-- Search and Filter Form -->
        <div class="rounded-2xl bg-white dark:bg-gray-800 shadow-sm p-6">
            <form action="{{ route('projects.index') }}" method="GET" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label for="search" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Search</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                            <input type="text" name="search" id="search" value="{{ request('search') }}"
                                class="block w-full pl-10 pr-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white text-black placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                placeholder="Search projects...">
                        </div>
                    </div>
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status</label>
                        <select name="status" id="status"
                            class="block w-full pl-3 pr-10 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white text-black focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            <option value="">All Statuses</option>
                            <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                            <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                        </select>
                    </div>
                    <div class="flex items-end gap-2">
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg shadow-sm transition">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            Search
                        </button>
                        <a href="{{ route('projects.index') }}"
                            class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white text-sm font-medium rounded-lg shadow-sm transition">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            Clear
                        </a>
                    </div>
                </div>
            </form>
        </div>
        <!-- Projects List -->
        <div class="rounded-2xl bg-white dark:bg-gray-800 shadow-sm p-6">
            @if($projects->isEmpty())
                <div class="flex flex-col items-center justify-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    <h3 class="mt-2 text-sm font-semibold text-gray-900 dark:text-white">No projects found</h3>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Get started by creating a new project.</p>
                    @can('create', App\Models\Project::class)
                        <div class="mt-6">
                            <a href="{{ route('projects.create') }}"
                               class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg shadow-sm transition">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                                Create Project
                            </a>
                        </div>
                    @endcan
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($projects as $project)
                        <x-project-card :project="$project" />
                    @endforeach
                </div>
                <div class="mt-8">
                    {{ $projects->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>