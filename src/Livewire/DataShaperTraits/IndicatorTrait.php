<?php

namespace Uneca\DisseminationToolkit\Livewire\DataShaperTraits;

use Uneca\DisseminationToolkit\Models\Area;
use Uneca\DisseminationToolkit\Models\Dataset;
use Uneca\DisseminationToolkit\Models\Indicator;
use Uneca\DisseminationToolkit\Services\AreaTree;

trait IndicatorTrait {
    public array $indicators = [];
    public array $selectedIndicators = [];

    public function updatedSelectedIndicators($indicatorIds): void
    {
        if ($indicatorIds === '__rm__') {
            return;
        }
        $this->reset('selectedGeographyLevels', 'geographyLevels', 'geographies', 'selectedGeographies',
            'years', 'selectedYears', 'dimensions', 'selectedDimensions', 'selectedDimensionValues', 'sortingColumn', 'pivotableDimensions', 'pivotColumn', 'pivotRow', 'nestingPivotColumn');

        $indicators = Indicator::findMany($this->selectedIndicators);
        $dataset = Dataset::find($this->selectedDataset);
        $allLevels = (new AreaTree())->hierarchies;
        $this->geographyLevels = $dataset ? array_slice($allLevels, 0,$dataset->max_area_level + 1) : $allLevels;

        foreach($this->geographyLevels as $level => $levelName) {
            $areas = Area::ofLevel($level)
                ->select(['id', 'name', 'path'])
                ->orderBy('name')
                ->get()
                ->map(function ($area) {
                    $area->group = str($area->path)
                        ->beforeLast('.')
                        ->value();
                    return $area;
                })
                ->groupBy('group')
                ->sortBy(function ($group) {
                    return $group->first()->parentName();
                })
                ->all();
            $this->geographies[$level] = $areas;
            $this->selectedGeographies[$level] = [];
        }

        $this->dimensions = $dataset->dimensions->map(function ($dimension) use ($dataset) {
                if ($dimension->name == 'Year') {
                    $this->selectedDimensions[] = $dimension->id;
                    $values = $dataset->availableValuesForDimension($dimension)->map(fn ($v) => ['id' => $v->id, 'name' => $v->name])->all();
                } else {
                    $values = $dimension->values()->map(fn ($v) => ['id' => $v->id, 'name' => $v->name])->all();
                }
                return [
                    'id' => $dimension->id,
                    'label' => $dimension->name,
                    'values' => $values,
                ];
            })
            ->all();

        $this->selectedDimensionValues = collect($this->dimensions)
            ->keyBy('id')
            ->map(fn ($dimension) => [])
            ->all();

        $this->setPivotableDimensions();

        $this->nextSelection = 'geography';

        $this->dispatch('dataShaperSelectionMade', $this->makeReadableDataParams('indicators', $indicators->pluck('name')->join(', ', ' and ')));
    }
}
