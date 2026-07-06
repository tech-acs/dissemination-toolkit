<x-app-layout>

    <x-slot name="header">
        <h3 class="text-lg leading-6 font-medium text-gray-900">
            {{ __('Indicators') }}
        </h3>
        <p class="mt-2 max-w-7xl text-sm text-gray-500">
            {{ __('List of existing indicators') }}
        </p>
    </x-slot>

    <div class="flex flex-col max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
        @can(\Uneca\DisseminationToolkit\Enums\PermissionsEnum::CREATE_INDICATOR)
        <div class="text-right">
            <a href="{{ route('manage.indicator.create') }}"><x-button>{{ __('Create new') }}</x-button></a>
        </div>
        @endcan

        <x-dissemination::message-display />
        <x-dissemination::error-display />

        <x-dissemination-smart-table :$smartTableData custom-action-sub-view="dissemination::manage.indicator.custom-action" />

    </div>
</x-app-layout>
