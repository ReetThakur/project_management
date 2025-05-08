<aside class="fixed inset-y-0 left-0 z-40 w-64 bg-white dark:bg-gray-900 border-r border-gray-200 dark:border-gray-800 flex flex-col justify-between py-6 px-4">
    <div>
        <!-- Logo -->
        <div class="flex items-center space-x-2 mb-8">
            <x-application-logo class="h-8 w-auto text-blue-600 dark:text-blue-400" />
            <span class="text-2xl font-bold text-gray-900 dark:text-white">{{ config('app.name', 'Laravel') }}</span>
        </div>
        <!-- Navigation -->
        <nav class="space-y-2">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800 transition {{ request()->routeIs('dashboard') ? 'bg-gray-100 dark:bg-gray-800' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                Dashboard
            </a>
            <a href="{{ route('projects.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800 transition {{ request()->routeIs('projects.*') ? 'bg-gray-100 dark:bg-gray-800' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                Projects
            </a>
            <a href="{{ route('notifications.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800 transition {{ request()->routeIs('notifications.*') ? 'bg-gray-100 dark:bg-gray-800' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                Notifications
                @if(auth()->user()->unreadNotifications->count() > 0)
                    <span class="ml-auto inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100">
                        {{ auth()->user()->unreadNotifications->count() }}
                    </span>
                @endif
            </a>
        </nav>
    </div>
    <div class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center text-lg font-bold text-gray-600 dark:text-gray-300">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>
            <div>
                <div class="font-semibold text-gray-900 dark:text-white">{{ Auth::user()->name }}</div>
                <div class="text-xs text-gray-500 dark:text-gray-400">{{ Auth::user()->email }}</div>
            </div>
        </div>
    </div>
</aside> 