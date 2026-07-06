<?php

use Uneca\DisseminationToolkit\Models\Announcement;
use Uneca\DisseminationToolkit\Models\User;

it('can create an announcement using the factory', function () {
    $announcement = Announcement::factory()->create();

    expect($announcement->refresh())->toBeInstanceOf(Announcement::class)
        ->and($announcement->title)->toBeString();
});

it('belongs to a user', function () {
    $user = User::factory()->create();
    $announcement = Announcement::factory()->create(['user_id' => $user->id]);

    expect($announcement->user->id)->toBe($user->id);
});
