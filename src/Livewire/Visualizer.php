<?php

namespace Uneca\DisseminationToolkit\Livewire;

use Livewire\Component;
use Uneca\DisseminationToolkit\Livewire\Visualizations\Table;

class Visualizer extends Component
{
    public string $designatedComponent = Table::class;
    public array $rawData = [];
    public array $data = [];
    public array $layout = [];
    public array $options = [];
    public int $vizId;

    public function render()
    {
        return view('dissemination::livewire.visualizer');
    }
}
