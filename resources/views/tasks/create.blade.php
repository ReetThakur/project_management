<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">{{ __('Create Task') }}</h2>
    </x-slot>
    <div class="py-8">
        <div class="max-w-2xl mx-auto">
            <div class="rounded-2xl bg-white dark:bg-gray-800 shadow-sm p-8">
                <form action="{{ route('projects.tasks.store', $project) }}" method="POST" class="space-y-6">
                    @csrf
                    <div>
                        <x-input-label for="title" :value="__('Title')" class="mb-1" />
                        <x-text-input id="title" name="title" type="text" class="block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white text-black placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" :value="old('title')" required autofocus />
                        <x-input-error class="mt-2" :messages="$errors->get('title')" />
                    </div>
                    <div>
                        <x-input-label for="description" :value="__('Description')" class="mb-1" />
                        <textarea id="description" name="description" rows="4" class="block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white text-black placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>{{ old('description') }}</textarea>
                        <x-input-error class="mt-2" :messages="$errors->get('description')" />
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <x-input-label for="status" :value="__('Status')" class="mb-1" />
                            <select id="status" name="status" class="block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white text-black focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                                <option value="todo" {{ old('status') === 'todo' ? 'selected' : '' }}>To Do</option>
                                <option value="in_progress" {{ old('status') === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="done" {{ old('status') === 'done' ? 'selected' : '' }}>Done</option>
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('status')" />
                        </div>
                        <div>
                            <x-input-label for="priority" :value="__('Priority')" class="mb-1" />
                            <select id="priority" name="priority" class="block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white text-black focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                                <option value="low" {{ old('priority') === 'low' ? 'selected' : '' }}>Low</option>
                                <option value="medium" {{ old('priority') === 'medium' ? 'selected' : '' }}>Medium</option>
                                <option value="high" {{ old('priority') === 'high' ? 'selected' : '' }}>High</option>
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('priority')" />
                        </div>
                    </div>
                    <div>
                        <x-input-label for="assigned_to" :value="__('Assign To')" class="mb-1" />
                        <select id="assigned_to" name="assigned_to" class="block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white text-black focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ old('assigned_to') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                            @endforeach
                        </select>
                        <x-input-error class="mt-2" :messages="$errors->get('assigned_to')" />
                    </div>
                    <div>
                        <x-input-label for="due_date" :value="__('Due Date')" class="mb-1" />
                        <x-text-input id="due_date" name="due_date" type="date" class="block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white text-black focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" :value="old('due_date')" required />
                        <x-input-error class="mt-2" :messages="$errors->get('due_date')" />
                    </div>
                    <div class="flex items-center gap-4">
                        <x-primary-button>{{ __('Create Task') }}</x-primary-button>
                        <a href="{{ route('projects.show', $project) }}" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 font-medium">{{ __('Cancel') }}</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout> 