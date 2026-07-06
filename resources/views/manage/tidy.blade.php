<x-app-layout>

    <x-slot name="header">
        <h3 class="text-lg leading-6 font-medium text-gray-900">
            {{ __('Tidy Data Maker') }}
        </h3>
        <p class="mt-2 max-w-7xl text-sm text-gray-500">
            {{ __('Convert data from wide to long (tidy) format') }}
        </p>
    </x-slot>

    <div class="flex flex-col max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">

        {{-- <div class="text-right">
            @can(\Uneca\DisseminationToolkit\Enums\PermissionsEnum::CREATE_DATASET)
                <a href="{{route('manage.dataset.create')}}"><x-button>{{ __('Create new') }}</x-button></a>
            @endcan
        </div> --}}

        <x-dissemination::message-display />
        <x-dissemination::error-display />

        <div class="mt-2 flex flex-col">
            <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                    <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">

                        <livewire:tidy-data-maker />
                        
                    </div>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>
