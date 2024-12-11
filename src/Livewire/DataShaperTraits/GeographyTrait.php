<?php

namespace Uneca\DisseminationToolkit\Livewire\DataShaperTraits;

use Uneca\DisseminationToolkit\Models\Area;

trait GeographyTrait
{
    public array $geographyLevels = [];
    public array $selectedGeographyLevels = [];

    public array $geographies = [];
    public array $selectedGeographies = [];

    private function dispatchDisplayUpdate()
    {
        $this->nextSelection = 'dimension';
        $selectedCount = array_reduce($this->selectedGeographies, fn ($carry, $levelAreas) => $carry + count($levelAreas), 0);
        $this->dispatch('dataShaperSelectionMade', $this->makeReadableDataParams('geography', $selectedCount . str('area')->plural($selectedCount)->prepend(' ')->append(' selected') ));
    }

    public function updatedSelectedGeographyLevels($added, $level): void
    {
        if ($added) {
            $this->selectedGeographies[$level] = Area::ofLevel($level)->pluck('id')->all();
        } else {
            //unset($this->selectedGeographies[$level]);
            $this->selectedGeographies[$level] = [];
        }
        $this->selectedGeographyLevels = array_filter($this->selectedGeographyLevels, fn ($nestedArr) => ! empty($nestedArr));

        $this->setSortableColumns();

        $this->dispatchDisplayUpdate();
    }

    public function updatedSelectedGeographies($geographyId): void
    {
        $this->dispatchDisplayUpdate();
    }
}
