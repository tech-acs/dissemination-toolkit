<?php

use Uneca\DisseminationToolkit\DisseminationToolkitServiceProvider;

it('registers the package service provider', function () {
    expect(app()->getProviders(DisseminationToolkitServiceProvider::class))
        ->toHaveCount(1);
});

it('loads the package config', function () {
    expect(config('dissemination.records_per_page'))->not->toBeNull();
});

it('redirects the root path to the landing page', function () {
    $this->get('/')
        ->assertRedirect(route('landing'));
});
