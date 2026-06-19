<x-app-layout>

    <div class="flex flex-col max-w-full mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <x-dissemination::message-display />
        <livewire:state-recorder />

        <section class="shadow sm:rounded-md sm:overflow-hidden py-5 bg-white sm:p-6">
            @include('dissemination::manage.viz-builder.nav')

            <div class="flex flex-col w-full" style="height: calc(100vh - 360px);">
                <livewire:plotly-editor
                    :data-sources="$resource->dataSources"
                    :data="$resource->data"
                    :layout="$resource->layout"
                    :config="$resource->config"
                    :trace-types="['bar', 'line', 'scatter', 'pie', 'histogram', 'box', 'area']"
                    sync-mode="auto"
                />
            </div>

            <footer class="flex items-center justify-between border-t border-gray-900/10 px-4 pt-5 sm:px-8">
                <div class="flex gap-x-5">
                    <x-secondary-button><a href="{{ route('manage.visualization.index') }}">{{ __('Cancel') }}</a></x-secondary-button>
                    <a href="{{ route("manage.viz-builder.chart.step1") }}" class="uppercase tracking-widest cursor-pointer rounded-md bg-white px-3 py-2 text-xs font-semibold text-red-700 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
                        {{ __('Restart')}}
                    </a>
                </div>

                <div class="flex gap-x-5">
                    <form action="{{ route('manage.viz-builder.chart.step3') }}" method="post">
                        @csrf
                        <button type="submit" class="uppercase tracking-widest cursor-pointer rounded-md bg-indigo-600 px-3 py-2 text-xs font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                            Next
                        </button>
                    </form>
                </div>

            </footer>

            <x-dissemination::toast />
        </section>

    </div>
</x-app-layout>
