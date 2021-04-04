---
title: 'Track Your Users Last Activity in Laravel'
slug: track-your-users-last-activity-in-laravel
excerpt: 'It''s quite common to keep tabs on when an authenticated user last used your web application. The information can be really useful when calculating software adoption, usage frequency and return rate.'
published_at: 2020-04-23T23:00:00+00:00
category_slug: laravel
---
Although there's many ways to do this in Laravel, the simplest way is with a piece of `web` middleware.

## The setup

When an authenticated user visits a route in our application, we want to store the timestamp in the database for use later on. Let's store it in a column called `last_active_at`.

All you need to do is create a migration:

```bash
php artisan make:migration add_last_active_at_to_users_table --table=users
```

And add the following line in the `up()` method:

```php
$table->timestamp('last_active_at')->nullable();
```

If the user has never visited a route, it will remain `NULL` in the database.

We also want to make sure this field is "fillable", so add `last_active_at` to the `protected $fillable` array on your `User` model.

As well as being able to update `last_active_at` using `User::update()`, we want to cast it to a `Carbon\Carbon` instance when using it so that we can make use of time comparison methods.

## The middleware

### Logic

The middleware will be responsible for checking the authentication status and updating the `last_active_at` column.

```php
namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Closure;

class TrackLastActiveAt
{
    public function handle(Request $request, Closure $next)
    {
        if (! $request->user()) {
            return $next($request);
        }

        if (! $request->user()->last_active_at || $request->user()->last_active_at->isPast()) {
            $request->user()->update([
                'last_active_at' => now(),
            ]);
        }

        return $next($request);
    }
}
```

Here's what happens in order:

1. We check the current user is authenticated. If they're not, we're returning early so that the rest of the middleware has no effect.
2. If the current user `last_active_at` date & time is `NULL` or is in the past, we want to update it using the current date and time. Thankfully, Laravel has a `now()` helper function that returns an instance of `Carbon\Carbon` for the current date and time.
3. Forward the current request on to the next middleware.

### Registration

We have a couple of different options for registering the middleware. If you want to track your users activity across **all** routes, it should be registered under the `web` array in `App\Http\Kernel`:

```php
protected $middlewareGroups = [
    'web' => [
        // ...
        \App\Http\Middleware\TrackLastActiveAt::class,
    ]
]
```

If you only want to track the latest activity for particular routes, you can register the middleware as part of your route registration:

```php
Route::get('/foo', 'FooController')->middleware([\App\Http\Middleware\TrackLastActiveAt::class]);
```