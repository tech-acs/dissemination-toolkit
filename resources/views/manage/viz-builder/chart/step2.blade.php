@pushonce('scripts')
    @viteReactRefresh
    @vite('resources/js/ChartEditor/index.jsx')
@endpushonce

<x-app-layout>

    <div class="flex flex-col max-w-full mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <x-dissemination::message-display />
        <livewire:state-recorder />

        <section class="shadow sm:rounded-md sm:overflow-hidden py-5 bg-white sm:p-6">
            @include('dissemination::manage.viz-builder.nav')

            <div class="flex w-full">

                <div class="relative pr-3 w-full" style="height: calc(100vh - 360px);">
                    <div id="chart-editor"></div>
                </div>

            </div>

            <footer class="flex items-center justify-end gap-x-5 border-t border-gray-900/10 px-4 pt-5 sm:px-8">
                <a href="{{ route("manage.viz-builder.chart.step1") }}" class="cursor-pointer rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
                    {{ __('Restart')}}
                </a>
                <form action="{{ route('manage.viz-builder.chart.step3') }}" method="post">
                    @csrf
                    <input type="hidden" name="data" id="chart-data" value="{{ json_encode($resource->data) }}" />
                    <input type="hidden" name="layout" id="chart-layout" value="{{ json_encode($resource->layout) }}" />
                    <button type="submit" class="cursor-pointer rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                        Next
                    </button>
                </form>
            </footer>

            <x-dissemination::toast />
        </section>

    </div>
</x-app-layout>
