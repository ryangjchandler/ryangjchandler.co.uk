---
title: 'Unconventional Laravel: Route groups and `$router`'
slug: unconventional-laravel-route-groups-and-router
excerpt: 'When registering grouped routes using `Route::group()`, it''s normal to register those nested routes using the `Route` facade, but have you ever used the `$router` variable?'
published_at: 2020-07-13T16:00:00+00:00
category_slug: laravel
---
I'd estimate that 99% of Laravel applications register their routes using the `Illuminate\Support\Facades\Route` class. It looks a little something like:

```php
use Illuminate\Support\Facades\Route;

Route::get('/projects', 'ProjectsController@index');
```

The official documentation tells you this is the way to register routes and most applications use this method.

## Route groups

A route group is a way of collecting a number of routes and assigning the same properties, or options, to them. For example, you could prefix a group of routes with the same url:

```php
Route::prefix('/projects')->group(function () {
    Route::get('/', 'ProjectsController@index');
    Route::get('/{project}', 'ProjectsController@show');
});
```

This is a super convenient way of reducing the amount of duplication you would get from individually registering routes with that `/projects` prefix.

But did you know that you can drop the use of the `Route` facade inside of the group callback and make use of a `$router` parameter instead?

## The `$router` parameter

The `Closure` that is passed to the `group()` method can actually take an argument. I tend to call it `$router` but you can call it whatever you want. So taking the previous example of a route group, you can do this:

```php
Route::prefix('/projects')->group(function ($router) {
    $router->get('/', 'ProjectsController@index');
    $router->get('/{project}', 'ProjectsController@show');
});
```

If you wanted to type-hint parameter, you should type hint the `Illuminate\Routing\Router` class. The line of code responsible can be [found here](https://github.com/illuminate/routing/blob/1206eeb0456e9760e321c64338b9f0e305263628/Router.php#L421).

## Pros & Cons

To be honest, there aren't really any big pros or cons to this approach. It's more of a "Did you know you _could_ do this?" one.

Some people might think that there is a performance benefit since you're not calling a method on the `Route` facade each time, but after testing this with 100 routes the difference was literally a couple of milliseconds. This would be down to the fact that, under the hood, Laravel caches the underlying instance so that it doesn't need to be resolved from the container each time.

## Sign off

If you've ever seen or used this approach before, I'd love to know on [Twitter](https://twitter.com/ryangjchandler). 

Thanks for reading 👋