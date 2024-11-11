<x-guest-layout>
    <div class="">
        @if($visualization->type === 'table')
            <livewire:table :visualization="$visualization" />
        @elseif($visualization->type === 'chart')
            <livewire:chart :visualization="$visualization" />
        @elseif($visualization->type === 'map')
            <livewire:map :visualization="$visualization" />
        @else
            Unknown visualization type
        @endif
</x-guest-layout>
