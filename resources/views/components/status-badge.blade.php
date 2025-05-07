@props(['status'])

@php
$classes = match($status) {
    'active' => 'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100',
    'completed' => 'bg-gray-100 text-gray-800 dark:bg-gray-600 dark:text-gray-100',
    'todo' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100',
    'in_progress' => 'bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100',
    'done' => 'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100',
    'high' => 'bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100',
    'medium' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100',
    'low' => 'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100',
    default => 'bg-gray-100 text-gray-800 dark:bg-gray-600 dark:text-gray-100',
};
@endphp

<span {{ $attributes->merge(['class' => 'px-2 py-1 text-xs rounded-full ' . $classes]) }}>
    {{ ucfirst($status) }}
</span> 