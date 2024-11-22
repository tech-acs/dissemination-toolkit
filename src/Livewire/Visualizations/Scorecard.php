<?php

namespace Uneca\DisseminationToolkit\Livewire\Visualizations;

use Uneca\DisseminationToolkit\Traits\AreaResolver;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Livewire\Attributes\On;
use Uneca\DisseminationToolkit\Livewire\Visualization;

class Scorecard extends Visualization
{
    use AreaResolver;

    public const DEFAULT_CONFIG = [
        'responsive' => true,
        'displaylogo' => false,
        'modeBarButtonsToRemove' => ['select2d', 'lasso2d', 'autoScale2d', 'hoverClosestCartesian', 'hoverCompareCartesian'],
    ];
    public array $config;
    public string $filterPath = '';

    public function mount(): void
    {
        parent::mount();
        $this->config = $this->makeConfig();
    }

    public function makeTraces(Collection $rawData): array
    {
        $traces = $this->data;
        $data = toDataFrame($rawData);
        if ($data->isNotEmpty()) {
            foreach ($traces as $index => $trace) {
                $columnNames = Arr::get($trace, 'meta.columnNames', []);
                foreach($columnNames as $key => $columnName) {
                    if (! is_array($columnName)) {
                        $traces[$index][$key] = $data[$columnName] ?? null;
                    }
                }
            }
        } else {
            $traces = [];
        }
        return $traces;
    }

    public function makeConfig(): array
    {
        $dynamicOptions = ['toImageButtonOptions' => ['filename' => $this->htmlId . ' (' . now()->toDayDateTimeString() . ')'], 'locale' => app()->getLocale()];
        return array_merge(self::DEFAULT_CONFIG, $dynamicOptions);
    }

    public function preparePayload(array $rawData = []): void
    {
        $this->data = $this->makeTraces(collect($rawData));
        //array_replace_recursive($this->data[0], $options['data']);
    }

    #[On('dataShaperEvent')]
    public function reactToChanges(array $rawData, string $indicatorName, array $dataParams): void
    {
        //$this->layout = array_replace_recursive($this::DEFAULT_OPTIONS, $this->layout, []);
        $this->preparePayload($rawData);
        $this->dispatch("updateChart.$this->htmlId", $this->data, $this->layout);
    }

    #[On('scorecardOptionsShaperEvent')]
    public function applyOptions(array $options): void
    {
        $indicatorTrace = array_replace_recursive($this->data[0], $options['data']);
        $this->data[0] = $indicatorTrace;
        $this->layout = array_replace_recursive($this->layout, $options['layout']);
        //dump($this->data);
        $this->dispatch("updateResponse.$this->htmlId", $this->data, $this->layout);
    }

    public function render()
    {
        return view('dissemination::livewire.visualizations.scorecard');
    }
}
