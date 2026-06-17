<?php

use Uneca\DisseminationToolkit\Models\Document;
use Uneca\DisseminationToolkit\Models\Indicator;
use Uneca\DisseminationToolkit\Models\Story;
use Uneca\DisseminationToolkit\Models\Topic;
use Uneca\DisseminationToolkit\Models\Visualization;

it('can create a topic using the factory', function () {
    $topic = Topic::factory()->create();

    expect($topic->refresh())->toBeInstanceOf(Topic::class)
        ->and($topic->name)->toBeString();
});

it('can be attached to documents', function () {
    $topic = Topic::factory()->create();
    $document = Document::factory()->create();

    $topic->documents()->attach($document);

    expect($topic->documents)->toHaveCount(1)
        ->and($topic->documents->first()->id)->toBe($document->id);
});

it('can be attached to indicators', function () {
    $topic = Topic::factory()->create();
    $indicator = Indicator::factory()->create();

    $topic->indicators()->attach($indicator);

    expect($topic->indicators)->toHaveCount(1);
});

it('can be attached to visualizations', function () {
    $topic = Topic::factory()->create();
    $visualization = Visualization::factory()->create();

    $topic->visualizations()->attach($visualization);

    expect($topic->visualizations)->toHaveCount(1);
});

it('can be attached to stories', function () {
    $topic = Topic::factory()->create();
    $story = Story::factory()->create();

    $topic->stories()->attach($story);

    expect($topic->stories)->toHaveCount(1);
});
