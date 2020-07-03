<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class Commit
{
    public static function latest()
    {
        $commit = Cache::remember('latest_commit', now()->addMinutes(30), function () {
            return collect(
                Http::get('https://api.github.com/repos/ryangjchandler/ryangjchandler.co.uk/commits')->json()
            )->last();
        });

        if ($commit) {
            $commit = ['', ''];
        }

        return [Str::limit($commit['sha'], 7), $commit['commit']['url']];
    }
}
