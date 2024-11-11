<?php

namespace Uneca\DisseminationToolkit\Enums;

enum RatingEnum: int
{
    case UNKNOWN = -1;
    case POOR = 1;
    case FAIR = 2;
    case GOOD = 3;
    case VERY_GOOD = 4;
    case Excellent = 5;


    public static function getRatingLabel(RatingEnum|int $rating): string
    {
        return match ($rating) {
            self::POOR,1 => 'Poor',
            self::FAIR,2 => 'Fair',
            self::GOOD,3 => 'Good',
            self::VERY_GOOD,4 => 'Very Good',
            self::Excellent,5 => 'Excellent',
            default => 'Not rated'
        };
    }
    public static function getRatingColor(RatingEnum|int $rating): string
    {
        return match ($rating) {
            self::POOR,1, self::FAIR, 2 => 'bg-red-500 text-white',
            self::GOOD,3 => 'bg-yellow-500 text-white',
            self::VERY_GOOD,4, self::Excellent, 5 => 'bg-green-500 text-white',
            default => 'bg-gray-500 text-white',
        };
    }
    public static function getRatingValues(): array
    {
        return [
            self::POOR,
            self::FAIR,
            self::GOOD,
            self::VERY_GOOD,
            self::Excellent
        ];
    }
    public static function getTotalRating(): int
    {
        return count(self::getRatingValues());
    }
    public static function getRatings(): array
    {
        $ratings = collect();
        $ratingValues = RatingEnum::getRatingValues();
        foreach ($ratingValues as $ratingValue) {
            $ratings->push([
                'label' => RatingEnum::getRatingLabel($ratingValue),
                'value' => $ratingValue->value,
                'color' => RatingEnum::getRatingColor($ratingValue),
                'isSelected' => false,
            ]);
        }
        return $ratings->toArray();
    }
}
