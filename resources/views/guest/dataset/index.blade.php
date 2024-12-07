<x-guest-layout>
    <livewire:i-need-alpine />
    <div class="container mx-auto">
        @include('dissemination::partials.nav')

        <main class="py-12">
            {{--<div class="pb-6">
                <h1 class="text-3xl font-bold tracking-tight text-indigo-800">Datasets</h1>
                <p class="mt-4 text-sm text-left text-gray-500 w-3/4">
                    These are all the datasets available on the platform.
                </p>
            </div>--}}

            <form class="flex flex-row space-x-1">
                <div class="relative flex-1 ">
                    <label for="keyword" class="absolute -top-3 left-2 inline-block bg-white px-1 text-base font-normal text-gray-700">{{ __('Search')}}</label>
                    <input type="search" name="keyword" id="keyword" value="{{ request()->get('keyword') }}" class="block w-full rounded-l-md border-0 py-1.5 pt-2 text-gray-700 shadow-sm ring-1 ring-inset ring-indigo-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-8"
                           placeholder="Type keyword and press enter" />
                </div>
                <div class="basis-1/5">
                    <label for="topic" class="sr-only">{{ __('Topic')}}</label>
                    <select id="topic" name="topic" autocomplete="topic-name" x-data x-on:change="$event.target.form.submit()" class="relative block w-full rounded-none rounded-r-md border-0 bg-transparent py-1.5 pt-2 text-gray-700 ring-1 ring-inset ring-indigo-300 focus:z-10 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-8">
                        <option value>{{ __('All topics')}}</option>
                        @foreach($topics ?? [] as $topic)
                            <option class="p-2 rounded-md" value="{{ $topic?->id }}" @selected($topic->id == request()->get('topic')) >
                                {{ $topic->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </form>

            <div class="bg-gray-50 rounded-lg border border-gray-200 p-6 gap-6 grid grid-cols-2 xl:grid-cols-3 mt-6">

                @forelse($records as $record)
                    <div class="overflow-hidden bg-white shadow ring-1 ring-black/5 sm:rounded-lg flex flex-col justify-between">

                        <div class="p-6 space-y-3">
                            <h3 class="text-lg font-semibold text-gray-700">{{ $record['name'] }}</h3>
                            <p class="mt-1 max-w-2xl text-sm text-gray-500 line-clamp-3">{{ $record['description'] }}</p>
                            <p class="text-sm text-gray-500"><span class="font-semibold text-gray-600">{{ __('Indicators included')}}: </span> <span>{{ $record['indicators'] }}</span></p>
                            <p class="text-sm text-gray-500"><span class="font-semibold text-gray-600">{{ __('Disaggregated by')}}: </span> <span>{{ $record['dimensions'] }}</span></p>
                            <p class="text-sm text-gray-500"><span class="font-semibold text-gray-600">{{ __('Observation years')}}: </span> <span>{{ $record['available_years'] }}</span></p>
                        </div>

                        <div>
                            <div class="p-6 grid grid-cols-2 text-sm pt-8 text-stone-500">
                                <div>
                                    <svg class="size-7 mb-3" viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="1.5"  stroke-linecap="round"  stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 18.5l-3 -1.5l-6 3v-13l6 -3l6 3l6 -3v7" /><path d="M9 4v13" /><path d="M15 7v5" /><path d="M21.121 20.121a3 3 0 1 0 -4.242 0c.418 .419 1.125 1.045 2.121 1.879c1.051 -.89 1.759 -1.516 2.121 -1.879z" /><path d="M19 18v.01" /></svg>
                                    <div class="text-gray-500">{{ __('Granularity')}}</div>
                                    <div class="font-medium">{{ $record['granularity'] }}</div>
                                </div>
                                {{--<div>
                                    <svg class="size-7 mb-3" viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="1.5"  stroke-linecap="round"  stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14 3v4a1 1 0 0 0 1 1h4" /><path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" /><path d="M8 11h8v7h-8z" /><path d="M8 15h8" /><path d="M11 11v7" /></svg>
                                    <div class="text-gray-500">{{ __('Fact table')}}</div>
                                    <div class="font-medium">{{ $record['fact_table'] }}</div>
                                </div>--}}
                                <div>
                                    <svg class="size-7 mb-3" viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="1.5"  stroke-linecap="round"  stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6 5l0 14" /><path d="M10 5l0 14" /><path d="M14 5l0 14" /><path d="M18 5l0 14" /><path d="M3 17l18 -10" /></svg>
                                    <div class="text-gray-500">{{ __('Observations')}}</div>
                                    <div class="font-medium">{{ $record['observations'] }}</div>
                                </div>
                            </div>
                            <div class="px-4 flex justify-between bg-blue-50/50">
                                <a href="{{ route('data-explorer') }}?prefillDatasetId={{ $record['id'] }}" class="flex items-center justify-center gap-x-2.5 py-3 text-sm font-semibold leading-6 text-indigo-500 hover:text-indigo-700">
                                    <svg class="h-5 w-5 flex-none" viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6 21l6 -5l6 5" /><path d="M12 13v8" /><path d="M3.294 13.678l.166 .281c.52 .88 1.624 1.265 2.605 .91l14.242 -5.165a1.023 1.023 0 0 0 .565 -1.456l-2.62 -4.705a1.087 1.087 0 0 0 -1.447 -.42l-.056 .032l-12.694 7.618c-1.02 .613 -1.357 1.897 -.76 2.905z" /><path d="M14 5l3 5.5" /></svg>
                                    {{ __('Explore')}}
                                </a>
                                <a href="{{ route('dataset.download', $record['id']) }}" class="flex items-center justify-center gap-x-2.5 py-3 text-sm font-semibold leading-6 text-indigo-500 hover:text-indigo-700">
                                    <svg class="h-5 w-5 flex-none" viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" /><path d="M7 11l5 5l5 -5" /><path d="M12 4l0 12" /></svg>
                                    {{ __('Download')}}
                                </a>
                            </div>
                        </div>

                    </div>
                @empty
                    <div class="col-span-3 justify-center items-center py-6">
                        <div class="text-center text-3xl p-4 text-gray-500">
                            {{ __('There are no published datasets to display at the moment') }}
                        </div>
                    </div>
                @endforelse

            </div>

        </main>

        @include('dissemination::partials.footer')
    </div>
    @include('dissemination::partials.footer-end')
</x-guest-layout>
