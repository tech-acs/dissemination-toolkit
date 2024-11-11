<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

if (! function_exists('settings')) {
    function settings(?string $key = null, $default = null)
    {
        if (is_null($key)) {
            return app('settings');
        }
        return app('settings')->get($key, $default);
    }
}

if (! function_exists('safeDivide')) {
    function safeDivide($numerator, $denominator, $integerDivision = false)
    {
        if (is_numeric($denominator) && $denominator > 0) {
            return $integerDivision ? intdiv($numerator, $denominator): ($numerator/$denominator);
        }
        return 0;
    }
}

if (! function_exists('toDataFrame')) {
    function toDataFrame(Collection $data): Collection
    {
        $df = collect();
        if ($data->isEmpty()) {
            return $df;
        }
        $firstRow = $data[0];
        $columns = array_keys($firstRow instanceof Model ? $firstRow->toArray() : (array) $firstRow);
        foreach ($columns as $column) {
            $df[$column] = $data->pluck($column)->all();
        }
        return $df;
    }
}

if (! function_exists('toResultSet')) {
    function toResultSet(Collection $df): Collection
    {
        $resultSet = collect();
        $columns = $df->keys();
        for($i = 0; $i < count($df->first()); $i++) {
            $row = [];
            foreach ($columns as $column) {
                $row[$column] = $df[$column][$i];
            }
            $resultSet->push($row);
        }
        return $resultSet;
    }
}
