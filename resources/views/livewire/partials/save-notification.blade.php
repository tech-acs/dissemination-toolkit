<x-dialog-strict-modal wire:model.live="showSaveNotification">
    <x-slot name="title">
        Visualization successfully created
    </x-slot>
    <x-slot name="content">
        <p class="leading-7 mt-6">
            The visualization has been successfully saved as draft.
            To make is publicly visible, you can publish it from the visualizations page.
        </p>
        <p class="mt-6 mb-6">
            Press the ok button to go back to the visualizations list.
        </p>
    </x-slot>
    <x-slot name="footer">
        <x-secondary-button wire:click="complete()">Ok</x-secondary-button>
    </x-slot>
</x-dialog-strict-modal>
