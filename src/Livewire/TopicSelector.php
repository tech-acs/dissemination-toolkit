<?php

namespace Uneca\DisseminationToolkit\Livewire;

use Uneca\DisseminationToolkit\Models\Topic;
use Livewire\Component;

class TopicSelector extends Component
{
    public $topics;

    public function mount()
    {
        $this->topics = Topic::all();
    }
    public function render()
    {
        return view('dissemination::livewire.topic-selector');
    }
}
