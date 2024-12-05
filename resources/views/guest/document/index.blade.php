<x-guest-layout>
    <div class="container mx-auto">
        @include('dissemination::partials.nav')

        <main class="py-12">
            <div class="pb-6 border-b border-gray-200">
                <h1 class="text-3xl font-bold tracking-tight text-indigo-800">{{ __('Documents') }}</h1>
                <p class="mt-4 text-sm text-left text-gray-500">
                    Census tables are published in the form of a large collection of Excel files. These tables are
                    listed here by Census year, organized by series. To a large extent, census tables maintain the same
                    design over time to foster comparability of census outputs.
                </p>
            </div>

            <div class="pt-8 lg:grid lg:grid-cols-4 lg:gap-x-8">

                <aside class="pr-1">
                    <div class="hidden lg:block">
                        <form class="space-y-10 divide-y divide-gray-200">
                            <div>
                                <fieldset>
                                    <div class="pt-2 space-y-2">
                                        <legend for="dataset_type" class="block text-sm font-medium text-gray-900">{{ __('Type') }}</legend>
                                        <div class="flex flex-col gap-1 pt-2 overflow-y-scroll border border-gray-200"
                                             x-data>
                                            @foreach($types ?? [] as $type)
                                                <div class="flex items-center gap-1 ">
                                                    <input id="type-{{ $type->id }}" name="dataset_type" value="{{ $type->id }}" type="radio"
                                                           class="h-4 ml-8 p-1.5 text-indigo-600 border-gray-300 focus:ring-indigo-600"
                                                           x-on:change="$event.target.form.submit()"
                                                        @checked($type->id == request()->get('dataset_type', 'all'))
                                                    >
                                                    <label for="type-{{ $type->id }}" class="block m-1 font-medium text-gray-900">{{ $type->name }}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                            <div>
                                <fieldset>
                                    <div class="pt-2 space-y-2">
                                        <label for="fromYear" class="block text-sm font-medium leading-6 text-gray-900">{{ __('From year') }}</label>
                                        <div>
                                            <label for="fromYear" class="sr-only">{{ __('Year') }}</label>
                                            <select id="fromYear" name="fromYear" autocomplete="fromYear-name" x-data x-on:change="$event.target.form.submit()"
                                                    class="relative block w-full rounded-none rounded-r-md border-0 bg-transparent py-1.5 pt-2 text-gray-700 ring-1 ring-inset ring-indigo-300 focus:z-10 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-8">
                                                <option value></option>
                                                @foreach($censusYears ?? [] as $censusYear)
                                                    <option class="p-2 rounded-md" value="{{ $censusYear?->id }}" @selected($censusYear->id == request()->get('fromYear')) >
                                                        {{ $censusYear->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="pt-2 space-y-2">
                                        <label for="toYear" class="block text-sm font-medium leading-6 text-gray-900">{{ __('To year') }}</label>
                                        <div>
                                            <label for="toYear" class="sr-only">{{ __('Year') }}</label>
                                            <select id="toYear" name="toYear" autocomplete="toYear-name" x-data x-on:change="$event.target.form.submit()"
                                                    class="relative block w-full rounded-none rounded-r-md border-0 bg-transparent py-1.5 pt-2 text-gray-700 ring-1 ring-inset focus:z-10 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-8">
                                                <option value></option>
                                                @foreach($censusYears ?? [] as $censusYear)
                                                    <option class="p-2 rounded-md" value="{{ $censusYear?->id }}" @selected($censusYear->id == request()->get('toYear')) >
                                                        {{ $censusYear->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                            <div>
                                <fieldset>
                                    <div class="pt-2 space-y-2">
                                        <label for="topic" class="block text-sm font-medium leading-6 text-gray-900">{{ __('Topic') }}</label>
                                        <livewire:topic-selector/>
                                    </div>
                                </fieldset>
                            </div>
                            <div>
                                <fieldset>
                                    <div class="pt-2 space-y-2">
                                        <legend class="block text-sm font-medium text-gray-900">{{ __('Tags') }}</legend>
                                        <div class="h-64 pt-2 overflow-y-scroll border border-gray-200" x-data>
                                            @foreach($tags ?? [] as $tag)
                                                <div class="flex items-center pl-2">
                                                    <input id="tag-{{ $tag->id }}" name="tags[]" type="checkbox"
                                                           class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500"
                                                           value="{{ $tag->id }}"
                                                           x-on:change="$event.target.form.submit()"
                                                           @if(is_array(request()->get('tags')) && in_array($tag->id, request()->get('tags'))) checked @endif
                                                    >
                                                    <label for="tag-{{ $tag->id }}" class="ml-3 text-sm text-gray-600">{{ $tag->name  }}
                                                        ({{$tag->documents_count}})</label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        </form>
                    </div>
                </aside>

                <div class="mt-6 lg:col-span-3 lg:mt-0">

                    <table class="min-w-full divide-y divide-gray-300">
                        <thead>
                        <tr>
                            <th scope="col"
                                class="py-3 pl-4 pr-3 text-sm text-left sm:pl-6">
                                <form class="flex flex-row space-x-1">
                                    <div class="relative flex-1" x-data>
                                        <label for="keyword" class="absolute -top-3 left-2 inline-block bg-white px-1 text-base font-normal text-gray-700">{{ __('Search') }}</label>
                                        <input type="search" name="keyword" id="keyword"
                                               value="{{ request()->get('keyword') }}"
                                               class="block w-full rounded-l-md border-0 py-1.5 pt-2 text-gray-400 ring-1 ring-inset ring-indigo-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-8"
                                               x-on:change="$event.target.form.submit()"
                                               placeholder="Type keyword and press enter"/>
                                    </div>
                                    <div class="basis-1/5">
                                        <label for="sort" class="sr-only">{{ __('Sort by')}}</label>
                                        <select id="sort" name="sort" x-data x-on:change="$event.target.form.submit()"
                                                autocomplete="sort"
                                                class="relative block w-full rounded-none rounded-r-md border-0 bg-transparent py-1.5 pt-2 text-gray-700 ring-1 ring-inset ring-indigo-300 focus:z-10 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-8">
                                            @foreach($sortOptions as $key => $value)
                                                <option value="{{ $key }}" {{ request()->get('sort') == $key ? 'selected' : '' }}>{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </form>
                            </th>
                        </tr>
                        <tr>
                            <th scope="col" class="py-1 pl-4 pr-3 text-sm text-left sm:pl-6">
                                <p>
                                <x-dissemination::message-display />
                                <x-dissemination::error-display />
                                </p>
                            </th>
                        </tr>
                        <tr>
                            <th scope="col"
                                class="py-3.5 pl-4 pr-3 text-left text-sm sm:pl-6">
                                <p> Showing {{ $records->firstItem() }} to {{ $records->lastItem() }}
                                    of {{ $records->total() }} tables </p>
                            </th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($records as $record)
                            <tr>
                                <td class="w-1/3 py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                                    <div class="-my-6 divide-y divide-gray-200 sm:-my-10">
                                        <div class="flex py-6 sm:py-10">
                                            <div class="flex-1 min-w-0 lg:flex lg:flex-col">
                                                <div class="lg:flex-1">
                                                    <div class="flex justify-between">
                                                        <div class="w-5/6">
                                                            <h4 class="text-lg font-bold text-gray-900 line-clamp-1">
                                                                <a href="{{ route('document.show', $record->id) }}"
                                                                   class="inline-flex justify-center gap-x-1">
                                                                    <span>{!! \Uneca\DisseminationToolkit\Enums\CensusTableTypeEnum::getTypeIcon($record->dataset_type) !!}</span>
                                                                    {{$record->title}}
                                                                </a>
                                                            </h4>
                                                            <div class="hidden mt-1 text-sm text-gray-600 sm:block">
                                                                <p class="line-clamp-3">

                                                                </p>

                                                                <p class="pt-2 text-xs text-gray-600 line-clamp-1">
                                                                    <strong>{{ __('Data source')}}: </strong>{{$record->data_source}}
                                                                </p>
                                                                <p class="pt-1 text-xs text-gray-600 line-clamp-1">
                                                                    <strong>{{ __('Published by')}}: </strong>{{$record->publisher}}
                                                                </p>
                                                            </div>
                                                            <div class="pt-2 text-xs text-gray-400">
                                                                <span>{{ __('Created on')}}: {{$record->created_at->format('M d, Y')}}</span>
                                                                <span class="px-2">{{ __('Last modified')}}: {{$record->updated_at->diffForHumans()}}</span>
                                                                <span class="px-2">{{ __('Views')}}: {{$record->view_count}}</span>
                                                                <span class="px-2">{{ __('Downloads')}}: {{$record->download_count}}</span>
                                                            </div>
                                                        </div>
                                                        <div class="w-1/6">
                                                            <p class="flex justify-end mt-1 font-medium text-gray-900 sm:ml-6 sm:mt-0 ">
                                                                {{ date('M - Y', strtotime($record->published_date))}}
                                                            </p>
                                                        </div>

                                                    </div>
                                                    <div class="flex text-sm font-medium sm:mt-4">
                                                        <a href="{{ route('document.show', $record->id) }}"
                                                           class="inline-flex items-center text-sm font-semibold text-indigo-600 transition duration-150 ease-in-out shadow-sm gap-x-1 hover:text-indigo-800 hover:border-b-2 hover:border-b-indigo-800">View
                                                            detail</a>
                                                        <div class="pl-4 ml-4 border-l border-gray-200 sm:ml-6 sm:pl-6">
                                                            <a href="{{ route('document.download', $record->id) }}"
                                                               class="inline-flex items-center text-sm font-semibold text-indigo-600 align-middle shadow-sm gap-x-1 hover:text-indigo-800 hover:border-b-2 hover:border-b-indigo-800">
                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                     viewBox="0 0 24 24" fill="currentColor"
                                                                     class="-ml-0.5 h-5 w-5">
                                                                    <path fill-rule="evenodd"
                                                                          d="M12 2.25a.75.75 0 01.75.75v11.69l3.22-3.22a.75.75 0 111.06 1.06l-4.5 4.5a.75.75 0 01-1.06 0l-4.5-4.5a.75.75 0 111.06-1.06l3.22 3.22V3a.75.75 0 01.75-.75zm-9 13.5a.75.75 0 01.75.75v2.25a1.5 1.5 0 001.5 1.5h13.5a1.5 1.5 0 001.5-1.5V16.5a.75.75 0 011.5 0v2.25a3 3 0 01-3 3H5.25a3 3 0 01-3-3V16.5a.75.75 0 01.75-.75z"
                                                                          clip-rule="evenodd"/>
                                                                </svg>
                                                                <span class="text-xs uppercase">{{$record->file_type}} ({{ \Illuminate\Support\Number::fileSize($record->file_size) }})</span>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6"
                                    class="px-6 py-4 text-sm font-medium text-center text-gray-400 whitespace-nowrap">
                                    {{ __('There are no records to display') }}
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                        @if ($records->hasPages())
                            <tfoot>
                            <tr>
                                <td colspan="3"
                                    class="px-6 text-xs tracking-wider text-left text-gray-500">{{ $records->appends(request()->all())->links() }}</td>
                            </tr>
                            </tfoot>
                        @endif
                    </table>
                </div>
            </div>

        </main>

        @include('dissemination::partials.footer')
    </div>
    @include('dissemination::partials.footer-end')

</x-guest-layout>
