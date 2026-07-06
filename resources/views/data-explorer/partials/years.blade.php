<div x-data="{
        id: 'year',
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
            <label class="block text-lg font-medium leading-6 text-gray-900">{{ __('Years') }}</label>
            <x-dissemination::animation.bouncing-left-pointer :class="$nextSelection === 'year' ? '' : 'hidden'" />
            <span x-show="expanded" class="ml-4" x-cloak>&minus;</span>
            <span x-show="!expanded" class="ml-4 items-center align-middle">&plus;</span>
        </button>
    </h2>

    <div x-show="expanded" x-collapse x-cloak>
        <div class="px-6 pb-4">
            @if($years)
                @foreach($years ?? [] as $id => $year)
                    <div class="flex items-start">
                        <input
                            id="year-{{ $loop->index }}"
                            wire:model.live="selectedYears"
                            value="{{ $id }}"
                            type="checkbox"
                            class="h-4 w-4 mt-1 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600"
                        >
                        <label for="year-{{ $loop->index }}" class="text-gray-900 ml-2 leading-6">{{ $year }}</label>
                    </div>
              @endforeach
            @else
                <div class="text-gray-500 mt-2 border rounded-md p-4 py-2">{{ __('Select dataset to see available years') }}</div>
            @endif
        </div>
    </div>
</div>
