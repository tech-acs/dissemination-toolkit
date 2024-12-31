<x-guest-layout>
    <x-dissemination::guest-header :content="$visualization" :show-embed="false" />
    <livewire:visualizer :designated-component="$visualization->livewire_component" :viz-id="$visualization->id" />
</x-guest-layout>
