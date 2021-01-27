<?php

namespace App\Models\Cms;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory;

    protected $table = 'cms_posts';

    public static function booted()
    {
        static::creating(function (Post $post): void {
            if (! $post->user_id) {
                $post->user_id = Auth::id();
            }

            if (! $post->slug) {
                $post->slug = Str::slug($post->title);
            }
        });

        static::saving(function (Post $post): void {
            if ($post->status === 'draft') {
                $post->slug = Str::slug($post->title);
            }
        });
    }
}
