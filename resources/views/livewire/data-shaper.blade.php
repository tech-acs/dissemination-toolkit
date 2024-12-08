<div x-data="{ nextSelection: @entangle('nextSelection') }">
    <div class="pt-4">
        <div x-data="{ active: '{{ $nextSelection }}' }" class="mx-auto max-w-3xl w-full space-y-4">
            @include('dissemination::data-explorer.partials.topic')
            @include('dissemination::data-explorer.partials.datasets')
            @include('dissemination::data-explorer.partials.indicators')
            @include('dissemination::data-explorer.partials.geography')
            {{--@include('data-explorer.partials.years')--}}
            @include('dissemination::data-explorer.partials.dimensions')
            @include('dissemination::data-explorer.partials.sorting')
            @include('dissemination::data-explorer.partials.pivoting')
        </div>
        <div class="flex justify-end mt-6">
            {{--@dump($selectedGeographyLevels, $selectedGeographies)--}}
            <x-dissemination::animation.bouncing-right-pointer :class="$nextSelection === 'apply' ? '' : 'hidden'" />
            <x-dissemination::button wire:click="apply()" wire:loading.attr="disabled">Fetch</x-dissemination::button>
            <x-dissemination::secondary-button class="ml-4" wire:click="resetFilter()">Reset</x-dissemination::secondary-button>
        </div>
    </div>
</div>

