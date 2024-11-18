<?php

namespace Uneca\DisseminationToolkit\Livewire;

use Illuminate\Support\Arr;
use Livewire\Component;

class MapOptionsShaper extends Component
{
    public array $options = [];
    public array $optionValues = [];

    public function mount()
    {
        $this->optionValues = Arr::undot(array_map(fn($option) => $option['value'], $this->options));
    }

    /*public function updated($property)
    {
        if ($property === 'optionValues.data.meta.columnNames.z') {
            $this->optionValues['data']['zsrc'] = Arr::get($this->optionValues, 'data.meta.columnNames.z');
        }
    }*/

    public function apply()
    {
        //dump($this->optionValues);
        $this->dispatch('mapOptionsShaperEvent', options: $this->optionValues);
    }

    public function render()
    {
        return view('dissemination::livewire.map-options-shaper');
    }
}
