<div x-data="{
        id: 'indicator',
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
            <label class="block text-lg font-medium leading-6 text-gray-900">
                {{ __('Indicators') }}
                @if(count($indicators) > 1)
                    <a class="cursor-pointer text-blue-600" title="Multiple selection possible">*</a>
                @endif
            </label>
            <x-dissemination::animation.bouncing-left-pointer :class="$nextSelection === 'indicator' ? '' : 'hidden'" />
            <span x-show="expanded" class="ml-4" x-cloak>&minus;</span>
            <span x-show="!expanded" class="ml-4 items-center align-middle">&plus;</span>
        </button>
    </h2>

    <div x-show="expanded" x-collapse x-cloak>
        <div class="px-6 pb-4">
            @if($indicators)
                <select multiple wire:model.live="selectedIndicators" size="4" class="bg-none scrollbar block w-full appearance-none rounded-md border-1 border-gray-300 py-2 pl-3 text-gray-900 focus:ring-1 focus:ring-indigo-300 sm:text-sm sm:leading-6">
                    @foreach($indicators as $table => $indicator)
                        <option value="{{ $table }}" class="p-2 rounded-md">{{ $indicator }}</option>
                    @endforeach
                </select>
            @else
                <div class="text-gray-500 mt-2 border rounded-md p-4 py-2">{{ __('Select dataset to see available indicators') }}</div>
            @endif
        </div>
    </div>
</div>
