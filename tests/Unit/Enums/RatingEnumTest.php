<?php

use Uneca\DisseminationToolkit\Enums\RatingEnum;

it('provides labels and colors for each rating', function () {
    expect(RatingEnum::getRatingLabel(RatingEnum::POOR))->toBe('Poor')
        ->and(RatingEnum::getRatingColor(RatingEnum::POOR))->toBeString();
});

it('returns all rating values', function () {
    expect(RatingEnum::getRatingValues())->toBeArray()->not->toBeEmpty();
});

it('returns the total number of ratings', function () {
    expect(RatingEnum::getTotalRating())->toBe(5);
});

it('exposes all ratings with metadata', function () {
    $ratings = RatingEnum::getRatings();

    expect($ratings)->toBeArray()->not->toBeEmpty();
    expect($ratings[0])->toHaveKeys(['label', 'value', 'color', 'isSelected']);
});
