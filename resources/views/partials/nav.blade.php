<nav class="relative flex flex-wrap items-center justify-between lg:justify-between p-8 xl:px-0" x-data="{open: false}">
    <div class="flex flex-wrap items-center justify-between w-full lg:w-auto">
        <a href="/">
            <div class="flex items-center space-x-2 text-2xl font-medium text-indigo-500">
                <img class="h-16" title="{{ $org?->name }}" alt="{{ $org?->name }}" src="{{ asset(empty($org?->logo_path) ? 'images/placeholder-logo.png' : $org->logo_path) }}">
                {{--<span>{{ $org?->name }}</span>--}}
            </div>
        </a>
        {{-- ToDo: do responsive menu --}}
        <button x-on:click="open = ! open"
                class="px-2 py-1 ml-auto text-gray-500 rounded-md lg:hidden hover:text-indigo-500 focus:text-indigo-500 focus:bg-indigo-100 focus:outline-none"
                type="button">
            <svg class="w-6 h-6 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path fill-rule="evenodd"
                      d="M4 5h16a1 1 0 0 1 0 2H4a1 1 0 1 1 0-2zm0 6h16a1 1 0 0 1 0 2H4a1 1 0 0 1 0-2zm0 6h16a1 1 0 0 1 0 2H4a1 1 0 0 1 0-2z"></path>
            </svg>
        </button>
        <div class="flex flex-wrap w-full my-5 lg:hidden" :class="{ 'block': open, 'hidden': !open }">
            <a class="w-full px-4 py-2 -ml-4 text-gray-500 rounded-md hover:text-indigo-500 focus:text-indigo-500 focus:bg-indigo-100 focus:outline-none"
               href="{{ route('data-explorer') }}">{{ __('Data Explorer') }}</a>
            <a class="w-full px-4 py-2 -ml-4 text-gray-500 rounded-md hover:text-indigo-500 focus:text-indigo-500 focus:bg-indigo-100 focus:outline-none"
               href="{{ route('visualization.index') }}">{{ __('Visualizations') }}</a>
            <a class="w-full px-4 py-2 -ml-4 text-gray-500 rounded-md hover:text-indigo-500 focus:text-indigo-500 focus:bg-indigo-100 focus:outline-none"
               href="{{ route('story.index') }}">{{ __('Data Stories') }}</a>
            <a class="w-full px-4 py-2 -ml-4 text-gray-500 rounded-md hover:text-indigo-500 focus:text-indigo-500 focus:bg-indigo-100 focus:outline-none"
               href="{{ route('census-table.index') }}">{{ __('Documents') }}</a>
            <a class="w-full px-4 py-2 -ml-4 text-gray-500 rounded-md hover:text-indigo-500 focus:text-indigo-500 focus:bg-indigo-100 focus:outline-none"
               href="{{ route('about') }}">{{ __('Datasets') }}</a>
            @guest
                <a class="px-6 py-2 mt-3 text-center text-white bg-indigo-600 rounded-md lg:ml-5"
                   href="{{ route('login') }}">Login</a>
            @elseauth
                <a class="px-6 py-2 mt-3 text-center text-white bg-indigo-600 rounded-md lg:ml-5"
                   href="{{ route('manage.home') }}">Manage</a>
            @endguest
        </div>
    </div>
    <div class="hidden text-center lg:flex lg:items-center">
        {{-- ToDo: add underlines to active links--}}
        <ul class="items-center justify-end flex-1 pt-6 list-none lg:pt-0 lg:flex max-w-5xl">
            <li class="mr-3"><a href="{{ route('data-explorer') }}"
                                class="{{ request()->routeIs('data-explorer') ? 'border border-indigo-300 bg-indigo-50' : '' }} group inline-block px-4 py-2 text-base font-normal text-gray-800 no-underline rounded-md hover:bg-indigo-500 hover:text-white focus:text-indigo-500 focus:bg-indigo-100 focus:outline-none">
                    <div class="flex justify-center">
                        <svg class="w-6 h-6 text-indigo-500 group-hover:bg-indigo-500 group-hover:text-white"
                             fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"
                             xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M9.75 3.104v5.714a2.25 2.25 0 01-.659 1.591L5 14.5M9.75 3.104c-.251.023-.501.05-.75.082m.75-.082a24.301 24.301 0 014.5 0m0 0v5.714c0 .597.237 1.17.659 1.591L19.8 15.3M14.25 3.104c.251.023.501.05.75.082M19.8 15.3l-1.57.393A9.065 9.065 0 0112 15a9.065 9.065 0 00-6.23-.693L5 14.5m14.8.8l1.402 1.402c1.232 1.232.65 3.318-1.067 3.611A48.309 48.309 0 0112 21c-2.773 0-5.491-.235-8.135-.687-1.718-.293-2.3-2.379-1.067-3.61L5 14.5"></path>
                        </svg>
                    </div>
                    {{ __('Data Explorer') }}
                </a>
            </li>
            <li class="mr-3"><a href="{{ route('visualization.index') }}"
                                class="{{ request()->routeIs('visualization.*') ? 'border border-indigo-300 bg-indigo-50' : '' }} group inline-block px-4 py-2 text-base font-normal text-gray-800 no-underline rounded-md hover:bg-indigo-500 hover:text-white focus:text-indigo-500 focus:bg-indigo-100 focus:outline-none">
                    <div class="flex justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="w-6 h-6 text-indigo-500 group-hover:bg-indigo-500 group-hover:text-white"
                             viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                             stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M6 16m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0"></path>
                            <path d="M16 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"></path>
                            <path d="M14.5 7.5m-4.5 0a4.5 4.5 0 1 0 9 0a4.5 4.5 0 1 0 -9 0"></path>
                        </svg>
                    </div>
                    {{ __('Visualizations') }}
                </a>
            </li>
            <li class="mr-3"><a href="{{ route('story.index') }}"
                                class="{{ request()->routeIs('story.*') ? 'border border-indigo-300 bg-indigo-50' : '' }} group inline-block cursor-pointer px-4 py-2 text-base font-normal text-gray-800 no-underline rounded-md hover:bg-indigo-500 hover:text-white focus:text-indigo-500 focus:bg-indigo-100 focus:outline-none">
                    <div class="flex justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="w-6 h-6 text-indigo-500 group-hover:bg-indigo-500 group-hover:text-white"
                             viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                             stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M3 19a9 9 0 0 1 9 0a9 9 0 0 1 9 0"></path>
                            <path d="M3 6a9 9 0 0 1 9 0a9 9 0 0 1 9 0"></path>
                            <path d="M3 6l0 13"></path>
                            <path d="M12 6l0 13"></path>
                            <path d="M21 6l0 13"></path>
                        </svg>
                    </div>
                    {{ __('Data Stories') }}
                </a>
            </li>
            <li class="mr-3"><a href="{{ route('census-table.index') }}"
                                class="{{ request()->routeIs('census-table.*') ? 'border border-indigo-300 bg-indigo-50' : '' }} group inline-block px-4 py-2 text-base font-normal text-gray-800 no-underline rounded-md hover:bg-indigo-500 hover:text-white focus:text-indigo-500 focus:bg-indigo-100 focus:outline-none">
                    <div class="flex justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-indigo-500 group-hover:bg-indigo-500 group-hover:text-white" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M9 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-2"></path>
                            <path d="M9 3m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v0a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z"></path>
                            <path d="M9 17v-5"></path>
                            <path d="M12 17v-1"></path>
                            <path d="M15 17v-3"></path>
                        </svg>
                    </div>
                    {{ __('Documents') }}
                </a>
            </li>

            <li class="mr-3"><a href="{{ route('dataset.index') }}"
                                class="{{ request()->routeIs('dataset.*') ? 'border border-indigo-300 bg-indigo-50' : '' }} group inline-block px-4 py-2 text-base font-normal text-gray-800 no-underline rounded-md hover:bg-indigo-500 hover:text-white focus:text-indigo-500 focus:bg-indigo-100 focus:outline-none">
                    <div class="flex justify-center">
                        <svg  xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-indigo-500 group-hover:bg-indigo-500 group-hover:text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 4l-8 4l8 4l8 -4l-8 -4" /><path d="M4 12l8 4l8 -4" /><path d="M4 16l8 4l8 -4" />
                        </svg>
                    </div>
                    {{ __('Datasets') }}
                </a>
            </li>

            {{--<li class="mr-3"><a href="{{ route('map-visualization.index') }}"
                                class="{{ request()->routeIs('map-visualization.*') ? 'border border-indigo-300 bg-indigo-50' : '' }} group inline-block px-4 py-2 text-base font-normal text-gray-800 no-underline rounded-md hover:bg-indigo-500 hover:text-white focus:text-indigo-500 focus:bg-indigo-100 focus:outline-none">
                    <div class="flex justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-indigo-500 group-hover:bg-indigo-500 group-hover:text-white" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M12 18.5l-3 -1.5l-6 3v-13l6 -3l6 3l6 -3v7"></path>
                            <path d="M9 4v13"></path>
                            <path d="M15 7v5"></path>
                            <path d="M21.121 20.121a3 3 0 1 0 -4.242 0c.418 .419 1.125 1.045 2.121 1.879c1.051 -.89 1.759 -1.516 2.121 -1.879z"></path>
                            <path d="M19 18v.01"></path>
                        </svg>
                    </div>
                    {{ __('Maps') }}
                </a>
            </li>
            <li class="mr-3"><a href="{{ route('about') }}"
                                class="{{ request()->routeIs('about') ? 'border border-indigo-300 bg-indigo-50' : '' }} group inline-block px-4 py-2 text-base font-normal text-gray-800 no-underline rounded-md hover:bg-indigo-500 hover:text-white focus:text-indigo-500 focus:bg-indigo-100 focus:outline-none">
                    <div class="flex justify-center">
                        <svg class="w-6 h-6 text-indigo-500 group-hover:bg-indigo-500 group-hover:text-white" fill="none" stroke="currentColor" stroke-width="1.5"
                             viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z"></path>
                        </svg>
                    </div>
                    {{ __('About') }}
                </a>
            </li>
            <li class="mr-3"><a href="{{ route('contact') }}"
                                class="{{ request()->routeIs('contact') ? 'border border-indigo-300 bg-indigo-50' : '' }} group inline-block px-4 py-2 text-base font-normal text-gray-800 no-underline rounded-md hover:bg-indigo-500 hover:text-white focus:text-indigo-500 focus:bg-indigo-100 focus:outline-none">
                    <div class="flex justify-center">
                        <svg class="w-6 h-6 text-indigo-500 group-hover:bg-indigo-500 group-hover:text-white"
                             fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"
                             xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"></path>
                        </svg>
                    </div>
                    {{ __('Contact') }}
                </a>
            </li>--}}
        </ul>
    </div>
    @guest
        <div class="hidden mr-3 space-x-4 lg:flex"><a class="px-6 py-2 text-white bg-indigo-600 rounded-md md:ml-5"
                                                      href="{{ route('login') }}">Login</a></div>
    @elseauth
        <div class="hidden mr-3 space-x-4 lg:flex"><a class="px-6 py-2 text-white bg-indigo-600 rounded-md md:ml-5"
                                                      href="{{ route('manage.home') }}">Manage</a></div>
    @endguest
</nav>
