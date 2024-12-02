<?php

namespace Uneca\DisseminationToolkit\Models;

use Uneca\DisseminationToolkit\Services\DynamicDimensionModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Spatie\Translatable\HasTranslations;

class Dataset extends Model
{
    use HasTranslations;

    protected $guarded = ['id'];
    public array $translatable = ['name', 'description'];

    public function topics(): MorphToMany
    {
        return $this->morphToMany(Topic::class, 'topicable');
    }

    public function dimensions(): BelongsToMany
    {
        return $this->belongsToMany(Dimension::class);
    }

    public function indicators(): BelongsToMany
    {
        return $this->belongsToMany(Indicator::class);
    }

    public function years(): BelongsToMany
    {
        return $this->belongsToMany(Year::class);
    }

    public function scopePublished($query)
    {
        return $query->where('published', true);
    }

    public function observationsCount(): ?int
    {
        try {
            return DB::table($this->fact_table)
                ->where('dataset_id', $this->id)
                ->count();
        } catch (\Exception $exception) {
            return null;
        }
    }

    public function observations(): Collection
    {
        try {
            return DB::table($this->fact_table)
                ->select(['indicator_id', 'area_id', ...$this->dimensions->pluck('foreign_key')->toArray(), 'value'])
                ->where('dataset_id', $this->id)
                ->get();
        } catch (\Exception $exception) {
            return collect();
        }
    }

    public function availableValuesForDimension(Dimension $dimension): Collection
    {
        //$ids = $this->observations()->pluck($dimension->foreign_key)->unique()->all();
        $ids = DB::table($this->fact_table)
            ->selectRaw("DISTINCT $dimension->foreign_key")
            ->where('dataset_id', $this->id)
            ->pluck($dimension->foreign_key)
            ->toArray();
        return (new DynamicDimensionModel($dimension->table_name))->findMany($ids);
    }

    public function info(): array
    {
        $hierarchies = AreaHierarchy::orderBy('index')->pluck('name', 'index')->all();
        $yearDimension = $this->dimensions->filter(fn($dimension) => $dimension->table_name == 'year')->first();
        $availableYears = $this->availableValuesForDimension($yearDimension);
        return [
            'name' => $this->name,
            'description' => $this->description,
            'indicators' => $this->indicators->pluck('name')->join(', ', ', and '),
            'dimensions' => $this->dimensions->pluck('name')->join(', ', ', and '),
            'available_years' => $availableYears->sortBy('name')->pluck('name')->join(', ', ', and '),
            'observations' => $this->observationsCount(),
            'granularity' => $hierarchies[$this->max_area_level],
            'fact_table' => config('dissemination.fact_tables')[$this->fact_table] ?? $this->fact_table,
            'id' => $this->id,
        ];
    }

    public function templateFileColumnHeaders(): array
    {
        return [
            'Area Code',
            ...$this->dimensions->pluck('name')->map(fn ($name) => "$name code")->toArray(),
            ...$this->indicators->pluck('name')->toArray()
        ];
    }
}
