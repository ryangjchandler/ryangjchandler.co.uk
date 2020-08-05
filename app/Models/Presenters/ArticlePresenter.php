<?php

namespace App\Models\Presenters;

use App\Support\Markdown\Markdown;
use Carbon\CarbonInterval;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Spatie\Feed\FeedItem;
use App\Support\Markdown\Markdown;

trait ArticlePresenter
{
    public function formattedTitle(bool $removeSeriesTitle = false)
    {
        $title = $this->title;

        if ($this->series && str_contains($title, $this->series->title) && $removeSeriesTitle) {
            $title = Str::after($title, $this->series->title);
        }

        return Str::after($title, ': ');
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

    public function isPublished()
    {
        return $this->published_at && $this->published_at->isPast();
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
