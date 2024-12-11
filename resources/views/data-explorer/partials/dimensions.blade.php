<div x-data="{
        id: 'dimension',
        get expanded() {
            return this.active === this.id
        },
        set expanded(value) {
            this.active = value ? this.id : null
        },
    }" class="rounded-md bg-white shadow-sm border"
>
    <h2>
        <button
            x-on:click="expanded = !expanded"
            class="flex w-full items-center justify-between px-6 py-2 text-xl font-bold"
        >
            <label class="block text-lg font-medium leading-6 text-gray-900">{{ __('Dimensions') }}</label>
            <x-dissemination::animation.bouncing-left-pointer :class="$nextSelection === 'dimension' ? '' : 'hidden'" />
            <span x-show="expanded" aria-hidden="true" class="ml-4" x-cloak>&minus;</span>
            <span x-show="!expanded" aria-hidden="true" class="ml-4">&plus;</span>
        </button>
    </h2>

    <div x-show="expanded" x-collapse x-cloak>
        <div class="px-6 pb-4 space-y-5 mt-2 text-sm">
            @forelse($dimensions as $dimension)
                <div class="flex flex-col" x-data="{ showValues: false }" :key="dimension.{{ $loop->index }}">
                    <div class="flex justify-between">
                        <div class="flex items-start">
                            <input
                                type="checkbox"
                                id="dimension-{{ $loop->index }}"
                                wire:model.live="selectedDimensions"
                                value="{{ $dimension['id'] }}"
                                class="h-4 w-4 mt-1 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600"
                            >
                            <label for="dimension-{{ $loop->index }}" class="text-gray-900 ml-2 leading-6">{{ $dimension['label'] }}</label>
                        </div>
                        <div class="flex items-center">
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
                        </div>
                    </div>
                    <div x-show="showValues" class="text-xs mt-2 border rounded-md p-4 max-h-72 overflow-y-auto scrollbar" x-data="{ clickAllChildren() { $el.querySelectorAll('input').forEach(el => el.dispatchEvent(new MouseEvent('click')) ) } }">
                        <span class="cursor-pointer font-semibold text-blue-600" x-on:click="clickAllChildren()">Select all</span>
                        @forelse($dimension['values'] as $value)
                            <div class="flex items-start">
                                <input
                                    id="dimension-{{ $dimension['id'] }}-dimension-value-{{ $value['id'] }}"
                                    wire:model.live="selectedDimensionValues.{{ $dimension['id'] }}"
                                    value="{{ $value['id'] }}"
                                    type="checkbox"
                                    class="h-4 w-4 mt-1 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600"
                                >
                                <label for="dimension-{{ $dimension['id'] }}-dimension-value-{{ $value['id'] }}" class="text-gray-900 ml-2 leading-6">{{ $value['name'] }}</label>
                            </div>
                        @empty
                            {{ __('There are no values to display') }}
                        @endforelse
                    </div>
                </div>
            @empty
                <div class="text-gray-500 text-base mt-2 border rounded-md p-4 py-2">{{ __('Select dataset to see available dimensions') }}</div>
            @endforelse
        </div>
    </div>
</div>
