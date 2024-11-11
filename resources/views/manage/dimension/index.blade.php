<x-app-layout>

    <x-slot name="header">
        <h3 class="text-lg leading-6 font-medium text-gray-900">
            {{ __('Dimensions') }}
        </h3>
        <p class="mt-2 max-w-7xl text-sm text-gray-500">
            {{ __('List of existing dimensions') }}
        </p>
    </x-slot>

    <div class="flex flex-col max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">

        <div class="text-right">
            <a href="{{ route('manage.dimension.create') }}"><x-button>{{ __('Create new') }}</x-button></a>
        </div>

        <x-dissemination::message-display />
        <x-dissemination::error-display />

        <x-dissemination-smart-table :$smartTableData custom-action-sub-view="dissemination::manage.dimension.custom-action" />

    </div>
</x-app-layout>
