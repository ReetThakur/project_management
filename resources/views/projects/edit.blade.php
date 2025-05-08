<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">{{ __('Edit Project') }}</h2>
    </x-slot>
    <div class="py-8">
        <div class="max-w-2xl mx-auto">
            <div class="rounded-2xl bg-white dark:bg-gray-800 shadow-sm p-8">
                @if(session('success'))
                    <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-4 text-sm" role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif
                <form action="{{ route('projects.update', $project) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')
                    <div>
                        <x-input-label for="title" :value="__('Title')" class="mb-1" />
                        <x-text-input id="title" name="title" type="text" class="block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white text-black placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" :value="old('title', $project->title)" required />
                        <x-input-error class="mt-2" :messages="$errors->get('title')" />
                    </div>
                    <div>
                        <x-input-label for="description" :value="__('Description')" class="mb-1" />
                        <textarea id="description" name="description" rows="4" class="block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white text-black placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>{{ old('description', $project->description) }}</textarea>
                        <x-input-error class="mt-2" :messages="$errors->get('description')" />
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <x-input-label for="start_date" :value="__('Start Date')" class="mb-1" />
                            <x-text-input id="start_date" name="start_date" type="date" class="block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white text-black focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" :value="old('start_date', $project->start_date->format('Y-m-d'))" required />
                            <x-input-error class="mt-2" :messages="$errors->get('start_date')" />
                        </div>
                        <div>
                            <x-input-label for="due_date" :value="__('Due Date')" class="mb-1" />
                            <x-text-input id="due_date" name="due_date" type="date" class="block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white text-black focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" :value="old('due_date', $project->due_date->format('Y-m-d'))" required />
                            <x-input-error class="mt-2" :messages="$errors->get('due_date')" />
                        </div>
                    </div>
                    <div>
                        <x-input-label for="status" :value="__('Status')" class="mb-1" />
                        <select id="status" name="status" class="block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white text-black focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                            <option value="active" {{ old('status', $project->status) === 'active' ? 'selected' : '' }}>Active</option>
                            <option value="completed" {{ old('status', $project->status) === 'completed' ? 'selected' : '' }}>Completed</option>
                        </select>
                        <x-input-error class="mt-2" :messages="$errors->get('status')" />
                    </div>
                    <div class="flex items-center gap-4">
                        <x-primary-button>{{ __('Update Project') }}</x-primary-button>
                        <a href="{{ route('projects.index') }}" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 font-medium">{{ __('Cancel') }}</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
