<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Search Result') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    {{-- @dd($searchHistory) --}}

                    <div class="w-full bg-white p-6 rounded-md shadow-md mb-6">
                        <h1 class="text-gray-900 text-5xl font-bold">
                            Search Result:
                        </h1>
                        <ul class="list-none">
                            <li class="text-gray-900">Now this is</li>
                        </ul>
                    </div>

                    <form class="w-full max-w-sm" action="">
                        <div>
                            <h1>All Keywords:</h1>
                            @foreach ($keywords as $key=> $keyword)
                                <div class="flex items-center mb-4">
                                    <input id="keyword-{{ $key }}" type="checkbox" value="{{ $keyword['keyword'] }}" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                    <label for="keyword-{{ $key }}" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{ $keyword['keyword'] }} ({{ $keyword['count'] }} times found)</label>
                                </div>
                            @endforeach
                        </div>
                        <div>
                            <h1>All Users:</h1>
                            @foreach ($users as $key=> $user)
                                <div class="flex items-center mb-4">
                                    <input id="user-{{ $key }}" type="checkbox" value="{{ $user['id'] }}" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                    <label for="user-{{ $key }}" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{ $user['name'] }}</label>
                                </div>
                            @endforeach
                        </div>
                        <div>
                            <h1>Time Range:</h1>
                            <div class="flex items-center mb-4">
                                <input id="time_range_yesterday" type="checkbox" value="yesterday" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="time_range_yesterday" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">See data from yesterday</label>
                            </div>
                            <div class="flex items-center mb-4">
                                <input id="time_range_last_week" type="checkbox" value="last_week" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="time_range_last_week" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">See data from last week</label>
                            </div>
                            <div class="flex items-center mb-4">
                                <input id="time_range_last_month" type="checkbox" value="last_month" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="time_range_last_month" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300"> see data from last month</label>
                            </div>
                        </div>
                        <div>
                            <h1>Select Date:</h1>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
