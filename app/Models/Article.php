<?php

namespace App\Models;

use App\Models\Concerns\HasComments;
use App\Models\Concerns\HasLikes;
use App\Services\Markdown\Markdown;
use Carbon\CarbonInterval;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Spatie\Feed\Feedable;
use Spatie\Feed\FeedItem;

class Article extends Model implements Feedable
{
    use HasComments, HasLikes;

    protected $guarded = [];

    protected $casts = [
        'sponsors_only' => 'bool',
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

    public function getTitleAttribute($title)
    {
        if ($this->series && str_contains($title, $this->series->title)) {
            $title = Str::after($title, $this->series->title);
        }

        return Str::after($title, ': ');
    }

    public function series()
    {
        return $this->belongsTo(Series::class);
    }

    public function scopePublished(Builder $query)
    {
        $query->whereNotNull('published_at')->where('published_at', '<=', now());
    }

    public function parsedContent()
    {
        if (! app()->environment('production')) {
            return app(Markdown::class)->parse($this->content);
        }

        return Cache::remember("content_cache_{$this->id}", CarbonInterval::days(7)->totalSeconds, function () {
            return app(Markdown::class)->parse($this->content);
        });
    }

    public function getFeedResults()
    {
        return static::query()->published()->latest('published_at')->get();
    }

    public function toFeedItem()
    {
        return FeedItem::create([
            'id' => $this->id,
            'title' => $this->title,
            'summary' => $this->excerpt,
            'updated' => $this->updated_at,
            'link' => route('articles.show', $this),
            'author' => 'Ryan Chandler',
        ]);
    }
}
