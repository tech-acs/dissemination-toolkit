<?php

namespace Uneca\DisseminationToolkit\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Uneca\DisseminationToolkit\Models\Review;
use Uneca\DisseminationToolkit\Models\Story;
use Uneca\DisseminationToolkit\Models\User;

/**
 * @extends Factory<Review>
 */
class ReviewFactory extends Factory
{
    protected $model = Review::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'reviewable_type' => Story::class,
            'reviewable_id' => Story::factory(),
            'rating' => fake()->numberBetween(1, 5),
            'headline' => fake()->sentence(),
            'detailed_review' => fake()->paragraph(),
            'approved_at' => fake()->optional()->dateTime(),
        ];
    }
}
