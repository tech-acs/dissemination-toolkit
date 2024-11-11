<?php

namespace Uneca\DisseminationToolkit\Components;

use Uneca\DisseminationToolkit\Models\Story;
use Uneca\DisseminationToolkit\Models\Visualization;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class Reviews extends Component
{
    public Collection $reviews;

    public function __construct(public Visualization|Story $subject)
    {
        $this->reviews = $this->subject->reviews()->approved()->get()->map(function ($review) {
            return (object)[
                'id' => $review->id,
                'headline' => $review->headline,
                'detailed_review' => $review->detailed_review,
                'rating' => $review->rating,
                'reviewed_on' => $review->created_at->toFormattedDateString(),
                'reviewer' => (object)[
                    'name' => $review->user->name,
                    'joined_on' => $review->user->created_at->toFormattedDateString(),
                ]
            ];
        });
    }

    public function render()
    {
        return view('components.reviews');
    }
}
