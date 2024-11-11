<x-guest-layout>
    <div class="container mx-auto">
        @include('dissemination::partials.nav')

        <main class="py-12">
            <div class="flex flex-col space-y-5">
                <form class="flex flex-row space-x-1">
                    <div class="relative flex-1 ">
                        <label for="keyword" class="absolute -top-3 left-2 inline-block bg-white px-1 text-base font-normal text-gray-700">Search</label>
                        <input type="search" name="keyword" id="keyword" value="{{ request()->get('keyword') }}"
                               class="block w-full rounded-l-md border-0 py-1.5 pt-2 text-gray-900 shadow-sm ring-1 ring-inset ring-indigo-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-8"
                               placeholder="Type keyword and press enter"/>
                    </div>
                    <div class="basis-1/5">
                        <label for="topic" class="sr-only">Topic</label>
                        <select id="topic" name="topic" x-data x-on:change="$event.target.form.submit()"
                                class="relative block w-full  rounded-none rounded-r-md border-0 bg-transparent py-1.5 pt-2 text-gray-700 ring-1 ring-inset ring-indigo-300 focus:z-10 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-8">
                            <option value>All topics</option>
                            @foreach($topics ?? [] as $topic)
                                <option class="p-2 rounded-md" value="{{ $topic?->id }}" @selected($topic->id == request()->get('topic'))>
                                    {{ $topic->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </form>
                <div class="grid grid-cols-2 gap-4">
                    @forelse($records as $record)
                        <div class="col-span-1 py-3">
                            <a href="{{ route('story.show', $record->id) }}">
                                <div
                                    class="flex ring-1 ring-indigo-200 shadow-md rounded-md hover:ring-2 hover:ring-indigo-500 overflow-hidden">
                                    <div class="rounded-l-md flex-shrink-0 flex items-center w-64 h-64 border-r">
                                        <img alt="feature image" loading="lazy" class="object-cover"
                                             src="{{ File::exists($record->featured_image) ? $record->featured_image : asset('img/story-container.png') }}">
                                    </div>
                                    <div class="w-full flex flex-col p-4 space-y-4 bg-gray-50">
                                        <div class="line-clamp-1 text-lg text-indigo-900 font-semibold cursor-pointer">
                                            {{ $record->title }}
                                        </div>
                                        <div class="line-clamp-2 text-sm text-gray-500 font-normal leading-5">
                                            {{ $record->description }}
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @empty
                        <div class="col-span-2 justify-center items-center py-6 mb-8">
                            <div class="text-center text-3xl p-4 text-gray-500">
                                {{ __('There are no published stories to display at the moment') }}
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
