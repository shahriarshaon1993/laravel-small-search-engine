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
                    <div class="w-full bg-white p-6 rounded-md shadow-md mb-6">
                        <h1 class="text-gray-900 text-2xl font-bold">
                            Search Result:
                        </h1>
                        <hr class="mb-2">

                        <a href="#" class="text-gray-900 font-bold text-xl underline underline-offset-8">
                            {{ $results }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
