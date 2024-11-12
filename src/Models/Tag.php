<?php

namespace Uneca\DisseminationToolkit\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Collection;
use Spatie\Translatable\HasTranslations;

class Tag extends Model
{
    //use HasTranslations;

    protected $guarded = ['id'];
    //public $translatable = ['name'];

    public function visualizations(): MorphToMany
    {
        return $this->morphedByMany(Visualization::class, 'taggable');
    }

    public function stories(): MorphToMany
    {
        return $this->morphedByMany(Story::class, 'taggable');
    }
    public function documents(): MorphToMany
    {
        return $this->morphedByMany(Document::class, 'taggable');
    }

    public static function tagsToJsArray($tags)
    {
        return '[' . $tags->pluck('name')->map(fn ($t) => "'{$t}'")->join(',') . ']';
    }

    public static function prepareForSync(?string $commaizedTags): Collection
    {
        $tagsFromString = empty($commaizedTags) ? [] : explode(',', $commaizedTags);
        $tags = collect();
        foreach ($tagsFromString as $tag) {
            $tags[] = Tag::firstOrCreate(['name' => $tag]);
        }
        return $tags;
    }
}
