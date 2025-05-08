<header class="sticky top-0 z-30 w-full bg-white/80 dark:bg-gray-900/80 backdrop-blur border-b border-gray-200 dark:border-gray-800">
    <div class="flex items-center justify-between h-16 px-6">
        <!-- Left: Placeholder for future breadcrumbs or page title -->
        <div></div>
        <!-- Right: Actions -->
        <div class="flex items-center gap-4">
            <!-- Dark Mode Toggle -->
            <button id="theme-toggle" type="button" class="text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none rounded-lg text-sm p-2.5 transition">
                <svg id="theme-toggle-dark-icon" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                </svg>
                <svg id="theme-toggle-light-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"></path>
                </svg>
            </button>
            <!-- User Dropdown -->
            <div class="relative" x-data="{ open: false }" @click.away="open = false">
                <button @click="open = !open" class="flex items-center gap-2 px-3 py-2 rounded-lg text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none">
                    <span class="font-medium">{{ Auth::user()->name }}</span>
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div x-show="open" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="absolute right-0 mt-2 w-48 rounded-xl shadow-lg bg-white dark:bg-gray-900 ring-1 ring-black ring-opacity-5 z-20">
                    <div class="py-1">
                        <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800">Profile</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800">Log Out</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header> 