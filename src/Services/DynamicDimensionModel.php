<?php

namespace Uneca\DisseminationToolkit\Services;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class DynamicDimensionModel
{
    private Builder $builder;
    private ?int $id;

    public function __construct(string $tableName, int $id = null)
    {
        $this->builder = DB::table($tableName);
        $this->id = $id;
    }

    public function find(int $id): object
    {
        return $this->builder->find($id);
    }

    public function findMany(array $ids): object
    {
        return $this->builder->whereIn('id', $ids)->get();
    }

    public function all(): Collection
    {
        return $this->builder->get();
    }

    public function create(array $columns): bool
    {
        return $this->builder->insert($columns);
    }

    public function update(array $columns): bool
    {
        if ($this->id) {
            return $this->builder
                ->where('id', $this->id)
                ->update($columns);
        }
        return false;
    }

    public function delete(): bool
    {
        if ($this->id) {
            return $this->builder->delete($this->id);
        }
        return false;
    }

    public function truncate()
    {
        return $this->builder->truncate();
    }
}
