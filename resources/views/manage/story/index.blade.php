<x-app-layout>

    <x-slot name="header">
        <h3 class="text-lg leading-6 font-medium text-gray-900">
            {{ __('Stories') }}
        </h3>
        <p class="mt-2 max-w-7xl text-sm text-gray-500">
            {{ __('Manage stories here') }}
        </p>
    </x-slot>

    <div class="flex flex-col max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">

        @can(\Uneca\DisseminationToolkit\Enums\PermissionsEnum::CREATE_STORY)
            <div class="text-right">
                <a href="{{route('manage.story.create')}}"><x-button>{{ __('Create new') }}</x-button></a>
            </div>
        @endcan

        <x-dissemination-smart-table :$smartTableData custom-action-sub-view="dissemination::manage.story.custom-action" />
    </div>
</x-app-layout>
