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
                        <h1 class="text-gray-900 text-3xl font-bold">
                            Search Result:
                        </h1>
                        <ul class="list-none" id="searchList">

                        </ul>
                    </div>

                    <form class="w-full max-w-sm" id="filterForm" name="filterForm">
                        <div>
                            <h1>All Keywords:</h1>
                            @foreach ($keywords as $key => $keyword)
                                <div class="flex items-center mb-4">
                                    <input id="keyword-{{ $key }}" name="keyword[]" type="checkbox"
                                        value="{{ $keyword['keyword'] }}"
                                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                    <label for="keyword-{{ $key }}"
                                        class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{ $keyword['keyword'] }}
                                        ({{ $keyword['count'] }} times found)</label>
                                </div>
                            @endforeach
                        </div>
                        <div>
                            <h1>All Users:</h1>
                            @foreach ($users as $key => $user)
                                <div class="flex items-center mb-4">
                                    <input id="user-{{ $key }}" type="checkbox" name="user_id[]" value="{{ $user['id'] }}"
                                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                    <label for="user-{{ $key }}"
                                        class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{ $user['name'] }}</label>
                                </div>
                            @endforeach
                        </div>
                        <div>
                            <h1>Time Range:</h1>
                            <div class="flex items-center mb-4">
                                <input id="time_range_yesterday" name="yesterday" type="checkbox" value="yesterday"
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="time_range_yesterday"
                                    class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">See data from
                                    yesterday</label>
                            </div>
                            <div class="flex items-center mb-4">
                                <input id="time_range_last_week" name="last_week" type="checkbox" value="last_week"
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="time_range_last_week"
                                    class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">See data from last
                                    week</label>
                            </div>
                            <div class="flex items-center mb-4">
                                <input id="time_range_last_month" name="last_month" type="checkbox" value="last_month"
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="time_range_last_month"
                                    class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300"> see data from
                                    last month</label>
                            </div>
                        </div>
                        <div class="mb-4">
                            <h1>Select Date:</h1>
                            <div class="mb-4">
                                <label for="start_date">Start Date</label>
                                <input
                                    name="start_date"
                                    id="start_date"
                                    value=""
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    type="date" placeholder="Search">
                            </div>

                            <div class="mb-4">
                                <label for="end_date">End Date</label>
                                <input
                                    name="end_date"
                                    id="end_date"
                                    value=""
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    type="date" placeholder="Search">
                            </div>
                        </div>
                        <div class="flex items-center justify-between">
                            <button id="filterBtn" type="button"
                                class="bg-white hover:bg-gray-100 text-gray-800 font-semibold py-1 px-4 border border-gray-400 rounded shadow">
                                Filter
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            $(function() {
                // Pussing @CSRF Token
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]')
                            .attr('content')
                    }
                });

                // Data Submit To Database
                $('#filterBtn').click((ev) => {
                    ev.preventDefault();
                    $.ajax({
                        data: $('#filterForm').serialize(),
                        url: "{{ route('search-history') }}",
                        type: "POST",
                        dataType: 'json',
                        success: function(response) {
                            $('#searchList').empty();
                            if (response.searchHistory.length > 0) {
                                $.each(response.searchHistory, function(index, item) {
                                    $('#searchList').append('<li class="text-gray-900"> User: ' + item.user.name + '</li>');
                                    $('#searchList').append('<li class="text-gray-900"> Keyword: ' + item.keyword + '</li>');
                                    $('#searchList').append('<li class="text-gray-900"> Searched at: ' + item.searched_at + '</li>');
                                    $('#searchList').append('<li class="text-gray-900"> Search Results: ' + item.search_results + '</li>');
                                    $('#searchList').append('<hr class="my-2">');
                                });
                            }else {
                                $('#searchList').append('<h3 class="text-red-900 text-xl">No Data Here</h3>');
                            }
                        },
                        error: function(error) {
                            console.log(error);
                        }
                    });
                });
            });
        </script>
    @endpush
</x-app-layout>
