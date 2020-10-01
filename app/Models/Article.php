<?php

namespace App\Models;

use App\Models\Concerns\HasComments;
use App\Models\Concerns\HasLikes;
use App\Models\Presenters\ArticlePresenter;
use App\Support\Markdown\Markdown;
use Carbon\CarbonInterval;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Spatie\Feed\Feedable;
use Spatie\Feed\FeedItem;

class Article extends Model implements Feedable
{
    use ArticlePresenter;

    protected $casts = [
        'sponsors_only' => 'bool',
        'show_toc' => 'bool',
    ];

    protected $dates = ['published_at'];

    public static function booted()
    {
        static::creating(function (Article $article) {
            if (! $article->slug) {
                $article->slug = Str::slug($article->title);
            }
        });

        static::saving(function (Article $article) {
            Cache::forget("content_cache_{$article->id}");
        });
    }

    public function series()
    {
        return $this->belongsTo(Series::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function scopePublished(Builder $query)
    {
        $query->whereNotNull('published_at')->where('published_at', '<=', now());
    }

    public function scopeFree(Builder $query)
    {
        $query->where('sponsors_only', 0);
    }

    public function getFeedResults()
    {
        return static::query()->published()->free()->latest('published_at')->get();
    }
}
