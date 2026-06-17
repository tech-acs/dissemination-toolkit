<?php

use Uneca\DisseminationToolkit\Models\Document;
use Uneca\DisseminationToolkit\Models\Story;
use Uneca\DisseminationToolkit\Models\Tag;
use Uneca\DisseminationToolkit\Models\Visualization;

it('can create a tag using the factory', function () {
    $tag = Tag::factory()->create();

    expect($tag->refresh())->toBeInstanceOf(Tag::class)
        ->and($tag->name)->toBeString();
});

it('prepares tags from a comma separated string', function () {
    $tags = Tag::prepareForSync('foo,bar,baz');

    expect($tags)->toHaveCount(3);
    expect(Tag::pluck('name')->all())->toContain('foo', 'bar', 'baz');
});

it('returns an empty collection for an empty tag string', function () {
    expect(Tag::prepareForSync(''))->toHaveCount(0)
        ->and(Tag::prepareForSync(null))->toHaveCount(0);
});

it('formats tags as a javascript array', function () {
    $tags = Tag::factory()->count(2)->create();

    expect(Tag::tagsToJsArray($tags))->toBe("['{$tags[0]->name}','{$tags[1]->name}']");
});

it('can be attached to visualizations, stories and documents', function () {
    $tag = Tag::factory()->create();

    $tag->visualizations()->attach(Visualization::factory()->create());
    $tag->stories()->attach(Story::factory()->create());
    $tag->documents()->attach(Document::factory()->create());

    expect($tag->visualizations)->toHaveCount(1)
        ->and($tag->stories)->toHaveCount(1)
        ->and($tag->documents)->toHaveCount(1);
});
