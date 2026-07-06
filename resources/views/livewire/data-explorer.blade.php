<main class="mx-auto" x-data="{ hasData: @entangle('hasData') }">

    {{-- Top bar --}}
    <div class="flex items-center justify-between py-3 pb-2">
        <div class="inline-flex items-center">
            <h1 class="text-2xl font-semibold tracking-tight text-gray-600">{{ __('Data Explorer') }}</h1>
        </div>
        <div class="flex items-center">
            <div class="h-6 text-lg font-medium leading-6 text-gray-900">{{ $indicatorName }}</div>
        </div>
        <div class="flex gap-x-2">
            @if($hasData)
                <div>
                    {{--ToDo: Change this to a disabled download button if there's no data--}}
                    <x-dissemination::viz-button wire:click="download()" icon="download-xls">{{ __('Download') }}</x-dissemination::viz-button>
                </div>
            @endif
        </div>
    </div>
    <div class="flex flex-wrap space-x-2 border-b border-gray-200 pb-3">
        @forelse($dataShaperSelections as $key => $value)
            <x-dissemination::simple-badge><span class="font-bold">{{ ucfirst($key) }}:</span>&nbsp;{{ $value }}</x-dissemination::simple-badge>
        @empty
            {{ __('Please select your desired parameters and press the fetch button')}}
        @endforelse
    </div>

    <main class="pb-24">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-x-6">

            <livewire:data-shaper />

            <div class="lg:col-span-3 pl-6 pt-4 pr-2 border-l">
                <livewire:visualizations.table />
            </div>
        </div>

        <x-dissemination::toast />
    </main>

</main>
