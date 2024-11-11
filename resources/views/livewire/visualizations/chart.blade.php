<div class="relative z-0 px-4 py-5 sm:px-6">
    <div
        id="{{ $htmlId }}"
        class="chart"
        x-init="new PlotlyChart('{{ $htmlId }}')"
        data-data='@json($data)'
        data-layout='@json($layout)'
        data-config='@json($config)'
        data-baseurl="{{ config('app.url') }}"
        wire:ignore
    >
        <div class="relative block w-full rounded-lg border-2 border-dashed border-gray-300 p-12 py-32 text-center focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
            <svg class="mx-auto h-32 w-32 text-gray-300" viewBox="0 0 24 24"><path fill="currentColor" d="M2 21v-2h20v2zm1-3v-7h3v7zm5 0V6h3v12zm5 0V9h3v9zm5 0V3h3v15z"/></svg>
            <span class="mt-2 block text-base text-gray-500 leading-7">
                When available, data will be displayed here
            </span>
        </div>
    </div>
    <div wire:loading.flex class="absolute inset-0 justify-center items-center z-10 opacity-80 bg-white">
        {{ __('Updating...') }}
        <svg class="animate-spin h-5 w-5 mr-3 ..." viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="gray" stroke-width="4"></circle>
            <path class="opacity-75"  d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
    </div>
</div>
