<?php

namespace App\Models;

use App\Services\Markdown\Markdown;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Carbon\CarbonPeriod;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

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

        static::saving(function (Article $article) {
            Cache::forget("content_cache_{$article->id}");
        });
    }

    public function scopePublished(Builder $query)
    {
        $query->whereNotNull('published_at')->where('published_at', '<=', now());
    }

    public function content()
    {
        return Cache::remember("content_cache_{$this->id}", CarbonInterval::days(7)->totalSeconds, function () {
            return app(Markdown::class)->parse($this->content);
        });
    }
}
