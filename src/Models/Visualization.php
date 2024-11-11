<?php

namespace Uneca\DisseminationToolkit\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Spatie\Translatable\HasTranslations;
use Uneca\DisseminationToolkit\Traits\Reviewable;

class Visualization extends Model
{
    use HasTranslations;
    use Reviewable;

    protected $guarded = ['id'];
    public array $translatable = ['title', 'description'];
    protected $casts = [
        'data_params' => 'array',
        'data' => 'array',
        'layout' => 'array',
        'options' => 'array',
    ];

    public function embedCode()
    {
        $route = route('visualization.show', $this->id);
        return "<div style='position: relative; overflow: hidden; width: 100%; padding-top: 56.25%'>
            <iframe style='position: absolute; top: 0; left: 0; bottom: 0; right: 0; width: 100%; height: 100%; border: none;'
                src='{$route}' > </iframe> </div>";
    }

    public function tags(): MorphToMany
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    public function topics(): MorphToMany
    {
        return $this->morphToMany(Topic::class, 'topicable');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected function type(): Attribute
    {
        return Attribute::make(
            get: fn () => class_basename($this->livewire_component),
        );
    }

    public function getIsOwnerAttribute()
    {
        return $this->user()->is(auth()->user());
    }

    public function scopePublished($query)
    {
        return $query->where('published', true);
    }

    protected function permissionName(): Attribute
    {
        return new Attribute(
            get: fn () => str($this->slug)
                ->replace('.', ':')
                ->append(':indicator')
                ->toString(),
        );
    }

    /*public function isFilterable(): Attribute
    {
        return new Attribute(
            get: fn () => $this->options['extra']['filterable'] ?? false,
        );
    }*/

    protected function component(): Attribute
    {
        return new Attribute(
            get: fn () => $this->slug,
        );
    }

    protected static function booted()
    {
        static::created(function ($visualization) {
            $visualization->update([
                'name' => str($visualization->title)
                    ->slug('-')
                    ->append('-' . $visualization->type)
                    ->append('-' . $visualization->id)
            ]);
        });
    }
}
