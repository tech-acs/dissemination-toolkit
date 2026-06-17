<?php

use Uneca\DisseminationToolkit\Models\Dataset;
use Uneca\DisseminationToolkit\Models\Dimension;
use Uneca\DisseminationToolkit\Models\Indicator;
use Uneca\DisseminationToolkit\Models\Topic;

it('can create a dataset using the factory', function () {
    $dataset = Dataset::factory()->create();

    expect($dataset->refresh())->toBeInstanceOf(Dataset::class)
        ->and($dataset->name)->toBeString();
});

it('can be attached to topics', function () {
    $dataset = Dataset::factory()->create();

    $dataset->topics()->attach(Topic::factory()->create());

    expect($dataset->topics)->toHaveCount(1);
});

it('can be attached to dimensions', function () {
    $dataset = Dataset::factory()->create();

    $dataset->dimensions()->attach(Dimension::factory()->create());

    expect($dataset->dimensions)->toHaveCount(1);
});

it('can be attached to indicators', function () {
    $dataset = Dataset::factory()->create();

    $dataset->indicators()->attach(Indicator::factory()->create());

    expect($dataset->indicators)->toHaveCount(1);
});

it('filters published datasets', function () {
    Dataset::factory()->create(['published' => true]);
    Dataset::factory()->create(['published' => false]);

    expect(Dataset::published()->count())->toBe(1);
});
