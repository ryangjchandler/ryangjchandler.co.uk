<?php

use App\Models\Ad;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Route;

if (! function_exists('active_classes')) {
    function active_classes(string $route, array $classes)
    {
        if ($route === Route::currentRouteName()) {
            return implode(' ', $classes);
        }
    }
}

if (! function_exists('random_greeting')) {
    function random_greeting()
    {
        return Arr::random([
            'What\'s crackin\'?',
            'Aloha!',
            'What\'s good?',
            'Greetings!',
            'Hello!',
            'Wassup?',
            'Hello, World!',
        ]);
    }
}

if (!function_exists('pre_article_ad')) {
    function pre_article_ad() {
        return Ad::query()
            ->where('type', 'pre-article')
            ->where(function (Builder $query) {
                return $query->whereDate('start_at', '<=', now()->format('Y-m-d'))
                    ->whereDate('end_at', '>=', now()->format('Y-m-d'));
            })
            ->firstOr(function () {
                return false;
            });
    }
}

if (! function_exists('banner_ad')) {
    function banner_ad() {
        return Ad::query()
            ->where('type', 'banner')
            ->where(function (Builder $query) {
                return $query->whereDate('start_at', '<=', now()->format('Y-m-d'))
                    ->whereDate('end_at', '>=', now()->format('Y-m-d'));
            })
            ->firstOr(function () {
                return false;
            });
    }
}
