<x-app-layout>

    <x-slot name="header">
        <h3 class="text-lg leading-6 font-medium text-gray-900">
            {{ __('Organization') }}
        </h3>
        <p class="mt-2 max-w-7xl text-sm text-gray-500">
            {{ __('Edit organization') }}
        </p>
    </x-slot>

    <div class="flex flex-col max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">

        <x-message-display />

        <form action="{{ route('manage.organization.update', $organization) }}" method="POST" enctype="multipart/form-data">
            @method('PATCH')
            @csrf
            @include('manage.organization.form')
        </form>

    </div>
</x-app-layout>
