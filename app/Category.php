<?php

namespace App;

use App\Concerns\ClearsResponseCache;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use Facades\App\Services\Markdown\Markdown;

class Category extends Model
{
    use ClearsResponseCache;

    protected $guarded = [];

    public static function booted()
    {
        static::creating(function (Category $category) {
            if (! $category->slug) {
                $category->slug = Str::slug($category->title);
            }

            Cache::forget('all_categories');
        });

        static::saving(function (Category $category) {
            if (! $category->slug) {
                $category->slug = Str::slug($category->title);
            }

            Cache::forget('all_categories');
            Cache::forget("category_content_{$category->id}");
        });
    }

    public function getParsedContentAttribute()
    {
        return Cache::rememberForever("category_content_{$this->id}", function () {
            return Markdown::parse($this->content);
        });
    }

    public function getUrlAttribute()
    {
        return route('categories.show', ['category' => $this]);
    }

    public function posts()
    {
        return $this->belongsToMany(Post::class);
    }
}
