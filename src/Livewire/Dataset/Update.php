<?php

namespace Uneca\DisseminationToolkit\Livewire\Dataset;

use Livewire\Component;
use Uneca\DisseminationToolkit\Models\Dataset;
use Uneca\DisseminationToolkit\Models\Dimension;
use Uneca\DisseminationToolkit\Models\Indicator;
use Uneca\DisseminationToolkit\Services\AreaTree;

class Update extends Component
{
    public DatasetForm $form;
    public array $indicatorsList = [];
    public array $dimensionsList = [];
    public array $factTablesList = [];
    public array $areaLevelsList = [];

    public function mount(Dataset $dataset)
    {
        $this->indicatorsList = Indicator::orderBy('name')->pluck('name', 'id')->toArray();
        $this->dimensionsList = Dimension::orderBy('name')->pluck('name', 'id')->toArray();
        $this->factTablesList = config('dissemination.fact_tables');
        $this->areaLevelsList = (new AreaTree())->hierarchies;
        $this->form->setDataset($dataset);
    }

    public function updateDimensionsList()
    {
        $this->dimensionsList = Dimension::applicableTo($this->form->fact_table)->pluck('name', 'id')->toArray();
    }

    public function save()
    {
        $this->form->update();
        session()->flash('message', 'Record updated.');
        return $this->redirect(route('manage.dataset.index'));
    }

    public function render()
    {
        return view('dissemination::livewire.dataset.form');
    }
}
