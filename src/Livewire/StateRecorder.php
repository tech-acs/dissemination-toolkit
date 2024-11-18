<?php

namespace Uneca\DisseminationToolkit\Livewire;

use Livewire\Attributes\On;
use Livewire\Component;
use Uneca\DisseminationToolkit\Services\QueryBuilder;

class StateRecorder extends Component
{
    #[On('dataShaperEvent')]
    public function recordDataShape(array $rawData, string $indicatorName, array $dataParams)
    {
        $resource = session()->get('viz-wizard-resource');
        $resource->dataSources = toDataFrame(collect($rawData))->toArray();
        $resource->indicatorTitle = $indicatorName;
        $resource->dataParams = $dataParams;
        $resource->rawData = $rawData;
        session()->put('viz-wizard-resource', $resource);
    }

    #[On('thumbnailCaptured')]
    public function recordThumbnail(string $imageData)
    {
        $resource = session()->get('viz-wizard-resource');
        $resource->thumbnail = $imageData;
        session()->put('viz-wizard-resource', $resource);
    }

    #[On('tableOptionsShaperEvent')]
    public function recordOptions(array $options): void
    {
        $resource = session()->get('viz-wizard-resource');
        $resource->options = array_replace_recursive($resource->options, $options);
        session()->put('viz-wizard-resource', $resource);
    }

    #[On('mapOptionsShaperEvent')]
    public function recordMapTweaks(array $options): void
    {
        //dump($options);
        $resource = session()->get('viz-wizard-resource');
        $resource->data[0] = array_replace_recursive($resource->data[0], $options['data']);
        $resource->layout = array_replace_recursive($resource->layout, $options['layout']);
        session()->put('viz-wizard-resource', $resource);
    }

    public function render()
    {
        return <<<'blade'
            <div></div>
        blade;
    }
}
