<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ route('landing') }}">
                        <img class="h-12" title="{{ $org?->name }}" alt="{{ $org?->name }}" src="{{ asset(empty($org?->logo_path) ? 'images/placeholder-logo.png' : $org->logo_path) }}">
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 lg:flex items-center">
                    <x-nav-link href="{{ route('manage.home') }}" :active="request()->routeIs('manage.home')">{{ __('Home') }}</x-nav-link>
                    <x-nav-link href="{{ route('manage.visualization.index') }}" :active="request()->routeIs('manage.visualization.*')">{{ __('Visualizations') }}</x-nav-link>
                    <x-nav-link href="{{ route('manage.story.index') }}" :active="request()->routeIs('manage.story.*')" class="whitespace-nowrap">{{ __('Data stories') }}</x-nav-link>
                    <x-nav-link href="{{ route('manage.topic.index') }}" :active="request()->routeIs('manage.topic.*')">{{ __('Topics') }}</x-nav-link>
                    <x-nav-link href="{{ route('manage.indicator.index') }}" :active="request()->routeIs('manage.indicator.*')">{{ __('Indicators') }}</x-nav-link>
                    <x-nav-link href="{{ route('manage.dimension.index') }}" :active="request()->routeIs('manage.dimension.*')">{{ __('Dimensions') }}</x-nav-link>
                    <x-nav-link href="{{ route('manage.dataset.index') }}" :active="request()->routeIs('manage.dataset.*')">{{ __('Datasets') }}</x-nav-link>
                    <x-nav-link href="{{ route('manage.document.index') }}" :active="request()->routeIs('manage.document.*')">{{ __('Documents') }}</x-nav-link>
                </div>
            </div>

            <div class="hidden lg:flex sm:items-center sm:ml-6">
                <div class="flex space-x-4">
                    <x-dropdown align="right" contentClasses="w-96 py-0 bg-white overflow-hidden">
                        <x-slot name="trigger">
                            <livewire:notification-bell />
                        </x-slot>
                        <x-slot name="content" class="overflow-hidden py-0">
                            <livewire:notification-dropdown />
                        </x-slot>
                    </x-dropdown>

                    <livewire:language-switcher />

                    @can('Super Admin')
                        <x-dropdown align="right" class="w-60">
                            <x-slot name="trigger">
                                <x-dissemination::round-button title="{{ __('Manage') }}">
                                    <x-dissemination::icon.wrench />
                                </x-dissemination::round-button>
                            </x-slot>

                            <x-slot name="content">
                                <div class="w-48">
                                    <div class="block px-4 py-2 text-xs text-gray-400">{{ __('Access Control') }}</div>
                                    <x-dropdown-link class="px-6" href="{{ route('manage.user.index') }}">{{ __('Users') }}</x-dropdown-link>
                                    <x-dropdown-link class="px-6" href="{{ route('manage.role.index') }}">{{ __('Roles') }}</x-dropdown-link>
                                    <div class="border-t border-gray-100"></div>
                                    <div class="block px-4 py-2 text-xs text-gray-400">{{ __('Core Configuration') }}</div>
                                    {{--<x-dropdown-link class="px-6" href="{{route('developer.source.index')}}">{{ __('Sources') }}</x-dropdown-link>--}}
                                    <x-dropdown-link class="px-6" href="{{route('manage.area-hierarchy.index')}}">{{ __('Area Hierarchy') }}</x-dropdown-link>
                                    <x-dropdown-link class="px-6" href="{{ route('manage.area.index') }}">{{ __('Areas') }}</x-dropdown-link>
                                    <div class="border-t border-gray-100"></div>
                                    {{--<div class="block px-4 py-2 text-xs text-gray-400">{{ __('Data') }}</div>
                                    <x-dropdown-link class="px-6" href="{{ route('manage.topic.index') }}">{{ __('Topics') }}</x-dropdown-link>
                                    --}}{{--<x-dropdown-link class="px-6" href="{{ route('manage.subtopic.index') }}">{{ __('Subtopics') }}</x-dropdown-link>--}}{{--
                                    <x-dropdown-link class="px-6" href="{{ route('manage.indicator.index') }}">{{ __('Indicators') }}</x-dropdown-link>
                                    <x-dropdown-link class="px-6" href="{{ route('manage.dimension.index') }}">{{ __('Dimensions') }}</x-dropdown-link>
                                    <x-dropdown-link class="px-6" href="{{ route('manage.year.index') }}">{{ __('Years') }}</x-dropdown-link>
                                    <x-dropdown-link class="px-6" href="{{ route('manage.dataset.index') }}">{{ __('Datasets') }}</x-dropdown-link>
                                    <div class="border-t border-gray-100"></div>--}}
                                    <div class="block px-4 py-2 text-xs text-gray-400">{{ __('Dissemination') }}</div>
                                    <x-dropdown-link class="px-6" href="{{ route('manage.organization.edit') }}">{{ __('Organization') }}</x-dropdown-link>
                                    <x-dropdown-link class="px-6" href="{{ route('manage.tag.index') }}">{{ __('Tags') }}</x-dropdown-link>
                                    {{--<div class="border-t border-gray-100"></div>
                                    <div class="block px-4 py-2 text-xs text-gray-400">{{ __('Templates') }}</div>
                                    <x-dropdown-link class="px-6" href="{{ route('manage.templates.visualization.index') }}">{{ __('Visualizations') }}</x-dropdown-link>
                                    <x-dropdown-link class="px-6" href="{{ route('manage.templates.story.index') }}">{{ __('Stories') }}</x-dropdown-link>--}}
                                    {{-- <x-dropdown-link class="px-6" href="{{ route('manage.story.index') }}">{{ __('Stories Store') }}</x-dropdown-link> --}}
                                    <div class="border-t border-gray-100"></div>
                                    <x-dropdown-link href="{{route('manage.announcement.index')}}">{{ __('Announcements') }}</x-dropdown-link>
                                    {{--<x-dropdown-link href="{{route('usage_stats')}}">{{ __('Usage Stats') }}</x-dropdown-link>
                                    <x-dropdown-link href="{{route('analytics.index')}}">{{ __('Query Analytics') }}</x-dropdown-link>--}}
                                </div>
                            </x-slot>
                        </x-dropdown>
                    @endcan
                </div>

                <!-- Teams Dropdown -->
                @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                    <div class="ml-3 relative">
                        <x-dropdown align="right" width="60">
                            <x-slot name="trigger">
                                <span class="inline-flex rounded-md">
                                    <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:bg-gray-50 hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition">
                                        {{ Auth::user()->currentTeam->name }}

                                        <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </span>
                            </x-slot>

                            <x-slot name="content">
                                <div class="w-60">
                                    <!-- Team Management -->
                                    <div class="block px-4 py-2 text-xs text-gray-400">
                                        {{ __('Manage Team') }}
                                    </div>

                                    <!-- Team Settings -->
                                    <x-dropdown-link href="{{ route('teams.show', Auth::user()->currentTeam->id) }}">
                                        {{ __('Team Settings') }}
                                    </x-dropdown-link>

                                    @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                                        <x-dropdown-link href="{{ route('teams.create') }}">
                                            {{ __('Create New Team') }}
                                        </x-dropdown-link>
                                    @endcan

                                    <div class="border-t border-gray-100"></div>

                                    <!-- Team Switcher -->
                                    <div class="block px-4 py-2 text-xs text-gray-400">
                                        {{ __('Switch Teams') }}
                                    </div>

                                    @foreach (Auth::user()->allTeams() as $team)
                                        <x-switchable-team :team="$team" />
                                    @endforeach
                                </div>
                            </x-slot>
                        </x-dropdown>
                    </div>
                @endif

                <!-- Settings Dropdown -->
                <div class="ml-3 relative">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                <button class="flex items-center text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                    <img class="h-8 w-8 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" />
                                    <span class="hidden ml-3 text-gray-700 text-sm font-medium lg:block">{{Auth::user()->name}}</span>
                                    <svg class="hidden flex-shrink-0 ml-1 h-5 w-5 text-gray-400 lg:block" x-description="Heroicon name: solid/chevron-down" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                    </svg>
                                </button>
                            @else
                                <span class="inline-flex rounded-md">
                                    <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition">
                                        {{ Auth::user()->name }}

                                        <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </span>
                            @endif
                        </x-slot>

                        <x-slot name="content">
                            <!-- Account Management -->
                            <div class="block px-4 py-2 text-xs text-gray-400">
                                {{ __('Manage Account') }}
                            </div>

                            <x-dropdown-link href="{{ route('profile.show') }}">
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                                <x-dropdown-link href="{{ route('api-tokens.index') }}">
                                    {{ __('API Tokens') }}
                                </x-dropdown-link>
                            @endif

                            <div class="border-t border-gray-100"></div>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link href="{{ route('logout') }}"
                                                 onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center lg:hidden">
                <div class="mr-4 flex items-center space-x-4">
                    {{--<div class="-mt-2"><livewire:command-palette /></div>--}}
                    <a href="{{ route('notification.index') }}">
                        <livewire:notification-bell />
                    </a>
                    <livewire:language-switcher />
                </div>
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden lg:hidden h-96 overflow-y-auto">
        <div class="pt-2 pb-3 space-y-1">
            {{--<x-responsive-nav-link href="{{ route('home') }}" :active="request()->routeIs('home')">
                {{ __('Home') }}
            </x-responsive-nav-link>--}}
            <x-responsive-nav-link href="{{ route('manage.visualization.index') }}" :active="request()->routeIs('manage.visualization.*')">{{ __('Visualizations') }}</x-responsive-nav-link>
            <x-responsive-nav-link href="{{ route('manage.story.index') }}" :active="request()->routeIs('manage.story.*')" class="whitespace-nowrap">{{ __('Data stories') }}</x-responsive-nav-link>
            <x-responsive-nav-link href="{{ route('manage.topic.index') }}" :active="request()->routeIs('manage.topic.*')">{{ __('Topics') }}</x-responsive-nav-link>
            <x-responsive-nav-link href="{{ route('manage.indicator.index') }}" :active="request()->routeIs('manage.indicator.*')">{{ __('Indicators') }}</x-responsive-nav-link>
            <x-responsive-nav-link href="{{ route('manage.dimension.index') }}" :active="request()->routeIs('manage.dimension.*')">{{ __('Dimensions') }}</x-responsive-nav-link>
            <x-responsive-nav-link href="{{ route('manage.dataset.index') }}" :active="request()->routeIs('manage.dataset.*')">{{ __('Datasets') }}</x-responsive-nav-link>
            <x-responsive-nav-link href="{{ route('manage.document.index') }}" :active="request()->routeIs('manage.document.*')">{{ __('Documents') }}</x-responsive-nav-link>

            @can('Super User')
                <div class="border-t border-gray-200"></div>
                <x-responsive-nav-link href="{{ route('manage.user.index') }}">{{ __('Users') }}</x-responsive-nav-link>
                <x-responsive-nav-link href="{{ route('manage.role.index') }}">{{ __('Roles') }}</x-responsive-nav-link>
                <div class="border-t border-gray-200 border-dotted mx-4"></div>
                <x-responsive-nav-link href="{{route('manage.area-hierarchy.index')}}">{{ __('Area Hierarchy') }}</x-responsive-nav-link>
                <x-responsive-nav-link href="{{ route('manage.area.index') }}">{{ __('Areas') }}</x-responsive-nav-link>
                <div class="border-t border-gray-200 border-dotted mx-4"></div>
                <x-responsive-nav-link href="{{ route('manage.organization.edit') }}">{{ __('Organization') }}</x-responsive-nav-link>
                <x-responsive-nav-link href="{{ route('manage.tag.index') }}">{{ __('Tags') }}</x-responsive-nav-link>
                <div class="border-t border-gray-200 border-dotted mx-4"></div>
                <x-responsive-nav-link href="{{ route('manage.announcement.index') }}">{{ __('Announcements') }}</x-responsive-nav-link>
            @endcan
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="flex items-center px-4">
                @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                    <div class="flex-shrink-0 mr-3">
                        <img class="h-10 w-10 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                    </div>
                @endif

                <div>
                    <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <!-- Account Management -->
                <x-responsive-nav-link href="{{ route('profile.show') }}" :active="request()->routeIs('profile.show')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                    <x-responsive-nav-link href="{{ route('api-tokens.index') }}" :active="request()->routeIs('api-tokens.index')">
                        {{ __('API Tokens') }}
                    </x-responsive-nav-link>
                @endif

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link href="{{ route('logout') }}"
                                           onclick="event.preventDefault();
                                    this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
                <!-- Team Management -->
                @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                    <div class="border-t border-gray-200"></div>

                    <div class="block px-4 py-2 text-xs text-gray-400">
                        {{ __('Manage Team') }}
                    </div>

                    <!-- Team Settings -->
                    <x-responsive-nav-link href="{{ route('teams.show', Auth::user()->currentTeam->id) }}" :active="request()->routeIs('teams.show')">
                        {{ __('Team Settings') }}
                    </x-responsive-nav-link>

                    @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                        <x-responsive-nav-link href="{{ route('teams.create') }}" :active="request()->routeIs('teams.create')">
                            {{ __('Create New Team') }}
                        </x-responsive-nav-link>
                    @endcan

                    <div class="border-t border-gray-200"></div>

                    <!-- Team Switcher -->
                    <div class="block px-4 py-2 text-xs text-gray-400">
                        {{ __('Switch Teams') }}
                    </div>

                    @foreach (Auth::user()->allTeams() as $team)
                        <x-switchable-team :team="$team" component="responsive-nav-link" />
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</nav>
