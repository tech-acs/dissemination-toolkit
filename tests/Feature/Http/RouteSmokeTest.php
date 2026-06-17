<?php

it('can resolve the login route', function () {
    expect(route('login'))->toContain('/login');
});
