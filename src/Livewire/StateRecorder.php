<?php

namespace Uneca\DisseminationToolkit\Livewire;

use Livewire\Attributes\On;
use Livewire\Component;
use Uneca\DisseminationToolkit\Http\Resources\DesignerResource;
use Uneca\DisseminationToolkit\Services\VizWizardSession;

class StateRecorder extends Component
{
    #[On('dataShaperEvent')]
    public function recordDataShape(array $rawData, string $indicatorName, array $dataParams)
    {
        $resource = VizWizardSession::get();
        if (! $resource instanceof DesignerResource) {
            return;
        }
        $resource->dataSources = toDataFrame(collect($rawData))->toArray();
        $resource->indicatorTitle = $indicatorName;
        $resource->dataParams = $dataParams;
        $resource->rawData = $rawData;
        VizWizardSession::put($resource);
    }

    #[On('thumbnailCaptured')]
    public function recordThumbnail(string $imageData)
    {
        $resource = VizWizardSession::get();
        if (! $resource instanceof DesignerResource) {
            return;
        }
        $resource->thumbnail = $imageData;
        VizWizardSession::put($resource);
    }

    #[On('tableOptionsShaperEvent')]
    public function recordOptions(array $options): void
    {
        $resource = VizWizardSession::get();
        if (! $resource instanceof DesignerResource) {
            return;
        }
        $resource->options = array_replace_recursive($resource->options, $options);
        VizWizardSession::put($resource);
    }

    #[On('mapOptionsShaperEvent')]
    public function recordMapTweaks(array $options): void
    {
        $resource = VizWizardSession::get();
        if (! $resource instanceof DesignerResource) {
            return;
        }
        $resource->data[0] = array_replace_recursive($resource->data[0], $options['data']);
        $resource->layout = array_replace_recursive($resource->layout, $options['layout']);
        VizWizardSession::put($resource);
    }

    #[On('scorecardOptionsShaperEvent')]
    public function recordScorecardTweaks(array $options): void
    {
        $resource = VizWizardSession::get();
        if (! $resource instanceof DesignerResource) {
            return;
        }
        $resource->data[0] = array_replace_recursive($resource->data[0], $options['data']);
        $resource->layout = array_replace_recursive($resource->layout, $options['layout']);
        VizWizardSession::put($resource);
    }

    public function render()
    {
        return <<<'blade'
            <div></div>
        blade;
    }
}
