---
slug: unconventional-laravel-middleware-as-a-service-provider
title: 'Unconventional Laravel: Middleware-as-a-Service-Provider'
excerpt: 'Have you ever used a service provider to set a default value for a third-party library? Have you ever done this based on the current request or URL? Have you ever considered doing this inside of middleware instead?'
published_at: 2020-09-29T16:00:00+00:00
---
Service providers are the backbone of Laravel's powerful [service container](https://laravel.com/docs/8.x/container). They can be used to bind new services to the container, call setup methods on third party libraries and interact with first-party / core services (generally through [facades](https://laravel.com/docs/8.x/facades)).

The problem with these classes is that they're global and generally registered and bootstrapped for **every request**. This means that if you want to do something based on the current request, your service provider needs to have some knowledge of the current request context.

Take the following example:

```php
class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if (! request()->is('admin/*')) {
            User::addGlobalScope('forTenant', new ForTenantScope);
        }
    }
}
```

In this example a [global scope](https://laravel.com/docs/8.x/eloquent#global-scopes) is being applied to the `User` model, but **only** for routes / URLs that don't match the pattern `admin/*`.

On a small scale this is _probably_ fine, but as your application grows and you find yourself adding more code inside of this `if` statement, things can get out of hand quickly and become a maintenance nightmare.

## The middleware approach

Since this code is **only** going to be run for a specific group / set of routes, it can be moved to a piece of middleware and added to the stack for that group of routes. 

```php
class BootstrapWebRoutes
{
    public function handle(Request $request, Closure $next)
    {
        User::addGlobalScope('forTenant', new ForTenantScope);
    }
}
```

This code is doing the same thing as before, but we can now add this middleware to the non `admin/*` routes and remove the request logic and knowledge from our service provider.

```php
Route::as('web.')
    ->middleware(BootstrapWebRoutes::class)
    ->group(function () {
        Route::get('users', [UserController::class, 'index'])->name('users.index');
    });
```

Our global boot process now doesn't need to know about the current request context and we can guarantee that this scope is only going to be applied when visiting a route inside of this group (unless the middleware is applied elsewhere, obviously).

## Pros

### Thinner service providers

The benefit with this approach is that our service providers will actually be slimmer and hopefully only contain things related to actual services.

Of course, global scopes aren't the best example, but as you use more third-party libraries that have configuration values dependent on the current request context (menu builders, breadcrumbs, authorisation), you'll be thankful that it's all contained in middleware classes that are easier to find and compose.

### Potentially faster bootups

On a small scale, framework bootstrapping times won't necessarily be faster since the logic that has been moved isn't heavy.

If you were doing multiple bits of string manipulation, or lots of `preg_*` calls, then moving this out of the global application process _might_ bring a performance improvement since it's only going to be done when it **needs** to be done.

### Modularity

When building applications that use a modular structure, where each component of your application is grouped up into a smaller, Laravel-esque structure, this approach could definitely be of use.

You won't need to step out of the module's context into a global service provider to run logic, or even worse, conditionally register a service provider. You can move all of that logic into a middleware class inside of the current module and register it for a group of routes as shown above.

## Cons

### Abstract thinking

This concept isn't something that a lot of people will think to do when building there applications, because in a lot of cases libraries will directly tell you to add code inside of a `ServiceProvider` class. This is even the case with Laravel's own first-party packages.

Due to this, future you might find it difficult to find logic or configuration without sifting through project-wide search results.

### Late running

Route middleware is executed after global middleware and any service registration (inside `ServiceProvider::register()`) so using this approach might not work for _all_ scenarios.

Make sure that if you register any services from inside of this bootstrap middleware that it runs in the correct order, especially if another piece of middleware relies on one of those services.

Also be careful when working with third-party libraries as they could be hooked into those early stages of the framework startup, meaning none of your code inside of the middleware has been evaluated at the right time.

## Sign off

As always, be careful when adopting patterns like this (especially prematurely). On small projects with one or two developers, this pattern might not be a beneficial one to use since you're going to know where things are 99% of the time and it will probably cause more damage than good.

I've seen this patterns used in a couple of different scenarios, mostly when working with `carbon/carbon` and different default formats are used depending on the context, or the base element for breadcrumbs is different based on the request URL.

If you enjoyed this article, I'd love to know on [Twitter](https://twitter.com). If you've ever used this pattern, let me know too!

Thanks for reading!