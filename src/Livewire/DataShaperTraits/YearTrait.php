<?php

namespace Uneca\DisseminationToolkit\Livewire\DataShaperTraits;

use Uneca\DisseminationToolkit\Models\Year;

trait YearTrait {
    public array $years = [];
    public array $selectedYears = [];

    public function updatedSelectedYears($yearId): void
    {
        $this->nextSelection = 'dimension';

        $this->dispatch('dataShaperSelectionMade', $this->makeReadableDataParams('years', Year::find($this->selectedYears)->pluck('name')->join(', ', ' and ')));
    }
}
