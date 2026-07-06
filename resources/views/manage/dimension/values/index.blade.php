<x-app-layout>

    <x-slot name="header">
        <h3 class="text-lg leading-6 font-medium text-gray-900">
            {{ __('Dimension values') }}
        </h3>
        <p class="mt-2 max-w-7xl text-sm text-gray-500">
            {{ $dimension->name }} {{ __('dimension')}}: {{ __('values') }}
        </p>
    </x-slot>

    <div class="flex flex-col max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8" x-data="confirmedDeletion">

        <div class="text-right">
            <a href="{{route('manage.dimension.values.delete-all', $dimension)}}" x-on:click.prevent="confirmThenDelete($el)" class="mr-4"><x-danger-button>{{ __('Delete All') }}</x-danger-button></a>
            <a href="{{ route('manage.dimension.import-values.create', $dimension) }}" class="mr-4"><x-button>{{ __('Import') }}</x-button></a>
            <a href="{{ route('manage.dimension.values.create', $dimension) }}"><x-button>{{ __('Create new') }}</x-button></a>
        </div>

        <x-dissemination::message-display />
        <x-dissemination::error-display />

        <div class="mt-2 flex flex-col">
            <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                    <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">

                        <x-dissemination::delete-confirmation />

                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    {{ __('Name') }}
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    {{ __('Code') }}
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    {{ __('Rank') }}
                                </th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider"></th>
                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($records as $value)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $value->name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $value->code }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $value->rank }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="{{route('manage.dimension.values.edit', ['dimension' => $dimension->id, 'value' => $value->id])}}" class="text-indigo-600 hover:text-indigo-900">{{ __('Edit') }}</a>
                                        <span class="text-gray-400 px-1">|</span>
                                        <a href="{{ route('manage.dimension.values.destroy', ['dimension' => $dimension->id, 'value' => $value->id]) }}" x-on:click.prevent="confirmThenDelete($el)" class="text-red-600">{{ __('Delete') }}</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-400">
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
