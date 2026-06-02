<?php

namespace Uneca\DisseminationToolkit\Livewire;

use Livewire\Component;
use Uneca\DisseminationToolkit\Models\Story;
use Uneca\DisseminationToolkit\Models\Visualization;

class ManageStoryDesigner extends Component
{
    public Story $story;

    public function mount(Story $story)
    {
        $this->story = $story;
    }

    public function save(array $blocks)
    {
        $validated = validator(['blocks' => $blocks], [
            'blocks' => 'required|array',
            'blocks.*.type' => 'required|in:text,image,visualization,two-column',
            'blocks.*.data' => 'required|array',
        ])->validate();

        $this->story->update(['html' => json_encode($blocks)]);

        $this->dispatch('notify', type: 'success', content: __('Saved successfully'));
    }

    public function render()
    {
        $visualizations = Visualization::published()->orderBy('title')->get();
        $blocks = [];
        if ($this->story->html) {
            $decoded = json_decode($this->story->html, true);
            if (is_array($decoded)) {
                $blocks = $decoded;
            }
        }

        return view('dissemination::livewire.manage-story-designer', compact('visualizations', 'blocks'))
            ->layout('layouts.app');
    }
}
