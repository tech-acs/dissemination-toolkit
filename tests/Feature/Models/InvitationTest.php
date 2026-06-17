<?php

use Uneca\DisseminationToolkit\Models\Invitation;

it('can create an invitation using the factory', function () {
    $invitation = Invitation::factory()->create();

    expect($invitation->refresh())->toBeInstanceOf(Invitation::class)
        ->and($invitation->email)->toBeString();
});

it('reports whether it is expired', function () {
    $expired = Invitation::factory()->create(['expires_at' => now()->subDay()]);
    $active = Invitation::factory()->create(['expires_at' => now()->addDay()]);

    expect($expired->is_expired)->toBeTrue()
        ->and($active->is_expired)->toBeFalse();
});

it('returns an expiration status message', function () {
    $invitation = Invitation::factory()->create(['expires_at' => now()->addDays(2)]);

    expect($invitation->status)->toBeString()
        ->and($invitation->status)->toContain('Expires in');
});
