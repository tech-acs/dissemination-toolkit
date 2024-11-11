@push('scripts')
    @vite(['resources/js/chart.js'])
@endpush
<div class="z-0 py-5 pr-4">
    <div id="{{ $htmlId }}" class="bg-gray-50 border border-gray-100 rounded flex flex-col text-center py-36">
        <div class="flex justify-center gap-x-10 text-gray-400 text-sm">
            <div>
                <x-icon.table class="w-20 text-blue-200" />
                Table
            </div>
            <div>
                <x-icon.chart class="w-20 text-blue-200" />
                Chart
            </div>
            <div>
                <x-icon.map class="w-20 text-blue-200" />
                Map
            </div>
        </div>
        <p class="mt-10 text-lg text-gray-400">The visualization will be displayed once you have made your selections</p>
        <p class="text-sm text-gray-400">(Some visualization types may not be appropriate for the data you have prepared. Please choose mindfully!)</p>
    </div>
</div>
