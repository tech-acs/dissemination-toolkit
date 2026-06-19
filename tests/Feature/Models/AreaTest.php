<?php

use Uneca\DisseminationToolkit\Models\Area;

it('can create an area using the factory', function () {
    $area = Area::factory()->create();

    expect($area->refresh())->toBeInstanceOf(Area::class)
        ->and($area->name)->toBeString();
});

it('can be filtered by level', function () {
    Area::factory()->create(['level' => 0]);
    Area::factory()->create(['level' => 1]);

    expect(Area::ofLevel(0)->count())->toBe(1)
        ->and(Area::ofLevel(1)->count())->toBe(1);
});
