<div x-data="{
        id: 'dataset',
        get expanded() {
            return this.active === this.id
        },
        set expanded(value) {
            this.active = value ? this.id : null
        },
        selectedDatasetId: null
    }" class="rounded-md bg-white shadow-sm border"
>
    <h2>
        <button
            x-on:click="expanded = !expanded"
            class="flex w-full items-center justify-between px-6 py-2 text-xl font-bold"
        >
            <label class="block text-lg font-medium leading-6 text-gray-900">
                {{ __('Datasets') }}
                <a class="text-gray-500 text-sm font-base">({{ __('double click entries for details') }})</a>
            </label>
            <x-dissemination::animation.bouncing-left-pointer :class="$nextSelection === 'dataset' ? '' : 'hidden'" />
            <span x-show="expanded" class="ml-4" x-cloak>&minus;</span>
            <span x-show="!expanded" class="ml-4 items-center align-middle">&plus;</span>
        </button>
    </h2>

    <div x-show="expanded" x-collapse x-cloak>
        <div class="px-6 pb-4">
            @if($datasets)
                <select  wire:model.live="selectedDataset" size="4" class="bg-none scrollbar block w-full appearance-none rounded-md border-1 border-gray-300 py-2 pl-3 text-gray-900 focus:ring-1 focus:ring-indigo-300 sm:text-sm sm:leading-6">
                    @foreach($datasets ?? [] as $id => $dataset)
                        <option @dblclick="selectedDatasetId = {{ $id }}; document.getElementById('dataset_detail').showPopover()" value="{{ $id }}" class="p-2 rounded-md" title="{{ $dataset['name'] }}">{{ $dataset['name'] }}</option>
                    @endforeach
                </select>
            @else
                <div class="text-gray-500 mt-2 border rounded-md p-4 py-2">{{ __('Select topic to see available datasets') }}</div>
            @endif
        </div>
    </div>

    <div popover id="dataset_detail" class="bg-transparent w-1/2">
        <ul>
            @foreach($datasets ?? [] as $id => $dataset)
            <li x-show="selectedDatasetId == {{ $id }}">
                <div class="overflow-hidden bg-amber-200 shadow sm:rounded-lg">
                    <div class="px-4 py-4 sm:px-6">
                        <h3 class="text-base font-semibold leading-7 text-gray-900">{{ $dataset['name'] }}</h3>
                        <div class="text-sm text-gray-700 mt-2">{{ $dataset['description'] }}</div>
                        <button onclick="document.getElementById('dataset_detail').hidePopover()" type="button" class="absolute right-0 top-0 mt-2 mr-2 rounded-full p-1.5 transition hover:bg-white/50"><svg viewBox="0 0 24 24" aria-hidden="true" class="h-4 w-4 fill-gray-700"><path d="m5.636 4.223 14.142 14.142-1.414 1.414L4.222 5.637z"></path><path d="M4.222 18.363 18.364 4.22l1.414 1.414L5.636 19.777z"></path></svg>
                        </button>
                    </div>
                    <div class="border-t border-gray-300">
                        <dl class="divide-y divide-gray-300">
                            <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-900">Included indicators</dt>
                                <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{ $dataset['indicators'] }}</dd>
                            </div>
                            <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-900">Available dimensions</dt>
                                <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{ $dataset['dimensions'] }}</dd>
                            </div>
                            <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-900">No. of observations</dt>
                                <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{ $dataset['observations'] }}</dd>
                            </div>
                            <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-900">Geographic granularity</dt>
                                <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{ $dataset['granularity'] }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>

            </li>
            @endforeach
        </ul>
    </div>
</div>
