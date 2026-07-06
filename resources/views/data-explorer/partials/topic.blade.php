<div x-data="{
        id: 'topic',
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
            <label class="block text-lg font-medium leading-6 text-gray-900">{{ __('Topics') }}</label>
            <x-dissemination::animation.bouncing-left-pointer :class="$nextSelection === 'topic' ? '' : 'hidden'" />
            <span x-show="expanded" aria-hidden="true" class="ml-4" x-cloak>&minus;</span>
            <span x-show="!expanded" aria-hidden="true" class="ml-4">&plus;</span>
        </button>
    </h2>

    <div x-show="expanded" x-collapse x-cloak>
        <div class="px-6 pb-4">
            <select wire:model.live="selectedTopic" size="5" class="bg-none scrollbar block w-full appearance-none rounded-md border-1 border-gray-300 py-2 pl-3 text-gray-900 focus:ring-1 focus:ring-indigo-300 sm:text-sm sm:leading-6">
                @foreach($topics as $id => $topic)
                    <option value="{{ $id }}" class="p-2 rounded-md">{{ $topic }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>
