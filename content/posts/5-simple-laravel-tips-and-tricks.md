---
slug: 5-simple-laravel-tips-and-tricks
title: '5 Simple Laravel Tips and Tricks'
excerpt: 'Here are 5 simple Laravel tips and tricks that you can start applying and using in your Laravel applications right now!'
published_at: 2021-01-17T12:00:00+00:00
---
## 1. Chained `dd` and `dump`

Have you ever written a block of code like this?

```php
$users = User::all();

dd($users);
```

It's not awful, but it is annoying that you _need_ to assign the result of `User::all()` (an instance of `Collection`) to a variable just to dump and die. Turns out, you don't actually _need_ to. Instead, you can use the `dd` or `dump` method on the `Collection` class instead and turn this into a one-liner.

```php
User::all()->dd();
```

## 2. `Auth::id()`

I wrote a tweet about this one a little while ago and it seemed like a lot of people didn't know about it.

> 🔥 I still see so many people retrieving the current user's ID as shown at the top of the image. Take a shortcut and use the `Auth::id()` method instead! <https://t.co/P7eB1PJrt2>
> 
> [![](https://pbs.twimg.com/media/EdnqD4AXoAIcrx3.png?name=thumb)](https://twitter.com/ryangjchandler/status/1286316647385636864/photo/1)
> 
> — Ryan Chandler ([@ryangjchandler](https://twitter.com/ryangjchandler)) [Jul 23, 2020](https://twitter.com/ryangjchandler/status/1286316647385636864)

I think my favourite thing about using this method is that you don't need to worry about accessing the `id` property on a `null` object, you can just use `Auth::id()` and it will return `null` when the user is logged out.

## 3. Default Relationship Models

Laravel provides a handy `withDefault()` method on the `belongsTo` relationship that will return a model object even when the relationship doesn't actually exist.

```php
class Post extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class)->withDefault();
    }
}
```

Now, if we try to access the `$post->user` relationship, we'll still get a `User` object even when it does exist in the database. This is known as the "null object" pattern and helps eliminate some of those `if ($post->user)` conditional statements.

There's a few different things you can do with `withDefault()`, you can read more about it [here in the documentation](https://laravel.com/docs/8.x/eloquent-relationships#default-models).

## 4. Custom Blade Directives

I don't use custom Blade directives all too often, but when I do it definitely makes my views look nicer. One example of a Blade directive that I use across multiple projects is `@nl2br`

```blade
<h3>Notes</h3>

@foreach($notes as $note)
    <p>@nl2br($note->content)</p>
@endforeach
```

Creating your own Blade directive really isn't difficult. Here's what the `@nl2br` one looks like:

```php
Blade::directive('nl2br', function ($expression) {
    return "<?php echo nl2br(e({$expression})) ?>";
});
```

Under the hood, Blade transforms a Blade directive into a PHP string (or expression). In this case, we're writing the PHP code necessary to print out the result of `nl2br`.

The callback function accepts an `$expression` argument. This is what was passed to the directive as arguments. In the example above, that would be `$note->content` as a string.

That confuses people quite a bit, because they expect `$expression` to be the return value of `$note->content`, when in fact is it a literal string with the contents `$note->content`:

```php
$expression = '$note->content';
```

## 5. Better Intellisense

This isn't something related to your code directly, but it can definitely make it faster to write. 

### PhpStorm

If you're one of the PhpStorm crowd, you've probably already got the Laravel extension installed. If you're looking for something a little more powerful, and premium, you should definitely check out [LaravelIdea](https://plugins.jetbrains.com/plugin/13441-laravel-idea).

This extension provides auto-complete for basically everything cool and awesome in Laravel. View names, config names, Blade component tags and more.

### Visual Studio Code

I've been using [Laravel Extra Intellisense](https://marketplace.visualstudio.com/items?itemName=amiralizadeh9480.laravel-extra-intellisense) for a little while now and it has definitely given me a speed boost when it comes to getting the right view, configuration value or route name.

It's free, pretty powerful and feels just like any other intellisense plugin.