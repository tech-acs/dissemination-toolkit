<x-guest-layout>
    <div class="container mx-auto">
        @include('dissemination::partials.nav')

        <main class="max-w-2xl px-4 py-8 mx-auto sm:px-6 lg:max-w-7xl lg:px-8">

            <div class="flex justify-between items-start border-b border-gray-200 py-2">
                <div class="pr-4">
                    <div class="mt-2 text-4xl text-indigo-800 font-bold tracking-tight flex-wrap">{{ $censusTable->title }}</div>
                    <div class="mt-2 text-xs text-gray-500 inline-flex gap-x-2 items-center gap-0.5">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                             stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5m-9-6h.008v.008H12v-.008zM12 15h.008v.008H12V15zm0 2.25h.008v.008H12v-.008zM9.75 15h.008v.008H9.75V15zm0 2.25h.008v.008H9.75v-.008zM7.5 15h.008v.008H7.5V15zm0 2.25h.008v.008H7.5v-.008zm6.75-4.5h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V15zm0 2.25h.008v.008h-.008v-.008zm2.25-4.5h.008v.008H16.5v-.008zm0 2.25h.008v.008H16.5V15z"/>
                        </svg>
                        <span><b>Last updated</b> {{ $censusTable->updated_at->format('F j, Y \a\t h:i A') }} </span>
                        <span class="px-2"><b>Views:</b> {{ $censusTable->view_count }} </span>
                        <span class="px-2"><b>Downloads: </b> {{ $censusTable->download_count }} </span>
                    </div>
                </div>
            </div>

            <article class="mt-4">
                <dl class="py-2 border-b ">
                    <dt class="my-2 font-semibold leading-none text-gray-900 dark:text-white">{{ __('Description')}}</dt>
                    <dd class="mb-4  text-gray-500 sm:mb-5 dark:text-gray-400">{{ strip_tags($censusTable->description) }}</dd>
                </dl>
                <dl class="py-2 border-b flex justify-between">
                    <div class="basis-1/3">
                        <dt class="my-2 font-semibold leading-none text-gray-900 dark:text-white">{{ __('Published date')}}</dt>
                        <dd class="mb-4 text-gray-500 sm:mb-5 dark:text-gray-400">{{$censusTable->published_date}}</dd>
                    </div>
                    <div class="basis-1/3">
                        <dt class="my-2 mt-2 font-semibold leading-none text-gray-900 dark:text-white">{{ __('Last modified')}}</dt>
                        <dd class="mb-4 text-gray-500 sm:mb-5 dark:text-gray-400">{{$censusTable->updated_at->format('M d, Y')}}</dd>
                    </div>
                    <div class="basis-1/3">
                        <dt class="my-2 mt-2 font-semibold leading-none text-gray-900 dark:text-white">{{ __('Updated by')}}</dt>
                        <dd class="mb-4 text-gray-500 sm:mb-5 dark:text-gray-400">{{$censusTable->updated_by}}</dd>
                    </div>

                </dl>
                <dl class="py-2 border-b ">
                    <dt class="my-2 font-semibold leading-none text-gray-900 dark:text-white">{{ __('Downloads')}}</dt>
                    <dd class="mb-4 text-gray-500 sm:mb-5 dark:text-gray-400">
                        <ul role="list" class="divide-y divide-gray-100 rounded-md ">
                            <li class="flex items-center justify-between py-4 pl-4 pr-5 text-sm leading-6">
                                <div class="flex w-0 flex-1 items-center">
                                    <svg class="h-5 w-5 flex-shrink-0 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M15.621 4.379a3 3 0 00-4.242 0l-7 7a3 3 0 004.241 4.243h.001l.497-.5a.75.75 0 011.064 1.057l-.498.501-.002.002a4.5 4.5 0 01-6.364-6.364l7-7a4.5 4.5 0 016.368 6.36l-3.455 3.553A2.625 2.625 0 119.52 9.52l3.45-3.451a.75.75 0 111.061 1.06l-3.45 3.451a1.125 1.125 0 001.587 1.595l3.454-3.553a3 3 0 000-4.242z" clip-rule="evenodd" />
                                    </svg>
                                    <div class="ml-4 flex min-w-0 flex-1 gap-2">
                                        <span class="truncate font-medium">{{$censusTable->file_name}}</span>
                                        <span class="flex-shrink-0 text-gray-400"> {{ \Illuminate\Support\Number::fileSize($censusTable->file_size) }} </span>
                                    </div>
                                </div>
                                <div class="ml-4 flex-shrink-0">
                                    <a href="{{ route('document.download', $censusTable->id) }}"
                                       class="inline-flex items-end text-sm font-semibold text-indigo-600 shadow-sm gap-x-1 hover:text-indigo-800 hover:border-b-2 hover:border-b-indigo-800 ">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                             class="-ml-0.5 h-5 w-5 animate-bounce" >
                                            <path fill-rule="evenodd" d="M12 2.25a.75.75 0 01.75.75v11.69l3.22-3.22a.75.75 0 111.06 1.06l-4.5 4.5a.75.75 0 01-1.06 0l-4.5-4.5a.75.75 0 111.06-1.06l3.22 3.22V3a.75.75 0 01.75-.75zm-9 13.5a.75.75 0 01.75.75v2.25a1.5 1.5 0 001.5 1.5h13.5a1.5 1.5 0 001.5-1.5V16.5a.75.75 0 011.5 0v2.25a3 3 0 01-3 3H5.25a3 3 0 01-3-3V16.5a.75.75 0 01.75-.75z" clip-rule="evenodd" />
                                        </svg>
                                        <span class="text-xs uppercase">{{$censusTable->file_type}} ({{ \Illuminate\Support\Number::fileSize($censusTable->file_size) }})</span>
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </dd>
                </dl>

                <dl class="py-2 border-b">
                    <dt class="my-2 font-semibold leading-none text-gray-900 dark:text-white">Topics</dt>
                    <dd class="mb-4 font-light text-gray-500 sm:mb-5 dark:text-gray-400">
                        <div class="space-x-0.5">
                            @foreach($censusTable->topics as $topic)
                                <a href="?topic={{ $topic->id }}" class="inline-flex items-center bg-gray-100 text-gray-800 px-1.5 py-0.5 text-xs font-medium rounded border border-gray-400">
                                    {{ $topic->name }}
                                </a>
                            @endforeach
                        </div>
                    </dd>
                </dl>
                <dl class="py-2 border-b">
                    <dt class="my-2 font-semibold leading-none text-gray-900 dark:text-white">{{ __('Tags')}}</dt>
                    <dd class="mb-4 font-light text-gray-500 sm:mb-5 dark:text-gray-400">@include('dissemination::components.tag-cloud', ['tags' => $censusTable->tags])</dd>
                </dl>
                <dl class="py-2 border-b flex items-center">
                    <div class="basis-1/2">
                        <dt class="my-2 font-semibold leading-none text-gray-900 dark:text-white">{{ __('Producer')}}</dt>
                        <dd class="mb-4 text-gray-500 sm:mb-5 dark:text-gray-400">{{$censusTable->producer}}</dd>
                    </div>
                    <div class="basis-1/2">
                        <dt class="my-2 font-semibold leading-none text-gray-900 dark:text-white">{{ __('Publisher')}}</dt>
                        <dd class="mb-4 text-gray-500 sm:mb-5 dark:text-gray-400">{{$censusTable->publisher}}</dd>
                    </div>
                </dl>
                <dl class="py-2 border-b">
                    <dt class="my-2 font-semibold leading-none text-gray-900 dark:text-white">{{ __('Data source')}}</dt>
                    <dd class="mb-4 font-light text-gray-500 sm:mb-5 dark:text-gray-400">{{$censusTable->data_source}}</dd>
                </dl>
                <dl class="py-2">
                    <dt class="my-2 font-semibold leading-none text-gray-900 dark:text-white">{{ __('Comment')}}</dt>
                    <dd class="mb-4 font-light text-gray-500 sm:mb-5 dark:text-gray-400">{{$censusTable->comment}}</dd>
                </dl>
            </article>


        </main>

        @include('dissemination::partials.footer')
    </div>
    @include('dissemination::partials.footer-end')

</x-guest-layout>
