<?php

namespace Uneca\DisseminationToolkit\Livewire;

use App\Enums\RatingEnum;
use App\Models\Story;
use App\Models\Visualization;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Rating extends Component
{
    public string $type;
    public int $id;
    public string $selectedRate;
    public array $possibleRatings = [];
    public Visualization|Story $ratingModel;
    public int $hoveredRating;
    public function mount(): void
    {
        $this->possibleRatings = RatingEnum::getRatings();

        if ($this->type === class_basename(Visualization::class)) {
            $this->ratingModel = Visualization::find($this->id);
        } elseif ($this->type === class_basename(Story::class)) {
            $this->ratingModel = Story::find($this->id);
        }

        if ($this->ratingModel->rated) {
            $ratedValue =  $this->ratingModel->ratings()->where('user_id', auth()->id())->first()->value;
            $this->setSelectedValue($ratedValue);
        }
    }
    public function saveRating($value): void
    {
        if ($this->ratingModel->rated) {
            return;
        }
        $this->setSelectedValue($value);
        $this->ratingModel->ratings()->create([
            'user_id' => auth()->id(),
            'value' => $value
        ]);
    }
    private function setSelectedValue($value): void
    {
        foreach ($this->possibleRatings as $key => $rating) {
            if ($rating['value'] <= $value) {
                $this->possibleRatings[$key]['isSelected'] = true;
            } else {
                $this->possibleRatings[$key]['isSelected'] = false;
            }
        }
        $this->selectedRate = collect($this->possibleRatings)->where('value', $value)->first()['label'];
    }

    public function render(): View|Factory|Application|\Illuminate\Foundation\Application
    {
        return view('livewire.rating');
    }
}
