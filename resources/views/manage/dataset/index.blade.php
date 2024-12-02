<x-app-layout>

    <x-slot name="header">
        <h3 class="text-lg leading-6 font-medium text-gray-900">
            {{ __('Datasets') }}
        </h3>
        <p class="mt-2 max-w-7xl text-sm text-gray-500">
            {{ __('List of datasets') }}
        </p>
    </x-slot>

    <div class="flex flex-col max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">

        <div class="text-right">
            @can('create:dataset')
                <a href="{{route('manage.dataset.create')}}"><x-button>{{ __('Create new') }}</x-button></a>
            @endcan
        </div>

        <x-dissemination::message-display />
        <x-dissemination::error-display />

        <div class="mt-2 flex flex-col">
            <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                    <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg" x-data="confirmedDeletion">

                        <x-dissemination::delete-confirmation />

                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="w-2/5 px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    {{ __('Name') }}
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    {{ __('Indicator') }}
                                </th>
                                <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    {{ __('Dimensions') }}
                                </th>
                                <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    {{ __('Obs') }}
                                </th>
                                <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider"></th>
                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($records as $record)
                                <tr>
                                    <td class="w-2/5 px-6 py-4 text-sm font-medium text-gray-900">
                                        {{ $record->name }}<br />
                                        <div class="text-xs text-gray-600 mt-1">Topics: <span class="font-normal text-gray-500">{{ $record->topics->pluck('name')->join(', ') }}</span></div>
                                    </td>
                                    <td class="px-6 py-4 text-left text-xs font-medium text-gray-900">
                                        {{ $record->indicators->pluck('name')->join(', ') }}
                                    </td>
                                    <td class="px-6 py-4 text-center text-xs font-medium text-gray-900">
                                        {{ $record->dimensions->pluck('name')->join(', ') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium text-gray-900">
                                        {{ $record->observationsCount() }}
                                    </td>
                                    <td class="px-6 py-4  text-center text-sm font-medium text-gray-900">
                                        @can('edit:dataset')
                                            <a href="{{ route('manage.dataset.edit', $record) }}" class="text-indigo-600 hover:text-indigo-900">{{ __('Edit') }}</a>
                                        @endcan
                                        @can('delete:dataset')
                                            <span class="text-gray-400 px-1">|</span>
                                            <a href="{{ route('manage.dataset.destroy', $record) }}" x-on:click.prevent="confirmThenDelete($el)" class="text-red-600">{{ __('Delete') }}</a>
                                        @endcan
                                        @can('import:dataset')
                                            <span class="text-gray-400 px-1">|</span>
                                            <a href="{{ route('manage.dataset.import', $record) }}" class="text-indigo-600 hover:text-indigo-900">{{ __('Import') }}</a>
                                            @if($record->observationsCount())
                                                <span class="text-gray-400 px-1">|</span>
                                                <a href="{{ route('manage.dataset.truncate', $record) }}" class="text-red-600 hover:text-red-900">{{ __('Empty') }}</a>
                                            @endif
                                        @endcan
                                        <span class="text-gray-400 px-1">|</span>
                                        <a href="{{ route('manage.dataset.download-template', $record) }}" class="text-red-600 hover:text-red-900">{{ __('Template') }}</a>
                                        @can('publish-and-unpublish:dataset')
                                            <span class="text-gray-400 px-1">|</span>
                                            <x-dissemination::toggle :value="$record->published" route="{{ route('manage.dataset.change-publish-status', $record->id) }}" />
                                        @endcan
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-400">
                                        {{ __('There are no records to display') }}
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>
