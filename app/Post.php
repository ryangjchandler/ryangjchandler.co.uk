<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Post extends Model
{
    protected $guarded = [];

    protected $dates = ['published_at'];

    public static function booted()
    {
        static::creating(function (Post $post) {
            if (! $post->slug) {
                $post->slug = Str::slug($post->title);
            }

            if ($post->published && ! $post->published_at) {
                $post->published_at = now();
            }
        });

        static::saving(function (Post $post) {
            if ($post->published && ! $post->published_at) {
                $post->published_at = now();
            }
        });
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }
}
