<?php

namespace Uneca\DisseminationToolkit\Livewire\Visualizations;

use Uneca\DisseminationToolkit\Livewire\Visualization;

class Placeholder extends Visualization
{
    public function render()
    {
        return view('livewire.visualizations.placeholder');
    }

    protected function prepareViewPayload(): void
    {
        // TODO: Implement prepareViewPayload() method.
    }

    public function dispatchViewPayload(): void
    {
        // TODO: Implement dispatchViewPayload() method.
    }

    public function updateData(array $data): void
    {
        // TODO: Implement updateData() method.
    }

    public function updateOptions(array $options): void
    {
        // TODO: Implement updateOptions() method.
    }

    public function reactToChanges($data, $indicatorName, $dataParams)
    {
        // TODO: Implement reactToChanges() method.
    }

    public function preparePayload(): void
    {
        // TODO: Implement preparePayload() method.
    }
}
