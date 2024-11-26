<?php

namespace Uneca\DisseminationToolkit\Livewire\Dataset;

use Livewire\Component;
use Uneca\DisseminationToolkit\Models\Dimension;
use Uneca\DisseminationToolkit\Models\Indicator;
use Uneca\DisseminationToolkit\Services\AreaTree;

class Create extends Component
{
    public DatasetForm $form;
    public array $indicatorsList = [];
    public array $dimensionsList = [];
    public array $factTablesList = [];
    public array $areaLevelsList = [];

    public function mount()
    {
        $this->indicatorsList = Indicator::orderBy('name')->pluck('name', 'id')->toArray();
        $this->dimensionsList = Dimension::orderBy('name')->pluck('name', 'id')->toArray();
        $this->factTablesList = config('dissemination.fact_tables');
        $this->areaLevelsList = (new AreaTree())->hierarchies;
    }

    public function updateDimensionsList()
    {
        $this->dimensionsList = Dimension::applicableTo($this->form->fact_table)->pluck('name', 'id')->toArray();
    }

    public function save()
    {
        $this->form->store();
        session()->flash('message', 'Record created.');
        return $this->redirect(route('manage.dataset.index'));
    }

    public function render()
    {
        return view('dissemination::livewire.dataset.form');
    }
}
