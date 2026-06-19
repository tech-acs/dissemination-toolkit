<?php

use Uneca\DisseminationToolkit\Models\Review;
use Uneca\DisseminationToolkit\Models\Story;
use Uneca\DisseminationToolkit\Models\Tag;
use Uneca\DisseminationToolkit\Models\Topic;
use Uneca\DisseminationToolkit\Models\User;

it('can create a story using the factory', function () {
    $story = Story::factory()->create();

    expect($story->refresh())->toBeInstanceOf(Story::class)
        ->and($story->title)->toBeString();
});

it('belongs to a user', function () {
    $user = User::factory()->create();

    $story = Story::factory()->create(['user_id' => $user->id]);

    expect($story->user->id)->toBe($user->id);
});

it('generates a slug on creation', function () {
    $story = Story::factory()->create(['title' => ['en' => 'My Great Story']]);

    expect($story->slug)->toBe('my-great-story');
});

it('can have topics and tags', function () {
    $story = Story::factory()->create();

    $story->topics()->attach(Topic::factory()->create());
    $story->tags()->attach(Tag::factory()->create());

    expect($story->topics)->toHaveCount(1)
        ->and($story->tags)->toHaveCount(1);
});

it('can receive reviews', function () {
    $story = Story::factory()->create();

    Review::factory()->create([
        'reviewable_type' => Story::class,
        'reviewable_id' => $story->id,
        'rating' => 4,
        'approved_at' => now(),
    ]);

    expect($story->reviews)->toHaveCount(1)
        ->and($story->rating)->toBe(4)
        ->and($story->reviews_count)->toBe(1);
});

it('filters published and featured stories', function () {
    Story::factory()->create(['published' => true, 'featured' => true]);
    Story::factory()->create(['published' => false, 'featured' => false]);

    expect(Story::published()->count())->toBe(1)
        ->and(Story::featured()->count())->toBe(1);
});
