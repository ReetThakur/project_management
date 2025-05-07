@props(['route', 'placeholder' => 'Search...'])

<form action="{{ $route }}" method="GET" class="space-y-4">
    <div class="flex space-x-2">
        <div class="flex-1">
            <input type="text" name="search" value="{{ request('search') }}"
                class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-blue-500 focus:ring-blue-500"
                placeholder="{{ $placeholder }}">
        </div>
        <button type="submit"
            class="inline-flex items-center px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-600 focus:bg-blue-600 active:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
            Search
        </button>
        @if(request('search'))
            <a href="{{ $route }}" 
                class="inline-flex items-center px-4 py-2 bg-gray-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-600 focus:bg-gray-600 active:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                Clear
            </a>
        @endif
    </div>
</form> 