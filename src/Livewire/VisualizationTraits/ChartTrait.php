<?php

namespace Uneca\DisseminationToolkit\Livewire\VisualizationTraits;

use App\Service\QueryBuilder;
use Illuminate\Support\Collection;

trait ChartTrait
{
    protected function isPivoted($columns): bool
    {
        return !in_array('result', $columns, true);
    }
    protected function getCollection(): Collection
    {
        return collect($this->data);
    }
    protected function classifyColumnByMarker(): array
    {
         $columns = array_keys(collect($this->data)->first() ?? []);
         $categories = array_filter($columns, function ($column) {
             return $this->isCategory($column);
         });
         $result = array_filter($columns, function ($column) {
             return $this->isResult($column);
         });
         return [$categories,$result];
    }

    protected function isCategory($column): bool
    {
        return !str($column)->endsWith(QueryBuilder::VALUE_COLUMN_INVISIBLE_MARKER);
    }
    protected function isResult($column): bool
    {
        return str($column)->endsWith(QueryBuilder::VALUE_COLUMN_INVISIBLE_MARKER);
    }
    protected static function columnClassifiedByType($data): array
    {
        // Todo: use column type to classify instead of pivot
        $columns = array_keys(collect($data)->first() ?? []);
        if (in_array('result', $columns, true)) {
            $lastColumn = array_pop($columns);
            return [$columns, $lastColumn];
        } else {
            $firstColumn = array_shift($columns);
            return [$columns, $firstColumn];
        }
    }

    protected static function pluckMultipleColumns($collection, $columns): array
    {
        return collect($columns)->map(function ($columnName) use ($collection) {
            return $collection->pluck($columnName)->all();
        })->toArray();
    }
    public function reduceColumnWithMultipleUniqueValues($columns):array{
        $data = $this->getCollection();
        $columnWithMultipleUniqueValues = array_values(array_filter($columns, function ($column) use ($data) {
            return $data->pluck($column)->unique()->count() > 1;
        }));
        return count($columnWithMultipleUniqueValues)<1?$columns:$columnWithMultipleUniqueValues;
   }
    public static function getColumnsWithMultipleUniqueValues(Collection $data): array
    {
        $columns = array_keys($data->first()??[]);
        $lastColumn = array_pop($columns);
        $columnWithMultipleUniqueValues = array_values(array_filter($columns, function ($column) use ($data) {
            return $data->pluck($column)->unique()->count() > 1;
        }));
        return empty($columnWithMultipleUniqueValues)?$columns:[...$columnWithMultipleUniqueValues,$lastColumn];
    }

    protected function isTraceDefinitionEmpty(): bool
    {
        return empty($this->options['meta']);
    }

    protected function tryMakeTraceUsingOptions(): ?array
    {
        $collection = collect($this->data);
        if (!empty($this->options['meta'])) {
            return collect($this->options['meta'])->map(function ($trace) use ($collection) {
                foreach ($trace['meta']['columnNames'] as $traceKey => $column) {
                    $trace[$traceKey] = is_array($column) ? $this->pluckMultipleColumns($collection, $column) : $collection->pluck($column)->all();
                }
                return $trace;
            })->toArray();
        }
        return null;
    }
}
