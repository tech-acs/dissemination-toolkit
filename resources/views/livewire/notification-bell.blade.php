<x-dissemination::round-button title="{{ __('Notifications') }}"  class="inline-flex relative items-center">
    <div wire:poll.3000ms.visible>
        @if ($unreadCount > 0)
            <x-dissemination::icon.bell-unread />
        @else
            <x-dissemination::icon.bell />
        @endif
    </div>
</x-dissemination::round-button>
