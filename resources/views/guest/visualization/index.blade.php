<x-guest-layout>
    <livewire:i-need-alpine />
    <div class="container mx-auto bg-stale-100">
        @include('dissemination::partials.nav')
        <main class="py-12">

            <div class="flex flex-col py-2 px-2 lg:px-0">

                <form class="flex flex-row space-x-1">
                    <div class="relative flex-1 ">
                        <label for="keyword" class="absolute -top-3 left-2 inline-block bg-white px-1 text-base font-normal text-gray-700">{{ __('Search')}}</label>
                        <input type="search" name="keyword" id="keyword" value="{{ request()->get('keyword') }}" class="block w-full rounded-l-md border-0 py-1.5 pt-2 text-gray-700 shadow-sm ring-1 ring-inset ring-indigo-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-8"
                               placeholder="{{ __('Type keyword and press enter')}}" />
                    </div>
                    <div class="basis-1/5">
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

                <div class="mt-6  bg-stale-100">
                    <ul role="list" class="mx-4 inline-flex flex-col sm:mx-6 lg:mx-0 lg:grid lg:grid-cols-4 lg:gap-x-8 lg:space-x-0">

                    @forelse($records as $record)
                            <li class="inline-flex flex-col text-center w-auto lg:w-auto p-6 shadow-lg mt-6 border rounded-md hover:border-indigo-500/100 hover:border-2">
                                <div class="group relative">
                                    @if($record->type==='Table')
                                        <img src="{{ $record->thumbnail }}" alt="" class="aspect-square w-full rounded-md bg-gray-200 object-cover object-left-top group-hover:opacity-75">
                                    @else
                                        <img src="{{ $record->thumbnail }}" alt="" class="aspect-square w-full rounded-md bg-gray-200 object-cover group-hover:opacity-75">
                                    @endif
                                    <div class="mt-6 h-24">
                                        <h3 class="mt-1 font-semibold text-gray-900">
                                            <a href="{{ route('visualization.show', $record->id) }}">
                                                <span class="absolute inset-0"></span>
                                                {{ $record->title }}                                            </a>
                                        </h3>
                                        <p class="mt-1 text-sm text-gray-900">{{ $record->type }}</p>
                                    </div>
                                </div>
                            </li>

                            <!-- More products... -->
{{--                        <div class="group w-full rounded-md bg-white shadow-md ring-1 ring-indigo-300 hover:bg-indigo-50 hover:ring-indigo-500 hover:ring-2">--}}
{{--                            <a href="{{ route('visualization.show', $record->id) }}" class="group-hover:bg-indigo-50 rounded-md grid grid-cols-5 overflow-hidden">--}}



{{--                                        <img class="col-span-2" src="{{ $record->thumbnail }}" alt="">--}}


{{--                                <div class="p-3 cursor-pointer flex-col flex overflow-hidden col-span-3">--}}
{{--                                    <h5 class="line-clamp-2 text-lg text-indigo-900 font-semibold">{{ $record->title }}</h5>--}}
{{--                                    <p class="line-clamp-4 text-sm text-gray-500 font-normal leading-5">{{ $record->description }}</p>--}}
{{--                                </div>--}}
{{--                            </a>--}}
{{--                        </div>--}}
                    @empty
                        <div class="col-span-3 flex justify-center items-center py-6 mb-8">
                            <div class="text-center text-3xl p-4 text-gray-500">
                                {{ __('There are no published visualizations to display at the moment') }}
                            </div>
                        </div>
                    @endforelse
                    </ul>

                </div>

            </div>
        </main>

        @include('dissemination::partials.footer')
    </div>
    @include('dissemination::partials.footer-end')

</x-guest-layout>
