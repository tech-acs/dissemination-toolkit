<?php

use Uneca\DisseminationToolkit\Models\Review;
use Uneca\DisseminationToolkit\Models\Tag;
use Uneca\DisseminationToolkit\Models\Topic;
use Uneca\DisseminationToolkit\Models\User;
use Uneca\DisseminationToolkit\Models\Visualization;

it('can create a visualization using the factory', function () {
    $visualization = Visualization::factory()->create();

    expect($visualization->refresh())->toBeInstanceOf(Visualization::class)
        ->and($visualization->title)->toBeString();
});

it('belongs to a user', function () {
    $user = User::factory()->create();
    $visualization = Visualization::factory()->create(['user_id' => $user->id]);

    expect($visualization->user->id)->toBe($user->id);
});

it('can have topics and tags', function () {
    $visualization = Visualization::factory()->create();

    $visualization->topics()->attach(Topic::factory()->create());
    $visualization->tags()->attach(Tag::factory()->create());

    expect($visualization->topics)->toHaveCount(1)
        ->and($visualization->tags)->toHaveCount(1);
});

it('can receive reviews', function () {
    $visualization = Visualization::factory()->create();

    Review::factory()->create([
        'reviewable_type' => Visualization::class,
        'reviewable_id' => $visualization->id,
        'rating' => 5,
        'approved_at' => now(),
    ]);

    expect($visualization->reviews)->toHaveCount(1)
        ->and($visualization->rating)->toBe(5);
});

it('filters published visualizations', function () {
    Visualization::factory()->create(['published' => true]);
    Visualization::factory()->create(['published' => false]);

    expect(Visualization::published()->count())->toBe(1);
});

it('exposes a type attribute from the livewire component', function () {
    $visualization = Visualization::factory()->create([
        'livewire_component' => 'Uneca\\DisseminationToolkit\\Livewire\\Visualizations\\Chart',
    ]);

    expect($visualization->type)->toBe('Chart');
});
