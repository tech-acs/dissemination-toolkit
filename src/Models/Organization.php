<?php

namespace Uneca\DisseminationToolkit\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Organization extends Model
{
    protected $table = 'organization';
    use HasTranslations;

    protected $guarded = ['id'];
    public array $translatable = ['name', 'slogan', 'blurb'];
    protected $casts = [
        'social_media' => 'array'
    ];
}
