---
slug: add-classes-to-active-link-in-laravel
title: 'Add Classes to Active Link in Laravel'
excerpt: 'Adding a class to make the current page "active" in your application''s navigation is a simple UI improvement. Let me show you how I typically do this in my apps.'
published_at: 2020-06-29T15:00:00+00:00
---
Generally speaking, the easiest way to do this is comparing the name of the current route and the one you'd like to test against.

Luckily, Laravel's `Illuminate\Support\Facades\Route` class provides a nice `currentRouteName()` method that we can use to make a comparison.

Let's create a little function that you can re-use throughout your application.

```php
use Illuminate\Support\Facades\Route;

function active_route(string $name): bool
{
    return Route::currentRouteName() === $name;
}
```

This function is great, but it doesn't do anything with classes. Let's add a second parameter so that a class string such as `'bg-gray-900'` could be passed through.


```php
use Illuminate\Support\Facades\Route;

function active_route(string $name, string $classes): bool
{
    if ($active = Route::currentRouteName() === $name) {
        echo $classes;
    }
  
    return $active;
}
```

Perfect! Now we can pass in the name of a route and a class string and it will `echo` the class if the current route matches the one provided.

If we wanted to, we could also wrap this into a custom Blade directive. In any `ServiceProvider::boot()`, add the following snippet:

```php
Blade::directive('active', function ($expression) {
    return "<?php \active_route({$expression}); ?>"
});
```

Inside of a Blade template, we could now do:

```blade
@active('projects.index', 'bg-gray-900 hover:bg-gray-500')
```

And it would work just the same as calling `active_route()` directly. Nice!

## Going beyond

One way this could be improved is conditionally checking whether or not a second parameter is passed through via the directive. This means you could treat `@active` as an `if` statement and do something based on the true and false conditions.

Let's make the second parameter to `active_route()` optional and add some checks to see how many parameters the directive receives:

```php
use Illuminate\Support\Facades\Route;

function active_route(string $name, string $classes = null): bool
{
    if ($active = Route::currentRouteName() === $name && $classes) {
        echo $classes;
    }
  
    return $active;
}
```

```php
use Illuminate\Support\Facades\Blade;

Blade::directive('active', function ($expression) {
    $parts = explode(',', str_replace(['(', ')'], '', $expression));
  
    if (count($parts) === 1) {
        return "<?php if (active_route({$expression})) : ?>";
    }
  
    return "<?php \active_route({$expression}); ?>"
});
```

It seems a bit confusing at first, but I'll break it down:

1. When our custom directive handler is called, it will receive `$expression` as a string. For example, `@active('projects.index')` will mean expression is `('projects.index')`. The parentheses are included, so we need to remove those from the string before running `explode()`.

2. `explode(',', ...)` will split the string after each `,`. If two arguments are provided, then were should be a comma separating them. You could run into problems here if you use commas in your route names, but I've never seen anybody do that, most people use full-stops. In the case that no commas are present, `$parts` will just be an array with a single item.

3. If there is only 1 "part" (the length of `$parts` is 1), then we can assume that we're in `if else` mode, so we return an `if` statement instead of the string. Luckily, our `active_route()` function already returns a boolean, no matter the number of arguments received.

Now, we can do something like:

```php
@active('projects.index') bg-gray-900 hover:bg-gray-500 @else bg-gray-400 @endif
```

### @endactive vs. @endif

We've only got a single `if` statement, so using `@endif` is perfectly fine. If you wanted to make it a bit prettier, you could just add the following bit of code;

```php
Blade::directive('endactive', function () {
    return '<?php endif; ?>';
});
```