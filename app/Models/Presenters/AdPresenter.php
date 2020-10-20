<?php

namespace App\Models\Presenters;

use App\Support\Markdown\Markdown;
use Carbon\CarbonInterval;
use Illuminate\Support\Facades\Cache;

trait AdPresenter
{
    public function parsedContent()
    {
        if (! app()->environment('production')) {
            return app(Markdown::class)->parse($this->content);
        }

        return Cache::remember("ad_content_cache_{$this->id}", CarbonInterval::days(7)->totalSeconds, function () {
            return app(Markdown::class)->parse($this->content);
        });
    }
}
