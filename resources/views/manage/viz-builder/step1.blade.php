<x-app-layout>

    <div class="flex flex-col max-w-full mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <x-dissemination::message-display />
        <x-dissemination::error-display />
        <livewire:state-recorder />

        <section class="shadow sm:rounded-md sm:overflow-hidden py-5 bg-white sm:p-6">
            @include('dissemination::manage.viz-builder.nav')

            {{-- Breadcrumb of badges to show selections made in the data shaper --}}
            <livewire:data-shaper-selections-display />

            <div class="grid grid-cols-3">
                <div class="border p-4">

                    <livewire:data-shaper />

                </div>
                <div class="border p-4 pt-8 col-span-2">

                    <livewire:visualizations.table />

                </div>
            </div>

            <footer class="flex items-center justify-end gap-x-6 border-t border-gray-900/10 px-4 pt-5 sm:px-8">
                <a href="{{ route("manage.viz-builder.$type.step2") }}" class="cursor-pointer rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                    Next
                </a>
            </footer>

            <x-dissemination::toast />
        </section>

    </div>
</x-app-layout>
