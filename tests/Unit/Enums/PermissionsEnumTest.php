<?php

use Uneca\DisseminationToolkit\Enums\PermissionsEnum;

it('groups permissions by domain', function () {
    $grouped = PermissionsEnum::grouped();

    expect($grouped)->toHaveKeys([
        'visualization',
        'story',
        'review',
        'topic',
        'indicator',
        'dimension',
        'dataset',
        'document',
    ]);
});

it('returns the requested permission group', function () {
    expect(PermissionsEnum::getGroup('dataset'))
        ->toHaveKey(PermissionsEnum::CREATE_DATASET->value)
        ->toHaveKey(PermissionsEnum::IMPORT_DATASET->value);
});

it('returns an empty array for an unknown group', function () {
    expect(PermissionsEnum::getGroup('unknown'))->toBe([]);
});
