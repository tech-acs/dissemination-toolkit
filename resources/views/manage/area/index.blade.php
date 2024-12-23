<x-app-layout>

    <x-slot name="header">
        <h3 class="text-lg leading-6 font-medium text-gray-900">
            {{ __('Areas') }}
        </h3>
        <p class="mt-2 max-w-7xl text-sm text-gray-500">
            {{ __('Manage areas. Names, codes and map.') }}
        </p>
    </x-slot>

    <div class="flex flex-col max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
        <x-dissemination::message-display />

        <div class="flex justify-between">
            <div>
                @if(count($hierarchies) > 0)
                    <a
                        title="Download excel template you can use to populate your areas with and import them"
                        {{--href="{{ route('developer.download-area-import-template') }}"--}}
                        class="text-sm font-medium text-indigo-600 hover:text-indigo-500"
                    >
                        {{ __('Download Import Template')}}
                    </a>
                @endif
            </div>
            <div class="flex items-center">
                <div class="bg-sky-400/20 text-sky-600 h-9 px-4 text-sm flex items-center rounded-full font-medium">
                    {{ empty($summary) ? "No areas imported yet" : $summary }}
                </div>

                <div class="ml-4" x-data="confirmedDeletion">
                    <a href="{{route('manage.area.create')}}"><x-button>{{ __('Import') }}</x-button></a>

                    <x-dissemination::delete-confirmation />
                    <a href="{{route('manage.area.destroy')}}" x-on:click.prevent="confirmThenDelete($el)">
                        <x-danger-button class="ml-2">{{ __('Delete All') }}</x-danger-button>
                    </a>
                </div>
            </div>
        </div>

        <x-dissemination-smart-table :$smartTableData />
    </div>

</x-app-layout>
