<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RedirectIfNotSponsor
{
    public function handle(Request $request, Closure $next)
    {
        if (! $request->user()) {
            return redirect()->route('login');
        }

        $isAdminOrSponsor = $request->user()->admin || $request->user()->sponsor || (int) $request->user()->sponsor->tier_price >= 5;

        if ($request->route('article')->sponsors_only && ! $isAdminOrSponsor) {
            $sponsorsLink = config('services.github.sponsors_link');

            session()->flash('error', "You must be a <a href=\"{$sponsorsLink}\">GitHub Sponsor</a> to access this content.");

            return redirect()->route('support');
        }

        return $next($request);
    }
}
