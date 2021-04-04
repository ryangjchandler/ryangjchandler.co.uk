---
slug: unconventional-laravel-custom-pipeline-classes
title: 'Unconventional Laravel: Custom Pipeline Classes'
excerpt: 'Laravel makes use of the internal `Pipeline` class and it''s more common in userland too, but have you ever considered tidying up these pipeline processes with custom pipeline classes?'
published_at: 2020-09-15T11:00:00+00:00
---
I'll start off by going over what the `Pipeline` class actually does. In [layman's terms](https://en.wikipedia.org/wiki/Plain_English), this class will take a value and pass it off to a collection of handler classes before being returned.

These handler classes are simple classes that are resolved from the container and only need a single `handle()` or `__invoke()` method.

## An example pipeline

Imagine you have a blog and when you publish a post, you want to run through a series of tasks. Each task has it's own "action", or "handler", class that will receive the post and do something to it.

Here's what your code might look like **without** using pipelines (with some pseudo methods):

```php
<?php
  
$post = Post::current();

$pipes = [
    MakeSurePostHasBeenPublished::class,
    SendTweetAboutNewPost::class,
    SendEmailAboutNewPost::class,
];

foreach ($pipes as $pipe) {
    $post = app($pipe)->handle($post);
}
```

There isn't anything immediately wrong with this code since it's on a small scale. Personally though, I don't like having that temporary variable that is only being used as the iterable for the `foreach` loop and I don't like that the `$post` variable is being re-assigned after each action. It makes for some confusing and messy code, especially as the number of "pipes" grows.

Let's replace this with a `Pipeline` implementation and see how much cleaner it is:

```php
use Illuminate\Pipeline\Pipeline;

$post = app(Pipeline::class)
    ->send(Post::current())
    ->through([
        MakeSurePostHasBeenPublished::class,
        SendTweetAboutNewPost::class,
        SendEmailAboutNewPost::class,
    ])
    ->thenReturn();
```

You can instantly follow the logic of the code, since it uses a fluent method chain with sensible method names. The idea is still the same as before. The current post is being _sent_ through each _pipe_ and _then_ being _returned_ to a `$post` variable.

The `Pipeline` itself is being resolved out of the container through the `app()` helper function since it needs an implementation of `Illuminate\Contracts\Container\Container` to resolve each pipe class.

## Taking it one step further

We've already made an improvement to the code leaving the `foreach` loop behind and moving to an object-oriented approach, but we can take this even further by wrapping this same logic up inside of a custom pipeline class.

Let's start off by creating a new class called `PublishPostPipeline`:

```php
use Illuminate\Pipeline\Pipeline;

class PublishPostPipeline extends Pipeline
{
    //
}
```

When the `Pipeline::through()` method is called, the array argument passed will be assigned to the `$pipes` property on the object. This means that method call can be circumvented and the pipes can be assigned directly to the `protected $pipes` property on the class.

This change also means there is only a single place to add, or remove, a pipe from the pipeline:

```php
use Illuminate\Pipeline\Pipeline;

class PublishPostPipeline extends Pipeline
{
    protected $pipes = [
        MakeSurePostHasBeenPublished::class,
        SendTweetAboutNewPost::class,
        SendEmailAboutNewPost::class,
    ];
}
```

If we refactor our previous code to use this new `PublishPostPipeline` class, it would look something like:

```php
$post = app(PublishPostPipeline::class)
    ->send(Post::current())
    ->thenReturn();
```

The method chain doesn't read very nicely now though, because it sounds like we're just sending the post and returning straight away.

This next part is optional, but I like to add a named constructor and runner method that will accept the `Post` as an argument and do all of this logic for me.


```php
use Illuminate\Pipeline\Pipeline;

class PublishPostPipeline extends Pipeline
{
    protected $pipes = [
        MakeSurePostHasBeenPublished::class,
        SendTweetAboutNewPost::class,
        SendEmailAboutNewPost::class,
    ];

    public static function run(Post $post): Post
    {
        return app(static::class)->send($post)->thenReturn();
    }
}
```

Instead of having all of the logic for sending and returning in our caller method, we can just call `PublishPostPipeline::run()` and use the return value of that method. 

The benefit here is that we can type the `$post` argument and also add a return type of `Post`, allowing the intellisense plugin of your editor to pick up on the variable type and provide better autocomplete / suggestions.

## Sign off

I haven't seen this pattern used too much in the wild but I have used it a lot for making my code more DRY, especially when I use the same pipelines in controllers, queues and commands.

If you want to read up on the `Pipeline` class a little more, [Jeff Ochoa](https://twitter.com/Jeffer_8a) has written a [blog post](https://jeffochoa.me/understanding-laravel-pipelines) that goes over the basics.

The team over at [Zaengle](https://zaengle.com/) have also created a [package](https://github.com/zaengle/pipeline) that has a deeper approach to writing DRY pipelines, along with a few niceties.

I'd love to know what you thought about this blog post on [Twitter](https://twitter.com/ryangjchandler).

Thanks for reading!