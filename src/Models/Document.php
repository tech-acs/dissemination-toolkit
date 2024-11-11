<?php

namespace Uneca\DisseminationToolkit\Models;

use Uneca\DisseminationToolkit\Enums\CensusTableTypeEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Spatie\Translatable\HasTranslations;

/**
 * @method static create(array $only)
 */
class Document extends Model
{
    use HasTranslations;

    protected $guarded = ['id'];
    public $translatable = ['title', 'description'];
    protected $casts = [
        'dataset_type' => CensusTableTypeEnum::class
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function tags(): MorphToMany
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    public function topics(): MorphToMany
    {
        return $this->morphToMany(Topic::class, 'topicable');
    }

    public function scopePublished($query)
    {
        return $query->wherePublished(true);
    }
}
