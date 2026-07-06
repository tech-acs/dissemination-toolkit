<?php

use Uneca\DisseminationToolkit\Models\User;

it('redirects guests from the user management index', function () {
    $this->get(route('manage.user.index'))
        ->assertRedirect(route('login'));
});

it('allows an admin to view the user index after password confirmation', function () {
    $this->actingAs(adminUser(), 'sanctum')
        ->withSession(['auth.password_confirmed_at' => time()])
        ->get(route('manage.user.index'))
        ->assertOk();
});

it('allows an admin to update a user role', function () {
    $user = User::factory()->create();

    $this->actingAs(adminUser(), 'sanctum')
        ->withSession(['auth.password_confirmed_at' => time()])
        ->patch(route('manage.user.update', $user), ['role' => 'Manager'])
        ->assertRedirect(route('manage.user.index'));

    expect($user->refresh()->hasRole('Manager'))->toBeTrue();
});
