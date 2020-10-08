<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RedirectIfNotSponsor
{
    public function handle(Request $request, Closure $next)
    {
        if (! $request->route('article')->sponsors_only) {
            return $next($request);
        }

        if (! $request->user()) {
            session(['sponsors_intended_url' => route('articles.show', $request->route('article'))]);

            return redirect()->route('login', [
                'sponsors_only' => true,
            ]);
        }

        $isAdminOrSponsor = $request->user()->admin || $request->user()->sponsor || (int) $request->user()->sponsor->tier_price >= 5;

        if (! $isAdminOrSponsor) {
            return redirect()->route('support');
        }

        return $next($request);
    }
}
