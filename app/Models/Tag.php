<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Tag extends Model
{
    public static function booted()
    {
        static::creating(function (Tag $tag) {
            if (!$tag->slug) {
                $tag->slug = Str::slug($tag->title);
            };
        });
    }

    public function articles()
    {
        return $this->belongsToMany(Article::class);
    }

    public function url()
    {
        return route('tags.show', $this);
    }
}
