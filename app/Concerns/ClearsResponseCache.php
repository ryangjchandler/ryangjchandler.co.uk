<?php

namespace App\Concerns;

use Spatie\ResponseCache\Facades\ResponseCache;

trait ClearsResponseCache
{
    public static function bootClearsResponseCache()
    {
        static::created(fn () => ResponseCache::clear());
        static::updated(fn () => ResponseCache::clear());
        static::deleted(fn () => ResponseCache::clear());
    }
}
