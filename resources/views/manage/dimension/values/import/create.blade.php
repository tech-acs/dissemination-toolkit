<x-app-layout>

    <x-slot name="header">
        <h3 class="text-lg leading-6 font-medium text-gray-900">
            {{ __('Import dimension values') }}
        </h3>
        <p class="mt-2 max-w-7xl text-sm text-gray-500">
            {{ __('Dimension: ') }} <span class="font-semibold">{{ $dimension->name }}</span>
        </p>
    </x-slot>

    <div class="flex flex-col max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">

        <x-dissemination::message-display />
        <x-dissemination::error-display />

        <form action="{{ route('manage.dimension.import-values.store', $dimension) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @include('dissemination::manage.dimension.values.import.form')
        </form>
        {{--<livewire:dataset-importer :dataset="$dataset" />--}}

    </div>
</x-app-layout>
