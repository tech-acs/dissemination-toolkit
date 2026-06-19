<?php

use Uneca\DisseminationToolkit\Models\Tag;

it('redirects guests from the tag management index', function () {
    $this->get(route('manage.tag.index'))
        ->assertRedirect(route('login'));
});

it('allows an admin to view the tag index', function () {
    $this->actingAs(adminUser(), 'sanctum')
        ->get(route('manage.tag.index'))
        ->assertOk();
});

it('allows an admin to update a tag', function () {
    $tag = Tag::factory()->create();

    $this->actingAs(adminUser(), 'sanctum')
        ->patch(route('manage.tag.update', $tag), ['name' => 'renamed-tag'])
        ->assertRedirect(route('manage.tag.index'));

    expect($tag->refresh()->name)->toBe('renamed-tag');
});

it('allows an admin to view the tag edit form', function () {
    $tag = Tag::factory()->create();

    $this->actingAs(adminUser(), 'sanctum')
        ->get(route('manage.tag.edit', $tag))
        ->assertOk();
});
