<?php

use Uneca\DisseminationToolkit\Enums\CensusTableTypeEnum;
use Uneca\DisseminationToolkit\Models\Document;
use Uneca\DisseminationToolkit\Models\Tag;
use Uneca\DisseminationToolkit\Models\Topic;
use Uneca\DisseminationToolkit\Models\User;

it('can create a document using the factory', function () {
    $document = Document::factory()->create();

    expect($document->refresh())->toBeInstanceOf(Document::class)
        ->and($document->title)->toBeString();
});

it('belongs to a user', function () {
    $user = User::factory()->create();
    $document = Document::factory()->create(['user_id' => $user->id]);

    expect($document->user->id)->toBe($user->id);
});

it('can have topics and tags', function () {
    $document = Document::factory()->create();

    $document->topics()->attach(Topic::factory()->create());
    $document->tags()->attach(Tag::factory()->create());

    expect($document->topics)->toHaveCount(1)
        ->and($document->tags)->toHaveCount(1);
});

it('casts dataset type to an enum', function () {
    $document = Document::factory()->create([
        'dataset_type' => CensusTableTypeEnum::Report->value,
    ]);

    expect($document->dataset_type)->toBeInstanceOf(CensusTableTypeEnum::class)
        ->and($document->dataset_type)->toBe(CensusTableTypeEnum::Report);
});

it('filters published documents', function () {
    Document::factory()->create(['published' => true]);
    Document::factory()->create(['published' => false]);

    expect(Document::published()->count())->toBe(1);
});
