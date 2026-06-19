<?php

use Uneca\DisseminationToolkit\Models\AreaHierarchy;

it('can create an area hierarchy using the factory', function () {
    $hierarchy = AreaHierarchy::factory()->create();

    expect($hierarchy->refresh())->toBeInstanceOf(AreaHierarchy::class)
        ->and($hierarchy->name)->toBeString();
});

it('casts map zoom levels to an array', function () {
    $hierarchy = AreaHierarchy::factory()->create([
        'map_zoom_levels' => [1, 5, 10],
    ]);

    expect($hierarchy->map_zoom_levels)->toBeArray()->toBe([1, 5, 10]);
});
