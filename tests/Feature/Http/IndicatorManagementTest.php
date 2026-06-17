<?php

use Uneca\DisseminationToolkit\Models\Indicator;
use Uneca\DisseminationToolkit\Models\Topic;

it('redirects guests from the indicator management index', function () {
    $this->get(route('manage.indicator.index'))
        ->assertRedirect(route('login'));
});

it('allows an admin to view the indicator index', function () {
    $this->actingAs(adminUser(), 'sanctum')
        ->get(route('manage.indicator.index'))
        ->assertOk();
});

it('allows an admin to create an indicator', function () {
    $topic = Topic::factory()->create();

    $this->actingAs(adminUser(), 'sanctum')
        ->post(route('manage.indicator.store'), [
            'name' => 'New Indicator',
            'description' => 'A description',
            'code' => 'new_indicator',
            'topics' => [$topic->id],
        ])
        ->assertRedirect(route('manage.indicator.index'));

    $indicator = Indicator::where('code', 'new_indicator')->first();
    expect($indicator)->not->toBeNull()
        ->and($indicator->topics)->toHaveCount(1);
});

it('validates indicator creation input', function () {
    $this->actingAs(adminUser(), 'sanctum')
        ->post(route('manage.indicator.store'), [
            'name' => '',
            'code' => '',
            'topics' => [],
        ])
        ->assertSessionHasErrors(['name', 'code', 'topics']);
});

it('allows an admin to update an indicator', function () {
    $indicator = Indicator::factory()->create();
    $topic = Topic::factory()->create();

    $this->actingAs(adminUser(), 'sanctum')
        ->patch(route('manage.indicator.update', $indicator), [
            'name' => 'Updated Indicator',
            'description' => 'Updated description',
            'code' => $indicator->code,
            'topics' => [$topic->id],
        ])
        ->assertRedirect(route('manage.indicator.index'));

    expect($indicator->refresh()->name)->toBe('Updated Indicator');
});

it('allows an admin to delete an indicator', function () {
    $indicator = Indicator::factory()->create();

    $this->actingAs(adminUser(), 'sanctum')
        ->delete(route('manage.indicator.destroy', $indicator))
        ->assertRedirect(route('manage.indicator.index'));

    expect(Indicator::find($indicator->id))->toBeNull();
});
