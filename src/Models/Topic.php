<?php

namespace Uneca\DisseminationToolkit\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Spatie\Translatable\HasTranslations;

class Topic extends Model
{
    use HasTranslations;

    protected $guarded = ['id'];
    public array $translatable = ['name', 'description'];

    public function censusTables(): MorphToMany
    {
        return $this->morphedByMany(Document::class, 'topicable');
    }

    public function datasets(): MorphToMany
    {
        return $this->morphedByMany(Dataset::class, 'topicable');
    }

    public function indicators(): MorphToMany
    {
        return $this->morphedByMany(Indicator::class, 'topicable');
    }

    public function visualizations(): MorphToMany
    {
        return $this->morphedByMany(Visualization::class, 'topicable');
    }

    public function stories(): MorphToMany
    {
        return $this->morphedByMany(Story::class, 'topicable');
    }
}
