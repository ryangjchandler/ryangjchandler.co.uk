<?php

namespace App;

use Spatie\Feed\Feedable;
use Spatie\Feed\FeedItem;
use Illuminate\Support\Str;
use Mtownsend\ReadTime\ReadTime;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Facades\App\Services\Markdown\Markdown;

class Post extends Model implements Feedable
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

            Cache::forget('all_posts');
        });

        static::saving(function (Post $post) {
            if ($post->published && ! $post->published_at) {
                $post->published_at = now();
            }

            Cache::forget('all_posts');
            Cache::forget("post_content_{$post->id}");
        });
    }

    public function getParsedContentAttribute()
    {
        return Cache::rememberForever("post_content_{$this->id}", function () {
            return Markdown::parse($this->content);
        });
    }

    public function getExcerptAttribute()
    {
        return Markdown::parse(
            Str::limit($this->parsed_content, 250)
        );
    }

    public function getUrlAttribute()
    {
        return route('articles.show', ['post' => $this]);
    }

    public function getReadingTimeAttribute()
    {
        return new ReadTime(strip_tags($this->parsed_content));
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function toFeedItem()
    {
        return FeedItem::create([
            'id' => $this->id,
            'title' => $this->title,
            'summary' => $this->excerpt,
            'updated' => $this->updated_at,
            'link' => $this->url,
            'author' => 'Ryan Chandler',
        ]);
    }

    public static function getFeedItems()
    {
        return static::where('published', true)->get();
    }
}
