<?php

namespace Uneca\DisseminationToolkit\Livewire\DataShaperTraits;

use Uneca\DisseminationToolkit\Models\Topic;

trait TopicTrait {
    public array $topics = [];
    public int $selectedTopic = 0;

    public function mountTopicTrait()
    {
        //$this->topics = Topic::has('indicators')->pluck('name', 'id')->all();
        $this->topics = Topic::has('datasets')->pluck('name', 'id')->all();
    }

    public function updatedSelectedTopic(int $topicId): void
    {
        $this->reset('selectedDataset', 'selectedIndicators', 'datasets', 'selectedGeographyLevels',
            'geographyLevels', 'geographies', 'selectedGeographies', 'years', 'selectedYears',
            'dimensions', 'selectedDimensions', 'selectedDimensionValues', 'pivotableDimensions', 'pivotColumn', 'pivotRow', 'nestingPivotColumn');
        $topic = Topic::find($topicId);
        //$this->datasets = $topic?->datasets->pluck('name', 'id')->all() ?? [];
        $this->datasets = $topic?->datasets->mapWithKeys(function ($dataset) {
            return [$dataset->id => $dataset->info()];
        })->all();
        $this->nextSelection = 'dataset';

        $this->dispatch('dataShaperSelectionMade', $this->makeReadableDataParams('topic', $topic->name));
    }
}
