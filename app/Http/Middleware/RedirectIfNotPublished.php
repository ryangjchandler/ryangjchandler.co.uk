<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;

class RedirectIfNotPublished
{
    public function handle(Request $request, Closure $next)
    {
        if (! $request->route('article')->published_at->isPast() && ! ($request->user() && $request->user()->admin)) {
            return redirect()->route('articles.index');
        }

        return $next($request);
    }
}
