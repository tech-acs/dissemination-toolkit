<?php

namespace Uneca\DisseminationToolkit\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Spatie\Translatable\HasTranslations;

class Dimension extends Model
{
    use HasTranslations;

    protected $guarded = ['id'];
    public array $translatable = ['name', 'description'];
    protected $casts = ['for' => 'array'];
    protected $appends = ['foreign_key'];

    public function datasets(): BelongsToMany
    {
        return $this->belongsToMany(Dataset::class);
    }

    public function values()
    {
        if ($this->table_exists) {
            return DB::table($this->table_name)->orderBy('rank')->get();
        }
        return false;
    }

    public function getTableExistsAttribute(): bool
    {
        return Schema::hasTable($this->table_name);
    }

    public function getIsCompleteAttribute(): bool
    {
        if ($this->table_exists) {
            return DB::table($this->table_name)->where('code', '_T')->exists();
        }
        return false;
    }

    public function getValuesCountAttribute(): int
    {
        if ($this->table_exists) {
            return DB::table($this->table_name)->count();
        }
        return 0;
    }

    public function getForeignKeyAttribute(): string
    {
        return str($this->name)->lower()->snake()->append('_id')->value();
    }

    public function scopeApplicableTo(Builder $query, string $factTable)
    {
        $query->whereJsonContains('for', $factTable);
    }
}
