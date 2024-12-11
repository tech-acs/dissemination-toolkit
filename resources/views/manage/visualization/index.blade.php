<x-app-layout>

    <x-slot name="header">
        <h3 class="text-lg leading-6 font-medium text-gray-900">
            {{ __('Visualizations') }}
        </h3>
        <p class="mt-2 max-w-7xl text-sm text-gray-500">
            {{ __('Manage visualizations here') }}
        </p>
    </x-slot>

    <div class="flex flex-col max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">

        <div class="flex justify-end gap-4">
            @can(\Uneca\DisseminationToolkit\Enums\PermissionsEnum::CREATE_VIZ)
                <x-button  onclick="document.getElementById('vizualization-selector').showPopover()">{{ __('Create New Visualization') }}</x-button>

            @endcan
        </div>

        <x-dissemination::message-display />

        <x-dissemination::error-display />

        <x-dissemination-smart-table :$smartTableData custom-action-sub-view="dissemination::manage.visualization.custom-action" />

    </div>
    <div popover id="vizualization-selector" class="bg-slate-100 w-3/4 p-10 border shadow">
        <div class="grid grid-cols-4 gap-x-4 gap-y-10">
            <div class="group relative rounded-md  border hover:border-4 hover:border-indigo-500/100 shadow-xl">
                <img src="{{ asset('images/chart.png') }}" alt="Chart" class="aspect-square w-full rounded-md bg-gray-100 object-cover group-hover:opacity-75">
                <div class="flex justify-center items-center">
                    <a href="{{route('manage.viz-builder.chart.step1')}}" class="mt-6 block text-md font-medium text-gray-900">
                        <span class="absolute inset-0 z-10" aria-hidden="true"></span>
                        {{ __('Chart') }}
                    </a>
                </div>
                <p aria-hidden="true" class="mt-1 text-sm text-gray-500"></p>
            </div>
            <div class="group relative rounded-md  border hover:border-4 hover:border-indigo-500/100 shadow-xl">
                <img src="{{ asset('images/table.png') }}" alt="Table" class="aspect-square w-full rounded-md bg-gray-100 object-cover group-hover:opacity-75">
                <div class="flex justify-center items-center">
                <a href="{{route('manage.viz-builder.table.step1')}}" class="mt-6 block text-md font-medium text-gray-900">
                    <span class="absolute inset-0 z-10" aria-hidden="true"></span>
                    {{ __('Table') }}
                </a>
                </div>
                <p aria-hidden="true" class="mt-1 text-sm text-gray-500"></p>
            </div>
            <div class="group relative rounded-md  border hover:border-4 hover:border-indigo-500/100  shadow-xl">
                <img src="{{ asset('images/map.png') }}" alt="Map" class="aspect-square w-full rounded-md bg-gray-100 object-cover group-hover:opacity-75">
                <div class="flex justify-center items-center">

                <a href="{{route('manage.viz-builder.map.step1')}}" class="mt-6 block text-md font-medium text-gray-900">
                    <span class="absolute inset-0 z-10" aria-hidden="true"></span>
                    {{ __('Map') }}
                </a>
                </div>
                <p aria-hidden="true" class="mt-1 text-sm text-gray-500"></p>
            </div>
            <div class="group relative rounded-md  border hover:border-4 hover:border-indigo-500/100  shadow-xl">
                <img src="{{ asset('images/scorecard.png') }}" alt="Scorecard" class="aspect-square w-full rounded-md bg-gray-100 object-cover group-hover:opacity-75">
                <div class="flex justify-center items-center">

                <a href="{{route('manage.viz-builder.scorecard.step1')}}" class="mt-6 block text-md font-medium text-gray-900">
                    <span class="absolute inset-0 z-10" aria-hidden="true"></span>
                    {{ __('Scorecard') }}
                </a>
                </div>
                <p aria-hidden="true" class="mt-1 text-sm text-gray-500"></p>
            </div>
        </div>
    </div>
</x-app-layout>
