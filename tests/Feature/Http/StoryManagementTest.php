<?php

use Uneca\DisseminationToolkit\Models\Story;
use Uneca\DisseminationToolkit\Models\Topic;

it('redirects guests from the story management index', function () {
    $this->get(route('manage.story.index'))
        ->assertRedirect(route('login'));
});

it('allows an admin to view the story index', function () {
    $this->actingAs(adminUser(), 'sanctum')
        ->get(route('manage.story.index'))
        ->assertOk();
});

it('allows an admin to create a story', function () {
    $topic = Topic::factory()->create();

    $response = $this->actingAs(adminUser(), 'sanctum')
        ->post(route('manage.story.store'), [
            'title' => 'My New Story',
            'description' => 'This is a long enough description.',
            'topics' => [$topic->id],
            'tags' => 'tag-one,tag-two',
            'featured' => false,
            'is_filterable' => false,
            'is_reviewable' => false,
        ]);

    $response->assertRedirect(route('manage.story.index'));

    $story = Story::where('title->en', 'My New Story')->first();
    expect($story)->not->toBeNull()
        ->and($story->topics)->toHaveCount(1)
        ->and($story->tags)->toHaveCount(2);
});

it('validates story creation input', function () {
    $this->actingAs(adminUser(), 'sanctum')
        ->post(route('manage.story.store'), [
            'title' => '',
            'description' => 'short',
            'topics' => [],
        ])
        ->assertSessionHasErrors(['title', 'description', 'topics']);
});

it('allows an admin to update a story', function () {
    $story = Story::factory()->create();
    $topic = Topic::factory()->create();

    $this->actingAs(adminUser(), 'sanctum')
        ->patch(route('manage.story.update', $story), [
            'title' => 'Updated Story',
            'description' => 'This is a long enough updated description.',
            'topics' => [$topic->id],
            'tags' => 'updated-tag',
            'featured' => true,
            'is_filterable' => true,
            'is_reviewable' => true,
        ])
        ->assertRedirect(route('manage.story.index'));

    expect($story->refresh()->title)->toBe('Updated Story')
        ->and($story->featured)->toBeTrue();
});

it('allows an admin to delete a story', function () {
    $story = Story::factory()->create();

    $this->actingAs(adminUser(), 'sanctum')
        ->delete(route('manage.story.destroy', $story))
        ->assertRedirect(route('manage.story.index'));

    expect(Story::find($story->id))->toBeNull();
});
