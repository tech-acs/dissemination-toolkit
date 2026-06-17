<?php

use Uneca\DisseminationToolkit\Models\Review;
use Uneca\DisseminationToolkit\Models\Story;
use Uneca\DisseminationToolkit\Models\User;
use Uneca\DisseminationToolkit\Models\Visualization;

it('can create a review using the factory', function () {
    $review = Review::factory()->create();

    expect($review->refresh())->toBeInstanceOf(Review::class)
        ->and($review->rating)->toBeBetween(1, 5);
});

it('belongs to a user', function () {
    $user = User::factory()->create();
    $review = Review::factory()->create(['user_id' => $user->id]);

    expect($review->user->id)->toBe($user->id);
});

it('is morphable to stories and visualizations', function () {
    $story = Story::factory()->create();
    $visualization = Visualization::factory()->create();

    $storyReview = Review::factory()->create([
        'reviewable_type' => Story::class,
        'reviewable_id' => $story->id,
    ]);

    $vizReview = Review::factory()->create([
        'reviewable_type' => Visualization::class,
        'reviewable_id' => $visualization->id,
    ]);

    expect($storyReview->reviewable->id)->toBe($story->id)
        ->and($vizReview->reviewable->id)->toBe($visualization->id);
});

it('scopes approved reviews', function () {
    Review::factory()->create(['approved_at' => now()]);
    Review::factory()->create(['approved_at' => null]);

    expect(Review::approved()->count())->toBe(1);
});
