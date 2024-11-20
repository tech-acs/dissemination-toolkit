<x-guest-layout>
    <div class="container mx-auto">
        @include('dissemination::partials.nav')
        <main class="py-12">

            <div class="flex flex-col py-2">

                <form class="flex flex-row space-x-1">
                    <div class="relative flex-1 ">
                        <label for="keyword" class="absolute -top-3 left-2 inline-block bg-white px-1 text-base font-normal text-gray-700">{{ __('Search')}}</label>
                        <input type="search" name="keyword" id="keyword" value="{{ request()->get('keyword') }}" class="block w-full rounded-l-md border-0 py-1.5 pt-2 text-gray-700 shadow-sm ring-1 ring-inset ring-indigo-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-8"
                               placeholder="{{ __('Type keyword and press enter')}}" />
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

                <div class="mt-6 grid grid-cols-1 gap-2 md:grid-cols-2 md:gap-4 lg:grid-cols-3">
                    @forelse($records as $record)
                        <div class="group w-full rounded-md bg-white shadow-md ring-1 ring-indigo-300 hover:bg-indigo-50 hover:ring-indigo-500 hover:ring-2">
                            <a href="{{ route('visualization.show', $record->id) }}" class="group-hover:bg-indigo-50 rounded-md grid grid-cols-5 overflow-hidden">

                                    @if($record->type === 'Table')
                                        <div class="col-span-2 overflow-hidden justify-center items-center text-indigo-300">
                                            <x-dissemination::icon.table class="w-2/3 group-hover:text-indigo-500"/>
                                        </div>
                                    @else($record->type === 'Chart')
                                        <img class="col-span-2" src="{{ $record->thumbnail }}" alt="">
                                    {{--@elseif($record->type === 'Map')
                                        <x-dissemination::icon.map class="w-2/3 group-hover:text-indigo-500" url="{{$record->id}}"/>--}}
                                    @endif

                                <div class="p-3 cursor-pointer flex-col flex overflow-hidden col-span-3">
                                    <h5 class="line-clamp-2 text-lg text-indigo-900 font-semibold">{{ $record->title }}</h5>
                                    <p class="line-clamp-4 text-sm text-gray-500 font-normal leading-5">{{ $record->description }}</p>
                                </div>
                            </a>
                        </div>
                    @empty
                        <div class="col-span-3 flex justify-center items-center py-6 mb-8">
                            <div class="text-center text-3xl p-4 text-gray-500">
                                {{ __('There are no published visualizations to display at the moment') }}
                            </div>
                        </div>
                    @endforelse
                </div>

            </div>
        </main>

        @include('dissemination::partials.footer')
    </div>
    @include('dissemination::partials.footer-end')

</x-guest-layout>
