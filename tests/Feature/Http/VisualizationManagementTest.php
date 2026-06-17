<?php

use Uneca\DisseminationToolkit\Models\Visualization;

it('redirects guests from the visualization management index', function () {
    $this->get(route('manage.visualization.index'))
        ->assertRedirect(route('login'));
});

it('allows an admin to view the visualization index', function () {
    $this->actingAs(adminUser(), 'sanctum')
        ->get(route('manage.visualization.index'))
        ->assertOk();
});

it('allows an admin to delete a visualization', function () {
    $visualization = Visualization::factory()->create();

    $this->actingAs(adminUser(), 'sanctum')
        ->delete(route('manage.visualization.destroy', $visualization))
        ->assertRedirect(route('manage.visualization.index'));

    expect(Visualization::find($visualization->id))->toBeNull();
});

it('allows an admin to toggle the published status', function () {
    $visualization = Visualization::factory()->create(['published' => false]);

    $this->actingAs(adminUser(), 'sanctum')
        ->patch(route('manage.visualization.change-published-status', $visualization), [
            'published' => true,
        ])
        ->assertRedirect(route('manage.visualization.index'));

    expect($visualization->refresh()->published)->toBeTrue();
});

it('allows an admin to toggle the restricted status', function () {
    $visualization = Visualization::factory()->create(['restricted' => true]);

    $this->actingAs(adminUser(), 'sanctum')
        ->patch(route('manage.visualization.change-restricted-status', $visualization), [
            'restricted' => false,
        ])
        ->assertRedirect(route('manage.visualization.index'));

    expect($visualization->refresh()->restricted)->toBeFalse();
});
