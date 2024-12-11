<x-guest-layout>

<article class="p-4 rounded-md ring-1 mb-8">
            <x-dissemination::guest-header :content="$visualization" :show-embed="true" />
            {{--@if($visualization->isFilterable)
                <livewire:geographical-area-filter :dataParams="$visualization->data_params" />
            @endif--}}

            <livewire:visualizer :designated-component="$visualization->livewire_component" :viz-id="$visualization->id" />

            <x-dissemination-reviews :subject="$visualization" />

        </article>
</x-guest-layout>
