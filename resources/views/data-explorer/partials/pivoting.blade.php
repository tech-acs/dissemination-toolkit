<div x-data="{
        id: 'pivoting',
        dimensions: this.@entangle('pivotableDimensions'),
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
            <label class="block text-lg font-medium leading-6 text-gray-900">{{ __('Pivoting') }}</label>
            <x-dissemination::animation.bouncing-left-pointer :class="$nextSelection === 'pivoting' ? '' : 'hidden'" />
            <span x-show="expanded" class="ml-4" x-cloak>&minus;</span>
            <span x-show="!expanded" class="ml-4 items-center align-middle">&plus;</span>
        </button>
    </h2>

    <div x-show="expanded" x-collapse x-cloak>
        <div class="px-6 pb-4 pl-8">
            @if(! empty($pivotableDimensions))
                <div class="flex flex-col space-y-4">
                    <div class="flex flex-col">
                        <label class="text-xs mb-1">Column</label>
                        <select wire:model.live="pivotColumn" class="w-fit text-xs rounded-md border border-gray-300 bg-white px-3 pr-10 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500">
                            <option value>Select a dimension</option>
                            @foreach($pivotableDimensions as $dimension)
                                <option value="{{ $dimension['id'] }}">{{ $dimension['label'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div x-show="dimensions.length > 1" class="flex flex-col">
                        <label class="text-xs mb-1">Row</label>
                        <select wire:model.live="pivotRow" class="w-fit text-xs rounded-md border border-gray-300 bg-white px-3 pr-10 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500">
                            <option value>Select a dimension</option>
                            @foreach($pivotableDimensions as $dimension)
                                <option value="{{ $dimension['id'] }}">{{ $dimension['label'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div x-show="dimensions.length > 2" class="flex flex-col">
                        <label class="text-xs mb-1">Nesting column</label>
                        <select wire:model.live="nestingPivotColumn" class="w-fit text-xs rounded-md border border-gray-300 bg-white px-3 pr-10 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500">
                            <option value>Select a dimension</option>
                            @foreach($pivotableDimensions as $dimension)
                                <option value="{{ $dimension['id'] }}">{{ $dimension['label'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            @else
                @if ($pivotingNotPossible)
                    <div class="text-gray-500 mt-2 border rounded-md p-4 py-2">{{ __('Pivoting not possible when multiple indicators are selected') }}</div>
                @else
                    <div class="text-gray-500 mt-2 border rounded-md p-4 py-2">{{ __('Select dimensions to see pivoting options') }}</div>
                @endif
            @endif
        </div>
    </div>
</div>



{{--<div class="p-2 flex items-center text-xs space-x-6 rounded-md border" x-show="dimensions.length > 1"
     x-data="{
        dimensions: this.@entangle('pivotableDimensions'),
    }"
>
    <div>
        <label>Column</label>
        <select wire:model="pivotColumn" class="text-xs rounded-md border border-gray-300 bg-white px-3 pr-10 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500">
            <option value>Select a dimension</option>
            @foreach($pivotableDimensions as $dimension)
                <option value="{{ $dimension['id'] }}">{{ $dimension['label'] }}</option>
            @endforeach
        </select>
    </div>
    <div x-show="dimensions.length > 1">
        <label>Row</label>
        <select wire:model="pivotRow" class="text-xs rounded-md border border-gray-300 bg-white px-3 pr-10 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500">
            <option value>Select a dimension</option>
            @foreach($pivotableDimensions as $dimension)
                <option value="{{ $dimension['id'] }}">{{ $dimension['label'] }}</option>
            @endforeach
        </select>
    </div>
    <div x-show="dimensions.length > 2">
        <label>Nesting column</label>
        <select wire:model="nestingPivotColumn" class="text-xs rounded-md border border-gray-300 bg-white px-3 pr-10 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500">
            <option value>Select a dimension</option>
            @foreach($pivotableDimensions as $dimension)
                <option value="{{ $dimension['id'] }}">{{ $dimension['label'] }}</option>
            @endforeach
        </select>
    </div>
    <x-button class="ml-4 leading-3" wire:click="pivot()">Pivot</x-button>
</div>--}}
