<?php

use Uneca\DisseminationToolkit\Models\Topic;

it('redirects guests from the topic management index', function () {
    $this->get(route('manage.topic.index'))
        ->assertRedirect(route('login'));
});

it('allows an admin to view the topic index', function () {
    $this->actingAs(adminUser(), 'sanctum')
        ->get(route('manage.topic.index'))
        ->assertOk();
});

it('allows an admin to create a topic', function () {
    $response = $this->actingAs(adminUser(), 'sanctum')
        ->post(route('manage.topic.store'), [
            'name' => 'New Topic',
            'description' => 'A description',
            'rank' => 1,
        ]);

    $response->assertRedirect(route('manage.topic.index'));

    expect(Topic::where('name->en', 'New Topic')->exists())->toBeTrue();
});

it('validates topic creation input', function () {
    $this->actingAs(adminUser(), 'sanctum')
        ->post(route('manage.topic.store'), [
            'name' => '',
        ])
        ->assertSessionHasErrors(['name']);
});

it('allows an admin to update a topic', function () {
    $topic = Topic::factory()->create();

    $this->actingAs(adminUser(), 'sanctum')
        ->patch(route('manage.topic.update', $topic), [
            'name' => 'Updated Topic',
            'description' => 'Updated description',
            'rank' => $topic->rank,
        ])
        ->assertRedirect(route('manage.topic.index'));

    expect($topic->refresh()->name)->toBe('Updated Topic');
});

it('allows an admin to delete a topic', function () {
    $topic = Topic::factory()->create();

    $this->actingAs(adminUser(), 'sanctum')
        ->delete(route('manage.topic.destroy', $topic))
        ->assertRedirect(route('manage.topic.index'));

    expect(Topic::find($topic->id))->toBeNull();
});
