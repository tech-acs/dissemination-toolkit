<div x-data="{
        id: 'sorting',
        dimensions: this.@entangle('sortableColumns'),
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
            <label class="block text-lg font-medium leading-6 text-gray-900">{{ __('Sorting') }}</label>
            <x-dissemination::animation.bouncing-left-pointer :class="$nextSelection === 'pivoting' ? '' : 'hidden'" />
            <span x-show="expanded" class="ml-4" x-cloak>&minus;</span>
            <span x-show="!expanded" class="ml-4 items-center align-middle">&plus;</span>
        </button>
    </h2>

    <div x-show="expanded" x-collapse x-cloak>
        <div class="px-6 pb-4 pl-8">
            @if(! empty($sortableColumns))
                <div class="flex flex-col space-y-4">
                    <div class="flex flex-col">
                        <label class="text-xs mb-1">{{ __('Sort by column') }}</label>
                        <select wire:model.live="sortingColumn" class="w-fit text-xs rounded-md border border-gray-300 bg-white px-3 pr-10 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500">
                            <option value>Select column</option>
                            @foreach($sortableColumns as $column)
                                <option value="{{ $column['column'] }}">{{ $column['label'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            @else
                <div class="text-gray-500 mt-2 border rounded-md p-4 py-2">{{ __('Select dimensions to see sorting options') }}</div>
            @endif
        </div>
    </div>
</div>
