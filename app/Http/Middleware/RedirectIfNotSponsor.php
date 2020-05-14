<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RedirectIfNotSponsor
{
    public function handle(Request $request, Closure $next)
    {
        if (
            $request->route('article')->sponsors_only &&
            (! $request->user() ||
            ! $request->user()->sponsor ||
            ! $request->user()->admin)
        ) {
            $sponsorsLink = config('services.github.sponsors_link');

            session()->flash('error', "You must be a <a href=\"{$sponsorsLink}\">GitHub Sponsor</a> to access this content.");

            return redirect()->back();
        }

        return $next($request);
    }
}
