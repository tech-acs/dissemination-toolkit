<?php

use Uneca\DisseminationToolkit\Models\Dataset;
use Uneca\DisseminationToolkit\Models\Indicator;
use Uneca\DisseminationToolkit\Models\Topic;

it('can create an indicator using the factory', function () {
    $indicator = Indicator::factory()->create();

    expect($indicator->refresh())->toBeInstanceOf(Indicator::class)
        ->and($indicator->name)->toBeString();
});

it('generates a slug attribute', function () {
    $indicator = Indicator::factory()->create(['name' => ['en' => 'Population Density']]);

    expect($indicator->slug)->toBe('population-density');
});

it('can be attached to topics', function () {
    $indicator = Indicator::factory()->create();
    $topic = Topic::factory()->create();

    $indicator->topics()->attach($topic);

    expect($indicator->topics)->toHaveCount(1);
});

it('can be attached to datasets', function () {
    $indicator = Indicator::factory()->create();
    $dataset = Dataset::factory()->create();

    $indicator->datasets()->attach($dataset);

    expect($indicator->datasets)->toHaveCount(1);
});
