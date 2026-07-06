<?php

use Uneca\DisseminationToolkit\Models\Organization;

it('can create an organization using the factory', function () {
    $organization = Organization::factory()->create();

    expect($organization->refresh())->toBeInstanceOf(Organization::class)
        ->and($organization->name)->toBeString();
});

it('casts social media to an array', function () {
    $organization = Organization::factory()->create([
        'social_media' => ['twitter' => 'https://x.test/org'],
    ]);

    expect($organization->social_media)->toBeArray()
        ->and($organization->social_media['twitter'])->toBe('https://x.test/org');
});
