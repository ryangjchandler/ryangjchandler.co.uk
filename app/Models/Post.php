<?php

namespace App\Models;

use Illuminate\Support\Str;
use Orbit\Concerns\Orbital;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Spatie\Feed\Feedable;
use Spatie\Feed\FeedItem;

class Post extends Model implements Feedable
{
    use Orbital;

    public $timestamps = false;

    protected $casts = [
        'published_at' => 'datetime',
    ];

    public static function schema(Blueprint $table)
    {
        $table->string('title');
        $table->string('slug');
        $table->text('excerpt')->nullable();
        $table->text('content')->nullable();
        $table->timestamp('published_at')->nullable();
        $table->string('category_slug')->nullable();
    }

    public function getPublishedAttribute()
    {
        return $this->published_at && $this->published_at->isPast();
    }

    public function getExcerptAttribute($excerpt)
    {
        if ($excerpt) {
            return $excerpt;
        }

        return Str::limit($this->content, 100, '');
    }

    public function scopePublished($query)
    {
        return $query
            ->whereNotNull('published_at')
            ->whereDate('published_at', '<=', now())
            ->orderBy('published_at', 'DESC');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function getKeyName()
    {
        return 'slug';
    }

    public function getIncrementing()
    {
        return false;
    }

    public function toFeedItem(): FeedItem
    {
        return FeedItem::create()
            ->id($this->slug)
            ->title($this->title)
            ->summary($this->excerpt)
            ->link(route('posts.show', $this))
            ->updated($this->published_at)
            ->author('Ryan Chandler');
    }

    public static function getFeedResults()
    {
        return static::published()->get();
    }

    public static function booted()
    {
        static::creating(function (Post $post) {
            if (! $post->slug) {
                $post->slug = Str::slug($post->title);
            }
        });

        static::updating(function (Post $post) {
            if (! $post->published) {
                $post->slug = Str::slug($post->title);
            }
        });
    }
}
