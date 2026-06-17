<?php

use Uneca\DisseminationToolkit\Enums\CensusTableTypeEnum;

it('returns labels, classes and icons for each type', function () {
    foreach (CensusTableTypeEnum::cases() as $type) {
        expect(CensusTableTypeEnum::getTypeLabel($type))->toBeString();
        expect(CensusTableTypeEnum::getTypeClass($type))->toBeString();
        expect(CensusTableTypeEnum::getTypeIcon($type))->toBeString();
    }
});

it('exposes all available types', function () {
    expect(CensusTableTypeEnum::getTypes())->toBeInstanceOf(\Illuminate\Support\Collection::class)->not->toBeEmpty();
});

it('falls back to unknown label for invalid value', function () {
    expect(CensusTableTypeEnum::getTypeLabel('invalid'))->toBe('Unknown');
});
