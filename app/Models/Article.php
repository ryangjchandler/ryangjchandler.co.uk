<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $dates = ['published_at'];

    public static function booted()
    {
        static::creating(function (Article $article) {
            if (! $article->slug) {
                $article->slug = Str::slug($article->title);
            }
        });
    }

    public function scopePublished(Builder $query)
    {
        $query->whereNotNull('published_at')->where('published_at', '<=', now());
    }
}
