<?php

it('redirects the root path to the landing page', function () {
    $this->get('/')
        ->assertRedirect('/landing');
});

it('loads the public story listing', function () {
    $this->get(route('story.index'))
        ->assertOk();
});

it('loads the public visualization listing', function () {
    $this->get(route('visualization.index'))
        ->assertOk();
});

it('loads the public document listing', function () {
    $this->get(route('document.index'))
        ->assertOk();
});
