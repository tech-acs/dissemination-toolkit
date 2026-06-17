<?php

use Spatie\Permission\Models\Role;
use Uneca\DisseminationToolkit\Models\Announcement;
use Uneca\DisseminationToolkit\Models\Document;
use Uneca\DisseminationToolkit\Models\Review;
use Uneca\DisseminationToolkit\Models\Story;
use Uneca\DisseminationToolkit\Models\User;
use Uneca\DisseminationToolkit\Models\Visualization;

it('can create a user using the factory', function () {
    $user = User::factory()->create();

    expect($user->refresh())->toBeInstanceOf(User::class)
        ->and($user->name)->toBeString();
});

it('can have roles assigned', function () {
    $role = Role::create(['name' => 'editor', 'guard_name' => 'web']);
    $user = User::factory()->create();

    $user->assignRole($role);

    expect($user->hasRole('editor'))->toBeTrue();
});

it('can own visualizations, stories, documents and announcements', function () {
    $user = User::factory()->create();

    Visualization::factory()->create(['user_id' => $user->id]);
    Story::factory()->create(['user_id' => $user->id]);
    Document::factory()->create(['user_id' => $user->id]);
    Announcement::factory()->create(['user_id' => $user->id]);

    expect($user->visualizations)->toHaveCount(1)
        ->and($user->stories)->toHaveCount(1)
        ->and($user->documents)->toHaveCount(1)
        ->and($user->announcements)->toHaveCount(1);
});

it('can detect whether it has already reviewed an item', function () {
    $user = User::factory()->create();
    $story = Story::factory()->create();

    expect($user->hasAlreadyReviewed(Story::class, $story->id))->toBeFalse();

    Review::factory()->create([
        'user_id' => $user->id,
        'reviewable_type' => Story::class,
        'reviewable_id' => $story->id,
    ]);

    expect($user->hasAlreadyReviewed(Story::class, $story->id))->toBeTrue();
});
