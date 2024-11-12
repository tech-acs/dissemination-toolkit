<?php

namespace Uneca\DisseminationToolkit\Livewire;

use Livewire\Component;

class TableOptionsShaper extends Component
{
    public array $options = [];
    public array $optionLabels = [
        'pagination' => 'Enable pagination',
        'suppressMovableColumns' => 'Disable movable columns',
        'unSortIcon' => 'Show unsort icon',
        'columnHoverHighlight' => 'Highlight columns on hover'
    ];
    public ?int $sortColumn = null;
    public string $sortDirection = 'asc';

    public function mount()
    {
        $this->sortColumn = collect($this->options['columnDefs'])->reduce(function ($carry, $columnDef, $index) {
            return key_exists('sort', $columnDef) && ! is_null($columnDef['sort']) ? $index : $carry;
        });
    }

    public function apply()
    {
        if (! is_null($this->sortColumn)) {
            foreach ($this->options['columnDefs'] as $index => $columnDef) {
                if ($columnDef['sort'] ?? null) {
                    $this->options['columnDefs'][$index]['sort'] = null;
                }
            }
            $this->options['columnDefs'][$this->sortColumn]['sort'] = $this->sortDirection;
        }
        $options = $this->options;
        unset($options['rowData']);
        $this->dispatch('tableOptionsShaperEvent', options: $options);
    }

    public function render()
    {
        //dump($this->options, $this->sortColumn);
        return view('dissemination::livewire.table-options-shaper');
    }
}
