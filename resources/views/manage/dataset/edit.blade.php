<x-app-layout>

    <x-slot name="header">
        <h3 class="text-lg leading-6 font-medium text-gray-900">
            {{ __('Datasets') }}
        </h3>
        <p class="mt-2 max-w-7xl text-sm text-gray-500">
            {{ __('Edit existing dataset') }}
        </p>
    </x-slot>

    <div class="flex flex-col max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">

        <x-dissemination::message-display />

        {{--<form action="{{route('manage.dataset.update', $dataset)}}" method="POST">
            @method('PATCH')
            @csrf
            @include('dissemination::manage.dataset.form')
        </form>--}}

        <livewire:dataset.update :dataset="$dataset" />

    </div>
</x-app-layout>
