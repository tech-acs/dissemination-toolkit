<x-guest-layout>
    <div class="container mx-auto">
        @include('dissemination::partials.nav')

        {{-- Hero --}}
        <header>
            <div class="flex flex-wrap p-8 xl:px-0">
                <div class="flex items-center w-full lg:w-1/2">
                    <div class="max-w-2xl mb-8">
                        <h1 class="text-4xl font-bold leading-snug tracking-tight text-indigo-800 lg:text-4xl lg:leading-tight xl:text-6xl xl:leading-tight">
                            {{ $org?->slogan ?? "Making data accessible to everyone." }}
                        </h1>
                        <div class="py-5 text-xl leading-normal font-base text-gray-500 lg:text-xl xl:text-2xl">
                            {!! str($org?->blurb)->markdown() !!}
                        </div>
                    </div>
                </div>
                <div class="flex items-center justify-center w-full lg:w-1/2">
                    <div><img width="616" height="617" class="object-cover" src="{{ asset($org?->hero_image_path) }}" alt="Hero image"></div>
                </div>
            </div>
        </header>

        {{-- Stats --}}
        <section>
            <div class="p-8 xl:px-0">
                <div class="bg-white py-12">
                    <div class="mx-auto">
                        <div class="text-center">
                            <h2 class="text-3xl tracking-tight text-gray-500">{{ __('Our data, available for browsing and download') }}</h2>
                        </div>
                        <dl class="mt-8 grid grid-cols-1 gap-2.5 overflow-hidden rounded-2xl text-center sm:grid-cols-2 lg:grid-cols-4">
                            <div class="flex flex-col bg-indigo-500 p-12 hover:scale-95">
                                <dt class="text-3xl font-semibold leading-7 text-white">{{ __('Datasets') }}</dt>
                                <dd class="order-first text-7xl font-semibold tracking-tight text-white">{{ $datasetSummary['datasets'] }}</dd>
                            </div>
                            <div class="flex flex-col bg-sky-500 p-12 hover:scale-95">
                                <dt class="text-3xl font-semibold leading-7 text-white">{{ __('Indicators') }}</dt>
                                <dd class="order-first text-7xl font-semibold tracking-tight text-white">{{ $datasetSummary['indicators'] }}</dd>
                            </div>
                           {{-- <div class="flex flex-col bg-green-500 p-12 hover:scale-95">
                                <dt class="text-base font-bold leading-7 text-white">{{ __('Dimensions') }}</dt>
                                <dd class="order-first text-7xl font-semibold tracking-tight text-white">{{ $datasetSummary['dimensions'] }}</dd>
                            </div>--}}
                            <div class="flex flex-col bg-orange-500 p-12 hover:scale-95">
                                <dt class="text-3xl font-semibold leading-7 text-white">{{ __('Visualizations') }}</dt>
                                <dd class="order-first text-7xl font-semibold tracking-tight text-white">{{ $datasetSummary['visualizations'] }}</dd>
                            </div>
                            <div class="flex flex-col bg-purple-500 p-12 hover:scale-95">
                                <dt class="text-3xl font-semibold leading-7 text-white">{{ __('Data Stories') }}</dt>
                                <dd class="order-first text-7xl font-semibold tracking-tight text-white">{{ $datasetSummary['data_stories'] }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>
        </section>

        {{-- Data Explorer Promo --}}
        <section>
            <div class="p-8 xl:px-0 flex w-full flex-col mt-4 items-center justify-center text-center">
                <div class="text-sm font-bold tracking-wider text-indigo-600 uppercase">Try the data explorer</div>
                <h2 class="max-w-2xl mt-3 text-3xl font-bold leading-snug tracking-tight text-gray-800 lg:leading-tight lg:text-3xl">Explore, visualize, &amp; communicate census data</h2>
                <p class="max-w-2xl py-4 text-lg leading-normal text-gray-500 lg:text-xl xl:text-xl">
                    Explore data through a point-and-click interface and create and share visualizations in minutes, all without any programming.
                </p>
            </div>
            <div class="p-8 xl:px-0">
                <div class="w-full max-w-5xl mx-auto overflow-hidden lg:mb-20">
                    <img class="border-4 border-indigo-300 border-b-0 rounded-t-lg" src="{{asset("/images/data-explorer.png")}}" alt="data explorer image">
                </div>
            </div>
        </section>

        {{-- Featured Data Stories --}}
        <section>
            <div class="p-8 xl:px-0 flex w-full flex-col mt-12 items-center justify-center text-center">
                <div class="max-w-2xl mt-3 text-3xl font-bold leading-snug tracking-tight text-indigo-800 lg:leading-tight lg:text-4xl uppercase">Featured Data Stories</div>
                <p class="max-w-2xl py-4 text-lg leading-normal text-gray-500 lg:text-xl xl:text-xl">
                    Every so often, we go to great lengths to craft beautiful pages that narrate worthy data stories using
                    charts, tables, maps and much more. Here are a few that we feel you need to read.
                </p>
            </div>
            {{-- Stories --}}
            @foreach($featuredStories ?? [] as $story)
                <article class="p-8 px-12 flex flex-wrap bg-blue-50 mb-6 lg:gap-10 lg:flex-nowrap border rounded-md group hover:ring-2 ring-indigo-500">
                    <div class="flex flex-wrap items-center w-full lg:w-1/2 lg:order-1">
                        <div class="w-10/12">
                            <a  href="{{ route('story.show', $story) }}" class="text-3xl font-bold tracking-wider text-indigo-600 uppercase">{{ $story->title }}</a>
                            <div class="text-lg space-y-4 py-2">
                                {!! $story->description !!}
                            </div>
                            <a href="{{ route('story.show', $story) }}" class="py-2 rounded-md text-sm font-semibold leading-6 text-indigo-900 hover:ring-1 ring-indigo-500">Read more <span aria-hidden="true">→</span></a>
                        </div>
                    </div>
                    <div class="flex items-center justify-center w-full lg:w-1/2 @if($loop->odd) lg:order-1 @endif">
                        <div class="overflow-hidden ">
                            <img alt="featured image" loading="lazy" class="object-cover h-64 w-10/12" src="{{ $story->featured_image }}">
                        </div>
                    </div>
                </article>
            @endforeach
        </section>

        @include('dissemination::partials.footer')
    </div>
    @include('dissemination::partials.footer-end')
</x-guest-layout>
