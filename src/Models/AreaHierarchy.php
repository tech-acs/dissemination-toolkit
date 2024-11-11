<?php

namespace Uneca\DisseminationToolkit\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class AreaHierarchy extends Model
{
    use HasTranslations;

    protected $guarded = ['id'];
    public $translatable = ['name'];
    protected $casts = ['map_zoom_levels' => 'array'];
}
