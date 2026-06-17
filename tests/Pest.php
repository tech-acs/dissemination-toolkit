<?php

use Uneca\DisseminationToolkit\Models\User;
use Uneca\DisseminationToolkit\Tests\TestCase;

uses(TestCase::class)->in(__DIR__);

function adminUser(): User
{
    return User::where('email', 'super@example.org')->first();
}
