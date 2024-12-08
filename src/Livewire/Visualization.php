<?php

namespace Uneca\DisseminationToolkit\Livewire;

use Uneca\DisseminationToolkit\Services\QueryBuilder;
use Uneca\DisseminationToolkit\Services\Sorter;
use Livewire\Component;

abstract class Visualization extends Component
{
    public const DEFAULT_OPTIONS = [];
    public const EDITABLE_OPTIONS = [];

    public string $htmlId;
    public array $rawData = [];
    public array $data = [];
    public array $layout = [];
    public array $options = [];
    public ?int $vizId = null;

    public function mount(): void
    {
        $this->htmlId = 'viz-' . str()->random(5);

        if ($this->vizId) {
            $visualization = \Uneca\DisseminationToolkit\Models\Visualization::find($this->vizId);
            $this->data = $visualization->data;
            $this->layout = $visualization->layout;
            $this->options = $visualization->options;
            $query = new QueryBuilder($visualization->data_params);
            $this->rawData = $query->get()->all();//Sorter::sort($query->get());
        }
        if (! empty($this->rawData)) {
            $this->preparePayload($this->rawData);
        }
    }

    /*#[On('thumbnailCaptureRequested')]
    public function captureThumbnail($name):void
    {
        $this->dispatch("captureThumbnail.$this->visualizationId", $name);
    }*/

    abstract public function reactToChanges(array $rawData, string $indicatorName, array $dataParams);

    abstract public function preparePayload(array $rawData = []): void;
}
