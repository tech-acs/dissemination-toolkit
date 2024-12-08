<?php

namespace Uneca\DisseminationToolkit\Livewire\DataShaperTraits;

use Uneca\DisseminationToolkit\Models\Dataset;

trait DatasetTrait
{
    public array $datasets = [];
    public int $selectedDataset = 0;

    public function updatedSelectedDataset($datasetId): void
    {
        $this->reset(
            'selectedIndicators',
            'selectedGeographyLevels',
            'selectedGeographies',
            'geographyLevels',
            'geographies',
            'years',
            'selectedYears',
            'dimensions',
            'selectedDimensions',
            'selectedDimensionValues',
            'sortingColumn',
            'pivotableDimensions',
            'pivotColumn',
            'pivotRow',
            'nestingPivotColumn'
        );

        $dataset = Dataset::with('dimensions')->find($datasetId);
        $this->indicators = $dataset?->indicators->pluck('name', 'id')->all() ?? [];
        $this->nextSelection = 'indicator';
        $this->dispatch('dataShaperSelectionMade', $this->makeReadableDataParams('dataset', $dataset->name));

        /*$allLevels = (new AreaTree())->hierarchies;
        $this->geographyLevels = $dataset ? array_slice($allLevels, 0,$dataset->max_area_level + 1) : $allLevels;
        //$this->geographies = Area::ofLevel(0)->pluck('name', 'id')->all();

        foreach($this->geographyLevels as $level => $levelName) {
            //$this->geographies[$level] = Area::ofLevel($level)->pluck('name', 'id')->all();
            $areas = Area::ofLevel($level)->select(['id', 'name', 'path'])
                ->get()
                ->map(function ($area) {
                    $area->group = str($area->path)
                        ->beforeLast('.')
                        ->value();
                    return $area;
                })
                ->groupBy("group")
                ->all();
            $this->geographies[$level] = $areas;
            $this->selectedGeographies[$level] = [];
        }

        $this->years = $dataset->years->pluck('name', 'id')->all();

        $this->dimensions = $dataset->dimensions->map(function ($dimension) {
            return [
                'id' => $dimension->id,
                'label' => $dimension->name,
                'values' => $dimension->values()->map(fn ($v) => ['id' => $v->id, 'name' => $v->name])->all(),
            ];
        })->all();

        $this->selectedDimensionValues = collect($this->dimensions)
            ->keyBy('id')
            ->map(fn ($dimension) => [])
            ->all();
        $this->nextSelection = 'geography';

        $this->dispatch('dataShaperSelectionMade', $this->makeReadableDataParams('dataset', $dataset->name));*/
    }
}
