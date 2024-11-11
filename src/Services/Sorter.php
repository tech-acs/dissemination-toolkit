<?php

namespace Uneca\DisseminationToolkit\Services;

use Uneca\DisseminationToolkit\Enums\SortingTypeEnum;
use Uneca\DisseminationToolkit\Models\Dimension;
use Illuminate\Support\Collection;

class Sorter
{
    private static function decideSortingType($column): int
    {
        $local = app()->getLocale();
        $sortingTypeFlag = SortingTypeEnum::REGULAR->value;
        if (strtolower($column) !== 'geography') {
            $dimension = Dimension::where("name->$local", rtrim($column, QueryBuilder::VALUE_COLUMN_INVISIBLE_MARKER))->first();
            $sortingTypeFlag = $dimension ? $dimension->sorting_type : SortingTypeEnum::REGULAR->value;
        }
        return $sortingTypeFlag;
    }

    public static function sort(Collection $data): Collection
    {
        $firstColumn = array_key_first($data->first() ?? []);
        $sortingType = self::decideSortingType($firstColumn);
        return $data->sortBy($firstColumn, $sortingType)->values();
    }
}
