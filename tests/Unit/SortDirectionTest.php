<?php

use Uneca\DisseminationToolkit\Enums\SortDirection;

it('has ascending and descending cases', function () {
    expect(SortDirection::cases())->toHaveCount(2)
        ->and(SortDirection::ASC->value)->toBe('ASC')
        ->and(SortDirection::DESC->value)->toBe('DESC');
});
