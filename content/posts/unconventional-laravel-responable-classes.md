---
slug: unconventional-laravel-responable-classes
title: 'Unconventional Laravel: Responsable classes'
excerpt: 'Sometimes your controllers can get rather large, especially if you have lots of conditions and data formatting. Have you ever considered moving some of that complexity out into a dedicated response class?'
published_at: 2020-10-22T16:00:00+00:00
---
In your typical Laravel application, you're probably used to using Laravel's helper methods for returning responses.

Those responses might also vary in type: you might have an HTML response, generated from a Blade view, or a JSON response if the route being hit is an API endpoint.

Here's an example:

```php
class PostController
{
    public function index()
    {
        return view('posts.index', [
            'post' => Post::published()->get(),
        ]);
    }
}
```

We're going to look at how a controller like this can grow within an application, as well as how we can expand on this concept and turn the code above into the code snippet below:

```php
class PostController
{
    public function index()
    {
        $posts = Post::published()->get();
        
        return new PostIndexResponse($posts);
    }
}
```

## The basic idea

### Content negotiation

In some applications, it makes sense to have a single route for both your HTML responses, as well as your API responses.

This technique is known as "content negotiation". You check what sort of request is being made and send a specific type of response back, based on that request type.

Take the example above. If I wanted to return some JSON when the request wants that type of content, I would do the following:

```php
class PostController
{
    public function index(Request $request)
    {
        $posts = Post::published()->get();
        
        if ($request->wantsJson()) {
            return $posts;
        }
        
        return view('posts.index', [
            'post' => $posts,
        ]);
    }
}
```

Thanks to Laravel's `Request::wantsJson()` method, you can easily check whether or not you need to return JSON or HTML in the response.

For small scenarios like this, custom response classes won't benefit you much. There's only 2 different conditions that determine the type of response that needs to be returned.

Let's use a hypothetical `Request::wantsRss()` method now. 

```php
class PostController
{
    public function index(Request $request)
    {
        $posts = Post::published()->get();
        
        if ($request->wantsRss()) {
            return RssFeed::from($posts)->create();
        }
        
        if ($request->wantsJson()) {
            return $posts;
        }
        
        return view('posts.index', [
            'post' => $posts,
        ]);
    }
}
```

As more and more of these different content types get added, the method will get more and more crowded. Let's try and tackle this with custom response classes.

The first step to creating a custom response class is implementing the `Responsable` interface and moving some of our response logic into the `toResponse` method.

```php
class PostIndexResponse implements Responsable
{
    public function toResponse(Request $request)
    {
        if ($request->wantsRss()) {
            return RssFeed::from($posts)->create();
        }
        
        if ($request->wantsJson()) {
            return $posts;
        }
        
        return view('posts.index', [
            'post' => $posts,
        ]);
    }
}
```

First problem is that our `$posts` variable isn't here anymore. Thankfully, we can add a constructor the class and assign it to a property.

```php
class PostIndexResponse implements Responsable
{
    private $posts;
    
    public function __construct($posts)
    {
        $this->posts = $posts;
    }
    
    public function toResponse(Request $request)
    {
        // ...
    }
}
```

If we head back to our controller, we can replace all of those `if` statements with a single instantiation of our new `PostIndexResponse` class.

```php
class PostController
{
    public function index(Request $request)
    {
        $posts = Post::published()->get();
        
        return new PostIndexResponse($posts);
    }
}
```

## Creating a base response class

The logic that we've just abstracted into a separate class is still a bit long and tedious to write out every time.

One way of working around this is by creating an abstract `BaseResponse` class that holds this logic instead.

Here's a super simple version:

```php
abstract class BaseResponse implements Responsable
{
    public function toResponse($request)
    {
        if ($request->wantsJson()) {
            return $this->toJson();
        }
        
        return $this->toHtml();
    }
}
```

The logic is similar to the previous class, but now we're going to use some conventional method naming.

For requests that are expecting a JSON response, the `toJson` method should be used on the child class. By default, it will use the `toHtml` method, so you could return a view from here or an instance of `HtmlString`.

Let's take this new abstract class and apply it to our `PostIndexResponse`.

```php
class PostIndexResponse extends BaseResponse
{
    private $posts;
    
    public function __construct($posts)
    {
        $this->posts = $posts;
    }
    
    public function toRss()
    {
        return RssFeed::from($this->posts)->create();
    }
    
    public function toJson()
    {
        return $this->posts;
    }
    
    public function toHtml()
    {
        return view('posts.index', [
            'posts' => $this->posts,
        ]);
    }
}
```

### Adding some magic

If I wanted to add a new `wantsPng` condition to my `BaseResponse` class, I'd need to go into the `toResponse` method, check for it, add in a new method. This is tedious when you're using lots of different content types, so why don't we add a bit of magic to it.

I'm going to go down the route of assuming there is always a `wants{format}` method on the request object. This is probably going to be the case, especially if you're using the check in other places in your app, you'd probably want to macro it in.

```php
abstract class BaseResponse implements Responsable
{
    protected $accepts = [
        'json', 'rss', 'png', 'jpg',
    ];

    public function toResponse($request)
    {
        foreach ($this->accepts as $accept) {
            $requestMethod = 'wants'.Str::studly($accept);
            $responseMethod = 'to'.Str::studly($accept);
          
            if ($request->{$requestMethod}()) {
                return $this->{$responseMethod}();
            }
        }
      
        return $this->toHtml();
    }
}
```

Now, instead of needing to write the condition yourself, you can simply add a new item to the `$accepts` property, define a `to{format}` method using *StudlyCase* and it should "just work".

## Pros

### Thin controllers

One of the Laravel community's many "best practices" is to always have thin controllers. This just means that your controllers are always lightweight and small, resulting in a lot of logic being moved outside into models and actions, or in this case, custom response classes. 

This best practice also helps with naming things, since each method or class will be appropriately named for what it does. Custom response classes have the same effect.

### Code clarity

If this is a pattern that you adopt and use across your codebase, you'll probably find that finding things becomes a lot easier. The same idea can be found in single action controllers and form requests.

If you know the name of the current route / context, or can describe what you're viewing, as long as your custom response classes are named appropriately, you can do a quick search and find exactly what you're looking for.

## Cons

### Hidden logic

Despite me saying that code clarity is a *pro* for this pattern, you could also be making an early abstraction, meaning your logic and request flow is hidden away under a named object. 

For small projects, that can be problematic, especially if you're not working on them 24/7 and know the structure like the back of your hand.

It can also be problematic for new developers on a project, since it's not conventional. But hey, that's what these posts are all about.

### Maintenance of accepted types

Like I've shown, you can use a bit of magic to make the maintenance of this pattern a bit easier, but if you find yourself adding 100 different content types because you have 100 different contexts, you're probably using the wrong pattern.

With each type you add, you need to remember how it works, what should happen with the response and where that magic is even coming from.

### Unexpected errors

If somebody makes a request to your route asking for an unexpected content type, your code probably won't have any support for it. That means the user is going to get a nasty 500 error and you're going to be sitting there debugging the problem. Even worse, depending on your default response type, you could even leak data because it will always return JSON, or HTML.

Be sure to protect your routes correctly, or tighten up the base response class to return an empty response by default instead.

## Sign off

If you enjoyed this article or have any questions, I'd love to know on [Twitter](https://twitter.com/ryangjchandler). I'd also love to know if you have used this pattern in your own applications.

Thanks for reading!