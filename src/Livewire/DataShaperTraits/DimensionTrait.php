<?php

namespace Uneca\DisseminationToolkit\Livewire\DataShaperTraits;

use Uneca\DisseminationToolkit\Models\Dimension;

trait DimensionTrait {
    public array $dimensions = [];
    public array $selectedDimensions = [];
    public array $selectedDimensionValues = [];

    public function updatedSelectedDimensions($key)
    {
        $this->reset('pivotableDimensions', 'pivotColumn', 'pivotRow', 'nestingPivotColumn');
        $this->setPivotableDimensions();
        $this->nextSelection = 'apply';

        $this->dispatch('dataShaperSelectionMade', $this->makeReadableDataParams('dimensions', Dimension::find($this->selectedDimensions)->pluck('name')->join(', ', ' and ')));
    }
}
