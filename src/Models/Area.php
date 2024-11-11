<?php

namespace Uneca\DisseminationToolkit\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Area extends Model
{
    use HasTranslations;

    protected $guarded = ['id'];
    public $translatable = ['name'];

    public function scopeOfLevel(Builder $query, $level)
    {
        return $query->where('level', $level);
    }

    public function parentName(): string
    {
        $parentPath = str($this->path)->beforeLast('.')->value();
        return Area::select('path', 'code', 'name', 'level')
            ->whereRaw("path ~ '{$parentPath}'")
            ->first()
            ->name;
    }
}
