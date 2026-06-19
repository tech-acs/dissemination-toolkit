<?php

it('redirects guests from manage resource index routes', function (string $route) {
    $this->get(route($route))
        ->assertRedirect(route('login'));
})->with([
    'manage.topic.index',
    'manage.story.index',
    'manage.visualization.index',
    'manage.indicator.index',
    'manage.tag.index',
    'manage.dataset.index',
    'manage.document.index',
    'manage.announcement.index',
    'manage.area.index',
    'manage.area-hierarchy.index',
    'manage.role.index',
]);

it('allows an admin to access manage resource index routes', function (string $route) {
    $this->actingAs(adminUser(), 'sanctum')
        ->get(route($route))
        ->assertOk();
})->with([
    'manage.topic.index',
    'manage.story.index',
    'manage.visualization.index',
    'manage.indicator.index',
    'manage.tag.index',
    'manage.dataset.index',
    'manage.document.index',
    'manage.announcement.index',
    'manage.area.index',
    'manage.area-hierarchy.index',
    'manage.role.index',
]);
