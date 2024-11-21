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
            {{--<a href="{{ route('manage.viz-builder.chart.prepare-data') }}"><x-button>{{ __('Create New') }}</x-button></a>--}}

            <x-dropdown align="right" class="48" contentClasses="py-0 bg-white overflow-hidden">
                <x-slot name="trigger">
                    <x-button>{{ __('Create New Visualization') }}</x-button>
                </x-slot>
                <x-slot name="content" class="overflow-hidden py-0">
                    <x-dropdown-link class="px-6 tracking-wide" href="{{ route('manage.viz-builder.chart.step1') }}">{{ __('Chart') }}</x-dropdown-link>
                    <x-dropdown-link class="px-6 tracking-wide" href="{{ route('manage.viz-builder.table.step1') }}">{{ __('Table') }}</x-dropdown-link>
                    <x-dropdown-link class="px-6 tracking-wide" href="{{ route('manage.viz-builder.map.step1') }}">{{ __('Map') }}</x-dropdown-link>
                    <x-dropdown-link class="px-6 tracking-wide" href="{{ route('manage.viz-builder.scorecard.step1') }}">{{ __('Scorecard') }}</x-dropdown-link>
                </x-slot>
            </x-dropdown>
        </div>

        <x-dissemination::message-display />

        <x-dissemination::error-display />

        <x-dissemination-smart-table :$smartTableData custom-action-sub-view="dissemination::manage.visualization.custom-action" />

    </div>
</x-app-layout>
