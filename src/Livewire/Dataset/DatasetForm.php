<?php

namespace Uneca\DisseminationToolkit\Livewire\Dataset;

use Livewire\Form;
use Uneca\DisseminationToolkit\Models\Dataset;
use Uneca\DisseminationToolkit\Models\Dimension;
use Closure;

class DatasetForm extends Form
{
    public ?Dataset $dataset;

    public string $name;
    public string $description = '';
    public string $fact_table;
    public array $indicators = [];
    public array $dimensions = [];
    public int $max_area_level;

    public function rules()
    {
        return [
            'name' => 'required|string|min:5',
            'description' => 'nullable',
            'indicators' => 'required|exists:indicators,id',
            'dimensions' => [
                'required', 'array',
                function (string $attribute, mixed $value, Closure $fail) {
                    $yearDimension = Dimension::firstWhere('table_name', 'year');
                    if (! in_array($yearDimension->id, $value)) {
                        $fail("The year dimension is mandatory");
                    }
                },
            ],
            'fact_table' => 'required',
            'max_area_level' => 'required',
        ];
    }

    public function setDataset(Dataset $dataset)
    {
        $this->dataset = $dataset;
        $this->name = $dataset->name;
        $this->description = $dataset->description;
        $this->fact_table = $dataset->fact_table;
        $this->indicators = $dataset->indicators->pluck('id')->toArray();
        $this->dimensions = $dataset->dimensions->pluck('id')->toArray();
        $this->max_area_level = $dataset->max_area_level;
    }

    public function store()
    {
        $this->validate();
        $dataset = Dataset::create($this->only(['name', 'description', 'fact_table', 'max_area_level']));
        $dataset->indicators()->sync($this->indicators);
        $dataset->dimensions()->sync($this->dimensions);
        $inheritedTopics = $dataset->indicators->pluck('topics')->flatten()->pluck('id')->unique();
        $dataset->topics()->sync($inheritedTopics);
    }

    public function update()
    {
        $this->validate();
        $this->dataset->update($this->only(['name', 'description', 'fact_table', 'max_area_level']));
        $this->dataset->indicators()->sync($this->indicators);
        $this->dataset->dimensions()->sync($this->dimensions);
        $inheritedTopics = $this->dataset->indicators->pluck('topics')->flatten()->pluck('id')->unique();
        $this->dataset->topics()->sync($inheritedTopics);
    }

    public function render()
    {
        return view('livewire.dataset.create');
    }
}
