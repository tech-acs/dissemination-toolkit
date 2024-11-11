<?php

namespace Uneca\DisseminationToolkit\Services;

use Uneca\DisseminationToolkit\Models\Dimension;
use Illuminate\Support\Collection;

class Pivoting
{
    public bool $isNested;
    private array $selections = [];
    private string $row;

    public function __construct(int $col, int $row = 0, ?int $nestingCol = null)
    {
        $this->row = $this->make($row, 'row');
        $this->make($col, 'col');
        $this->make($nestingCol, 'nestingCol');
        $this->isNested = collect($this->selections)->contains('type', 'nestingCol');
    }

    private function make(?int $id, string $type): string
    {
        if (is_null($id)) {
            return '';
        } elseif ($id === 0) {
            $this->selections['areas.name'] = [
                'select' => "areas.name->>'" . app()->getLocale() . "'::text AS $type", // AS geography
                'type' => $type,
            ];
            return 'Geography';
        } elseif ($id > 0) {
            $dim = Dimension::find($id);
            $this->selections["{$dim->table_name}.name"] = [
                'select' => "{$dim->table_name}.name::text AS $type", // AS {$dim->table_name}
                'type' => $type,
            ];
            return '"' . $dim->name . '"';
        }
    }

    public function select(): string
    {
        if ($this->isNested) {
            return collect($this->selections)
                ->filter(fn ($item) => $item['type'] === 'row')
                ->map(fn ($item) => $item['select'])
                ->concat([$this->concatenateColumns()])
                ->join(', ');
        } else {
            return collect($this->selections)
                ->map(fn ($item) => $item['select'])
                ->join(', ');
        }
    }

    public function crosstabCategories(Collection $result): string
    {
        return $result->pluck('col')
            ->unique()
            ->map(fn ($category) => '"' . $category . QueryBuilder::VALUE_COLUMN_INVISIBLE_MARKER . '" text')
            ->prepend("{$this->row} text")
            ->join(', ');
    }

    private function concatenateColumns(): string
    {
        $joined = collect($this->selections)
            ->filter(fn ($item) => in_array($item['type'], ['col', 'nestingCol']))
            ->sortByDesc('type')
            ->keys()
            ->join(", '|', ");
        return str($joined)
            ->prepend('concat(')
            ->append(')::text AS col')
            ->toString();
    }
}
