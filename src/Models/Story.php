<?php

namespace Uneca\DisseminationToolkit\Models;

use Uneca\DisseminationToolkit\Traits\Reviewable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Str;
use Spatie\Translatable\HasTranslations;

class Story extends Model
{
    use HasTranslations;
    use Reviewable;

    protected $guarded = ['id'];
    public $translatable = ['title', 'description'];

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

    public function getIsOwnerAttribute()
    {
        return $this->user()->is(auth()->user());
    }

    public function embedCode()
    {
        $route = route('story.show', [$this->id,'embed' => true]);
        return "<div style='position: relative; overflow: hidden; width: 100%; padding-top: 56.25%'>
            <iframe style='position: absolute; top: 0; left: 0; bottom: 0; right: 0; width: 100%; height: 100%; border: none;'
                src='{$route}' > </iframe> </div>";
    }

    protected function permissionName(): Attribute
    {
        return new Attribute(
            get: fn () => str($this->slug)->replace('.', ':')->toString(),
        );
    }

    public function scopePublished($query)
    {
        return $query->wherePublished(true);
    }

    public function scopeFeatured($query)
    {
        return $query->whereFeatured(true);
    }

    /*public function getAverageRatingAttribute(): float
    {
        return round(num: $this->ratings()->avg('value'), precision: 2);
    }

    public function getRatedAttribute(): bool
    {
        return $this->ratings()->where('user_id', auth()->id())->exists();
    }*/

    protected static function booted()
    {
        static::creating(function ($page) {
            $page->slug = Str::slug($page->title);
        });

        /*static::created(function ($page) {
            Permission::create(['guard_name' => 'web', 'name' => $page->permission_name]);
        });
        static::deleted(function ($page) {
            Permission::whereName($page->permission_name)->delete();
        });*/
    }
}
