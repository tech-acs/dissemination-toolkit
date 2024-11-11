<?php

namespace Uneca\DisseminationToolkit\Livewire;

use Livewire\Attributes\On;
use Livewire\Component;
use Spatie\SimpleExcel\SimpleExcelWriter;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Uneca\DisseminationToolkit\Livewire\Visualizations\Table;

class DataExplorer extends Component
{
    public ?string $livewireComponent = Table::class;
    public string $indicatorName = '';
    public array $dataParams = [];
    public array $data = [];
    public bool $hasData = false;
    public array $dataShaperSelections = [];

    #[On('dataShaperEvent')]
    public function dataShaperUpdated(array $rawData, string $indicatorName, array $dataParams)
    {
        $this->data = $rawData;
        $this->indicatorName = $indicatorName;
        $this->dataParams = $dataParams;
        $this->hasData = ! empty($this->data);
    }

    #[On('dataShaperSelectionMade')]
    public function dataShaperSelectionMade(array $selection)
    {
        $this->dataShaperSelections = $selection;
    }

    public function download(): StreamedResponse
    {
        $filename = str($this->indicatorName)->slug('-')->append('.xlsx')->toString();
        $writer = SimpleExcelWriter::streamDownload($filename)->addRows($this->data);
        return response()->streamDownload(fn() => $writer->close(), $filename);
    }

    public function render()
    {
        return view('dissemination::livewire.data-explorer');
    }
}
