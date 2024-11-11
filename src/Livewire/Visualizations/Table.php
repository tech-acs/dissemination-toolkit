<?php

namespace Uneca\DisseminationToolkit\Livewire\Visualizations;

use Uneca\DisseminationToolkit\Services\QueryBuilder;
use Livewire\Attributes\On;
use Uneca\DisseminationToolkit\Livewire\Visualization;

class Table extends Visualization
{
    public const DEFAULT_OPTIONS = [
        /*'defaultColDef' => [
            'width' => 100,
        ],
        'columnTypes' => [
            'rangeColumn' => [
                'width' => 150
            ]
        ],*/
        'columnDefs' => [],
        'rowData' => [],
        'autoSizeStrategy' => [
            'type' => 'fitGridWidth'
        ],
        'suppressMovableColumns' => false,
        'unSortIcon' => false,
        'columnHoverHighlight' => false,
        'pagination' => false,
    ];

    private function makeColumnDefs($data): array
    {
        if ($data->isNotEmpty()) {
            [$toNest, $flat] = collect(array_keys((array)$data->first()))
                ->partition(fn ($header) => str($header)->contains('|'));

            $nested = $toNest
                ->map(function ($joined, $index) {
                    list($parent, $child) = explode('|', $joined);
                    return ['parent' => $parent, 'child' => $child, 'field' => $joined, 'order' => $index];
                })
                ->groupBy('parent')
                ->map(function ($children, $parent) {
                    return [
                        'headerName' => $parent,
                        //'headerHozAlign' => 'center',
                        'order' => min($children->pluck('order')->all()),
                        'children' => $children
                            ->map(function ($c) {
                                $colDef = [
                                    'headerName' => $c['child'],
                                    'field' => $c['field'],
                                    'filter' => false,
                                    'hide' => false,
                                    'sortable' => true,
                                ];
                                if (str($c['child'])->endsWith(QueryBuilder::VALUE_COLUMN_INVISIBLE_MARKER)){
                                    /*$colDef['hozAlign'] = 'right';
                                    $colDef['headerHozAlign'] = 'right';
                                    $colDef['sorter'] = 'number';
                                    $colDef['formatter'] = 'money';*/
                                    $colDef['type'] = 'numericColumn';
                                }
                                return $colDef;
                            })
                            ->values()
                            ->all(),
                    ];
                })->values();

            $notNested = $flat
                ->map(function ($column) {
                    $colDef = [
                        'headerName' => str($column)->replace('_', ' ')->ucfirst()->toString(),
                        'field' => $column,
                        'filter' => false,
                        'hide' => false,
                        'sortable' => true,
                        //'sorter' => 'string',
                        //'frozen' => true
                    ];
                    if (str($column)->endsWith(QueryBuilder::VALUE_COLUMN_INVISIBLE_MARKER)){
                        //$colDef['hozAlign'] = 'right';
                        //$colDef['headerHozAlign'] = 'right';
                        //$colDef['sorter'] = 'number';
                        //$colDef['formatter'] = 'money';
                        $colDef['type'] = 'numericColumn';
                        unset($colDef['filter']);
                    }
                    if (str($column)->contains('age_group')){
                        //$colDef['sorter'] = 'number';
                        $colDef['type'] = 'rangeColumn';
                    }
                    return $colDef;
                });

            return $nested
                ->concat($notNested)
                ->sortBy('order')
                //->map(fn ($header) => $header)
                ->values()
                ->all();
        }
        return [];
    }

    public function preparePayload(array $rawData = []): void
    {
        //$this->options = array_replace_recursive($this::DEFAULT_OPTIONS, $this->options);
        $options['rowData'] = $rawData;
        $options['columnDefs'] = $this->makeColumnDefs(collect($rawData));
        //dump($options, $this->options);
        $this->options = array_replace_recursive($this::DEFAULT_OPTIONS, $options, $this->options);
        //dump($this->options);
        /*$this->options['columnDefs'] = empty($this->options['columnDefs']) ?
            $this->makeColumnDefs(collect($rawData)) :
            $this->options['columnDefs'];*/
    }

    #[On('dataShaperEvent')]
    public function reactToChanges(array $rawData, string $indicatorName, array $dataParams): void
    {
        //$this->options = array_replace_recursive($this::DEFAULT_OPTIONS, $this->options, []);
        $this->preparePayload($rawData);
        $this->dispatch("updateTable.$this->htmlId", $this->options);
    }

    #[On('tableOptionsShaperEvent')]
    public function applyOptions(array $options): void
    {
        $this->options = array_replace_recursive($this->options, $options);
        $this->dispatch("updateTable.$this->htmlId", $this->options);
    }

    public function render()
    {
        return view('dissemination::livewire.visualizations.table');
    }
}
