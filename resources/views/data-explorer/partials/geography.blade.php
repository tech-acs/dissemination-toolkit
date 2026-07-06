<div x-data="{
        id: 'geography',
        get expanded() {
            return this.active === this.id
        },
        set expanded(value) {
            this.active = value ? this.id : null
        }
    }" class="rounded-md bg-white shadow-sm border"
>
    <h2>
        <button
            x-on:click="expanded = !expanded"
            class="flex w-full items-center justify-between px-6 py-2 text-xl font-bold"
        >
            <label class="block text-lg font-medium leading-6 text-gray-900">{{ __('Geography') }}</label>
            <x-dissemination::animation.bouncing-left-pointer :class="$nextSelection === 'geography' ? '' : 'hidden'" />
            <span x-show="expanded" aria-hidden="true" class="ml-4" x-cloak>&minus;</span>
            <span x-show="!expanded" aria-hidden="true" class="ml-4">&plus;</span>
        </button>
    </h2>

    <div x-show="expanded" x-collapse x-cloak>
        <div class="px-6 pb-4">

            @if($geographyLevels)
                <div class="flex flex-col" x-data="{ showValues: false }">
                    <div class="flex justify-between">

                            {{--<select wire:model.live="selectedGeographyLevel" class="mt-1 rounded-md border border-gray-300 bg-white px-3 pr-10 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm">
                                @foreach($geographyLevels as $id => $geographyLevel)
                                <option value="{{ $id }}" class="p-2 rounded-md">By {{ $geographyLevel }}</option>
                                @endforeach
                            </select>--}}

                            {{--@foreach($geographyLevels as $id => $geographyLevel)
                            <div class="flex h-6 items-center px-4">
                                <input id="{{ $geographyLevel }}" value="{{ $id }}" wire:model.live="selectedGeographyLevels" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600">
                                <label for="{{ $geographyLevel }}" class="font-medium text-gray-900">{{ $geographyLevel }}</label>
                            </div>
                            @endforeach--}}



                            <div class="flex w-full" x-data="{ selected: 0 }">
                                <ul class="flex-column space-y space-y-2 text-sm font-medium text-gray-700 md:me-2 mb-2 md:mb-0">
                                    @foreach($geographyLevels as $level => $geographyLevel)
                                    <li>
                                        <a x-on:click="selected = {{ $level }}" :class="{ 'border border-blue-300 bg-blue-50' : selected == {{ $level }} }" class="inline-flex items-center w-full px-3 py-2 rounded-md hover:text-gray-900 hover:bg-gray-200">
                                            <input title="Select/deselect all" value="{{ $level }}" wire:model.live="selectedGeographyLevels.{{ $level }}" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600">
                                            <label title="Show {{ str($geographyLevel)->plural() }}" class="ml-2 cursor-pointer">{{ $geographyLevel }}</label>
                                        </a>
                                    </li>
                                    @endforeach
                                </ul>

                                @forelse($geographies ?? [] as $level => $levelAreas)
                                <div x-show="selected == {{ $level }}" class="p-2 bg-blue-50 text-sm text-gray-500 rounded-md border border-blue-300 w-full max-h-96 overflow-y-auto scrollbar">

                                    @foreach($levelAreas as $group => $lAreas)
                                        <div class="border p-1 mb-1 rounded-md text-xs" x-data="{ clickAllChildren() { $el.querySelectorAll('input').forEach(el => el.dispatchEvent(new MouseEvent('click')) ) } }">
                                            <div x-on:click="clickAllChildren()" class="text-xs cursor-pointer font-semibold text-blue-600 underline" title="Select all">{{ $lAreas[0]->parentName() }}</div>
                                            @foreach($lAreas as $area)
                                                <div class="inline-flex items-start mr-2">
                                                    <input
                                                        id="geography-{{ $level }}-{{ $area->id }}"
                                                        wire:model.live="selectedGeographies.{{ $level }}"
                                                        value="{{ $area->id }}"
                                                        type="checkbox"
                                                        class="h-4 w-4 mt-1 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600"
                                                    >
                                                    <label for="geography-{{ $level }}-{{ $area->id }}" class="text-gray-900 ml-2 leading-6">{{ $area->name }}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endforeach

                                </div>
                                @empty
                                    There are no values to display
                                @endforelse
                            </div>



                        {{--<div class="flex items-center">
                            <button @click="showValues = !showValues" type="button" class="text-gray-400 hover:text-gray-700 cursor-pointer">
                                <!-- Expand icon -->
                                <svg x-show="!(showValues)" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
                                </svg>
                                <!-- Collapse icon -->
                                <svg x-show="showValues" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M4 10a.75.75 0 01.75-.75h10.5a.75.75 0 010 1.5H4.75A.75.75 0 014 10z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>--}}
                    </div>

                    {{--<div x-show="showValues" class="text-xs mt-2 border rounded-md p-4 max-h-64 overflow-y-auto scrollbar">
                        @forelse($geographies ?? [] as $id => $name)
                            <div class="flex items-start">
                                <input
                                    id="geography-{{ $loop->index }}"
                                    wire:model="selectedGeographies"
                                    value="{{ $id }}"
                                    type="checkbox"
                                    class="h-4 w-4 mt-1 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600"
                                >
                                <label for="geography-{{ $loop->index }}" class="text-gray-900 ml-2 leading-6">{{ $name }}</label>
                            </div>
                        @empty
                            There are no values to display
                        @endforelse
                    </div>--}}
                    {{--<div class="flex justify-end mt-6">
                        @if($this->showFetchGeographicalChildren)
                            <div class="flex items-start">
                                <input
                                    id="fetchGeographicalChildren",
                                    wire:model="fetchGeographicalChildren"
                                    type="checkbox"
                                    class="h-4 w-4 mt-1 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600"
                                >
                                <label for="fetchGeographicalChildren" class="text-gray-900 ml-2 leading-6">{{ __('Fetch geographical heirachical area children') }}</label>
                            </div>
                        @endif--}}
                </div>
            @else
                <div class="text-gray-500 mt-2 border rounded-md p-4 py-2">{{ __('Select dataset to see available geographies') }}</div>
            @endif
        </div>
    </div>
</div>
