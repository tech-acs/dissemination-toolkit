<x-app-layout>
    <x-slot name="header">
        <h2 class="text-base font-semibold leading-6 text-gray-900">{{ __('Welcome') }}</h2>
        <p class="mt-1 text-sm text-gray-500">{{ __('Your one stop shop for disseminating usable statistical data.') }}</p>
    </x-slot>

    <div class="flex flex-col  max-w-7xl mx-auto py-23 sm:px-6 lg:px-8">

        <ul role="list" class="mt-6 grid grid-cols-1 gap-8 sm:grid-cols-2">
            <li class="flow-root py-2">
                <div class="relative -m-2 flex items-center space-x-4 rounded-xl p-2 focus-within:ring-2 focus-within:ring-indigo-500 hover:bg-gray-50 border hover:border hover:border-green-800">
                    <div class="flex h-16 w-16 flex-shrink-0 items-center justify-center rounded-lg bg-green-500">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-white">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-900">
                            <a href="{{route('manage.visualization.index')}}" class="focus:outline-none">
                                <span class="absolute inset-0" aria-hidden="true"></span>
                                <span>Manage visualizations</span>
                                <span aria-hidden="true"> &rarr;</span>
                            </a>
                        </h3>
                        <p class="mt-1 text-sm text-gray-500">
                            Create, customize, and share interactive data visualizations. Use our builtin visualization types to create
                            beautiful charts, tables, and diagrams from your data in minutes.
                        </p>
                    </div>
                </div>
            </li>
            <li class="flow-root py-2">
                <div class="relative -m-2 flex items-center space-x-4 rounded-xl p-2 focus-within:ring-2 focus-within:ring-indigo-500 hover:bg-gray-50 border hover:border hover:border-yellow-800">
                    <div class="flex h-16 w-16 flex-shrink-0 items-center justify-center rounded-lg bg-yellow-500">
                        <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-900">
                            <a href="{{route('manage.story.index')}}" class="focus:outline-none">
                                <span class="absolute inset-0" aria-hidden="true"></span>
                                <span>Manage stories</span>
                                <span aria-hidden="true"> &rarr;</span>
                            </a>
                        </h3>
                        <p class="mt-1 text-sm text-gray-500">
                            Explore our data story builder to create, customize, and share captivating narratives with ease.
                            Unleash the power of your data and manage your stories effortlessly, engaging your audience and driving informed decisions
                        </p>
                    </div>
                </div>
            </li>
            <li class="flow-root py-2">
                <div class="relative -m-2 flex items-center space-x-4 rounded-xl p-2 focus-within:ring-2 focus-within:ring-indigo-500 hover:bg-gray-50 border hover:border hover:border-red-800">
                    <div class="flex h-16 w-16 flex-shrink-0 items-center justify-center rounded-lg bg-red-500">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-white">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 6.75V15m6-6v8.25m.503 3.498l4.875-2.437c.381-.19.622-.58.622-1.006V4.82c0-.836-.88-1.38-1.628-1.006l-3.869 1.934c-.317.159-.69.159-1.006 0L9.503 3.252a1.125 1.125 0 00-1.006 0L3.622 5.689C3.24 5.88 3 6.27 3 6.695V19.18c0 .836.88 1.38 1.628 1.006l3.869-1.934c.317-.159.69-.159 1.006 0l4.994 2.497c.317.158.69.158 1.006 0z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-900">
                            <a href="{{route('manage.topic.index')}}" class="focus:outline-none">
                                <span class="absolute inset-0" aria-hidden="true"></span>
                                <span>Manage topics</span>
                                <span aria-hidden="true"> &rarr;</span>
                            </a>
                        </h3>
                        <p class="mt-1 text-sm text-gray-500">
                            Topics can be used to organize indicators, visualizations and stories into meaningful semantic categories.
                            You are free to add as many topics as you desire.
                        </p>
                    </div>
                </div>
            </li>
            <li class="flow-root py-2">
                <div class="relative -m-2 flex items-center space-x-4 rounded-xl p-2 focus-within:ring-2 focus-within:ring-indigo-500  hover:bg-gray-50 border hover:border hover:border-blue-800">
                    <div class="flex h-16 w-16 flex-shrink-0 items-center justify-center rounded-lg bg-blue-500">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-white">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349m-16.5 11.65V9.35m0 0a3.001 3.001 0 003.75-.615A2.993 2.993 0 009.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 002.25 1.016c.896 0 1.7-.393 2.25-1.016a3.001 3.001 0 003.75.614m-16.5 0a3.004 3.004 0 01-.621-4.72L4.318 3.44A1.5 1.5 0 015.378 3h13.243a1.5 1.5 0 011.06.44l1.19 1.189a3 3 0 01-.621 4.72m-13.5 8.65h3.75a.75.75 0 00.75-.75V13.5a.75.75 0 00-.75-.75H6.75a.75.75 0 00-.75.75v3.75c0 .415.336.75.75.75z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-900">
                            <a href="{{route('manage.indicator.index')}}" class="focus:outline-none">
                                <span class="absolute inset-0" aria-hidden="true"></span>
                                <span>Manage indicators</span>
                                <span aria-hidden="true"> &rarr;</span>
                            </a>
                        </h3>
                        <p class="mt-1 text-sm text-gray-500">
                            Simplify indicator management with comprehensive management capabilities. Create, update, delete, and seamlessly
                            assign indicators to topics for a streamlined approach for managing your data.
                        </p>
                    </div>
                </div>
            </li>
            <li class="flow-root py-2">
                <div class="relative -m-2 flex items-center space-x-4 rounded-xl p-2 focus-within:ring-2 focus-within:ring-indigo-500 hover:bg-gray-50 border hover:border hover:border-indigo-800">
                    <div class="flex h-16 w-16 flex-shrink-0 items-center justify-center rounded-lg bg-indigo-500">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-white">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 7.5l-2.25-1.313M21 7.5v2.25m0-2.25l-2.25 1.313M3 7.5l2.25-1.313M3 7.5l2.25 1.313M3 7.5v2.25m9 3l2.25-1.313M12 12.75l-2.25-1.313M12 12.75V15m0 6.75l2.25-1.313M12 21.75V19.5m0 2.25l-2.25-1.313m0-16.875L12 2.25l2.25 1.313M21 14.25v2.25l-2.25 1.313m-13.5 0L3 16.5v-2.25" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-900">
                            <a href="{{route('manage.dimension.index')}}" class="focus:outline-none">
                                <span class="absolute inset-0" aria-hidden="true"></span>
                                <span>Manage dimensions</span>
                                <span aria-hidden="true"> &rarr;</span>
                            </a>
                        </h3>
                        <p class="mt-1 text-sm text-gray-500">
                            Dimensions are what contain the descriptive attributes of your indicators. These attributes are used to slice and dice the data in your tables,
                            allowing users to analyze the data from different perspectives.
                        </p>
                    </div>
                </div>
            </li>
            <li class="flow-root py-2">
                <div class="relative -m-2 flex items-center space-x-4 rounded-xl p-2 focus-within:ring-2 focus-within:ring-indigo-500 hover:bg-gray-50 border hover:border hover:border-pink-800">
                    <div class="flex h-16 w-16 flex-shrink-0 items-center justify-center rounded-lg bg-pink-500">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-white" >
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 9V4.5M9 9H4.5M9 9L3.75 3.75M9 15v4.5M9 15H4.5M9 15l-5.25 5.25M15 9h4.5M15 9V4.5M15 9l5.25-5.25M15 15h4.5M15 15v4.5m0-4.5l5.25 5.25" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-900">
                            <a href="{{route('manage.dataset.index')}}" class="focus:outline-none">
                                <span class="absolute inset-0" aria-hidden="true"></span>
                                <span>Manage datasets</span>
                                <span aria-hidden="true"> &rarr;</span>
                            </a>
                        </h3>
                        <p class="mt-1 text-sm text-gray-500">
                            Datasets can be created and edited in the Dataset management page. A dataset is a collection of data, generally tabular, that is organized into rows and columns.
                        </p>
                    </div>
                </div>
            </li>
            {{--<li class="flow-root py-2">
                <div class="relative -m-2 flex items-center space-x-4 rounded-xl p-2 focus-within:ring-2 focus-within:ring-indigo-500 hover:bg-gray-50 border hover:border hover:border-green-800">
                    <div class="flex h-16 w-16 flex-shrink-0 items-center justify-center rounded-lg bg-orange-500">
                        <svg  class="w-6 h-6 text-white" viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="1.5"  stroke-linecap="round"  stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M11.795 21h-6.795a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v4" /><path d="M18 14v4h4" /><path d="M18 18m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" /><path d="M15 3v4" /><path d="M7 3v4" /><path d="M3 11h16" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-900">
                            <a href="{{route('manage.year.index')}}" class="focus:outline-none">
                                <span class="absolute inset-0" aria-hidden="true"></span>
                                <span>Manage years</span>
                                <span aria-hidden="true"> &rarr;</span>
                            </a>
                        </h3>
                        <p class="mt-1 text-sm text-gray-500">
                            Year management allows you to treat year as a special dimension so that you are able to keep track of indicator data for multiple years.
                            Year is an integral dimension in census data.
                        </p>
                    </div>
                </div>
            </li>--}}

            <li class="flow-root py-2">
                <div class="relative -m-2 flex items-center space-x-4 rounded-xl p-2 focus-within:ring-2 focus-within:ring-indigo-500 hover:bg-gray-50 border hover:border hover:border-sky-800">
                    <div class="flex h-16 w-16 flex-shrink-0 items-center justify-center rounded-lg bg-sky-500">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-white">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.375 19.5h17.25m-17.25 0a1.125 1.125 0 01-1.125-1.125M3.375 19.5h7.5c.621 0 1.125-.504 1.125-1.125m-9.75 0V5.625m0 12.75v-1.5c0-.621.504-1.125 1.125-1.125m18.375 2.625V5.625m0 12.75c0 .621-.504 1.125-1.125 1.125m1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125m0 3.75h-7.5A1.125 1.125 0 0112 18.375m9.75-12.75c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125m19.5 0v1.5c0 .621-.504 1.125-1.125 1.125M2.25 5.625v1.5c0 .621.504 1.125 1.125 1.125m0 0h17.25m-17.25 0h7.5c.621 0 1.125.504 1.125 1.125M3.375 8.25c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125m17.25-3.75h-7.5c-.621 0-1.125.504-1.125 1.125m8.625-1.125c.621 0 1.125.504 1.125 1.125v1.5c0 .621-.504 1.125-1.125 1.125m-17.25 0h7.5m-7.5 0c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125M12 10.875v-1.5m0 1.5c0 .621-.504 1.125-1.125 1.125M12 10.875c0 .621.504 1.125 1.125 1.125m-2.25 0c.621 0 1.125.504 1.125 1.125M13.125 12h7.5m-7.5 0c-.621 0-1.125.504-1.125 1.125M20.625 12c.621 0 1.125.504 1.125 1.125v1.5c0 .621-.504 1.125-1.125 1.125m-17.25 0h7.5M12 14.625v-1.5m0 1.5c0 .621-.504 1.125-1.125 1.125M12 14.625c0 .621.504 1.125 1.125 1.125m-2.25 0c.621 0 1.125.504 1.125 1.125m0 1.5v-1.5m0 0c0-.621.504-1.125 1.125-1.125m0 0h7.5" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-900">
                            <a href="{{route('manage.census-table.index')}}" class="focus:outline-none">
                                <span class="absolute inset-0" aria-hidden="true"></span>
                                <span>Manage Documents</span>
                                <span aria-hidden="true"> &rarr;</span>
                            </a>
                        </h3>
                        <p class="mt-1 text-sm text-gray-500">
                            Manage Documents. Our application simplifies the management of documents by allowing you to upload tables along with metadata following the Dublin Core standard.
                        </p>
                    </div>
                </div>
            </li>

        </ul>
    </div>
</x-app-layout>


