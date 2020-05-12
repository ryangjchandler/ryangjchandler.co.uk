<?php

namespace App\Models;

use Carbon\CarbonInterval;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use App\Services\Markdown\Markdown;

class Comment extends Model
{
    protected $guarded = [];

    public function getContentAttribute(string $content)
    {
        return Cache::remember('comment_content_' . $this->id, CarbonInterval::hours(8)->totalSeconds, function () use ($content) {
            return app(Markdown::class)->parse($content);
        });
    }

    public function getLastInteractionAtAttribute()
    {
        if ($this->updated_at->gt($this->created_at)) {
            return $this->updated_at;
        }

        return $this->created_at;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function commentable()
    {
        return $this->morphTo();
    }
}
