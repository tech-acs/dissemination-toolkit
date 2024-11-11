<?php

namespace Uneca\DisseminationToolkit\Livewire;

use App\Models\Story;
use App\Models\Visualization;
use Livewire\Attributes\Validate;
use Livewire\Component;

class ReviewForm extends Component
{
    #[Validate('required|integer|between:1,5')]
    public int $rating = 0;
    #[Validate('required|string|min:5')]
    public string $headline = '';
    /*#[Validate('required|string|min:5')]*/
    public string $detailedReview = '';
    #[Validate('required')]
    public Visualization|Story $subject;

    public bool $alreadyReviewed;

    public function mount()
    {
        $this->alreadyReviewed = auth()->user()
            ->hasAlreadyReviewed(get_class($this->subject), $this->subject->id);
    }

    public function rate()
    {
        //dump($this->rating, $this->headline, $this->detailedReview);
        $this->validate();
        $this->subject->reviews()->create([
            'user_id' => auth()->id(),
            'rating' => $this->rating,
            'headline' => $this->headline,
            'detailed_review' => $this->detailedReview,
        ]);
        $this->reset();
    }

    public function render()
    {
        return view('livewire.review-form');
    }
}
